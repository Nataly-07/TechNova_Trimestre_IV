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
          
          @if($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          
          <div class="form-row">
            <div class="form-group">
              <label for="first_name">Primer Nombre</label>
              <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Primer nombre" required />
            </div>
            <div class="form-group">
              <label for="last_name">Apellido</label>
              <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Apellido" required />
            </div>
          </div>
          
          <div class="form-group">
            <label for="document_type">Tipo de Documento</label>
            <select id="document_type" name="document_type" required>
              <option value="">Selecciona</option>
              <option value="CC" {{ old('document_type') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
              <option value="TI" {{ old('document_type') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
              <option value="CE" {{ old('document_type') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="document_number">Número de Documento</label>
            <input type="text" id="document_number" name="document_number" value="{{ old('document_number') }}" placeholder="Número de documento" required />
          </div>
          
          <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com" required />
          </div>
          
          <div class="form-group">
            <label for="phone">Teléfono Celular</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Teléfono celular" required />
          </div>
          
          <div class="form-group">
            <label for="address">Dirección de Residencia</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Dirección completa" required />
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required />
            </div>
            <div class="form-group">
              <label for="password_confirmation">Confirmar Contraseña</label>
              <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite tu contraseña" required />
            </div>
          </div>
          
          <div class="form-group">
            <label for="role">Rol del Usuario</label>
            <select id="role" name="role" required>
              <option value="">Seleccionar Rol</option>
              <option value="cliente" {{ old('role') == 'cliente' ? 'selected' : '' }}>Cliente</option>
              <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
              <option value="empleado" {{ old('role') == 'empleado' ? 'selected' : '' }}>Empleado</option>
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
                <td>{{ $user->first_name ?? 'Sin nombre' }} {{ $user->last_name ?? 'Sin apellido' }}</td>
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

  <script src="{{ asset('frontend/js/perfilad.js') }}"></script>
  
  <style>
    .form-nuevo-usuario {
      padding: 20px;
    }
    
    .form-row {
      display: flex;
      gap: 15px;
      margin-bottom: 20px;
    }
    
    .form-group {
      margin-bottom: 20px;
      position: relative;
      flex: 1;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #4a5568;
      font-weight: 600;
      font-size: 14px;
    }
    
    .form-nuevo-usuario input[type="text"],
    .form-nuevo-usuario input[type="email"],
    .form-nuevo-usuario input[type="tel"],
    .form-nuevo-usuario input[type="password"],
    .form-nuevo-usuario select {
      width: 100%;
      padding: 12px;
      margin-bottom: 5px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 16px;
      transition: border-color 0.3s;
    }
    
    .form-nuevo-usuario input:focus,
    .form-nuevo-usuario select:focus {
      outline: none;
      border-color: #007acc;
    }
    
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 8px;
    }
    
    .alert-danger {
      background-color: #fef2f2;
      border: 1px solid #fecaca;
      color: #dc2626;
    }
    
    .alert-danger ul {
      margin: 0;
      padding-left: 20px;
    }
    
    .btn-submit {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    
    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    
    @media (max-width: 768px) {
      .form-row {
        flex-direction: column;
        gap: 0;
      }
    }
  </style>

</body>
</html>
