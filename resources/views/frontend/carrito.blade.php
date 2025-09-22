<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Carrito de Compras | Technova</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/producto.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}" />
  <script src="{{ asset('frontend/js/app.js') }}" defer></script>
  
  <style>
    .carrito-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    
    .carrito-header {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .carrito-header h1 {
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-size: 2.5em;
      margin-bottom: 10px;
    }
    
    .carrito-content {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 30px;
      margin-top: 20px;
    }
    
    .productos-carrito {
      background: var(--janna-light);
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      padding: 20px;
      border: 2px solid var(--sinbad);
    }
    
    .producto-item {
      display: flex;
      align-items: center;
      gap: 20px;
      padding: 15px 0;
      border-bottom: 1px solid #eee;
    }
    
    .producto-item:last-child {
      border-bottom: none;
    }
    
    .producto-imagen {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 10px;
    }
    
    .producto-info {
      flex: 1;
    }
    
    .producto-nombre {
      font-weight: bold;
      margin-bottom: 5px;
    }
    
    .producto-precio {
      color: var(--bondi-blue);
      font-weight: bold;
    }
    
    .cantidad-controls {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .cantidad-btn {
      background: var(--gradient-primary);
      color: white;
      border: none;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }
    
    .cantidad-btn:hover {
      background: var(--gradient-primary-hover);
      transform: scale(1.1);
    }
    
    .cantidad-input {
      width: 50px;
      text-align: center;
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 5px;
    }
    
    .eliminar-btn {
      background: var(--danger);
      color: white;
      border: none;
      border-radius: 5px;
      padding: 8px 12px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .eliminar-btn:hover {
      background: #c82333;
      transform: scale(1.05);
    }
    
    .resumen-carrito {
      background: var(--janna-light);
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      padding: 20px;
      height: fit-content;
      border: 2px solid var(--sinbad);
    }
    
    .resumen-total {
      font-size: 1.5em;
      font-weight: bold;
      color: var(--bondi-blue);
      margin-bottom: 20px;
    }
    
    .btn-proceder {
      background: var(--gradient-primary);
      color: white;
      border: none;
      border-radius: 25px;
      padding: 15px 30px;
      font-size: 1.1em;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      margin-bottom: 10px;
      transition: all 0.3s ease;
    }
    
    .btn-proceder:hover {
      background: var(--gradient-primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .btn-vaciar {
      background: var(--danger);
      color: white;
      border: none;
      border-radius: 25px;
      padding: 10px 20px;
      cursor: pointer;
      width: 100%;
      transition: all 0.3s ease;
    }
    
    .btn-vaciar:hover {
      background: #c82333;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .carrito-vacio {
      text-align: center;
      padding: 60px 20px;
      color: #666;
    }
    
    .carrito-vacio h2 {
      color: #999;
      margin-bottom: 20px;
    }
    
    .carrito-vacio a {
      display: inline-block;
      background: var(--gradient-primary);
      color: white;
      padding: 12px 24px;
      text-decoration: none;
      border-radius: 25px;
      font-weight: bold;
      transition: all 0.3s ease;
    }
    
    .carrito-vacio a:hover {
      background: var(--gradient-primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>
  <header class="header">
    @if(auth()->user()->role === 'cliente')
      <a href="{{ route('catalogo.autenticado') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" />
      <span>TECHNOVA</span>
    </a>
    @else
      <div class="logo" style="cursor: default;">
        <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" />
        <span>TECHNOVA</span>
      </div>
    @endif
    
    <div class="search-bar">
      <input type="text" placeholder="¿Qué estás buscando hoy?" />
      <button class="search-btn">&#128269;</button>
    </div>
    
    <div class="acciones-usuario">
      @if(auth()->user()->role === 'admin')
        <a href="{{ route('perfilad') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      @elseif(auth()->user()->role === 'empleado')
        <a href="{{ route('perfilemp') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      @else
        <a href="{{ route('perfillcli') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      @endif
      <a href="{{ route('logout') }}" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
      <a href="{{ route('favoritos.index') }}" class="cart"><i class='bx bx-heart'></i> <span>Favoritos</span></a>
      <a href="{{ route('carrito.index') }}" class="cart"><i class='bx bx-cart'></i> <span>Carrito</span></a>
    </div>
  </header>

  <div class="dashboard-wrapper">
    <div class="menu-dashboard">
      <div class="top-menu">
        <div class="logo">
          <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
          <span>Panel Usuario</span>
        </div>
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
      </div>

      <div class="input-search">
        <i class='bx bx-search'></i>
        <input type="text" class="input" placeholder="Buscar">
      </div>

      <div class="menu">
        @if(auth()->user()->role === 'admin')
          <div class="enlace"><a href="{{ route('perfilad') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
          <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
          <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Inventario</a></div>
          <div class="enlace"><a href="{{ route('dashboard') }}"><i class='bx bx-chart'></i> Estadísticas</a></div>
          <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
        @elseif(auth()->user()->role === 'empleado')
          <div class="enlace"><a href="{{ route('perfilemp') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
          <div class="enlace"><a href="{{ route('empleado.inventario') }}"><i class='bx bx-shopping-bag'></i> Inventario</a></div>
          <div class="enlace"><a href="{{ route('empleado.usuarios.cliente') }}"><i class='bx bx-user'></i> Usuarios Cliente</a></div>
        @else
          <div class="enlace"><a href="{{ route('perfillcli') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        @endif
        <div class="enlace"><a href="{{ route('catalogo.autenticado') }}"><i class='bx bx-store'></i> Catálogo</a></div>
        <div class="enlace"><a href="{{ route('favoritos.index') }}"><i class='bx bx-heart'></i> Favoritos</a></div>
        <div class="enlace"><a href="{{ route('carrito.index') }}"><i class='bx bx-cart'></i> Carrito</a></div>
        <div class="enlace"><a href="{{ route('compras.index') }}"><i class='bx bx-receipt'></i> Mis Compras</a></div>
        <div class="enlace"><a href="{{ route('logout') }}"><i class='bx bx-log-out'></i> Cerrar Sesión</a></div>
      </div>
    </div>

    <main class="main-content">
      <div class="carrito-container">
        <div class="carrito-header">
          <h1>🛒 Mi Carrito de Compras</h1>
          <p>Revisa tus productos antes de proceder al pago</p>
        </div>

        @if($productos->count() > 0)
          <div class="carrito-content">
            <div class="productos-carrito">
              <h3>Productos en tu carrito</h3>
              @foreach($productos as $detalle)
                <div class="producto-item" data-detalle-id="{{ $detalle->ID_DetalleCarrito }}">
                  @php
                    $imgSrc = $detalle->producto->Imagen;
                    if (!$imgSrc) {
                        $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                    } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                        $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                    }
                  @endphp
                  
                  <img src="{{ $imgSrc }}" alt="{{ $detalle->producto->Nombre }}" class="producto-imagen">
                  
                  <div class="producto-info">
                    <div class="producto-nombre">{{ $detalle->producto->Nombre }}</div>
                    <div class="producto-precio">${{ number_format($detalle->producto->caracteristicas->Precio_Venta, 0, ',', '.') }}</div>
                  </div>
                  
                  <div class="cantidad-controls">
                    <button class="cantidad-btn" onclick="actualizarCantidad({{ $detalle->ID_DetalleCarrito }}, {{ $detalle->Cantidad - 1 }})">-</button>
                    <input type="number" class="cantidad-input" value="{{ $detalle->Cantidad }}" min="1" onchange="actualizarCantidad({{ $detalle->ID_DetalleCarrito }}, this.value)">
                    <button class="cantidad-btn" onclick="actualizarCantidad({{ $detalle->ID_DetalleCarrito }}, {{ $detalle->Cantidad + 1 }})">+</button>
                  </div>
                  
                  <button class="eliminar-btn" onclick="eliminarProducto({{ $detalle->ID_DetalleCarrito }})">
                    <i class='bx bx-trash'></i>
                  </button>
                </div>
              @endforeach
            </div>
            
            <div class="resumen-carrito">
              <h3>Resumen del pedido</h3>
              <div class="resumen-total">
                Total: ${{ number_format($total, 0, ',', '.') }}
              </div>
              
              <button class="btn-proceder" onclick="procederPago()">
                Proceder al Pago
              </button>
              
              <button class="btn-vaciar" onclick="vaciarCarrito()">
                Vaciar Carrito
              </button>
            </div>
          </div>
        @else
          <div class="carrito-vacio">
            <h2>Tu carrito está vacío</h2>
            <p>Agrega algunos productos para comenzar tu compra</p>
            <a href="{{ route('catalogo.autenticado') }}">Continuar Comprando</a>
          </div>
        @endif
      </div>
  </main>
  </div>

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

  <script>
    function actualizarCantidad(detalleId, cantidad) {
      if (cantidad < 1) {
        eliminarProducto(detalleId);
        return;
      }
      
      fetch(`/carrito/actualizar/${detalleId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ cantidad: cantidad })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload();
        } else {
          alert(data.error || 'Error al actualizar el carrito');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión');
      });
    }
    
    function eliminarProducto(detalleId) {
      if (confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) {
        fetch(`/carrito/eliminar/${detalleId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            location.reload();
          } else {
            alert(data.error || 'Error al eliminar el producto');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error de conexión');
        });
      }
    }
    
    function vaciarCarrito() {
      if (confirm('¿Estás seguro de que quieres vaciar todo el carrito?')) {
        fetch('/carrito/vaciar', {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            location.reload();
          } else {
            alert(data.error || 'Error al vaciar el carrito');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error de conexión');
        });
      }
    }
    
    function procederPago() {
      window.location.href = '{{ route('checkout.informacion') }}';
    }
  </script>
</body>
</html>