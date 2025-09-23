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

    /* Estilos para modal de confirmación moderno y atractivo */
    .confirmation-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(12px);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 10000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .confirmation-modal.show {
      opacity: 1;
      visibility: visible;
    }

    .confirmation-content {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.98) 100%);
      backdrop-filter: blur(25px);
      border-radius: 24px;
      padding: 40px 35px;
      max-width: 480px;
      width: 90%;
      box-shadow: 
        0 25px 80px rgba(0, 0, 0, 0.25),
        0 0 0 1px rgba(255, 255, 255, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.2);
      transform: scale(0.6) translateY(80px) rotateX(15deg);
      transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .confirmation-content::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
      border-radius: 24px 24px 0 0;
    }

    .confirmation-modal.show .confirmation-content {
      transform: scale(1) translateY(0) rotateX(0deg);
    }

    .confirmation-icon {
      font-size: 72px;
      margin-bottom: 25px;
      filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
      animation: bounce 0.6s ease-out;
    }

    @keyframes bounce {
      0% { transform: scale(0.3) rotate(-10deg); }
      50% { transform: scale(1.1) rotate(5deg); }
      100% { transform: scale(1) rotate(0deg); }
    }

    .confirmation-title {
      font-size: 24px;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 15px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .confirmation-message {
      font-size: 16px;
      color: #5a6c7d;
      line-height: 1.6;
      margin-bottom: 35px;
      font-weight: 500;
    }

    .confirmation-buttons {
      display: flex;
      gap: 15px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .confirmation-btn {
      padding: 14px 28px;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      display: flex;
      align-items: center;
      gap: 8px;
      min-width: 140px;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .confirmation-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.5s;
    }

    .confirmation-btn:hover::before {
      left: 100%;
    }

    .confirmation-btn.confirm {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .confirmation-btn.confirm:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
    }

    .confirmation-btn.cancel {
      background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
      color: white;
      box-shadow: 0 8px 25px rgba(149, 165, 166, 0.3);
    }

    .confirmation-btn.cancel:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 35px rgba(149, 165, 166, 0.4);
    }

    .confirmation-btn i {
      font-size: 18px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .confirmation-content {
        padding: 30px 25px;
        max-width: 95%;
      }
      
      .confirmation-title {
        font-size: 20px;
      }
      
      .confirmation-message {
        font-size: 14px;
      }
      
      .confirmation-buttons {
        flex-direction: column;
        gap: 12px;
      }
      
      .confirmation-btn {
        width: 100%;
        min-width: auto;
      }
    }

    /* Estilos para notificaciones */
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
    @if(auth()->user()->role === 'cliente')
      @include('frontend.layouts.sidebar-cliente')
    @else
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
            <div class="enlace"><a href="{{ route('empleado.inventario') }}"><i class='bx bx-shopping-bag'></i> Visualización Artículos</a></div>
            <div class="enlace"><a href="{{ route('empleado.usuarios.cliente') }}"><i class='bx bx-user'></i> Usuarios Cliente</a></div>
          @endif
          <div class="enlace"><a href="{{ route('catalogo.autenticado') }}"><i class='bx bx-store'></i> Catálogo</a></div>
          <div class="enlace"><a href="{{ route('favoritos.index') }}"><i class='bx bx-heart'></i> Favoritos</a></div>
          <div class="enlace"><a href="{{ route('carrito.index') }}"><i class='bx bx-cart'></i> Carrito</a></div>
          
<div class="enlace"><a href="{{ route('compras.index') }}"><i class='bx bx-receipt'></i> Mis Compras</a></div>
<div class="enlace">
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;padding:0;">
      <i class='bx bx-log-out'></i> Cerrar Sesión
    </button>
  </form>
</div>

        </div>
      </div>
    @endif

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
                    <div class="producto-precio-original" style="text-decoration: line-through; color: #999; font-size: 0.9rem; margin-bottom: 4px;">
                      ${{ number_format($detalle->producto->caracteristicas->Precio_Venta * 1.05, 0, ',', '.') }}
                    </div>
                    <div class="producto-precio" style="color: #27ae60; font-weight: bold; font-size: 1.1rem;">
                      ${{ number_format($detalle->producto->caracteristicas->Precio_Venta, 0, ',', '.') }}
                      <span class="descuento" style="background-color: #cce5cc; color: #006600; padding: 2px 6px; border-radius: 6px; font-size: 0.8rem; margin-left: 6px;">-5%</span>
                    </div>
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
      showConfirmationModal(
        '¿Estás seguro de que quieres eliminar este producto del carrito?',
        'Eliminar del carrito',
        '🗑️',
        function() {
          fetch(`/carrito/eliminar/${detalleId}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              showNotification('Producto eliminado del carrito', 'success', '✅');
              setTimeout(() => location.reload(), 1000);
            } else {
              showNotification(data.error || 'Error al eliminar el producto', 'error', '❌');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            showNotification('Error de conexión', 'error', '❌');
          });
        }
      );
    }
    
    function vaciarCarrito() {
      showConfirmationModal(
        '¿Estás seguro de que quieres vaciar todo el carrito?',
        'Vaciar carrito',
        '🗑️',
        function() {
        fetch('/carrito/vaciar', {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
              showNotification('Carrito vaciado exitosamente', 'success', '✅');
              setTimeout(() => location.reload(), 1000);
          } else {
              showNotification(data.error || 'Error al vaciar el carrito', 'error', '❌');
          }
        })
        .catch(error => {
          console.error('Error:', error);
            showNotification('Error de conexión', 'error', '❌');
        });
      }
      );
    }
    
    function procederPago() {
      window.location.href = '{{ route('checkout.informacion') }}';
    }

    // Función para mostrar modal de confirmación bonito
    function showConfirmationModal(message, title, icon, onConfirm) {
      const modal = document.createElement('div');
      modal.className = 'confirmation-modal';
      
      modal.innerHTML = `
        <div class="confirmation-content">
          <div class="confirmation-icon">${icon}</div>
          <div class="confirmation-title">${title}</div>
          <div class="confirmation-message">${message}</div>
          <div class="confirmation-buttons">
            <button class="confirmation-btn confirm" onclick="confirmAction()">
              <i class='bx bx-check'></i> Confirmar
            </button>
            <button class="confirmation-btn cancel" onclick="cancelAction()">
              <i class='bx bx-x'></i> Cancelar
            </button>
          </div>
        </div>
      `;
      
      document.body.appendChild(modal);
      
      // Mostrar modal con animación
      setTimeout(() => {
        modal.classList.add('show');
      }, 100);
      
      // Función para confirmar
      window.confirmAction = function() {
        modal.classList.remove('show');
        setTimeout(() => {
          document.body.removeChild(modal);
          if (onConfirm) onConfirm();
        }, 300);
      };
      
      // Función para cancelar
      window.cancelAction = function() {
        modal.classList.remove('show');
        setTimeout(() => {
          document.body.removeChild(modal);
        }, 300);
      };
      
      // Cerrar al hacer clic fuera del modal
      modal.addEventListener('click', function(e) {
        if (e.target === modal) {
          window.cancelAction();
        }
      });
    }

    // Función para mostrar notificaciones bonitas
    function showNotification(message, type, icon) {
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
      
      document.body.appendChild(notification);
      
      setTimeout(() => {
        notification.classList.add('show');
      }, 100);
      
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