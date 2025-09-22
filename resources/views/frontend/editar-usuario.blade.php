<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Editar Usuario - Technova</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .form-editar-usuario {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }
        .form-editar-usuario h2 {
            color: #007acc;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-editar-usuario input[type="text"],
        .form-editar-usuario input[type="email"],
        .form-editar-usuario input[type="password"],
        .form-editar-usuario select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-editar-usuario input:focus,
        .form-editar-usuario select:focus {
            outline: none;
            border-color: #007acc;
        }
        .btn-guardar {
            background: var(--gradient-primary);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }
        .btn-guardar:hover {
            background: #00a844;
        }
        .btn-cancelar {
            background: #ff4d4d;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
            margin-top: 10px;
        }
        .btn-cancelar:hover {
            background: #d90000;
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
            <h1><i class='bx bx-edit'></i> Editar Usuario</h1>

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

            <!-- Formulario para editar usuario -->
            <div class="form-editar-usuario">
                <h2><i class='bx bx-user-edit'></i> Editar Información del Usuario</h2>
                <form action="{{ route('usuarios.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Nombre completo" required />
                    
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Correo electrónico" required />
                    
                    <input type="password" name="password" placeholder="Nueva contraseña (dejar vacío para mantener la actual)" />
                    
                    <input type="password" name="password_confirmation" placeholder="Confirmar nueva contraseña" />
                    
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="Primer nombre" />
                    
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Apellido" />
                    
                    <input type="text" name="document_type" value="{{ old('document_type', $user->document_type) }}" placeholder="Tipo de documento" />
                    
                    <input type="text" name="document_number" value="{{ old('document_number', $user->document_number) }}" placeholder="Número de documento" />
                    
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Teléfono" />
                    
                    <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="Dirección" />
                    
                    <select name="role" required>
                        <option value="">Seleccionar Rol</option>
                        <option value="cliente" {{ old('role', $user->role) == 'cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="empleado" {{ old('role', $user->role) == 'empleado' ? 'selected' : '' }}>Empleado</option>
                    </select>
                    
                    <button type="submit" class="btn-guardar">
                        <i class='bx bx-save'></i> Guardar Cambios
                    </button>
                    
                    <a href="{{ route('usuarios.index') }}" class="btn-cancelar" style="text-decoration: none; display: block; text-align: center;">
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
