<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\User;
use App\Models\Producto;
use App\Models\MedioPago;
use Illuminate\Support\Facades\DB;

class AdminOrdersController extends Controller
{
    public function index(Request $request)
    {
        $query = Compra::with(['user', 'medioPago', 'detalles.producto.caracteristicas']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('Estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('Fecha_De_Compra', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('Fecha_De_Compra', '<=', $request->fecha_hasta);
        }

        if ($request->filled('cliente')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cliente . '%')
                  ->orWhere('email', 'like', '%' . $request->cliente . '%');
            });
        }

        $pedidos = $query->orderBy('ID_Compras', 'desc')->paginate(15);

        $estados = ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'];
        $total_pedidos = Compra::count();
        $pedidos_pendientes = Compra::where('Estado', 'pendiente')->count();

        return view('frontend.admin.orders.index', compact(
            'pedidos', 
            'estados', 
            'total_pedidos', 
            'pedidos_pendientes'
        ));
    }

    public function show($id)
    {
        $pedido = Compra::with(['user', 'medioPago', 'detalles.producto.caracteristicas'])
            ->findOrFail($id);

        return view('frontend.admin.orders.show', compact('pedido'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,procesando,enviado,entregado,cancelado'
        ]);

        $pedido = Compra::findOrFail($id);
        $pedido->update(['Estado' => $request->estado]);

        return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pedido = Compra::findOrFail($id);
        $pedido->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }

    public function getOrdersStats()
    {
        $stats = [
            'total' => Compra::count(),
            'pendientes' => Compra::where('Estado', 'pendiente')->count(),
            'procesando' => Compra::where('Estado', 'procesando')->count(),
            'enviados' => Compra::where('Estado', 'enviado')->count(),
            'entregados' => Compra::where('Estado', 'entregado')->count(),
            'cancelados' => Compra::where('Estado', 'cancelado')->count(),
        ];

        return response()->json($stats);
    }
}
