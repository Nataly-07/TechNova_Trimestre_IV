<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Editar Perfil - Technova</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
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
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #00d4ff;
        }
        .btn-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: var(--gradient-secondary);
            color: white;
        }
        .btn-primary:hover {
            background: var(--gradient-primary-hover);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
            <span>TECHNOVA</span>
        </a>

        <div class="search-bar">
            <input type="text" placeholder="¿Qué estás buscando hoy?">
            <button class="search-btn">&#128269;</button>
        </div>

        <div class="acciones-usuario">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('perfilad') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
            @elseif(Auth::user()->role === 'empleado')
                <a href="{{ route('perfilemp') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
            @else
                <a href="{{ route('perfillcli') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
            @endif
            
            <a href="/logout" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
        </div>
    </header>

    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 30px; color: #00d4ff;">
            <i class='bx bx-edit-alt'></i> Editar Perfil
        </h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('perfil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $user->first_name) }}" required>
                @error('nombre')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="apellido">Apellido *</label>
                <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $user->last_name) }}" required>
                @error('apellido')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tipo_doc">Tipo de Documento *</label>
                <select id="tipo_doc" name="tipo_doc" required>
                    <option value="">Selecciona un tipo</option>
                    <option value="CC" {{ old('tipo_doc', $user->document_type) == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                    <option value="TI" {{ old('tipo_doc', $user->document_type) == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                    <option value="CE" {{ old('tipo_doc', $user->document_type) == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                </select>
                @error('tipo_doc')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="documento">Número de Documento *</label>
                <input type="text" id="documento" name="documento" value="{{ old('documento', $user->document_number) }}" required>
                @error('documento')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico *</label>
                <input type="email" id="correo" name="correo" value="{{ old('correo', $user->email) }}" required>
                @error('correo')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono *</label>
                <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $user->phone) }}" required>
                @error('telefono')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="direccion">Dirección *</label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $user->address) }}" required>
                @error('direccion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Nueva Contraseña (opcional)</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-save'></i> Guardar Cambios
                </button>
                
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('perfilad') }}" class="btn btn-secondary">
                        <i class='bx bx-arrow-back'></i> Cancelar
                    </a>
                @elseif(Auth::user()->role === 'empleado')
                    <a href="{{ route('perfilemp') }}" class="btn btn-secondary">
                        <i class='bx bx-arrow-back'></i> Cancelar
                    </a>
                @else
                    <a href="{{ route('perfillcli') }}" class="btn btn-secondary">
                        <i class='bx bx-arrow-back'></i> Cancelar
                    </a>
                @endif
                
                <a href="{{ route('perfil.delete') }}" class="btn btn-danger">
                    <i class='bx bx-trash'></i> Eliminar Cuenta
                </a>
            </div>
        </form>
    </div>
</body>
</html>
