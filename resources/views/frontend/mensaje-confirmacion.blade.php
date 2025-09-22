<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technova | Confirmación de Compra</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/comprainfo.css') }}">
         <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
         <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <header class="header">
    @if(auth()->user()->role === 'cliente')
      <a href="{{ route('catalogo.autenticado') }}" class="logo">
        <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
        <span>TECHNOVA</span>
      </a>
    @else
      <div class="logo" style="cursor: default;">
        <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
        <span>TECHNOVA</span>
      </div>
    @endif
    
    <div class="search-bar">
      <input type="text" placeholder="¿Qué estás buscando hoy?">
      <button class="search-btn">&#128269;</button>
    </div>
    
    <div class="acciones-usuario">
      @if(auth()->user()->role === 'admin')
        <a href="{{ route('perfilad') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      @elseif(auth()->user()->role === 'empleado')
        <a href="{{ route('perfilemp') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      @else
        <a href="{{ route('perfillcli') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      @endif
      <a href="{{ route('logout') }}" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
      <a href="{{ route('favoritos.index') }}" class="cart"><i class='bx bx-heart'></i> <span>Favoritos</span></a>
      <a href="{{ route('carrito.index') }}" class="cart"><i class='bx bx-cart'></i> <span>Carrito</span></a>
    </div>
  </header>

  <main class="confirmacion-compra">
    <div class="container">
      <div class="confirmacion-content">
        <div class="success-icon">
          <i class='bx bx-check-circle' style="font-size: 80px; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"></i>
        </div>
        
        <h1 style="background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">¡Compra Realizada Exitosamente!</h1>
        
        <div class="confirmacion-details">
          <p><strong>Gracias por tu compra, {{ auth()->user()->name }}!</strong></p>
          <p>Tu pedido ha sido procesado y recibirás un correo de confirmación en breve.</p>
          
          <div class="info-box">
            <h3>Detalles de tu compra:</h3>
            <ul>
              <li><strong>Fecha:</strong> {{ date('d/m/Y H:i') }}</li>
              <li><strong>Estado:</strong> <span style="color: #00d4ff;">Procesado</span></li>
              <li><strong>Tiempo estimado de entrega:</strong> 3-5 días hábiles</li>
            </ul>
          </div>
          
          <div class="actions">
            <a href="{{ route('catalogo.autenticado') }}" class="btn btn-primary">
              <i class='bx bx-store'></i> Continuar Comprando
            </a>
            <a href="{{ route('compras.index') }}" class="btn btn-secondary">
              <i class='bx bx-receipt'></i> Ver Mis Compras
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <p>© 2025 TECHNOVA. Todos los derechos reservados.</p>
  </footer>

  <style>
    .confirmacion-compra {
      min-height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      padding: 20px;
    }
    
    .container {
      max-width: 600px;
      width: 100%;
    }
    
    .confirmacion-content {
      background: white;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      padding: 40px;
      text-align: center;
    }
    
    .success-icon {
      margin-bottom: 20px;
    }
    
    .confirmacion-content h1 {
      color: #00d4ff;
      font-size: 2.5em;
      margin-bottom: 20px;
    }
    
    .confirmacion-details p {
      font-size: 1.1em;
      margin-bottom: 15px;
      color: #333;
    }
    
    .info-box {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
      margin: 30px 0;
      text-align: left;
    }
    
    .info-box h3 {
      color: #00d4ff;
      margin-bottom: 15px;
    }
    
    .info-box ul {
      list-style: none;
      padding: 0;
    }
    
    .info-box li {
      padding: 8px 0;
      border-bottom: 1px solid #eee;
    }
    
    .info-box li:last-child {
      border-bottom: none;
    }
    
    .actions {
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-top: 30px;
    }
    
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 12px 24px;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
      transition: all 0.3s ease;
    }
    
    .btn-primary {
      background: var(--gradient-primary);
      color: white;
    }
    
    .btn-primary:hover {
      background: #00a041;
      transform: translateY(-2px);
    }
    
    .btn-secondary {
      background: #6c757d;
      color: white;
    }
    
    .btn-secondary:hover {
      background: #545b62;
      transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
      .actions {
        flex-direction: column;
      }
      
      .confirmacion-content {
        padding: 20px;
      }
      
      .confirmacion-content h1 {
        font-size: 2em;
      }
    }
  </style>
</body>
</html>
