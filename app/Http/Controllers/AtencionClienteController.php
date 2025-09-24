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
        $mensajes = [];
        
        if (Auth::check()) {
            $consultas = AtencionCliente::where('ID_Usuario', Auth::id())
                ->orderBy('Fecha_Consulta', 'desc')
                ->get();
                
            $mensajes = MensajeDirecto::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('frontend.atencion-cliente', compact('consultas', 'mensajes'));
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

        MensajeDirecto::create([
            'user_id' => Auth::id(),
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'prioridad' => $request->prioridad,
            'estado' => 'enviado'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado correctamente'
        ]);
    }

    public function showMensaje($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }
        
        $mensaje = MensajeDirecto::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        return response()->json($mensaje);
    }
}
