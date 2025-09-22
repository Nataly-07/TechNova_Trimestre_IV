<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Gestión de Usuarios - Technova</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header class="header">
        <div class="logo" style="cursor: default;">
            <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
            <span>TECHNOVA</span>
        </div>

        <div class="search-bar">
            <input type="text" placeholder="¿Qué estás buscando hoy?">
            <button class="search-btn">&#128269;</button>
        </div>

        <div class="acciones-usuario">
            <a href="{{ route('perfilad') }}" class="account">
                <i class='bx bx-user-circle'></i> 
                <span>Perfil</span>
            </a>
            <a href="{{ route('logout') }}" class="account">
                <i class='bx bx-log-out'></i> 
                <span>Cerrar Sesión</span>
            </a>
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
                <div class="enlace active"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
                <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Movimiento de Artículos</a></div>
                <div class="enlace"><a href="{{ route('reportes.index') }}"><i class='bx bx-file-blank'></i> Reportes</a></div>
                <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-message'></i> Mensajes</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-cart'></i> Pedidos</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-credit-card'></i> Pagos</a></div>
                <div class="enlace"><a href="{{ route('logout') }}"><i class='bx bx-log-out'></i> Cerrar Sesión</a></div>
            </div>

        </div><!-- /.menu-dashboard -->

        <main class="main-content">
    <script>
        function confirmarEliminacionUsuario(event, nombreUsuario) {
            event.preventDefault();
            
            Swal.fire({
                title: '⚠️ ¿Eliminar Usuario?',
                html: `
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 48px; margin-bottom: 20px;">🗑️</div>
                        <p style="font-size: 18px; color: #333; margin-bottom: 10px;">
                            <strong>¿Estás seguro de eliminar este usuario?</strong>
                        </p>
                        <p style="font-size: 16px; color: #666; background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #ff4757;">
                            <strong>Usuario:</strong> ${nombreUsuario}
                        </p>
                        <p style="font-size: 14px; color: #999; margin-top: 15px;">
                            Esta acción no se puede deshacer
                        </p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: `
                    <i class='bx bx-trash' style="margin-right: 8px;"></i>
                    Sí, Eliminar
                `,
                cancelButtonText: `
                    <i class='bx bx-x' style="margin-right: 8px;"></i>
                    Cancelar
                `,
                confirmButtonColor: '#ff4757',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'swal2-popup-custom',
                    title: 'swal2-title-custom',
                    confirmButton: 'swal2-confirm-custom',
                    cancelButton: 'swal2-cancel-custom',
                    htmlContainer: 'swal2-html-custom'
                },
                buttonsStyling: true,
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Eliminando...',
                        html: `
                            <div style="text-align: center; padding: 20px;">
                                <div style="font-size: 48px; margin-bottom: 20px;">⏳</div>
                                <p style="font-size: 16px; color: #333;">
                                    Eliminando usuario <strong>${nombreUsuario}</strong>
                                </p>
                            </div>
                        `,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal2-popup-custom'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar el formulario
                    event.target.closest('form').submit();
                }
            });
        }

        // Mostrar mensaje de éxito si hay un parámetro en la URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('deleted') === 'success') {
                Swal.fire({
                    title: '✅ ¡Usuario Eliminado!',
                    html: `
                        <div style="text-align: center; padding: 20px;">
                            <div style="font-size: 48px; margin-bottom: 20px;">🎉</div>
                            <p style="font-size: 18px; color: #333; margin-bottom: 10px;">
                                <strong>El usuario ha sido eliminado exitosamente</strong>
                            </p>
                            <p style="font-size: 14px; color: #666;">
                                La información se ha actualizado en la base de datos
                            </p>
                        </div>
                    `,
                    confirmButtonText: `
                        <i class='bx bx-check' style="margin-right: 8px;"></i>
                        Entendido
                    `,
                    confirmButtonColor: '#00d4ff',
                    customClass: {
                        popup: 'swal2-popup-custom',
                        title: 'swal2-title-custom',
                        confirmButton: 'swal2-confirm-success'
                    },
                    showClass: {
                        popup: 'animate__animated animate__bounceIn animate__faster'
                    }
                });
                
                // Limpiar la URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>
    <style>
        /* Botón eliminar - Más pequeño y estilizado */
        .btn-eliminar {
            background: linear-gradient(135deg, #ff4757, #ff3742);
            color: #fff;
            border: none;
            padding: 3px 6px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            margin-right: 2px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(255, 71, 87, 0.3);
            font-size: 10px;
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }
        .btn-eliminar:hover {
            background: linear-gradient(135deg, #ff3742, #ff2f3a);
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(255, 71, 87, 0.4);
        }
        .btn-eliminar:active {
            transform: translateY(0);
        }
        
        /* Estilos personalizados para SweetAlert2 */
        .swal2-popup-custom {
            border-radius: 20px !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
            border: 2px solid #e9ecef !important;
            overflow: hidden !important;
        }
        
        .swal2-title-custom {
            color: #2c3e50 !important;
            font-weight: 700 !important;
            font-size: 24px !important;
            margin-bottom: 0 !important;
        }
        
        .swal2-confirm-custom {
            background: linear-gradient(135deg, #ff4757, #ff3742) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.4) !important;
            transition: all 0.3s ease !important;
        }
        
        .swal2-confirm-custom:hover {
            background: linear-gradient(135deg, #ff3742, #ff2f3a) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(255, 71, 87, 0.6) !important;
        }
        
        .swal2-cancel-custom {
            background: linear-gradient(135deg, #6c757d, #5a6268) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4) !important;
            transition: all 0.3s ease !important;
        }
        
        .swal2-cancel-custom:hover {
            background: linear-gradient(135deg, #5a6268, #495057) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.6) !important;
        }
        
        .swal2-html-custom {
            color: #495057 !important;
            line-height: 1.6 !important;
        }
        
        .swal2-confirm-success {
            background: var(--gradient-secondary) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4) !important;
            transition: all 0.3s ease !important;
        }
        
        .swal2-confirm-success:hover {
            background: var(--gradient-primary-hover) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.6) !important;
        }
        
        /* Animaciones personalizadas */
        @keyframes pulse-danger {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .swal2-popup-custom .swal2-icon {
            animation: pulse-danger 2s infinite !important;
        }
        /* Botón editar - Más pequeño y estilizado */
        .btn-editar {
            background: var(--gradient-secondary) !important;
            color: #fff !important;
            padding: 3px 6px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            margin-left: 2px;
            border: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 2px;
            box-shadow: 0 1px 3px rgba(6, 182, 212, 0.3);
            font-size: 10px;
        }
        .btn-editar:hover {
            background: var(--gradient-primary-hover) !important;
            color: #fff !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(6, 182, 212, 0.4);
        }
        .btn-editar:active {
            transform: translateY(0);
        }
        /* Formulario */
        .form-nuevo-usuario input[type="text"],
        .form-nuevo-usuario input[type="email"],
        .form-nuevo-usuario input[type="password"],
        .form-nuevo-usuario select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        /* Tabla responsive */
        .tabla-responsive {
            width: 100%;
            overflow-x: auto;
        }
        .table-usuarios {
            width: 100%;
            border-collapse: collapse;
        }
        .table-usuarios th, .table-usuarios td {
            padding: 8px 12px;
            text-align: center;
            min-width: 100px;
        }
        .table-usuarios th {
            background: var(--gradient-primary) !important;
            color: #fff !important;
        }
        .table-usuarios tr:nth-child(even) {
            background: #f9f9f9;
        }
        .table-usuarios tbody tr {
            display: table-row !important;
            visibility: visible !important;
        }
        .table-usuarios tbody td {
            display: table-cell !important;
            visibility: visible !important;
        }
    </style>
</head>
<body>

        <!-- PRINCIPAL -->
<main class="main-content">
            <h1>Gestión de Usuarios</h1>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

    <!-- 📋 Formulario para nuevo usuario -->
     <div class="form-nuevo-usuario">
      <h2>Agregar Nuevo Usuario</h2>
      <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nombre completo" required />
        <input type="email" name="email" placeholder="Correo electrónico" required />
        <input type="password" name="password" placeholder="Contraseña" required />
        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required />
        <input type="text" name="first_name" placeholder="Primer nombre" />
        <input type="text" name="last_name" placeholder="Apellido" />
        <input type="text" name="document_type" placeholder="Tipo de documento" />
        <input type="text" name="document_number" placeholder="Número de documento" />
        <input type="text" name="phone" placeholder="Teléfono" />
        <input type="text" name="address" placeholder="Dirección" />
        <select name="role" required>
                        <option value="">Seleccionar Rol</option>
          <option value="cliente">Cliente</option>
          <option value="admin">Administrador</option>
          <option value="empleado">Empleado</option>
        </select>
        <button type="submit"><i class='bx bx-user-plus'></i> Agregar Usuario</button>
      </form>
    </div>

<div class="acciones-usuarios">
      <input type="text" id="buscadorUsuarios" placeholder="Buscar usuario..." />
    </div>

    <div class="filtro-roles">
  <label for="filtroRol">Filtrar por rol:</label>
  <select id="filtroRol">
    <option value="todos">Todos</option>
    <option value="admin">Administrador</option>
    <option value="cliente">Cliente</option>
    <option value="empleado">Empleado</option>
  </select>
</div>

            <h2 id="contadorUsuarios">Total de usuarios: {{ $users->count() }}</h2>

    <!-- Tabla de Usuarios -->
            <div class="tabla-responsive">
    <table class="table-usuarios">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="usuarios-body">
        @foreach($users as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->role }}</td>
          <td>
                                <a href="{{ route('usuarios.edit', $user->id) }}" class="btn-editar"><i class='bx bx-edit'></i> Editar</a>
            <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
                                    <button type="submit" class="btn-eliminar" onclick="confirmarEliminacionUsuario(event, '{{ $user->name }}')">
                                        <i class='bx bx-trash'></i> Eliminar
                                    </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
            </div>
        </main><!-- /main-content -->
    </div><!-- /dashboard-wrapper -->

    <footer>
        &copy; {{ date('Y') }} Technova
    </footer>

</body>
</html>
