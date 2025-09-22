@extends('frontend.layouts.checkout')

@section('content')
  <h2 class="section-title">Forma de pago</h2>
  <form method="POST" action="{{ route('checkout.pago') }}">
    @csrf
    @if(session('error'))
      <div class="info-box" style="background:#ffecec;color:#b00020;margin-bottom:10px;">{{ session('error') }}</div>
    @endif
    @if(($savedPaymentMethods ?? null) && $savedPaymentMethods->count())
      <div class="form-group">
        <label>Tarjetas guardadas</label>
        <select name="saved_payment_method_id" id="saved_payment_method_id">
          <option value="">Usar nueva tarjeta</option>
          @foreach($savedPaymentMethods as $pm)
            <option value="{{ $pm->id }}">{{ $pm->brand }} **** {{ $pm->last4 }}</option>
          @endforeach
        </select>
      </div>
    @endif
    <div class="form-group">
      <select name="metodo_pago" id="metodo_pago">
        @foreach($metodosDisponibles as $value => $label)
          <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group" id="tarjeta_campos" style="display:none; flex-wrap: wrap; gap: 10px;">
      <input type="text" name="datos_pago[numero]" placeholder="Número de tarjeta" />
      <input type="text" name="datos_pago[nombre]" placeholder="Nombre" />
      <input type="text" name="datos_pago[apellido]" placeholder="Apellido" />
      <input type="text" name="datos_pago[exp_mes]" placeholder="MM" style="max-width:80px;" />
      <input type="text" name="datos_pago[exp_anio]" placeholder="AAAA" style="max-width:100px;" />
      <input type="text" name="datos_pago[cvc]" placeholder="CVC/CVV" style="max-width:120px;" />
      <input type="email" name="datos_pago[email]" placeholder="Correo" />
      <input type="text" name="datos_pago[telefono]" placeholder="Telefono" />
      <select name="datos_pago[cuotas]">
        <option value="1">1 cuota</option>
        <option value="3">3 cuotas</option>
        <option value="6">6 cuotas</option>
        <option value="12">12 cuotas</option>
      </select>
    </div>
    <div class="form-group">
      <label style="display:flex;align-items:center;gap:8px;">
        <input type="checkbox" name="guardar_tarjeta" value="1" /> Guardar tarjeta en mi perfil
      </label>
    </div>
    <button type="submit" class="account">Continuar</button>
  </form>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      var selector = document.getElementById('metodo_pago');
      var tarjetaCampos = document.getElementById('tarjeta_campos');
      var savedSelect = document.getElementById('saved_payment_method_id');
      function toggle(){
        var v = selector.value;
        var usingCard = (v === 'tarjeta_credito' || v === 'tarjeta_debito');
        var usingSaved = savedSelect && savedSelect.value;
        if(usingCard && !usingSaved){
          tarjetaCampos.style.display = '';
        } else {
          tarjetaCampos.style.display = 'none';
        }
      }
      selector.addEventListener('change', toggle);
      if(savedSelect){ savedSelect.addEventListener('change', toggle); }
      toggle();
    });
  </script>
@endsection


