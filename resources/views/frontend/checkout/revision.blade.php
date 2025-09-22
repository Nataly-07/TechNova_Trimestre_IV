@extends('frontend.layouts.checkout')

@section('content')
  <h2 class="section-title">Revisión</h2>
  @if(session('error'))
    <div class="info-box" style="background:#ffecec;color:#b00020;margin-bottom:10px;">{{ session('error') }}</div>
  @endif
  <div class="info-box">
    <h3>Datos personales</h3>
    <div>{{ $usuario->first_name }} {{ $usuario->last_name }}</div>
    <div>{{ $usuario->email }} | {{ $usuario->phone }}</div>
    <div>{{ $usuario->document_type }}: {{ $usuario->document_number }}</div>
  </div>
  @if($direccion)
  <div class="info-box">
    <h3>Dirección</h3>
    <div>{{ $direccion['direccion'] ?? '' }} - {{ $direccion['barrio'] ?? '' }}</div>
    <div>{{ $direccion['ciudad'] ?? '' }} ({{ $direccion['departamento'] ?? '' }})</div>
  </div>
  @endif
  @if($envio)
  <div class="info-box">
    <h3>Envío</h3>
    <div>Transportadora: {{ $envio['transportadora'] }}</div>
    <div>Fecha: {{ \Carbon\Carbon::parse($envio['fecha_envio'])->format('d/m/Y') }}</div>
  </div>
  @endif
  @if($pago)
  <div class="info-box">
    <h3>Pago</h3>
    <div>Método: {{ $pagoResumen ?? $pago['metodo_pago'] }}</div>
  </div>
  @endif

  <form method="POST" action="{{ route('checkout.finalizar') }}">
    @csrf
    <button type="submit" class="account">Finalizar compra</button>
  </form>
@endsection


