<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\DetalleCarrito;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    /**
     * Mostrar el carrito del usuario
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        // Obtener o crear carrito del usuario
        $carrito = $user->carrito;
        if (!$carrito) {
            $carrito = Carrito::create([
                'ID_Usuario' => $user->id,
                'Fecha_Creacion' => now()
            ]);
        }

        // Obtener productos del carrito con sus detalles
        $productos = $carrito->detalles()->with('producto.caracteristicas')->get();
        
        $total = 0;
        foreach ($productos as $detalle) {
            $total += $detalle->producto->caracteristicas->Precio_Venta * $detalle->Cantidad;
        }

        return view('frontend.carrito', compact('productos', 'total', 'carrito'));
    }

    /**
     * Agregar producto al carrito
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

        $cantidad = $request->input('cantidad', 1);

        // Obtener o crear carrito del usuario
        $carrito = $user->carrito;
        if (!$carrito) {
            $carrito = Carrito::create([
                'ID_Usuario' => $user->id,
                'Fecha_Creacion' => now()
            ]);
        }

        // Verificar si el producto ya está en el carrito
        $detalleExistente = DetalleCarrito::where('ID_Carrito', $carrito->ID_Carrito)
                                         ->where('ID_Producto', $productoId)
                                         ->first();

        if ($detalleExistente) {
            $detalleExistente->Cantidad += $cantidad;
            $detalleExistente->save();
        } else {
            DetalleCarrito::create([
                'ID_Carrito' => $carrito->ID_Carrito,
                'ID_Producto' => $productoId,
                'Cantidad' => $cantidad
            ]);
        }

        // Calcular el contador actualizado del carrito
        $cartCount = $carrito->detalles()->sum('Cantidad');

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'cartCount' => $cartCount
        ]);
    }

    /**
     * Actualizar cantidad de producto en el carrito
     */
    public function actualizar(Request $request, $detalleId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $detalle = DetalleCarrito::find($detalleId);
        if (!$detalle) {
            return response()->json(['error' => 'Detalle no encontrado'], 404);
        }

        // Verificar que el detalle pertenece al carrito del usuario
        if ($detalle->carrito->ID_Usuario != $user->id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $cantidad = $request->input('cantidad');
        if ($cantidad <= 0) {
            $detalle->delete();
        } else {
            $detalle->Cantidad = $cantidad;
            $detalle->save();
        }

        // Calcular el contador actualizado del carrito
        $carrito = $user->carrito;
        $cartCount = $carrito ? $carrito->detalles()->sum('Cantidad') : 0;

        return response()->json([
            'success' => true,
            'message' => 'Carrito actualizado',
            'cartCount' => $cartCount
        ]);
    }

    /**
     * Eliminar producto del carrito
     */
    public function eliminar($detalleId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $detalle = DetalleCarrito::find($detalleId);
        if (!$detalle) {
            return response()->json(['error' => 'Detalle no encontrado'], 404);
        }

        // Verificar que el detalle pertenece al carrito del usuario
        if ($detalle->carrito->ID_Usuario != $user->id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $detalle->delete();

        // Calcular el contador actualizado del carrito
        $carrito = $user->carrito;
        $cartCount = $carrito ? $carrito->detalles()->sum('Cantidad') : 0;

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado del carrito',
            'cartCount' => $cartCount
        ]);
    }

    /**
     * Vaciar carrito
     */
    public function vaciar()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $carrito = $user->carrito;
        if ($carrito) {
            $carrito->detalles()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Carrito vaciado',
            'cartCount' => 0
        ]);
    }
}
