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
    <div class="menu-dashboard">
      <!-- TOP MENU -->
      <div class="top-menu">
        <div class="logo">
          <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
          <span>Panel Administrador</span>
        </div>
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
      </div>


      <div class="menu">
        <div class="enlace active"><a href="{{ route('perfilad') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
        <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Movimiento de Artículos</a></div>
        <div class="enlace"><a href="{{ route('reportes.index') }}"><i class='bx bx-file-blank'></i> Reportes</a></div>
        <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
        <div class="enlace"><a href="#"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace"><a href="#"><i class='bx bx-cart'></i> Pedidos</a></div>
        <div class="enlace"><a href="#"><i class='bx bx-credit-card'></i> Pagos</a></div>
        <div class="enlace"><a href="{{ route('logout') }}"><i class='bx bx-log-out'></i> Cerrar Sesión</a></div>
      </div>

    </div><!-- /.menu-dashboard -->

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
            <h3>Estadísticas</h3>
            <p>Visualiza métricas del negocio</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">reportes disponibles</span>
            </div>
            <a href="{{ route('dashboard') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Estadísticas
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
              <span class="stat-number">-</span>
              <span class="stat-label">proveedores activos</span>
            </div>
            <a href="{{ route('proveedores.index') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Gestionar Proveedores
            </a>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="quick-actions">
        <h2>Acciones Rápidas</h2>
        <div class="action-buttons">
          <a href="{{ route('usuarios.create') }}" class="action-btn primary">
            <i class='bx bx-user-plus'></i>
            <span>Nuevo Usuario</span>
          </a>
          <a href="{{ route('productos.create') }}" class="action-btn secondary">
            <i class='bx bx-plus'></i>
            <span>Nuevo Producto</span>
          </a>
          <a href="#" class="action-btn tertiary">
            <i class='bx bx-message'></i>
            <span>Ver Mensajes</span>
          </a>
          <a href="#" class="action-btn quaternary">
            <i class='bx bx-cart'></i>
            <span>Ver Pedidos</span>
          </a>
        </div>
      </div>

    </main><!-- /main-content -->

  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

</body>
</html>