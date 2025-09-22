<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventario - Empleados</title>
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header class="header">
    <a href="{{ route('index') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" />
      <span>TECHNOVA</span>
    </a>
    <div class="search-bar">
      <input type="text" placeholder="Buscar producto..." id="buscarProducto" />
      <button class="search-btn">&#128269;</button>
    </div>
    <div class="acciones-usuario">
      <a href="{{ route('perfilemp') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      <a href="{{ route('index') }}" class="account"><i class='bx bx-log-out'></i> <span>Salir</span></a>
    </div>
  </header>

    <div class="dashboard-wrapper">
    <div class="menu-dashboard">
      <!-- TOP MENU -->
      <div class="top-menu">
        <div class="logo">
          <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="">
          <span>Panel Empleado</span>
        </div>
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
      </div>

      <!-- INPUT SEARCH -->
      <div class="input-search">
        <i class='bx bx-search'></i>
        <input type="text" class="input" placeholder="Buscar">
      </div>

      <!-- MENÚ -->
     <div class="menu">
        <div class="enlace"><a href="{{ route('perfilemp') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        <div class="enlace"><a href="{{ route('empleado.usuarios.cliente') }}"><i class='bx bx-user'></i> Usuarios</a></div>
        <div class="enlace"><a href="mensajesemp.html"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace"><a href="{{ route('inventarioempleados') }}"><i class='bx bx-shopping-bag'></i> Visualización Artículos</a></div>
        <div class="enlace"><a href="pedidosemp.html"><i class='bx bx-cart'></i> Pedidos</a></div>
        <div class="enlace"><a href="atencion.html"><i class='bx bx-headphone'></i> Atencion Al Cliente</a></div>
        <div class="enlace"><a href="{{ route('index') }}"><i class='bx bx-log-out'></i> Cerrar Sesion</a></div>
      </div>


    </div><!-- /.menu-dashboard -->

    <main class="main-content">
    <h1>Catálogo de Visualización Artículos</h1>

    <table class="table-inventario">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Precio Venta</th>
          <th>Unidades</th>
          <th>Disponibilidad</th>
        </tr>
      </thead>
      <tbody>
        @foreach($productos as $producto)
        <tr>
          <td class="nombre">{{ $producto->Nombre }}</td>
          <td>${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }}</td>
          <td>{{ $producto->Stock }}</td>
          <td>
            <span class="estado {{ $producto->Stock > 0 ? 'disponible' : 'agotado' }}">
              {{ $producto->Stock > 0 ? "Disponible" : "Agotado" }}
            </span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </main>

  <script>
    // Manejar error de carga de imagen
    document.querySelectorAll('img').forEach(img => {
      img.onerror = function() {
        this.src = '{{ asset("frontend/imagenes/default.png") }}';
      };
    });
  </script>

  <script>
    // Manejar error de carga de imagen
    document.querySelectorAll('img').forEach(img => {
      img.onerror = function() {
        this.src = '{{ asset("frontend/imagenes/default.png") }}';
      };
    });
  </script>

  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; 2025 Technova
  </footer>

</body>
</html>
