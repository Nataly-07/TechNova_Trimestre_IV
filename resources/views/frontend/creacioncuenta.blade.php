<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TECHNOVA - Registro</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/estilos1.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}" />
  <style>
    .register-box {
      background: var(--gradient-light);
      border: 2px solid var(--sinbad);
      border-radius: 20px;
      padding: 40px;
      margin: 50px auto;
      max-width: 500px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .register-box h2 {
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      text-align: center;
      font-size: 2.5em;
      margin-bottom: 10px;
      font-weight: bold;
    }
    
    .register-box h3 {
      color: var(--eden);
      text-align: center;
      font-size: 1.5em;
      margin-bottom: 30px;
    }
    
    .register-box label {
      color: var(--eden);
      font-weight: bold;
      margin-bottom: 8px;
      display: block;
    }
    
    .register-box input, .register-box select {
      width: 100%;
      padding: 12px;
      border: 2px solid var(--sinbad);
      border-radius: 10px;
      font-size: 16px;
      margin-bottom: 20px;
      transition: all 0.3s ease;
      box-sizing: border-box;
    }
    
    .register-box input:focus, .register-box select:focus {
      outline: none;
      border-color: var(--bondi-blue);
      box-shadow: 0 0 0 3px rgba(7, 153, 182, 0.1);
    }
    
    .register-btn {
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
    
    .register-btn:hover {
      background: var(--gradient-primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .register-box a {
      display: block;
      text-align: center;
      color: var(--bondi-blue);
      text-decoration: none;
      margin-bottom: 10px;
      transition: color 0.3s ease;
    }
    
    .register-box a:hover {
      color: var(--bondi-blue-dark);
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
      <a href="{{ url('/iniciosesion') }}" class="account"><span>Iniciar Sesión</span></a>
      <a href="{{ url('/creacioncuenta') }}" class="account"><span>Crear Cuenta</span></a>
      <a href="{{ url('/carrito') }}" class="cart"><span class="cart-icon">&#128722;</span><span>Mi Carrito</span></a>
    </div>
  </header>

  <main class="register-box">
    <h2>TECHNOVA</h2>
    <h3>Formulario de Registro</h3>
    <form id="registro-form" method="POST" action="{{ route('frontend.register.submit') }}" novalidate>
      @csrf

      @if(session('success'))
        <div class="alert alert-success" style="color: #00d4ff; margin-bottom: 15px;">
          {{ session('success') }}
        </div>
      @endif

      <div class="form-group">
        <label for="nombre">Nombre</label>
        <div class="campo-icono">
          <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required />
          <span class="icono" id="icono-nombre"></span>
        </div>
        @error('nombre')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-group">
        <label for="apellido">Apellido</label>
        <div class="campo-icono">
          <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required />
          <span class="icono" id="icono-apellido"></span>
        </div>
        @error('apellido')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-group">
        <label for="tipo-doc">Tipo de Documento</label>
        <select id="tipo-doc" name="tipo-doc" required>
          <option value="">Selecciona</option>
          <option value="CC" {{ old('tipo_doc') == 'CC' ? 'selected' : '' }}>Cédula De Ciudadanía</option>
          <option value="TI" {{ old('tipo_doc') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
          <option value="CE" {{ old('tipo_doc') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
        </select>
        @error('tipo_doc')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-group">
        <label for="documento">Número de Documento</label>
        <div class="campo-icono">
          <input type="text" id="documento" name="documento" value="{{ old('documento') }}" required />
          <span class="icono" id="icono-documento"></span>
        </div>
        @error('documento')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-group">
        <label for="correo">Correo Electrónico</label>
        <div class="campo-icono">
          <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required />
          <span class="icono" id="icono-correo"></span>
        </div>
        @error('correo')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-group">
        <label for="confirmar-correo">Confirmar Correo</label>
        <div class="campo-icono">
          <input type="email" id="confirmar-correo" name="confirmar-correo" value="{{ old('confirmar_correo') }}" required />
          <span class="icono" id="icono-confirmar-correo"></span>
        </div>
        @error('confirmar_correo')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-group">
        <label for="telefono">Teléfono Celular</label>
        <div class="campo-icono">
          <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" required />
          <span class="icono" id="icono-telefono"></span>
        </div>
        @error('telefono')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-group">
        <label for="direccion">Dirección de Residencia</label>
        <div class="campo-icono">
          <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" required />
          <span class="icono" id="icono-direccion"></span>
        </div>
        @error('direccion')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <div class="campo-icono">
          <input type="password" id="password" name="password" required />
          <span class="icono" id="icono-password"></span>
        </div>
        @error('password')
          <small class="text-danger">{{ $message }}</small>
        @enderror
        <div class="password-requisitos">
          <p class="requisito" data-req="length">✔ Mínimo 8 caracteres</p>
          <p class="requisito" data-req="upper">✔ Mayúscula</p>
          <p class="requisito" data-req="lower">✔ Minúscula</p>
          <p class="requisito" data-req="digit">✔ Número</p>
          <p class="requisito" data-req="special">✔ Carácter especial</p>
        </div>
      </div>

      <div class="form-group">
        <label for="confirmar-password">Confirmar Contraseña</label>
        <div class="campo-icono">
          <input type="password" id="confirmar-password" name="password_confirmation" required />
          <span class="icono" id="icono-confirmar-password"></span>
        </div>
        @error('password_confirmation')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div id="mensaje" class="mensaje-confirmacion"></div>

      <button type="submit" id="btn-enviar" class="register-btn" disabled>Registrarse</button>
    </form>
  </main>

  <script src="{{ asset('frontend/js/validacioncreacion.js') }}"></script>
</body>
</html>
