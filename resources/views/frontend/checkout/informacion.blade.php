@php /** @var \App\Models\User $user */ @endphp
@extends('frontend.layouts.checkout')

@section('content')
  <h2 class="section-title">Información personal</h2>
  <form method="POST" action="{{ route('checkout.informacion') }}">
    @csrf
    <div class="form-group">
      <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="Nombres" />
      <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Apellidos" />
    </div>
    <div class="form-group">
      <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Correo" />
      <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Telefono" />
    </div>
    <div class="form-group">
      <select name="document_type">
        <option value="CC" {{ old('document_type', $user->document_type)=='CC'?'selected':'' }}>CC</option>
        <option value="CE" {{ old('document_type', $user->document_type)=='CE'?'selected':'' }}>CE</option>
        <option value="PAS" {{ old('document_type', $user->document_type)=='PAS'?'selected':'' }}>Pasaporte</option>
      </select>
      <input type="text" name="document_number" value="{{ old('document_number', $user->document_number) }}" placeholder="Numero de identidad" />
    </div>

    <button type="submit" class="account">Continuar</button>
  </form>
@endsection


