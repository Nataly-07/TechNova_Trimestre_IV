<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Eliminar Cuenta - Technova</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <style>
        .form-container {
            max-width: 500px;
            margin: 40px auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .warning-icon {
            font-size: 64px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #dc3545;
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
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
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
        .warning-text {
            color: #721c24;
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .info-text {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
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
        <div class="warning-icon">
            <i class='bx bx-error-circle'></i>
        </div>
        
        <h2 style="color: #dc3545; margin-bottom: 20px;">
            Eliminar Cuenta
        </h2>

        <div class="warning-text">
            ⚠️ Esta acción no se puede deshacer
        </div>

        <div class="info-text">
            Al eliminar tu cuenta, se perderán permanentemente todos tus datos, 
            historial de compras y configuraciones. Esta acción es irreversible.
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('perfil.destroy') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="form-group">
                <label for="password">Confirma tu contraseña para eliminar la cuenta *</label>
                <input type="password" id="password" name="password" required placeholder="Ingresa tu contraseña actual">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="btn-container">
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás completamente seguro de que quieres eliminar tu cuenta? Esta acción no se puede deshacer.')">
                    <i class='bx bx-trash'></i> Eliminar Cuenta Permanentemente
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
            </div>
        </form>
    </div>
</body>
</html>
