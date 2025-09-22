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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\AuthController;

use App\Models\Producto;

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

// Ruta autenticada del catálogo (requiere autenticación)
Route::middleware(['auth'])->group(function () {
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
});

// Rutas de login y registro frontend
Route::get('/iniciosesion', [AuthController::class, 'showLoginForm'])->name('frontend.login');
Route::post('/iniciosesion', [AuthController::class, 'login'])->name('frontend.login.submit');
Route::get('/creacioncuenta', [AuthController::class, 'showRegisterForm'])->name('frontend.register');
Route::post('/creacioncuenta', [AuthController::class, 'register'])->name('frontend.register.submit');

// Ruta de logout (debe estar fuera de middleware para funcionar)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de favoritos (requieren autenticación)
Route::middleware(['auth'])->group(function () {
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
    
    // Rutas de compras
    Route::get('/compras', [CompraController::class, 'index'])->name('compras.index');
    Route::get('/compras/{id}', [CompraController::class, 'show'])->name('compras.show');
    Route::get('/mensaje-confirmacion', function() {
        return view('frontend.mensaje-confirmacion');
    })->name('mensaje.confirmacion');
    
        // Rutas de pedidos del cliente
        Route::get('/pedidoscli', [\App\Http\Controllers\PedidosClienteController::class, 'index'])->name('pedidoscli');
        Route::get('/pedidoscli/{id}', [\App\Http\Controllers\PedidosClienteController::class, 'show'])->name('pedidoscli.show');
        Route::post('/pedidoscli/{id}/cancelar', [\App\Http\Controllers\PedidosClienteController::class, 'cancelar'])->name('pedidoscli.cancelar');
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

Route::middleware(['auth', 'admin'])->group(function () {
    // Rutas para usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    // Rutas para productos
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

    // Rutas para reportes
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


Route::middleware(['auth', 'admin'])->group(function () {
// Rutas para inventario
Route::get('/inventario', [\App\Http\Controllers\InventarioController::class, 'index'])->name('inventario.index');
Route::get('/inventarioempleados', [\App\Http\Controllers\InventarioController::class, 'empleados'])->name('inventario.empleados');
});

// Rutas de perfiles por rol
Route::middleware(['auth'])->group(function () {
    Route::redirect('/perfil/admin', '/perfilad')->name('perfil.admin');
    Route::redirect('/perfil/empleado', '/perfilemp')->name('perfil.empleado');
    Route::redirect('/perfil/cliente', '/perfillcli')->name('perfil.cliente');

    // Alias de rutas para compatibilidad con las antiguas páginas HTML
    Route::get('/perfilad', [UserController::class, 'perfilad'])->name('perfilad');
    Route::view('/perfilep', 'frontend.perfilep')->name('perfilep');
    Route::view('/perfilemp', 'frontend.perfilep')->name('perfilemp'); // alias por posible nombre previo
    Route::view('/perfilcli', 'frontend.perfilcli')->name('perfilcli');
    Route::view('/perfillcli', 'frontend.perfilcli')->name('perfillcli'); // alias exacto solicitado

    // Agregar ruta para perfil empleado real
    Route::get('/perfilemp', [\App\Http\Controllers\UserController::class, 'perfilEmpleado'])->name('perfilemp');

    // Agregar ruta para perfil cliente real
    Route::get('/perfillcli', [\App\Http\Controllers\UserController::class, 'perfilCliente'])->name('perfillcli');

    // Rutas para gestión de perfil
    Route::get('/perfil/edit', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil/update', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/perfil/delete', [PerfilController::class, 'confirmDelete'])->name('perfil.delete');
    Route::delete('/perfil/destroy', [PerfilController::class, 'destroy'])->name('perfil.destroy');

    // Rutas para empleados
    Route::get('/empleado/inventario', [EmpleadoController::class, 'inventario'])->name('empleado.inventario');
    Route::get('/empleado/usuarios-cliente', [EmpleadoController::class, 'usuariosCliente'])->name('empleado.usuarios.cliente');
    Route::get('/inventarioempleados', [EmpleadoController::class, 'inventario'])->name('inventarioempleados');

});
