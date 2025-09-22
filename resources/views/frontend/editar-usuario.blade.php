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
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
            flex: 1;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 600;
            font-size: 14px;
        }
        
        .form-editar-usuario input[type="text"],
        .form-editar-usuario input[type="email"],
        .form-editar-usuario input[type="tel"],
        .form-editar-usuario input[type="password"],
        .form-editar-usuario select {
            width: 100%;
            padding: 12px;
            margin-bottom: 5px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .form-editar-usuario input:focus,
        .form-editar-usuario select:focus {
            outline: none;
            border-color: #007acc;
        }
        .form-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .btn-guardar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-guardar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
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
            transition: all 0.3s;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-cancelar:hover {
            background: #d90000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 77, 77, 0.4);
        }
        
        .user-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #e9ecef;
        }
        
        .user-info h3 {
            color: #007acc;
            margin-bottom: 20px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .info-item label {
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
        }
        
        .info-item span {
            color: #2d3748;
            font-size: 16px;
            padding: 8px 12px;
            background: white;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        
        .current-role {
            background: #e6fffa !important;
            color: #234e52 !important;
            font-weight: 600;
            border-color: #81e6d9 !important;
        }
        
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .form-buttons {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn-guardar,
            .btn-cancelar {
                width: 100%;
            }
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

            <!-- Información del usuario (solo lectura) -->
            <div class="form-editar-usuario">
                <h2><i class='bx bx-user-edit'></i> Editar Rol de Usuario</h2>
                
                <!-- Información del usuario -->
                <div class="user-info">
                    <h3><i class='bx bx-user'></i> Información del Usuario</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nombre:</label>
                            <span>{{ $user->first_name ?? 'Sin nombre' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Apellido:</label>
                            <span>{{ $user->last_name ?? 'Sin apellido' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Correo Electrónico:</label>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="info-item">
                            <label>Tipo de Documento:</label>
                            <span>{{ $user->document_type ?? 'No especificado' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Número de Documento:</label>
                            <span>{{ $user->document_number ?? 'No especificado' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Teléfono:</label>
                            <span>{{ $user->phone ?? 'No especificado' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Dirección:</label>
                            <span>{{ $user->address ?? 'No especificada' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Rol Actual:</label>
                            <span class="current-role">{{ ucfirst($user->role) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Formulario para cambiar solo el rol -->
                <form action="{{ route('usuarios.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="role">Cambiar Rol del Usuario</label>
                        <select id="role" name="role" required>
                            <option value="">Seleccionar Nuevo Rol</option>
                            <option value="cliente" {{ old('role', $user->role) == 'cliente' ? 'selected' : '' }}>Cliente</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="empleado" {{ old('role', $user->role) == 'empleado' ? 'selected' : '' }}>Empleado</option>
                        </select>
                        @error('role')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit" class="btn-guardar">
                            <i class='bx bx-save'></i> Actualizar Rol
                        </button>
                        
                        <a href="{{ route('usuarios.index') }}" class="btn-cancelar">
                            <i class='bx bx-x'></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </main><!-- /main-content -->
    </div><!-- /dashboard-wrapper -->

    <footer>
        &copy; {{ date('Y') }} Technova
    </footer>

</body>
</html>
