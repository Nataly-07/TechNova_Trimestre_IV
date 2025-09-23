<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Technova</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/css/producto.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
   <style>
     /* Estilos para búsqueda multifiltro */
     .filter-btn {
       background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
       border: none;
       border-radius: 50%;
       width: 40px;
       height: 40px;
       display: flex;
       align-items: center;
       justify-content: center;
       cursor: pointer;
       color: white;
       font-size: 16px;
       transition: all 0.3s ease;
       margin-right: 8px;
     }

     .filter-btn:hover {
       background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
       transform: translateY(-2px);
       box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
     }

     .multi-filter-modal {
       position: fixed;
       top: 0;
       left: 0;
       width: 100%;
       height: 100%;
       background: rgba(0, 0, 0, 0.6);
       backdrop-filter: blur(8px);
       display: none;
       align-items: center;
       justify-content: center;
       z-index: 10000;
       opacity: 0;
       visibility: hidden;
       transition: all 0.3s ease;
     }

     .multi-filter-modal.show {
       opacity: 1;
       visibility: visible;
     }

     .multi-filter-content {
       background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
       backdrop-filter: blur(20px);
       border-radius: 20px;
       padding: 0;
       max-width: 500px;
       width: 90%;
       max-height: 80vh;
       overflow-y: auto;
       box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
       border: 1px solid rgba(255, 255, 255, 0.2);
       transform: scale(0.7) translateY(50px);
       transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
     }

     .multi-filter-modal.show .multi-filter-content {
       transform: scale(1) translateY(0);
     }

     .multi-filter-header {
       background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
       color: white;
       padding: 20px 25px;
       border-radius: 20px 20px 0 0;
       display: flex;
       justify-content: space-between;
       align-items: center;
     }

     .multi-filter-header h3 {
       margin: 0;
       font-size: 20px;
       font-weight: 700;
     }

     .close-filter-btn {
       background: none;
       border: none;
       color: white;
       font-size: 24px;
       cursor: pointer;
       padding: 5px;
       border-radius: 50%;
       transition: all 0.3s ease;
       width: 35px;
       height: 35px;
       display: flex;
       align-items: center;
       justify-content: center;
     }

     .close-filter-btn:hover {
       background: rgba(255, 255, 255, 0.2);
       transform: scale(1.1);
     }

     .multi-filter-body {
       padding: 25px;
     }

     .filter-section {
       margin-bottom: 20px;
     }

     .filter-label {
       display: block;
       font-weight: 600;
       color: #2c3e50;
       margin-bottom: 8px;
       font-size: 14px;
     }

     .filter-select {
       width: 100%;
       padding: 12px 15px;
       border: 2px solid #e9ecef;
       border-radius: 10px;
       font-size: 14px;
       background: white;
       transition: all 0.3s ease;
       cursor: pointer;
     }

     .filter-select:focus {
       outline: none;
       border-color: #667eea;
       box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
     }

     .price-range {
       display: flex;
       align-items: center;
       gap: 10px;
     }

     .price-input {
       flex: 1;
       padding: 12px 15px;
       border: 2px solid #e9ecef;
       border-radius: 10px;
       font-size: 14px;
       transition: all 0.3s ease;
     }

     .price-input:focus {
       outline: none;
       border-color: #667eea;
       box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
     }

     .price-separator {
       color: #6c757d;
       font-weight: 600;
     }

     .multi-filter-footer {
       padding: 20px 25px;
       border-top: 1px solid #e9ecef;
       display: flex;
       gap: 15px;
       justify-content: flex-end;
     }

     .clear-filters-btn, .apply-filters-btn {
       padding: 12px 20px;
       border: none;
       border-radius: 10px;
       font-weight: 600;
       font-size: 14px;
       cursor: pointer;
       transition: all 0.3s ease;
       position: relative;
       overflow: hidden;
     }

     .clear-filters-btn {
       background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
       color: white;
     }

     .clear-filters-btn:hover {
       transform: translateY(-2px);
       box-shadow: 0 4px 15px rgba(149, 165, 166, 0.3);
     }

     .apply-filters-btn {
       background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
       color: white;
     }

     .apply-filters-btn:hover {
       transform: translateY(-2px);
       box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
     }

     /* Estilos para filtros activos */
     .active-filters {
       display: flex;
       flex-wrap: wrap;
       gap: 8px;
       margin-top: 10px;
       align-items: center;
     }

     .filters-label {
       color: var(--eden);
       font-weight: 600;
       font-size: 14px;
     }

     .filter-tag {
       background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
       color: white;
       padding: 4px 12px;
       border-radius: 15px;
       font-size: 12px;
       font-weight: 600;
       display: inline-flex;
       align-items: center;
       gap: 4px;
     }

     /* Responsive */
     @media (max-width: 768px) {
       .multi-filter-content {
         width: 95%;
         max-height: 90vh;
       }
       
       .price-range {
         flex-direction: column;
         gap: 8px;
       }
       
       .multi-filter-footer {
         flex-direction: column;
       }

       .active-filters {
         flex-direction: column;
         align-items: flex-start;
         gap: 6px;
       }
     }
   </style>
