<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Technova</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/css/producto.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
</head>
<body>
 <header class="header">
  <a href="{{ route('catalogo.autenticado') }}" class="logo">
    <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" style="cursor:pointer;">
    <span>TECHNOVA</span>
  </a>

  <!-- Barra de búsqueda -->
  <div class="search-container">
    <form action="{{ route('buscar') }}" method="GET" class="search-form">
      <input type="text" name="q" placeholder="Buscar productos..." class="search-input" value="{{ request('q') }}">
      <button type="submit" class="search-btn">
        🔍
      </button>
    </form>
  </div>

  @php
    $cartCount = 0;
    try {
      $carritoUser = Auth::user()->carrito ?? null;
      if ($carritoUser) {
        $cartCount = $carritoUser->detalles()->sum('Cantidad');
      }
    } catch (\Throwable $e) {}
  @endphp

  <div class="acciones-usuario">
    @if(Auth::user()->role === 'admin')
      <a href="{{ route('perfilad') }}" class="account">
        <span>Perfil</span>
      </a>
    @elseif(Auth::user()->role === 'empleado')
      <a href="{{ route('perfilemp') }}" class="account">
        <span>Perfil</span>
      </a>
    @else
      <a href="{{ route('perfillcli') }}" class="account">
        <span>Perfil</span>
      </a>
    @endif
    
    <a href="/logout" class="account">
      <span>Cerrar Sesión</span>
    </a>
    
    <a href="{{ route('favoritos.index') }}" class="cart">
      <span class="cart-icon">❤️</span>
      <span>Favoritos</span>
    </a>
    
    <a href="{{ route('carrito.index') }}" class="cart" style="position: relative;">
      <span class="cart-icon">&#128722;</span>
      @if($cartCount > 0)
        <span class="cart-badge" style="position:absolute; top:-6px; right:-6px; background:#e63946; color:#fff; border-radius:12px; padding:2px 6px; font-size:12px; line-height:1; font-weight:700;">{{ $cartCount }}</span>
      @endif
      <span>Carrito</span>
    </a>
  </div>
</header>

@if(isset($query) && $query)
<div class="search-results-header">
  <div class="search-info">
    <span class="search-label">Resultados para:</span>
    <span class="search-term">"{{ $query }}"</span>
    <a href="{{ route('catalogo.autenticado') }}" class="clear-search">Limpiar búsqueda</a>
  </div>
</div>
@endif

<nav class="menu-principal">
  <ul>
    <li><a href="{{ route('index') }}">Inicio</a></li>
      <li class="submenu">
      <a href="#">Categorías ▾</a>
      <ul class="submenu-lista">
        <li><a href="{{ route('auth.celulares') }}">📱 Celulares</a></li>
        <li><a href="{{ route('auth.portatiles') }}">💻 Portátiles</a></li>
        <!-- Oferta removida según solicitud -->
      </ul>
    </li>
    <li class="submenu">
      <a href="#">Marcas ▾</a>
      <ul class="submenu-lista">
        <li><a href="{{ route('auth.marca.apple') }}">🍎 Apple</a></li>
        <li><a href="{{ route('auth.marca.samsung') }}">📱 Samsung</a></li>
        <li><a href="{{ route('auth.marca.motorola') }}">📞 Motorola</a></li>
        <li><a href="{{ route('auth.marca.xiaomi') }}">🧡 Xiaomi</a></li>
        <li><a href="{{ route('auth.marca.oppo') }}">📲 OPPO</a></li>
        <li><a href="{{ route('auth.marca.lenovo') }}">💻 Lenovo</a></li>
      </ul>
    </li>
    <li><a href="#contacto">Contacto</a></li>
  </ul>
</nav>

<!-- Contenido principal -->
<div class="contenido-principal">
  <!-- Carrusel de productos -->
  <div class="carrusel-productos-contenedor">
    <button class="carrusel-btn prev">&#10094;</button>

    <div class="carrusel-track">
      @foreach($productos as $producto)
      <div class="producto">
        @php
          $imgSrc = $producto->Imagen;
          if (!$imgSrc) {
              $imgSrc = asset('frontend/imagenes/foto perfil.webp');
          } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
              $imgSrc = asset('frontend/imagenes/' . $imgSrc);
          }
        @endphp
        <img src="{{ $imgSrc }}" alt="{{ $producto->Nombre }}">
        <a href="#"><span class="detalles">Ver Más Detalles</span></a>
        <h3>{{ $producto->Nombre }}</h3>
        <p>4.5 ⭐</p>
        <p class="precio-original">${{ number_format($producto->caracteristicas->Precio_Venta * 1.05, 0, ',', '.') }}</p>
        <p class="precio-descuento">${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }} <span class="descuento">-5%</span></p>
         <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
           <button class="favorito-btn" data-producto-id="{{ $producto->ID_Producto }}" style="background-color: #ff6b6b; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 18px; cursor: pointer; color: white;">❤️</button>
           <button class="carrito-btn" data-producto-id="{{ $producto->ID_Producto }}" style="background: var(--gradient-primary); border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 18px; cursor: pointer; color: white; transition: all 0.3s ease;">&#128722;</button>
         </div>
      </div>
      @endforeach
    </div>

    <button class="carrusel-btn next">&#10095;</button>
  </div>

