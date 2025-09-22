<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard Cliente</title>

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
      <a href="{{ route('perfilcli') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
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
        <div class="enlace"><a href="{{ url('mediopagos') }}"><i class='bx bx-credit-card'></i>Medios De  Pagos</a></div>
        <div class="enlace"><a href="{{ url('miscompras') }}"><i class='bx bx-cart'></i> Mis Compras</a></div>
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
        <h1>¡Bienvenido, {{ auth()->user()->name ?? 'Cliente' }}!</h1>
        <p>Panel de cliente de Technova</p>
      </div>

      <div class="profile-card">
        <img src="{{ asset('frontend/imagenes/userim.png') }}" alt="Foto de perfil">
        <div class="profile-details">
          <h2>{{ auth()->user()->name ?? 'Cliente' }}</h2>
          <p><i class='bx bx-envelope'></i> {{ auth()->user()->email ?? 'cliente@technova.com' }}</p>
          <p><i class='bx bx-shield'></i> {{ ucfirst(auth()->user()->role ?? 'cliente') }}</p>
          <a href="{{ route('perfil.edit') }}" class="edit-profile"><i class='bx bx-edit'></i> Editar perfil</a>
        </div>
      </div>

      <!-- Dashboard Cards -->
      <div class="dashboard-cards">
        <div class="card">
          <div class="card-icon">
            <i class='bx bx-heart'></i>
          </div>
          <div class="card-content">
            <h3>Mis Favoritos</h3>
            <p>Productos que te gustan</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">productos favoritos</span>
            </div>
            <a href="{{ url('favoritos') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Favoritos
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-cart'></i>
          </div>
          <div class="card-content">
            <h3>Mis Pedidos</h3>
            <p>Historial de compras</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">pedidos realizados</span>
            </div>
            <a href="{{ route('pedidoscli') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Pedidos
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-message'></i>
          </div>
          <div class="card-content">
            <h3>Mensajes</h3>
            <p>Comunicación con soporte</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">mensajes pendientes</span>
            </div>
            <a href="{{ url('mensajescli') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Mensajes
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-credit-card'></i>
          </div>
          <div class="card-content">
            <h3>Medios de Pago</h3>
            <p>Gestiona tus métodos de pago</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">métodos configurados</span>
            </div>
            <a href="{{ url('mediopagos') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Gestionar Pagos
            </a>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="quick-actions">
        <h2>Acciones Rápidas</h2>
        <div class="action-buttons">
          <a href="{{ url('favoritos') }}" class="action-btn primary">
            <i class='bx bx-heart'></i>
            <span>Ver Favoritos</span>
          </a>
          <a href="{{ route('pedidoscli') }}" class="action-btn secondary">
            <i class='bx bx-cart'></i>
            <span>Mis Pedidos</span>
          </a>
          <a href="{{ url('mensajescli') }}" class="action-btn tertiary">
            <i class='bx bx-message'></i>
            <span>Mensajes</span>
          </a>
          <a href="{{ url('atencion') }}" class="action-btn quaternary">
            <i class='bx bx-headphone'></i>
            <span>Soporte</span>
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
