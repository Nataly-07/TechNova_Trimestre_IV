<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Editar Movimiento de Artículo - Technova</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
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
        .form-editar-producto {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }
        .form-editar-producto h2 {
            color: #007acc;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-editar-producto input[type="text"],
        .form-editar-producto input[type="number"],
        .form-editar-producto select,
        .form-editar-producto textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-editar-producto input:focus,
        .form-editar-producto select:focus,
        .form-editar-producto textarea:focus {
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
        
        /* Estilo para la sección de información del sistema */
        .info-sistema {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border: 2px solid #e1f5fe;
            box-shadow: 0 2px 10px rgba(33, 150, 243, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .info-sistema::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #2196f3 0%, #9c27b0 100%);
        }
        
        .info-sistema h4 {
            margin: 0 0 15px 0;
            color: #1976d2;
            font-size: 1.1em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-sistema p {
            margin: 0;
            color: #424242;
            font-size: 0.95em;
            line-height: 1.6;
        }
        
        .info-sistema strong {
            color: #1976d2;
            font-weight: 600;
        }
        
        /* Estilo para campos deshabilitados */
        input[disabled] {
            background-color: #f5f5f5 !important;
            color: #666 !important;
            cursor: not-allowed !important;
            border-color: #ddd !important;
            opacity: 0.7;
        }
        
        input[disabled]:focus {
            outline: none !important;
            border-color: #ddd !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body>

        <!-- PRINCIPAL -->
        <main class="main-content">
            <h1><i class='bx bx-edit'></i> Editar Movimiento de Artículo</h1>

            <div class="form-editar-producto">
        <h2>Editar Movimiento de Artículo</h2>
        
        <div class="info-sistema">
            <h4><i class='bx bx-info-circle'></i> Información del Sistema</h4>
            <p>
                <strong>Ingreso:</strong> Solo el administrador puede modificar productos que ingresan al inventario.<br>
                <strong>Salida:</strong> Se actualiza automáticamente cuando los clientes realizan compras.<br>
                <strong>Stock:</strong> Se calcula automáticamente como Ingreso - Salida.
            </p>
        </div>

        @if($errors->any())
            <div style="color: red; margin-bottom: 20px; padding: 10px; border: 1px solid red; border-radius: 5px; background-color: #ffe6e6;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div style="color: #00d4ff; margin-bottom: 20px; padding: 10px; border: 1px solid #00d4ff; border-radius: 5px; background: var(--gradient-light);">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="color: red; margin-bottom: 20px; padding: 10px; border: 1px solid red; border-radius: 5px; background-color: #ffe6e6;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('productos.update', $producto->ID_Producto) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="Codigo" value="{{ $producto->Codigo }}" required placeholder="Código" />
            <input type="text" name="Nombre" value="{{ $producto->Nombre }}" required placeholder="Nombre" />
<input type="text" name="Imagen" value="{{ old('Imagen', $producto->Imagen) }}" placeholder="URL de la imagen" />
<select name="Categoria" required>
    <option value="">Selecciona una categoría</option>
    <option value="Celulares" {{ ($producto->caracteristicas->Categoria ?? '') == 'Celulares' ? 'selected' : '' }}>📱 Celulares</option>
    <option value="Portátiles" {{ ($producto->caracteristicas->Categoria ?? '') == 'Portátiles' ? 'selected' : '' }}>💻 Portátiles</option>
</select>
            <input type="text" name="Color" value="{{ $producto->caracteristicas->Color ?? '' }}" required placeholder="Color" />
            <textarea name="Descripcion" placeholder="Descripción">{{ $producto->caracteristicas->Descripcion ?? '' }}</textarea>
            <input type="number" name="Precio_Compra" id="precio_compra_edit" value="{{ $producto->caracteristicas->Precio_Compra ?? '' }}" required placeholder="Precio de compra" />
            <input type="number" name="Porcentaje_Ganancia" id="porcentaje_ganancia_edit" value="{{ $producto->caracteristicas->Porcentaje_Ganancia ?? '' }}" required placeholder="Porcentaje de Ganancia (%)" min="0" max="1000" step="0.01" />
            <input type="number" name="Precio_Venta" id="precio_venta_edit" value="{{ $producto->caracteristicas->Precio_Venta ?? '' }}" required placeholder="Precio de venta" readonly disabled />
<select name="Marca" required>
    <option value="">Selecciona una marca</option>
    <option value="Apple" {{ ($producto->caracteristicas->Marca ?? '') == 'Apple' ? 'selected' : '' }}> Apple</option>
    <option value="Samsung" {{ ($producto->caracteristicas->Marca ?? '') == 'Samsung' ? 'selected' : '' }}>📱 Samsung</option>
    <option value="Motorola" {{ ($producto->caracteristicas->Marca ?? '') == 'Motorola' ? 'selected' : '' }}>📞 Motorola</option>
    <option value="Xiaomi" {{ ($producto->caracteristicas->Marca ?? '') == 'Xiaomi' ? 'selected' : '' }}>🧡 Xiaomi</option>
    <option value="OPPO" {{ ($producto->caracteristicas->Marca ?? '') == 'OPPO' ? 'selected' : '' }}>📲 OPPO</option>
    <option value="Lenovo" {{ ($producto->caracteristicas->Marca ?? '') == 'Lenovo' ? 'selected' : '' }}>💻 Lenovo</option>
</select>
            <div style="margin-bottom: 15px;">
                <label for="Ingreso" style="display: block; margin-bottom: 5px; font-weight: bold; color: #333;">Ingreso de Artículos</label>
                <input type="number" name="Ingreso" id="Ingreso" value="{{ $producto->Ingreso ?? 0 }}" required placeholder="Cantidad de productos que ingresan" />
                <small style="display: block; margin-top: 3px; color: #666; font-size: 0.85em; font-style: italic;">Artículos que el administrador registra como ingresados al inventario</small>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="Salida" style="display: block; margin-bottom: 5px; font-weight: bold; color: #333;">Salida de Artículos</label>
                <input type="number" name="Salida" id="Salida" value="{{ $producto->Salida ?? 0 }}" placeholder="Cantidad de productos que salen" readonly style="background-color: #f5f5f5; cursor: not-allowed; border-color: #ddd;" />
                <small style="display: block; margin-top: 3px; color: #666; font-size: 0.85em; font-style: italic;">Artículos que salen por compras (se actualizará automáticamente)</small>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="Stock" style="display: block; margin-bottom: 5px; font-weight: bold; color: #333;">Stock Actual</label>
                <input type="number" name="Stock" id="Stock" value="{{ $producto->Stock }}" placeholder="Stock calculado automáticamente" readonly style="background-color: #f5f5f5; cursor: not-allowed; border-color: #ddd;" />
                <small style="display: block; margin-top: 3px; color: #666; font-size: 0.85em; font-style: italic;">Stock = Ingreso - Salida (no editable por el administrador)</small>
            </div>
                <button type="submit" class="btn-guardar">
                    <i class='bx bx-save'></i> Actualizar Movimiento
                </button>
                
                <a href="{{ route('productos.index') }}" class="btn-cancelar" style="text-decoration: none; display: block; text-align: center;">
                    <i class='bx bx-x'></i> Cancelar
                </a>
            </form>
            </div>
        </main><!-- /main-content -->
    </div><!-- /dashboard-wrapper -->

    <footer>
        &copy; {{ date('Y') }} Technova
    </footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoriaSelect = document.querySelector('select[name="Categoria"]');
        const marcaSelect = document.querySelector('select[name="Marca"]');

        const categoryBrandMap = {
            'Celulares': ['Apple', 'Samsung', 'Motorola', 'Xiaomi', 'OPPO'],
            'Portátiles': ['Lenovo']
        };

        function updateMarcaOptions() {
            const selectedCategory = categoriaSelect.value;
            const allowedBrands = categoryBrandMap[selectedCategory] || [];
            let currentSelectedBrand = marcaSelect.value;

            Array.from(marcaSelect.options).forEach(option => {
                if (option.value === '') {
                    option.disabled = false;
                } else if (allowedBrands.includes(option.value)) {
                    option.disabled = false;
                } else {
                    option.disabled = true;
                    if (option.selected) {
                        option.selected = false;
                        currentSelectedBrand = '';
                    }
                }
            });

            // If no brand is selected and there are allowed brands, select the first one
            if (!currentSelectedBrand && allowedBrands.length > 0) {
                marcaSelect.value = allowedBrands[0];
            }
        }

        if (categoriaSelect && marcaSelect) {
            categoriaSelect.addEventListener('change', () => {
                updateMarcaOptions();
            });

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

        // Cálculo automático del precio de venta
        const precioCompraInput = document.getElementById('precio_compra_edit');
        const porcentajeGananciaInput = document.getElementById('porcentaje_ganancia_edit');
        const precioVentaInput = document.getElementById('precio_venta_edit');

        function calcularPrecioVenta() {
            const precioCompra = parseFloat(precioCompraInput.value) || 0;
            const porcentajeGanancia = parseFloat(porcentajeGananciaInput.value) || 0;
            
            if (precioCompra > 0 && porcentajeGanancia >= 0) {
                const ganancia = (precioCompra * porcentajeGanancia) / 100;
                const precioVenta = precioCompra + ganancia;
                precioVentaInput.value = precioVenta.toFixed(2);
            } else {
                precioVentaInput.value = '';
            }
        }

        // Agregar event listeners para el cálculo automático
        if (precioCompraInput && porcentajeGananciaInput && precioVentaInput) {
            precioCompraInput.addEventListener('input', calcularPrecioVenta);
            porcentajeGananciaInput.addEventListener('input', calcularPrecioVenta);
            
            // Calcular al cargar la página si ya hay valores
            calcularPrecioVenta();
        }
    });
</script>
    </main><!-- /main-content -->
    </div><!-- /dashboard-wrapper -->

    <footer>
        &copy; {{ date('Y') }} Technova
    </footer>

</body>
</html>
