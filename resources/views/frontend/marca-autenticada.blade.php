<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technova - {{ ucfirst($marca) }}</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/css/producto.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
 <header class="header">
  <a href="{{ route('catalogo.autenticado') }}" class="logo">
    <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" style="cursor:pointer;">
    <span>TECHNOVA</span>
  </a>

 <div class="search-bar">
  <form action="{{ route('buscar') }}" method="GET" class="search-form">
    <input type="text" name="q" placeholder="¿Qué estás buscando hoy?" class="search-input" value="{{ request('q') }}" />
    <button type="submit" class="search-btn">&#128269;</button>
  </form>
</div>

  <div class="acciones-usuario">
    <a href="{{ route('perfillcli') }}" class="account">
      <span>Perfil</span>
    </a>
    <a href="/logout" class="account">
      <span>Cerrar Sesión</span>
    </a>
  </div>
</header>

<div class="dashboard-wrapper">
  @include('frontend.layouts.sidebar-cliente')

  <main class="main-content">

<style>
  /* Layout overrides to ensure main content fills beside sidebar */
  .dashboard-wrapper { 
    gap: 20px; 
    width: 100%;
  }
  .main-content { 
    width: 100%; 
    flex: 1;
    display: flex; 
    flex-direction: column; 
    padding: 0;
  }
  .menu-principal, 
  .productos-grid, 
  .search-results-header { 
    width: 100%; 
    margin: 0; 
    padding: 0 20px; 
  }
  @media (max-width: 992px) { 
    .menu-principal, 
    .productos-grid, 
    .search-results-header { 
      padding: 0 12px; 
    } 
  }
</style>

<nav class="menu-principal">
  <ul>
    <li><a href="{{ route('catalogo.autenticado') }}">Inicio</a></li>
      <li class="submenu">
      <a href="#">Categorías ▾</a>
      <ul class="submenu-lista">
        <li><a href="{{ route('auth.celulares') }}">📱 Celulares</a></li>
        <li><a href="{{ route('auth.portatiles') }}">💻 Portátiles</a></li>
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
    <li><a href="#contacto">Contacto</a></li>
  </ul>
</nav>

<!-- Contenido principal -->
<div class="contenido-principal">
  <h1 style="text-align: center; margin: 30px 0; color: #00d4ff;">{{ ucfirst($marca) }}</h1>
  
  <div class="productos-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; padding: 15px;">
    @foreach($productos as $producto)
    <div class="producto-card" style="background: white; border-radius: 12px; padding: 12px; text-align: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease, box-shadow 0.3s ease; position: relative; border: 1px solid #f0f0f0;">
      @php
        $imgSrc = $producto->Imagen;
        if (!$imgSrc) {
            $imgSrc = asset('frontend/imagenes/foto perfil.webp');
        } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
            $imgSrc = asset('frontend/imagenes/' . $imgSrc);
        }
      @endphp
      <img src="{{ $imgSrc }}" alt="{{ $producto->Nombre }}" style="width: 100%; max-width: 200px; height: auto; border-radius: 10px; margin-bottom: 15px;">
      <a href="{{ route('producto.detalles', $producto->ID_Producto) }}" style="display: inline-block; margin: 10px 0; background: var(--gradient-secondary); color: white; padding: 8px 15px; border-radius: 20px; text-decoration: none; font-size: 0.9em; font-weight: bold;">Ver Más Detalles</a>
      <h3 style="font-weight: bold; margin: 10px 0; color: #333; font-size: 1.1em;">{{ $producto->Nombre }}</h3>
      <p style="margin: 5px 0; color: #666;">4.5 ⭐</p>
      <p class="precio-actual" style="color: #00d4ff; font-weight: bold; margin: 5px 0; font-size: 1.1em;">
        ${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }}
      </p>
      <button class="carrito-btn" style="background: var(--gradient-secondary); border: none; border-radius: 50%; width: 40px; height: 40px; color: white; font-size: 18px; cursor: pointer; position: absolute; bottom: 15px; right: 15px; transition: all 0.3s ease;">
        &#128722;
      </button>
    </div>
    @endforeach
  </div>
  
  @if($productos->count() == 0)
    <div style="text-align: center; padding: 50px; color: #666;">
      <h3>No se encontraron productos de esta marca</h3>
      <a href="{{ route('catalogo.autenticado') }}" style="color: #00d4ff; text-decoration: none;">← Volver al catálogo</a>
    </div>
  @endif
</div>

  </main><!-- /main-content -->
</div><!-- /dashboard-wrapper -->

</body>
</html>
