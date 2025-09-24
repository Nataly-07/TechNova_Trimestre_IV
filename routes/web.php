<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\MedioPagoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AtencionClienteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\AuthController;

use App\Models\Producto;

// Incluir rutas de autenticación
require __DIR__.'/auth.php';

// Rutas públicas del catálogo (sin autenticación)
Route::get('/', [CatalogoController::class, 'index'])->name('index');

// Rutas específicas de categorías
Route::get('/celulares', function() {
    return app(CatalogoController::class)->categoria('celulares');
})->name('celulares');

Route::get('/portatiles', function() {
    return app(CatalogoController::class)->categoria('portatiles');
})->name('portatiles');

// Rutas específicas de marcas
Route::get('/marca/apple', function() {
    return app(CatalogoController::class)->marca('apple');
})->name('marca.apple');

Route::get('/marca/samsung', function() {
    return app(CatalogoController::class)->marca('samsung');
})->name('marca.samsung');

Route::get('/marca/motorola', function() {
    return app(CatalogoController::class)->marca('motorola');
})->name('marca.motorola');

Route::get('/marca/xiaomi', function() {
    return app(CatalogoController::class)->marca('xiaomi');
})->name('marca.xiaomi');

Route::get('/marca/oppo', function() {
    return app(CatalogoController::class)->marca('oppo');
})->name('marca.oppo');

Route::get('/marca/lenovo', function() {
    return app(CatalogoController::class)->marca('lenovo');
})->name('marca.lenovo');

// Rutas genéricas (para compatibilidad)
Route::get('/categoria/{categoria}', [CatalogoController::class, 'categoria'])->name('categoria');
Route::get('/marca/{marca}', [CatalogoController::class, 'marca'])->name('marca');

// Ruta autenticada del catálogo (solo para clientes)
Route::middleware(['auth', \App\Http\Middleware\ClienteMiddleware::class])->group(function () {
    Route::get('/catalogo-autenticado', [CatalogoController::class, 'catalogoAutenticado'])->name('catalogo.autenticado');
    Route::get('/buscar', [CatalogoController::class, 'buscar'])->name('buscar');
    
    // Rutas autenticadas de categorías
    Route::get('/auth/celulares', function() {
        return app(CatalogoController::class)->categoriaAutenticada('celulares');
    })->name('auth.celulares');
    
    Route::get('/auth/portatiles', function() {
        return app(CatalogoController::class)->categoriaAutenticada('portatiles');
    })->name('auth.portatiles');
    
    // Rutas autenticadas de marcas
    Route::get('/auth/marca/apple', function() {
        return app(CatalogoController::class)->marcaAutenticada('apple');
    })->name('auth.marca.apple');
    
    Route::get('/auth/marca/samsung', function() {
        return app(CatalogoController::class)->marcaAutenticada('samsung');
    })->name('auth.marca.samsung');
    
    Route::get('/auth/marca/motorola', function() {
        return app(CatalogoController::class)->marcaAutenticada('motorola');
    })->name('auth.marca.motorola');
    
    Route::get('/auth/marca/xiaomi', function() {
        return app(CatalogoController::class)->marcaAutenticada('xiaomi');
    })->name('auth.marca.xiaomi');
    
    Route::get('/auth/marca/oppo', function() {
        return app(CatalogoController::class)->marcaAutenticada('oppo');
    })->name('auth.marca.oppo');
    
    Route::get('/auth/marca/lenovo', function() {
        return app(CatalogoController::class)->marcaAutenticada('lenovo');
    })->name('auth.marca.lenovo');
    
    // Rutas genéricas autenticadas
    Route::get('/auth/categoria/{categoria}', [CatalogoController::class, 'categoriaAutenticada'])->name('auth.categoria');
    Route::get('/auth/marca/{marca}', [CatalogoController::class, 'marcaAutenticada'])->name('auth.marca');
    
    // Ruta para detalles del producto
    Route::get('/producto/{id}/detalles', [CatalogoController::class, 'mostrarDetalles'])->name('producto.detalles');
});

