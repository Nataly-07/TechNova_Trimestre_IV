<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MensajeEmpleado;
use App\Models\User;

class MensajeAdministradorController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        
        // Obtener todos los mensajes donde el admin es remitente o destinatario
        $mensajes = MensajeEmpleado::where(function($query) use ($admin) {
            $query->where('remitente_id', $admin->id)
                  ->orWhere('empleado_id', $admin->id);
        })
        ->with(['empleado', 'remitente'])
        ->orderBy('created_at', 'desc')
        ->get();
        
        // Estadísticas - Solo mensajes donde el admin es destinatario para leídos/no leídos
        $totalMensajes = $mensajes->count();
        $mensajesNoLeidos = $mensajes->where('empleado_id', $admin->id)->where('leido', false)->count();
        $mensajesLeidos = $mensajes->where('empleado_id', $admin->id)->where('leido', true)->count();
        $mensajesEnviados = $mensajes->where('remitente_id', $admin->id)->count();
        $mensajesRecibidos = $mensajes->where('empleado_id', $admin->id)->count();
        
        // Obtener empleados para el formulario de nuevo mensaje
        $empleados = User::where('role', 'empleado')->get();
        
        return view('frontend.mensajes-administrador', compact('mensajes', 'totalMensajes', 'mensajesNoLeidos', 'mensajesLeidos', 'mensajesEnviados', 'mensajesRecibidos', 'empleados'));
    }

    public function show($id)
    {
        $admin = Auth::user();
        
        $mensaje = MensajeEmpleado::where('id', $id)
            ->where(function($query) use ($admin) {
                $query->where('remitente_id', $admin->id)
                      ->orWhere('empleado_id', $admin->id);
            })
            ->with(['empleado', 'remitente'])
            ->firstOrFail();
        
        // Marcar como leído si no lo está y el admin es el destinatario
        if (!$mensaje->leido && $mensaje->empleado_id == $admin->id) {
            $mensaje->marcarComoLeido();
        }
        
        return response()->json($mensaje);
    }

    public function marcarComoLeido($id)
    {
        try {
            $admin = Auth::user();
            
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }
            
            $mensaje = MensajeEmpleado::where('id', $id)
                ->where(function($query) use ($admin) {
                    $query->where('remitente_id', $admin->id)
                          ->orWhere('empleado_id', $admin->id);
                })
                ->firstOrFail();
            
            // Solo marcar como leído si el admin es el destinatario
            if ($mensaje->empleado_id == $admin->id) {
                $mensaje->marcarComoLeido();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Mensaje marcado como leído'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes marcar este mensaje como leído'
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar el mensaje: ' . $e->getMessage()
            ], 500);
        }
    }

    public function marcarTodosComoLeidos()
    {
        $admin = Auth::user();
        
        MensajeEmpleado::where('empleado_id', $admin->id)
            ->where('leido', false)
            ->update([
                'leido' => true,
                'fecha_leido' => now()
            ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Todos los mensajes han sido marcados como leídos'
        ]);
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:users,id',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string|max:1000',
            'prioridad' => 'required|in:baja,normal,alta'
        ]);

        $admin = Auth::user();
        
        // Verificar que el destinatario sea un empleado
        $empleado = User::where('id', $request->empleado_id)
            ->where('role', 'empleado')
            ->firstOrFail();

        // Crear mensaje
        $mensaje = MensajeEmpleado::create([
            'empleado_id' => $empleado->id,
            'remitente_id' => $admin->id,
            'tipo_remitente' => 'admin',
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'tipo' => 'general',
            'prioridad' => $request->prioridad,
            'leido' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado correctamente',
            'mensaje' => $mensaje->load('empleado')
        ]);
    }

    public function responder(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|string|max:1000'
        ]);

        $admin = Auth::user();
        
        $mensajeOriginal = MensajeEmpleado::where('id', $id)
            ->where(function($query) use ($admin) {
                $query->where('remitente_id', $admin->id)
                      ->orWhere('empleado_id', $admin->id);
            })
            ->firstOrFail();

        // Determinar el destinatario de la respuesta
        $destinatarioId = $mensajeOriginal->remitente_id == $admin->id 
            ? $mensajeOriginal->empleado_id 
            : $mensajeOriginal->remitente_id;

        // Crear mensaje de respuesta
        $respuesta = MensajeEmpleado::create([
            'empleado_id' => $destinatarioId,
            'remitente_id' => $admin->id,
            'tipo_remitente' => 'admin',
            'asunto' => 'Re: ' . $mensajeOriginal->asunto,
            'mensaje' => $request->respuesta,
            'tipo' => 'respuesta',
            'prioridad' => 'normal',
            'leido' => false,
            'data_adicional' => [
                'mensaje_original_id' => $id,
                'conversacion_id' => $mensajeOriginal->data_adicional['conversacion_id'] ?? $id
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Respuesta enviada correctamente',
            'respuesta' => $respuesta->load('empleado')
        ]);
    }

    public function filtrar(Request $request)
    {
        try {
            $admin = Auth::user();
            
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }
            
            $filtro = $request->get('filtro', 'todos');
        
        $query = MensajeEmpleado::where(function($query) use ($admin) {
            $query->where('remitente_id', $admin->id)
                  ->orWhere('empleado_id', $admin->id);
        })
        ->with(['empleado', 'remitente'])
        ->orderBy('created_at', 'desc');

        switch ($filtro) {
            case 'no_leidos':
                // Solo mensajes no leídos donde el admin es destinatario
                $query->where('empleado_id', $admin->id)->where('leido', false);
                break;
            case 'leidos':
                // Solo mensajes leídos donde el admin es destinatario
                $query->where('empleado_id', $admin->id)->where('leido', true);
                break;
            case 'enviados':
                // Solo mensajes enviados por el admin
                $query->where('remitente_id', $admin->id);
                break;
            case 'recibidos':
                // Solo mensajes recibidos por el admin
                $query->where('empleado_id', $admin->id);
                break;
            case 'empleado':
                $empleadoId = $request->get('empleado_id');
                if ($empleadoId) {
                    $query->where(function($q) use ($empleadoId, $admin) {
                        $q->where(function($subQ) use ($empleadoId, $admin) {
                            $subQ->where('remitente_id', $admin->id)
                                 ->where('empleado_id', $empleadoId);
                        })->orWhere(function($subQ) use ($empleadoId, $admin) {
                            $subQ->where('remitente_id', $empleadoId)
                                 ->where('empleado_id', $admin->id);
                        });
                    });
                }
                break;
            case 'todos':
            default:
                // Sin filtro adicional - mostrar todos los mensajes
                break;
        }

        $mensajes = $query->get();
        
        // Estadísticas - Siempre calcular desde la base de datos completa
        $totalMensajes = MensajeEmpleado::where(function($query) use ($admin) {
            $query->where('remitente_id', $admin->id)
                  ->orWhere('empleado_id', $admin->id);
        })->count();
        
        $mensajesNoLeidos = MensajeEmpleado::where('empleado_id', $admin->id)
            ->where('leido', false)->count();
            
        $mensajesLeidos = MensajeEmpleado::where('empleado_id', $admin->id)
            ->where('leido', true)->count();
            
        $mensajesEnviados = MensajeEmpleado::where('remitente_id', $admin->id)->count();
        $mensajesRecibidos = MensajeEmpleado::where('empleado_id', $admin->id)->count();

            return response()->json([
                'success' => true,
                'mensajes' => $mensajes,
                'estadisticas' => [
                    'total' => $totalMensajes,
                    'no_leidos' => $mensajesNoLeidos,
                    'leidos' => $mensajesLeidos,
                    'enviados' => $mensajesEnviados,
                    'recibidos' => $mensajesRecibidos
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al filtrar mensajes: ' . $e->getMessage()
            ], 500);
        }
    }

    public function conversacionesEmpleados()
    {
        try {
            $admin = Auth::user();
            
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }
            
            // Obtener empleados que han tenido conversaciones con el admin
            $empleados = User::where('role', 'empleado')
                ->whereHas('mensajesRecibidos', function($query) use ($admin) {
                    $query->where('remitente_id', $admin->id);
                })
                ->orWhereHas('mensajesEnviados', function($query) use ($admin) {
                    $query->where('empleado_id', $admin->id);
                })
                ->withCount([
                    'mensajesRecibidos as total_mensajes' => function($query) use ($admin) {
                        $query->where('remitente_id', $admin->id);
                    },
                    'mensajesRecibidos as mensajes_no_leidos' => function($query) use ($admin) {
                        $query->where('remitente_id', $admin->id)->where('leido', false);
                    }
                ])
                ->with(['mensajesRecibidos' => function($query) use ($admin) {
                    $query->where('remitente_id', $admin->id)
                          ->orderBy('created_at', 'desc')
                          ->limit(1);
                }])
                ->get()
                ->map(function($empleado) {
                    $ultimoMensaje = $empleado->mensajesRecibidos->first();
                    return [
                        'id' => $empleado->id,
                        'name' => $empleado->name,
                        'email' => $empleado->email,
                        'total_mensajes' => $empleado->total_mensajes,
                        'mensajes_no_leidos' => $empleado->mensajes_no_leidos,
                        'ultimo_mensaje' => $ultimoMensaje ? [
                            'asunto' => $ultimoMensaje->asunto,
                            'fecha' => $ultimoMensaje->created_at->diffForHumans()
                        ] : null
                    ];
                });
            
            return response()->json([
                'success' => true,
                'empleados' => $empleados
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener conversaciones: ' . $e->getMessage()
            ], 500);
        }
    }
}
