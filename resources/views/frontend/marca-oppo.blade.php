<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OPPO | Technova</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/producto.css') }}" />
</head>
<body>
  <header class="header">
    <a href="{{ route('index') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo Technova" />
      <span>TECHNOVA</span>
    </a>
    <div class="search-bar">
      <input type="text" placeholder="¿Qué estás buscando hoy?" />
      <button class="search-btn">&#128269;</button>
    </div>
    <div class="acciones-usuario">
      <a href="{{ route('login') }}" class="account"><span>Iniciar Sesión</span></a>
      <a href="{{ route('register') }}" class="account"><span>Crear Cuenta</span></a>
      <a href="{{ route('carrito') }}" class="cart">
        <span class="cart-icon">&#128722;</span>
        <span>Mi Carrito</span>
      </a>
    </div>
  </header>

  <main class="main-content">
    <section class="productos">
      <h2>📲 Productos OPPO</h2>
      @if($productos->count() > 0)
        @foreach($productos as $producto)
          <div class="producto">
            @if($producto->Imagen)
              <img src="{{ $producto->Imagen }}" alt="{{ $producto->Nombre }}" />
            @endif
            <h3>{{ $producto->Nombre }}</h3>
            <p>{{ $producto->caracteristicas->Descripcion ?? '' }}</p>
            <p>Precio: ${{ $producto->caracteristicas->Precio_Venta ?? '' }}</p>
            <p>Stock: {{ $producto->Stock }}</p>
          </div>
        @endforeach
      @else
        <p>No hay productos disponibles en esta marca.</p>
      @endif
    </section>
    <section class="navegacion-categorias">
      <h2>Explora otras marcas</h2>
      <div class="marcas-grid">
        <a href="{{ route('marca.apple') }}" class="marca-item"> Apple</a>
        <a href="{{ route('marca.samsung') }}" class="marca-item">📱 Samsung</a>
        <a href="{{ route('marca.motorola') }}" class="marca-item">📞 Motorola</a>
        <a href="{{ route('marca.xiaomi') }}" class="marca-item">🧡 Xiaomi</a>
        <a href="{{ route('marca.lenovo') }}" class="marca-item">💻 Lenovo</a>
      </div>
    </section>
    <section class="navegacion-categorias">
      <h2>Explora otras categorías</h2>
      <div class="categorias-grid">
        <a href="{{ route('celulares') }}" class="categoria-item">📱 Celulares</a>
        <a href="{{ route('portatiles') }}" class="categoria-item">💻 Portátiles</a>
        <a href="{{ route('ofertas') }}" class="categoria-item">🔥 Ofertas</a>
      </div>
    </section>
  </main>

  <footer>
    <p>© 2025 TECHNOVA. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
