<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class CatalogoController extends Controller
{
    /**
     * Mostrar catálogo público (sin autenticación requerida)
     */
    public function index()
    {
        $productos = Producto::with('caracteristicas')->get();
        return view('frontend.index', compact('productos'));
    }

    /**
     * Mostrar catálogo autenticado (requiere autenticación)
     */
    public function catalogoAutenticado()
    {
        $user = Auth::user();
        $productos = Producto::with('caracteristicas')->get();
        return view('frontend.index-autenticado', compact('productos', 'user'));
    }

    /**
     * Mostrar productos por categoría (público)
     */
    public function categoria($categoria)
    {
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function($query) use ($categoria) {
                $query->where('Categoria', $categoria);
            })
            ->get();
        
        return view('frontend.categoria', compact('productos', 'categoria'));
    }

    /**
     * Mostrar productos por marca (público)
     */
    public function marca($marca)
    {
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function($query) use ($marca) {
                $query->where('Marca', $marca);
            })
            ->get();
        
        return view('frontend.marca', compact('productos', 'marca'));
    }

    /**
     * Mostrar productos por categoría (autenticado)
     */
    public function categoriaAutenticada($categoria)
    {
        $user = Auth::user();
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function($query) use ($categoria) {
                $query->where('Categoria', $categoria);
            })
            ->get();
        
        return view('frontend.categoria-autenticada', compact('productos', 'categoria', 'user'));
    }

    /**
     * Mostrar productos por marca (autenticado)
     */
    public function marcaAutenticada($marca)
    {
        $user = Auth::user();
        $productos = Producto::with('caracteristicas')
            ->whereHas('caracteristicas', function($query) use ($marca) {
                $query->where('Marca', $marca);
            })
            ->get();
        
        return view('frontend.marca-autenticada', compact('productos', 'marca', 'user'));
    }

    /**
     * Buscar productos (autenticado)
     */
    public function buscar(Request $request)
    {
        $user = Auth::user();
        $query = $request->get('q');
        
        if ($query) {
            $productos = Producto::with('caracteristicas')
                ->where('Nombre', 'like', '%' . $query . '%')
                ->orWhereHas('caracteristicas', function($q) use ($query) {
                    $q->where('Categoria', 'like', '%' . $query . '%')
                      ->orWhere('Marca', 'like', '%' . $query . '%')
                      ->orWhere('Descripcion', 'like', '%' . $query . '%');
                })
                ->get();
        } else {
            $productos = Producto::with('caracteristicas')->get();
        }
        
        return view('frontend.index-autenticado', compact('productos', 'user', 'query'));
    }
}