</head>
<body>
 <header class="header">
  <a href="{{ route('catalogo.autenticado') }}" class="logo">
    <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" style="cursor:pointer;">
    <span>TECHNOVA</span>
  </a>

  <!-- Barra de búsqueda -->
  <div class="search-container">
    <form action="{{ route('buscar') }}" method="GET" class="search-form" id="searchForm">
      <input type="text" name="q" placeholder="Buscar productos..." class="search-input" value="{{ request('q') }}">
      <button type="button" class="filter-btn" id="filterBtn" onclick="toggleMultiFilter()" title="Búsqueda multifiltro">
        ⚙️
      </button>
      <button type="submit" class="search-btn">
        🔍
      </button>
    </form>
  </div>

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
    
    <a href="{{ route('favoritos.index') }}" class="cart">
      <span class="cart-icon">❤️</span>
      <span>Favoritos</span>
    </a>
    
    <a href="{{ route('carrito.index') }}" class="cart" style="position: relative;">
      <span class="cart-icon">&#128722;</span>
      @if($cartCount > 0)
        <span class="cart-badge" style="position:absolute; top:-6px; right:-6px; background:#e63946; color:#fff; border-radius:12px; padding:2px 6px; font-size:12px; line-height:1; font-weight:700;">{{ $cartCount }}</span>
      @endif
      <span>Carrito</span>
    </a>
  </div>
</header>

<!-- Modal de búsqueda multifiltro -->
<div id="multiFilterModal" class="multi-filter-modal">
  <div class="multi-filter-content">
    <div class="multi-filter-header">
      <h3>🔍 Búsqueda Multifiltro</h3>
      <button class="close-filter-btn" onclick="closeMultiFilter()">×</button>
    </div>
    
    <div class="multi-filter-body">
      <div class="filter-section">
        <label class="filter-label">📱 Categoría</label>
        <select id="filterCategoria" class="filter-select">
          <option value="">Todas las categorías</option>
          <option value="celulares">📱 Celulares</option>
        </select>
      </div>
      
      <div class="filter-section">
        <label class="filter-label">🏷️ Marca</label>
        <select id="filterMarca" class="filter-select">
          <option value="">Todas las marcas</option>
          <option value="Apple">🍎 Apple</option>
          <option value="Motorola">📞 Motorola</option>
          <option value="Xiaomi">🧡 Xiaomi</option>
        </select>
      </div>
      
      <div class="filter-section">
        <label class="filter-label">💰 Rango de Precio</label>
        <div class="price-range">
          <input type="number" id="precioMin" placeholder="Mínimo" class="price-input" value="">
          <span class="price-separator">-</span>
          <input type="number" id="precioMax" placeholder="Máximo" class="price-input" value="">
        </div>
      </div>
      
      <div class="filter-section">
        <label class="filter-label">⭐ Calificación Mínima</label>
        <select id="filterCalificacion" class="filter-select">
          <option value="">Cualquier calificación</option>
          <option value="4">4+ estrellas</option>
          <option value="3">3+ estrellas</option>
          <option value="2">2+ estrellas</option>
        </select>
      </div>
      
      <div class="filter-section">
        <label class="filter-label">📦 Disponibilidad</label>
        <select id="filterStock" class="filter-select">
          <option value="">Cualquier disponibilidad</option>
          <option value="disponible">En stock</option>
          <option value="agotado">Agotado</option>
        </select>
      </div>
    </div>
    
    <div class="multi-filter-footer">
      <button class="clear-filters-btn" onclick="clearAllFilters()">
        🗑️ Limpiar Filtros
      </button>
      <button class="clear-filters-btn" onclick="setWideFilters()" style="background: #27ae60;">
        📈 Filtros Amplios
      </button>
      <button class="apply-filters-btn" onclick="applyMultiFilter()">
        🔍 Aplicar Filtros
      </button>
    </div>
  </div>
