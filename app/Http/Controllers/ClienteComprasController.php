<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Productos;
use Illuminate\Support\Facades\Auth;

class ClienteComprasController extends Controller
{
    /**
     * Mostrar el listado de compras del cliente
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        // Obtener todas las compras del cliente con sus detalles
        $compras = Compra::where('ID_Usuario', $user->id)
            ->with(['detalles.producto', 'medioPago'])
            ->orderBy('Fecha_Compra', 'desc')
            ->paginate(10);

        return view('frontend.cliente.mis-compras', compact('compras'));
    }

    /**
     * Mostrar los detalles de una compra específica
     */
    public function show($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        // Obtener la compra específica del cliente
        $compra = Compra::where('ID_Compras', $id)
            ->where('ID_Usuario', $user->id)
            ->with(['detalles.producto', 'medioPago'])
            ->first();

        if (!$compra) {
            return redirect()->route('cliente.mis-compras.index')
                ->with('error', 'Compra no encontrada');
        }

        return view('frontend.cliente.detalle-compra', compact('compra'));
    }

    /**
     * Obtener estadísticas de compras del cliente
     */
    public function estadisticas()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        $compras = Compra::where('ID_Usuario', $user->id)->get();
        
        $estadisticas = [
            'total_compras' => $compras->count(),
            'total_gastado' => $compras->sum('Total'),
            'compra_promedio' => $compras->count() > 0 ? $compras->avg('Total') : 0,
            'ultima_compra' => $compras->max('Fecha_Compra'),
            'compras_por_estado' => $compras->groupBy('Estado')->map->count()
        ];

        return response()->json($estadisticas);
    }
}


