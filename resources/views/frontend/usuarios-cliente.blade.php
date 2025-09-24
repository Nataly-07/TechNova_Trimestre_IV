<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Clientes Registrados - Technova</title>

  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header class="header">
    <div class="logo" style="cursor: default;">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
      <span>TECHNOVA</span>
    </div>


    <div class="acciones-usuario">
      <a href="{{ route('perfilemp') }}" class="account"><i class="bx bx-user-circle"></i> <span>Perfil</span></a>
      <a href="/logout" class="account"><i class="bx bx-log-out"></i> <span>Cerrar Sesión</span></a>
    </div>
  </header>

  <div class="dashboard-wrapper">
    <div class="menu-dashboard">
      <div class="top-menu">
        <div class="logo">
          <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
          <span>Panel Empleado</span>
        </div>
        <div class="toggle"><i class="bx bx-menu"></i></div>
      </div>


      <div class="menu">
        <div class="enlace"><a href="{{ route('perfilemp') }}"><i class="bx bx-user-circle"></i> Mi Perfil</a></div>
        <div class="enlace"><a href="{{ route('empleado.usuarios.cliente') }}"><i class="bx bx-user"></i> Usuarios</a></div>
        <div class="enlace"><a href="#"><i class="bx bx-message"></i> Mensajes</a></div>
        <div class="enlace"><a href="{{ route('empleado.inventario') }}"><i class="bx bx-shopping-bag"></i> Visualización Artículos</a></div>
        <div class="enlace"><a href="#"><i class="bx bx-cart"></i> Pedidos</a></div>
        <div class="enlace"><a href="#"><i class="bx bx-headphone"></i> Atención al Cliente</a></div>
        <div class="enlace"><a href="/logout"><i class="bx bx-log-out"></i> Cerrar Sesión</a></div>
      </div>
    </div>

   <main class="main-content">
  <h1>Clientes Registrados</h1>
  <h3 id="contadorClientes">Total de clientes: {{ $clientes->count() }}</h3>

      <table class="table-usuarios">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Documento</th>
            <th>Rol</th>
          </tr>
        </thead>
        <tbody id="clientesBody">
          @foreach($clientes as $cliente)
          <tr>
            <td>{{ $cliente->name }}</td>
            <td>{{ $cliente->email }}</td>
            <td>{{ $cliente->phone ?? 'N/A' }}</td>
            <td>{{ $cliente->document_number ?? 'N/A' }}</td>
            <td>
              <span class="badge badge-success">{{ ucfirst($cliente->role) }}</span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </main>
  </div>

  <footer>
    &copy; 2025 Technova
  </footer>

</body>
</html>
