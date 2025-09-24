<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;
use App\Services\NotificacionService;

class NotificacionesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Procesar eventos automáticos para crear notificaciones
        NotificacionService::procesarEventosAutomaticos();
        
        // Obtener notificaciones reales de la base de datos
        $notificaciones = Notificacion::obtenerTodas($user->id, 50);
        
        // Obtener estadísticas
        $estadisticas = NotificacionService::obtenerEstadisticas($user->id);
        
        return view('frontend.notificaciones', compact('notificaciones', 'estadisticas'));
    }

    public function marcarComoLeida($id)
    {
        $user = Auth::user();
        
        $notificacion = Notificacion::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
            
        if (!$notificacion) {
            return response()->json([
                'success' => false, 
                'message' => 'Notificación no encontrada'
            ], 404);
        }
        
        $notificacion->marcarComoLeida();
        
        // Obtener estadísticas actualizadas
        $estadisticas = NotificacionService::obtenerEstadisticas($user->id);
        
        return response()->json([
            'success' => true, 
            'message' => 'Notificación marcada como leída',
            'estadisticas' => $estadisticas
        ]);
    }

    public function marcarComoNoLeida($id)
    {
        $user = Auth::user();
        
        $notificacion = Notificacion::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
            
        if (!$notificacion) {
            return response()->json([
                'success' => false, 
                'message' => 'Notificación no encontrada'
            ], 404);
        }
        
        $notificacion->marcarComoNoLeida();
        
        // Obtener estadísticas actualizadas
        $estadisticas = NotificacionService::obtenerEstadisticas($user->id);
        
        return response()->json([
            'success' => true, 
            'message' => 'Notificación marcada como no leída',
            'estadisticas' => $estadisticas
        ]);
    }

    public function marcarTodasComoLeidas()
    {
        $user = Auth::user();
        
        // Marcar todas las notificaciones del usuario como leídas
        Notificacion::where('user_id', $user->id)
            ->where('leida', false)
            ->update(['leida' => true]);
        
        // Obtener estadísticas actualizadas
        $estadisticas = NotificacionService::obtenerEstadisticas($user->id);
        
        return response()->json([
            'success' => true, 
            'message' => 'Todas las notificaciones marcadas como leídas',
            'estadisticas' => $estadisticas
        ]);
    }

    public function filtrar(Request $request)
    {
        $user = Auth::user();
        $filtro = $request->get('filtro', 'todas');
        
        $query = Notificacion::where('user_id', $user->id)
            ->orderBy('fecha_creacion', 'desc');

        switch ($filtro) {
            case 'no_leidas':
                $query->where('leida', false);
                break;
            case 'leidas':
                $query->where('leida', true);
                break;
            case 'todas':
            default:
                // Sin filtro adicional
                break;
        }

        $notificaciones = $query->limit(50)->get();
        
        // Obtener estadísticas
        $estadisticas = NotificacionService::obtenerEstadisticas($user->id);

        return response()->json([
            'success' => true,
            'notificaciones' => $notificaciones,
            'estadisticas' => $estadisticas
        ]);
    }
}
