<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtencionCliente;
use App\Models\MensajeDirecto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AtencionClienteEmpleadoController extends Controller
{
    public function index()
    {
        // Obtener todas las consultas de clientes
        $consultas = AtencionCliente::with('usuario')
            ->orderBy('Fecha_Consulta', 'desc')
            ->get();
            
        // Obtener conversaciones únicas con el último mensaje de cada una
        $conversaciones = MensajeDirecto::select('conversation_id')
            ->distinct()
            ->get()
            ->map(function($conv) {
                // Obtener el último mensaje de esta conversación
                $ultimoMensaje = MensajeDirecto::where('conversation_id', $conv->conversation_id)
                    ->with(['sender', 'recipient', 'usuario'])
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                return $ultimoMensaje;
            })
            ->filter() // Remover conversaciones vacías
            ->sortByDesc('created_at'); // Ordenar por fecha del último mensaje
            
        // Estadísticas generales
        $estadisticas = [
            'total_consultas' => $consultas->count(),
            'consultas_pendientes' => $consultas->where('Estado', 'abierto')->count(),
            'consultas_en_proceso' => $consultas->where('Estado', 'en_proceso')->count(),
            'consultas_resueltas' => $consultas->where('Estado', 'resuelto')->count(),
            'total_mensajes' => $conversaciones->count(),
            'mensajes_no_leidos' => $conversaciones->where('estado', 'enviado')->count(),
        ];
        
        return view('frontend.atencion-cliente-empleado', compact('consultas', 'conversaciones', 'estadisticas'));
    }
    
    public function showConsulta($id)
    {
        $consulta = AtencionCliente::with('usuario')->findOrFail($id);
        
        return response()->json([
            'consulta' => $consulta,
            'usuario' => $consulta->usuario
        ]);
    }
    
    public function responderConsulta(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|string|max:2000',
            'estado' => 'required|in:abierto,en_proceso,resuelto,cerrado'
        ]);
        
        $consulta = AtencionCliente::findOrFail($id);
        
        $consulta->update([
            'Respuesta' => $request->respuesta,
            'Estado' => $request->estado,
            'ID_Empleado_Respuesta' => Auth::id(),
            'Fecha_Respuesta' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Consulta actualizada correctamente'
        ]);
    }
    
    public function actualizarEstadoConsulta(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:abierto,en_proceso,resuelto,cerrado'
        ]);
        
        $consulta = AtencionCliente::findOrFail($id);
        
        $consulta->update([
            'Estado' => $request->estado,
            'ID_Empleado_Respuesta' => Auth::id()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    }
    
    public function showMensaje($id)
    {
        $mensaje = MensajeDirecto::with('usuario')->findOrFail($id);
        
        // Marcar como leído si no lo está
        if ($mensaje->estado === 'enviado') {
            $mensaje->update(['estado' => 'leido']);
        }
        
        return response()->json([
            'mensaje' => $mensaje,
            'usuario' => $mensaje->usuario
        ]);
    }
    
    public function responderMensaje(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|string|max:2000'
        ]);
        
        $mensaje = MensajeDirecto::findOrFail($id);
        
        $mensaje->update([
            'respuesta' => $request->respuesta,
            'estado' => 'respondido',
            'empleado_id' => Auth::id(),
            'fecha_respuesta' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Mensaje respondido correctamente'
        ]);
    }
    
    public function filtrarConsultas(Request $request)
    {
        $filtro = $request->get('filtro', 'todas');
        
        $query = AtencionCliente::with('usuario');
        
        switch ($filtro) {
            case 'pendientes':
                $query->where('Estado', 'abierto');
                break;
            case 'en_proceso':
                $query->where('Estado', 'en_proceso');
                break;
            case 'resueltas':
                $query->where('Estado', 'resuelto');
                break;
            case 'cerradas':
                $query->where('Estado', 'cerrado');
                break;
        }
        
        $consultas = $query->orderBy('Fecha_Consulta', 'desc')->get();
        
        return response()->json([
            'consultas' => $consultas,
            'estadisticas' => [
                'total' => $consultas->count(),
                'pendientes' => $consultas->where('Estado', 'abierto')->count(),
                'en_proceso' => $consultas->where('Estado', 'en_proceso')->count(),
                'resueltas' => $consultas->where('Estado', 'resuelto')->count(),
                'cerradas' => $consultas->where('Estado', 'cerrado')->count(),
            ]
        ]);
    }
    
    public function filtrarMensajes(Request $request)
    {
        $filtro = $request->get('filtro', 'todos');
        
        $query = MensajeDirecto::with('usuario');
        
        switch ($filtro) {
            case 'no_leidos':
                $query->where('estado', 'enviado');
                break;
            case 'leidos':
                $query->where('estado', 'leido');
                break;
            case 'respondidos':
                $query->where('estado', 'respondido');
                break;
        }
        
        $mensajes = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'mensajes' => $mensajes,
            'estadisticas' => [
                'total' => $mensajes->count(),
                'no_leidos' => $mensajes->where('estado', 'enviado')->count(),
                'leidos' => $mensajes->where('estado', 'leido')->count(),
                'respondidos' => $mensajes->where('estado', 'respondido')->count(),
            ]
        ]);
    }

    public function getConversation($conversationId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $conversation = MensajeDirecto::where('conversation_id', $conversationId)
            ->with(['sender', 'recipient'])
            ->orderBy('created_at')
            ->get();

        if ($conversation->isEmpty()) {
            return response()->json(['error' => 'Conversación no encontrada'], 404);
        }

        return response()->json($conversation);
    }

    public function replyToMessage(Request $request, $id)
    {
        $request->validate([
            'mensaje' => 'required|string|max:2000'
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $parentMessage = MensajeDirecto::findOrFail($id);
        
        $reply = $parentMessage->reply([
            'user_id' => Auth::id(),
            'asunto' => 'Re: ' . $parentMessage->asunto,
            'mensaje' => $request->mensaje,
            'prioridad' => $parentMessage->prioridad,
            'estado' => 'respondido'
        ], 'empleado', Auth::id(), $parentMessage->user_id);

        return response()->json([
            'success' => true,
            'message' => 'Respuesta enviada correctamente',
            'reply' => $reply->load(['sender', 'recipient'])
        ]);
    }
}
