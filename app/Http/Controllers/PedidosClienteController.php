<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Carrito;
use App\Models\DetalleCarrito;
use Barryvdh\DomPDF\Facade\Pdf;

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
            ->with(['detalles.producto.caracteristicas'])
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
                        'caracteristicas' => $detalle->producto->caracteristicas,
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
            ->with(['detalles.producto.caracteristicas'])
            ->firstOrFail();

        return view('frontend.pedido-detalle', compact('compra'));
    }

    public function factura($id)
    {
        $user = Auth::user();
        
        $compra = Compra::where('ID_Compras', $id)
            ->where('ID_Usuario', $user->id)
            ->with(['detalles.producto.caracteristicas'])
            ->firstOrFail();

        // Procesar los datos para la factura
        $factura = [
            'id' => $compra->ID_Compras,
            'fecha' => $compra->Fecha_Compra,
            'total' => $compra->Total,
            'estado' => $this->determinarEstado($compra),
            'metodo_pago' => $this->obtenerMetodoPago($compra),
            'productos' => [],
            'direccion' => $this->obtenerDireccion($compra),
            'transportadora' => $this->obtenerTransportadora($compra),
            'numero_guia' => $this->obtenerNumeroGuia($compra),
            'cliente' => [
                'nombre' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'documento' => $user->document_number ?? 'N/A',
                'telefono' => $user->phone ?? 'N/A',
            ]
        ];

        // Agregar productos del pedido
        foreach ($compra->detalles as $detalle) {
            if ($detalle->producto) {
                $factura['productos'][] = [
                    'nombre' => $detalle->producto->Nombre,
                    'cantidad' => $detalle->Cantidad,
                    'precio' => $detalle->Precio,
                    'subtotal' => $detalle->Cantidad * $detalle->Precio,
                    'imagen' => $detalle->producto->Imagen,
                    'caracteristicas' => $detalle->producto->caracteristicas,
                ];
            }
        }

        return view('frontend.factura', compact('factura'));
    }

    public function facturaPDF($id)
    {
        $user = Auth::user();
        
        $compra = Compra::where('ID_Compras', $id)
            ->where('ID_Usuario', $user->id)
            ->with(['detalles.producto.caracteristicas'])
            ->firstOrFail();

        // Procesar los datos para la factura
        $factura = [
            'id' => $compra->ID_Compras,
            'fecha' => $compra->Fecha_Compra,
            'total' => $compra->Total,
            'estado' => $this->determinarEstado($compra),
            'metodo_pago' => $this->obtenerMetodoPago($compra),
            'productos' => [],
            'direccion' => $this->obtenerDireccion($compra),
            'transportadora' => $this->obtenerTransportadora($compra),
            'numero_guia' => $this->obtenerNumeroGuia($compra),
            'cliente' => [
                'nombre' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'documento' => $user->document_number ?? 'N/A',
                'telefono' => $user->phone ?? 'N/A',
            ]
        ];

        // Agregar productos del pedido
        foreach ($compra->detalles as $detalle) {
            if ($detalle->producto) {
                $factura['productos'][] = [
                    'nombre' => $detalle->producto->Nombre,
                    'cantidad' => $detalle->Cantidad,
                    'precio' => $detalle->Precio,
                    'subtotal' => $detalle->Cantidad * $detalle->Precio,
                    'imagen' => $detalle->producto->Imagen,
                    'caracteristicas' => $detalle->producto->caracteristicas,
                ];
            }
        }

        // Generar PDF
        $pdf = Pdf::loadView('frontend.factura-pdf', compact('factura'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('factura-' . $factura['id'] . '.pdf');
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

    public function volverAPedir($id)
    {
        $user = Auth::user();
        
        try {
            $compra = Compra::where('ID_Compras', $id)
                ->where('ID_Usuario', $user->id)
                ->with(['detalles.producto'])
                ->firstOrFail();

            // Verificar que el pedido existe
            if (!$compra) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pedido no encontrado'
                ]);
            }

            // Obtener o crear carrito del usuario
            $carrito = Carrito::where('ID_Usuario', $user->id)
                ->where('Estado', 'activo')
                ->first();

            if (!$carrito) {
                $carrito = Carrito::create([
                    'ID_Usuario' => $user->id,
                    'Fecha_Creacion' => now(),
                    'Estado' => 'activo'
                ]);
            } else {
                // Limpiar detalles del carrito actual
                DetalleCarrito::where('ID_Carrito', $carrito->ID_Carrito)->delete();
            }

            // Agregar productos del pedido al carrito
            $productosAgregados = 0;
            $productosNoDisponibles = [];

            foreach ($compra->detalles as $detalle) {
                if ($detalle->producto) {
                    $producto = $detalle->producto;
                    
                    // Verificar disponibilidad
                    if ($producto->Stock >= $detalle->Cantidad) {
                        // Crear detalle en el carrito
                        DetalleCarrito::create([
                            'ID_Carrito' => $carrito->ID_Carrito,
                            'ID_Producto' => $producto->ID_Producto,
                            'Cantidad' => $detalle->Cantidad
                        ]);
                        $productosAgregados++;
                    } else {
                        $productosNoDisponibles[] = [
                            'nombre' => $producto->Nombre,
                            'solicitado' => $detalle->Cantidad,
                            'disponible' => $producto->Stock
                        ];
                    }
                }
            }

            // Preparar mensaje de respuesta
            $mensaje = "Se agregaron {$productosAgregados} productos al carrito.";
            
            if (!empty($productosNoDisponibles)) {
                $mensaje .= " Algunos productos no están disponibles en la cantidad solicitada: ";
                foreach ($productosNoDisponibles as $producto) {
                    $mensaje .= "{$producto['nombre']} (solicitado: {$producto['solicitado']}, disponible: {$producto['disponible']}), ";
                }
                $mensaje = rtrim($mensaje, ', ');
            }

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'productos_agregados' => $productosAgregados,
                'productos_no_disponibles' => $productosNoDisponibles,
                'redirect_url' => route('checkout.informacion')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ]);
        }
    }
}
