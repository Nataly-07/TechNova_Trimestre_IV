<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ ucfirst($categoria) }} - Technova</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/producto.css') }}">
  <style>
    .filters-bar {
      display: flex;
      gap: 15px;
      align-items: center;
      margin-left: 20px;
    }

    .filters-bar select {
      padding: 8px 12px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: white;
      font-size: 14px;
      cursor: pointer;
      min-width: 150px;
    }

    .filters-bar select:hover {
      border-color: #00d4ff;
    }

    .filters-bar select:focus {
      outline: none;
      border-color: #00d4ff;
      box-shadow: 0 0 5px rgba(0, 200, 83, 0.3);
    }

    .categoria-header {
      background: var(--gradient-secondary);
      color: white;
      padding: 30px;
      text-align: center;
      margin: 20px 0;
      border-radius: 10px;
    }

    .categoria-header h1 {
      font-size: 2.5em;
      margin: 0;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .categoria-header p {
      font-size: 1.2em;
      margin: 10px 0 0 0;
      opacity: 0.9;
    }

    .productos-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 15px;
      padding: 15px 0;
    }

    .producto-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      padding: 12px;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
      border: 1px solid #f0f0f0;
    }

    .producto-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .producto-card img {
      width: 140px;
      height: 140px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 8px;
    }

    .producto-card h3 {
      color: #333;
      margin: 8px 0 6px 0;
      font-size: 1.1em;
      line-height: 1.2;
    }

    .producto-card .precio-original {
      text-decoration: line-through;
      color: #999;
      font-size: 0.9em;
      margin: 3px 0;
    }

    .producto-card .precio-descuento {
      color: #00d4ff;
      font-weight: bold;
      font-size: 1.2em;
      margin: 6px 0;
    }

    .producto-card .descuento {
      background: var(--gradient-light);
      color: #00d4ff;
      padding: 3px 6px;
      border-radius: 8px;
      font-size: 0.7em;
      margin-left: 6px;
    }

    .producto-card .carrito-btn {
      background: var(--gradient-secondary);
      border: none;
      border-radius: 50%;
      width: 35px;
      height: 35px;
      color: white;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .producto-card .carrito-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 3px 8px rgba(0, 212, 255, 0.4);
    }

    .no-productos {
      text-align: center;
      padding: 60px 20px;
      color: #666;
    }

    .no-productos h2 {
      color: #333;
      margin-bottom: 20px;
    }

    .no-productos p {
      font-size: 1.1em;
      margin-bottom: 30px;
    }

    .btn-volver {
      background: var(--gradient-secondary);
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .btn-volver:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0, 200, 83, 0.4);
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body>
 <header class="header">
  <a href="{{ route('index') }}" class="logo">
    <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" style="cursor:pointer;">
    <span>TECHNOVA</span>
  </a>

 <div class="search-bar">
  <input type="text" id="buscador-header" placeholder="¿Qué estás buscando hoy?" />
  <button class="search-btn">&#128269;</button>
</div>

<div class="filters-bar">
  <select id="categoria-select" onchange="redirectCategory(this.value)">
    <option value="">Selecciona una categoría</option>
    <option value="celulares" {{ $categoria == 'celulares' ? 'selected' : '' }}>📱 Celulares</option>
    <option value="portatiles" {{ $categoria == 'portatiles' ? 'selected' : '' }}>💻 Portátiles</option>
  </select>

  <select id="marca-select" onchange="redirectBrand(this.value)">
    <option value="">Selecciona una marca</option>
    <option value="apple">🍎 Apple</option>
    <option value="samsung">📱 Samsung</option>
    <option value="motorola">📞 Motorola</option>
    <option value="xiaomi">🧡 Xiaomi</option>
    <option value="oppo">📲 OPPO</option>
    <option value="lenovo">💻 Lenovo</option>
  </select>
</div>

  <div class="acciones-usuario">
    <a href="{{ route('frontend.login') }}" class="account">
      <span>Iniciar Sesión</span>
    </a>
    <a href="{{ route('frontend.register') }}" class="account">
      <span>Crear Cuenta</span>
    </a>
  </div>
</header>

