<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Gestión de Proveedores - Technova</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarEliminacion(event, nombreProveedor) {
            event.preventDefault();
            
            Swal.fire({
                title: '⚠️ ¿Eliminar Proveedor?',
                html: `
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 48px; margin-bottom: 20px;">🗑️</div>
                        <p style="font-size: 18px; color: #333; margin-bottom: 10px;">
                            <strong>¿Estás seguro de eliminar este proveedor?</strong>
                        </p>
                        <p style="font-size: 16px; color: #666; background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #ff4757;">
                            <strong>Proveedor:</strong> ${nombreProveedor}
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
                                    Eliminando proveedor <strong>${nombreProveedor}</strong>
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
                    title: '✅ ¡Proveedor Eliminado!',
                    html: `
                        <div style="text-align: center; padding: 20px;">
                            <div style="font-size: 48px; margin-bottom: 20px;">🎉</div>
                            <p style="font-size: 18px; color: #333; margin-bottom: 10px;">
                                <strong>El proveedor ha sido eliminado exitosamente</strong>
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
        /* Botón eliminar */
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
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }
        .btn-eliminar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        .btn-eliminar:hover::before {
            left: 100%;
        }
        .btn-eliminar:hover {
            background: linear-gradient(135deg, #ff3742, #ff2f3a);
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(255, 71, 87, 0.4);
        }
        .btn-eliminar:active {
            transform: translateY(0);
        }
        .btn-eliminar i {
            margin-right: 2px;
            font-size: 10px;
        }
        /* Botón editar */
        .btn-editar {
            background: var(--gradient-secondary);
            color: #fff;
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
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .btn-editar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }
        .btn-editar:hover::before {
            left: 100%;
        }
        .btn-editar:hover {
            background: var(--gradient-primary-hover);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(6, 182, 212, 0.4);
        }
        .btn-editar:active {
            transform: translateY(0);
        }
        .btn-editar i {
            margin-right: 2px;
            font-size: 10px;
        }
        /* Botón agregar */
        .btn-agregar {
            background: var(--gradient-secondary);
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            display: inline-block;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0, 200, 83, 0.4);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-agregar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        .btn-agregar:hover::before {
            left: 100%;
        }
        .btn-agregar:hover {
            background: var(--gradient-primary-hover);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 200, 83, 0.6);
        }
        .btn-agregar i {
            margin-right: 8px;
            font-size: 18px;
        }
        /* Tabla de proveedores */
        .tabla-proveedores {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .tabla-proveedores thead {
            background: var(--gradient-primary);
            color: white;
        }
        .tabla-proveedores th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .tabla-proveedores th i {
            font-size: 1rem;
        }
        .tabla-proveedores tbody tr {
            border-bottom: 1px solid #e0e0e0;
            transition: background 0.3s;
        }
        .tabla-proveedores tbody tr:hover {
            background: #f8f9fa;
        }
        .tabla-proveedores tbody tr:last-child {
            border-bottom: none;
        }
        .tabla-proveedores td {
            padding: 12px;
            font-size: 0.9rem;
        }
        /* Forzar visibilidad */
        .tabla-proveedores tbody tr {
            display: table-row !important;
            visibility: visible !important;
        }
        .tabla-proveedores tbody td {
            display: table-cell !important;
            visibility: visible !important;
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
        
        /* Animaciones personalizadas */
        @keyframes pulse-danger {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .swal2-popup-custom .swal2-icon {
            animation: pulse-danger 2s infinite !important;
        }
        
        .swal2-confirm-success {
            background: linear-gradient(135deg, #00c853, #4caf50) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            box-shadow: 0 4px 15px rgba(0, 200, 83, 0.4) !important;
            transition: all 0.3s ease !important;
        }
        
        .swal2-confirm-success:hover {
            background: linear-gradient(135deg, #00a844, #00c853) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(0, 200, 83, 0.6) !important;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo" style="cursor: default;">
            <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
            <span>TECHNOVA</span>
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


      <div class="menu">
                <div class="enlace"><a href="{{ route('perfilad') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
                <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
                <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Movimiento de Artículos</a></div>
                <div class="enlace"><a href="{{ route('reportes.index') }}"><i class='bx bx-file-blank'></i> Reportes</a></div>
                <div class="enlace active"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-message'></i> Mensajes</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-cart'></i> Pedidos</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-credit-card'></i> Pagos</a></div>
                <div class="enlace"><a href="{{ route('logout') }}"><i class='bx bx-log-out'></i> Cerrar Sesión</a></div>
      </div>
    </div><!-- /.menu-dashboard -->

        <!-- PRINCIPAL -->
    <main class="main-content">
            <h1><i class='bx bx-user-circle'></i> Gestión de Proveedores</h1>

            {{-- Mensaje de éxito --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

            {{-- Mensaje de error --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <a href="{{ route('proveedores.create') }}" class="btn-agregar">
                <i class='bx bx-user-plus'></i> Agregar Proveedor
            </a>

            <h2 id="contadorProveedores">Total de proveedores: {{ $proveedores->count() }}</h2>

            <!-- Tabla de Proveedores -->
            <div class="tabla-responsive">
      <table id="proveedoresTable" class="tabla-proveedores">
        <thead>
          <tr>
                            <th><i class='bx bx-hash'></i> ID</th>
                            <th><i class='bx bx-id-card'></i> Identificación</th>
                            <th><i class='bx bx-user'></i> Nombre</th>
                            <th><i class='bx bx-buildings'></i> Empresa</th>
                            <th><i class='bx bx-phone'></i> Teléfono</th>
                            <th><i class='bx bx-envelope'></i> Correo</th>
                            <th><i class='bx bx-package'></i> ID Producto</th>
                            <th><i class='bx bx-cog'></i> Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($proveedores as $proveedor)
          <tr>
            <td>{{ $proveedor->ID_Proveedor }}</td>
            <td>{{ $proveedor->Identificacion }}</td>
            <td>{{ $proveedor->Nombre }}</td>
            <td>{{ $proveedor->Empresa ?? 'N/A' }}</td>
            <td>{{ $proveedor->Telefono }}</td>
            <td>{{ $proveedor->Correo }}</td>
                            <td>{{ $proveedor->ID_producto ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('proveedores.edit', $proveedor->ID_Proveedor) }}" class="btn-editar">
                                    <i class='bx bx-edit'></i> Editar
                                </a>
                                <form action="{{ route('proveedores.destroy', $proveedor->ID_Proveedor) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                                    <button type="submit" class="btn-eliminar" onclick="confirmarEliminacion(event, '{{ $proveedor->Nombre }}')">
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

  <script>
    function filterTable() {
      const input = document.getElementById('searchInput');
      const filter = input.value.toLowerCase();
      const table = document.getElementById('proveedoresTable');
      const trs = table.getElementsByTagName('tr');

      for (let i = 1; i < trs.length; i++) {
        const tds = trs[i].getElementsByTagName('td');
        let show = false;
        for (let j = 0; j < tds.length; j++) {
          if (tds[j].textContent.toLowerCase().indexOf(filter) > -1) {
            show = true;
            break;
          }
        }
        trs[i].style.display = show ? '' : 'none';
      }
    }
  </script>
</body>
</html>