</div>

@if(isset($query) && $query || isset($categoria) || isset($marca) || isset($precioMin) || isset($precioMax) || isset($calificacion) || isset($stock))
<div class="search-results-header">
  <div class="search-info">
    @if(isset($query) && $query)
    <span class="search-label">Resultados para:</span>
    <span class="search-term">"{{ $query }}"</span>
    @endif
    
    @if(isset($categoria) || isset($marca) || isset($precioMin) || isset($precioMax) || isset($calificacion) || isset($stock))
      <div class="active-filters">
        <span class="filters-label">Filtros activos:</span>
        @if(isset($categoria))
          <span class="filter-tag">📱 {{ ucfirst($categoria) }}</span>
        @endif
        @if(isset($marca))
          <span class="filter-tag">🏷️ {{ $marca }}</span>
        @endif
        @if(isset($precioMin) || isset($precioMax))
          <span class="filter-tag">💰 
            @if($precioMin && $precioMax)
              ${{ number_format($precioMin, 0, ',', '.') }} - ${{ number_format($precioMax, 0, ',', '.') }}
            @elseif($precioMin)
              Desde ${{ number_format($precioMin, 0, ',', '.') }}
            @elseif($precioMax)
              Hasta ${{ number_format($precioMax, 0, ',', '.') }}
            @endif
          </span>
        @endif
        @if(isset($calificacion))
          <span class="filter-tag">⭐ {{ $calificacion }}+ estrellas</span>
        @endif
        @if(isset($stock))
          <span class="filter-tag">📦 {{ $stock === 'disponible' ? 'En stock' : 'Agotado' }}</span>
        @endif
      </div>
    @endif
    
    <a href="{{ route('catalogo.autenticado') }}" class="clear-search">Limpiar búsqueda</a>
  </div>
</div>
@endif

<nav class="menu-principal">
  <ul>
    <li><a href="{{ route('index') }}">Inicio</a></li>
      <li class="submenu">
      <a href="#">Categorías ▾</a>
      <ul class="submenu-lista">
        <li><a href="{{ route('auth.celulares') }}">📱 Celulares</a></li>
        <li><a href="{{ route('auth.portatiles') }}">💻 Portátiles</a></li>
        <!-- Oferta removida según solicitud -->
      </ul>
    </li>
    <li class="submenu">
      <a href="#">Marcas ▾</a>
      <ul class="submenu-lista">
        <li><a href="{{ route('auth.marca.apple') }}">🍎 Apple</a></li>
        <li><a href="{{ route('auth.marca.samsung') }}">📱 Samsung</a></li>
        <li><a href="{{ route('auth.marca.motorola') }}">📞 Motorola</a></li>
        <li><a href="{{ route('auth.marca.xiaomi') }}">🧡 Xiaomi</a></li>
        <li><a href="{{ route('auth.marca.oppo') }}">📲 OPPO</a></li>
        <li><a href="{{ route('auth.marca.lenovo') }}">💻 Lenovo</a></li>
      </ul>
    </li>
  </ul>
