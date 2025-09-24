<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\MensajeDirecto;
use App\Models\AtencionCliente;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'total_usuarios' => User::count(),
            'total_clientes' => User::where('role', 'cliente')->count(),
            'total_empleados' => User::where('role', 'empleado')->count(),
            'total_productos' => Producto::count(),
            'total_proveedores' => Proveedor::count(),
        ];

        // Estadísticas de ventas y compras
        $ventas_stats = $this->getVentasStats();
        $compras_stats = $this->getComprasStats();
        $pagos_stats = $this->getPagosStats();

        // Pedidos recientes (compras de clientes)
        $pedidos_recientes = $this->getPedidosRecientes();

        // Ventas del último mes
        $ventas_mes = $this->getVentasUltimoMes();

        // Total de ventas
        $total_ventas = $this->getTotalVentas();

        // Pagos realizados por clientes
        $pagos_clientes = $this->getPagosClientes();

        // Gráficos de datos
        $grafico_ventas_mensual = $this->getGraficoVentasMensual();
        $grafico_usuarios_registrados = $this->getGraficoUsuariosRegistrados();
        $grafico_productos_mas_vendidos = $this->getProductosMasVendidos();

        // Mensajes y consultas recientes
        $mensajes_recientes = MensajeDirecto::with(['sender', 'recipient'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $consultas_recientes = AtencionCliente::with('usuario')
            ->orderBy('Fecha_Consulta', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.admin.dashboard', compact(
            'stats',
            'ventas_stats',
            'compras_stats',
            'pagos_stats',
            'pedidos_recientes',
            'ventas_mes',
            'total_ventas',
            'pagos_clientes',
            'grafico_ventas_mensual',
            'grafico_usuarios_registrados',
            'grafico_productos_mas_vendidos',
            'mensajes_recientes',
            'consultas_recientes'
        ));
    }

    private function getVentasStats()
    {
        $hoy = Carbon::today();
        $mes_actual = Carbon::now()->startOfMonth();
        $mes_anterior = Carbon::now()->subMonth()->startOfMonth();

        return [
            'ventas_hoy' => Venta::whereDate('fecha_venta', $hoy)->count(),
            'ventas_mes_actual' => Venta::where('fecha_venta', '>=', $mes_actual)->count(),
            'ventas_mes_anterior' => Venta::whereBetween('fecha_venta', [$mes_anterior, $mes_actual])->count(),
            'total_ventas' => Venta::count(),
        ];
    }

    private function getComprasStats()
    {
        $hoy = Carbon::today();
        $mes_actual = Carbon::now()->startOfMonth();

        return [
            'compras_hoy' => Compra::whereDate('Fecha_De_Compra', $hoy)->count(),
            'compras_mes_actual' => Compra::where('Fecha_De_Compra', '>=', $mes_actual)->count(),
            'total_compras' => Compra::count(),
            'compras_pendientes' => Compra::where('Estado', 'pendiente')->count(),
        ];
    }

    private function getPagosStats()
    {
        $hoy = Carbon::today();
        $mes_actual = Carbon::now()->startOfMonth();

        return [
            'pagos_hoy' => Pago::whereDate('Fecha_Pago', $hoy)->count(),
            'pagos_mes_actual' => Pago::where('Fecha_Pago', '>=', $mes_actual)->count(),
            'total_pagos' => Pago::count(),
            'pagos_pendientes' => Pago::where('Estado_Pago', 'pendiente')->count(),
        ];
    }

    private function getPedidosRecientes()
    {
        return Compra::with(['user', 'medioPago', 'detalles.producto'])
            ->orderBy('Fecha_De_Compra', 'desc')
            ->limit(10)
            ->get();
    }

    private function getVentasUltimoMes()
    {
        $inicio_mes = Carbon::now()->startOfMonth();
        $fin_mes = Carbon::now()->endOfMonth();

        return Venta::with(['usuario', 'detalles.producto'])
            ->whereBetween('fecha_venta', [$inicio_mes, $fin_mes])
            ->orderBy('fecha_venta', 'desc')
            ->get();
    }

    private function getTotalVentas()
    {
        return Venta::with(['usuario', 'detalles.producto'])
            ->orderBy('fecha_venta', 'desc')
            ->get();
    }

    private function getPagosClientes()
    {
        return Pago::orderBy('Fecha_Pago', 'desc')
            ->limit(20)
            ->get();
    }

    private function getGraficoVentasMensual()
    {
        $ventas_mensuales = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $inicio_mes = $fecha->copy()->startOfMonth();
            $fin_mes = $fecha->copy()->endOfMonth();
            
            $ventas_mensuales[] = [
                'mes' => $fecha->format('M Y'),
                'ventas' => Venta::whereBetween('fecha_venta', [$inicio_mes, $fin_mes])->count(),
                'compras' => Compra::whereBetween('Fecha_De_Compra', [$inicio_mes, $fin_mes])->count(),
            ];
        }

        return $ventas_mensuales;
    }

    private function getGraficoUsuariosRegistrados()
    {
        $usuarios_mensuales = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $inicio_mes = $fecha->copy()->startOfMonth();
            $fin_mes = $fecha->copy()->endOfMonth();
            
            $usuarios_mensuales[] = [
                'mes' => $fecha->format('M Y'),
                'usuarios' => User::whereBetween('created_at', [$inicio_mes, $fin_mes])->count(),
            ];
        }

        return $usuarios_mensuales;
    }

    private function getProductosMasVendidos()
    {
        return DB::table('detalleventas as dv')
            ->join('producto as p', 'dv.ID_Producto', '=', 'p.ID_Producto')
            ->select('p.Nombre as Nombre_Producto', 'p.ID_Producto', DB::raw('SUM(dv.Cantidad) as total_vendido'))
            ->groupBy('p.ID_Producto', 'p.Nombre')
            ->orderBy('total_vendido', 'desc')
            ->limit(10)
            ->get();
    }

    public function getStatsData()
    {
        $stats = [
            'ventas_mensuales' => $this->getGraficoVentasMensual(),
            'usuarios_registrados' => $this->getGraficoUsuariosRegistrados(),
            'productos_mas_vendidos' => $this->getProductosMasVendidos(),
        ];

        return response()->json($stats);
    }
}
