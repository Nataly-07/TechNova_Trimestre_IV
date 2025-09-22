@extends('frontend.layouts.checkout')

@section('content')
  <h2 class="section-title">Direccion de envío</h2>
  <form method="POST" action="{{ route('checkout.direccion') }}">
    @csrf
    <div class="form-group">
      <input type="text" name="departamento" value="{{ old('departamento', $direccionActual['departamento'] ?? '') }}" placeholder="Departamento" />
      <input type="text" name="ciudad" value="{{ old('ciudad', $direccionActual['ciudad'] ?? '') }}" placeholder="Ciudad" />
    </div>
    <div class="form-group full">
      <input type="text" name="direccion" value="{{ old('direccion', $direccionActual['direccion'] ?? '') }}" placeholder="Direccion" />
    </div>
    <div class="form-group">
      <input type="text" name="localidad" value="{{ old('localidad', $direccionActual['localidad'] ?? '') }}" placeholder="Localidad" />
      <input type="text" name="barrio" value="{{ old('barrio', $direccionActual['barrio'] ?? '') }}" placeholder="Barrio" />
    </div>
    <button type="submit" class="account">Continuar</button>
  </form>
@endsection