</nav>

<!-- Contenido principal -->
<div class="contenido-principal">
  <div class="mas-vendido-container">
    <div class="mas-vendido-header">
      <span class="vendido">Lo más vendido</span>
      <a href="#" class="ver-mas">Ver más</a>
    </div>

    <!-- Carrusel de productos -->
    <div class="carrusel-productos-contenedor">
    <button class="carrusel-btn prev">&#10094;</button>

    <div class="carrusel-track">
      @foreach($productos as $producto)
      <div class="producto">
        @php
          $imgSrc = $producto->Imagen;
          if (!$imgSrc) {
              $imgSrc = asset('frontend/imagenes/foto perfil.webp');
          } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
              $imgSrc = asset('frontend/imagenes/' . $imgSrc);
          }
        @endphp
        <img src="{{ $imgSrc }}" alt="{{ $producto->Nombre }}">
        <a href="{{ route('producto.detalles', $producto->ID_Producto) }}"><span class="detalles">Ver Más Detalles</span></a>
        <h3>{{ $producto->Nombre }}</h3>
        <p>4.5 ⭐</p>
        <p class="precio-original">${{ number_format($producto->caracteristicas->Precio_Venta * 1.05, 0, ',', '.') }}</p>
        <p class="precio-descuento">${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }} <span class="descuento">-5%</span></p>
        <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
          <button class="favorito-btn" data-producto-id="{{ $producto->ID_Producto }}" style="background-color: #ff6b6b; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 18px; cursor: pointer; color: white;">❤️</button>
          <button class="carrito-btn" data-producto-id="{{ $producto->ID_Producto }}" style="background: var(--gradient-primary); border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 18px; cursor: pointer; color: white; transition: all 0.3s ease;">&#128722;</button>
        </div>
      </div>
      @endforeach
    </div>

    <button class="carrusel-btn next">&#10095;</button>
    </div>
  </div>

<div class="info-botones">
    <div class="info-btn">
        <span class="icon">&#128666;</span>
        <span>Envios<br>gratis</span>
    </div>
    <div class="info-btn">
        <span class="icon">&#128179;</span>
        <span>Metodos<br>de pago</span>
    </div>
    <div class="info-btn">
        <span class="icon">&#128100;</span>
        <span>Asistencia<br>virtual</span>
    </div>
