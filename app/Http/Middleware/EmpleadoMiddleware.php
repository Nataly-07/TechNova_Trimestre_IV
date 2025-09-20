<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpleadoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/iniciosesion')->with('error', 'Debes iniciar sesión como empleado para acceder a esta página.');
        }
        
        // Verificar si el usuario es empleado
        $user = Auth::user();
        if ($user->role !== 'empleado') {
            if ($user->role === 'admin') {
                return redirect()->route('perfilad')->with('error', 'No tienes permisos de empleado para acceder a esta página.');
            } elseif ($user->role === 'cliente') {
                return redirect()->route('perfillcli')->with('error', 'No tienes permisos de empleado para acceder a esta página.');
            } else {
                return redirect('/iniciosesion')->with('error', 'Rol de usuario no válido.');
            }
        }
        
        return $next($request);
    }
}
