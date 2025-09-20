@extends('layouts.app')

@section('title', 'Iniciar sesión - TECHNOVA')

@section('content')
<header class="header">
  <div class="menu-icon">&#9776;</div>

  <a href="{{ url('/') }}" class="logo">
    <img src="{{ asset('imagenes/logo technova.png') }}" alt="Logo">
    <span>TECHNOVA</span>
  </a>

  <div class="search-bar">
    <input type="text" placeholder="¿Qué estás buscando hoy?">
    <button class="search-btn">&#128269;</button>
  </div>

  <div class="acciones-usuario">
    <a href="{{ route('login') }}" class="account">
      <span>Iniciar Sesión</span>
    </a>
    <a href="{{ route('register') }}" class="account">
      <span>Crear Cuenta</span>
    </a>
    <a href="{{ url('/carrito') }}" class="cart">
      <span class="cart-icon">&#128722;</span>
      <span>Mi Carrito</span>
    </a>
  </div>
</header>

<main class="login-box">
  <h2>TECHNOVA</h2>
  <h3>Iniciar sesión</h3>
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <label for="email">Correo electrónico</label>
    <input type="email" id="email" name="email" placeholder="Ingresa tu correo" required autofocus />
    @error('email')
      <span class="text-danger">{{ $message }}</span>
    @enderror

    <label for="password">Contraseña</label>
    <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required />
    @error('password')
      <span class="text-danger">{{ $message }}</span>
    @enderror

    <button type="submit" class="login-btn">Iniciar sesión</button>

    <div class="google-login">
      <img src="{{ asset('google_720255.png') }}" alt="Google" />
      <a href="https://workspace.google.com/intl/es-419/gmail/">Registrarse con Google</a>
    </div>

    <a href="{{ route('register') }}">Crear cuenta</a>
    <a href="{{ route('password.request') }}" class="forgot">Olvidé mi contraseña</a>
  </form>
</main>

<footer>
  <p>© 2025 TECHNOVA. Todos los derechos reservados.</p>
</footer>

<div id="msg-flotante" class="msg-flotante oculto"></div>

<script src="{{ asset('validacion.js') }}"></script>
@endsection
