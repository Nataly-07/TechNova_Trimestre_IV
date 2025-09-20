<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/iniciosesion')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }
        
        // Verificar si el usuario es cliente
        $user = Auth::user();
        if ($user->role !== 'cliente') {
            if ($user->role === 'admin') {
                return redirect()->route('perfilad')->with('error', 'No tienes permisos para acceder a esta página de cliente.');
            } elseif ($user->role === 'empleado') {
                return redirect()->route('perfilemp')->with('error', 'No tienes permisos para acceder a esta página de cliente.');
            } else {
                return redirect('/iniciosesion')->with('error', 'Rol de usuario no válido.');
            }
        }
        
        return $next($request);
    }
}