</div>
<div class="ofertas-container" style="background: var(--gradient-light); padding: 20px 25px; border-radius: 10px; overflow: hidden; max-width: 100%; box-sizing: border-box; display: flex; gap: 25px; justify-content: center; flex-wrap: nowrap;">
    <div class="bloque" style="margin-bottom: 40px; overflow: hidden; flex: 0 0 300px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <span class="vendido1" style="background: var(--gradient-secondary); color: white; padding: 6px 15px; border-radius: 15px; font-weight: bold; font-size: 1em; align-self: flex-start;">Oferta del dia</span>
        <div class="producto-card" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 15px 15px 80px 15px; width: 240px; text-align: center; position: relative; margin-top: 12px; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            @if($productos->count() > 0)
            @php
              $imgSrc = $productos->first()->Imagen;
              if (!$imgSrc) {
                  $imgSrc = asset('frontend/imagenes/foto perfil.webp');
              } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                  $imgSrc = asset('frontend/imagenes/' . $imgSrc);
              }
            @endphp
            <img src="{{ $imgSrc }}" alt="{{ $productos->first()->Nombre }}" style="width: 180px; height: auto; margin: 0 auto; display: block; border-radius: 10px;">
            <a href="{{ route('producto.detalles', $productos->first()->ID_Producto) }}" style="display: inline-block; margin: 15px 0; background: var(--gradient-secondary); color: white; padding: 8px 15px; border-radius: 12px; font-weight: bold; font-size: 1em; text-decoration: none;">Ver Más Detalles</a>
            <h3 style="font-weight: bold; margin: 12px 0 8px; font-size: 1.2em;">{{ $productos->first()->Nombre }}</h3>
            <p style="margin: 8px 0; font-size: 1em;">4.9 ⭐</p>
            <p class="precio-original" style="text-decoration: line-through; color: gray; margin: 8px 0; font-size: 0.9em;">
              ${{ number_format($productos->first()->caracteristicas->Precio_Venta * 1.05, 0, ',', '.') }}
            </p>
            <p class="precio-descuento" style="color: #006600; font-weight: bold; margin: 8px 0; font-size: 1.1em;">
              ${{ number_format($productos->first()->caracteristicas->Precio_Venta, 0, ',', '.') }}
              <span class="descuento" style="background-color: #cce5cc; color: #006600; padding: 2px 6px; border-radius: 6px; font-size: 0.8em; margin-left: 6px;">-5%</span>
            </p>
            <div style="display: flex; gap: 15px; justify-content: center; align-items: center; position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);">
              <button class="favorito-btn" data-producto-id="{{ $productos->first()->ID_Producto }}" style="background-color: #ff6b6b; border: none; border-radius: 50%; width: 45px; height: 45px; font-size: 20px; cursor: pointer; color: white;">❤️</button>
              <button class="carrito-btn" data-producto-id="{{ $productos->first()->ID_Producto }}" style="background: var(--gradient-primary); border: none; border-radius: 50%; width: 45px; height: 45px; color: white; font-size: 20px; cursor: pointer; transition: all 0.3s ease;">
                &#128722;
              </button>
            </div>
            @endif
        </div>
    </div>
     <div class="bloque" style="margin-top: 40px; overflow: hidden; flex: 0 0 660px;">
        <div class="bloque-header" style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <span class="vendido1" style="background: var(--gradient-secondary); color: white; padding: 6px 15px; border-radius: 15px; font-weight: bold; font-size: 1em;">Ofertas que te pueden interesar</span>
            <a href="#" class="ver-mas" style="color: #00d4ff; font-weight: bold; font-size: 1em; text-decoration: none;">Ver mas</a>
        </div>
        <div class="productos-grid" style="display: flex; gap: 20px; overflow: hidden; flex-wrap: nowrap; justify-content: flex-start;">
            @foreach($productos->take(3) as $producto)
            <div class="producto-card" style="background: white; border-radius: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 15px 15px 80px 15px; width: 200px; text-align: center; position: relative;">
                @php
                  $imgSrc = $producto->Imagen;
                  if (!$imgSrc) {
                      $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                  } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                      $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                  }
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $producto->Nombre }}" style="width: 120px; height: auto; margin: 0 auto 10px; display: block; border-radius: 8px;">
                <a href="{{ route('producto.detalles', $producto->ID_Producto) }}" style="display: inline-block; margin: 8px 0; background: var(--gradient-secondary); color: white; padding: 6px 12px; border-radius: 10px; font-weight: bold; font-size: 0.9em; text-decoration: none;">Ver Más Detalles</a>
                <h3 style="font-weight: bold; margin: 8px 0 6px; font-size: 1em;">{{ $producto->Nombre }}</h3>
                <p style="margin: 6px 0; font-size: 0.9em;">4.5 ⭐</p>
                <p class="precio-original" style="text-decoration: line-through; color: gray; margin: 6px 0; font-size: 0.8em;">
                  ${{ number_format($producto->caracteristicas->Precio_Venta * 1.05, 0, ',', '.') }}
                </p>
                <p class="precio-descuento" style="color: #006600; font-weight: bold; margin: 6px 0; font-size: 1em;">
                  ${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }}
                  <span class="descuento" style="background-color: #cce5cc; color: #006600; padding: 2px 6px; border-radius: 6px; font-size: 0.8em; margin-left: 6px;">-5%</span>
                </p>
                <div style="display: flex; gap: 8px; justify-content: center; align-items: center; position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%);">
                  <button class="favorito-btn" data-producto-id="{{ $producto->ID_Producto }}" style="background-color: #ff6b6b; border: none; border-radius: 50%; width: 35px; height: 35px; font-size: 16px; cursor: pointer; color: white;">❤️</button>
                  <button class="carrito-btn" data-producto-id="{{ $producto->ID_Producto }}" style="background: var(--gradient-primary); border: none; border-radius: 50%; width: 35px; height: 35px; color: white; font-size: 16px; cursor: pointer; transition: all 0.3s ease;">
                    &#128722;
                  </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

    <section class="categorias">
      <h2>Categorías</h2>
      <div class="category-list">
        <span><img src="{{ asset('frontend/imagenes/celular.png') }}" alt="Celulares" /></span>
        <span><img src="{{ asset('frontend/imagenes/computador.png') }}" alt="Computadores" /></span>
      </div>
    </section>

    <section class="navegacion-categorias">
  <h2>Explora por Categoría</h2>
  <div class="categorias-grid">
    <a href="{{ route('auth.celulares') }}" class="categoria-item">📱 Celulares</a>
    <a href="{{ route('auth.portatiles') }}" class="categoria-item">💻 Portátiles</a>
    <!-- Oferta removida según solicitud -->
  </div>
