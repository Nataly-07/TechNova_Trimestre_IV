<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Carrito;
use App\Models\DetalleCarrito;
use App\Models\Producto;
use App\Models\Productos;
use App\Models\Caracteristica;
use App\Models\MedioPago;
use App\Models\Pago;
use App\Models\Usuario;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\UserPaymentMethod;

class CheckoutController extends Controller
{
    /**
     * Paso 1: Información del usuario (ver/editar)
     */
    public function informacion(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        $carrito = $user->carrito;
        if (!$carrito || $carrito->detalles()->count() === 0) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío');
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'required|string|max:50',
                'document_type' => 'required|string|max:50',
                'document_number' => 'required|string|max:100|unique:users,document_number,' . $user->id,
            ]);

            // Guardar cambios básicos en el perfil
            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->document_type = $validated['document_type'];
            $user->document_number = $validated['document_number'];
            $user->save();

            return redirect()->route('checkout.direccion');
        }

        $productos = $carrito->detalles()->with('producto.caracteristicas')->get();
        $total = $this->calcularTotal($productos);

        return view('frontend.checkout.informacion', compact('user', 'productos', 'total'));
    }

    /**
     * Paso 2: Dirección de envío
     */
    public function direccion(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        $carrito = $user->carrito;
        if (!$carrito || $carrito->detalles()->count() === 0) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío');
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'departamento' => 'required|string|max:100',
                'ciudad' => 'required|string|max:100',
                'direccion' => 'required|string|max:255',
                'localidad' => 'nullable|string|max:100',
                'barrio' => 'nullable|string|max:100',
            ]);

            // Guardar en sesión de checkout
            $checkout = session('checkout', []);
            $checkout['direccion'] = $validated;
            session(['checkout' => $checkout]);

            // Persistir dirección básica en el perfil (campo address existente)
            $user->address = $validated['direccion'];
            $user->save();

            return redirect()->route('checkout.envio');
        }

        $productos = $carrito->detalles()->with('producto.caracteristicas')->get();
        $total = $this->calcularTotal($productos);
        $direccionActual = session('checkout.direccion', []);

        return view('frontend.checkout.direccion', compact('productos', 'total', 'direccionActual'));
    }

    /**
     * Paso 3: Método de envío
     */
    public function envio(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        $carrito = $user->carrito;
        if (!$carrito || $carrito->detalles()->count() === 0) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío');
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'transportadora' => 'required|string|max:100',
                'fecha_envio' => 'required|date',
            ]);

            $checkout = session('checkout', []);
            $checkout['envio'] = $validated;
            session(['checkout' => $checkout]);

            return redirect()->route('checkout.pago');
        }

        $productos = $carrito->detalles()->with('producto.caracteristicas')->get();
        $total = $this->calcularTotal($productos);
        $direccion = session('checkout.direccion');

        return view('frontend.checkout.envio', compact('productos', 'total', 'direccion'));
    }

    /**
     * Paso 4: Forma de pago
     */
    public function pago(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        $carrito = $user->carrito;
        if (!$carrito || $carrito->detalles()->count() === 0) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío');
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'metodo_pago' => 'required|string|in:tarjeta_credito,tarjeta_debito,pse,nequi,transferencia_bancaria,efectivo',
                'datos_pago' => 'nullable|array',
                'guardar_tarjeta' => 'nullable|boolean',
                'saved_payment_method_id' => 'nullable|integer',
            ]);

            // Si selecciona una tarjeta guardada, no se requieren nuevos datos de tarjeta
            if (!empty($validated['saved_payment_method_id'])) {
                $saved = UserPaymentMethod::where('user_id', $user->id)
                    ->where('id', $validated['saved_payment_method_id'])
                    ->first();
                if (!$saved) {
                    return back()->with('error', 'Método de pago guardado inválido');
                }
            } else {
                // Si el método es tarjeta y no eligió guardada, requerir campos básicos
                if (in_array($validated['metodo_pago'], ['tarjeta_credito', 'tarjeta_debito'])) {
                    $request->validate([
                        'datos_pago.numero' => 'required|string|min:12',
                        'datos_pago.nombre' => 'required|string',
                        'datos_pago.apellido' => 'required|string',
                        'datos_pago.exp_mes' => 'required|digits_between:1,2',
                        'datos_pago.exp_anio' => 'required|digits:4',
                        'datos_pago.cvc' => 'required|digits_between:3,4',
                        'datos_pago.email' => 'required|email',
                        'datos_pago.telefono' => 'required|string',
                        'datos_pago.cuotas' => 'required|integer|in:1,3,6,12',
                    ]);
                }
            }

            $checkout = session('checkout', []);
            $checkout['pago'] = $validated;
            session(['checkout' => $checkout]);

            // Guardar tarjeta en perfil si aplica (simulación básica sin pasarela real)
            if (empty($validated['saved_payment_method_id'])
                && in_array($validated['metodo_pago'], ['tarjeta_credito', 'tarjeta_debito'])
                && ($validated['guardar_tarjeta'] ?? false)
                && isset($validated['datos_pago']['numero'])) {
                $numero = preg_replace('/\D+/', '', $validated['datos_pago']['numero']);
                $last4 = substr($numero, -4);
                UserPaymentMethod::create([
                    'user_id' => $user->id,
                    'brand' => $validated['metodo_pago'] === 'tarjeta_credito' ? 'Crédito' : 'Débito',
                    'last4' => $last4,
                    'holder_name' => $validated['datos_pago']['nombre'] ?? null,
                    'token' => null,
                    'exp_month' => $validated['datos_pago']['exp_mes'] ?? null,
                    'exp_year' => $validated['datos_pago']['exp_anio'] ?? null,
                    'email' => $validated['datos_pago']['email'] ?? null,
                    'phone' => $validated['datos_pago']['telefono'] ?? null,
                    'installments' => isset($validated['datos_pago']['cuotas']) ? (int)$validated['datos_pago']['cuotas'] : null,
                ]);
            }

            return redirect()->route('checkout.revision');
        }

        $productos = $carrito->detalles()->with('producto.caracteristicas')->get();
        $total = $this->calcularTotal($productos);
        $metodosDisponibles = MedioPago::getMetodosDisponibles();
        try {
            $savedPaymentMethods = UserPaymentMethod::where('user_id', $user->id)->get();
        } catch (\Throwable $e) {
            $savedPaymentMethods = collect();
        }

        return view('frontend.checkout.pago', compact('productos', 'total', 'metodosDisponibles', 'savedPaymentMethods'));
    }

    /**
     * Paso 5: Revisión y finalizar compra
     */
    public function revision()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        $carrito = $user->carrito;
        if (!$carrito || $carrito->detalles()->count() === 0) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío');
        }

        $productos = $carrito->detalles()->with('producto.caracteristicas')->get();
        $total = $this->calcularTotal($productos);
        $checkout = session('checkout', []);

        // Preparar resumen de pago (tarjeta enmascarada si aplica)
        $pagoResumen = null;
        if (!empty($checkout['pago']['metodo_pago'])) {
            $metodo = $checkout['pago']['metodo_pago'];
            if (!empty($checkout['pago']['saved_payment_method_id'])) {
                $pm = UserPaymentMethod::where('user_id', $user->id)
                    ->where('id', $checkout['pago']['saved_payment_method_id'])
                    ->first();
                if ($pm) {
                    $pagoResumen = ($metodo === 'tarjeta_credito' ? 'Tarjeta de Crédito' : ($metodo === 'tarjeta_debito' ? 'Tarjeta de Débito' : ucfirst(str_replace('_',' ',$metodo))))
                        . ' **** ' . $pm->last4;
                }
            } elseif (in_array($metodo, ['tarjeta_credito','tarjeta_debito']) && !empty($checkout['pago']['datos_pago']['numero'])) {
                $numero = preg_replace('/\D+/', '', $checkout['pago']['datos_pago']['numero']);
                $last4 = substr($numero, -4);
                $pagoResumen = ($metodo === 'tarjeta_credito' ? 'Tarjeta de Crédito' : 'Tarjeta de Débito') . ' **** ' . $last4;
            } else {
                $map = MedioPago::getMetodosDisponibles();
                $pagoResumen = $map[$metodo] ?? ucfirst(str_replace('_',' ',$metodo));
            }
        }

        return view('frontend.checkout.revision', [
            'productos' => $productos,
            'total' => $total,
            'usuario' => $user,
            'direccion' => $checkout['direccion'] ?? null,
            'envio' => $checkout['envio'] ?? null,
            'pago' => $checkout['pago'] ?? null,
            'pagoResumen' => $pagoResumen,
        ]);
    }

    /**
     * Finalizar la compra: crea registros y descuenta stock
     */
    public function finalizar(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('frontend.login');
        }

        $carrito = $user->carrito;
        if (!$carrito || $carrito->detalles()->count() === 0) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío');
        }

        $checkout = session('checkout', []);
        if (!isset($checkout['pago']['metodo_pago'])) {
            return redirect()->route('checkout.pago')->with('error', 'Selecciona un método de pago');
        }

        try {
            DB::beginTransaction();

            $productos = $carrito->detalles()->with('producto.caracteristicas')->lockForUpdate()->get();
            $total = $this->calcularTotal($productos);

            // Verificar stock
            foreach ($productos as $detalle) {
                if ($detalle->producto->Stock < $detalle->Cantidad) {
                    throw new \Exception('Stock insuficiente para: ' . $detalle->producto->Nombre);
                }
            }

            // Crear registro de pago
            $pago = Pago::create([
                'Fecha_Pago' => now()->toDateString(),
                'Numero_Factura' => 'FAC-' . time() . '-' . $user->id,
                'Fecha_Factura' => now()->toDateString(),
                'Monto' => $total,
                'Estado_Pago' => 'procesado',
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

            // Registrar medio de pago
            $medioPago = MedioPago::create([
                'ID_Pagos' => $pago->ID_Pagos,
                'ID_DetalleVentas' => $detalleVenta->ID_DetalleVentas,
                'ID_Usuario' => $user->id,
                'Metodo_pago' => $checkout['pago']['metodo_pago'],
                'Fecha_De_Compra' => now(),
                'Tiempo_De_Entrega' => now()->addDays(3),
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
                'Estado' => 'procesado',
            ]);

            // Crear detalles y descontar stock
            foreach ($productos as $detalle) {
                $productoLegacy = $productosLegacy[$detalle->ID_Producto];
                DetalleCompra::create([
                    'ID_Compras' => $compra->ID_Compras,
                    'ID_Producto' => $productoLegacy->ID_Producto, // Usar el producto de la tabla productos
                    'Cantidad' => $detalle->Cantidad,
                    'Precio' => $detalle->producto->caracteristicas->Precio_Venta,
                ]);

                // Descontar stock e incrementar salida
                $producto = $detalle->producto;
                $producto->Stock = max(0, $producto->Stock - $detalle->Cantidad);
                $producto->Salida = ($producto->Salida ?? 0) + $detalle->Cantidad;
                $producto->save();
            }

            // Vaciar carrito
            $carrito->detalles()->delete();

            // Limpiar sesión
            session()->forget('checkout');

            DB::commit();

            return redirect()->route('mensaje.confirmacion');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('checkout.revision')->with('error', 'No fue posible completar la compra: ' . $e->getMessage());
        }
    }

    private function calcularTotal($detalles)
    {
        $total = 0;
        foreach ($detalles as $detalle) {
            $total += ($detalle->producto->caracteristicas->Precio_Venta ?? 0) * $detalle->Cantidad;
        }
        return $total;
    }
}


