<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - {{ date('d/m/Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0799b6;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #0799b6;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .stats-section {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            border-right: 1px solid #dee2e6;
            vertical-align: top;
        }
        
        .stat-item:last-child {
            border-right: none;
        }
        
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #0799b6;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 11px;
        }
        
        .filters-section {
            background: #e3f2fd;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .filters-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #0799b6;
        }
        
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        
        th {
            background-color: #0799b6;
            color: white;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .status-completada { background: #d4edda; color: #155724; padding: 2px 6px; border-radius: 3px; }
        .status-pendiente { background: #fff3cd; color: #856404; padding: 2px 6px; border-radius: 3px; }
        .status-procesando { background: #cce5ff; color: #004085; padding: 2px 6px; border-radius: 3px; }
        .status-cancelada { background: #f8d7da; color: #721c24; padding: 2px 6px; border-radius: 3px; }
        
        .currency {
            text-align: right;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .summary-section {
            background: #f8f9fa;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            border-left: 4px solid #0799b6;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 REPORTE DE VENTAS</h1>
        <p><strong>TECHNOVA</strong></p>
        <p>Generado el {{ date('d/m/Y H:i') }}</p>
        @if($request->filled('fecha_desde') || $request->filled('fecha_hasta'))
            <p><strong>Período:</strong> 
                {{ $request->fecha_desde ? date('d/m/Y', strtotime($request->fecha_desde)) : 'Inicio' }} - 
                {{ $request->fecha_hasta ? date('d/m/Y', strtotime($request->fecha_hasta)) : 'Fin' }}
            </p>
        @endif
    </div>

    @php
        $totalVentas = $ventas->count();
        $ingresosTotales = $ventas->sum('total');
        $ventaPromedio = $ventas->avg('total');
        $productosVendidos = $ventas->sum('cantidad');
    @endphp

    <!-- Sección de Estadísticas -->
    <div class="stats-section">
        <h3 style="margin-top: 0; color: #0799b6;">📈 Resumen Ejecutivo</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ number_format($totalVentas) }}</div>
                <div class="stat-label">Total Ventas</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">${{ number_format($ingresosTotales, 0, ',', '.') }}</div>
                <div class="stat-label">Ingresos Totales</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">${{ number_format($ventaPromedio, 0, ',', '.') }}</div>
                <div class="stat-label">Venta Promedio</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ number_format($productosVendidos) }}</div>
                <div class="stat-label">Productos Vendidos</div>
            </div>
        </div>
    </div>

    <!-- Sección de Filtros Aplicados -->
    @if($request->hasAny(['categoria', 'marca', 'estado', 'monto_min', 'tipo_reporte']))
    <div class="filters-section">
        <div class="filters-title">🔍 Filtros Aplicados:</div>
        @if($request->filled('tipo_reporte'))
            <span class="filter-item"><strong>Tipo:</strong> {{ ucfirst($request->tipo_reporte) }}</span>
        @endif
        @if($request->filled('categoria'))
            <span class="filter-item"><strong>Categoría:</strong> {{ $request->categoria }}</span>
        @endif
        @if($request->filled('marca'))
            <span class="filter-item"><strong>Marca:</strong> {{ $request->marca }}</span>
        @endif
        @if($request->filled('estado'))
            <span class="filter-item"><strong>Estado:</strong> {{ ucfirst($request->estado) }}</span>
        @endif
        @if($request->filled('monto_min'))
            <span class="filter-item"><strong>Monto mínimo:</strong> ${{ number_format($request->monto_min, 0, ',', '.') }}</span>
        @endif
    </div>
    @endif

    <!-- Detalle de Ventas -->
    <h3 style="color: #0799b6; margin-bottom: 10px;">📋 Detalle de Ventas</h3>
    
    @if($ventas->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Marca</th>
                    <th>Cliente</th>
                    <th>Cant.</th>
                    <th>P. Unit.</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr>
                    <td>#{{ $venta->id }}</td>
                    <td>{{ date('d/m/Y', strtotime($venta->fecha)) }}</td>
                    <td>{{ $venta->producto_nombre }}</td>
                    <td>{{ $venta->categoria }}</td>
                    <td>{{ $venta->marca }}</td>
                    <td>{{ $venta->cliente }}</td>
                    <td style="text-align: center;">{{ $venta->cantidad }}</td>
                    <td class="currency">${{ number_format($venta->precio_unitario, 0, ',', '.') }}</td>
                    <td class="currency">${{ number_format($venta->total, 0, ',', '.') }}</td>
                    <td>
                        <span class="status-{{ $venta->estado }}">
                            @switch($venta->estado)
                                @case('completada') Completada @break
                                @case('pendiente') Pendiente @break
                                @case('procesando') Procesando @break
                                @case('cancelada') Cancelada @break
                            @endswitch
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Resumen por Estado -->
        @php
            $ventasPorEstado = $ventas->groupBy('estado');
        @endphp
        
        @if($ventasPorEstado->count() > 1)
        <div class="summary-section page-break">
            <h3 style="margin-top: 0; color: #0799b6;">📊 Análisis por Estado</h3>
            <table style="width: 60%;">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Cantidad</th>
                        <th>Ingresos</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasPorEstado as $estado => $grupo)
                    <tr>
                        <td style="text-transform: capitalize;">{{ $estado }}</td>
                        <td style="text-align: center;">{{ $grupo->count() }}</td>
                        <td class="currency">${{ number_format($grupo->sum('total'), 0, ',', '.') }}</td>
                        <td style="text-align: center;">{{ number_format(($grupo->count() / $totalVentas) * 100, 1) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    @else
        <div class="no-data">
            <h3>ℹ️ Sin Datos</h3>
            <p>No se encontraron ventas que coincidan con los filtros seleccionados.</p>
        </div>
    @endif

    <div class="footer">
        <p><strong>TECHNOVA</strong> - Sistema de Reportes</p>
        <p>Reporte generado automáticamente el {{ date('d/m/Y H:i:s') }}</p>
        <p style="font-style: italic;">Datos obtenidos de la base de datos del sistema</p>
    </div>
</body>
</html>
