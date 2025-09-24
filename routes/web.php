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
    
    // Rutas de gestión de medios de pago del cliente
    Route::get('/cliente/medios-pago', [\App\Http\Controllers\ClienteMediosPagoController::class, 'index'])->name('cliente.medios-pago.index');
    Route::post('/cliente/medios-pago', [\App\Http\Controllers\ClienteMediosPagoController::class, 'store'])->name('cliente.medios-pago.store');
    Route::delete('/cliente/medios-pago/{id}', [\App\Http\Controllers\ClienteMediosPagoController::class, 'destroy'])->name('cliente.medios-pago.destroy');
    Route::post('/cliente/medios-pago/{id}/default', [\App\Http\Controllers\ClienteMediosPagoController::class, 'setDefault'])->name('cliente.medios-pago.default');
    
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
    // Rutas de gestión de medios de pago del cliente
    Route::get('/cliente/medios-pago', [\App\Http\Controllers\ClienteMediosPagoController::class, 'index'])->name('cliente.medios-pago.index');
    Route::post('/cliente/medios-pago', [\App\Http\Controllers\ClienteMediosPagoController::class, 'store'])->name('cliente.medios-pago.store');
    Route::delete('/cliente/medios-pago/{id}', [\App\Http\Controllers\ClienteMediosPagoController::class, 'destroy'])->name('cliente.medios-pago.destroy');
    Route::post('/cliente/medios-pago/{id}/default', [\App\Http\Controllers\ClienteMediosPagoController::class, 'setDefault'])->name('cliente.medios-pago.default');
    
    // Rutas de gestión de compras del cliente
    Route::get('/cliente/mis-compras', [\App\Http\Controllers\ClienteComprasController::class, 'index'])->name('cliente.mis-compras.index');
    Route::get('/cliente/mis-compras/{id}', [\App\Http\Controllers\ClienteComprasController::class, 'show'])->name('cliente.mis-compras.show');
    Route::get('/cliente/mis-compras/estadisticas', [\App\Http\Controllers\ClienteComprasController::class, 'estadisticas'])->name('cliente.mis-compras.estadisticas');
});

// Rutas de perfiles específicas por rol
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/perfilad', [UserController::class, 'perfilad'])->name('perfilad');
});

Route::middleware(['auth', \App\Http\Middleware\EmpleadoMiddleware::class])->group(function () {
    Route::get('/perfilemp', [\App\Http\Controllers\UserController::class, 'perfilEmpleado'])->name('perfilemp');
    Route::view('/perfilep', 'frontend.perfilep')->name('perfilep');
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

// Rutas de inventario (solo para empleados)
Route::middleware(['auth', \App\Http\Middleware\EmpleadoMiddleware::class])->group(function () {
    Route::get('/inventario', [\App\Http\Controllers\InventarioController::class, 'index'])->name('inventario.index');
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
    
    // Ruta de compatibilidad para la URL antigua
    Route::get('/atencion', function() {
        return redirect()->route('atencion-cliente.index');
    });
});

// Ruta de atención al cliente accesible sin autenticación (con funcionalidad limitada)
Route::get('/atencion-publica', [AtencionClienteController::class, 'indexPublico'])->name('atencion-cliente.publico');

