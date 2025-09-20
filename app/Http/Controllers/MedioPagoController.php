<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedioPago;
use App\Models\Pago;
use App\Models\Usuario;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Productos;
use App\Models\Caracteristica;
use App\Models\Carrito;
use App\Models\DetalleCarrito;
use App\Models\Compra;
use App\Models\DetalleCompra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedioPagoController extends Controller
{
    /**
     * Mostrar la página de medios de pago
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        // Verificar que el usuario tenga productos en el carrito
        $carrito = $user->carrito;
        if (!$carrito || $carrito->detalles()->count() == 0) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío');
        }

        $productos = $carrito->detalles()->with('producto.caracteristicas')->get();
        
        $total = 0;
        foreach ($productos as $detalle) {
            $total += $detalle->producto->caracteristicas->Precio_Venta * $detalle->Cantidad;
        }

        $metodosDisponibles = MedioPago::getMetodosDisponibles();

        return view('frontend.medios-pago', compact('productos', 'total', 'metodosDisponibles'));
    }

    /**
     * Procesar el pago y crear la compra
     */
    public function procesarPago(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $request->validate([
            'metodo_pago' => 'required|string',
            'datos_pago' => 'required|array'
        ]);

        $carrito = $user->carrito;
        if (!$carrito || $carrito->detalles()->count() == 0) {
            return response()->json(['error' => 'Carrito vacío'], 400);
        }

        try {
            DB::beginTransaction();

            // Calcular total
            $productos = $carrito->detalles()->with('producto.caracteristicas')->get();
            $total = 0;
            foreach ($productos as $detalle) {
                $total += $detalle->producto->caracteristicas->Precio_Venta * $detalle->Cantidad;
            }

            // Crear registro de pago
            $pago = Pago::create([
                'Fecha_Pago' => now()->toDateString(),
                'Numero_Factura' => 'FAC-' . time() . '-' . $user->id,
                'Fecha_Factura' => now()->toDateString(),
                'Monto' => $total,
                'Estado_Pago' => 'pendiente',
            ]);

            // Crear o obtener usuario en la tabla usuario para satisfacer la restricción de clave foránea
            $usuario = Usuario::where('ID_Usuario', $user->id)->first();
            if (!$usuario) {
                $usuario = Usuario::create([
                    'ID_Usuario' => $user->id,
                    'Tipo_De_Documento' => $user->document_type ?? 'CC',
                    'Identificacion' => $user->document_number ?? 'N/A',
                    'Nombre' => $user->first_name ?? 'Usuario',
                    'Apellido' => $user->last_name ?? 'Sistema',
                    'Correo' => $user->email,
                    'Contraseña' => $user->password,
                    'Telefono' => $user->phone ?? '0000000000',
                    'Direccion' => $user->address ?? 'N/A',
                    'Rol' => $user->role ?? 'cliente',
                    'Fecha_De_Registro' => now()->toDateString(),
                ]);
            }

            // Crear venta dummy para satisfacer la restricción de clave foránea
            $venta = Venta::create([
                'ID_Usuario' => $usuario->ID_Usuario,
                'fecha_venta' => now()->toDateString(),
            ]);

            // Crear o obtener productos en la tabla productos para satisfacer la restricción de clave foránea
            $productosLegacy = [];
            foreach ($productos as $detalle) {
                $producto = $detalle->producto;
                
                // Verificar si el producto ya existe por ID_Producto o por Codigo
                $productoLegacy = Productos::where('ID_Producto', $producto->ID_Producto)
                    ->orWhere('Codigo', $producto->Codigo)
                    ->first();
                    
                if (!$productoLegacy) {
                    // Crear o obtener característica en la tabla caracteristica para satisfacer la restricción de clave foránea
                    $caracteristicaLegacy = Caracteristica::where('ID_Caracteristicas', $producto->ID_Caracteristicas)->first();
                    if (!$caracteristicaLegacy && $producto->caracteristicas) {
                        $caracteristicaLegacy = Caracteristica::create([
                            'ID_Caracteristicas' => $producto->caracteristicas->ID_Caracteristicas,
                            'Categoria' => $producto->caracteristicas->Categoria,
                            'Color' => $producto->caracteristicas->Color,
                            'Descripcion' => $producto->caracteristicas->Descripcion,
                            'Precio_Compra' => $producto->caracteristicas->Precio_Compra,
                            'Precio_Venta' => $producto->caracteristicas->Precio_Venta,
                            'Marca' => $producto->caracteristicas->Marca,
                        ]);
                    }
                    
                    $productoLegacy = Productos::create([
                        'ID_Producto' => $producto->ID_Producto,
                        'Codigo' => $producto->Codigo ?? 'N/A',
                        'Nombre' => $producto->Nombre ?? 'Producto',
                        'Imagen' => $producto->Imagen,
                        'ID_Caracteristicas' => $caracteristicaLegacy ? $caracteristicaLegacy->ID_Caracteristicas : null,
                        'Stock' => $producto->Stock ?? 0, // Provide default value if null
                    ]);
                }
                $productosLegacy[$producto->ID_Producto] = $productoLegacy;
            }
            
            // Usar el primer producto para el detalle de venta dummy
            $primerProducto = $productos->first();
            $productoLegacy = $productosLegacy[$primerProducto->ID_Producto];

            // Crear detalle de venta dummy
            $detalleVenta = DetalleVenta::create([
                'ID_Ventas' => $venta->ID_Ventas,
                'ID_Producto' => $productoLegacy->ID_Producto, // Usar el producto de la tabla productos
                'Cantidad' => '1', // Cantidad dummy
                'Precio' => 0.00, // Precio dummy
            ]);

            // Crear medio de pago
            $medioPago = MedioPago::create([
                'ID_Pagos' => $pago->ID_Pagos,
                'ID_DetalleVentas' => $detalleVenta->ID_DetalleVentas,
                'ID_Usuario' => $user->id,
                'Metodo_pago' => $request->metodo_pago,
                'Fecha_De_Compra' => now(),
                'Tiempo_De_Entrega' => now()->addDays(3) // 3 días por defecto
            ]);

            // Crear compra
            $compra = Compra::create([
                'ID_Proveedor' => null, // Customer purchase, no supplier
                'ID_Usuario' => $user->id,
                'ID_MedioDePago' => $medioPago->ID_MedioDePago,
                'Fecha_De_Compra' => now(),
                'Fecha_Compra' => now(),
                'Tiempo_De_Entrega' => now()->addDays(3),
                'Total' => $total,
                'Estado' => 'pendiente'
            ]);

            // Crear detalles de compra
            foreach ($productos as $detalle) {
                $productoLegacy = $productosLegacy[$detalle->ID_Producto];
                DetalleCompra::create([
                    'ID_Compras' => $compra->ID_Compras,
                    'ID_Producto' => $productoLegacy->ID_Producto, // Usar el producto de la tabla productos
                    'Cantidad' => $detalle->Cantidad,
                    'Precio' => $detalle->producto->caracteristicas->Precio_Venta
                ]);
            }

            // Vaciar carrito
            $carrito->detalles()->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'compra_id' => $compra->ID_Compras,
                'message' => 'Compra procesada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al procesar la compra: ' . $e->getMessage()], 500);
        }
    }
}
