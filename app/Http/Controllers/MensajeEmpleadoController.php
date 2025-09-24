<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MensajeEmpleado;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MensajeEmpleadoController extends Controller
{
    public function index()
    {
        $empleado = Auth::user();
        
        $mensajes = MensajeEmpleado::where('empleado_id', $empleado->id)
            ->with('remitente')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Estadísticas
        $totalMensajes = $mensajes->count();
        $mensajesNoLeidos = $mensajes->where('leido', false)->count();
        $mensajesLeidos = $mensajes->where('leido', true)->count();
        
        return view('frontend.mensajes-empleado', compact('mensajes', 'totalMensajes', 'mensajesNoLeidos', 'mensajesLeidos'));
    }

    public function show($id)
    {
        $empleado = Auth::user();
        
        $mensaje = MensajeEmpleado::where('id', $id)
            ->where('empleado_id', $empleado->id)
            ->with('remitente')
            ->firstOrFail();
        
        // Marcar como leído si no lo está
        if (!$mensaje->leido) {
            $mensaje->marcarComoLeido();
        }
        
        return response()->json($mensaje);
    }

    public function marcarComoLeido($id)
    {
        $empleado = Auth::user();
        
        $mensaje = MensajeEmpleado::where('id', $id)
            ->where('empleado_id', $empleado->id)
            ->firstOrFail();
        
        $mensaje->marcarComoLeido();
        
        return response()->json([
            'success' => true,
            'message' => 'Mensaje marcado como leído'
        ]);
    }

    public function marcarTodosComoLeidos()
    {
        $empleado = Auth::user();
        
        MensajeEmpleado::where('empleado_id', $empleado->id)
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

    public function responder(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|string|max:1000'
        ]);

        $empleado = Auth::user();
        
        $mensajeOriginal = MensajeEmpleado::where('id', $id)
            ->where('empleado_id', $empleado->id)
            ->firstOrFail();

        // Crear mensaje de respuesta
        $respuesta = MensajeEmpleado::create([
            'empleado_id' => $mensajeOriginal->remitente_id, // El remitente original recibe la respuesta
            'remitente_id' => $empleado->id,
            'tipo_remitente' => 'empleado',
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
            'respuesta' => $respuesta
        ]);
    }

    public function filtrar(Request $request)
    {
        $empleado = Auth::user();
        $filtro = $request->get('filtro', 'todos');
        
        $query = MensajeEmpleado::where('empleado_id', $empleado->id)
            ->with('remitente')
            ->orderBy('created_at', 'desc');

        switch ($filtro) {
            case 'no_leidos':
                $query->where('leido', false);
                break;
            case 'leidos':
                $query->where('leido', true);
                break;
            case 'todos':
            default:
                // Sin filtro adicional
                break;
        }

        $mensajes = $query->get();
        
        // Estadísticas
        $totalMensajes = MensajeEmpleado::where('empleado_id', $empleado->id)->count();
        $mensajesNoLeidos = MensajeEmpleado::where('empleado_id', $empleado->id)->where('leido', false)->count();
        $mensajesLeidos = MensajeEmpleado::where('empleado_id', $empleado->id)->where('leido', true)->count();

        return response()->json([
            'success' => true,
            'mensajes' => $mensajes,
            'estadisticas' => [
                'total' => $totalMensajes,
                'no_leidos' => $mensajesNoLeidos,
                'leidos' => $mensajesLeidos
            ]
        ]);
    }
}
