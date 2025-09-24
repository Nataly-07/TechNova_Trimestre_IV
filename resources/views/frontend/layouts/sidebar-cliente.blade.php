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

    <!-- Notificaciones -->
    <div class="enlace {{ request()->routeIs('notificaciones.*') ? 'active' : '' }}">
      <a href="{{ route('notificaciones.index') }}">
        <i class='bx bx-bell'></i> Notificaciones
      </a>
    </div>
    
    <!-- Carrito (rama develop) -->
    <div class="enlace {{ request()->routeIs('carrito.*') ? 'active' : '' }}">
      <a href="{{ route('carrito.index') }}">
        <i class='bx bx-cart'></i> Carrito
      </a>
    </div>
    
    <!-- Pedidos -->
    <div class="enlace {{ request()->routeIs('pedidoscli*') ? 'active' : '' }}">
      <a href="{{ route('pedidoscli') }}">
        <i class='bx bx-package'></i> Pedidos
      </a>
    </div>
    
    <!-- Medios de Pago -->
    <div class="enlace {{ request()->routeIs('cliente.medios-pago.*') || request()->routeIs('mediopagos') ? 'active' : '' }}">
      <a href="{{ route('cliente.medios-pago.index') }}">
        <i class='bx bx-credit-card'></i> Medios De<br>Pagos
      </a>
    </div>
    
    <!-- Mis Compras -->
    <div class="enlace {{ request()->routeIs('cliente.mis-compras.*') || request()->routeIs('miscompras') ? 'active' : '' }}">
      <a href="{{ route('cliente.mis-compras.index') }}">
        <i class='bx bx-shopping-bag'></i> Mis Compras
      </a>
    </div>
    
    <!-- Atención al Cliente -->
    <div class="enlace {{ request()->routeIs('atencion-cliente.*') || request()->routeIs('atencion') ? 'active' : '' }}">
      <a href="{{ route('atencion-cliente.index') }}">
        <i class='bx bx-headphone'></i> Atención Al Cliente
      </a>
    </div>
    
    <!-- Logout -->
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
