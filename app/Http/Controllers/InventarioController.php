<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventarioController extends Controller
{
    // Mostrar vista inventario
    public function index()
    {
        return view('frontend.inventario');
    }

    // Mostrar vista inventario empleados
    public function empleados()
    {
        return view('frontend.inventarioempleados');
    }
}