<div class="info-botones">
    <div class="info-btn">
        <span class="icon">&#128666;</span>
        <span>Envios<br>gratis</span>
    </div>
    <div class="info-btn">
        <span class="icon">&#128179;</span>
        <span>Metodos<br>de pago</span>
    </div>
    <div class="info-btn">
        <span class="icon">&#128100;</span>
        <span>Asistencia<br>virtual</span>
    </div>
</div>
<div class="ofertas-container" style="background: var(--gradient-light); padding: 20px 25px; border-radius: 10px; overflow: hidden; max-width: 100%; box-sizing: border-box; display: flex; gap: 25px; justify-content: center; flex-wrap: nowrap;">
    <div class="bloque" style="margin-bottom: 40px; overflow: hidden; flex: 0 0 300px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <span class="vendido1" style="background: var(--gradient-secondary); color: white; padding: 6px 15px; border-radius: 15px; font-weight: bold; font-size: 1em; align-self: flex-start;">Oferta del dia</span>
        <div class="producto-card" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 15px 15px 70px 15px; width: 240px; text-align: center; position: relative; margin-top: 12px; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            @if($productos->count() > 0)
            @php
              $imgSrc = $productos->first()->Imagen;
              if (!$imgSrc) {
                  $imgSrc = asset('frontend/imagenes/foto perfil.webp');
              } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                  $imgSrc = asset('frontend/imagenes/' . $imgSrc);
              }
            @endphp
            <img src="{{ $imgSrc }}" alt="{{ $productos->first()->Nombre }}" style="width: 180px; height: auto; margin: 0 auto; display: block; border-radius: 10px;">
            <a href="#" style="display: inline-block; margin: 15px 0; background: var(--gradient-secondary); color: white; padding: 8px 15px; border-radius: 12px; font-weight: bold; font-size: 1em; text-decoration: none;">Ver Más Detalles</a>
            <h3 style="font-weight: bold; margin: 12px 0 8px; font-size: 1.2em;">{{ $productos->first()->Nombre }}</h3>
            <p style="margin: 8px 0; font-size: 1em;">4.9 ⭐</p>
            <p class="precio-original" style="text-decoration: line-through; color: gray; margin: 8px 0; font-size: 0.9em;">
              ${{ number_format($productos->first()->caracteristicas->Precio_Venta * 1.05, 0, ',', '.') }}
            </p>
            <p class="precio-descuento" style="color: #006600; font-weight: bold; margin: 8px 0; font-size: 1.1em;">
              ${{ number_format($productos->first()->caracteristicas->Precio_Venta, 0, ',', '.') }}
              <span class="descuento" style="background-color: #cce5cc; color: #006600; padding: 3px 8px; border-radius: 6px; font-size: 0.9em; margin-left: 8px;">-5%</span>
            </p>
            <button class="carrito-btn" style="background: var(--gradient-primary); border: none; border-radius: 50%; width: 48px; height: 48px; color: white; font-size: 24px; cursor: pointer; position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); transition: all 0.3s ease;">
              &#128722;
            </button>
            @endif
        </div>
    </div>
     <div class="bloque" style="margin-top: 40px; overflow: hidden; flex: 0 0 660px;">
        <div class="bloque-header" style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <span class="vendido1" style="background: var(--gradient-secondary); color: white; padding: 6px 15px; border-radius: 15px; font-weight: bold; font-size: 1em;">Ofertas que te pueden interesar</span>
            <a href="#" class="ver-mas" style="color: #00d4ff; font-weight: bold; font-size: 1em; text-decoration: none;">Ver mas</a>
        </div>
        <div class="productos-grid" style="display: flex; gap: 20px; overflow: hidden; flex-wrap: nowrap; justify-content: flex-start;">
            @foreach($productos->take(3) as $producto)
            <div class="producto-card" style="background: white; border-radius: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 15px 15px 70px 15px; width: 200px; text-align: center; position: relative;">
                @php
                  $imgSrc = $producto->Imagen;
                  if (!$imgSrc) {
                      $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                  } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                      $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                  }
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $producto->Nombre }}" style="width: 120px; height: auto; margin: 0 auto 10px; display: block; border-radius: 8px;">
                <a href="#" style="display: inline-block; margin: 8px 0; background: var(--gradient-secondary); color: white; padding: 6px 12px; border-radius: 10px; font-weight: bold; font-size: 0.9em; text-decoration: none;">Ver Más Detalles</a>
                <h3 style="font-weight: bold; margin: 8px 0 6px; font-size: 1em;">{{ $producto->Nombre }}</h3>
                <p style="margin: 6px 0; font-size: 0.9em;">4.5 ⭐</p>
                <p class="precio-original" style="text-decoration: line-through; color: gray; margin: 6px 0; font-size: 0.8em;">
                  ${{ number_format($producto->caracteristicas->Precio_Venta * 1.38, 0, ',', '.') }}
                </p>
                <p class="precio-descuento" style="color: #006600; font-weight: bold; margin: 6px 0; font-size: 1em;">
                  ${{ number_format($producto->caracteristicas->Precio_Venta, 0, ',', '.') }}
                  <span class="descuento" style="background-color: #cce5cc; color: #006600; padding: 2px 6px; border-radius: 6px; font-size: 0.8em; margin-left: 6px;">-5%</span>
                </p>
                <button class="carrito-btn" data-producto-id="{{ $producto->ID_Producto }}" style="background: var(--gradient-primary); border: none; border-radius: 50%; width: 40px; height: 40px; color: white; font-size: 20px; cursor: pointer; position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); transition: all 0.3s ease;">
                  &#128722;
                </button>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
