<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Mis Compras - Technova</title>

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
    @include('frontend.layouts.sidebar-cliente')

    <main class="main-content">
      <div class="welcome-section">
        <h1>Mis Compras</h1>
        <p>Historial de todas tus compras realizadas</p>
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

      @if($compras->count() > 0)
        <div class="compras-container">
          @foreach($compras as $compra)
            <div class="compra-card">
              <div class="compra-header">
                <div class="compra-info">
                  <h3><i class='bx bx-receipt'></i> Compra #{{ $compra->ID_Compras }}</h3>
                  <p class="compra-fecha">
                    <i class='bx bx-calendar'></i> {{ \Carbon\Carbon::parse($compra->Fecha_Compra)->format('d/m/Y H:i') }}
                  </p>
                </div>
                <div class="compra-status">
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
              </div>

              <div class="compra-details">
                <div class="compra-items">
                  <h4><i class='bx bx-package'></i> Productos ({{ $compra->detalles->count() }})</h4>
                  <div class="items-list">
                    @foreach($compra->detalles as $detalle)
                      <div class="item">
                        <span class="item-name">{{ $detalle->producto->Nombre ?? 'Producto no disponible' }}</span>
                        <span class="item-quantity">x{{ $detalle->Cantidad }}</span>
                        <div class="item-price-container">
                          <div class="precio-original" style="text-decoration: line-through; color: #999; font-size: 0.8rem;">
                            ${{ number_format($detalle->Precio * 1.05, 0, ',', '.') }}
                          </div>
                          <span class="item-price" style="color: #27ae60; font-weight: bold;">
                            ${{ number_format($detalle->Precio, 0, ',', '.') }}
                            <span class="descuento" style="background-color: #cce5cc; color: #006600; padding: 2px 6px; border-radius: 6px; font-size: 0.7rem; margin-left: 6px;">-5%</span>
                          </span>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>

                <div class="compra-summary">
                  <div class="summary-row">
                    <span><i class='bx bx-money'></i> Total:</span>
                    <span class="total-amount">${{ number_format($compra->Total, 0, ',', '.') }}</span>
                  </div>
                  @if($compra->medioPago)
                    <div class="summary-row">
                      <span><i class='bx bx-credit-card'></i> Método de pago:</span>
                      <span>{{ ucfirst(str_replace('_', ' ', $compra->medioPago->Metodo_pago)) }}</span>
                    </div>
                  @endif
                  <div class="summary-row">
                    <span><i class='bx bx-time'></i> Entrega estimada:</span>
                    <span>{{ \Carbon\Carbon::parse($compra->Tiempo_De_Entrega)->format('d/m/Y') }}</span>
                  </div>
                </div>
              </div>

              <div class="compra-actions">
                <a href="{{ route('cliente.mis-compras.show', $compra->ID_Compras) }}" class="btn btn-primary">
                  <i class='bx bx-show'></i> Ver Detalles
                </a>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Paginación -->
        <div class="pagination-container">
          {{ $compras->links() }}
        </div>
      @else
        <div class="empty-state">
          <div class="empty-icon">
            <i class='bx bx-shopping-bag'></i>
          </div>
          <h3>No tienes compras realizadas</h3>
          <p>Aún no has realizado ninguna compra. ¡Explora nuestros productos y haz tu primera compra!</p>
          <a href="{{ route('catalogo.autenticado') }}" class="btn btn-primary">
            <i class='bx bx-store'></i> Ver Productos
          </a>
        </div>
      @endif
    </main><!-- /main-content -->
  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

  <style>
    .compras-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
      margin-top: 20px;
    }

    .compra-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .compra-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    .compra-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }

    .compra-info h3 {
      margin: 0;
      font-size: 1.3rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .compra-fecha {
      margin: 5px 0 0 0;
      opacity: 0.9;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .status-badge {
      padding: 8px 16px;
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

    .compra-details {
      padding: 20px;
    }

    .compra-items h4 {
      margin: 0 0 15px 0;
      color: var(--text-primary);
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .items-list {
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-bottom: 20px;
    }

    .item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid #f0f0f0;
    }

    .item:last-child {
      border-bottom: none;
    }

    .item-name {
      flex: 1;
      color: var(--text-primary);
    }

    .item-quantity {
      color: var(--text-secondary);
      margin: 0 10px;
    }

    .item-price {
      color: var(--primary-color);
      font-weight: 600;
    }

    .compra-summary {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 8px;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
      align-items: center;
    }

    .summary-row:last-child {
      margin-bottom: 0;
    }

    .summary-row span:first-child {
      color: var(--text-secondary);
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .summary-row span:last-child {
      color: var(--text-primary);
      font-weight: 500;
    }

    .total-amount {
      color: var(--primary-color) !important;
      font-weight: 700 !important;
      font-size: 1.1rem;
    }

    .compra-actions {
      padding: 20px;
      background: #f8f9fa;
      text-align: center;
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

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .empty-state {
      text-align: center;
      padding: 60px 20px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .empty-icon {
      font-size: 4rem;
      margin-bottom: 20px;
      color: var(--primary-color);
    }

    .empty-state h3 {
      color: var(--text-primary);
      margin-bottom: 10px;
    }

    .empty-state p {
      color: var(--text-secondary);
      margin-bottom: 30px;
      max-width: 400px;
      margin-left: auto;
      margin-right: auto;
    }

    .pagination-container {
      margin-top: 30px;
      display: flex;
      justify-content: center;
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
      .compra-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }

      .item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
      }

      .summary-row {
        flex-direction: column;
        gap: 5px;
      }
    }
  </style>
</body>
</html>