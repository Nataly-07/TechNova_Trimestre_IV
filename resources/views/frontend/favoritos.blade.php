<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mis Favoritos - Technova</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    <script src="{{ asset('frontend/js/usuarios.js') }}" defer></script>
    <script src="{{ asset('frontend/js/inventarioproductos.js') }}" defer></script>
    
    <style>
        .favoritos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .favorito-card {
            background: var(--janna-light);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
            border: 2px solid var(--sinbad);
        }
        
        .favorito-card:hover {
            transform: translateY(-5px);
        }
        
        .favorito-card img {
            width: 100%;
            height: 180px;
            object-fit: contain;
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            padding: 10px;
        }
        
        .favorito-card h3 {
            color: #333;
            margin-bottom: 8px;
            font-size: 1em;
            line-height: 1.2;
        }
        
        .favorito-card .precio {
            color: #00d4ff;
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 12px;
        }
        
        .favorito-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        
        .btn-favorito {
            background-color: var(--danger);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            font-size: 16px;
            cursor: pointer;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-favorito:hover {
            background-color: #c82333;
            transform: scale(1.1);
        }
        
        .btn-carrito {
            background: var(--gradient-primary);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            font-size: 16px;
            cursor: pointer;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-carrito:hover {
            background: var(--gradient-primary-hover);
            transform: scale(1.1);
        }
        
        .empty-favoritos {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .empty-favoritos h2 {
            color: #999;
            margin-bottom: 20px;
        }
        
        .empty-favoritos a {
            display: inline-block;
            background: var(--gradient-primary);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        
        .empty-favoritos a:hover {
            background-color: #00a844;
        }
    </style>
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
    </div>
  </header>

  <div class="dashboard-wrapper">
    @if(auth()->user()->role === 'cliente')
      @include('frontend.layouts.sidebar-cliente')
    @else
      <div class="menu-dashboard">


        <div class="top-menu">
          <div class="logo">
            <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
            <span>Panel Usuario</span>
          </div>
          <div class="toggle">
            <i class='bx bx-menu'></i>
          </div>
        </div>



        <div class="input-search">
          <i class='bx bx-search'></i>
          <input type="text" class="input" placeholder="Buscar">
        </div>

        <div class="menu">
          @if(auth()->user()->role === 'admin')
            <div class="enlace"><a href="{{ route('perfilad') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
            <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
            <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Inventario</a></div>
            <div class="enlace"><a href="{{ route('dashboard') }}"><i class='bx bx-chart'></i> Estadísticas</a></div>
            <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
          @elseif(auth()->user()->role === 'empleado')
            <div class="enlace"><a href="{{ route('perfilemp') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
            <div class="enlace"><a href="{{ route('empleado.inventario') }}"><i class='bx bx-shopping-bag'></i> Visualización Artículos</a></div>
            <div class="enlace"><a href="{{ route('empleado.usuarios.cliente') }}"><i class='bx bx-user'></i> Usuarios Cliente</a></div>
          @endif
          <div class="enlace"><a href="{{ route('catalogo.autenticado') }}"><i class='bx bx-store'></i> Catálogo</a></div>
          <div class="enlace"><a href="{{ route('favoritos.index') }}"><i class='bx bx-heart'></i> Favoritos</a></div>
          <div class="enlace"><a href="{{ route('carrito.index') }}"><i class='bx bx-cart'></i> Carrito</a></div>
          <div class="enlace">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;padding:0;">
                <i class='bx bx-log-out'></i> Cerrar Sesión
              </button>
            </form>
          </div>
        </div>
      </div>
    @endif

    <!-- PRINCIPAL -->
    <main class="main-content">
      <div class="welcome-section">
        <h1>❤️ Mis Favoritos</h1>
        <p>Productos que has marcado como favoritos</p>
      </div>

      @if($favoritos->count() > 0)
        <div class="favoritos-grid">
          @foreach($favoritos as $producto)
            <div class="favorito-card">
              @php
                $imgSrc = $producto->Imagen;
                if (!$imgSrc) {
                    $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                    $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                }
              @endphp
              
              <img src="{{ $imgSrc }}" alt="{{ $producto->Nombre }}">
              <h3>{{ $producto->Nombre }}</h3>
              <div class="precio">${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }}</div>
              
              <div class="favorito-actions">
                <button class="btn-favorito favorito-btn" data-producto-id="{{ $producto->ID_Producto }}">❤️</button>
                <button class="btn-carrito">&#128722;</button>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="empty-favoritos">
          <h2>No tienes productos favoritos aún</h2>
          <p>Explora nuestro catálogo y marca tus productos favoritos con el corazón ❤️</p>
          <a href="{{ route('catalogo.autenticado') }}">Ver Catálogo</a>
        </div>
      @endif

    </main><!-- /main-content -->

  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
        // Funcionalidad de favoritos
        const favoritoBtns = document.querySelectorAll('.favorito-btn');
        
        favoritoBtns.forEach(btn => {
            btn.addEventListener('click', async function() {
                const productoId = this.getAttribute('data-producto-id');
                
                try {
                    const response = await fetch(`/favoritos/${productoId}/toggle`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        if (data.isFavorito) {
                            this.style.backgroundColor = '#ff6b6b';
                            this.innerHTML = '❤️';
                        } else {
                            // Remover la tarjeta del DOM
                            this.closest('.favorito-card').remove();
                            showMessage(data.message, 'success');
                            
                            // Si no quedan favoritos, mostrar mensaje
                            if (document.querySelectorAll('.favorito-card').length === 0) {
                                location.reload();
                            }
                        }
                    } else {
                        showMessage(data.error || 'Error al actualizar favoritos', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showMessage('Error de conexión', 'error');
                }
            });
        });

        // Función para mostrar mensajes
        function showMessage(message, type) {
            const messageDiv = document.createElement('div');
            messageDiv.textContent = message;
            messageDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 5px;
                color: white;
                font-weight: bold;
                z-index: 1000;
                ${type === 'success' ? 'background-color: #4CAF50;' : 'background-color: #f44336;'}
            `;
            
            document.body.appendChild(messageDiv);
            
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }
    });
  </script>

</body>
</html>
