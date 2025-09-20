<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/iniciosesion')->with('error', 'Debes iniciar sesión como administrador para acceder a esta página.');
        }
        
        // Verificar si el usuario es admin
        $user = Auth::user();
        if ($user->role !== 'admin') {
            if ($user->role === 'cliente') {
                return redirect()->route('perfillcli')->with('error', 'No tienes permisos de administrador para acceder a esta página.');
            } elseif ($user->role === 'empleado') {
                return redirect()->route('perfilemp')->with('error', 'No tienes permisos de administrador para acceder a esta página.');
            } else {
                return redirect('/iniciosesion')->with('error', 'Rol de usuario no válido.');
            }
        }
        
        return $next($request);
    }
}
