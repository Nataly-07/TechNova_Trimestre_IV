<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TECHNOVA - Iniciar sesión</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/estilos.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}" />
  <style>
    .login-box {
      background: var(--gradient-light);
      border: 2px solid var(--sinbad);
      border-radius: 20px;
      padding: 40px;
      margin: 50px auto;
      max-width: 400px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .login-box h2 {
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      text-align: center;
      font-size: 2.5em;
      margin-bottom: 10px;
      font-weight: bold;
    }
    
    .login-box h3 {
      color: var(--eden);
      text-align: center;
      font-size: 1.5em;
      margin-bottom: 30px;
    }
    
    .login-box label {
      color: var(--eden);
      font-weight: bold;
      margin-bottom: 8px;
      display: block;
    }
    
    .login-box input {
      width: 100%;
      padding: 12px;
      border: 2px solid var(--sinbad);
      border-radius: 10px;
      font-size: 16px;
      margin-bottom: 20px;
      transition: all 0.3s ease;
      box-sizing: border-box;
    }
    
    .login-box input:focus {
      outline: none;
      border-color: var(--bondi-blue);
      box-shadow: 0 0 0 3px rgba(7, 153, 182, 0.1);
    }
    
    .login-btn {
      width: 100%;
      background: var(--gradient-primary);
      color: white;
      border: none;
      border-radius: 25px;
      padding: 15px;
      font-size: 1.1em;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-bottom: 20px;
    }
    
    .login-btn:hover {
      background: var(--gradient-primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .google-login {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
      padding: 10px;
      border: 2px solid var(--sinbad);
      border-radius: 10px;
      background: white;
      transition: all 0.3s ease;
    }
    
    .google-login:hover {
      border-color: var(--bondi-blue);
      background: var(--sinbad-light);
    }
    
    .google-login a {
      color: var(--eden);
      text-decoration: none;
      font-weight: bold;
    }
    
    .login-box a {
      display: block;
      text-align: center;
      color: var(--bondi-blue);
      text-decoration: none;
      margin-bottom: 10px;
      transition: color 0.3s ease;
    }
    
    .login-box a:hover {
      color: var(--bondi-blue-dark);
    }
    
    .forgot {
      font-size: 0.9em;
      color: var(--san-marino) !important;
    }
  </style>
</head>
<body>
 <header class="header">
  <div class="menu-icon">&#9776;</div>

  <a href="{{ url('/') }}" class="logo">
    <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
    <span>TECHNOVA</span>
  </a>

  <div class="search-bar">
    <input type="text" placeholder="¿Qué estás buscando hoy?">
    <button class="search-btn">&#128269;</button>
  </div>

  <div class="acciones-usuario">
    <a href="{{ url('/iniciosesion') }}" class="account">
      <span>Iniciar Sesión</span>
    </a>
    <a href="{{ url('/creacioncuenta') }}" class="account">
      <span>Crear Cuenta</span>
    </a>
  
  </div>
</header>

  <main class="login-box">
    <h2>TECHNOVA</h2>
    <h3>Iniciar sesión</h3>
    <form id="iniciosesion" method="POST" action="{{ route('frontend.login.submit') }}">
      @csrf
      <label for="email">Correo electrónico</label>
      <input type="email" id="email" name="email" placeholder="Ingresa tu correo" required />
      @error('email')
        <span class="text-danger">{{ $message }}</span>
      @enderror

      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required />
      @error('password')
        <span class="text-danger">{{ $message }}</span>
      @enderror

      <button type="submit" class="login-btn">Iniciar sesión</button>
      <div class="google-login">
      <img src="{{ asset('frontend/imagenes/google_720255.png') }}" alt="" />
      <a href="https://workspace.google.com/intl/es-419/gmail/">Registrarse con Google</a>
      </div>
      <a href="{{ url('/creacioncuenta') }}">Crear cuenta</a>
      <a href="" class="forgot">Olvidé mi contraseña</a>
    </form>
  </main>
  <footer>
    <p>© 2025 TECHNOVA. Todos los derechos reservados.</p>
  </footer>
   
  <div id="msg-flotante" class="msg-flotante oculto"></div>

  <script src="{{ asset('frontend/js/validacion.js') }}"></script>
</body>
</html>
