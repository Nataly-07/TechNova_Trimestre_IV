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
        
        @if($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        
        <div class="form-row">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre" required />
          </div>
          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" placeholder="Tu apellido" required />
          </div>
        </div>
        
        <div class="form-group">
          <label for="tipo-doc">Tipo de Documento</label>
          <select id="tipo-doc" name="tipo-doc" required>
            <option value="">Selecciona</option>
            <option value="CC" {{ old('tipo-doc') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
            <option value="TI" {{ old('tipo-doc') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
            <option value="CE" {{ old('tipo-doc') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="documento">Número de Documento</label>
          <input type="text" id="documento" name="documento" value="{{ old('documento') }}" placeholder="Número de documento" required />
        </div>
        
        <div class="form-group">
          <label for="correo">Correo Electrónico</label>
          <input type="email" id="correo" name="correo" value="{{ old('correo') }}" placeholder="tu@email.com" required />
        </div>
        
        <div class="form-group">
          <label for="telefono">Teléfono Celular</label>
          <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="Tu teléfono celular" required />
        </div>
        
        <div class="form-group">
          <label for="direccion">Dirección de Residencia</label>
          <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" placeholder="Tu dirección completa" required />
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required />
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite tu contraseña" required />
          </div>
        </div>
        
        <div class="form-group">
          <label for="role">Rol del Usuario</label>
          <select id="role" name="role" required>
            <option value="">Seleccionar Rol</option>
            <option value="cliente" {{ old('role') == 'cliente' ? 'selected' : '' }}>Cliente</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
            <option value="empleado" {{ old('role') == 'empleado' ? 'selected' : '' }}>Empleado</option>
          </select>
        </div>
        
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
          <td>{{ $user->first_name ?? 'Sin nombre' }} {{ $user->last_name ?? 'Sin apellido' }}</td>
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

    <!-- Modal personalizado para errores -->
    <div id="errorModal" class="custom-modal">
      <div class="modal-content">
        <div class="modal-header">
          <i class='bx bx-error-circle'></i>
          <h3>Errores de Validación</h3>
        </div>
        <div class="modal-body">
          <p>Por favor corrija los siguientes errores:</p>
          <ul id="errorList" class="error-list">
            <!-- Los errores se insertarán aquí dinámicamente -->
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="modal-btn modal-btn-primary" onclick="closeErrorModal()">
            <i class='bx bx-check'></i>
            Entendido
          </button>
        </div>
      </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Technova
    </footer>

  <style>
    .form-nuevo-usuario {
      padding: 20px;
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
    
    .form-nuevo-usuario input[type="text"],
    .form-nuevo-usuario input[type="email"],
    .form-nuevo-usuario input[type="tel"],
    .form-nuevo-usuario input[type="password"],
    .form-nuevo-usuario select {
      width: 100%;
      padding: 12px;
      margin-bottom: 5px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 16px;
      transition: border-color 0.3s;
    }
    
    .form-nuevo-usuario input:focus,
    .form-nuevo-usuario select:focus {
      outline: none;
      border-color: #007acc;
    }
    
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 8px;
    }
    
    .alert-danger {
      background-color: #fef2f2;
      border: 1px solid #fecaca;
      color: #dc2626;
    }
    
    .alert-danger ul {
      margin: 0;
      padding-left: 20px;
    }
    
    .alert-success {
      background-color: #f0fdf4;
      border: 1px solid #bbf7d0;
      color: #166534;
    }
    
    @media (max-width: 768px) {
      .form-row {
        flex-direction: column;
        gap: 0;
      }
    }
    
    /* Estilos para validación en tiempo real */
    .form-nuevo-usuario input.valid {
      border-color: #10b981;
      background-color: #f0fdf4;
    }
    
    .form-nuevo-usuario input.invalid {
      border-color: #ef4444;
      background-color: #fef2f2;
    }
    
    .form-nuevo-usuario select.valid {
      border-color: #10b981;
      background-color: #f0fdf4;
    }
    
    .form-nuevo-usuario select.invalid {
      border-color: #ef4444;
      background-color: #fef2f2;
    }
    
    .password-requirements {
      margin-top: 10px;
      font-size: 12px;
      color: #666;
    }
    
    .requirement {
      margin: 2px 0;
      transition: all 0.3s ease;
    }
    
    .requirement.valid {
      color: #10b981;
      font-weight: 600;
    }
    
    .requirement.invalid {
      color: #ef4444;
    }
    
    /* Estilos para el modal personalizado */
    .custom-modal {
      display: none;
      position: fixed;
      z-index: 10000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(5px);
      animation: fadeIn 0.3s ease;
    }
    
    .modal-content {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      margin: 5% auto;
      padding: 0;
      border: none;
      border-radius: 20px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
      animation: slideInUp 0.4s ease;
      overflow: hidden;
    }
    
    .modal-header {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      color: white;
      padding: 20px 25px;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .modal-header i {
      font-size: 24px;
      animation: shake 0.5s ease-in-out;
    }
    
    .modal-header h3 {
      margin: 0;
      font-size: 18px;
      font-weight: 600;
    }
    
    .modal-body {
      padding: 25px;
    }
    
    .modal-body p {
      margin: 0 0 15px 0;
      color: #374151;
      font-size: 16px;
      font-weight: 500;
    }
    
    .error-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .error-list li {
      background: #fef2f2;
      border: 1px solid #fecaca;
      border-radius: 8px;
      padding: 12px 15px;
      margin-bottom: 8px;
      color: #dc2626;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all 0.3s ease;
    }
    
    .error-list li:hover {
      background: #fee2e2;
      transform: translateX(5px);
    }
    
    .error-list li i {
      color: #ef4444;
      font-size: 16px;
      flex-shrink: 0;
    }
    
    .modal-footer {
      padding: 20px 25px;
      background: #f8fafc;
      display: flex;
      justify-content: flex-end;
      gap: 12px;
    }
    
    .modal-btn {
      padding: 12px 24px;
      border: none;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .modal-btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }
    
    .modal-btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }
    
    .modal-btn-secondary {
      background: #e5e7eb;
      color: #374151;
    }
    
    .modal-btn-secondary:hover {
      background: #d1d5db;
      transform: translateY(-1px);
    }
    
    /* Animaciones */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(50px) scale(0.9);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
    
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .modal-content {
        margin: 10% auto;
        width: 95%;
      }
      
      .modal-header,
      .modal-body,
      .modal-footer {
        padding: 20px;
      }
      
      .modal-footer {
        flex-direction: column;
      }
      
      .modal-btn {
        width: 100%;
        justify-content: center;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Función para validar nombre y apellido (solo letras)
      function validateName(value) {
        return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value) && value.length >= 2;
      }
      
      // Función para validar documento (solo números, mínimo 7)
      function validateDocument(value) {
        return /^\d+$/.test(value) && value.length >= 7;
      }
      
      // Función para validar email
      function validateEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
      }
      
      // Función para validar teléfono (solo números, exactamente 10)
      function validatePhone(value) {
        return /^\d+$/.test(value) && value.length === 10;
      }
      
      // Función para validar dirección (mínimo 8 caracteres)
      function validateAddress(value) {
        return value.length >= 8;
      }
      
      // Función para validar contraseña
      function validatePassword(password) {
        const requirements = {
          length: password.length >= 8,
          upper: /[A-Z]/.test(password),
          lower: /[a-z]/.test(password),
          digit: /\d/.test(password),
          special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };
        return requirements;
      }
      
      // Función para aplicar estilos de validación
      function applyValidation(input, isValid) {
        if (input.value.length > 0) {
          input.classList.remove('valid', 'invalid');
          input.classList.add(isValid ? 'valid' : 'invalid');
        } else {
          input.classList.remove('valid', 'invalid');
        }
      }
      
      // Función para actualizar requisitos de contraseña
      function updatePasswordRequirements(password) {
        const requirements = validatePassword(password);
        const requirementsDiv = document.getElementById('password-requirements');
        
        if (!requirementsDiv) {
          // Crear el div si no existe
          const passwordField = document.getElementById('password');
          const newDiv = document.createElement('div');
          newDiv.id = 'password-requirements';
          newDiv.className = 'password-requirements';
          newDiv.innerHTML = `
            <div class="requirement" data-req="length">✗ Mínimo 8 caracteres</div>
            <div class="requirement" data-req="upper">✗ Mayúscula</div>
            <div class="requirement" data-req="lower">✗ Minúscula</div>
            <div class="requirement" data-req="digit">✗ Número</div>
            <div class="requirement" data-req="special">✗ Carácter especial</div>
          `;
          passwordField.parentNode.appendChild(newDiv);
        }
        
        const requirementsDiv2 = document.getElementById('password-requirements');
        const requirementElements = requirementsDiv2.querySelectorAll('.requirement');
        
        let allValid = true;
        requirementElements.forEach(element => {
          const req = element.getAttribute('data-req');
          const isValid = requirements[req];
          
          if (isValid) {
            element.innerHTML = '✓ ' + element.textContent.substring(2);
            element.classList.remove('invalid');
            element.classList.add('valid');
          } else {
            element.innerHTML = '✗ ' + element.textContent.substring(2);
            element.classList.remove('valid');
            element.classList.add('invalid');
            allValid = false;
          }
        });
        
        return allValid;
      }
      
      // Event listeners para validación en tiempo real
      document.getElementById('nombre').addEventListener('input', function() {
        const isValid = validateName(this.value);
        applyValidation(this, isValid);
      });
      
      document.getElementById('apellido').addEventListener('input', function() {
        const isValid = validateName(this.value);
        applyValidation(this, isValid);
      });
      
      document.getElementById('documento').addEventListener('input', function() {
        const isValid = validateDocument(this.value);
        applyValidation(this, isValid);
      });
      
      document.getElementById('correo').addEventListener('input', function() {
        const isValid = validateEmail(this.value);
        applyValidation(this, isValid);
      });
      
      document.getElementById('telefono').addEventListener('input', function() {
        const isValid = validatePhone(this.value);
        applyValidation(this, isValid);
      });
      
      document.getElementById('direccion').addEventListener('input', function() {
        const isValid = validateAddress(this.value);
        applyValidation(this, isValid);
      });
      
      document.getElementById('password').addEventListener('input', function() {
        const isValid = updatePasswordRequirements(this.value);
        applyValidation(this, isValid);
      });
      
      document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const isValid = this.value === password && password.length > 0;
        applyValidation(this, isValid);
      });
      
      document.getElementById('tipo-doc').addEventListener('change', function() {
        const isValid = this.value !== '';
        applyValidation(this, isValid);
      });
      
      document.getElementById('role').addEventListener('change', function() {
        const isValid = this.value !== '';
        applyValidation(this, isValid);
      });
      
      // Validación del formulario antes de enviar
      document.querySelector('.form-nuevo-usuario form').addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre');
        const apellido = document.getElementById('apellido');
        const documento = document.getElementById('documento');
        const correo = document.getElementById('correo');
        const telefono = document.getElementById('telefono');
        const direccion = document.getElementById('direccion');
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const tipoDoc = document.getElementById('tipo-doc');
        const role = document.getElementById('role');
        
        let isValid = true;
        let errorMessage = '';
        
        // Validar todos los campos
        if (!validateName(nombre.value)) {
          isValid = false;
          errorMessage += '• El nombre debe contener solo letras y tener al menos 2 caracteres\n';
        }
        
        if (!validateName(apellido.value)) {
          isValid = false;
          errorMessage += '• El apellido debe contener solo letras y tener al menos 2 caracteres\n';
        }
        
        if (!validateDocument(documento.value)) {
          isValid = false;
          errorMessage += '• El documento debe contener solo números y tener al menos 7 dígitos\n';
        }
        
        if (!validateEmail(correo.value)) {
          isValid = false;
          errorMessage += '• El correo debe tener un formato válido\n';
        }
        
        if (!validatePhone(telefono.value)) {
          isValid = false;
          errorMessage += '• El teléfono debe contener solo números y tener exactamente 10 dígitos\n';
        }
        
        if (!validateAddress(direccion.value)) {
          isValid = false;
          errorMessage += '• La dirección debe tener al menos 8 caracteres\n';
        }
        
        const passwordRequirements = validatePassword(password.value);
        const allPasswordValid = Object.values(passwordRequirements).every(v => v);
        if (!allPasswordValid) {
          isValid = false;
          errorMessage += '• La contraseña debe cumplir todos los requisitos\n';
        }
        
        if (password.value !== passwordConfirmation.value) {
          isValid = false;
          errorMessage += '• Las contraseñas no coinciden\n';
        }
        
        if (tipoDoc.value === '') {
          isValid = false;
          errorMessage += '• Debe seleccionar un tipo de documento\n';
        }
        
        if (role.value === '') {
          isValid = false;
          errorMessage += '• Debe seleccionar un rol\n';
        }
        
        if (!isValid) {
          e.preventDefault();
          showErrorModal(errorMessage);
          return false;
        }
      });
    });
    
    // Función para mostrar el modal de errores
    function showErrorModal(errorMessage) {
      const modal = document.getElementById('errorModal');
      const errorList = document.getElementById('errorList');
      
      // Limpiar lista anterior
      errorList.innerHTML = '';
      
      // Dividir el mensaje en líneas y crear elementos de lista
      const errors = errorMessage.split('\n').filter(error => error.trim() !== '');
      
      errors.forEach(error => {
        const li = document.createElement('li');
        li.innerHTML = `<i class='bx bx-x'></i>${error}`;
        errorList.appendChild(li);
      });
      
      // Mostrar el modal
      modal.style.display = 'block';
      document.body.style.overflow = 'hidden';
    }
    
    // Función para cerrar el modal
    function closeErrorModal() {
      const modal = document.getElementById('errorModal');
      modal.style.display = 'none';
      document.body.style.overflow = 'auto';
    }
    
    // Cerrar modal al hacer clic fuera de él
    window.onclick = function(event) {
      const modal = document.getElementById('errorModal');
      if (event.target === modal) {
        closeErrorModal();
      }
    }
    
    // Cerrar modal con tecla Escape
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closeErrorModal();
      }
    });
  </script>

</body>
</html>
