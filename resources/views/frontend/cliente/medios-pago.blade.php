<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mis Medios de Pago - TECHNOVA</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    <style>
        .medios-pago-container {
            padding: 20px;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2.5em;
            font-weight: bold;
        }

        .page-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1em;
        }

        .medios-pago-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .medios-guardados {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .medios-guardados h2 {
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .medio-pago-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            position: relative;
        }

        .medio-pago-card:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.2);
        }

        .medio-pago-card.default {
            border-color: #28a745;
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        }

        .medio-pago-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 15px;
        }

        .medio-pago-info {
            flex: 1;
        }

        .medio-pago-brand {
            font-weight: bold;
            font-size: 1.2em;
            color: #333;
            margin-bottom: 5px;
        }

        .medio-pago-number {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .medio-pago-holder {
            color: #888;
            font-size: 0.9em;
        }

        .medio-pago-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9em;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-default {
            background: #28a745;
            color: white;
        }

        .btn-default:hover {
            background: #218838;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-default.disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .default-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .agregar-medio {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .agregar-medio h2 {
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group select,
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group select:focus,
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn-agregar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-agregar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .empty-state i {
            font-size: 4em;
            margin-bottom: 20px;
            color: #ccc;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .medios-pago-grid {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
  <header class="header">
    <a href="{{ route('catalogo.autenticado') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
      <span>TECHNOVA</span>
    </a>
    <div class="acciones-usuario">
      <a href="{{ route('perfillcli') }}" class="account">
        <i class='bx bx-user-circle'></i> <span>Mi Perfil</span>
      </a>
      <a href="{{ route('logout') }}" class="account">
        <i class='bx bx-log-out'></i> <span>Cerrar Sesión</span>
      </a>
    </div>
  </header>

  <div class="dashboard-wrapper">
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
        <div class="enlace"><a href="{{ route('perfillcli') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        @if(auth()->user() && auth()->user()->role === 'admin')
        <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
        <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-package'></i> Inventario Productos</a></div>
        @endif
        <div class="enlace"><a href="{{ url('favoritos') }}"><i class='bx bx-heart'></i> Favoritos</a></div>
        <div class="enlace"><a href="{{ url('mensajescli') }}"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace"><a href="{{ route('pedidoscli') }}"><i class='bx bx-cart'></i> Pedidos</a></div>
        <div class="enlace active"><a href="{{ url('mediopagos') }}"><i class='bx bx-credit-card'></i>Medios De<br>Pagos</a></div>
        <div class="enlace"><a href="{{ url('miscompras') }}"><i class='bx bx-shopping-bag'></i> Mis Compras</a></div>
        <div class="enlace"><a href="{{ url('atencion') }}"><i class='bx bx-headphone'></i> Atencion Al Cliente</a></div>
        <div class="enlace">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;padding:0;">
              <i class='bx bx-log-out'></i> Cerrar Sesión
            </button>
          </form>
        </div>
      </div>
    </div><!-- /.menu-dashboard -->

    <main class="main-content">
      <div class="medios-pago-container">
        <div class="page-header">
            <h1><i class='bx bx-credit-card'></i> Mis Medios de Pago</h1>
            <p>Gestiona tus métodos de pago preferidos para compras más rápidas</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class='bx bx-check-circle'></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class='bx bx-error-circle'></i> {{ session('error') }}
            </div>
        @endif

        <div class="medios-pago-grid">
            <!-- Medios de Pago Guardados -->
            <div class="medios-guardados">
                <h2><i class='bx bx-credit-card-alt'></i> Medios de Pago Guardados</h2>
                
                @if($mediosPagoGuardados->count() > 0)
                    @foreach($mediosPagoGuardados as $medio)
                        <div class="medio-pago-card {{ $medio->is_default ? 'default' : '' }}">
                            @if($medio->is_default)
                                <div class="default-badge">Predeterminado</div>
                            @endif
                            
                            <div class="medio-pago-header">
                                <div class="medio-pago-info">
                                    <div class="medio-pago-brand">
                                        @if($medio->brand === 'Crédito' || $medio->brand === 'Débito')
                                            <i class='bx bx-credit-card'></i> Tarjeta de {{ $medio->brand }}
                                        @else
                                            <i class='bx bx-wallet'></i> {{ $medio->brand }}
                                        @endif
                                    </div>
                                    <div class="medio-pago-number">
                                        **** **** **** {{ $medio->last4 }}
                                    </div>
                                    @if($medio->holder_name)
                                        <div class="medio-pago-holder">
                                            Titular: {{ $medio->holder_name }}
                                        </div>
                                    @endif
                                    @if($medio->exp_month && $medio->exp_year)
                                        <div class="medio-pago-holder">
                                            Vence: {{ $medio->exp_month }}/{{ $medio->exp_year }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="medio-pago-actions">
                                    @if(!$medio->is_default)
                                        <button class="btn-action btn-default" onclick="setDefault({{ $medio->id }})">
                                            <i class='bx bx-star'></i> Predeterminado
                                        </button>
                                    @else
                                        <button class="btn-action btn-default disabled">
                                            <i class='bx bx-check'></i> Predeterminado
                                        </button>
                                    @endif
                                    
                                    <button class="btn-action btn-delete" onclick="deletePaymentMethod({{ $medio->id }})">
                                        <i class='bx bx-trash'></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class='bx bx-credit-card'></i>
                        <h3>No tienes medios de pago guardados</h3>
                        <p>Agrega un medio de pago para hacer tus compras más rápidas</p>
                    </div>
                @endif
            </div>

            <!-- Agregar Nuevo Medio de Pago -->
            <div class="agregar-medio">
                <h2><i class='bx bx-plus-circle'></i> Agregar Medio de Pago</h2>
                
                <form id="agregarMedioForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="metodo_pago">Tipo de Medio de Pago</label>
                        <select name="metodo_pago" id="metodo_pago" required>
                            <option value="">Seleccionar método</option>
                            @foreach($metodosDisponibles as $key => $metodo)
                                @if(in_array($key, ['tarjeta_credito', 'tarjeta_debito', 'nequi', 'pse', 'transferencia_bancaria']))
                                    <option value="{{ $key }}">{{ $metodo }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre del Titular</label>
                        <input type="text" name="datos_pago[nombre]" id="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="numero">Número de Tarjeta/Cuenta</label>
                        <input type="text" name="datos_pago[numero]" id="numero" required>
                    </div>

                    <div class="form-row" id="fecha_vencimiento" style="display: none;">
                        <div class="form-group">
                            <label for="exp_mes">Mes de Vencimiento</label>
                            <select name="datos_pago[exp_mes]" id="exp_mes">
                                <option value="">Mes</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exp_anio">Año de Vencimiento</label>
                            <select name="datos_pago[exp_anio]" id="exp_anio">
                                <option value="">Año</option>
                                @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email (Opcional)</label>
                        <input type="email" name="datos_pago[email]" id="email">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono (Opcional)</label>
                        <input type="text" name="datos_pago[telefono]" id="telefono">
                    </div>

                    <button type="submit" class="btn-agregar">
                        <i class='bx bx-plus'></i> Agregar Medio de Pago
                    </button>
                </form>
            </div>
        </div>
      </div>
    </main><!-- /main-content -->
  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

  <script>
        // Mostrar/ocultar campos de fecha de vencimiento para tarjetas
        document.getElementById('metodo_pago').addEventListener('change', function() {
            const fechaVencimiento = document.getElementById('fecha_vencimiento');
            const metodo = this.value;
            
            if (metodo === 'tarjeta_credito' || metodo === 'tarjeta_debito') {
                fechaVencimiento.style.display = 'grid';
            } else {
                fechaVencimiento.style.display = 'none';
            }
        });

        // Formatear número de tarjeta
        document.getElementById('numero').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 16) value = value.substring(0, 16);
            this.value = value;
        });

        // Enviar formulario
        document.getElementById('agregarMedioForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = {
                metodo_pago: formData.get('metodo_pago'),
                datos_pago: {
                    nombre: formData.get('datos_pago[nombre]'),
                    numero: formData.get('datos_pago[numero]'),
                    exp_mes: formData.get('datos_pago[exp_mes]'),
                    exp_anio: formData.get('datos_pago[exp_anio]'),
                    email: formData.get('datos_pago[email]'),
                    telefono: formData.get('datos_pago[telefono]')
                }
            };

            fetch('{{ route("cliente.medios-pago.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (data.error || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al agregar el medio de pago');
            });
        });

        // Establecer como predeterminado
        function setDefault(id) {
            if (confirm('¿Establecer este medio de pago como predeterminado?')) {
                fetch(`/cliente/medios-pago/${id}/default`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al establecer el medio de pago predeterminado');
                });
            }
        }

        // Eliminar medio de pago
        function deletePaymentMethod(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este medio de pago?')) {
                fetch(`/cliente/medios-pago/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el medio de pago');
                });
            }
        }
    </script>
</body>
</html>