<nav class="menu-principal">
  <ul>
    <li><a href="{{ route('index') }}">Inicio</a></li>
    <li class="submenu">
      <a href="#">Categorías ▾</a>
      <ul class="submenu-lista">
        <li><a href="{{ route('celulares') }}">📱 Celulares</a></li>
        <li><a href="{{ route('portatiles') }}">💻 Portátiles</a></li>
      </ul>
    </li>
    <li class="submenu">
      <a href="#">Marcas ▾</a>
      <ul class="submenu-lista">
        <li><a href="{{ route('marca.apple') }}">🍎 Apple</a></li>
        <li><a href="{{ route('marca.samsung') }}">📱 Samsung</a></li>
        <li><a href="{{ route('marca.motorola') }}">📞 Motorola</a></li>
        <li><a href="{{ route('marca.xiaomi') }}">🧡 Xiaomi</a></li>
        <li><a href="{{ route('marca.oppo') }}">📲 OPPO</a></li>
        <li><a href="{{ route('marca.lenovo') }}">💻 Lenovo</a></li>
      </ul>
    </li>
  </ul>
</nav>

<div class="categoria-header">
  <h1>
    @if($categoria == 'celulares')
      📱 Celulares
    @elseif($categoria == 'portatiles')
      💻 Portátiles
    @else
      {{ ucfirst($categoria) }}
    @endif
  </h1>
  <p>{{ $productos->count() }} productos disponibles</p>
</div>

@if($productos->count() > 0)
  <div class="productos-grid">
    @foreach($productos as $producto)
    <div class="producto-card">
      @php
        $imgSrc = $producto->Imagen;
        if (!$imgSrc) {
            $imgSrc = asset('frontend/imagenes/foto perfil.webp');
        } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
            $imgSrc = asset('frontend/imagenes/' . $imgSrc);
        }
      @endphp
      <img src="{{ $imgSrc }}" alt="{{ $producto->Nombre }}">
      <h3>{{ $producto->Nombre }}</h3>
      <p>4.5 ⭐</p>
      <p class="precio-original">${{ number_format($producto->caracteristicas->Precio_Venta * 1.05, 0, ',', '.') }}</p>
      <p class="precio-descuento">${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }} <span class="descuento">-5%</span></p>
      <a href="{{ route('frontend.login') }}" class="carrito-btn" style="text-decoration: none; color: white; display: inline-flex; align-items: center; justify-content: center;">&#128722;</a>
    </div>
    @endforeach
  </div>
@else
  <div class="no-productos">
    <h2>No hay productos disponibles</h2>
    <p>No se encontraron productos en la categoría <strong>{{ ucfirst($categoria) }}</strong>.</p>
    <a href="{{ route('index') }}" class="btn-volver">Volver al Inicio</a>
  </div>
@endif

<script src="{{ asset('frontend/js/script.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const buscador = document.getElementById("buscador-header");
  const productos = document.querySelectorAll(".producto-card");

  buscador.addEventListener("input", () => {
    const valor = buscador.value.toLowerCase();
    productos.forEach((producto) => {
      const contenido = producto.textContent.toLowerCase();
      producto.style.display = contenido.includes(valor) ? "block" : "none";
    });
  });
</script>

<script>
  function redirectCategory(value) {
    if (value) {
      let redirectUrl = '';
      switch(value) {
        case 'celulares':
          redirectUrl = '{{ route("celulares") }}';
          break;
        case 'portatiles':
          redirectUrl = '{{ route("portatiles") }}';
          break;
      }
      if (redirectUrl) {
        window.location.href = redirectUrl;
      }
    }
  }

  function redirectBrand(value) {
    if (value) {
      let redirectUrl = '';
      switch(value) {
        case 'apple':
          redirectUrl = '{{ route("marca.apple") }}';
          break;
        case 'samsung':
          redirectUrl = '{{ route("marca.samsung") }}';
          break;
        case 'motorola':
          redirectUrl = '{{ route("marca.motorola") }}';
          break;
        case 'xiaomi':
          redirectUrl = '{{ route("marca.xiaomi") }}';
          break;
        case 'oppo':
          redirectUrl = '{{ route("marca.oppo") }}';
          break;
        case 'lenovo':
          redirectUrl = '{{ route("marca.lenovo") }}';
          break;
      }
      if (redirectUrl) {
        window.location.href = redirectUrl;
      }
    }
  }
</script>

<footer>
    <p>© 2025 TECHNOVA. Todos los derechos reservados.</p>
</footer>

</body>
</html>
