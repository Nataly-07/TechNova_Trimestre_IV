<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    /**
     * Agregar producto a favoritos
     */
    public function agregar(Request $request, $productoId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $producto = Producto::find($productoId);
        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Verificar si ya está en favoritos
        $favoritoExistente = Favorito::where('user_id', $user->id)
                                   ->where('producto_id', $productoId)
                                   ->first();

        if ($favoritoExistente) {
            return response()->json(['error' => 'El producto ya está en favoritos'], 400);
        }

        // Crear nuevo favorito
        Favorito::create([
            'user_id' => $user->id,
            'producto_id' => $productoId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado a favoritos'
        ]);
    }

    /**
     * Quitar producto de favoritos
     */
    public function quitar(Request $request, $productoId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $favorito = Favorito::where('user_id', $user->id)
                           ->where('producto_id', $productoId)
                           ->first();

        if (!$favorito) {
            return response()->json(['error' => 'El producto no está en favoritos'], 404);
        }

        $favorito->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado de favoritos'
        ]);
    }

    /**
     * Toggle favorito (agregar si no existe, quitar si existe)
     */
    public function toggle(Request $request, $productoId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $producto = Producto::find($productoId);
        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        $favorito = Favorito::where('user_id', $user->id)
                           ->where('producto_id', $productoId)
                           ->first();

        if ($favorito) {
            // Quitar de favoritos
            $favorito->delete();
            $isFavorito = false;
            $message = 'Producto eliminado de favoritos';
        } else {
            // Agregar a favoritos
            Favorito::create([
                'user_id' => $user->id,
                'producto_id' => $productoId
            ]);
            $isFavorito = true;
            $message = 'Producto agregado a favoritos';
        }

        return response()->json([
            'success' => true,
            'isFavorito' => $isFavorito,
            'message' => $message
        ]);
    }

    /**
     * Verificar si un producto es favorito del usuario
     */
    public function verificar(Request $request, $productoId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['isFavorito' => false]);
        }

        $isFavorito = Favorito::where('user_id', $user->id)
                             ->where('producto_id', $productoId)
                             ->exists();

        return response()->json(['isFavorito' => $isFavorito]);
    }

    /**
     * Obtener todos los favoritos del usuario
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        $favoritos = $user->productosFavoritos()->with('caracteristicas')->get();

        return view('frontend.favoritos', compact('favoritos'));
    }
}
