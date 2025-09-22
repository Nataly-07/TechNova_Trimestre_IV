<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Carrito;

class PedidosClienteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('frontend.login')->with('error', 'Debes iniciar sesión para ver tus pedidos.');
        }
        
        // Obtener las compras del cliente autenticado
        $compras = Compra::where('ID_Usuario', $user->id)
            ->with(['detalles.producto.caracteristica'])
            ->orderBy('Fecha_Compra', 'desc')
            ->get();

        // Procesar los datos para la vista
        $pedidos = [];
        foreach ($compras as $compra) {
            $pedido = [
                'id' => $compra->ID_Compras,
                'fecha' => $compra->Fecha_Compra,
                'total' => $compra->Total,
                'estado' => $this->determinarEstado($compra),
                'metodo_pago' => $this->obtenerMetodoPago($compra),
                'productos' => [],
                'direccion' => $this->obtenerDireccion($compra),
                'transportadora' => $this->obtenerTransportadora($compra),
                'numero_guia' => $this->obtenerNumeroGuia($compra),
            ];

            // Agregar productos del pedido
            foreach ($compra->detalles as $detalle) {
                if ($detalle->producto) {
                    $pedido['productos'][] = [
                        'nombre' => $detalle->producto->Nombre,
                        'cantidad' => $detalle->Cantidad,
                        'precio' => $detalle->Precio,
                        'imagen' => $detalle->producto->Imagen,
                        'caracteristicas' => $detalle->producto->caracteristica,
                    ];
                }
            }

            $pedidos[] = $pedido;
        }

        return view('frontend.pedidoscli', compact('pedidos'));
    }

    private function determinarEstado($compra)
    {
        // Si el pedido está cancelado, retornar cancelado
        if ($compra->Estado === 'cancelado') {
            return 'cancelado';
        }
        
        // Si el pedido está entregado, retornar entregado
        if ($compra->Estado === 'entregado') {
            return 'entregado';
        }
        
        // Para otros estados, usar lógica basada en fecha
        $fechaCompra = \Carbon\Carbon::parse($compra->Fecha_Compra);
        $diasTranscurridos = $fechaCompra->diffInDays(now());

        if ($diasTranscurridos >= 7) {
            return 'entregado';
        } elseif ($diasTranscurridos >= 3) {
            return 'transito';
        } elseif ($diasTranscurridos >= 1) {
            return 'preparacion';
        } else {
            return 'pendiente';
        }
    }

    private function obtenerMetodoPago($compra)
    {
        // Obtener el método de pago desde la tabla mediodepago
        $medioPago = \App\Models\MedioPago::where('ID_MedioDePago', $compra->ID_MedioDePago)->first();
        return $medioPago ? $medioPago->Metodo_pago : 'No especificado';
    }

    private function obtenerDireccion($compra)
    {
        // Por ahora retornamos una dirección por defecto
        // En el futuro esto debería venir de una tabla de direcciones
        return 'Cl 58 Norte #12-34, Chapinero, Bogotá';
    }

    private function obtenerTransportadora($compra)
    {
        // Por ahora retornamos transportadoras aleatorias
        $transportadoras = ['Servientrega', 'Interrapidísimo', 'Coordinadora', 'TCC'];
        return $transportadoras[array_rand($transportadoras)];
    }

    private function obtenerNumeroGuia($compra)
    {
        // Generar un número de guía ficticio
        $prefijos = ['ST', 'IR', 'CO', 'TC'];
        $prefijo = $prefijos[array_rand($prefijos)];
        return $prefijo . rand(100000000, 999999999);
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $compra = Compra::where('ID_Compras', $id)
            ->where('ID_Usuario', $user->id)
            ->with(['detalles.producto.caracteristica'])
            ->firstOrFail();

        return view('frontend.pedido-detalle', compact('compra'));
    }

    public function cancelar($id)
    {
        $user = Auth::user();
        
        try {
            $compra = Compra::where('ID_Compras', $id)
                ->where('ID_Usuario', $user->id)
                ->firstOrFail();

            // Verificar que el pedido se puede cancelar
            if ($compra->Estado === 'cancelado') {
                return response()->json([
                    'success' => false,
                    'message' => 'Este pedido ya está cancelado'
                ]);
            }

            if ($compra->Estado === 'entregado') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede cancelar un pedido que ya fue entregado'
                ]);
            }

            // Actualizar el estado del pedido
            $compra->Estado = 'cancelado';
            $compra->save();

            // Opcional: Restaurar stock de productos
            foreach ($compra->detalles as $detalle) {
                if ($detalle->producto) {
                    $producto = \App\Models\Producto::find($detalle->producto->ID_Producto);
                    if ($producto) {
                        $producto->Stock += $detalle->Cantidad;
                        $producto->Salida = max(0, $producto->Salida - $detalle->Cantidad);
                        $producto->save();
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Pedido cancelado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar el pedido: ' . $e->getMessage()
            ]);
        }
    }
}
