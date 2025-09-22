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
        
        // Obtener parámetros de filtro
        $categoria = $request->get('categoria');
        $marca = $request->get('marca');
        $precioMin = $request->get('precio_min');
        $precioMax = $request->get('precio_max');
        $calificacion = $request->get('calificacion');
        $stock = $request->get('stock');
        
        // Debug: Log de parámetros recibidos
        \Log::info('Parámetros de búsqueda:', [
            'query' => $query,
            'categoria' => $categoria,
            'marca' => $marca,
            'precioMin' => $precioMin,
            'precioMax' => $precioMax,
            'calificacion' => $calificacion,
            'stock' => $stock
        ]);
        
        // Debug: Ver qué categorías y marcas existen
        $categoriasExistentes = \App\Models\Caracteristica::distinct()->pluck('Categoria')->toArray();
        $marcasExistentes = \App\Models\Caracteristica::distinct()->pluck('Marca')->toArray();
        \Log::info('Categorías existentes:', $categoriasExistentes);
        \Log::info('Marcas existentes:', $marcasExistentes);
        
        // Construir consulta base
        $productosQuery = Producto::with('caracteristicas');
        
        // Aplicar filtros en una sola consulta whereHas
        $productosQuery->whereHas('caracteristicas', function($q) use ($categoria, $marca, $precioMin, $precioMax) {
            if ($categoria) {
                $q->where('Categoria', 'like', '%' . ucfirst($categoria) . '%');
            }
            
            if ($marca) {
                $q->where('Marca', 'like', '%' . $marca . '%');
            }
            
            if ($precioMin || $precioMax) {
                if ($precioMin && $precioMax) {
                    $q->whereBetween('Precio_Venta', [$precioMin, $precioMax]);
                } elseif ($precioMin) {
                    $q->where('Precio_Venta', '>=', $precioMin);
                } elseif ($precioMax) {
                    $q->where('Precio_Venta', '<=', $precioMax);
                }
            }
        });
        
        if ($stock === 'disponible') {
            $productosQuery->where('Stock', '>', 0);
        } elseif ($stock === 'agotado') {
            $productosQuery->where('Stock', '<=', 0);
        }
        
        // Aplicar búsqueda de texto
        if ($query) {
            $productosQuery->where(function($q) use ($query) {
                $q->where('Nombre', 'like', '%' . $query . '%')
                  ->orWhereHas('caracteristicas', function($subQ) use ($query) {
                      $subQ->where('Categoria', 'like', '%' . $query . '%')
                           ->orWhere('Marca', 'like', '%' . $query . '%')
                           ->orWhere('Descripcion', 'like', '%' . $query . '%');
                  });
            });
        }
        
        // Aplicar filtro de calificación (simulado) en la consulta SQL
        if ($calificacion) {
            $productosQuery->whereRaw('(4 + (ID_Producto % 2)) >= ?', [$calificacion]);
        }
        
        // Debug: Log de la consulta SQL
        \Log::info('Consulta SQL:', ['sql' => $productosQuery->toSql(), 'bindings' => $productosQuery->getBindings()]);
        
        $productos = $productosQuery->get();
        
        // Debug: Log de productos encontrados
        \Log::info('Productos encontrados después de filtros:', ['count' => $productos->count()]);
        
        // Debug: Log de productos específicos encontrados
        if ($productos->count() > 0) {
            \Log::info('Productos encontrados:', $productos->map(function($p) {
                return [
                    'id' => $p->ID_Producto,
                    'nombre' => $p->Nombre,
                    'marca' => $p->caracteristicas->Marca ?? 'Sin marca',
                    'precio' => $p->caracteristicas->Precio_Venta ?? 0,
                    'stock' => $p->Stock ?? 0
                ];
            })->toArray());
        }
        
        return view('frontend.index-autenticado', compact('productos', 'user', 'query', 'categoria', 'marca', 'precioMin', 'precioMax', 'calificacion', 'stock'));
    }


    /**
     * Mostrar detalles de un producto específico
     */
    public function mostrarDetalles($id)
    {
        $producto = Producto::with('caracteristicas')->findOrFail($id);
        $user = Auth::user();
        
        return view('frontend.detalle-producto', compact('producto', 'user'));
    }
}
