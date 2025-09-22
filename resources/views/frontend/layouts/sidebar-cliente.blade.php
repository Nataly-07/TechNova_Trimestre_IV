<div class="menu-dashboard">
  <div class="top-menu">
    <div class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
      <span>Dashboard Cliente</span>
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
    <div class="enlace {{ request()->routeIs('perfillcli') ? 'active' : '' }}">
      <a href="{{ route('perfillcli') }}">
        <i class='bx bx-user-circle'></i> Mi Perfil
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('favoritos.*') ? 'active' : '' }}">
      <a href="{{ route('favoritos.index') }}">
        <i class='bx bx-heart'></i> Favoritos
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('mensajescli') ? 'active' : '' }}">
      <a href="{{ url('mensajescli') }}">
        <i class='bx bx-message'></i> Mensajes
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('carrito.*') ? 'active' : '' }}">
      <a href="{{ route('carrito.index') }}">
        <i class='bx bx-cart'></i> Carrito
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('pedidoscli') ? 'active' : '' }}">
      <a href="{{ route('pedidoscli') }}">
        <i class='bx bx-package'></i> Pedidos
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('cliente.medios-pago.*') ? 'active' : '' }}">
      <a href="{{ route('cliente.medios-pago.index') }}">
        <i class='bx bx-credit-card'></i> Medios De Pagos
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('cliente.mis-compras.*') ? 'active' : '' }}">
      <a href="{{ route('cliente.mis-compras.index') }}">
        <i class='bx bx-shopping-bag'></i> Mis Compras
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('atencion-cliente.*') || request()->routeIs('atencion') ? 'active' : '' }}">
      <a href="{{ route('atencion-cliente.index') }}">
        <i class='bx bx-headphone'></i> Atención Al Cliente
      </a>
    </div>
    
    <div class="enlace">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;padding:0;width:100%;text-align:left;">
          <i class='bx bx-log-out'></i> Cerrar Sesión
        </button>
      </form>
    </div>
  </div>
</div>
