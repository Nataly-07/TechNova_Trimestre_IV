{{-- filepath: resources/views/frontend/agregarproveedor.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Agregar Proveedor</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
</head>
<body>
  <header class="header">
    <a href="{{ route('index') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" />
      <span>TECHNOVA</span>
    </a>

    <div class="search-bar">
      <input type="text" placeholder="¿Qué estás buscando hoy?" />
      <button class="search-btn">&#128269;</button>
    </div>

    <div class="acciones-usuario">
      <a href="{{ url('perfilad') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      <a href="{{ route('index') }}" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesion</span></a>
      <a href="{{ url('configuraciones') }}" class="cart"><i class='bx bx-cog'></i> <span>Configuracion</span></a>
    </div>
  </header>

  <div class="dashboard-wrapper">
    <div class="menu-dashboard">
      <!-- TOP MENU -->
      <div class="top-menu">
        <div class="logo">
          <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="" />
          <span>Panel Administrador</span>
        </div>
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
      </div>

      <!-- INPUT SEARCH -->
      <div class="input-search">
        <i class='bx bx-search'></i>
        <input type="text" class="input" placeholder="Buscar" />
      </div>

      <div class="menu">
        <div class="enlace"><a href="{{ url('perfilad') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        <div class="enlace"><a href="{{ url('usuarios') }}"><i class='bx bx-user'></i> Usuarios</a></div>
        <div class="enlace"><a href="{{ url('dashboardad') }}"><i class='bx bx-chart'></i> Estadisticas</a></div>
        <div class="enlace"><a href="{{ url('mensajes') }}"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace"><a href="{{ url('inventarioproductos') }}"><i class='bx bx-shopping-bag'></i> Inventario</a></div>
        <div class="enlace"><a href="{{ url('pedidosad') }}"><i class='bx bx-cart'></i> Pedidos</a></div>
        <div class="enlace"><a href="{{ url('pagos') }}"><i class='bx bx-credit-card'></i> Pagos</a></div>
        <div class="enlace"><a href="{{ url('proveedores') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
        <div class="enlace"><a href="{{ url('configuraciones') }}"><i class='bx bx-cog'></i> Configuraciones</a></div>
        <div class="enlace"><a href="{{ route('index') }}"><i class='bx bx-log-out'></i> Cerrar Sesion</a></div>
      </div>
    </div><!-- /.menu-dashboard -->

    <main class="main-content">
      <h1>Agregar Proveedor</h1>

      <form action="{{ route('proveedores.store') }}" method="POST" class="form-agregar-proveedor">
        @csrf
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required />

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required />

        <label for="productos">Productos:</label>
        <input type="text" id="productos" name="productos" required />

        <label for="fecha_factura">Fecha última factura:</label>
        <input type="date" id="fecha_factura" name="fecha_factura" required />

        <button type="submit">Agregar Proveedor</button>
      </form>
    </main><!-- /main-content -->
  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; 2025 Technova
  </footer>
</body>
</html>
