<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Technova</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}" />
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
                <div class="enlace active"><a href="{{ route('reportes.index') }}"><i class='bx bx-file-blank'></i> Reportes</a></div>
                <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-message'></i> Mensajes</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-cart'></i> Pedidos</a></div>
                <div class="enlace"><a href="#"><i class='bx bx-credit-card'></i> Pagos</a></div>
                <div class="enlace"><a href="{{ route('logout') }}"><i class='bx bx-log-out'></i> Cerrar Sesión</a></div>
            </div>

        </div><!-- /.menu-dashboard -->

        <main class="main-content">
    <style>
        .reportes-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .reporte-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .reporte-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--gradient-primary);
        }

        .reporte-header i {
            font-size: 2.5em;
            color: var(--gradient-primary);
            margin-right: 15px;
        }

        .reporte-header h2 {
            color: #333;
            margin: 0;
            font-size: 1.8em;
        }

        .filtros-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .filtro-group {
            display: flex;
            flex-direction: column;
        }

        .filtro-group label {
            font-weight: 600;
            color: #333 !important;
            margin-bottom: 8px;
            font-size: 0.9em;
        }

        .filtro-group input,
        .filtro-group select {
            padding: 10px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.9em;
            transition: all 0.3s ease;
        }

        .filtro-group input:focus,
        .filtro-group select:focus {
            outline: none;
            border-color: var(--gradient-primary);
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }

        .btn-generar {
            background: var(--gradient-secondary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-generar:hover {
            background: var(--gradient-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 212, 255, 0.3);
        }

        .btn-generar:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--gradient-primary);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .info-text {
            background: var(--gradient-light);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            color: #333 !important;
            font-size: 0.9em;
        }

    </style>
</head>
<body>
        <main class="main-content">
            <div class="reportes-container">
                <h1 style="color: var(--gradient-primary); margin-bottom: 30px; text-align: center;">
                    <i class="bx bx-file-blank"></i> Sistema de Reportes
                </h1>

                <!-- Sección de información -->
                <div class="reporte-card" style="background: linear-gradient(135deg, #e3f2fd, #f0f8ff); border-left: 5px solid var(--gradient-primary);">
                    <div class="reporte-header">
                        <i class="bx bx-info-circle"></i>
                        <h2>¿Cómo usar el Sistema de Reportes?</h2>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
                        <div style="background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <h4 style="color: #00d4ff !important; margin: 0 0 10px 0;"><i class="bx bx-filter-alt"></i> 1. Configurar Filtros</h4>
                            <p style="margin: 0; color: #333 !important; font-size: 0.9em;">Selecciona los criterios que deseas aplicar para filtrar los datos. Puedes combinar múltiples filtros para obtener resultados específicos.</p>
                        </div>
                        
                        <div style="background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <h4 style="color: #00d4ff !important; margin: 0 0 10px 0;"><i class="bx bx-show"></i> 2. Vista Previa</h4>
                            <p style="margin: 0; color: #333 !important; font-size: 0.9em;">Haz clic en "Vista Previa" para ver los resultados antes de generar el PDF. Esto te permite verificar que los filtros funcionan correctamente.</p>
                        </div>
                        
                        <div style="background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <h4 style="color: #00d4ff !important; margin: 0 0 10px 0;"><i class="bx bx-download"></i> 3. Generar PDF</h4>
                            <p style="margin: 0; color: #333 !important; font-size: 0.9em;">Una vez satisfecho con la vista previa, haz clic en "Generar PDF" para descargar el reporte completo en formato PDF.</p>
                        </div>
                    </div>
                    
                    <div style="margin-top: 20px; padding: 15px; background: rgba(0, 212, 255, 0.1); border-radius: 10px;">
                        <h4 style="color: #00d4ff !important; margin: 0 0 10px 0;"><i class="bx bx-lightbulb"></i> Tip:</h4>
                        <p style="margin: 0; color: #333 !important; font-size: 0.9em;">Los reportes incluyen un resumen estadístico y se pueden usar para análisis de inventario, gestión de usuarios y toma de decisiones empresariales.</p>
                    </div>
                </div>

                <!-- Reporte de Productos -->
                <div class="reporte-card">
                    <div class="reporte-header">
                        <i class="bx bx-package"></i>
                        <h2>Reporte de Productos</h2>
                    </div>
                    
                    <div class="info-text">
                        <i class="bx bx-info-circle"></i>
                        Genera un reporte detallado de productos con filtros personalizables. El reporte incluye información de inventario, precios y proveedores.
                    </div>

                    <form id="formProductos" action="{{ route('reportes.productos') }}" method="GET">
                        <div class="filtros-grid">
                            <div class="filtro-group">
                                <label for="categoria">Categoría</label>
                                <select name="categoria" id="categoria">
                                    <option value="">Todas las categorías</option>
                                </select>
                            </div>

                            <div class="filtro-group">
                                <label for="marca">Marca</label>
                                <select name="marca" id="marca">
                                    <option value="">Todas las marcas</option>
                                </select>
                            </div>


                            <div class="filtro-group">
                                <label for="precio_min">Precio Mínimo</label>
                                <input type="number" name="precio_min" id="precio_min" placeholder="Ej: 100000">
                            </div>

                            <div class="filtro-group">
                                <label for="precio_max">Precio Máximo</label>
                                <input type="number" name="precio_max" id="precio_max" placeholder="Ej: 5000000">
                            </div>

                            <div class="filtro-group">
                                <label for="stock_min">Stock Mínimo</label>
                                <input type="number" name="stock_min" id="stock_min" placeholder="Ej: 10">
                            </div>

                            <div class="filtro-group">
                                <label for="fecha_desde">Fecha Desde</label>
                                <input type="date" name="fecha_desde" id="fecha_desde">
                            </div>

                            <div class="filtro-group">
                                <label for="fecha_hasta">Fecha Hasta</label>
                                <input type="date" name="fecha_hasta" id="fecha_hasta">
                            </div>
                        </div>

                        <div style="display: flex; gap: 15px; margin-top: 20px;">
                            <button type="button" class="btn-generar" id="btnPreviewProductos" style="background: var(--gradient-primary);">
                                <i class="bx bx-show"></i>
                                Vista Previa
                            </button>
                            <button type="submit" class="btn-generar" id="btnProductos">
                                <i class="bx bx-download"></i>
                                Generar PDF
                            </button>
                        </div>
                    </form>

                    <div class="loading" id="loadingProductos">
                        <div class="spinner"></div>
                        <p>Generando reporte...</p>
                    </div>
                </div>

                <!-- Reporte de Usuarios -->
                <div class="reporte-card">
                    <div class="reporte-header">
                        <i class="bx bx-user"></i>
                        <h2>Reporte de Usuarios</h2>
                    </div>
                    
                    <div class="info-text">
                        <i class="bx bx-info-circle"></i>
                        Genera un reporte completo de usuarios registrados con filtros por rol, estado y fechas de registro.
                    </div>

                    <form id="formUsuarios" action="{{ route('reportes.usuarios') }}" method="GET">
                        <div class="filtros-grid">
                            <div class="filtro-group">
                                <label for="rol">Rol</label>
                                <select name="rol" id="rol">
                                    <option value="">Todos los roles</option>
                                </select>
                            </div>


                            <div class="filtro-group">
                                <label for="busqueda">Buscar</label>
                                <input type="text" name="busqueda" id="busqueda" placeholder="Nombre, email o documento">
                            </div>

                            <div class="filtro-group">
                                <label for="fecha_desde_usuarios">Fecha Registro Desde</label>
                                <input type="date" name="fecha_desde" id="fecha_desde_usuarios">
                            </div>

                            <div class="filtro-group">
                                <label for="fecha_hasta_usuarios">Fecha Registro Hasta</label>
                                <input type="date" name="fecha_hasta" id="fecha_hasta_usuarios">
                            </div>
                        </div>

                        <div style="display: flex; gap: 15px; margin-top: 20px;">
                            <button type="button" class="btn-generar" id="btnPreviewUsuarios" style="background: var(--gradient-primary);">
                                <i class="bx bx-show"></i>
                                Vista Previa
                            </button>
                            <button type="submit" class="btn-generar" id="btnUsuarios">
                                <i class="bx bx-download"></i>
                                Generar PDF
                            </button>
                        </div>
                    </form>

                    <div class="loading" id="loadingUsuarios">
                        <div class="spinner"></div>
                        <p>Generando reporte...</p>
                    </div>
                </div>

                <!-- Reporte de Ventas -->
                <div class="reporte-card">
                    <div class="reporte-header">
                        <i class="bx bx-chart-line"></i>
                        <h2>📊 Reporte de Ventas</h2>
                    </div>
                    
                    <div class="info-text">
                        <i class="bx bx-info-circle"></i>
                        Genera un reporte detallado de ventas con estadísticas, gráficos y análisis de rendimiento. Incluye métricas de productos más vendidos, ingresos por período y tendencias de ventas.
                    </div>

                    <form id="formVentas" action="{{ route('reportes.ventas') }}" method="GET">
                        <div class="filtros-grid">
                            <div class="filtro-group">
                                <label for="tipo_reporte">Tipo de Reporte</label>
                                <select name="tipo_reporte" id="tipo_reporte">
                                    <option value="general">Reporte General</option>
                                    <option value="productos">Por Productos</option>
                                    <option value="categorias">Por Categorías</option>
                                    <option value="marcas">Por Marcas</option>
                                    <option value="tendencias">Análisis de Tendencias</option>
                                </select>
                            </div>

                            <div class="filtro-group">
                                <label for="periodo">Período</label>
                                <select name="periodo" id="periodo">
                                    <option value="hoy">Hoy</option>
                                    <option value="semana">Esta Semana</option>
                                    <option value="mes" selected>Este Mes</option>
                                    <option value="trimestre">Este Trimestre</option>
                                    <option value="año">Este Año</option>
                                    <option value="personalizado">Período Personalizado</option>
                                </select>
                            </div>

                            <div class="filtro-group" id="fecha_desde_ventas_group">
                                <label for="fecha_desde_ventas">Fecha Desde</label>
                                <input type="date" name="fecha_desde" id="fecha_desde_ventas">
                            </div>

                            <div class="filtro-group" id="fecha_hasta_ventas_group">
                                <label for="fecha_hasta_ventas">Fecha Hasta</label>
                                <input type="date" name="fecha_hasta" id="fecha_hasta_ventas">
                            </div>

                            <div class="filtro-group">
                                <label for="categoria_ventas">Categoría</label>
                                <select name="categoria" id="categoria_ventas">
                                    <option value="">Todas las categorías</option>
                                    <option value="celulares">📱 Celulares</option>
                                    <option value="portatiles">💻 Portátiles</option>
                                </select>
                            </div>

                            <div class="filtro-group">
                                <label for="marca_ventas">Marca</label>
                                <select name="marca" id="marca_ventas">
                                    <option value="">Todas las marcas</option>
                                    <option value="apple">🍎 Apple</option>
                                    <option value="samsung">📱 Samsung</option>
                                    <option value="motorola">📞 Motorola</option>
                                    <option value="xiaomi">🧡 Xiaomi</option>
                                    <option value="oppo">📲 OPPO</option>
                                    <option value="lenovo">💻 Lenovo</option>
                                </select>
                            </div>

                            <div class="filtro-group">
                                <label for="estado_venta">Estado de Venta</label>
                                <select name="estado" id="estado_venta">
                                    <option value="">Todos los estados</option>
                                    <option value="completada">✅ Completada</option>
                                    <option value="pendiente">⏳ Pendiente</option>
                                    <option value="cancelada">❌ Cancelada</option>
                                    <option value="procesando">🔄 Procesando</option>
                                </select>
                            </div>

                            <div class="filtro-group">
                                <label for="monto_min">Monto Mínimo</label>
                                <input type="number" name="monto_min" id="monto_min" placeholder="Ej: 50000" step="1000">
                            </div>
                        </div>


                        <div style="display: flex; gap: 15px; margin-top: 20px;">
                            <button type="button" class="btn-generar" id="btnPreviewVentas" style="background: var(--gradient-primary);">
                                <i class="bx bx-show"></i>
                                Vista Previa
                            </button>
                            <button type="submit" class="btn-generar" id="btnVentas">
                                <i class="bx bx-download"></i>
                                Generar PDF
                            </button>
                        </div>
                    </form>

                    <div class="loading" id="loadingVentas">
                        <div class="spinner"></div>
                        <p>Generando reporte de ventas...</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Cargar datos para filtros
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route("reportes.filtros") }}')
                .then(response => response.json())
                .then(data => {
                    // Llenar categorías
                    data.categorias.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria;
                        option.textContent = categoria;
                        document.getElementById('categoria').appendChild(option);
                    });

                    // Llenar marcas
                    data.marcas.forEach(marca => {
                        const option = document.createElement('option');
                        option.value = marca;
                        option.textContent = marca;
                        document.getElementById('marca').appendChild(option);
                    });


                    // Llenar roles
                    data.roles.forEach(rol => {
                        const option = document.createElement('option');
                        option.value = rol;
                        option.textContent = rol.charAt(0).toUpperCase() + rol.slice(1);
                        document.getElementById('rol').appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        });

        // Manejar envío de formularios
        document.getElementById('formProductos').addEventListener('submit', function() {
            document.getElementById('btnProductos').disabled = true;
            document.getElementById('loadingProductos').style.display = 'block';
        });

        document.getElementById('formUsuarios').addEventListener('submit', function() {
            document.getElementById('btnUsuarios').disabled = true;
            document.getElementById('loadingUsuarios').style.display = 'block';
        });

        // Manejar vista previa de productos
        document.getElementById('btnPreviewProductos').addEventListener('click', function() {
            const form = document.getElementById('formProductos');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);
            window.open('{{ route("reportes.preview.productos") }}?' + params.toString(), '_blank');
        });

        // Manejar vista previa de usuarios
        document.getElementById('btnPreviewUsuarios').addEventListener('click', function() {
            const form = document.getElementById('formUsuarios');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);
            window.open('{{ route("reportes.preview.usuarios") }}?' + params.toString(), '_blank');
        });

        // Manejar funcionalidad de reportes de ventas
        document.getElementById('formVentas').addEventListener('submit', function() {
            document.getElementById('btnVentas').disabled = true;
            document.getElementById('loadingVentas').style.display = 'block';
        });

        // Manejar vista previa de ventas
        document.getElementById('btnPreviewVentas').addEventListener('click', function() {
            const form = document.getElementById('formVentas');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);
            window.open('{{ route("reportes.preview.ventas") }}?' + params.toString(), '_blank');
        });


        // Manejar cambio de período
        document.getElementById('periodo').addEventListener('change', function() {
            const fechaDesdeGroup = document.getElementById('fecha_desde_ventas_group');
            const fechaHastaGroup = document.getElementById('fecha_hasta_ventas_group');
            
            if (this.value === 'personalizado') {
                fechaDesdeGroup.style.display = 'flex';
                fechaHastaGroup.style.display = 'flex';
                document.getElementById('fecha_desde_ventas').required = true;
                document.getElementById('fecha_hasta_ventas').required = true;
            } else {
                fechaDesdeGroup.style.display = 'none';
                fechaHastaGroup.style.display = 'none';
                document.getElementById('fecha_desde_ventas').required = false;
                document.getElementById('fecha_hasta_ventas').required = false;
            }
        });

        // Inicializar estado del período
        document.getElementById('periodo').dispatchEvent(new Event('change'));
    </script>
    </main><!-- /main-content -->
    </div><!-- /dashboard-wrapper -->

    <footer>
        &copy; {{ date('Y') }} Technova
    </footer>

</body>
</html>