// Funciones para redirección de categorías y marcas
function redirectCategory(categoria) {
    if (categoria) {
        window.location.href = `/auth/categoria/${categoria}`;
    }
}

function redirectBrand(marca) {
    if (marca) {
        window.location.href = `/auth/marca/${marca}`;
    }
}



// Carrusel de productos (igual que el index público)
document.addEventListener("DOMContentLoaded", () => {
    const track = document.querySelector(".carrusel-track");
    const btnNext = document.querySelector(".carrusel-btn.next");
    const btnPrev = document.querySelector(".carrusel-btn.prev");

    if (track && btnNext && btnPrev) {
        btnNext.addEventListener("click", () => {
            track.scrollBy({ left: 320, behavior: "smooth" });
        });

        btnPrev.addEventListener("click", () => {
            track.scrollBy({ left: -320, behavior: "smooth" });
        });
    }

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
                    // Cambiar el estilo del botón según el estado
                    if (data.isFavorito) {
                        this.style.backgroundColor = '#ff6b6b';
                        this.innerHTML = '❤️';
                    } else {
                        this.style.backgroundColor = '#ccc';
                        this.innerHTML = '🤍';
                    }
                    
                    // Mostrar mensaje de éxito
                    showMessage(data.message, 'success');
                } else {
                    showMessage(data.error || 'Error al actualizar favoritos', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error de conexión', 'error');
            }
        });
    });

    // Funcionalidad de carrito - Versión simplificada
    console.log('Inicializando funcionalidad de carrito...');
    
    // Esperar un poco para asegurar que el DOM esté completamente cargado
    setTimeout(function() {
        const carritoBtns = document.querySelectorAll('.carrito-btn');
        console.log('Botones de carrito encontrados:', carritoBtns.length);
        
        if (carritoBtns.length === 0) {
            console.error('No se encontraron botones de carrito');
            return;
        }
        
        carritoBtns.forEach(function(btn, index) {
            console.log('Configurando botón', index, ':', btn);
            
            // Verificar que el botón tenga el atributo data-producto-id
            const productoId = btn.getAttribute('data-producto-id');
            console.log('Producto ID del botón', index, ':', productoId);
            
            if (!productoId) {
                console.error('Botón', index, 'no tiene data-producto-id');
                return;
            }
            
            // Agregar event listener
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('¡Botón de carrito clickeado!');
                console.log('Producto ID:', productoId);
                
                // Cambiar el botón temporalmente
                const originalText = this.innerHTML;
                this.innerHTML = 'Agregando...';
                this.disabled = true;
                
                // Hacer la petición
                fetch('/carrito/agregar/' + productoId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cantidad: 1 })
                })
                .then(function(response) {
                    console.log('Respuesta del servidor:', response.status);
                    return response.json();
                })
                .then(function(data) {
                    console.log('Datos recibidos:', data);
                    
                    if (data.success) {
                        // Mostrar éxito
                        btn.innerHTML = '✓ Agregado';
                        btn.style.backgroundColor = 'var(--success)';
                        
                        // Actualizar contador del carrito dinámicamente
                        updateCartCounter(data.cartCount || 0);
                        
                        // Mostrar mensaje
                        showMessage('Producto agregado al carrito exitosamente', 'success');
                        
                        // Restaurar botón después de 2 segundos
                        setTimeout(function() {
                            btn.innerHTML = originalText;
                            btn.style.background = 'var(--gradient-primary)';
                            btn.disabled = false;
                        }, 2000);
                    } else {
                        showMessage('Error: ' + (data.error || 'Error desconocido'), 'error');
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                })
                .catch(function(error) {
                    console.error('Error en la petición:', error);
                    showMessage('Error de conexión: ' + error.message, 'error');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
            });
        });
    }, 1000); // Esperar 1 segundo

    // Función para actualizar el contador del carrito
    function updateCartCounter(count) {
        const cartBadge = document.getElementById('cart-badge');
        if (cartBadge) {
            if (count > 0) {
                cartBadge.textContent = count;
                cartBadge.style.display = 'block';
            } else {
                cartBadge.style.display = 'none';
            }
        }
    }

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