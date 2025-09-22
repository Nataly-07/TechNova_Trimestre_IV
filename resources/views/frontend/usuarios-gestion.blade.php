<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Gestión de Usuarios - Technova</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    <script src="{{ asset('frontend/js/usuarios.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header class="header">
    <a href="{{ url('/') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
      <span>TECHNOVA</span>
    </a>

    <div class="search-bar">
      <input type="text" placeholder="¿Qué estás buscando hoy?">
      <button class="search-btn">&#128269;</button>
    </div>

    <div class="acciones-usuario">
      <a href="{{ route('perfilad') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="account" style="background:none;border:none;cursor:pointer;"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></button>
      </form>
      <a href="#" class="cart"><i class='bx bx-cog'></i> <span>Configuración</span></a>
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

      <!-- INPUT SEARCH -->
      <div class="input-search">
        <i class='bx bx-search'></i>
        <input type="text" class="input" placeholder="Buscar">
      </div>

      <div class="menu">
        <div class="enlace"><a href="{{ route('perfilad') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
        <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Inventario</a></div>
        <div class="enlace"><a href="{{ route('dashboard') }}"><i class='bx bx-chart'></i> Estadísticas</a></div>
        <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
        <div class="enlace"><a href="#"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace"><a href="#"><i class='bx bx-cart'></i> Pedidos</a></div>
        <div class="enlace"><a href="#"><i class='bx bx-credit-card'></i> Pagos</a></div>
        <div class="enlace"><a href="#"><i class='bx bx-cog'></i> Configuraciones</a></div>
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
      <div class="welcome-section">
        <h1>Gestión de Usuarios</h1>
        <p>Administra usuarios del sistema Technova</p>
      </div>

      <!-- Formulario para nuevo usuario -->
      <div class="form-section">
        <div class="form-header">
          <h2><i class='bx bx-user-plus'></i> Agregar Nuevo Usuario</h2>
        </div>
        <form action="{{ route('usuarios.store') }}" method="POST" class="form-nuevo-usuario">
          @csrf
          <div class="form-row">
            <input type="text" name="name" placeholder="Nombre completo" required />
            <input type="email" name="email" placeholder="Correo electrónico" required />
          </div>
          <div class="form-row">
            <input type="password" name="password" placeholder="Contraseña" required />
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required />
          </div>
          <div class="form-row">
            <input type="text" name="first_name" placeholder="Primer nombre" />
            <input type="text" name="last_name" placeholder="Apellido" />
          </div>
          <div class="form-row">
            <input type="text" name="document_type" placeholder="Tipo de documento" />
            <input type="text" name="document_number" placeholder="Número de documento" />
          </div>
          <div class="form-row">
            <input type="text" name="phone" placeholder="Teléfono" />
            <input type="text" name="address" placeholder="Dirección" />
          </div>
          <div class="form-row">
            <select name="role" required>
              <option value="">Seleccionar Rol</option>
              <option value="cliente">Cliente</option>
              <option value="admin">Administrador</option>
              <option value="empleado">Empleado</option>
            </select>
          </div>
          <button type="submit" class="btn-submit">
            <i class='bx bx-user-plus'></i> Agregar Usuario
          </button>
        </form>
      </div>

      <!-- Controles de búsqueda y filtro -->
      <div class="controls-section">
        <div class="search-controls">
          <div class="search-box">
            <i class='bx bx-search'></i>
            <input type="text" id="buscadorUsuarios" placeholder="Buscar usuario por nombre o correo..." />
          </div>
          <div class="filter-box">
            <label for="filtroRol">Filtrar por rol:</label>
            <select id="filtroRol">
              <option value="todos">Todos los roles</option>
              <option value="admin">Administrador</option>
              <option value="cliente">Cliente</option>
              <option value="empleado">Empleado</option>
            </select>
          </div>
        </div>
        <div class="stats-box">
          <h3 id="contadorUsuarios">Total de usuarios: {{ $users->count() }}</h3>
        </div>
      </div>

      <!-- Tabla de Usuarios -->
      <div class="table-section">
        <div class="table-header">
          <h2><i class='bx bx-table'></i> Lista de Usuarios</h2>
        </div>
        <div class="table-container">
          <table class="table-usuarios">
            <thead>
              <tr>
                <th><i class='bx bx-user'></i> Nombre</th>
                <th><i class='bx bx-envelope'></i> Correo</th>
                <th><i class='bx bx-shield'></i> Rol</th>
                <th><i class='bx bx-cog'></i> Acciones</th>
              </tr>
            </thead>
            <tbody id="usuarios-body">
              @foreach($users as $user)
              <tr>
                <td>{{ $user->name ?? 'Sin nombre' }}</td>
                <td>{{ $user->email ?? 'Sin correo' }}</td>
                <td>
                  <span class="rol-badge rol-{{ $user->role ?? 'cliente' }}">
                    {{ ucfirst($user->role ?? 'cliente') }}
                  </span>
                </td>
                <td class="actions-cell">
                  <a href="{{ route('usuarios.edit', $user->id) }}" class="btn-action btn-edit">
                    <i class='bx bx-edit'></i> Editar
                  </a>
                  <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                      <i class='bx bx-trash'></i> Eliminar
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </main><!-- /main-content -->

  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

</body>
</html>
