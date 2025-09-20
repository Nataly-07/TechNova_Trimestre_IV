<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TECHNOVA - Crear Cuenta</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/estilos.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow-x: hidden;
    }

    .auth-container {
      position: relative;
      width: 100%;
      max-width: 1200px;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-wrapper {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      padding: 40px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      position: relative;
      z-index: 10;
    }

    .form-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .logo {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    }

    .logo i {
      font-size: 28px;
      color: white;
    }

    .form-title {
      font-size: 28px;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 8px;
    }

    .form-subtitle {
      color: #718096;
      font-size: 16px;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #4a5568;
      font-weight: 600;
      font-size: 14px;
    }

    .input-wrapper {
      position: relative;
    }

    .form-group input {
      width: 100%;
      padding: 16px 20px;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      font-size: 16px;
      transition: all 0.3s ease;
      background: #f8fafc;
    }

    .form-group input:focus {
      outline: none;
      border-color: #667eea;
      background: white;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .input-icon {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #a0aec0;
      font-size: 20px;
    }

    .form-group input:focus + .input-icon {
      color: #667eea;
    }

    .error-message {
      color: #e53e3e;
      font-size: 14px;
      margin-top: 6px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .error-message i {
      font-size: 16px;
    }

    .register-btn {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
      position: relative;
      overflow: hidden;
    }

    .register-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
    }

    .register-btn:active {
      transform: translateY(0);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 30px 0;
      color: #a0aec0;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e2e8f0;
    }

    .divider span {
      padding: 0 20px;
      font-size: 14px;
    }

    .login-link {
      text-align: center;
      margin-top: 20px;
    }

    .login-link a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .login-link a:hover {
      color: #764ba2;
    }

    /* Decoraciones flotantes */
    .floating-shape {
      position: absolute;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
      animation: float 6s ease-in-out infinite;
    }

    .shape-1 {
      width: 80px;
      height: 80px;
      top: 10%;
      left: 10%;
      animation-delay: 0s;
    }

    .shape-2 {
      width: 120px;
      height: 120px;
      top: 20%;
      right: 15%;
      animation-delay: 2s;
    }

    .shape-3 {
      width: 60px;
      height: 60px;
      bottom: 20%;
      left: 20%;
      animation-delay: 4s;
    }

    .shape-4 {
      width: 100px;
      height: 100px;
      bottom: 10%;
      right: 10%;
      animation-delay: 1s;
    }

    .shape-5 {
      width: 40px;
      height: 40px;
      top: 50%;
      left: 5%;
      animation-delay: 3s;
    }

    .shape-6 {
      width: 70px;
      height: 70px;
      top: 60%;
      right: 5%;
      animation-delay: 5s;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0px) rotate(0deg);
      }
      50% {
        transform: translateY(-20px) rotate(180deg);
      }
    }

    /* Responsive */
    @media (max-width: 768px) {
      .form-wrapper {
        margin: 20px;
        padding: 30px 20px;
      }

      .form-title {
        font-size: 24px;
      }

      .floating-shape {
        display: none;
      }
    }

    /* Animación de entrada */
    .form-wrapper {
      animation: slideInUp 0.6s ease-out;
    }

    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <!-- Decoraciones flotantes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    <div class="floating-shape shape-4"></div>
    <div class="floating-shape shape-5"></div>
    <div class="floating-shape shape-6"></div>

    <div class="form-wrapper">
      <div class="form-header">
        <div class="logo">
          <i class='bx bx-laptop'></i>
        </div>
        <h1 class="form-title">Crear Cuenta</h1>
        <p class="form-subtitle">Únete a la comunidad TechNova</p>
  </div>

      @if(session('error'))
        <div class="error-message">
          <i class='bx bx-error-circle'></i>
          {{ session('error') }}
  </div>
      @endif

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
          <label for="name">Nombre completo</label>
          <div class="input-wrapper">
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Ingresa tu nombre completo" />
            <i class='bx bx-user input-icon'></i>
          </div>
      @error('name')
            <div class="error-message">
              <i class='bx bx-error-circle'></i>
              {{ $message }}
            </div>
      @enderror
    </div>

    <div class="form-group">
          <label for="email">Correo electrónico</label>
          <div class="input-wrapper">
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="tu@email.com" />
            <i class='bx bx-envelope input-icon'></i>
          </div>
      @error('email')
            <div class="error-message">
              <i class='bx bx-error-circle'></i>
              {{ $message }}
            </div>
      @enderror
    </div>

    <div class="form-group">
      <label for="password">Contraseña</label>
          <div class="input-wrapper">
            <input type="password" id="password" name="password" required placeholder="Mínimo 8 caracteres" />
            <i class='bx bx-lock-alt input-icon'></i>
          </div>
      @error('password')
            <div class="error-message">
              <i class='bx bx-error-circle'></i>
              {{ $message }}
            </div>
      @enderror
    </div>

    <div class="form-group">
          <label for="password_confirmation">Confirmar contraseña</label>
          <div class="input-wrapper">
            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repite tu contraseña" />
            <i class='bx bx-lock-alt input-icon'></i>
          </div>
        </div>

        <button type="submit" class="register-btn">
          <i class='bx bx-user-plus' style="margin-right: 8px;"></i>
          Crear Cuenta
        </button>
      </form>

      <div class="divider">
        <span>¿Ya tienes cuenta?</span>
      </div>

      <div class="login-link">
        <a href="/iniciosesion">
          <i class='bx bx-log-in' style="margin-right: 6px;"></i>
          Iniciar Sesión
        </a>
      </div>
    </div>
  </div>
</body>
</html>
