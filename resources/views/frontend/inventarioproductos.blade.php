
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Movimiento de Artículos</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('frontend/js/inventarioproductos.js') }}" defer></script>
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
                <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
                <div class="enlace active"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Movimiento de Artículos</a></div>
                <div class="enlace"><a href="{{ route('reportes.index') }}"><i class='bx bx-file-blank'></i> Reportes</a></div>
                <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-message'></i> Mensajes</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-cart'></i> Pedidos</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-credit-card'></i> Pagos</a></div>
                <div class="enlace"><a href="{{ route('logout') }}"><i class='bx bx-log-out'></i> Cerrar Sesión</a></div>
            </div>

        </div><!-- /.menu-dashboard -->

        <main class="main-content">
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
            box-shadow: 0 4px 15px rgba(0, 200, 83, 0.4) !important;
            transition: all 0.3s ease !important;
        }
        
        .swal2-confirm-success:hover {
            background: var(--gradient-primary-hover) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(0, 200, 83, 0.6) !important;
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
        }
        .btn-editar:hover {
            background: var(--gradient-primary-hover);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(6, 182, 212, 0.4);
        }
        /* Formulario */
        .form-nuevo-usuario input[type="text"],
        .form-nuevo-usuario input[type="number"],
        .form-nuevo-usuario select,
        .form-nuevo-usuario textarea {
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
        .table-inventario {
            width: 100%;
            border-collapse: collapse;
        }
        .table-inventario th, .table-inventario td {
            padding: 8px 12px;
            text-align: center;
            min-width: 100px;
        }
        .table-inventario th {
            background: var(--gradient-primary);
            color: #fff;
        }
        .table-inventario tr:nth-child(even) {
            background: #f9f9f9;
        }
    </style>
</head>
<body>

        <main class="main-content">
            <h1>Movimiento de Artículos</h1>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="form-nuevo-usuario">
                <h2>Registrar Movimiento de Artículo</h2>
                <div style="background: #e3f2fd; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #2196f3;">
                    <h4 style="margin: 0 0 10px 0; color: #1976d2;"><i class='bx bx-info-circle'></i> Información del Sistema</h4>
                    <p style="margin: 0; color: #333; font-size: 0.9em;">
                        <strong>Ingreso:</strong> Solo el administrador puede registrar productos que ingresan al inventario.<br>
                        <strong>Salida:</strong> Se actualiza automáticamente cuando los clientes realizan compras.<br>
                        <strong>Stock:</strong> Se calcula automáticamente como Ingreso - Salida.
                    </p>
                </div>
                <form id="formAgregarProducto" action="{{ route('productos.store') }}" method="POST">
                    @csrf
                    <input type="text" name="Codigo" placeholder="Código del producto" required />
                    <input type="text" name="Nombre" placeholder="Nombre del producto" required />
                    <input type="text" name="Imagen" placeholder="URL de imagen (opcional)" />
                    <select name="Categoria" required>
                        <option value="">Selecciona una categoría</option>
                        <option value="Celulares">📱 Celulares</option>
                        <option value="Portátiles">💻 Portátiles</option>
                    </select>
                    <input type="text" name="Color" placeholder="Color" required />
                    <textarea name="Descripcion" placeholder="Descripción"></textarea>
                    <input type="number" name="Precio_Compra" placeholder="Precio Compra" required />
                    <input type="number" name="Precio_Venta" placeholder="Precio Venta" required />
                    <select name="Marca" required>
                        <option value="">Selecciona una marca</option>
                        <option value="Apple"> Apple</option>
                        <option value="Samsung">📱 Samsung</option>
                        <option value="Motorola">📞 Motorola</option>
                        <option value="Xiaomi">🧡 Xiaomi</option>
                        <option value="OPPO">📲 OPPO</option>
                        <option value="Lenovo">💻 Lenovo</option>
                    </select>
                    <div class="filtro-group">
                        <label for="Ingreso">Ingreso de Artículos</label>
                        <input type="number" name="Ingreso" id="Ingreso" placeholder="Cantidad de productos que ingresan" required />
                        <small>Artículos que el administrador registra como ingresados al inventario</small>
                    </div>
                    
                    <div class="filtro-group">
                        <label for="Salida">Salida de Artículos</label>
                        <input type="number" name="Salida" id="Salida" placeholder="Cantidad de productos que salen" value="0" />
                        <small>Artículos que salen por compras (se actualizará automáticamente)</small>
                    </div>
                    
                    <div class="filtro-group">
                        <label for="Stock">Stock Actual</label>
                        <input type="number" name="Stock" id="Stock" placeholder="Stock calculado automáticamente" readonly />
                        <small>Stock = Ingreso - Salida (no editable por el administrador)</small>
                    </div>
                    <button type="submit">Registrar Movimiento</button>
                </form>
            </div>

            <div class="tabla-responsive">
                <table class="table-inventario">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Imagen</th>
                            <th>Categoría</th>
                            <th>Color</th>
                            <th>Descripción</th>
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Marca</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->Codigo }}</td>
                            <td>{{ $producto->Nombre }}</td>
                            <td>
                                @if($producto->Imagen)
                                    <img src="{{ $producto->Imagen }}" width="40">
                                @endif
                            </td>
                            <td>{{ $producto->caracteristicas->Categoria ?? '' }}</td>
                            <td>{{ $producto->caracteristicas->Color ?? '' }}</td>
                            <td>{{ $producto->caracteristicas->Descripcion ?? '' }}</td>
                            <td>{{ $producto->caracteristicas->Precio_Compra ?? '' }}</td>
                            <td>{{ $producto->caracteristicas->Precio_Venta ?? '' }}</td>
                            <td>{{ $producto->caracteristicas->Marca ?? '' }}</td>
                            <td>{{ $producto->Ingreso ?? 0 }}</td>
                            <td>{{ $producto->Salida ?? 0 }}</td>
                            <td>{{ $producto->Stock }}</td>
                            <td>
                                <form action="{{ route('productos.destroy', $producto->ID_Producto) }}" method="POST" style="display:inline;" id="delete-form-{{ $producto->ID_Producto }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-eliminar delete-btn" onclick="confirmarEliminacionProducto(event, '{{ $producto->Nombre ?: 'Producto sin nombre' }}')">
                                        <i class='bx bx-trash'></i> Eliminar
                                    </button>
                                </form>
                                <a href="{{ route('productos.edit', $producto->ID_Producto) }}" class="btn-editar"><i class='bx bx-edit'></i> Editar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <style>
        .filtro-group {
            margin-bottom: 15px;
        }
        
        .filtro-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        .filtro-group small {
            display: block;
            margin-top: 3px;
            color: #666;
            font-size: 0.85em;
            font-style: italic;
        }
        
        .filtro-group input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
            border-color: #ddd;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Los botones de eliminar ahora usan el modal personalizado con onclick

            // Remove redirects and implement strict filtering for category and brand selects
            const categoriaSelect = document.querySelector('select[name="Categoria"]');
            const marcaSelect = document.querySelector('select[name="Marca"]');

            // Mapping of categories to allowed brands
            const categoryBrandMap = {
                'Celulares': ['Apple', 'Samsung', 'Motorola', 'Xiaomi', 'OPPO'],
                'Portátiles': ['Lenovo']
            };

            function updateMarcaOptions() {
                const selectedCategory = categoriaSelect.value;
                const allowedBrands = categoryBrandMap[selectedCategory] || [];

                // Enable or disable brand options based on selected category
                Array.from(marcaSelect.options).forEach(option => {
                    if (option.value === '') {
                        option.disabled = false; // Always enable the default option
                        option.selected = true; // Reset selection to default when category changes
                    } else if (allowedBrands.includes(option.value)) {
                        option.disabled = false;
                    } else {
                        option.disabled = true;
                        if (option.selected) {
                            option.selected = false;
                        }
                    }
                });
            }

            if (categoriaSelect && marcaSelect) {
                categoriaSelect.addEventListener('change', () => {
                    updateMarcaOptions();
                });

                // On page load, update brand options based on current category selection
                updateMarcaOptions();
            }

            // Calcular stock automáticamente
            const ingresoInput = document.querySelector('input[name="Ingreso"]');
            const salidaInput = document.querySelector('input[name="Salida"]');
            const stockInput = document.querySelector('input[name="Stock"]');

            function calcularStock() {
                const ingreso = parseInt(ingresoInput.value) || 0;
                const salida = parseInt(salidaInput.value) || 0;
                const stock = ingreso - salida;
                stockInput.value = stock;
            }

            if (ingresoInput && salidaInput && stockInput) {
                ingresoInput.addEventListener('input', calcularStock);
                salidaInput.addEventListener('input', calcularStock);
                
                // Calcular stock inicial
                calcularStock();
            }
        });
    </script>

    <!-- Script del modal personalizado para eliminar productos -->
    <script>
        // Función global para confirmar eliminación de productos
        window.confirmarEliminacionProducto = function(event, nombreProducto) {
            console.log('Función confirmarEliminacionProducto llamada con:', nombreProducto);
            event.preventDefault();
            
            Swal.fire({
                title: '⚠️ ¿Eliminar Producto?',
                html: `
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 48px; margin-bottom: 20px;">🗑️</div>
                        <p style="font-size: 18px; color: #333; margin-bottom: 10px;">
                            <strong>¿Estás seguro de eliminar este producto?</strong>
                        </p>
                        <p style="font-size: 16px; color: #666; background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #ff4757;">
                            <strong>Producto:</strong> ${nombreProducto}
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
                                    Eliminando producto <strong>${nombreProducto}</strong>
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
        };

        // Mostrar mensaje de éxito si hay un parámetro en la URL
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM cargado, verificando parámetros de URL...');
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('deleted') === 'success') {
                Swal.fire({
                    title: '✅ ¡Producto Eliminado!',
                    html: `
                        <div style="text-align: center; padding: 20px;">
                            <div style="font-size: 48px; margin-bottom: 20px;">🎉</div>
                            <p style="font-size: 18px; color: #333; margin-bottom: 10px;">
                                <strong>El producto ha sido eliminado exitosamente</strong>
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
        
        console.log('Script de confirmación de productos cargado correctamente');
    </script>
    </main><!-- /main-content -->
    </div><!-- /dashboard-wrapper -->

    <footer>
        &copy; {{ date('Y') }} Technova
    </footer>

</body>
</html>
