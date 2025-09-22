<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proveedor - Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; margin-top: 10px; }
        .success { color: #00d4ff; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Crear Proveedor - Debug</h1>
    
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    
    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('proveedores.debug.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="Identificacion">Identificación:</label>
            <input type="text" name="Identificacion" id="Identificacion" value="{{ old('Identificacion') }}" required>
        </div>
        
        <div class="form-group">
            <label for="Nombre">Nombre:</label>
            <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre') }}" required>
        </div>
        
        <div class="form-group">
            <label for="Telefono">Teléfono:</label>
            <input type="text" name="Telefono" id="Telefono" value="{{ old('Telefono') }}" required>
        </div>
        
        <div class="form-group">
            <label for="Correo">Correo:</label>
            <input type="email" name="Correo" id="Correo" value="{{ old('Correo') }}" required>
        </div>
        
        <div class="form-group">
            <label for="ID_producto">Producto (Opcional):</label>
            <select name="ID_producto" id="ID_producto">
                <option value="">Seleccionar Producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->ID_Producto }}" {{ old('ID_producto') == $producto->ID_Producto ? 'selected' : '' }}>
                        {{ $producto->Nombre }} ({{ $producto->Codigo }})
                    </option>
                @endforeach
            </select>
        </div>
        
        <button type="submit">Crear Proveedor</button>
    </form>
    
    <p><a href="{{ route('proveedores.debug') }}">Ver Lista de Proveedores</a></p>
</body>
</html>
