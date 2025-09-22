<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard Cliente</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    
    <style>
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .card-icon i {
            font-size: 24px;
            color: white;
        }
        
        .card-content h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 6px 0;
        }
        
        .card-content p {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin: 0 0 15px 0;
            line-height: 1.4;
        }
        
        .card-stats {
            display: flex;
            flex-direction: column;
            margin-bottom: 18px;
        }
        
        .stat-number {
            font-size: 1.6rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 4px;
        }
        
        .stat-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: #7f8c8d;
            text-transform: lowercase;
        }
        
        .card-button {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            box-shadow: 0 3px 12px rgba(102, 126, 234, 0.3);
        }
        
        .card-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }
        
        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .card {
                padding: 18px;
            }
            
            .card-icon {
                width: 45px;
                height: 45px;
                margin-bottom: 12px;
            }
            
            .card-icon i {
                font-size: 20px;
            }
            
            .card-content h3 {
                font-size: 1.2rem;
            }
            
            .card-content p {
                font-size: 0.85rem;
            }
            
            .stat-number {
                font-size: 1.4rem;
            }
            
            .card-button {
                padding: 8px 16px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
  <header class="header">
    <a href="{{ route('catalogo.autenticado') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
      <span>TECHNOVA</span>
    </a>


    <div class="acciones-usuario">
      <a href="{{ route('perfillcli') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      <a href="/logout" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
    </div>
  </header>

  <div class="dashboard-wrapper">
    @include('frontend.layouts.sidebar-cliente')

    <main class="main-content">
      <div class="welcome-section">
        <h1>¡Bienvenido, {{ auth()->user()->name ?? 'Cliente' }}!</h1>
        <p>Panel de cliente de Technova</p>
      </div>

      <div class="profile-card">
        <img src="{{ asset('frontend/imagenes/userim.png') }}" alt="Foto de perfil">
        <div class="profile-details">
          <h2>{{ auth()->user()->name ?? 'Cliente' }}</h2>
          <p><i class='bx bx-envelope'></i> {{ auth()->user()->email ?? 'cliente@technova.com' }}</p>
          <p><i class='bx bx-shield'></i> {{ ucfirst(auth()->user()->role ?? 'cliente') }}</p>
          <a href="{{ route('perfil.edit') }}" class="edit-profile"><i class='bx bx-edit'></i> Editar perfil</a>
        </div>
      </div>

      <!-- Dashboard Cards -->
      <div class="dashboard-cards">
        <div class="card">
          <div class="card-icon">
            <i class='bx bx-heart'></i>
          </div>
          <div class="card-content">
            <h3>Mis Favoritos</h3>
            <p>Productos que te gustan</p>
            <div class="card-stats">
              <span class="stat-number">{{ $favoritosCount ?? 0 }}</span>
              <span class="stat-label">productos favoritos</span>
            </div>
            <a href="{{ route('favoritos.index') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Favoritos
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-cart'></i>
          </div>
          <div class="card-content">
            <h3>Mi Carrito</h3>
            <p>Productos en tu carrito</p>
            <div class="card-stats">
              <span class="stat-number">{{ $carritoCount ?? 0 }}</span>
              <span class="stat-label">productos en carrito</span>
            </div>
            <a href="{{ route('carrito.index') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Carrito
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-package'></i>
          </div>
          <div class="card-content">
            <h3>Mis Pedidos</h3>
            <p>Historial de compras</p>
            <div class="card-stats">
              <span class="stat-number">{{ $pedidosCount ?? 0 }}</span>
              <span class="stat-label">pedidos realizados</span>
            </div>
            <a href="{{ route('pedidoscli') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Pedidos
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-message'></i>
          </div>
          <div class="card-content">
            <h3>Mensajes</h3>
            <p>Comunicación con soporte</p>
            <div class="card-stats">
              <span class="stat-number">{{ $mensajesCount ?? 0 }}</span>
              <span class="stat-label">mensajes pendientes</span>
            </div>
            <a href="{{ url('mensajescli') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Mensajes
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-credit-card'></i>
          </div>
          <div class="card-content">
            <h3>Medios de Pago</h3>
            <p>Gestiona tus métodos de pago</p>
            <div class="card-stats">
              <span class="stat-number">{{ $mediosPagoCount ?? 0 }}</span>
              <span class="stat-label">métodos configurados</span>
            </div>
            <a href="{{ route('cliente.medios-pago.index') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Gestionar Pagos
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-icon">
            <i class='bx bx-shopping-bag'></i>
          </div>
          <div class="card-content">
            <h3>Mis Compras</h3>
            <p>Historial de tus compras realizadas</p>
            <div class="card-stats">
              <span class="stat-number">{{ $comprasCount ?? 0 }}</span>
              <span class="stat-label">compras realizadas</span>
            </div>
            <a href="{{ route('cliente.mis-compras.index') }}" class="card-button">
              <i class='bx bx-right-arrow-alt'></i> Ver Compras
            </a>
          </div>
        </div>
      </div>


    </main><!-- /main-content -->

  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

</body>
</html>
