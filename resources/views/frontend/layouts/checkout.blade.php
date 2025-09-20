<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technova | Checkout</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/comprainfo.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <header class="header">
    <a href="{{ route('catalogo.autenticado') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
      <span>TECHNOVA</span>
    </a>

    <div class="search-bar">
      <form action="{{ route('buscar') }}" method="GET" class="search-form">
        <input type="text" name="q" placeholder="¿Qué estás buscando hoy?" class="search-input" value="{{ request('q') }}">
        <button type="submit" class="search-btn">&#128269;</button>
      </form>
    </div>

    <div class="acciones-usuario">
      <a href="{{ route('perfillcli') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      <a href="{{ route('logout') }}" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
      <a href="{{ route('carrito.index') }}" class="cart"><i class='bx bx-cart'></i> <span>Carrito</span></a>
    </div>
  </header>

  <div class="container">
    <div class="steps">
      <div class="step {{ request()->routeIs('checkout.informacion') ? 'active' : '' }}">Informacion</div>
      <div class="step {{ request()->routeIs('checkout.direccion') ? 'active' : '' }}">Direccion</div>
      <div class="step {{ request()->routeIs('checkout.envio') ? 'active' : '' }}">Metodo de envio</div>
      <div class="step {{ request()->routeIs('checkout.pago') ? 'active' : '' }}">Forma de pago</div>
      <div class="step {{ request()->routeIs('checkout.revision') ? 'active' : '' }}">Revision</div>
    </div>

    <div class="content">
      <div class="form-section">
        @yield('content')
      </div>

      <div class="cart-section">
        <h2 class="cart-title">Mi Carrito</h2>
        <div class="cart-products">
          @if(isset($productos) && count($productos) > 0)
            @foreach($productos as $detalle)
            @if($detalle->producto)
            <div class="cart-product">
              @php
                $imgSrc = $detalle->producto->Imagen ?? null;
                if (!$imgSrc) {
                    $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                    $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                }
              @endphp
              <img src="{{ $imgSrc }}" alt="{{ $detalle->producto->Nombre }}" />
              <div class="product-details">
                <p><strong>{{ $detalle->producto->Nombre }}</strong></p>
                <p>Cantidad: {{ $detalle->Cantidad }}</p>
                <p>Valor: ${{ number_format($detalle->producto->caracteristicas->Precio_Venta ?? 0, 0, ',', '.') }}</p>
              </div>
            </div>
            @endif
            @endforeach
          @else
            <p>No hay productos en el carrito</p>
          @endif
        </div>
        <div class="cart-summary">
          <p><strong>Total:</strong> ${{ number_format($total ?? 0, 0, ',', '.') }}</p>
        </div>
        
        <!-- Aviso informativo -->
        <div class="checkout-notice" style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); border: 2px solid #00d4ff; border-radius: 10px; padding: 15px; margin-top: 15px; text-align: center;">
          <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 8px;">
            <i class='bx bx-info-circle' style="color: #00d4ff; font-size: 20px;"></i>
            <strong style="color: #333; font-size: 14px;">Información Importante</strong>
          </div>
          <p style="color: #555; font-size: 13px; margin: 0; line-height: 1.4;">
            Completa todos los datos requeridos en cada paso para continuar con tu compra de forma segura.
          </p>
        </div>
      </div>
    </div>

    <div class="footer-msg">
      ¡ No te preocupes ! Tu compra es 100% segura
    </div>
  </div>

</body>
</html>


