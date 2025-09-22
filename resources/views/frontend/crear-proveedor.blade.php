<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Crear Proveedor - Technova</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .form-crear-proveedor {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }
        .form-crear-proveedor h2 {
            color: #007acc;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-crear-proveedor input[type="text"],
        .form-crear-proveedor input[type="email"],
        .form-crear-proveedor select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-crear-proveedor input:focus,
        .form-crear-proveedor select:focus {
            outline: none;
            border-color: #007acc;
        }
        .btn-guardar {
            background: var(--gradient-secondary);
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            width: 100%;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0, 200, 83, 0.4);
        }
        .btn-guardar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        .btn-guardar:hover::before {
            left: 100%;
        }
        .btn-guardar:hover {
            background: var(--gradient-primary-hover);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(0, 200, 83, 0.6);
        }
        .btn-cancelar {
            background: linear-gradient(135deg, #ff4757, #ff3742);
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            width: 100%;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.4);
        }
        .btn-cancelar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        .btn-cancelar:hover::before {
            left: 100%;
        }
        .btn-cancelar:hover {
            background: linear-gradient(135deg, #ff3742, #ff2f3a);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(255, 71, 87, 0.6);
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
            <span>TECHNOVA</span>
        </a>
        <div class="search-bar">
            <input type="text" placeholder="¿Qué estás buscando hoy?">
            <button class="search-btn">&#128269;</button>
        </div>
        <div class="acciones-usuario">
            <a href="{{ route('perfilad') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="account" style="background:none;border:none;cursor:pointer;"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></button>
            </form>
            <a href="#" class="cart"><i class='bx bx-cog'></i> <span>Configuración</span></a>
        </div>
    </header>

    <div class="dashboard-wrapper">
        <div class="menu-dashboard">
            <!-- TOP MENU -->
            <div class="top-menu">
                <div class="logo">
                    <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
                    <span>Panel Administrador</span>
                </div>
                <div class="toggle">
                    <i class='bx bx-menu'></i>
                </div>
            </div>

            <!-- INPUT SEARCH -->
            <div class="input-search">
                <i class='bx bx-search'></i>
                <input type="text" class="input" placeholder="Buscar">
            </div>

            <div class="menu">
                <div class="enlace"><a href="{{ route('perfilad') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
                <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
                <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Inventario</a></div>
                <div class="enlace"><a href="{{ route('dashboard') }}"><i class='bx bx-chart'></i> Estadísticas</a></div>
                <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-message'></i> Mensajes</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-cart'></i> Pedidos</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-credit-card'></i> Pagos</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-cog'></i> Configuraciones</a></div>
                <div class="enlace">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;padding:0;">
                            <i class='bx bx-log-out'></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div><!-- /.menu-dashboard -->

        <!-- PRINCIPAL -->
        <main class="main-content">
            <h1><i class='bx bx-user-plus'></i> Crear Nuevo Proveedor</h1>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Mensaje de error --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario para crear proveedor -->
            <div class="form-crear-proveedor">
                <h2><i class='bx bx-user-plus'></i> Información del Proveedor</h2>
                <form action="{{ route('proveedores.store') }}" method="POST">
                    @csrf
                    
                    <input type="text" name="Identificacion" value="{{ old('Identificacion') }}" placeholder="Identificación (CC, NIT, etc.)" required />
                    
                    <input type="text" name="Nombre" value="{{ old('Nombre') }}" placeholder="Nombre completo del proveedor" required />
                    
                    <input type="text" name="Telefono" value="{{ old('Telefono') }}" placeholder="Teléfono" required />
                    
                    <input type="email" name="Correo" value="{{ old('Correo') }}" placeholder="Correo electrónico" required />
                    
                    <select name="ID_producto">
                        <option value="">Seleccionar Producto (Opcional)</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->ID_Producto }}" {{ old('ID_producto') == $producto->ID_Producto ? 'selected' : '' }}>
                                {{ $producto->Nombre }} ({{ $producto->Codigo }})
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="btn-guardar">
                        <i class='bx bx-save'></i> Crear Proveedor
                    </button>
                    
                    <a href="{{ route('proveedores.index') }}" class="btn-cancelar" style="text-decoration: none; display: block; text-align: center;">
                        <i class='bx bx-x'></i> Cancelar
                    </a>
                </form>
            </div>
        </main><!-- /main-content -->
    </div><!-- /dashboard-wrapper -->

    <footer>
        &copy; {{ date('Y') }} Technova
    </footer>

</body>
</html>