</section>

    <section class="marcas">
      <h2>Marcas Populares</h2>
      <div class="brand-list">
        <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" />
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg" alt="Samsung" />
        <img src="data:image/png;base64,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" alt="Xiaomi" />
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Motorola_logo.svg/1200px-Motorola_logo.svg.png" alt="Motorola" />
      </div>
    </section>

        <section class="navegacion-marcas">
  <h2>Busca por Marca</h2>
  <div class="marcas-grid">
    <a href="{{ route('auth.marca.apple') }}" class="marca-item">🍎 Apple</a>
    <a href="{{ route('auth.marca.samsung') }}" class="marca-item">📱 Samsung</a>
    <a href="{{ route('auth.marca.xiaomi') }}" class="marca-item">🧡 Xiaomi</a>
    <a href="{{ route('auth.marca.motorola') }}" class="marca-item">📞 Motorola</a>
    <a href="{{ route('auth.marca.lenovo') }}" class="marca-item">💻 Lenovo</a>
    <a href="{{ route('auth.marca.oppo') }}" class="marca-item">📲 OPPO</a>
  </div>
</section>

<script>
// Funciones para redirección de categorías y marcas
function redirectCategory(categoria) {
    if (categoria) {
        window.location.href = `/auth/categoria/${categoria}`;
    }
}

function redirectBrand(marca) {
    if (marca) {
        window.location.href = `/auth/marca/${marca}`;
    }
}



