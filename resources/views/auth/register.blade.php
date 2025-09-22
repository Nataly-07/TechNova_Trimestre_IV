@extends('layouts.app')

@section('title', 'Registro - TECHNOVA')

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
    <a href="{{ route('login') }}" class="account"><span>Iniciar Sesión</span></a>
    <a href="{{ route('register') }}" class="account"><span>Crear Cuenta</span></a>
    <a href="{{ url('/carrito') }}" class="cart"><span class="cart-icon">&#128722;</span><span>Mi Carrito</span></a>
  </div>
</header>

<main class="login-box">
  <h2>TECHNOVA</h2>
  <h3>Formulario de Registro</h3>
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
      <label for="name">Nombre</label>
      <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus />
      @error('name')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label for="email">Correo Electrónico</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required />
      @error('email')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" required />
      @error('password')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label for="password_confirmation">Confirmar Contraseña</label>
      <input type="password" id="password_confirmation" name="password_confirmation" required />
    </div>

    <button type="submit" class="login-btn">Registrarse</button>
  </form>
</main>

<script src="{{ asset('validacioncreacion.js') }}"></script>
@endsection
