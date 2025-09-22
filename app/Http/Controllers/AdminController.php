<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Producto;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function perfilad()
    {
        $users = User::all();
        $productos = Producto::with('caracteristicas')->get();
        return view('frontend.perfilad', compact('users', 'productos'));
    }
}