// Carrusel de productos (igual que el index público)
document.addEventListener("DOMContentLoaded", () => {
    const track = document.querySelector(".carrusel-track");
    const btnNext = document.querySelector(".carrusel-btn.next");
    const btnPrev = document.querySelector(".carrusel-btn.prev");

    if (track && btnNext && btnPrev) {
        btnNext.addEventListener("click", () => {
            track.scrollBy({ left: 320, behavior: "smooth" });
        });

        btnPrev.addEventListener("click", () => {
            track.scrollBy({ left: -320, behavior: "smooth" });
        });
    }

    // Funcionalidad de favoritos
    const favoritoBtns = document.querySelectorAll('.favorito-btn');
    
    favoritoBtns.forEach(btn => {
        btn.addEventListener('click', async function() {
            const productoId = this.getAttribute('data-producto-id');
            
            try {
                const response = await fetch(`/favoritos/${productoId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Cambiar el estilo del botón según el estado
                    if (data.isFavorito) {
                        this.style.backgroundColor = '#ff6b6b';
                        this.innerHTML = '❤️';
                    } else {
                        this.style.backgroundColor = '#ccc';
                        this.innerHTML = '🤍';
                    }
                    
                    // Mostrar mensaje de éxito
                    showMessage(data.message, 'success');
                } else {
                    showMessage(data.error || 'Error al actualizar favoritos', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error de conexión', 'error');
            }
        });
    });

    // Funcionalidad de carrito - Versión simplificada
    console.log('Inicializando funcionalidad de carrito...');
    
    // Esperar un poco para asegurar que el DOM esté completamente cargado
    setTimeout(function() {
        const carritoBtns = document.querySelectorAll('.carrito-btn');
        console.log('Botones de carrito encontrados:', carritoBtns.length);
        
        if (carritoBtns.length === 0) {
            console.error('No se encontraron botones de carrito');
            return;
        }
        
        carritoBtns.forEach(function(btn, index) {
            console.log('Configurando botón', index, ':', btn);
            
            // Verificar que el botón tenga el atributo data-producto-id
            const productoId = btn.getAttribute('data-producto-id');
            console.log('Producto ID del botón', index, ':', productoId);
            
            if (!productoId) {
                console.error('Botón', index, 'no tiene data-producto-id');
                return;
            }
            
            // Agregar event listener
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('¡Botón de carrito clickeado!');
                console.log('Producto ID:', productoId);
                
                // Cambiar el botón temporalmente
                const originalText = this.innerHTML;
                this.innerHTML = 'Agregando...';
                this.disabled = true;
                
                // Hacer la petición
                fetch('/carrito/agregar/' + productoId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cantidad: 1 })
                })
                .then(function(response) {
                    console.log('Respuesta del servidor:', response.status);
                    return response.json();
                })
                .then(function(data) {
                    console.log('Datos recibidos:', data);
                    
                    if (data.success) {
                        // Mostrar éxito
                        btn.innerHTML = '✓ Agregado';
                        btn.style.backgroundColor = 'var(--success)';
                        
                        // Actualizar contador del carrito dinámicamente
                        updateCartCounter(data.cartCount || 0);
                        
                        // Mostrar mensaje
                        showMessage('Producto agregado al carrito exitosamente', 'success');
                        
                        // Restaurar botón después de 2 segundos
                        setTimeout(function() {
                            btn.innerHTML = originalText;
                            btn.style.background = 'var(--gradient-primary)';
                            btn.disabled = false;
                        }, 2000);
                    } else {
                        showMessage('Error: ' + (data.error || 'Error desconocido'), 'error');
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                })
                .catch(function(error) {
                    console.error('Error en la petición:', error);
                    showMessage('Error de conexión: ' + error.message, 'error');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
            });
        });
    }, 1000); // Esperar 1 segundo

    // Función para actualizar el contador del carrito
    function updateCartCounter(count) {
        const cartBadge = document.getElementById('cart-badge');
        if (cartBadge) {
            if (count > 0) {
                cartBadge.textContent = count;
                cartBadge.style.display = 'block';
            } else {
                cartBadge.style.display = 'none';
            }
        }
    }

    // Función para mostrar mensajes
    function showMessage(message, type) {
        const messageDiv = document.createElement('div');
        messageDiv.textContent = message;
        messageDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            z-index: 1000;
            ${type === 'success' ? 'background-color: #4CAF50;' : 'background-color: #f44336;'}
        `;
        
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 3000);
    }

    // Funciones para búsqueda multifiltro - DEFINIR COMO GLOBALES
    window.toggleMultiFilter = function() {
      console.log('toggleMultiFilter llamado');
      const modal = document.getElementById('multiFilterModal');
      console.log('Modal encontrado:', modal);
      if (modal) {
        modal.style.display = 'flex';
        setTimeout(() => {
          modal.classList.add('show');
        }, 10);
        console.log('Modal abierto');
      } else {
        console.error('Modal no encontrado en el DOM');
      }
    };

    window.closeMultiFilter = function() {
      const modal = document.getElementById('multiFilterModal');
      if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
          modal.style.display = 'none';
        }, 300);
        console.log('Modal cerrado');
      }
    };

    window.clearAllFilters = function() {
      const elements = ['filterCategoria', 'filterMarca', 'precioMin', 'precioMax', 'filterCalificacion', 'filterStock'];
      elements.forEach(id => {
        const element = document.getElementById(id);
        if (element) element.value = '';
      });
      console.log('Filtros limpiados');
    };

    window.setWideFilters = function() {
      document.getElementById('precioMin').value = '100000';
      document.getElementById('precioMax').value = '10000000';
      document.getElementById('filterCalificacion').value = '3';
      document.getElementById('filterStock').value = 'disponible';
      console.log('Filtros amplios establecidos');
    };


    window.applyMultiFilter = function() {
      const categoria = document.getElementById('filterCategoria')?.value || '';
      const marca = document.getElementById('filterMarca')?.value || '';
      const precioMin = document.getElementById('precioMin')?.value || '';
      const precioMax = document.getElementById('precioMax')?.value || '';
      const calificacion = document.getElementById('filterCalificacion')?.value || '';
      const stock = document.getElementById('filterStock')?.value || '';

      console.log('Aplicando filtros:', { categoria, marca, precioMin, precioMax, calificacion, stock });

      let url = '{{ route("buscar") }}?';
      let params = [];

      if (categoria) params.push(`categoria=${encodeURIComponent(categoria)}`);
      if (marca) params.push(`marca=${encodeURIComponent(marca)}`);
      if (precioMin) params.push(`precio_min=${precioMin}`);
      if (precioMax) params.push(`precio_max=${precioMax}`);
      if (calificacion) params.push(`calificacion=${calificacion}`);
      if (stock) params.push(`stock=${stock}`);

      const searchTerm = document.querySelector('input[name="q"]')?.value || '';
      if (searchTerm) {
        params.push(`q=${encodeURIComponent(searchTerm)}`);
      }

      if (params.length > 0) {
        url += params.join('&');
      } else {
        url = '{{ route("catalogo.autenticado") }}';
      }

      console.log('URL final:', url);
      window.closeMultiFilter();
      window.location.href = url;
    };


    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM cargado');
      
      // Botón de filtro
      const filterBtn = document.getElementById('filterBtn');
      console.log('Botón de filtro encontrado:', filterBtn);
      
      if (filterBtn) {
        filterBtn.addEventListener('click', function(e) {
          e.preventDefault();
          console.log('Click en botón de filtro');
          window.toggleMultiFilter();
        });
      }

      // Cerrar modal al hacer clic fuera
      document.addEventListener('click', function(e) {
        const modal = document.getElementById('multiFilterModal');
        if (e.target === modal) {
          window.closeMultiFilter();
        }
      });

      // Cerrar modal con tecla ESC
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          window.closeMultiFilter();
        }
      });
    });
});

// Script de prueba simple
console.log('Script cargado');
console.log('Función toggleMultiFilter disponible:', typeof window.toggleMultiFilter);

// Verificar elementos inmediatamente
console.log('Modal encontrado:', document.getElementById('multiFilterModal'));
console.log('Botón encontrado:', document.getElementById('filterBtn'));

// Prueba directa del botón
setTimeout(function() {
  const btn = document.getElementById('filterBtn');
  const modal = document.getElementById('multiFilterModal');
  
  console.log('Después de 1 segundo:');
  console.log('Botón:', btn);
  console.log('Modal:', modal);
  
  if (btn) {
    console.log('Agregando event listener adicional');
    btn.onclick = function() {
      console.log('Click directo en botón');
      window.toggleMultiFilter();
    };
  }
  
  // Prueba directa de la función
  if (modal) {
    console.log('Modal existe, probando función...');
    // window.toggleMultiFilter(); // Descomenta esta línea para probar automáticamente
  }
}, 1000);
</script>

<!-- Footer -->
<footer>
  <p>© 2025 TECHNOVA. Todos los derechos reservados.</p>
</footer>

</body>
</html>