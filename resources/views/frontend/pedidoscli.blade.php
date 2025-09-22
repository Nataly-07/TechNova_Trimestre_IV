<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pedidos</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/pedidos.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
</head>
<body>
  <header class="header">
    <a href="{{ route('catalogo.autenticado') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
      <span>TECHNOVA</span>
    </a>

    <div class="acciones-usuario">
      <a href="{{ route('perfillcli') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      <a href="{{ route('logout') }}" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
    </div>
  </header>

  <div class="dashboard-wrapper">
    <div class="menu-dashboard">
      <!-- TOP MENU -->
      <div class="top-menu">
        <div class="logo">
          <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
          <span>Dashboard Cliente</span>
        </div>
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
      </div>

      <!-- MENÚ -->
      <div class="menu">
        <div class="enlace"><a href="{{ route('perfillcli') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        <div class="enlace"><a href="{{ route('favoritos.index') }}"><i class='bx bx-heart'></i> Favoritos</a></div>
        <div class="enlace"><a href="{{ url('mensajescli') }}"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace"><a href="{{ route('pedidoscli') }}"><i class='bx bx-cart'></i> Pedidos</a></div>
        <div class="enlace"><a href="{{ route('medios-pago.index') }}"><i class='bx bx-credit-card'></i>Medios De  Pagos</a></div>
        <div class="enlace"><a href="{{ route('compras.index') }}"><i class='bx bx-cart'></i> Mis Compras</a></div>
        <div class="enlace"><a href="{{ url('atencion') }}"><i class='bx bx-headphone'></i> Atencion Al Cliente</a></div>
         <div class="enlace">
           <form method="POST" action="{{ route('logout') }}">
             @csrf
             <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;padding:0;">
               <i class='bx bx-log-out'></i> Cerrar Sesión
             </button>
           </form>
         </div>
       </div>
    </div><!-- /.menu-dashboard -->

    <!-- PRINCIPAL -->
    <main class="main-content">
      <div class="page-header">
        <h1><i class='bx bx-package'></i> Mis Pedidos</h1>
        <p>Gestiona y rastrea todos tus pedidos</p>
      </div>

      <!-- Filtros y búsqueda -->
      <div class="filters-section">
        <div class="search-filter">
          <i class='bx bx-search'></i>
          <input type="text" placeholder="Buscar por ID de pedido o producto...">
        </div>
        <div class="status-filter">
          <select>
            <option value="">Todos los estados</option>
            <option value="pendiente">Pendiente</option>
            <option value="preparacion">En preparación</option>
            <option value="transito">En tránsito</option>
            <option value="entregado">Entregado</option>
            <option value="cancelado">Cancelado</option>
          </select>
        </div>
      </div>

      <!-- Lista de pedidos -->
      <div class="pedidos-container">
        
        @if(count($pedidos) > 0)
          @foreach($pedidos as $pedido)
            <div class="pedido-card">
              <div class="pedido-header">
                <div class="pedido-info">
                  <h3>Pedido #{{ $pedido['id'] }}</h3>
                  <span class="fecha">{{ \Carbon\Carbon::parse($pedido['fecha'])->format('d \d\e F, Y') }}</span>
                </div>
                <div class="estado-badge {{ $pedido['estado'] }}">
                  @if($pedido['estado'] == 'entregado')
                    <i class='bx bx-check-circle'></i>
                    Entregado
                  @elseif($pedido['estado'] == 'transito')
                    <i class='bx bx-truck'></i>
                    En tránsito
                  @elseif($pedido['estado'] == 'preparacion')
                    <i class='bx bx-time-five'></i>
                    En preparación
                  @elseif($pedido['estado'] == 'cancelado')
                    <i class='bx bx-x-circle'></i>
                    Cancelado
                  @else
                    <i class='bx bx-time'></i>
                    Pendiente
                  @endif
                </div>
              </div>
              
              <div class="pedido-content">
                @foreach($pedido['productos'] as $producto)
                  <div class="producto-info">
                    @php
                      $imgSrc = $producto['imagen'];
                      if (!$imgSrc) {
                          $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                      } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                          $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                      }
                    @endphp
                    <img src="{{ $imgSrc }}" alt="{{ $producto['nombre'] }}" class="producto-img">
                    <div class="producto-details">
                      <h4>{{ $producto['nombre'] }}</h4>
                      <p>Cantidad: {{ $producto['cantidad'] }}</p>
                      <p class="precio">${{ number_format($producto['precio'], 0, ',', '.') }}</p>
                      @if($producto['caracteristicas'])
                        <p class="caracteristicas">
                          <small>{{ $producto['caracteristicas']->Marca ?? '' }} - {{ $producto['caracteristicas']->Color ?? '' }}</small>
                        </p>
                      @endif
                    </div>
                  </div>
                @endforeach
                
                <div class="pedido-stats">
                  <div class="stat">
                    <span class="label">Total:</span>
                    <span class="value">${{ number_format($pedido['total'], 0, ',', '.') }}</span>
                  </div>
                  <div class="stat">
                    <span class="label">Método de pago:</span>
                    <span class="value">{{ $pedido['metodo_pago'] }}</span>
                  </div>
                </div>
              </div>

              <div class="tracking-info">
                <h4><i class='bx bx-map'></i> Información de Envío</h4>
                <div class="tracking-details">
                  <p><strong>Dirección:</strong> {{ $pedido['direccion'] }}</p>
                  <p><strong>Transportadora:</strong> {{ $pedido['transportadora'] }}</p>
                  <p><strong>Número de guía:</strong> {{ $pedido['numero_guia'] }}</p>
                  @if($pedido['estado'] == 'entregado')
                    <p><strong>Fecha de entrega:</strong> {{ \Carbon\Carbon::parse($pedido['fecha'])->addDays(3)->format('d \d\e F, Y') }}</p>
                  @elseif($pedido['estado'] == 'transito')
                    <p><strong>Estado actual:</strong> En camino a destino</p>
                  @elseif($pedido['estado'] == 'preparacion')
                    <p><strong>Tiempo estimado:</strong> 1-2 días hábiles</p>
                  @elseif($pedido['estado'] == 'cancelado')
                    <p><strong>Estado:</strong> Este pedido ha sido cancelado</p>
                  @else
                    <p><strong>Estado:</strong> Tu pedido está siendo procesado</p>
                  @endif
                </div>
              </div>

              <div class="pedido-actions">
                <button class="btn-secondary">
                  <i class='bx bx-receipt'></i> Ver Factura
                </button>
                @if($pedido['estado'] != 'pendiente' && $pedido['estado'] != 'preparacion')
                  <button class="btn-primary">
                    <i class='bx bx-package'></i> Rastrear Envío
                  </button>
                @else
                  <button class="btn-outline" disabled>
                    <i class='bx bx-package'></i> Rastrear Envío
                  </button>
                @endif
                <button class="btn-outline">
                  <i class='bx bx-refresh'></i> Volver a Pedir
                </button>
                @if($pedido['estado'] == 'pendiente' || $pedido['estado'] == 'preparacion')
                  <button class="btn-cancel" onclick="cancelarPedido({{ $pedido['id'] }})">
                    <i class='bx bx-x-circle'></i> Cancelar Pedido
                  </button>
                @elseif($pedido['estado'] == 'cancelado')
                  <button class="btn-cancel" disabled>
                    <i class='bx bx-x-circle'></i> Pedido Cancelado
                  </button>
                @endif
              </div>
            </div>
          @endforeach
        @else
          <div class="no-pedidos">
            <div class="no-pedidos-content">
              <i class='bx bx-package'></i>
              <h3>No tienes pedidos aún</h3>
              <p>Cuando realices tu primera compra, aparecerá aquí con toda la información de seguimiento.</p>
              <a href="{{ route('catalogo.autenticado') }}" class="btn-primary">
                <i class='bx bx-shopping-bag'></i> Ir a Comprar
              </a>
            </div>
          </div>
        @endif

      </div>

    </main><!-- /main-content -->

  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

  <script>
    function cancelarPedido(pedidoId) {
      if (confirm('¿Estás seguro de que quieres cancelar este pedido? Esta acción no se puede deshacer.')) {
        // Mostrar loading
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Cancelando...';
        button.disabled = true;

        // Enviar petición AJAX
        fetch(`/pedidoscli/${pedidoId}/cancelar`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Mostrar mensaje de éxito
            alert('Pedido cancelado exitosamente');
            // Recargar la página para mostrar el estado actualizado
            location.reload();
          } else {
            // Mostrar mensaje de error
            alert('Error al cancelar el pedido: ' + (data.message || 'Error desconocido'));
            // Restaurar botón
            button.innerHTML = originalText;
            button.disabled = false;
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al cancelar el pedido. Por favor, intenta de nuevo.');
          // Restaurar botón
          button.innerHTML = originalText;
          button.disabled = false;
        });
      }
    }
  </script>

</body>
</html>
