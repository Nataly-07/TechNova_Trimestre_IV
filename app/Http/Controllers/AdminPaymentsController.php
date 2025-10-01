<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Compra;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminPaymentsController extends Controller
{
    public function index(Request $request)
    {
        $query = Pago::query();

        // Filtros
        if ($request->filled('estado')) {
            $query->where('Estado_Pago', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('Fecha_Pago', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('Fecha_Pago', '<=', $request->fecha_hasta);
        }

        if ($request->filled('monto_min')) {
            $query->where('Monto', '>=', $request->monto_min);
        }

        if ($request->filled('monto_max')) {
            $query->where('Monto', '<=', $request->monto_max);
        }

        $pagos = $query->orderBy('ID_Pagos', 'desc')->paginate(15);

        $estados = ['pendiente', 'aprobado', 'rechazado', 'cancelado'];
        $total_pagos = Pago::count();
        $pagos_pendientes = Pago::where('Estado_Pago', 'pendiente')->count();
        $total_monto = Pago::where('Estado_Pago', 'aprobado')->sum('Monto');

        return view('frontend.admin.payments.index', compact(
            'pagos', 
            'estados', 
            'total_pagos', 
            'pagos_pendientes',
            'total_monto'
        ));
    }

    public function show($id)
    {
        $pago = Pago::findOrFail($id);
        
        // Buscar la compra relacionada si existe
        $compra = null;
        if ($pago->Numero_Factura) {
            $compra = Compra::where('ID_Compras', $pago->Numero_Factura)->first();
        }

        return view('frontend.admin.payments.show', compact('pago', 'compra'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,aprobado,rechazado,cancelado'
        ]);

        $pago = Pago::findOrFail($id);
        $pago->update(['Estado_Pago' => $request->estado]);

        return redirect()->back()->with('success', 'Estado del pago actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pago eliminado correctamente.');
    }

    public function getPaymentsStats()
    {
        $stats = [
            'total' => Pago::count(),
            'pendientes' => Pago::where('Estado_Pago', 'pendiente')->count(),
            'aprobados' => Pago::where('Estado_Pago', 'aprobado')->count(),
            'rechazados' => Pago::where('Estado_Pago', 'rechazado')->count(),
            'cancelados' => Pago::where('Estado_Pago', 'cancelado')->count(),
            'total_monto' => Pago::where('Estado_Pago', 'aprobado')->sum('Monto'),
        ];

        return response()->json($stats);
    }

    public function getMonthlyPayments()
    {
        $pagos_mensuales = DB::table('pagos')
            ->select(
                DB::raw('YEAR(Fecha_Pago) as año'),
                DB::raw('MONTH(Fecha_Pago) as mes'),
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('SUM(Monto) as total_monto')
            )
            ->where('Estado_Pago', 'aprobado')
            ->groupBy('año', 'mes')
            ->orderBy('año', 'desc')
            ->orderBy('mes', 'desc')
            ->limit(12)
            ->get();

        return response()->json($pagos_mensuales);
    }
}