// Rutas de login y registro frontend
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/iniciosesion', [AuthController::class, 'showLoginForm'])->name('frontend.login');
Route::post('/iniciosesion', [AuthController::class, 'login'])->name('frontend.login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/creacioncuenta', [AuthController::class, 'showRegisterForm'])->name('frontend.register');
Route::post('/creacioncuenta', [AuthController::class, 'register'])->name('frontend.register.submit');

// Ruta de prueba para la búsqueda
Route::get('/test-search', function () {
    return view('frontend.test-search');
});

// Ruta de logout (debe estar fuera de middleware para funcionar)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de favoritos (solo para clientes)
Route::middleware(['auth', \App\Http\Middleware\ClienteMiddleware::class])->group(function () {
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
    Route::post('/favoritos/{productoId}/toggle', [FavoritoController::class, 'toggle'])->name('favoritos.toggle');
    Route::post('/favoritos/{productoId}/agregar', [FavoritoController::class, 'agregar'])->name('favoritos.agregar');
    Route::delete('/favoritos/{productoId}/quitar', [FavoritoController::class, 'quitar'])->name('favoritos.quitar');
    Route::get('/favoritos/{productoId}/verificar', [FavoritoController::class, 'verificar'])->name('favoritos.verificar');
    
    // Rutas del carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{productoId}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::put('/carrito/actualizar/{detalleId}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/eliminar/{detalleId}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::delete('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
    
    // Pasarela de pagos (Checkout de 5 pasos)
    Route::match(['get', 'post'], '/checkout/informacion', [CheckoutController::class, 'informacion'])->name('checkout.informacion');
    Route::match(['get', 'post'], '/checkout/direccion', [CheckoutController::class, 'direccion'])->name('checkout.direccion');
    Route::match(['get', 'post'], '/checkout/envio', [CheckoutController::class, 'envio'])->name('checkout.envio');
    Route::match(['get', 'post'], '/checkout/pago', [CheckoutController::class, 'pago'])->name('checkout.pago');
    Route::get('/checkout/revision', [CheckoutController::class, 'revision'])->name('checkout.revision');
    Route::post('/checkout/finalizar', [CheckoutController::class, 'finalizar'])->name('checkout.finalizar');

    // Rutas de medios de pago
    Route::get('/medios-pago', [MedioPagoController::class, 'index'])->name('medios-pago.index');
    Route::post('/compras/procesar', [MedioPagoController::class, 'procesarPago'])->name('compras.procesar');
    
    
    // Rutas de gestión de compras del cliente
    Route::get('/cliente/mis-compras', [\App\Http\Controllers\ClienteComprasController::class, 'index'])->name('cliente.mis-compras.index');
    Route::get('/cliente/mis-compras/{id}', [\App\Http\Controllers\ClienteComprasController::class, 'show'])->name('cliente.mis-compras.show');
    Route::get('/cliente/mis-compras/estadisticas', [\App\Http\Controllers\ClienteComprasController::class, 'estadisticas'])->name('cliente.mis-compras.estadisticas');
    
    // Ruta de compatibilidad para la URL antigua
    Route::get('/mediopagos', function() {
        return redirect()->route('cliente.medios-pago.index');
    });
    
    // Ruta de compatibilidad para mis compras
    Route::get('/miscompras', function() {
        return redirect()->route('cliente.mis-compras.index');
    });
    
    // Rutas de compras
    Route::get('/compras', [CompraController::class, 'index'])->name('compras.index');
    Route::get('/compras/{id}', [CompraController::class, 'show'])->name('compras.show');
    Route::get('/mensaje-confirmacion', function() {
        return view('frontend.mensaje-confirmacion');
    })->name('mensaje.confirmacion');
    
        // Rutas de pedidos del cliente
        Route::get('/pedidoscli', [\App\Http\Controllers\PedidosClienteController::class, 'index'])->name('pedidoscli');
        Route::get('/pedidoscli/{id}', [\App\Http\Controllers\PedidosClienteController::class, 'show'])->name('pedidoscli.show');
        Route::get('/pedidoscli/{id}/factura', [\App\Http\Controllers\PedidosClienteController::class, 'factura'])->name('pedidoscli.factura');
        Route::get('/pedidoscli/{id}/factura/pdf', [\App\Http\Controllers\PedidosClienteController::class, 'facturaPDF'])->name('pedidoscli.factura.pdf');
        Route::post('/pedidoscli/{id}/cancelar', [\App\Http\Controllers\PedidosClienteController::class, 'cancelar'])->name('pedidoscli.cancelar');
        Route::post('/pedidoscli/{id}/volver-a-pedir', [\App\Http\Controllers\PedidosClienteController::class, 'volverAPedir'])->name('pedidoscli.volver-a-pedir');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('perfilad');
        } elseif ($user && $user->role === 'empleado') {
            return redirect()->route('perfilemp');
        } else {
            return redirect()->route('perfillcli');
        }
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas solo para administradores
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Rutas para usuarios (solo admin)
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    // Rutas para productos (solo admin)
    Route::get('/productos', [\App\Http\Controllers\ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/create', [\App\Http\Controllers\ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [\App\Http\Controllers\ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/edit', [\App\Http\Controllers\ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [\App\Http\Controllers\ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [\App\Http\Controllers\ProductoController::class, 'destroy'])->name('productos.destroy');

    // Rutas para proveedores
    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/proveedores/create', [ProveedorController::class, 'create'])->name('proveedores.create');
    Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store');
    Route::get('/proveedores/{id}/edit', [ProveedorController::class, 'edit'])->name('proveedores.edit');
    Route::put('/proveedores/{id}', [ProveedorController::class, 'update'])->name('proveedores.update');
    Route::delete('/proveedores/{id}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');

    // Rutas para reportes (solo admin)
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/productos', [ReporteController::class, 'productos'])->name('reportes.productos');
    Route::get('/reportes/usuarios', [ReporteController::class, 'usuarios'])->name('reportes.usuarios');
    Route::get('/reportes/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
    Route::get('/reportes/filtros', [ReporteController::class, 'getFiltros'])->name('reportes.filtros');
    Route::get('/reportes/preview-productos', [ReporteController::class, 'previewProductos'])->name('reportes.preview.productos');
    Route::get('/reportes/preview-usuarios', [ReporteController::class, 'previewUsuarios'])->name('reportes.preview.usuarios');
    Route::get('/reportes/preview-ventas', [ReporteController::class, 'previewVentas'])->name('reportes.preview.ventas');
    Route::get('/reportes/ventas/excel', [ReporteController::class, 'ventasExcel'])->name('reportes.ventas.excel');
    Route::get('/reportes/ventas/dashboard', [ReporteController::class, 'ventasDashboard'])->name('reportes.ventas.dashboard');
    
});

// Rutas para empleados
Route::middleware([\App\Http\Middleware\EmpleadoMiddleware::class])->group(function () {
    Route::get('/empleado/inventario', [EmpleadoController::class, 'inventario'])->name('empleado.inventario');
    Route::get('/empleado/usuarios-cliente', [EmpleadoController::class, 'usuariosCliente'])->name('empleado.usuarios.cliente');
    Route::get('/inventarioempleados', [EmpleadoController::class, 'inventario'])->name('inventarioempleados');
});


// Rutas para clientes
Route::middleware([\App\Http\Middleware\ClienteMiddleware::class])->group(function () {
    // Rutas de gestión de compras del cliente
    Route::get('/cliente/mis-compras', [\App\Http\Controllers\ClienteComprasController::class, 'index'])->name('cliente.mis-compras.index');
    Route::get('/cliente/mis-compras/{id}', [\App\Http\Controllers\ClienteComprasController::class, 'show'])->name('cliente.mis-compras.show');
    Route::get('/cliente/mis-compras/estadisticas', [\App\Http\Controllers\ClienteComprasController::class, 'estadisticas'])->name('cliente.mis-compras.estadisticas');
});

// Rutas de perfiles específicas por rol
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/perfilad', [UserController::class, 'perfilad'])->name('perfilad');
    
    // Dashboard del administrador
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/stats', [\App\Http\Controllers\AdminDashboardController::class, 'getStatsData'])->name('admin.dashboard.stats');
    
    // Gestión de pedidos
    Route::get('/admin/orders', [\App\Http\Controllers\AdminOrdersController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{id}', [\App\Http\Controllers\AdminOrdersController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{id}/status', [\App\Http\Controllers\AdminOrdersController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::delete('/admin/orders/{id}', [\App\Http\Controllers\AdminOrdersController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('/admin/orders/stats', [\App\Http\Controllers\AdminOrdersController::class, 'getOrdersStats'])->name('admin.orders.stats');
    
    // Gestión de pagos
    Route::get('/admin/payments', [\App\Http\Controllers\AdminPaymentsController::class, 'index'])->name('admin.payments.index');
    Route::get('/admin/payments/{id}', [\App\Http\Controllers\AdminPaymentsController::class, 'show'])->name('admin.payments.show');
    Route::put('/admin/payments/{id}/status', [\App\Http\Controllers\AdminPaymentsController::class, 'updateStatus'])->name('admin.payments.update-status');
    Route::delete('/admin/payments/{id}', [\App\Http\Controllers\AdminPaymentsController::class, 'destroy'])->name('admin.payments.destroy');
    Route::get('/admin/payments/stats', [\App\Http\Controllers\AdminPaymentsController::class, 'getPaymentsStats'])->name('admin.payments.stats');
    Route::get('/admin/payments/monthly', [\App\Http\Controllers\AdminPaymentsController::class, 'getMonthlyPayments'])->name('admin.payments.monthly');
    
    // Rutas de mensajes del administrador
    Route::get('/admin/mensajes', [\App\Http\Controllers\MensajeAdministradorController::class, 'index'])->name('admin.mensajes.index');
    Route::get('/admin/mensajes/{id}', [\App\Http\Controllers\MensajeAdministradorController::class, 'show'])->name('admin.mensajes.show');
    Route::post('/admin/mensajes/{id}/marcar-leido', [\App\Http\Controllers\MensajeAdministradorController::class, 'marcarComoLeido'])->name('admin.mensajes.marcar-leido');
    Route::post('/admin/mensajes/marcar-todos-leidos', [\App\Http\Controllers\MensajeAdministradorController::class, 'marcarTodosComoLeidos'])->name('admin.mensajes.marcar-todos-leidos');
    Route::post('/admin/mensajes/enviar', [\App\Http\Controllers\MensajeAdministradorController::class, 'enviar'])->name('admin.mensajes.enviar');
    Route::post('/admin/mensajes/{id}/responder', [\App\Http\Controllers\MensajeAdministradorController::class, 'responder'])->name('admin.mensajes.responder');
    Route::get('/admin/mensajes-filtrar', [\App\Http\Controllers\MensajeAdministradorController::class, 'filtrar'])->name('admin.mensajes.filtrar');
    Route::get('/admin/conversaciones-empleados', [\App\Http\Controllers\MensajeAdministradorController::class, 'conversacionesEmpleados'])->name('admin.conversaciones.empleados');
});

Route::middleware(['auth', \App\Http\Middleware\EmpleadoMiddleware::class])->group(function () {
    Route::get('/perfilemp', [\App\Http\Controllers\UserController::class, 'perfilEmpleado'])->name('perfilemp');
    Route::view('/perfilep', 'frontend.perfilep')->name('perfilep');
    
    // Rutas de atención al cliente para empleados
    Route::get('/empleado/atencion-cliente', [\App\Http\Controllers\AtencionClienteEmpleadoController::class, 'index'])->name('empleado.atencion-cliente.index');
    Route::get('/empleado/atencion-cliente/consultas/{id}', [\App\Http\Controllers\AtencionClienteEmpleadoController::class, 'showConsulta'])->name('empleado.atencion-cliente.consultas.show');
    Route::post('/empleado/atencion-cliente/consultas/{id}/responder', [\App\Http\Controllers\AtencionClienteEmpleadoController::class, 'responderConsulta'])->name('empleado.atencion-cliente.consultas.responder');
    Route::post('/empleado/atencion-cliente/consultas/{id}/estado', [\App\Http\Controllers\AtencionClienteEmpleadoController::class, 'actualizarEstadoConsulta'])->name('empleado.atencion-cliente.consultas.estado');
            Route::get('/empleado/atencion-cliente/mensajes/{id}', [\App\Http\Controllers\AtencionClienteEmpleadoController::class, 'showMensaje'])->name('empleado.atencion-cliente.mensajes.show');
            Route::post('/empleado/atencion-cliente/mensajes/{id}/responder', [\App\Http\Controllers\AtencionClienteEmpleadoController::class, 'responderMensaje'])->name('empleado.atencion-cliente.mensajes.responder');
            Route::get('/empleado/atencion-cliente/filtrar-consultas', [\App\Http\Controllers\AtencionClienteEmpleadoController::class, 'filtrarConsultas'])->name('empleado.atencion-cliente.filtrar-consultas');
            Route::get('/empleado/atencion-cliente/filtrar-mensajes', [\App\Http\Controllers\AtencionClienteEmpleadoController::class, 'filtrarMensajes'])->name('empleado.atencion-cliente.filtrar-mensajes');
            Route::get('/empleado/atencion-cliente/conversacion/{conversationId}', [\App\Http\Controllers\AtencionClienteEmpleadoController::class, 'getConversation'])->name('empleado.atencion-cliente.conversacion');
            Route::post('/empleado/atencion-cliente/mensajes/{id}/responder-conversacion', [\App\Http\Controllers\AtencionClienteEmpleadoController::class, 'replyToMessage'])->name('empleado.atencion-cliente.mensajes.responder-conversacion');
});

Route::middleware(['auth', \App\Http\Middleware\ClienteMiddleware::class])->group(function () {
    Route::get('/perfillcli', [UserController::class, 'perfilCliente'])->name('perfillcli');
});

// Rutas de gestión de perfil (accesibles para todos los usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    // Rutas para formularios de autenticación personalizados
    Route::get('/registro', function() {
        return view('frontend.registro');
    })->name('frontend.registro');

    // Rutas para gestión de perfil
    Route::get('/perfil/edit', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil/update', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/perfil/delete', [PerfilController::class, 'confirmDelete'])->name('perfil.delete');
    Route::delete('/perfil/destroy', [PerfilController::class, 'destroy'])->name('perfil.destroy');
});

// Rutas de empleados
Route::middleware(['auth', \App\Http\Middleware\EmpleadoMiddleware::class])->group(function () {
    Route::get('/inventario', [\App\Http\Controllers\InventarioController::class, 'index'])->name('inventario.index');
    
    // Rutas de mensajes de empleados
    Route::get('/empleado/mensajes', [\App\Http\Controllers\MensajeEmpleadoController::class, 'index'])->name('empleado.mensajes.index');
    Route::get('/empleado/mensajes/{id}', [\App\Http\Controllers\MensajeEmpleadoController::class, 'show'])->name('empleado.mensajes.show');
    Route::post('/empleado/mensajes/{id}/marcar-leido', [\App\Http\Controllers\MensajeEmpleadoController::class, 'marcarComoLeido'])->name('empleado.mensajes.marcar-leido');
    Route::post('/empleado/mensajes/marcar-todos-leidos', [\App\Http\Controllers\MensajeEmpleadoController::class, 'marcarTodosComoLeidos'])->name('empleado.mensajes.marcar-todos-leidos');
    Route::post('/empleado/mensajes/{id}/responder', [\App\Http\Controllers\MensajeEmpleadoController::class, 'responder'])->name('empleado.mensajes.responder');
    Route::get('/empleado/mensajes-filtrar', [\App\Http\Controllers\MensajeEmpleadoController::class, 'filtrar'])->name('empleado.mensajes.filtrar');
});

// Rutas de compatibilidad para URLs antiguas (solo para clientes)
Route::middleware(['auth', \App\Http\Middleware\ClienteMiddleware::class])->group(function () {
    // Ruta de compatibilidad para mis compras
    Route::get('/miscompras', function() {
        return redirect()->route('cliente.mis-compras.index');
    });
    
    // Ruta de compatibilidad para la URL antigua
    Route::get('/mediopagos', function() {
        return redirect()->route('cliente.medios-pago.index');
    });
    
    // Rutas de atención al cliente (solo para clientes)
    Route::get('/atencion-cliente', [AtencionClienteController::class, 'index'])->name('atencion-cliente.index');
    Route::post('/atencion-cliente', [AtencionClienteController::class, 'store'])->name('atencion-cliente.store');
    Route::post('/atencion-cliente/{id}/responder', [AtencionClienteController::class, 'responder'])->name('atencion-cliente.responder');
    
    // Rutas de mensajes directos integradas en atención al cliente
    Route::post('/atencion-cliente/mensajes', [AtencionClienteController::class, 'storeMensaje'])->name('atencion-cliente.mensajes.store');
    Route::get('/atencion-cliente/mensajes/{id}', [AtencionClienteController::class, 'showMensaje'])->name('atencion-cliente.mensajes.show');
    Route::get('/atencion-cliente/conversacion/{conversationId}', [AtencionClienteController::class, 'getConversation'])->name('atencion-cliente.conversacion');
    Route::post('/atencion-cliente/mensajes/{id}/responder', [AtencionClienteController::class, 'replyToMessage'])->name('atencion-cliente.mensajes.responder');
    
    // Ruta de prueba para verificar autenticación
    Route::get('/atencion-cliente/debug', function() {
        $user = Auth::user();
        $mensajes = \App\Models\MensajeDirecto::where('user_id', $user->id)->get();
        return response()->json([
            'user' => $user ? $user->toArray() : null,
            'mensajes_count' => $mensajes->count(),
            'mensajes' => $mensajes->toArray()
        ]);
    })->name('atencion-cliente.debug');
    
        // Rutas de notificaciones (solo para clientes)
        Route::get('/notificaciones', [\App\Http\Controllers\NotificacionesController::class, 'index'])->name('notificaciones.index');
        Route::post('/notificaciones/{id}/marcar-leida', [\App\Http\Controllers\NotificacionesController::class, 'marcarComoLeida'])->name('notificaciones.marcar-leida');
        Route::post('/notificaciones/{id}/marcar-no-leida', [\App\Http\Controllers\NotificacionesController::class, 'marcarComoNoLeida'])->name('notificaciones.marcar-no-leida');
        Route::post('/notificaciones/marcar-todas-leidas', [\App\Http\Controllers\NotificacionesController::class, 'marcarTodasComoLeidas'])->name('notificaciones.marcar-todas-leidas');
        Route::get('/notificaciones-filtrar', [\App\Http\Controllers\NotificacionesController::class, 'filtrar'])->name('notificaciones.filtrar');
    
    // Ruta de compatibilidad para la URL antigua
    Route::get('/atencion', function() {
        return redirect()->route('atencion-cliente.index');
    });
});

// Ruta de atención al cliente accesible sin autenticación (con funcionalidad limitada)
Route::get('/atencion-publica', [AtencionClienteController::class, 'indexPublico'])->name('atencion-cliente.publico');

