<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Perfil Empleado</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
</head>
<body>
  <header class="header">
    <div class="logo" style="cursor: default;">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
      <span>TECHNOVA</span>
    </div>


    <div class="acciones-usuario">
      <a href="{{ route('perfilemp') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      <a href="/logout" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
    </div>
  </header>

  <div class="dashboard-wrapper">
    <div class="menu-dashboard">
      <div class="top-menu">
        <div class="logo">
          <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
          <span>Panel Empleado</span>
        </div>
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
      </div>


      <div class="menu">
        <div class="enlace"><a href="{{ route('perfilemp') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        <div class="enlace"><a href="{{ route('empleado.usuarios.cliente') }}"><i class='bx bx-user'></i> Usuarios</a></div>
        <div class="enlace"><a href="#"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace"><a href="{{ route('empleado.inventario') }}"><i class='bx bx-shopping-bag'></i> Visualización Artículos</a></div>
        <div class="enlace"><a href="#"><i class='bx bx-cart'></i> Pedidos</a></div>
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
        <h1>¡Bienvenido, {{ auth()->user()->name ?? 'Empleado' }}!</h1>
        <p>Panel de empleado de Technova</p>
      </div>

      <div class="profile-card">
        <img src="{{ asset('frontend/imagenes/userim.png') }}" alt="Foto de perfil">
        <div class="profile-details">
          <h2>{{ auth()->user()->name ?? 'Empleado' }}</h2>
          <p><i class='bx bx-envelope'></i> {{ auth()->user()->email ?? 'empleado@technova.com' }}</p>
          <p><i class='bx bx-shield'></i> {{ ucfirst(auth()->user()->role ?? 'empleado') }}</p>
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
            <p>Administra usuarios clientes</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">usuarios gestionados</span>
            </div>
            <a href="{{ route('empleado.usuarios.cliente') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Gestionar Usuarios
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-shopping-bag'></i>
          </div>
          <div class="card-content">
            <h3>Visualización Artículos</h3>
            <p>Visualiza el stock de productos</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">productos en inventario</span>
            </div>
            <a href="{{ route('empleado.inventario') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Artículos
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-message'></i>
          </div>
          <div class="card-content">
            <h3>Mensajes</h3>
            <p>Comunicación con clientes</p>
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
            <p>Gestiona pedidos de clientes</p>
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
            <i class='bx bx-headphone'></i>
          </div>
          <div class="card-content">
            <h3>Atención al Cliente</h3>
            <p>Gestiona consultas y soporte</p>
            <div class="card-stats">
              <span class="stat-number">-</span>
              <span class="stat-label">consultas pendientes</span>
            </div>
            <a href="{{ route('atencion-cliente.index') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Gestionar Consultas
            </a>
          </div>
        </div>
      </div>


    </main><!-- /main-content -->

  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

  <script>
    // Filtro de búsqueda en el menú
    document.addEventListener('DOMContentLoaded', function() {
      const buscador = document.getElementById('buscador-menu');
      const enlaces = document.querySelectorAll('.menu .enlace a');
      
      if (buscador && enlaces.length > 0) {
        buscador.addEventListener('input', function() {
          const termino = this.value.toLowerCase();
          
          enlaces.forEach(function(enlace) {
            const texto = enlace.textContent.toLowerCase();
            const enlaceDiv = enlace.closest('.enlace');
            
            if (texto.includes(termino)) {
              enlaceDiv.style.display = 'block';
            } else {
              enlaceDiv.style.display = 'none';
            }
          });
        });
      }
    });
  </script>

</body>
</html>
