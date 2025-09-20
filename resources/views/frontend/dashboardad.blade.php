<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin - TECHNOVA</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/estilos.css') }}" />
</head>
<body>
  <header class="header">
    <a href="{{ route('index') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" />
      <span>TECHNOVA</span>
    </a>
    <nav>
      <ul>
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h1>Bienvenido al Dashboard de Administrador</h1>
    <p>Desde aquí puedes gestionar la aplicación.</p>
  </main>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
  </form>
</body>
</html>
