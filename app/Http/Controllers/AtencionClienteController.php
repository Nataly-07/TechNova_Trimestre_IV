<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtencionCliente;
use App\Models\MensajeDirecto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AtencionClienteController extends Controller
{
    public function index()
    {
        $consultas = [];
        $conversaciones = [];
        
        if (Auth::check()) {
            $consultas = AtencionCliente::where('ID_Usuario', Auth::id())
                ->orderBy('Fecha_Consulta', 'desc')
                ->get();
                
            // Obtener conversaciones únicas con el último mensaje de cada una
            $conversaciones = MensajeDirecto::where('user_id', Auth::id())
                ->select('conversation_id')
                ->distinct()
                ->get()
                ->map(function($conv) {
                    // Obtener el último mensaje de esta conversación
                    $ultimoMensaje = MensajeDirecto::where('conversation_id', $conv->conversation_id)
                        ->with(['sender', 'recipient'])
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    return $ultimoMensaje;
                })
                ->filter() // Remover conversaciones vacías
                ->sortByDesc('created_at'); // Ordenar por fecha del último mensaje
        }
        
        return view('frontend.atencion-cliente', compact('consultas', 'conversaciones'));
    }
    
    public function indexPublico()
    {
        // Versión pública sin consultas del usuario
        $consultas = collect();
        
        return view('frontend.atencion-cliente', compact('consultas'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'tema' => 'required|string|max:150',
            'descripcion' => 'required|string|max:1000'
        ]);
        
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Debes estar autenticado para enviar consultas.');
        }
        
        AtencionCliente::create([
            'ID_Usuario' => Auth::id(),
            'Fecha_Consulta' => now(),
            'Tema' => $request->tema,
            'Descripcion' => $request->descripcion,
            'Estado' => 'abierto'
        ]);
        
        return redirect()->back()->with('success', 'Tu consulta ha sido enviada. Te responderemos pronto.');
    }
    
    public function responder(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|string|max:1000'
        ]);
        
        $consulta = AtencionCliente::findOrFail($id);
        $consulta->update([
            'Respuesta' => $request->respuesta,
            'Estado' => 'respondido'
        ]);
        
        return redirect()->back()->with('success', 'Respuesta enviada correctamente.');
    }
    
    public function storeMensaje(Request $request)
    {
        $request->validate([
            'asunto' => 'required|string|max:200',
            'mensaje' => 'required|string|max:2000',
            'prioridad' => 'required|in:baja,normal,alta,urgente'
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Debes estar autenticado para enviar mensajes.'], 401);
        }

        $mensaje = MensajeDirecto::createConversation([
            'user_id' => Auth::id(),
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'prioridad' => $request->prioridad,
            'estado' => 'enviado'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado correctamente',
            'conversation_id' => $mensaje->conversation_id
        ]);
    }

    public function showMensaje($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }
        
        try {
            $mensaje = MensajeDirecto::where('id', $id)
                ->where('user_id', Auth::id())
                ->with(['sender', 'recipient', 'replies.sender', 'replies.recipient'])
                ->first();
            
            if (!$mensaje) {
                return response()->json(['error' => 'Mensaje no encontrado'], 404);
            }
            
            return response()->json($mensaje);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
        }
    }

    public function getConversation($conversationId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $conversation = MensajeDirecto::where('conversation_id', $conversationId)
            ->where(function($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('recipient_id', Auth::id());
            })
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
        
        // Determinar el tipo de remitente y destinatario
        $senderType = Auth::user()->role === 'empleado' ? 'empleado' : 'cliente';
        $recipientId = Auth::user()->role === 'empleado' ? $parentMessage->user_id : null;

        $reply = $parentMessage->reply([
            'user_id' => Auth::id(),
            'asunto' => 'Re: ' . $parentMessage->asunto,
            'mensaje' => $request->mensaje,
            'prioridad' => $parentMessage->prioridad,
            'estado' => 'enviado'
        ], $senderType, Auth::id(), $recipientId);

        return response()->json([
            'success' => true,
            'message' => 'Respuesta enviada correctamente',
            'reply' => $reply->load(['sender', 'recipient'])
        ]);
    }
}
