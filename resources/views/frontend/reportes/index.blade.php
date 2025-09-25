<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Technova</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <link rel="icon" href="{{ asset('frontend/imagenes/logo technova.png') }}" type="image/png">
    
    <style>
        /* Estilos específicos para reportes */
        .reportes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .reporte-tarjeta {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .reporte-tarjeta:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            border-color: var(--gradient-primary);
        }

        .tarjeta-icono {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .tarjeta-contenido h3 {
            text-align: center;
            color: #333;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .tarjeta-metrica {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .tarjeta-metrica .numero {
            display: block;
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--gradient-primary);
            margin-bottom: 0.5rem;
        }

        .tarjeta-metrica .texto {
            color: #666;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .tarjeta-boton {
            width: 100%;
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tarjeta-boton:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        /* Contenedor de formularios - OCULTO POR DEFECTO */
        #contenedor-formularios {
            display: none;
            visibility: hidden;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        #contenedor-formularios.mostrar {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            max-height: 2000px !important;
            position: relative !important;
            z-index: 10 !important;
        }

        /* Formularios dinámicos - SOLO VISIBLES CUANDO SE GENERAN */
        .formulario-reporte {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-top: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
            animation: slideDown 0.3s ease;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reporte-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .reporte-header i {
            font-size: 2.5em;
            color: var(--gradient-primary);
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .reporte-header h2 {
            color: #333;
            margin: 0;
            font-size: 1.8rem;
        }

        .info-text {
            background: linear-gradient(135deg, #e3f2fd, #f0f8ff);
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 4px solid var(--gradient-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-text i {
            color: var(--gradient-primary);
            font-size: 1.3rem;
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
            gap: 8px;
        }

        .filtro-group label {
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        .filtro-group select,
        .filtro-group input {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .filtro-group select:focus,
        .filtro-group input:focus {
            outline: none;
            border-color: var(--gradient-primary);
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }

        .botones-accion {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-preview,
        .btn-generar {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-preview {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-generar {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-preview:hover,
        .btn-generar:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Info Card */
        .reporte-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .reportes-grid {
                grid-template-columns: 1fr;
            }

            .botones-accion {
                flex-direction: column;
            }
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
      <a href="{{ route('perfilad') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      <a href="{{ route('logout') }}" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
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
        <div class="enlace"><a href="{{ route('admin.dashboard') }}"><i class='bx bx-chart'></i> Dashboard</a></div>
        <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
        <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Movimiento de Artículos</a></div>
        <div class="enlace active"><a href="{{ route('reportes.index') }}"><i class='bx bx-file-blank'></i> Reportes</a></div>
        <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
        <div class="enlace"><a href="{{ route('admin.mensajes.index') }}"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace"><a href="{{ route('admin.orders.index') }}"><i class='bx bx-cart'></i> Pedidos</a></div>
        <div class="enlace"><a href="{{ route('admin.payments.index') }}"><i class='bx bx-credit-card'></i> Pagos</a></div>
        <div class="enlace"><a href="{{ route('logout') }}"><i class='bx bx-log-out'></i> Cerrar Sesión</a></div>
      </div>

    </div><!-- /.menu-dashboard -->

        <main class="main-content">
            <div class="page-header">
                <h1>📊 Sistema de Reportes</h1>
            </div>

            <div class="content-wrapper">
                <!-- Sección de Instrucciones -->
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

                <!-- Tarjetas de Reportes -->
                <div class="reportes-grid">
                    <!-- Tarjeta Reporte de Productos -->
                    <div class="reporte-tarjeta" onclick="mostrarFormulario('productos')">
                        <div class="tarjeta-icono">
                            <i class="bx bx-package"></i>
                        </div>
                        <div class="tarjeta-contenido">
                            <h3>📦 Reporte de Productos</h3>
                            <div class="tarjeta-metrica">
                                <span class="numero">7</span>
                                <span class="texto">PRODUCTOS EN INVENTARIO</span>
                            </div>
                        </div>
                        <button class="tarjeta-boton">
                            → Generar Reporte
                        </button>
                    </div>

                    <!-- Tarjeta Reporte de Usuarios -->
                    <div class="reporte-tarjeta" onclick="mostrarFormulario('usuarios')">
                        <div class="tarjeta-icono">
                            <i class="bx bx-user"></i>
                        </div>
                        <div class="tarjeta-contenido">
                            <h3>👥 Reporte de Usuarios</h3>
                            <div class="tarjeta-metrica">
                                <span class="numero">23</span>
                                <span class="texto">USUARIOS REGISTRADOS</span>
                            </div>
                        </div>
                        <button class="tarjeta-boton">
                            → Generar Reporte
                        </button>
                    </div>

                    <!-- Tarjeta Reporte de Ventas -->
                    <div class="reporte-tarjeta" onclick="mostrarFormulario('ventas')">
                        <div class="tarjeta-icono">
                            <i class="bx bx-chart-line"></i>
                        </div>
                        <div class="tarjeta-contenido">
                            <h3>📊 Reporte de Ventas</h3>
                            <div class="tarjeta-metrica">
                                <span class="numero">3</span>
                                <span class="texto">REPORTES DISPONIBLES</span>
                            </div>
                        </div>
                        <button class="tarjeta-boton">
                            → Generar Reporte
                        </button>
                    </div>
                </div>

                <!-- Contenedor para formularios dinámicos -->
                <div id="contenedor-formularios">
                    <!-- Los formularios se cargarán aquí dinámicamente -->
                </div>

                <!-- Sección de información -->
            </div>
        </main>
  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

    <script>
        // Sistema de tarjetas con formularios dinámicos
        function mostrarFormulario(tipo) {
            console.log('Mostrando formulario:', tipo);
            
            // Obtener contenedor
            const contenedor = document.getElementById('contenedor-formularios');
            
            // Limpiar contenedor completamente
            contenedor.innerHTML = '';
            contenedor.classList.remove('mostrar');
            
            // Generar formulario dinámicamente
            let formularioHTML = '';
            
            switch(tipo) {
                case 'productos':
                    formularioHTML = `
                        <div class="formulario-reporte activo">
                    <div class="reporte-header">
                        <i class="bx bx-package"></i>
                                <h2>📦 Reporte de Productos</h2>
                    </div>
                    
                    <div class="info-text">
                        <i class="bx bx-info-circle"></i>
                                Genera reportes detallados de inventario con filtros por categoría, marca, precio y stock.
                    </div>

                    <form id="formProductos" action="{{ route('reportes.productos') }}" method="GET">
                        <div class="filtros-grid">
                            <div class="filtro-group">
                                <label for="categoria">Categoría</label>
                                <select name="categoria" id="categoria">
                                    <option value="">Todas las categorías</option>
                                            <!-- Las opciones se cargarán dinámicamente desde la base de datos -->
                                </select>
                            </div>

                            <div class="filtro-group">
                                <label for="marca">Marca</label>
                                <select name="marca" id="marca">
                                    <option value="">Todas las marcas</option>
                                            <!-- Las opciones se cargarán dinámicamente desde la base de datos -->
                                </select>
                            </div>

                            <div class="filtro-group">
                                <label for="precio_min">Precio Mínimo</label>
                                        <input type="number" name="precio_min" id="precio_min" placeholder="0" min="0" step="0.01">
                            </div>

                            <div class="filtro-group">
                                <label for="precio_max">Precio Máximo</label>
                                        <input type="number" name="precio_max" id="precio_max" placeholder="1000000" min="0" step="0.01">
                            </div>

                            <div class="filtro-group">
                                <label for="stock_min">Stock Mínimo</label>
                                        <input type="number" name="stock_min" id="stock_min" placeholder="0" min="0">
                            </div>

                            <div class="filtro-group">
                                        <label for="proveedor">Proveedor</label>
                                        <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del proveedor">
                            </div>
                        </div>

                                <div class="botones-accion">
                                    <button type="button" class="btn-preview" onclick="previewReporte('productos')">
                                        <i class="bx bx-show"></i> Vista Previa
                            </button>
                                    <button type="submit" class="btn-generar">
                                        <i class="bx bx-download"></i> Generar PDF
                            </button>
                        </div>
                    </form>
                    </div>
                    `;
                    break;

                case 'usuarios':
                    formularioHTML = `
                        <div class="formulario-reporte activo">
                    <div class="reporte-header">
                        <i class="bx bx-user"></i>
                                <h2>👥 Reporte de Usuarios</h2>
                    </div>
                    
                    <div class="info-text">
                        <i class="bx bx-info-circle"></i>
                                Analiza usuarios registrados con filtros por rol, fecha de registro y actividad.
                    </div>

                    <form id="formUsuarios" action="{{ route('reportes.usuarios') }}" method="GET">
                        <div class="filtros-grid">
                            <div class="filtro-group">
                                        <label for="rol">Rol de Usuario</label>
                                <select name="rol" id="rol">
                                    <option value="">Todos los roles</option>
                                            <!-- Las opciones se cargarán dinámicamente desde la base de datos -->
                                </select>
                            </div>

                            <div class="filtro-group">
                                <label for="busqueda">Buscar</label>
                                <input type="text" name="busqueda" id="busqueda" placeholder="Nombre, email o documento">
                            </div>

                            <div class="filtro-group">
                                        <label for="fecha_desde">Fecha Registro Desde</label>
                                        <input type="date" name="fecha_desde" id="fecha_desde">
                            </div>

                            <div class="filtro-group">
                                        <label for="fecha_hasta">Fecha Registro Hasta</label>
                                        <input type="date" name="fecha_hasta" id="fecha_hasta">
                            </div>

                            <div class="filtro-group">
                                        <label for="tipo_documento">Tipo de Documento</label>
                                        <select name="tipo_documento" id="tipo_documento">
                                            <option value="">Todos los tipos</option>
                                            <option value="CC">Cédula de Ciudadanía</option>
                                            <option value="CE">Cédula de Extranjería</option>
                                            <option value="TI">Tarjeta de Identidad</option>
                                            <option value="PA">Pasaporte</option>
                                        </select>
                            </div>
                        </div>

                                <div class="botones-accion">
                                    <button type="button" class="btn-preview" onclick="previewReporte('usuarios')">
                                        <i class="bx bx-show"></i> Vista Previa
                            </button>
                                    <button type="submit" class="btn-generar">
                                        <i class="bx bx-download"></i> Generar PDF
                            </button>
                        </div>
                    </form>
                    </div>
                    `;
                    break;

                case 'ventas':
                    formularioHTML = `
                        <div class="formulario-reporte activo">
                    <div class="reporte-header">
                        <i class="bx bx-chart-line"></i>
                        <h2>📊 Reporte de Ventas</h2>
                    </div>
                    
                    <div class="info-text">
                        <i class="bx bx-info-circle"></i>
                                Genera reportes detallados de ventas con estadísticas, gráficos y análisis de rendimiento.
                    </div>

                    <form id="formVentas" action="{{ route('reportes.ventas') }}" method="GET">
                        <div class="filtros-grid">
                            <div class="filtro-group">
                                        <label for="categoria">Categoría</label>
                                        <select name="categoria" id="categoria">
                                            <option value="">Todas las categorías</option>
                                            <!-- Las opciones se cargarán dinámicamente desde la base de datos -->
                                </select>
                            </div>

                            <div class="filtro-group">
                                        <label for="marca">Marca</label>
                                        <select name="marca" id="marca">
                                            <option value="">Todas las marcas</option>
                                            <!-- Las opciones se cargarán dinámicamente desde la base de datos -->
                                </select>
                            </div>

                            <div class="filtro-group">
                                        <label for="estado">Estado de Venta</label>
                                        <select name="estado" id="estado">
                                            <option value="">Todos los estados</option>
                                            <option value="completada">Completada</option>
                                            <option value="pendiente">Pendiente</option>
                                            <option value="procesando">Procesando</option>
                                            <option value="cancelada">Cancelada</option>
                                </select>
                            </div>

                            <div class="filtro-group">
                                        <label for="fecha_desde">Fecha Desde</label>
                                        <input type="date" name="fecha_desde" id="fecha_desde">
                            </div>

                            <div class="filtro-group">
                                        <label for="fecha_hasta">Fecha Hasta</label>
                                        <input type="date" name="fecha_hasta" id="fecha_hasta">
                            </div>

                            <div class="filtro-group">
                                <label for="monto_min">Monto Mínimo</label>
                                        <input type="number" name="monto_min" id="monto_min" placeholder="0" min="0" step="0.01">
                            </div>
                        </div>

                                <div class="botones-accion">
                                    <button type="button" class="btn-preview" onclick="previewReporte('ventas')">
                                        <i class="bx bx-show"></i> Vista Previa
                            </button>
                                    <button type="submit" class="btn-generar">
                                        <i class="bx bx-download"></i> Generar Reporte
                            </button>
                        </div>
                    </form>
                    </div>
                    `;
                    break;
            }
            
            // Insertar formulario en el contenedor
            contenedor.innerHTML = formularioHTML;
            
            // Mostrar contenedor con animación
            setTimeout(() => {
                contenedor.classList.add('mostrar');
                console.log('Formulario generado y mostrando:', tipo);
                console.log('Contenedor:', contenedor);
                console.log('Clases del contenedor:', contenedor.classList);
                console.log('Estilos computados:', window.getComputedStyle(contenedor));
                
                // Llenar los selects del formulario recién creado con un pequeño delay
                setTimeout(() => {
                    llenarSelectsFormulario();
                }, 100);
                
                // Scroll suave al formulario
                contenedor.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }, 200);
        }
        
        function previewReporte(tipo) {
            // Obtener datos del formulario
            const form = document.getElementById(`form${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`);
            if (!form) return;
            
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);
            
            // Construir URL de vista previa
            let previewUrl = '';
            switch(tipo) {
                case 'productos':
                    previewUrl = '{{ route("reportes.preview.productos") }}';
                    break;
                case 'usuarios':
                    previewUrl = '{{ route("reportes.preview.usuarios") }}';
                    break;
                case 'ventas':
                    previewUrl = '{{ route("reportes.preview.ventas") }}';
                    break;
            }
            
            if (previewUrl) {
                // Abrir vista previa en nueva ventana
                window.open(`${previewUrl}?${params.toString()}`, '_blank');
            }
        }
        
        // Cargar datos para filtros
        function cargarDatosFiltros() {
            console.log('Cargando datos de filtros...');
            
            // Intentar cargar datos del servidor primero
            fetch('{{ route("reportes.filtros") }}')
                .then(response => {
                    console.log('Respuesta recibida:', response.status);
                    if (!response.ok) {
                        throw new Error('Error en la respuesta: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Datos recibidos del servidor:', data);
                    
                    // Llenar con datos del servidor
                    if (data.categorias && data.categorias.length > 0) {
                        console.log('Cargando categorías del servidor:', data.categorias);
                    data.categorias.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria;
                        option.textContent = categoria;
                            
                            document.querySelectorAll('select[name="categoria"]').forEach(select => {
                                select.appendChild(option.cloneNode(true));
                    });
                        });
                    }

                    if (data.marcas && data.marcas.length > 0) {
                        console.log('Cargando marcas del servidor:', data.marcas);
                    data.marcas.forEach(marca => {
                        const option = document.createElement('option');
                        option.value = marca;
                        option.textContent = marca;
                            
                            document.querySelectorAll('select[name="marca"]').forEach(select => {
                                select.appendChild(option.cloneNode(true));
                    });
                        });
                    }

                    if (data.roles && data.roles.length > 0) {
                        console.log('Cargando roles del servidor:', data.roles);
                    data.roles.forEach(rol => {
                        const option = document.createElement('option');
                        option.value = rol;
                        option.textContent = rol.charAt(0).toUpperCase() + rol.slice(1);
                            
                            document.querySelectorAll('select[name="rol"]').forEach(select => {
                                select.appendChild(option.cloneNode(true));
                            });
                        });
                    }
                })
                .catch(error => {
                    console.error('Error cargando filtros del servidor:', error);
                    console.log('Cargando opciones por defecto como fallback');
                    cargarOpcionesPorDefecto();
                });
        }

        // Función para cargar opciones por defecto
        function cargarOpcionesPorDefecto() {
            console.log('Cargando opciones por defecto...');
            
            // Categorías por defecto
            const categoriasDefault = ['Electrónicos', 'Ropa', 'Hogar', 'Deportes', 'Libros'];
            console.log('Agregando categorías por defecto:', categoriasDefault);
            categoriasDefault.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria;
                option.textContent = categoria;
                
                const selects = document.querySelectorAll('select[name="categoria"]');
                console.log('Encontrados selects de categoría:', selects.length);
                selects.forEach(select => {
                    select.appendChild(option.cloneNode(true));
                });
            });

            // Marcas por defecto
            const marcasDefault = ['Samsung', 'Apple', 'Nike', 'Adidas', 'Sony'];
            console.log('Agregando marcas por defecto:', marcasDefault);
            marcasDefault.forEach(marca => {
                const option = document.createElement('option');
                option.value = marca;
                option.textContent = marca;
                
                const selects = document.querySelectorAll('select[name="marca"]');
                console.log('Encontrados selects de marca:', selects.length);
                selects.forEach(select => {
                    select.appendChild(option.cloneNode(true));
                });
            });

            // Roles por defecto
            const rolesDefault = ['admin', 'cliente', 'empleado'];
            console.log('Agregando roles por defecto:', rolesDefault);
            rolesDefault.forEach(rol => {
                const option = document.createElement('option');
                option.value = rol;
                option.textContent = rol.charAt(0).toUpperCase() + rol.slice(1);
                
                const selects = document.querySelectorAll('select[name="rol"]');
                console.log('Encontrados selects de rol:', selects.length);
                selects.forEach(select => {
                    select.appendChild(option.cloneNode(true));
                });
            });
        }

        // Función para verificar y llenar selects cuando se muestre un formulario
        function llenarSelectsFormulario() {
            console.log('Llenando selects del formulario actual...');
            
            // Verificar si hay selects en el DOM
            const selectsCategoria = document.querySelectorAll('select[name="categoria"]');
            const selectsMarca = document.querySelectorAll('select[name="marca"]');
            const selectsRol = document.querySelectorAll('select[name="rol"]');
            
            console.log('Selects encontrados:', {
                categoria: selectsCategoria.length,
                marca: selectsMarca.length,
                rol: selectsRol.length
            });
            
            // Si no hay selects, no hacer nada
            if (selectsCategoria.length === 0 && selectsMarca.length === 0 && selectsRol.length === 0) {
                console.log('No hay selects para llenar');
                return;
            }
            
            // Usar datos precargados o cargar si no están disponibles
            console.log('=== VERIFICANDO DATOS PRECARGADOS ===');
            console.log('window.datosFiltros existe:', !!window.datosFiltros);
            console.log('window.datosFiltros:', window.datosFiltros);
            
            if (window.datosFiltros) {
                console.log('Usando datos precargados:', window.datosFiltros);
                llenarSelectsConDatos(window.datosFiltros, selectsCategoria, selectsMarca, selectsRol);
            } else {
                console.log('Datos no precargados, cargando ahora...');
                fetch('{{ route("reportes.filtros") }}')
                    .then(response => {
                        console.log('Respuesta del servidor:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Datos cargados del servidor:', data);
                        llenarSelectsConDatos(data, selectsCategoria, selectsMarca, selectsRol);
                    })
                    .catch(error => {
                        console.error('Error cargando datos:', error);
                        console.log('Usando datos por defecto como fallback');
                        
                        // Usar datos por defecto
                        const datosDefault = {
                            categorias: ['Electrónicos', 'Ropa', 'Hogar', 'Deportes', 'Libros'],
                            marcas: ['Samsung', 'Apple', 'Nike', 'Adidas', 'Sony'],
                            roles: ['admin', 'cliente', 'empleado']
                        };
                        llenarSelectsConDatos(datosDefault, selectsCategoria, selectsMarca, selectsRol);
                    });
            }
        }

        // Función auxiliar para llenar selects con datos
        function llenarSelectsConDatos(data, selectsCategoria, selectsMarca, selectsRol) {
            console.log('=== LLENANDO SELECTS CON DATOS ===');
            console.log('Datos recibidos:', data);
            console.log('Selects encontrados:', {
                categoria: selectsCategoria.length,
                marca: selectsMarca.length,
                rol: selectsRol.length
            });
            
                    // Llenar categorías
            if (selectsCategoria.length > 0 && data.categorias && data.categorias.length > 0) {
                console.log('Agregando categorías:', data.categorias);
                selectsCategoria.forEach(select => {
                    // Limpiar opciones existentes (excepto la primera)
                    while (select.children.length > 1) {
                        select.removeChild(select.lastChild);
                    }
                    
                    data.categorias.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria;
                        option.textContent = categoria;
                        console.log('Agregando categoría a select:', categoria);
                        select.appendChild(option);
                    });
                });
            } else {
                console.log('No se pueden agregar categorías:', {
                    selectsLength: selectsCategoria.length,
                    dataCategorias: data.categorias,
                    dataCategoriasLength: data.categorias ? data.categorias.length : 'undefined'
                });
            }

                    // Llenar marcas
            if (selectsMarca.length > 0 && data.marcas && data.marcas.length > 0) {
                console.log('Agregando marcas:', data.marcas);
                selectsMarca.forEach(select => {
                    // Limpiar opciones existentes (excepto la primera)
                    while (select.children.length > 1) {
                        select.removeChild(select.lastChild);
                    }
                    
                    data.marcas.forEach(marca => {
                        const option = document.createElement('option');
                        option.value = marca;
                        option.textContent = marca;
                        console.log('Agregando marca a select:', marca);
                        select.appendChild(option);
                    });
                });
            } else {
                console.log('No se pueden agregar marcas:', {
                    selectsLength: selectsMarca.length,
                    dataMarcas: data.marcas,
                    dataMarcasLength: data.marcas ? data.marcas.length : 'undefined'
                });
            }

            // Llenar roles
            if (selectsRol.length > 0 && data.roles && data.roles.length > 0) {
                console.log('Agregando roles:', data.roles);
                selectsRol.forEach(select => {
                    // Limpiar opciones existentes (excepto la primera)
                    while (select.children.length > 1) {
                        select.removeChild(select.lastChild);
                    }
                    
                    data.roles.forEach(rol => {
                        const option = document.createElement('option');
                        option.value = rol;
                        option.textContent = rol.charAt(0).toUpperCase() + rol.slice(1);
                        console.log('Agregando rol a select:', rol);
                        select.appendChild(option);
                    });
                });
            } else {
                console.log('No se pueden agregar roles:', {
                    selectsLength: selectsRol.length,
                    dataRoles: data.roles,
                    dataRolesLength: data.roles ? data.roles.length : 'undefined'
                });
            }
            
            console.log('=== FIN LLENADO SELECTS ===');
        }

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Sistema de reportes con formularios dinámicos cargado correctamente');
            
            // Asegurar que el contenedor esté oculto
            const contenedor = document.getElementById('contenedor-formularios');
            if (contenedor) {
                contenedor.classList.remove('mostrar');
                contenedor.innerHTML = '';
            }
            
            console.log('Contenedor de formularios oculto correctamente');
            
            // Precargar datos de filtros para uso futuro
            precargarDatosFiltros();
        });

        // Precargar datos de filtros
        function precargarDatosFiltros() {
            console.log('=== PRECARGANDO DATOS DE FILTROS ===');
            console.log('URL:', '{{ route("reportes.filtros") }}');
            
            fetch('{{ route("reportes.filtros") }}')
                .then(response => {
                    console.log('Respuesta recibida:', response.status, response.statusText);
                    if (!response.ok) {
                        throw new Error('Error en la respuesta: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Datos precargados exitosamente:', data);
                    console.log('Categorías:', data.categorias);
                    console.log('Marcas:', data.marcas);
                    console.log('Roles:', data.roles);
                    
                    // Guardar datos globalmente para uso posterior
                    window.datosFiltros = data;
                    console.log('Datos guardados en window.datosFiltros:', window.datosFiltros);
                })
                .catch(error => {
                    console.error('Error precargando filtros:', error);
                    console.log('Usando datos por defecto como fallback');
                    
                    // Datos por defecto
                    window.datosFiltros = {
                        categorias: ['Electrónicos', 'Ropa', 'Hogar', 'Deportes', 'Libros'],
                        marcas: ['Samsung', 'Apple', 'Nike', 'Adidas', 'Sony'],
                        roles: ['admin', 'cliente', 'empleado']
                    };
                    console.log('Datos por defecto guardados:', window.datosFiltros);
                });
        }
    </script>
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>

</body>
</html>