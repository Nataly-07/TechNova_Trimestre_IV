<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Previa - Reporte de Ventas</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        .preview-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .preview-header {
            background: var(--gradient-primary);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .preview-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .preview-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .filtros-applied {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .filtros-applied h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 16px;
        }

        .filtros-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }

        .filtro-item {
            font-size: 14px;
            color: #333 !important;
        }

        .filtro-item strong {
            color: #00d4ff !important;
        }

        .resumen {
            background: #e3f2fd;
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .resumen h3 {
            margin: 0 0 15px 0;
            color: #00d4ff !important;
            font-size: 18px;
        }

        .resumen-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .resumen-item {
            text-align: center;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .resumen-item .numero {
            font-size: 24px;
            font-weight: bold;
            color: #00d4ff !important;
        }

        .resumen-item .label {
            font-size: 12px;
            color: #333 !important;
            margin-top: 5px;
        }

        .table-container {
            overflow-x: auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: linear-gradient(135deg, #00d4ff, #8b5cf6) !important;
            color: white !important;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 11px;
            color: #333 !important;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e3f2fd;
        }

        .currency {
            font-weight: bold;
            color: #00d4ff !important;
        }

        .status-badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .status-completada {
            background: #2ed573;
            color: white;
        }

        .status-pendiente {
            background: #ffa502;
            color: white;
        }

        .status-procesando {
            background: #3742fa;
            color: white;
        }

        .status-cancelada {
            background: #ff4757;
            color: white;
        }

        .status-cancelado {
            background: #ff4757;
            color: white;
        }

        .actions {
            padding: 20px;
            text-align: center;
            background: #f8f9fa;
            border-top: 1px solid #e0e0e0;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 10px;
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
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="preview-container">
        <div class="preview-header">
            <h1><i class="bx bx-chart-line"></i> Vista Previa - Reporte de Ventas</h1>
            <p>Technova - Sistema de Ventas</p>
        </div>

        @if($request->hasAny(['categoria', 'marca', 'estado', 'fecha_desde', 'fecha_hasta', 'monto_min']))
        <div class="filtros-applied">
            <h3>Filtros Aplicados:</h3>
            <div class="filtros-grid">
                @if($request->categoria)
                    <div class="filtro-item"><strong>Categoría:</strong> {{ $request->categoria }}</div>
                @endif
                @if($request->marca)
                    <div class="filtro-item"><strong>Marca:</strong> {{ $request->marca }}</div>
                @endif
                @if($request->estado)
                    <div class="filtro-item"><strong>Estado:</strong> {{ ucfirst($request->estado) }}</div>
                @endif
                @if($request->fecha_desde)
                    <div class="filtro-item"><strong>Desde:</strong> {{ date('d/m/Y', strtotime($request->fecha_desde)) }}</div>
                @endif
                @if($request->fecha_hasta)
                    <div class="filtro-item"><strong>Hasta:</strong> {{ date('d/m/Y', strtotime($request->fecha_hasta)) }}</div>
                @endif
                @if($request->monto_min)
                    <div class="filtro-item"><strong>Monto Mín:</strong> ${{ number_format($request->monto_min, 0, ',', '.') }}</div>
                @endif
            </div>
        </div>
        @endif
        
        <div class="resumen">
            <h3>Resumen del Reporte</h3>
            <div class="resumen-grid">
                <div class="resumen-item">
                    <div class="numero">{{ $ventas->count() }}</div>
                    <div class="label">Total Ventas</div>
                </div>
                <div class="resumen-item">
                    <div class="numero">${{ number_format($ventas->sum('total'), 0, ',', '.') }}</div>
                    <div class="label">Ingresos Totales</div>
                </div>
                <div class="resumen-item">
                    <div class="numero">${{ number_format($ventas->avg('total'), 0, ',', '.') }}</div>
                    <div class="label">Venta Promedio</div>
                </div>
                <div class="resumen-item">
                    <div class="numero">{{ $ventas->sum('cantidad') }}</div>
                    <div class="label">Productos Vendidos</div>
                </div>
            </div>
        </div>

        <div class="table-container">
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $venta)
                    <tr>
                        <td>#{{ $venta->id }}</td>
                        <td>{{ date('d/m/Y', strtotime($venta->fecha)) }}</td>
                        <td>{{ $venta->producto_nombre }}</td>
                        <td>{{ $venta->categoria }}</td>
                        <td>{{ $venta->marca }}</td>
                        <td>{{ $venta->cliente }}</td>
                        <td>{{ $venta->cantidad }}</td>
                        <td class="currency">${{ number_format($venta->precio_unitario, 0, ',', '.') }}</td>
                        <td class="currency">${{ number_format($venta->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge status-{{ $venta->estado }}">
                                @switch($venta->estado)
                                    @case('completada') Completada @break
                                    @case('pendiente') Pendiente @break
                                    @case('procesando') Procesando @break
                                    @case('cancelada') Cancelada @break
                                    @case('cancelado') Cancelado @break
                                @endswitch
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 20px; color: #666;">
                            No se encontraron ventas con los filtros aplicados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="actions">
            <a href="{{ route('reportes.ventas') }}?{{ $request->getQueryString() }}" class="btn btn-primary">
                <i class="bx bx-download"></i>
                Generar PDF
            </a>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="bx bx-x"></i>
                Cerrar
            </button>
        </div>
    </div>
</body>
</html>
