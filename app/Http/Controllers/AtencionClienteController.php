<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtencionCliente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AtencionClienteController extends Controller
{
    public function index()
    {
        $consultas = [];
        
        if (Auth::check()) {
            $consultas = AtencionCliente::where('ID_Usuario', Auth::id())
                ->orderBy('Fecha_Consulta', 'desc')
                ->get();
        }
        
        return view('frontend.atencion-cliente', compact('consultas'));
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
}
