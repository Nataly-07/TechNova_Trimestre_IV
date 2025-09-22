<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technova</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/css/producto.css') }}">
</head>
<body>
 <header class="header">
  <a href="{{ route('index') }}" class="logo">
    <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" style="cursor:pointer;">
    <span>TECHNOVA</span>
  </a>

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
        <!-- Oferta removida según solicitud -->
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

  <div class="mas-vendido-container">
    <div class="mas-vendido-header">
      <span class="vendido">Lo más vendido</span>
      <a href="#" class="ver-mas">Ver más</a>
    </div>

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
          <a href="#"><span class="detalles">Ver Más Detalles</span></a>
          <h3>{{ $producto->Nombre }}</h3>
          <p>4.5 ⭐</p>
          <p class="precio-original">${{ number_format($producto->caracteristicas->Precio_Venta * 1.05, 0, ',', '.') }}</p>
          <p class="precio-descuento">${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }} <span class="descuento">-5%</span></p>
          <a href="{{ route('frontend.login') }}" class="carrito-btn" style="text-decoration: none; color: white; display: inline-flex; align-items: center; justify-content: center; background: var(--gradient-secondary); border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 18px; cursor: pointer;">&#128722;</a>
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
        <div class="producto-card" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 15px 15px 70px 15px; width: 240px; text-align: center; position: relative; margin-top: 12px; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center;">
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
            <a href="#" style="display: inline-block; margin: 15px 0; background: var(--gradient-secondary); color: white; padding: 8px 15px; border-radius: 12px; font-weight: bold; font-size: 1em; text-decoration: none;">Ver Más Detalles</a>
            <h3 style="font-weight: bold; margin: 12px 0 8px; font-size: 1.2em;">{{ $productos->first()->Nombre }}</h3>
            <p style="margin: 8px 0; font-size: 1em;">4.9 ⭐</p>
            <p class="precio-original" style="text-decoration: line-through; color: gray; margin: 8px 0; font-size: 0.9em;">
              ${{ number_format($productos->first()->caracteristicas->Precio_Venta * 1.05, 0, ',', '.') }}
            </p>
            <p class="precio-descuento" style="color: #006600; font-weight: bold; margin: 8px 0; font-size: 1.1em;">
              ${{ number_format($productos->first()->caracteristicas->Precio_Venta, 0, ',', '.') }}
              <span class="descuento" style="background-color: #cce5cc; color: #006600; padding: 3px 8px; border-radius: 6px; font-size: 0.9em; margin-left: 8px;">-5%</span>
            </p>
            <a href="{{ route('frontend.login') }}" class="carrito-btn" style="background: var(--gradient-secondary); border: none; border-radius: 50%; width: 48px; height: 48px; color: white; font-size: 24px; cursor: pointer; position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
              &#128722;
            </a>
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
            <div class="producto-card" style="background: white; border-radius: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 15px 15px 70px 15px; width: 200px; text-align: center; position: relative;">
                @php
                  $imgSrc = $producto->Imagen;
                  if (!$imgSrc) {
                      $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                  } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                      $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                  }
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $producto->Nombre }}" style="width: 140px; height: auto; margin: 0 auto; display: block; border-radius: 10px;">
                <a href="#" style="display: inline-block; margin: 12px 0; background: var(--gradient-secondary); color: white; padding: 6px 12px; border-radius: 12px; font-weight: bold; font-size: 0.9em; text-decoration: none;">Ver Más Detalles</a>
                <h3 style="font-weight: bold; margin: 10px 0 6px; font-size: 1em;">{{ $producto->Nombre }}</h3>
                <p style="margin: 6px 0; font-size: 0.9em;">4.9 ⭐</p>
                <p class="precio-original" style="text-decoration: line-through; color: gray; margin: 6px 0; font-size: 0.8em;">
                  ${{ number_format($producto->caracteristicas->Precio_Venta * 1.05, 0, ',', '.') }}
                </p>
                <p class="precio-descuento" style="color: #006600; font-weight: bold; margin: 6px 0; font-size: 1em;">
                  ${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }}
                  <span class="descuento" style="background-color: #cce5cc; color: #006600; padding: 2px 6px; border-radius: 6px; font-size: 0.8em; margin-left: 6px;">-5%</span>
                </p>
                <a href="{{ route('frontend.login') }}" class="carrito-btn" style="background: var(--gradient-secondary); border: none; border-radius: 50%; width: 40px; height: 40px; color: white; font-size: 20px; cursor: pointer; position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                  &#128722;
                </a>
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
    <a href="{{ route('celulares') }}" class="categoria-item">📱 Celulares</a>
    <a href="{{ route('portatiles') }}" class="categoria-item">💻 Portátiles</a>
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
    <a href="{{ route('marca.apple') }}" class="marca-item">🍎 Apple</a>
    <a href="{{ route('marca.samsung') }}" class="marca-item">📱 Samsung</a>
    <a href="{{ route('marca.xiaomi') }}" class="marca-item">🧡 Xiaomi</a>
    <a href="{{ route('marca.motorola') }}" class="marca-item">📞 Motorola</a>
    <a href="{{ route('marca.lenovo') }}" class="marca-item">💻 Lenovo</a>
    <a href="{{ route('marca.oppo') }}" class="marca-item">📲 OPPO</a>
  </div>
</section>

<!-- Carrito removido del catálogo público - disponible solo en catálogo privado -->

<script src="{{ asset('frontend/js/script.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
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
        // Oferta removida según solicitud
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

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/68632ae6db555c190ce714bb/1iv1lv5no';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();</script>
<!--End of Tawk.to Script-->

</body>
</html>