<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\User;
use App\Models\Caracteristicas;
use App\Models\Proveedor;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Usuario;
use App\Models\Compra;
use App\Models\DetalleCompra;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    /**
     * Mostrar la página de reportes
     */
    public function index()
    {
        return view('frontend.reportes.index');
    }

    /**
     * Generar reporte de productos con filtros
     */
    public function productos(Request $request)
    {
        $query = Producto::with(['caracteristicas']);

        // Filtros
        if ($request->filled('categoria')) {
            $query->whereHas('caracteristicas', function($q) use ($request) {
                $q->where('Categoria', 'like', '%' . $request->categoria . '%');
            });
        }

        if ($request->filled('marca')) {
            $query->whereHas('caracteristicas', function($q) use ($request) {
                $q->where('Marca', 'like', '%' . $request->marca . '%');
            });
        }

        if ($request->filled('precio_min')) {
            $query->whereHas('caracteristicas', function($q) use ($request) {
                $q->where('Precio_Venta', '>=', $request->precio_min);
            });
        }

        if ($request->filled('precio_max')) {
            $query->whereHas('caracteristicas', function($q) use ($request) {
                $q->where('Precio_Venta', '<=', $request->precio_max);
            });
        }

        if ($request->filled('stock_min')) {
            $query->where('Stock', '>=', $request->stock_min);
        }

        $productos = $query->get();

        // Generar PDF usando Laravel DomPDF
        $pdf = Pdf::loadView('frontend.reportes.productos-pdf', compact('productos', 'request'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream('reporte_productos_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generar reporte de usuarios con filtros
     */
    public function usuarios(Request $request)
    {
        $query = User::query();

        // Filtros
        if ($request->filled('rol')) {
            $query->where('role', $request->rol);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->filled('busqueda')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('email', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('document_number', 'like', '%' . $request->busqueda . '%');
            });
        }

        $usuarios = $query->get();

        // Generar PDF usando Laravel DomPDF
        $pdf = Pdf::loadView('frontend.reportes.usuarios-pdf', compact('usuarios', 'request'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream('reporte_usuarios_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Obtener datos para filtros
     */
    public function getFiltros()
    {
        try {
            // Obtener categorías y marcas desde la tabla características
            $categorias = Caracteristicas::distinct()->pluck('Categoria')->filter();
            $marcas = Caracteristicas::distinct()->pluck('Marca')->filter();
            $roles = User::distinct()->pluck('role')->filter();

            return response()->json([
                'categorias' => $categorias,
                'marcas' => $marcas,
                'roles' => $roles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al cargar filtros: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vista previa del reporte de productos
     */
    public function previewProductos(Request $request)
    {
        $query = Producto::with(['caracteristicas']);

        // Aplicar los mismos filtros que en el método productos
        if ($request->filled('categoria')) {
            $query->whereHas('caracteristicas', function($q) use ($request) {
                $q->where('Categoria', 'like', '%' . $request->categoria . '%');
            });
        }

        if ($request->filled('marca')) {
            $query->whereHas('caracteristicas', function($q) use ($request) {
                $q->where('Marca', 'like', '%' . $request->marca . '%');
            });
        }

        if ($request->filled('precio_min')) {
            $query->whereHas('caracteristicas', function($q) use ($request) {
                $q->where('Precio_Venta', '>=', $request->precio_min);
            });
        }

        if ($request->filled('precio_max')) {
            $query->whereHas('caracteristicas', function($q) use ($request) {
                $q->where('Precio_Venta', '<=', $request->precio_max);
            });
        }

        if ($request->filled('stock_min')) {
            $query->where('Stock', '>=', $request->stock_min);
        }

        $productos = $query->limit(50)->get(); // Limitar para vista previa

        return view('frontend.reportes.preview-productos', compact('productos', 'request'));
    }

    /**
     * Vista previa del reporte de usuarios
     */
    public function previewUsuarios(Request $request)
    {
        $query = User::query();

        // Aplicar los mismos filtros que en el método usuarios
        if ($request->filled('rol')) {
            $query->where('role', $request->rol);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->filled('busqueda')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('email', 'like', '%' . $request->busqueda . '%')
                  ->orWhere('document_number', 'like', '%' . $request->busqueda . '%');
            });
        }

        $usuarios = $query->limit(50)->get(); // Limitar para vista previa

        return view('frontend.reportes.preview-usuarios', compact('usuarios', 'request'));
    }

    /**
     * Generar reporte de ventas con filtros
     */
    public function ventas(Request $request)
    {
        // Obtener datos reales de ventas de la base de datos
        $ventas = $this->obtenerVentasReales($request);
        
        // Generar PDF usando Laravel DomPDF
        $pdf = Pdf::loadView('frontend.reportes.ventas-pdf', compact('ventas', 'request'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream('reporte_ventas_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Vista previa del reporte de ventas
     */
    public function previewVentas(Request $request)
    {
        // Obtener datos reales de ventas para vista previa
        $ventas = $this->obtenerVentasReales($request);
        
        return view('frontend.reportes.preview-ventas', compact('ventas', 'request'));
    }

    /**
     * Exportar reporte de ventas a Excel
     */
    public function ventasExcel(Request $request)
    {
        // Por ahora retornamos un mensaje informativo
        return response()->json([
            'message' => 'Funcionalidad de exportación a Excel en desarrollo',
            'status' => 'info'
        ]);
    }

    /**
     * Dashboard interactivo de ventas
     */
    public function ventasDashboard(Request $request)
    {
        // Obtener datos reales de ventas para el dashboard
        $ventas = $this->obtenerVentasReales($request);
        $estadisticas = $this->generarEstadisticasVentas($ventas);
        
        return view('frontend.reportes.ventas-dashboard', compact('ventas', 'estadisticas', 'request'));
    }

    /**
     * Obtener datos reales de ventas de la base de datos
     */
    private function obtenerVentasReales($request)
    {
        // Usar directamente los datos de compras ya que sabemos que ahí están los datos correctos
        // Comentamos temporalmente la búsqueda en ventas
        /*
        // Intentar obtener ventas reales de la tabla 'ventas' con sus detalles
        try {
            $query = DetalleVenta::with([
                'venta', 
                'productos.caracteristica'
            ])
            ->join('ventas', 'detalleventas.ID_Ventas', '=', 'ventas.ID_Ventas')
            ->select('detalleventas.*', 'ventas.fecha_venta');

            // Aplicar filtros si se proporcionan
            if ($request->filled('categoria')) {
                $query->whereHas('productos.caracteristica', function($q) use ($request) {
                    $q->where('Categoria', 'like', '%' . $request->categoria . '%');
                });
            }

            if ($request->filled('marca')) {
                $query->whereHas('productos.caracteristica', function($q) use ($request) {
                    $q->where('Marca', 'like', '%' . $request->marca . '%');
                });
            }

            if ($request->filled('monto_min')) {
                $query->whereRaw('(detalleventas.Cantidad * detalleventas.Precio) >= ?', [$request->monto_min]);
            }

            // Aplicar filtros de fecha
            if ($request->filled('fecha_desde')) {
                $query->whereDate('ventas.fecha_venta', '>=', $request->fecha_desde);
            }

            if ($request->filled('fecha_hasta')) {
                $query->whereDate('ventas.fecha_venta', '<=', $request->fecha_hasta);
            }

            $ventasReales = $query->orderBy('ventas.fecha_venta', 'desc')->get();

            // Si hay ventas reales, procesarlas
            if ($ventasReales->count() > 0) {
                return $ventasReales->map(function($detalle) {
                    return (object)[
                        'id' => $detalle->ID_DetalleVentas,
                        'fecha' => $detalle->fecha_venta,
                        'producto_nombre' => $detalle->productos->Nombre ?? 'Producto desconocido',
                        'categoria' => $detalle->productos->caracteristica->Categoria ?? 'Sin categoría',
                        'marca' => $detalle->productos->caracteristica->Marca ?? 'Sin marca',
                        'cantidad' => $detalle->Cantidad,
                        'precio_unitario' => $detalle->Precio,
                        'total' => $detalle->Cantidad * $detalle->Precio,
                        'estado' => 'completada', // Por defecto, las ventas están completadas
                        'cliente' => 'Cliente ID: ' . ($detalle->venta->ID_Usuario ?? 'N/A'),
                    ];
                });
            }
        } catch (\Exception $e) {
            // Si hay error con las ventas reales, usar compras como alternativa
            \Log::info('Error obteniendo ventas reales: ' . $e->getMessage());
        }
        */

        // Usar compras como "ventas" (compras de clientes) - Consulta SQL directa
        try {
            // Consulta SQL directa para obtener todos los datos necesarios
            $sqlQuery = "
                SELECT 
                    dc.ID_DetalleCompras,
                    dc.Cantidad,
                    dc.Precio as precio_detalle,
                    c.Estado,
                    c.Fecha_De_Compra,
                    c.ID_Usuario,
                    p.Nombre as producto_nombre,
                    p.ID_Caracteristicas,
                    car.Categoria,
                    car.Marca,
                    car.Precio_Venta as precio_caracteristica,
                    u.name as usuario_nombre
                FROM detallecompras dc 
                JOIN compras c ON dc.ID_Compras = c.ID_Compras 
                JOIN productos p ON dc.ID_Producto = p.ID_Producto 
                LEFT JOIN caracteristica car ON p.ID_Caracteristicas = car.ID_Caracteristicas
                LEFT JOIN users u ON c.ID_Usuario = u.id
                WHERE 1=1
            ";

            $bindings = [];

            // Aplicar filtros si se proporcionan
            if ($request->filled('categoria')) {
                $sqlQuery .= " AND car.Categoria LIKE ?";
                $bindings[] = '%' . $request->categoria . '%';
            }

            if ($request->filled('marca')) {
                $sqlQuery .= " AND car.Marca LIKE ?";
                $bindings[] = '%' . $request->marca . '%';
            }

            if ($request->filled('estado')) {
                $estadosMap = [
                    'completada' => 'completado',
                    'pendiente' => 'pendiente',
                    'procesando' => 'procesando',
                    'cancelada' => 'cancelado'
                ];
                $estadoBD = $estadosMap[$request->estado] ?? $request->estado;
                $sqlQuery .= " AND c.Estado LIKE ?";
                $bindings[] = '%' . $estadoBD . '%';
            }

            if ($request->filled('monto_min')) {
                $sqlQuery .= " AND (dc.Cantidad * dc.Precio) >= ?";
                $bindings[] = $request->monto_min;
            }

            // Aplicar filtros de fecha
            if ($request->filled('fecha_desde')) {
                $sqlQuery .= " AND DATE(c.Fecha_De_Compra) >= ?";
                $bindings[] = $request->fecha_desde;
            }

            if ($request->filled('fecha_hasta')) {
                $sqlQuery .= " AND DATE(c.Fecha_De_Compra) <= ?";
                $bindings[] = $request->fecha_hasta;
            }

            $sqlQuery .= " ORDER BY c.Fecha_De_Compra DESC";

            $compras = \DB::select($sqlQuery, $bindings);


            if (count($compras) > 0) {
                return collect($compras)->map(function($detalle) {
                    $estado = strtolower($detalle->Estado ?? 'completada');
                    $estadosMap = [
                        'completado' => 'completada',
                        'pendiente' => 'pendiente',
                        'procesando' => 'procesando',
                        'cancelado' => 'cancelado'
                    ];
                    
                    // Determinar el precio correcto
                    $precioUnitario = $detalle->precio_detalle ?? 0;
                    if ($precioUnitario == 0) {
                        $precioUnitario = $detalle->precio_caracteristica ?? 0;
                    }
                    
                    
                    return (object)[
                        'id' => $detalle->ID_DetalleCompras,
                        'fecha' => $detalle->Fecha_De_Compra,
                        'producto_nombre' => $detalle->producto_nombre ?? 'Producto desconocido',
                        'categoria' => $detalle->Categoria ?? 'Sin categoría',
                        'marca' => $detalle->Marca ?? 'Sin marca',
                        'cantidad' => $detalle->Cantidad,
                        'precio_unitario' => $precioUnitario,
                        'total' => $detalle->Cantidad * $precioUnitario,
                        'estado' => $estadosMap[$estado] ?? 'completada',
                        'cliente' => $detalle->usuario_nombre ?? 'Cliente ID: ' . $detalle->ID_Usuario,
                    ];
                });
            }
        } catch (\Exception $e) {
            \Log::info('Error obteniendo compras como ventas: ' . $e->getMessage());
        }

        // Si no hay datos reales, retornar colección vacía
        return collect([]);
    }

    /**
     * Generar estadísticas de ventas
     */
    private function generarEstadisticasVentas($ventas)
    {
        return [
            'total_ventas' => $ventas->count(),
            'ingresos_totales' => $ventas->sum('total'),
            'venta_promedio' => $ventas->avg('total'),
            'productos_vendidos' => $ventas->sum('cantidad'),
            'ventas_por_estado' => $ventas->groupBy('estado')->map(function($grupo) {
                return $grupo->count();
            }),
            'ventas_por_categoria' => $ventas->groupBy('categoria')->map(function($grupo) {
                return $grupo->sum('total');
            }),
            'top_productos' => $ventas->groupBy('producto_nombre')
                ->map(function($grupo) {
                    return [
                        'cantidad' => $grupo->sum('cantidad'),
                        'ingresos' => $grupo->sum('total')
                    ];
                })
                ->sortByDesc('ingresos')
                ->take(5)
        ];
    }
}
