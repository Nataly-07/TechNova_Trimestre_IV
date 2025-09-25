<div class="menu-dashboard">
    <!-- TOP MENU -->
    <div class="top-menu">
        <div class="logo">
            <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
            <span>Panel Administrador</span>
        </div>
        <div class="toggle">
            <i class='bx bx-menu'></i>
        </div>
    </div>

    <div class="menu">
        <div class="enlace {{ request()->routeIs('perfilad') ? 'active' : '' }}"><a href="{{ route('perfilad') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        <div class="enlace {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}"><i class='bx bx-chart'></i> Dashboard</a></div>
        <div class="enlace {{ request()->routeIs('usuarios.*') ? 'active' : '' }}"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
        <div class="enlace {{ request()->routeIs('productos.*') ? 'active' : '' }}"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Movimiento de Artículos</a></div>
        <div class="enlace {{ request()->routeIs('reportes.*') ? 'active' : '' }}"><a href="{{ route('reportes.index') }}"><i class='bx bx-file-blank'></i> Reportes</a></div>
        <div class="enlace {{ request()->routeIs('proveedores.*') ? 'active' : '' }}"><a href="{{ route('proveedores.index') }}"><i class='bx bx-user-circle'></i> Proveedores</a></div>
        <div class="enlace {{ request()->routeIs('admin.mensajes.*') ? 'active' : '' }}"><a href="{{ route('admin.mensajes.index') }}"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><a href="{{ route('admin.orders.index') }}"><i class='bx bx-cart'></i> Pedidos</a></div>
        <div class="enlace {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"><a href="{{ route('admin.payments.index') }}"><i class='bx bx-credit-card'></i> Pagos</a></div>
        <div class="enlace"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class='bx bx-log-out'></i> Cerrar Sesión</a></div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
