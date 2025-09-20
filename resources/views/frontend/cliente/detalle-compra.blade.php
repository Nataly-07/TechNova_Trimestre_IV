<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Detalle de Compra #{{ $compra->ID_Compras }} - Technova</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
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
      <a href="/logout" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
    </div>
  </header>

  <div class="dashboard-wrapper">
    <div class="menu-dashboard">
      <div class="top-menu">
        <div class="logo">
          <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
          <span>Dashboard Cliente</span>
        </div>
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
      </div>

      <div class="menu">
        <div class="enlace"><a href="{{ route('perfillcli') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        @if(auth()->user() && auth()->user()->role === 'admin')
        <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
        <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-package'></i> Inventario Productos</a></div>
        @endif
        <div class="enlace"><a href="{{ url('favoritos') }}"><i class='bx bx-heart'></i> Favoritos</a></div>
        <div class="enlace"><a href="{{ url('mensajescli') }}"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace"><a href="{{ route('pedidoscli') }}"><i class='bx bx-cart'></i> Pedidos</a></div>
        <div class="enlace"><a href="{{ url('mediopagos') }}"><i class='bx bx-credit-card'></i>Medios De<br>Pagos</a></div>
        <div class="enlace active"><a href="{{ url('miscompras') }}"><i class='bx bx-shopping-bag'></i> Mis Compras</a></div>
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

    <main class="main-content">
      <div class="welcome-section">
        <div class="header-actions">
          <a href="{{ route('cliente.mis-compras.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back'></i> Volver a Mis Compras
          </a>
        </div>
        <h1>Detalle de Compra #{{ $compra->ID_Compras }}</h1>
        <p>Información completa de tu compra</p>
      </div>

      @if(session('success'))
        <div class="alert alert-success">
          <i class='bx bx-check-circle'></i>
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-error">
          <i class='bx bx-error-circle'></i>
          {{ session('error') }}
        </div>
      @endif

      <div class="detalle-grid">
        <!-- Información de la Compra -->
        <div class="info-section">
          <div class="section-header">
            <h2><i class='bx bx-info-circle'></i> Información de la Compra</h2>
          </div>
          <div class="info-card">
            <div class="info-row">
              <span class="label"><i class='bx bx-receipt'></i> Número de Compra:</span>
              <span class="value">#{{ $compra->ID_Compras }}</span>
            </div>
            <div class="info-row">
              <span class="label"><i class='bx bx-calendar'></i> Fecha de Compra:</span>
              <span class="value">{{ \Carbon\Carbon::parse($compra->Fecha_Compra)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
              <span class="label"><i class='bx bx-check-circle'></i> Estado:</span>
              <span class="status-badge status-{{ strtolower($compra->Estado) }}">
                @if($compra->Estado === 'procesado')
                  <i class='bx bx-time-five'></i> Procesando
                @elseif($compra->Estado === 'enviado')
                  <i class='bx bx-truck'></i> Enviado
                @elseif($compra->Estado === 'entregado')
                  <i class='bx bx-check-circle'></i> Entregado
                @else
                  <i class='bx bx-x-circle'></i> {{ ucfirst($compra->Estado) }}
                @endif
              </span>
            </div>
            <div class="info-row">
              <span class="label"><i class='bx bx-time'></i> Entrega Estimada:</span>
              <span class="value">{{ \Carbon\Carbon::parse($compra->Tiempo_De_Entrega)->format('d/m/Y') }}</span>
            </div>
          </div>
        </div>

        <!-- Productos Comprados -->
        <div class="info-section">
          <div class="section-header">
            <h2><i class='bx bx-package'></i> Productos Comprados</h2>
          </div>
          <div class="productos-list">
            @foreach($compra->detalles as $detalle)
              <div class="producto-item">
                <div class="producto-info">
                  <h3>{{ $detalle->producto->Nombre ?? 'Producto no disponible' }}</h3>
                  @if($detalle->producto)
                    <p class="producto-descripcion">
                      {{ $detalle->producto->Descripcion ?? 'Sin descripción disponible' }}
                    </p>
                  @endif
                </div>
                <div class="producto-details">
                  <div class="detail-row">
                    <span><i class='bx bx-hash'></i> Cantidad:</span>
                    <span class="quantity">{{ $detalle->Cantidad }}</span>
                  </div>
                  <div class="detail-row">
                    <span><i class='bx bx-money'></i> Precio Unitario:</span>
                    <span class="price">${{ number_format($detalle->Precio, 0, ',', '.') }}</span>
                  </div>
                  <div class="detail-row total">
                    <span><i class='bx bx-calculator'></i> Subtotal:</span>
                    <span class="subtotal">${{ number_format($detalle->Precio * $detalle->Cantidad, 0, ',', '.') }}</span>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Resumen de Pago -->
        <div class="info-section">
          <div class="section-header">
            <h2><i class='bx bx-credit-card'></i> Resumen de Pago</h2>
          </div>
          <div class="pago-resumen">
            <div class="resumen-row">
              <span><i class='bx bx-money'></i> Subtotal:</span>
              <span>${{ number_format($compra->Total, 0, ',', '.') }}</span>
            </div>
            <div class="resumen-row">
              <span><i class='bx bx-truck'></i> Envío:</span>
              <span>Gratis</span>
            </div>
            <div class="resumen-row">
              <span><i class='bx bx-receipt'></i> Impuestos:</span>
              <span>Incluidos</span>
            </div>
            <div class="resumen-row total">
              <span><i class='bx bx-wallet'></i> Total Pagado:</span>
              <span class="total-amount">${{ number_format($compra->Total, 0, ',', '.') }}</span>
            </div>
          </div>

          @if($compra->medioPago)
            <div class="metodo-pago">
              <h3><i class='bx bx-credit-card'></i> Método de Pago</h3>
              <div class="pago-info">
                <span class="metodo">{{ ucfirst(str_replace('_', ' ', $compra->medioPago->Metodo_pago)) }}</span>
                <span class="fecha-pago">
                  <i class='bx bx-time'></i> Pagado el {{ \Carbon\Carbon::parse($compra->medioPago->Fecha_De_Compra)->format('d/m/Y H:i') }}
                </span>
              </div>
            </div>
          @endif
        </div>

        <!-- Seguimiento -->
        <div class="info-section">
          <div class="section-header">
            <h2><i class='bx bx-trending-up'></i> Seguimiento del Pedido</h2>
          </div>
          <div class="seguimiento">
            <div class="timeline">
              <div class="timeline-item completed">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                  <h4><i class='bx bx-check-circle'></i> Compra Realizada</h4>
                  <p>{{ \Carbon\Carbon::parse($compra->Fecha_Compra)->format('d/m/Y H:i') }}</p>
                </div>
              </div>
              
              @if($compra->Estado === 'procesado')
                <div class="timeline-item active">
                  <div class="timeline-marker"></div>
                  <div class="timeline-content">
                    <h4><i class='bx bx-time-five'></i> Procesando</h4>
                    <p>Preparando tu pedido</p>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-marker"></div>
                  <div class="timeline-content">
                    <h4><i class='bx bx-truck'></i> Enviado</h4>
                    <p>Tu pedido está en camino</p>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-marker"></div>
                  <div class="timeline-content">
                    <h4><i class='bx bx-home'></i> Entregado</h4>
                    <p>Pedido entregado</p>
                  </div>
                </div>
              @elseif($compra->Estado === 'enviado')
                <div class="timeline-item completed">
                  <div class="timeline-marker"></div>
                  <div class="timeline-content">
                    <h4><i class='bx bx-time-five'></i> Procesando</h4>
                    <p>Pedido procesado</p>
                  </div>
                </div>
                <div class="timeline-item active">
                  <div class="timeline-marker"></div>
                  <div class="timeline-content">
                    <h4><i class='bx bx-truck'></i> Enviado</h4>
                    <p>Tu pedido está en camino</p>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-marker"></div>
                  <div class="timeline-content">
                    <h4><i class='bx bx-home'></i> Entregado</h4>
                    <p>Pedido entregado</p>
                  </div>
                </div>
              @elseif($compra->Estado === 'entregado')
                <div class="timeline-item completed">
                  <div class="timeline-marker"></div>
                  <div class="timeline-content">
                    <h4><i class='bx bx-time-five'></i> Procesando</h4>
                    <p>Pedido procesado</p>
                  </div>
                </div>
                <div class="timeline-item completed">
                  <div class="timeline-marker"></div>
                  <div class="timeline-content">
                    <h4><i class='bx bx-truck'></i> Enviado</h4>
                    <p>Pedido enviado</p>
                  </div>
                </div>
                <div class="timeline-item completed">
                  <div class="timeline-marker"></div>
                  <div class="timeline-content">
                    <h4><i class='bx bx-home'></i> Entregado</h4>
                    <p>Pedido entregado exitosamente</p>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </main><!-- /main-content -->
  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

  <style>
    .header-actions {
      margin-bottom: 20px;
    }

    .detalle-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      margin-top: 20px;
    }

    .info-section {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .section-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 20px;
      color: white;
    }

    .section-header h2 {
      margin: 0;
      font-size: 1.3rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .info-card {
      padding: 20px;
    }

    .info-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 0;
      border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
      border-bottom: none;
    }

    .label {
      color: var(--text-secondary);
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .value {
      color: var(--text-primary);
      font-weight: 600;
    }

    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      text-transform: uppercase;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .status-procesado {
      background: #e3f2fd;
      color: #1976d2;
    }

    .status-enviado {
      background: #fff3e0;
      color: #f57c00;
    }

    .status-entregado {
      background: #e8f5e8;
      color: #388e3c;
    }

    .status-cancelado {
      background: #ffebee;
      color: #d32f2f;
    }

    .productos-list {
      padding: 20px;
    }

    .producto-item {
      display: flex;
      justify-content: space-between;
      padding: 20px 0;
      border-bottom: 1px solid #f0f0f0;
    }

    .producto-item:last-child {
      border-bottom: none;
    }

    .producto-info {
      flex: 1;
    }

    .producto-info h3 {
      margin: 0 0 8px 0;
      color: var(--text-primary);
      font-size: 1.1rem;
    }

    .producto-descripcion {
      margin: 0;
      color: var(--text-secondary);
      font-size: 0.9rem;
    }

    .producto-details {
      text-align: right;
      min-width: 200px;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
      align-items: center;
    }

    .detail-row.total {
      font-weight: 600;
      color: var(--primary-color);
      border-top: 1px solid #e0e0e0;
      padding-top: 8px;
      margin-top: 8px;
    }

    .detail-row span:first-child {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .quantity {
      color: var(--text-secondary);
    }

    .price {
      color: var(--text-primary);
    }

    .subtotal {
      color: var(--primary-color);
      font-weight: 600;
    }

    .pago-resumen {
      padding: 20px;
    }

    .resumen-row {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid #f0f0f0;
      align-items: center;
    }

    .resumen-row:last-child {
      border-bottom: none;
    }

    .resumen-row span:first-child {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .resumen-row.total {
      font-weight: 700;
      font-size: 1.1rem;
      color: var(--primary-color);
      border-top: 2px solid var(--primary-color);
      margin-top: 10px;
      padding-top: 15px;
    }

    .total-amount {
      color: var(--primary-color);
    }

    .metodo-pago {
      margin-top: 20px;
      padding: 20px;
      background: #f8f9fa;
      border-radius: 8px;
    }

    .metodo-pago h3 {
      margin: 0 0 15px 0;
      color: var(--text-primary);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .pago-info {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .metodo {
      font-weight: 600;
      color: var(--primary-color);
    }

    .fecha-pago {
      color: var(--text-secondary);
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .seguimiento {
      padding: 20px;
    }

    .timeline {
      position: relative;
      padding-left: 30px;
    }

    .timeline::before {
      content: '';
      position: absolute;
      left: 15px;
      top: 0;
      bottom: 0;
      width: 2px;
      background: #e0e0e0;
    }

    .timeline-item {
      position: relative;
      margin-bottom: 30px;
    }

    .timeline-marker {
      position: absolute;
      left: -22px;
      top: 5px;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #e0e0e0;
      border: 3px solid white;
      box-shadow: 0 0 0 2px #e0e0e0;
    }

    .timeline-item.completed .timeline-marker {
      background: var(--primary-color);
      box-shadow: 0 0 0 2px var(--primary-color);
    }

    .timeline-item.active .timeline-marker {
      background: var(--primary-color);
      box-shadow: 0 0 0 2px var(--primary-color);
      animation: pulse 2s infinite;
    }

    .timeline-content h4 {
      margin: 0 0 5px 0;
      color: var(--text-primary);
      font-size: 1rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .timeline-content p {
      margin: 0;
      color: var(--text-secondary);
      font-size: 0.9rem;
    }

    .timeline-item.completed .timeline-content h4 {
      color: var(--primary-color);
    }

    .timeline-item.active .timeline-content h4 {
      color: var(--primary-color);
      font-weight: 600;
    }

    @keyframes pulse {
      0% { box-shadow: 0 0 0 2px var(--primary-color); }
      50% { box-shadow: 0 0 0 6px rgba(0, 212, 255, 0.3); }
      100% { box-shadow: 0 0 0 2px var(--primary-color); }
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 12px 24px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
    }

    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }

    .btn-secondary {
      background: #6c757d;
      color: white;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .alert {
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .alert-success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .menu .enlace.active a {
      background: rgba(255, 255, 255, 0.1);
      color: white;
    }

    @media (max-width: 768px) {
      .detalle-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }

      .producto-item {
        flex-direction: column;
        gap: 15px;
      }

      .producto-details {
        text-align: left;
      }

      .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
      }

      .resumen-row {
        flex-direction: column;
        gap: 5px;
      }
    }
  </style>
</body>
</html>