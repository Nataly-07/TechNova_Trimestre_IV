<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $producto->Nombre }} - Technova</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/producto.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 100%);
            padding: 12px 20px;
            border-radius: 25px;
            margin: 20px 0;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .breadcrumb a {
            color: #2c3e50;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(240, 248, 255, 0.8) 100%);
            border: 1px solid rgba(52, 152, 219, 0.3);
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .breadcrumb a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .breadcrumb a:hover::before {
            left: 100%;
        }

        .breadcrumb a:hover {
            color: white;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
            border-color: #3498db;
        }

        .breadcrumb i {
            color: #7f8c8d;
            font-size: 14px;
            margin: 0 4px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }

        .breadcrumb span {
            color: white;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 20px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            border: 1px solid rgba(231, 76, 60, 0.3);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
            position: relative;
            overflow: hidden;
        }

        .breadcrumb span::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            50% { left: 100%; }
            100% { left: 100%; }
        }

        /* Estilos para notificaciones bonitas */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 350px;
            max-width: 500px;
            padding: 20px 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            z-index: 10000;
            transform: translateX(100%);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.95) 0%, rgba(39, 174, 96, 0.95) 100%);
            border-left: 5px solid #27ae60;
        }

        .notification.error {
            background: linear-gradient(135deg, rgba(231, 76, 60, 0.95) 0%, rgba(192, 57, 43, 0.95) 100%);
            border-left: 5px solid #c0392b;
        }

        .notification-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
        }

        .notification-text {
            flex: 1;
            color: white;
            font-weight: 600;
            font-size: 16px;
            line-height: 1.4;
        }

        .notification-close {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        .notification-close:hover {
            opacity: 1;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .notification-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 0 0 15px 15px;
            animation: progress 3s linear forwards;
        }

        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }

        @keyframes bounceIn {
            0% {
                transform: translateX(100%) scale(0.3);
                opacity: 0;
            }
            50% {
                transform: translateX(-10%) scale(1.05);
            }
            70% {
                transform: translateX(0%) scale(0.9);
            }
            100% {
                transform: translateX(0%) scale(1);
                opacity: 1;
            }
        }

        .notification.bounce-in {
            animation: bounceIn 0.6s ease-out;
        }

        .producto-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            align-items: start;
        }

        .producto-imagen {
            text-align: center;
        }

        .producto-imagen img {
            max-width: 90%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .producto-imagen img:hover {
            transform: scale(1.05);
        }

        .producto-info h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .producto-marca {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .producto-categoria {
            display: inline-block;
            background: #f8f9fa;
            color: #666;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 11px;
            margin-left: 8px;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .stars {
            color: #ffc107;
            font-size: 16px;
        }

        .rating-text {
            color: #666;
            font-size: 13px;
        }

        .precio-container {
            margin-bottom: 20px;
        }

        .precio-original {
            text-decoration: line-through;
            color: #999;
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .precio-actual {
            font-size: 2rem;
            font-weight: 700;
            color: #00d4ff;
            margin-bottom: 8px;
        }

        .descuento {
            background: #cce5cc;
            color: #006600;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .stock-info {
            margin-bottom: 20px;
        }

        .stock-disponible {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .stock-disponible.alto {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .stock-disponible.medio {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .stock-disponible.bajo {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .stock-disponible.agotado {
            background: #f5c6cb;
            color: #721c24;
            border: 1px solid #f1b0b7;
        }

        .stock-icon {
            font-size: 16px;
        }

        .stock-text {
            font-weight: 600;
            font-size: 14px;
        }

        .caracteristicas {
            margin-bottom: 20px;
        }

        .caracteristicas h3 {
            color: #333;
            margin-bottom: 12px;
            font-size: 1.1rem;
            border-bottom: 2px solid #667eea;
            padding-bottom: 6px;
        }

        .caracteristica-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .caracteristica-label {
            font-weight: 600;
            color: #666;
        }

        .caracteristica-value {
            color: #333;
        }

        .descripcion {
            margin-bottom: 20px;
        }

        .descripcion h3 {
            color: #333;
            margin-bottom: 12px;
            font-size: 1.1rem;
            border-bottom: 2px solid #667eea;
            padding-bottom: 6px;
        }

        .descripcion p {
            line-height: 1.5;
            color: #666;
            font-size: 14px;
        }

        .acciones {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-align: center;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            flex: 1;
            min-width: 160px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-outline:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .btn-favorito {
            background: #ff6b6b;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            padding: 0;
            font-size: 24px;
        }

        .btn-favorito:hover {
            background: #ff5252;
            transform: scale(1.1);
        }

        .btn-favorito.activo {
            background: #e74c3c;
        }

        .btn-carrito {
            background: #28a745;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            padding: 0;
            font-size: 24px;
        }

        .btn-carrito:hover {
            background: #218838;
            transform: scale(1.1);
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .producto-container {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 20px;
            }

            .producto-info h1 {
                font-size: 2rem;
            }

            .precio-actual {
                font-size: 2rem;
            }

            .acciones {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .btn-favorito,
            .btn-carrito {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Estilos para productos relacionados */
        .productos-relacionados {
            margin-top: 40px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .productos-relacionados-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .productos-relacionados-header h2 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .productos-relacionados-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .productos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .producto-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .producto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .producto-imagen-container {
            position: relative;
            margin-bottom: 15px;
            border-radius: 10px;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .producto-imagen-mini {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background: #f8f9fa;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .producto-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .producto-card:hover .producto-overlay {
            opacity: 1;
        }

        .producto-card:hover .producto-imagen-mini {
            transform: scale(1.1);
        }

        .btn-ver-detalles {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-ver-detalles:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .producto-info-mini h4 {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .producto-marca-mini {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 10px;
        }

        .rating-mini {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 10px;
        }

        .rating-mini .stars {
            color: #ffc107;
            font-size: 14px;
        }

        .rating-mini .rating-text {
            color: #666;
            font-size: 0.9rem;
        }

        .precio-container-mini {
            margin-bottom: 15px;
        }

        .precio-original-mini {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9rem;
            display: block;
        }

        .precio-actual-mini {
            color: #00d4ff;
            font-size: 1.3rem;
            font-weight: 700;
            display: block;
        }

        .descuento-mini {
            background: #cce5cc;
            color: #006600;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 8px;
        }

        .stock-info-mini {
            margin-bottom: 15px;
        }

        .stock-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .stock-badge.alto {
            background: #d4edda;
            color: #155724;
        }

        .stock-badge.medio {
            background: #fff3cd;
            color: #856404;
        }

        .stock-badge.bajo {
            background: #f8d7da;
            color: #721c24;
        }

        .stock-badge.agotado {
            background: #f5c6cb;
            color: #721c24;
        }

        .producto-acciones-mini {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-favorito-mini,
        .btn-carrito-mini {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .btn-favorito-mini {
            background: #ff6b6b;
            color: white;
        }

        .btn-favorito-mini:hover {
            background: #ff5252;
            transform: scale(1.1);
        }

        .btn-favorito-mini.activo {
            background: #e74c3c;
        }

        .btn-carrito-mini {
            background: #28a745;
            color: white;
        }

        .btn-carrito-mini:hover {
            background: #218838;
            transform: scale(1.1);
        }

        .btn-carrito-mini:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
        }

        .no-productos {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .no-productos i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ccc;
        }

        @media (max-width: 768px) {
            .productos-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }

            .productos-relacionados-header h2 {
                font-size: 1.5rem;
            }

            .producto-card {
                padding: 15px;
            }

            .producto-imagen-mini {
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- Header estándar -->
    <header class="header">
        <a href="{{ route('catalogo.autenticado') }}" class="logo">
            <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" style="cursor:pointer;">
            <span>TECHNOVA</span>
        </a>


        @php
            $cartCount = 0;
            try {
                $carritoUser = Auth::user()->carrito ?? null;
                if ($carritoUser) {
                    $cartCount = $carritoUser->detalles()->sum('Cantidad');
                }
            } catch (\Throwable $e) {}
        @endphp

        <div class="acciones-usuario">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('perfilad') }}" class="account">
                    <span>Perfil</span>
                </a>
            @elseif(Auth::user()->role === 'empleado')
                <a href="{{ route('perfilemp') }}" class="account">
                    <span>Perfil</span>
                </a>
            @else
                <a href="{{ route('perfillcli') }}" class="account">
                    <span>Perfil</span>
                </a>
            @endif
            
            <a href="/logout" class="account">
                <span>Cerrar Sesión</span>
            </a>
            
            <a href="{{ route('carrito.index') }}" class="cart">
                <span class="cart-icon">&#128722;</span>
                <span>Carrito</span>
                @if($cartCount > 0)
                    <span class="cart-count">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </header>

    <!-- Navegación -->
    <nav class="menu-principal">
        <ul>
            <li><a href="{{ route('catalogo.autenticado') }}">Inicio</a></li>
            <li class="submenu">
                <a href="#">Categorías ▾</a>
                <ul class="submenu-lista">
                    <li><a href="{{ route('auth.categoria', 'celulares') }}">📱 Celulares</a></li>
                    <li><a href="{{ route('auth.categoria', 'portatiles') }}">💻 Portátiles</a></li>
                    <li><a href="{{ route('auth.categoria', 'accesorios') }}">🎧 Accesorios</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#">Marcas ▾</a>
                <ul class="submenu-lista">
                    <li><a href="{{ route('auth.marca', 'apple') }}">🍎 Apple</a></li>
                    <li><a href="{{ route('auth.marca', 'samsung') }}">📱 Samsung</a></li>
                    <li><a href="{{ route('auth.marca', 'motorola') }}">📞 Motorola</a></li>
                    <li><a href="{{ route('auth.marca', 'xiaomi') }}">🧡 Xiaomi</a></li>
                    <li><a href="{{ route('auth.marca', 'oppo') }}">📲 OPPO</a></li>
                    <li><a href="{{ route('auth.marca', 'lenovo') }}">💻 Lenovo</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('catalogo.autenticado') }}">Inicio</a>
            <i class='bx bx-chevron-right'></i>
            <a href="{{ route('auth.categoria', strtolower($producto->caracteristicas->Categoria ?? 'productos')) }}">{{ $producto->caracteristicas->Categoria ?? 'Productos' }}</a>
            <i class='bx bx-chevron-right'></i>
            <span>{{ $producto->Nombre }}</span>
        </div>

        <!-- Contenedor principal del producto -->
        <div class="producto-container">
            <!-- Imagen del producto -->
            <div class="producto-imagen">
                @php
                    $imgSrc = $producto->Imagen;
                    if (!$imgSrc) {
                        $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                    } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                        $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                    }
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $producto->Nombre }}">
            </div>

            <!-- Información del producto -->
            <div class="producto-info">
                <h1>{{ $producto->Nombre }}</h1>
                
                <div class="producto-marca">
                    {{ $producto->caracteristicas->Marca ?? 'Sin marca' }}
                </div>
                <span class="producto-categoria">{{ $producto->caracteristicas->Categoria ?? 'Sin categoría' }}</span>

                <!-- Rating -->
                <div class="rating">
                    <div class="stars">★★★★★</div>
                    <span class="rating-text">4.8 (127 reseñas)</span>
                </div>

                <!-- Precios -->
                <div class="precio-container">
                    <div class="precio-actual" style="font-size: 2rem; color: #27ae60; font-weight: 700;">${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }}</div>
                </div>

                <!-- Información de stock -->
                <div class="stock-info">
                    @php
                        $stock = $producto->Stock ?? 0;
                        $stockClass = 'agotado';
                        $stockIcon = 'bx-x-circle';
                        $stockText = 'Agotado';
                        
                        if ($stock > 20) {
                            $stockClass = 'alto';
                            $stockIcon = 'bx-check-circle';
                            $stockText = 'En stock (' . $stock . ' unidades)';
                        } elseif ($stock > 10) {
                            $stockClass = 'medio';
                            $stockIcon = 'bx-time-five';
                            $stockText = 'Stock limitado (' . $stock . ' unidades)';
                        } elseif ($stock > 0) {
                            $stockClass = 'bajo';
                            $stockIcon = 'bx-error-circle';
                            $stockText = 'Pocas unidades (' . $stock . ' disponibles)';
                        }
                    @endphp
                    
                    <div class="stock-disponible {{ $stockClass }}">
                        <i class='bx {{ $stockIcon }} stock-icon'></i>
                        <span class="stock-text">{{ $stockText }}</span>
                    </div>

                    @if($stock == 0)
                        <div class="alert alert-danger">
                            <i class='bx bx-error'></i>
                            <span>Este producto está agotado. Contacta con nosotros para más información.</span>
                        </div>
                    @elseif($stock <= 5)
                        <div class="alert alert-warning">
                            <i class='bx bx-error'></i>
                            <span>¡Solo quedan {{ $stock }} unidades! Aprovecha esta oferta.</span>
                        </div>
                    @endif
                </div>

                <!-- Características principales -->
                <div class="caracteristicas">
                    <h3>Características</h3>
                    <div class="caracteristica-item">
                        <span class="caracteristica-label">Marca:</span>
                        <span class="caracteristica-value">{{ $producto->caracteristicas->Marca ?? 'No especificada' }}</span>
                    </div>
                    <div class="caracteristica-item">
                        <span class="caracteristica-label">Categoría:</span>
                        <span class="caracteristica-value">{{ $producto->caracteristicas->Categoria ?? 'No especificada' }}</span>
                    </div>
                    @if($producto->caracteristicas->Color)
                    <div class="caracteristica-item">
                        <span class="caracteristica-label">Color:</span>
                        <span class="caracteristica-value">{{ $producto->caracteristicas->Color }}</span>
                    </div>
                    @endif
                    @if($producto->caracteristicas->Modelo)
                    <div class="caracteristica-item">
                        <span class="caracteristica-label">Modelo:</span>
                        <span class="caracteristica-value">{{ $producto->caracteristicas->Modelo }}</span>
                    </div>
                    @endif
                    <div class="caracteristica-item">
                        <span class="caracteristica-label">Stock disponible:</span>
                        <span class="caracteristica-value">{{ $stock }} unidades</span>
                    </div>
                </div>

                <!-- Descripción -->
                @if($producto->caracteristicas->Descripcion)
                <div class="descripcion">
                    <h3>Descripción</h3>
                    <p>{{ $producto->caracteristicas->Descripcion }}</p>
                </div>
                @endif

                <!-- Acciones -->
                <div class="acciones">
                    @if($stock > 0)
                        <button class="btn btn-primary" onclick="agregarAlCarrito({{ $producto->ID_Producto }})">
                            <i class='bx bx-cart-add'></i> Agregar al Carrito
                        </button>
                    @else
                        <button class="btn btn-primary" disabled>
                            <i class='bx bx-x'></i> Producto Agotado
                        </button>
                    @endif
                    
                    <button class="btn btn-favorito" onclick="toggleFavorito({{ $producto->ID_Producto }})" data-producto-id="{{ $producto->ID_Producto }}">
                        <i class='bx bx-heart'></i>
                    </button>
                    
                    <button class="btn btn-carrito" onclick="agregarAlCarrito({{ $producto->ID_Producto }})" {{ $stock == 0 ? 'disabled' : '' }}>
                        <i class='bx bx-cart'></i>
                    </button>
                </div>

                <!-- Loading indicator -->
                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <p>Procesando...</p>
                </div>
            </div>
        </div>

        <!-- Sección de productos relacionados -->
        <div class="productos-relacionados">
            <div class="productos-relacionados-header">
                <h2><i class='bx bx-star'></i> Productos que te pueden interesar</h2>
                <p>Descubre más opciones similares</p>
            </div>
            
            <div class="productos-grid">
                @php
                    $productosRelacionados = \App\Models\Producto::with('caracteristicas')
                        ->whereHas('caracteristicas', function($query) use ($producto) {
                            $query->where('Categoria', $producto->caracteristicas->Categoria ?? '')
                                  ->orWhere('Marca', $producto->caracteristicas->Marca ?? '');
                        })
                        ->where('ID_Producto', '!=', $producto->ID_Producto)
                        ->inRandomOrder()
                        ->limit(4)
                        ->get();
                @endphp
                
                @foreach($productosRelacionados as $productoRelacionado)
                    <div class="producto-card">
                        @php
                            $imgSrc = $productoRelacionado->Imagen;
                            if (!$imgSrc) {
                                $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                            } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                                $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                            }
                        @endphp
                        
                        <div class="producto-imagen-container">
                            <img src="{{ $imgSrc }}" alt="{{ $productoRelacionado->Nombre }}" class="producto-imagen-mini">
                            <div class="producto-overlay">
                                <a href="{{ route('producto.detalles', $productoRelacionado->ID_Producto) }}" class="btn-ver-detalles">
                                    <i class='bx bx-eye'></i> Ver Detalles
                                </a>
                            </div>
                        </div>
                        
                        <div class="producto-info-mini">
                            <h4>{{ $productoRelacionado->Nombre }}</h4>
                            <div class="producto-marca-mini">{{ $productoRelacionado->caracteristicas->Marca ?? 'Sin marca' }}</div>
                            
                            <div class="rating-mini">
                                <span class="stars">★★★★★</span>
                                <span class="rating-text">4.5</span>
                            </div>
                            
                            <div class="precio-container-mini">
                                <span class="precio-actual-mini" style="color: #27ae60; font-weight: bold;">${{ number_format($productoRelacionado->caracteristicas->Precio_Venta, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="stock-info-mini">
                                @php
                                    $stock = $productoRelacionado->Stock ?? 0;
                                    $stockClass = 'agotado';
                                    $stockText = 'Agotado';
                                    
                                    if ($stock > 20) {
                                        $stockClass = 'alto';
                                        $stockText = 'En stock';
                                    } elseif ($stock > 10) {
                                        $stockClass = 'medio';
                                        $stockText = 'Stock limitado';
                                    } elseif ($stock > 0) {
                                        $stockClass = 'bajo';
                                        $stockText = 'Pocas unidades';
                                    }
                                @endphp
                                <span class="stock-badge {{ $stockClass }}">{{ $stockText }}</span>
                            </div>
                            
                            <div class="producto-acciones-mini">
                                <button class="btn-favorito-mini" onclick="toggleFavorito({{ $productoRelacionado->ID_Producto }})" data-producto-id="{{ $productoRelacionado->ID_Producto }}">
                                    <i class='bx bx-heart'></i>
                                </button>
                                <button class="btn-carrito-mini" onclick="agregarAlCarrito({{ $productoRelacionado->ID_Producto }})" {{ $stock == 0 ? 'disabled' : '' }}>
                                    <i class='bx bx-cart-add'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($productosRelacionados->count() == 0)
                <div class="no-productos">
                    <i class='bx bx-package'></i>
                    <p>No hay productos relacionados disponibles en este momento.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function agregarAlCarrito(productoId) {
            const loading = document.getElementById('loading');
            loading.style.display = 'block';
            
            fetch(`/carrito/agregar/${productoId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                loading.style.display = 'none';
                if (data.success) {
                    showNotification('¡Producto agregado al carrito exitosamente!', 'success', '🛒');
                } else {
                    showNotification('Error: ' + data.message, 'error', '❌');
                }
            })
            .catch(error => {
                loading.style.display = 'none';
                console.error('Error:', error);
                showNotification('Error al agregar el producto al carrito', 'error', '❌');
            });
        }

        function toggleFavorito(productoId) {
            const btn = document.querySelector(`[data-producto-id="${productoId}"]`);
            const icon = btn.querySelector('i');
            
            fetch(`/favoritos/${productoId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.isFavorito) {
                        btn.classList.add('activo');
                        icon.className = 'bx bxs-heart';
                    } else {
                        btn.classList.remove('activo');
                        icon.className = 'bx bx-heart';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Función para mostrar notificaciones bonitas
        function showNotification(message, type, icon) {
            // Crear el elemento de notificación
            const notification = document.createElement('div');
            notification.className = `notification ${type} bounce-in`;
            
            notification.innerHTML = `
                <div class="notification-content">
                    <div class="notification-icon">${icon}</div>
                    <div class="notification-text">${message}</div>
                    <button class="notification-close" onclick="closeNotification(this)">×</button>
                </div>
                <div class="notification-progress"></div>
            `;
            
            // Agregar al DOM
            document.body.appendChild(notification);
            
            // Mostrar con animación
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Auto-remover después de 3 segundos
            setTimeout(() => {
                closeNotification(notification.querySelector('.notification-close'));
            }, 3000);
        }

        // Función para cerrar notificaciones
        function closeNotification(closeBtn) {
            const notification = closeBtn.closest('.notification');
            notification.classList.remove('show');
            notification.style.transform = 'translateX(100%)';
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 400);
        }
    </script>
</body>
</html>
