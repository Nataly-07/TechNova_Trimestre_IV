<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    /**
     * Mostrar el listado de compras (para administradores)
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect()->route('frontend.login');
        }

        $compras = Compra::with(['user', 'detalles.producto', 'medioPago'])
            ->orderBy('Fecha_Compra', 'desc')
            ->paginate(15);

        return view('admin.compras.index', compact('compras'));
    }

    /**
     * Mostrar detalles de una compra específica
     */
    public function show($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect()->route('frontend.login');
        }

        $compra = Compra::where('ID_Compras', $id)
            ->with(['user', 'detalles.producto', 'medioPago'])
            ->first();

        if (!$compra) {
            return redirect()->route('compras.index')
                ->with('error', 'Compra no encontrada');
        }

        return view('admin.compras.show', compact('compra'));
    }
}
