<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Usuarios - Technova</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #00d4ff;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #00d4ff !important;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .filtros-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #00d4ff;
        }

        .filtros-info h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 14px;
        }

        .filtros-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .filtro-item {
            font-size: 11px;
        }

        .filtro-item strong {
            color: #00d4ff !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: linear-gradient(135deg, #00d4ff, #8b5cf6) !important;
            color: white !important;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e3f2fd;
        }

        .rol-admin {
            background: #ff4757;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        .rol-empleado {
            background: #ffa502;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        .rol-cliente {
            background: #2ed573;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        .estado-activo {
            color: #2ed573;
            font-weight: bold;
        }

        .estado-inactivo {
            color: #ff4757;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }

        .resumen {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .resumen h3 {
            margin: 0 0 10px 0;
            color: #00d4ff;
            font-size: 14px;
        }

        .resumen-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .resumen-item {
            text-align: center;
        }

        .resumen-item .numero {
            font-size: 18px;
            font-weight: bold;
            color: #00d4ff;
        }

        .resumen-item .label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE USUARIOS</h1>
        <p>Technova - Sistema de Gestión</p>
        <p>Generado el: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    @if($request->hasAny(['rol', 'busqueda', 'fecha_desde', 'fecha_hasta']))
    <div class="filtros-info">
        <h3>Filtros Aplicados:</h3>
        <div class="filtros-grid">
            @if($request->rol)
                <div class="filtro-item"><strong>Rol:</strong> {{ ucfirst($request->rol) }}</div>
            @endif
            @if($request->busqueda)
                <div class="filtro-item"><strong>Búsqueda:</strong> {{ $request->busqueda }}</div>
            @endif
            @if($request->fecha_desde)
                <div class="filtro-item"><strong>Desde:</strong> {{ date('d/m/Y', strtotime($request->fecha_desde)) }}</div>
            @endif
            @if($request->fecha_hasta)
                <div class="filtro-item"><strong>Hasta:</strong> {{ date('d/m/Y', strtotime($request->fecha_hasta)) }}</div>
            @endif
        </div>
    </div>
    @endif

    <div class="resumen">
        <h3>Resumen del Reporte</h3>
        <div class="resumen-grid">
            <div class="resumen-item">
                <div class="numero">{{ $usuarios->count() }}</div>
                <div class="label">Total Usuarios</div>
            </div>
            <div class="resumen-item">
                <div class="numero">{{ $usuarios->where('role', 'admin')->count() }}</div>
                <div class="label">Administradores</div>
            </div>
            <div class="resumen-item">
                <div class="numero">{{ $usuarios->where('role', 'empleado')->count() }}</div>
                <div class="label">Empleados</div>
            </div>
            <div class="resumen-item">
                <div class="numero">{{ $usuarios->where('role', 'cliente')->count() }}</div>
                <div class="label">Clientes</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Documento</th>
                <th>Rol</th>
                <th>Fecha Registro</th>
                <th>Último Acceso</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->phone ?? 'N/A' }}</td>
                <td>{{ $usuario->document_number ?? 'N/A' }}</td>
                <td>
                    @if($usuario->role == 'admin')
                        <span class="rol-admin">Admin</span>
                    @elseif($usuario->role == 'empleado')
                        <span class="rol-empleado">Empleado</span>
                    @else
                        <span class="rol-cliente">Cliente</span>
                    @endif
                </td>
                <td>{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px; color: #666;">
                    No se encontraron usuarios con los filtros aplicados
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Reporte generado automáticamente por el Sistema Technova</p>
        <p>Página 1 de 1 - {{ $usuarios->count() }} registros</p>
    </div>
</body>
</html>
