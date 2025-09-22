@extends('frontend.layouts.checkout')

@section('content')
  <h2 class="section-title">Método de envío</h2>
  @if($direccion)
    <div class="info-box" style="margin-bottom:15px;">
      <strong>Enviar a:</strong>
      <div>{{ $direccion['direccion'] ?? '' }}, {{ $direccion['barrio'] ?? '' }}</div>
      <div>{{ $direccion['ciudad'] ?? '' }} - {{ $direccion['departamento'] ?? '' }}</div>
    </div>
  @endif
  <form method="POST" action="{{ route('checkout.envio') }}">
    @csrf
    <div class="form-group">
      <select name="transportadora">
        <option value="Servientrega">Servientrega</option>
        <option value="Coordinadora">Coordinadora</option>
        <option value="Interrapidisimo">Interrapidísimo</option>
      </select>
      <input type="date" name="fecha_envio" value="{{ old('fecha_envio', now()->addDay()->toDateString()) }}" />
    </div>
    <button type="submit" class="account">Continuar</button>
  </form>
@endsection


