<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medios De Pago | Technova</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
           <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
           <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
           <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    
    <style>
        .pago-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .pago-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .pago-header h1 {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .pago-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }
        
        .metodos-pago {
            background: var(--janna-light);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 20px;
            border: 2px solid var(--sinbad);
        }
        
        .metodo-pago {
            border: 2px solid var(--sinbad);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: white;
        }
        
        .metodo-pago:hover {
            border-color: var(--bondi-blue);
            background-color: var(--sinbad-light);
        }
        
        .metodo-pago.selected {
            border-color: var(--bondi-blue);
            background-color: var(--sinbad-light);
        }
        
        .metodo-pago input[type="radio"] {
            margin-right: 10px;
        }
        
        .metodo-pago label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-weight: bold;
        }
        
        .metodo-pago .icono {
            font-size: 1.5em;
            margin-right: 10px;
        }
        
        .datos-pago {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
            display: none;
        }
        
        .datos-pago.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .resumen-pago {
            background: var(--janna-light);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 20px;
            height: fit-content;
            border: 2px solid var(--sinbad);
        }
        
        .producto-resumen {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .producto-resumen:last-child {
            border-bottom: none;
        }
        
        .producto-imagen {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .resumen-total {
            font-size: 1.5em;
            font-weight: bold;
            color: #00d4ff;
            margin: 20px 0;
            text-align: center;
        }
        
        .btn-procesar {
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 15px 30px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-procesar:hover {
            background: var(--gradient-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .btn-volver {
            background: var(--gradient-secondary);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-volver:hover {
            background: var(--gradient-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <header class="header">
        @if(auth()->user()->role === 'cliente')
            <a href="{{ route('catalogo.autenticado') }}" class="logo">
                <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
                <span>TECHNOVA</span>
            </a>
        @else
            <div class="logo" style="cursor: default;">
                <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
                <span>TECHNOVA</span>
            </div>
        @endif
        
        <div class="search-bar">
            <input type="text" placeholder="¿Qué estás buscando hoy?">
            <button class="search-btn">&#128269;</button>
        </div>
        
        <div class="acciones-usuario">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('perfilad') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
            @elseif(auth()->user()->role === 'empleado')
                <a href="{{ route('perfilemp') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
            @else
                <a href="{{ route('perfillcli') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
            @endif
            <a href="{{ route('logout') }}" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
            <a href="{{ route('favoritos.index') }}" class="cart"><i class='bx bx-heart'></i> <span>Favoritos</span></a>
            <a href="{{ route('carrito.index') }}" class="cart"><i class='bx bx-cart'></i> <span>Carrito</span></a>
        </div>
    </header>

    <div class="dashboard-wrapper">
        <div class="menu-dashboard">
            <div class="top-menu">
                <div class="logo">
                    <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
                    <span>Panel Usuario</span>
                </div>
                <div class="toggle">
                    <i class='bx bx-menu'></i>
                </div>
            </div>

            <div class="input-search">
                <i class='bx bx-search'></i>
                <input type="text" class="input" placeholder="Buscar">
            </div>

            <div class="menu">
                @if(auth()->user()->role === 'admin')
                    <div class="enlace"><a href="{{ route('perfilad') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
                    <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
                    <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Inventario</a></div>
                    <div class="enlace"><a href="{{ route('dashboard') }}"><i class='bx bx-chart'></i> Estadísticas</a></div>
                    <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
                @elseif(auth()->user()->role === 'empleado')
                    <div class="enlace"><a href="{{ route('perfilemp') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
                    <div class="enlace"><a href="{{ route('empleado.inventario') }}"><i class='bx bx-shopping-bag'></i> Visualización Artículos</a></div>
                    <div class="enlace"><a href="{{ route('empleado.usuarios.cliente') }}"><i class='bx bx-user'></i> Usuarios Cliente</a></div>
                @else
                    <div class="enlace"><a href="{{ route('perfillcli') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
                @endif
                <div class="enlace"><a href="{{ route('catalogo.autenticado') }}"><i class='bx bx-store'></i> Catálogo</a></div>
                <div class="enlace"><a href="{{ route('favoritos.index') }}"><i class='bx bx-heart'></i> Favoritos</a></div>
                <div class="enlace"><a href="{{ route('carrito.index') }}"><i class='bx bx-cart'></i> Carrito</a></div>
                <div class="enlace"><a href="{{ route('compras.index') }}"><i class='bx bx-receipt'></i> Mis Compras</a></div>
                <div class="enlace"><a href="{{ route('logout') }}"><i class='bx bx-log-out'></i> Cerrar Sesión</a></div>
            </div>
        </div>

        <main class="main-content">
            <div class="pago-container">
                <div class="pago-header">
                    <h1>💳 Medios de Pago</h1>
                    <p>Selecciona tu método de pago preferido</p>
                </div>

                <div class="pago-content">
                    <div class="metodos-pago">
                        <h3>Selecciona un método de pago</h3>
                        
                        <form id="pagoForm">
                            @foreach($metodosDisponibles as $key => $metodo)
                                <div class="metodo-pago" data-metodo="{{ $key }}">
                                    <label>
                                        <input type="radio" name="metodo_pago" value="{{ $key }}" required>
                                        <span class="icono">
                                            @if($key === 'nequi')
                                                💰
                                            @elseif($key === 'pse')
                                                🏦
                                            @elseif($key === 'tarjeta_credito')
                                                💳
                                            @elseif($key === 'tarjeta_debito')
                                                💳
                                            @elseif($key === 'transferencia_bancaria')
                                                🏛️
                                            @elseif($key === 'efectivo')
                                                💵
                                            @endif
                                        </span>
                                        {{ $metodo }}
                                    </label>
                                    
                                    <div class="datos-pago" id="datos-{{ $key }}">
                                        @if($key === 'nequi')
                                            <div class="form-group">
                                                <label>Número de Nequi:</label>
                                                <input type="text" name="datos_pago[numero]" placeholder="3001234567" required>
                                            </div>
                                        @elseif($key === 'pse')
                                            <div class="form-group">
                                                <label>Banco:</label>
                                                <input type="text" name="datos_pago[banco]" placeholder="Banco de Bogotá" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Número de cuenta:</label>
                                                <input type="text" name="datos_pago[cuenta]" placeholder="1234567890" required>
                                            </div>
                                        @elseif($key === 'tarjeta_credito' || $key === 'tarjeta_debito')
                                            <div class="form-group">
                                                <label>Número de tarjeta:</label>
                                                <input type="text" name="datos_pago[numero_tarjeta]" placeholder="1234 5678 9012 3456" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Nombre del titular:</label>
                                                <input type="text" name="datos_pago[titular]" placeholder="Juan Pérez" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha de vencimiento:</label>
                                                <input type="text" name="datos_pago[vencimiento]" placeholder="MM/AA" required>
                                            </div>
                                            <div class="form-group">
                                                <label>CVV:</label>
                                                <input type="text" name="datos_pago[cvv]" placeholder="123" required>
                                            </div>
                                        @elseif($key === 'transferencia_bancaria')
                                            <div class="form-group">
                                                <label>Banco:</label>
                                                <input type="text" name="datos_pago[banco]" placeholder="Banco de Bogotá" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Número de cuenta:</label>
                                                <input type="text" name="datos_pago[cuenta]" placeholder="1234567890" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Nombre del titular:</label>
                                                <input type="text" name="datos_pago[titular]" placeholder="Juan Pérez" required>
                                            </div>
                                        @elseif($key === 'efectivo')
                                            <div class="form-group">
                                                <label>Dirección de entrega:</label>
                                                <input type="text" name="datos_pago[direccion]" placeholder="Calle 123 #45-67" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Teléfono de contacto:</label>
                                                <input type="text" name="datos_pago[telefono]" placeholder="3001234567" required>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </form>
                    </div>
                    
                    <div class="resumen-pago">
                        <h3>Resumen del pedido</h3>
                        
                        @foreach($productos as $detalle)
                            <div class="producto-resumen">
                                @php
                                    $imgSrc = $detalle->producto->Imagen;
                                    if (!$imgSrc) {
                                        $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                                    } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                                        $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                                    }
                                @endphp
                                
                                <img src="{{ $imgSrc }}" alt="{{ $detalle->producto->Nombre }}" class="producto-imagen">
                                <div>
                                    <div style="font-weight: bold;">{{ $detalle->producto->Nombre }}</div>
                                    <div style="color: #666;">Cantidad: {{ $detalle->Cantidad }}</div>
                                    <div style="color: #00d4ff; font-weight: bold;">${{ number_format($detalle->producto->caracteristicas->Precio_Venta * $detalle->Cantidad, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="resumen-total">
                            Total: ${{ number_format($total, 0, ',', '.') }}
                        </div>
                        
                        <button class="btn-procesar" onclick="procesarPago()">
                            Procesar Pago
                        </button>
                        
                        <button class="btn-volver" onclick="volverCarrito()">
                            Volver al Carrito
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer>
        &copy; {{ date('Y') }} Technova
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metodosPago = document.querySelectorAll('.metodo-pago');
            const datosPago = document.querySelectorAll('.datos-pago');
            
            metodosPago.forEach(metodo => {
                const radio = metodo.querySelector('input[type="radio"]');
                
                radio.addEventListener('change', function() {
                    // Remover selección de todos los métodos
                    metodosPago.forEach(m => m.classList.remove('selected'));
                    datosPago.forEach(d => d.classList.remove('active'));
                    
                    // Agregar selección al método actual
                    if (this.checked) {
                        metodo.classList.add('selected');
                        const metodoKey = metodo.dataset.metodo;
                        const datos = document.getElementById('datos-' + metodoKey);
                        if (datos) {
                            datos.classList.add('active');
                        }
                    }
                });
            });
        });
        
        function procesarPago() {
            const form = document.getElementById('pagoForm');
            const formData = new FormData(form);
            
            const metodoPago = formData.get('metodo_pago');
            if (!metodoPago) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selecciona un método de pago',
                    text: 'Por favor selecciona un método de pago antes de continuar.'
                });
                return;
            }
            
            // Recopilar datos del pago
            const datosPago = {};
            const inputs = form.querySelectorAll('input[name^="datos_pago"]');
            inputs.forEach(input => {
                if (input.name.includes('[') && input.name.includes(']')) {
                    const key = input.name.match(/\[([^\]]+)\]/)[1];
                    datosPago[key] = input.value;
                }
            });
            
            // Validar que todos los campos requeridos estén llenos
            const requiredInputs = form.querySelectorAll('input[required]');
            let allValid = true;
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    allValid = false;
                }
            });
            
            if (!allValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor completa todos los campos requeridos.'
                });
                return;
            }
            
            // Mostrar confirmación
            Swal.fire({
                title: '¿Confirmar pago?',
                text: `Total a pagar: ${{ number_format($total, 0, ',', '.') }}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00d4ff',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, procesar pago',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Procesar pago
                    fetch('/compras/procesar', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            metodo_pago: metodoPago,
                            datos_pago: datosPago
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Pago procesado!',
                                text: 'Tu compra ha sido procesada exitosamente.',
                                confirmButtonColor: '#00d4ff'
                            }).then(() => {
                                window.location.href = '/mensaje-confirmacion';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error en el pago',
                                text: data.error || 'Hubo un error al procesar el pago.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de conexión',
                            text: 'Hubo un problema al procesar el pago. Inténtalo de nuevo.'
                        });
                    });
                }
            });
        }
        
        function volverCarrito() {
            window.location.href = '/carrito';
        }
    </script>
</body>
</html>
