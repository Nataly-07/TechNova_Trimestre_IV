<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Producto;

class EmpleadoController extends Controller
{
    /**
     * Mostrar inventario para empleados
     */
    public function inventario()
    {
        $productos = Producto::with('caracteristicas')->get();
        return view('frontend.inventarioempleados', compact('productos'));
    }

    /**
     * Mostrar usuarios cliente para empleados
     */
    public function usuariosCliente()
    {
        $clientes = User::where('role', 'cliente')->get();
        return view('frontend.usuarios-cliente', compact('clientes'));
    }
}
