<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Perfil Administrador</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    <script src="{{ asset('frontend/js/usuarios.js') }}" defer></script>
    <script src="{{ asset('frontend/js/inventarioproductos.js') }}" defer></script>
</head>
<body>
  <header class="header">
    <div class="logo" style="cursor: default;">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
      <span>TECHNOVA</span>
    </div>


    <div class="acciones-usuario">
      <a href="{{ route('perfilad') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      <a href="{{ route('logout') }}" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
    </div>
  </header>

  <div class="dashboard-wrapper">
    @include('frontend.layouts.sidebar-admin')

    <!-- PRINCIPAL -->
    <main class="main-content">
      <div class="welcome-section">
        <h1>¡Bienvenido, {{ auth()->user()->name ?? 'Administrador' }}!</h1>
        <p>Panel de administración de Technova</p>
      </div>

      <div class="profile-card">
        <img src="{{ asset('frontend/imagenes/userim.png') }}" alt="Foto de perfil">
        <div class="profile-details">
          <h2>{{ auth()->user()->name ?? 'Administrador' }}</h2>
          <p><i class='bx bx-envelope'></i> {{ auth()->user()->email ?? 'admin@technova.com' }}</p>
          <p><i class='bx bx-shield'></i> {{ ucfirst(auth()->user()->role ?? 'administrador') }}</p>
          <a href="{{ route('perfil.edit') }}" class="edit-profile"><i class='bx bx-edit'></i> Editar perfil</a>
        </div>
      </div>

      <!-- Dashboard Cards -->
      <div class="dashboard-cards">
        <div class="card">
          <div class="card-icon">
            <i class='bx bx-user'></i>
          </div>
          <div class="card-content">
            <h3>Gestión de Usuarios</h3>
            <p>Administra usuarios del sistema</p>
            <div class="card-stats">
              <span class="stat-number">{{ count($users) }}</span>
              <span class="stat-label">usuarios registrados</span>
            </div>
            <a href="{{ route('usuarios.index') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Gestionar Usuarios
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-shopping-bag'></i>
          </div>
          <div class="card-content">
            <h3>Movimiento de Artículos</h3>
            <p>Controla ingresos, salidas y stock</p>
            <div class="card-stats">
              <span class="stat-number">{{ count($productos) }}</span>
              <span class="stat-label">productos en inventario</span>
            </div>
            <a href="{{ route('productos.index') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Gestionar Movimientos
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-chart'></i>
          </div>
          <div class="card-content">
            <h3>Reportes</h3>
            <p>Visualiza métricas del negocio</p>
            <div class="card-stats">
              <span class="stat-number">{{ $reportesDisponibles }}</span>
              <span class="stat-label">reportes disponibles</span>
            </div>
            <a href="{{ route('reportes.index') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Reportes
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-user-circle'></i>
          </div>
          <div class="card-content">
            <h3>Proveedores</h3>
            <p>Gestiona proveedores y compras</p>
            <div class="card-stats">
              <span class="stat-number">{{ count($proveedores) }}</span>
              <span class="stat-label">proveedores activos</span>
            </div>
            <a href="{{ route('proveedores.index') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Gestionar Proveedores
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-message'></i>
          </div>
          <div class="card-content">
            <h3>Mensajes</h3>
            <p>Gestiona comunicación del sistema</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">mensajes pendientes</span>
            </div>
            <a href="#" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Mensajes
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-cart'></i>
          </div>
          <div class="card-content">
            <h3>Pedidos</h3>
            <p>Gestiona pedidos y ventas</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">pedidos procesados</span>
            </div>
            <a href="#" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Pedidos
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-credit-card'></i>
          </div>
          <div class="card-content">
            <h3>Pagos</h3>
            <p>Gestiona transacciones y pagos</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">transacciones procesadas</span>
            </div>
            <a href="#" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Pagos
            </a>
          </div>
        </div>
      </div>


    </main><!-- /main-content -->

  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

</body>
</html>