<div class="menu-dashboard">
  <div class="top-menu">
    <div class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
      <span>Panel Empleado</span>
    </div>
    <div class="toggle">
      <i class='bx bx-menu'></i>
    </div>
  </div>

  <div class="menu">
    <div class="enlace {{ request()->routeIs('perfilemp') ? 'active' : '' }}">
      <a href="{{ route('perfilemp') }}">
        <i class='bx bx-user-circle'></i> Mi Perfil
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('empleado.usuarios.*') ? 'active' : '' }}">
      <a href="{{ route('empleado.usuarios.cliente') }}">
        <i class='bx bx-user'></i> Usuarios
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('empleado.mensajes.*') ? 'active' : '' }}">
      <a href="{{ route('empleado.mensajes.index') }}">
        <i class='bx bx-message'></i> Mensajes
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('empleado.inventario') ? 'active' : '' }}">
      <a href="{{ route('empleado.inventario') }}">
        <i class='bx bx-shopping-bag'></i> Visualización Artículos
      </a>
    </div>
    
    <div class="enlace">
      <a href="#">
        <i class='bx bx-cart'></i> Pedidos
      </a>
    </div>
    
    <div class="enlace {{ request()->routeIs('empleado.atencion-cliente.*') ? 'active' : '' }}">
      <a href="{{ route('empleado.atencion-cliente.index') }}">
        <i class='bx bx-headphone'></i> Atención al Cliente
      </a>
    </div>
    
    <div class="enlace">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px; text-align: left;">
          <i class='bx bx-log-out'></i> Cerrar Sesión
        </button>
      </form>
    </div>
  </div>
</div>


