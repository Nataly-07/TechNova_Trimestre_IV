<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Previa - Reporte de Ventas</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
            color: #333;
        }
        
        .preview-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--gradient-primary);
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: var(--gradient-primary);
            margin: 0 0 10px 0;
            font-size: 2.5em;
        }
        
        .header p {
            color: #666;
            margin: 0;
            font-size: 1.1em;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #e3f2fd, #f0f8ff);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid var(--gradient-primary);
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: var(--gradient-primary);
            margin: 0;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9em;
            margin: 5px 0 0 0;
        }
        
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background: var(--gradient-primary);
            color: white;
            font-weight: 600;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: 600;
        }
        
        .status-completada { background: #d4edda; color: #155724; }
        .status-pendiente { background: #fff3cd; color: #856404; }
        .status-procesando { background: #cce5ff; color: #004085; }
        .status-cancelada { background: #f8d7da; color: #721c24; }
        .status-cancelado { background: #f8d7da; color: #721c24; }
        
        .close-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }
        
        .close-btn:hover {
            background: #c82333;
        }
        
        .currency {
            font-weight: 600;
            color: #28a745;
        }
    </style>
</head>
<body>
    <button class="close-btn" onclick="window.close()">
        <i class="bx bx-x"></i> Cerrar
    </button>
    
    <div class="preview-container">
        <div class="header">
            <h1><i class="bx bx-chart-line"></i> Reporte de Ventas</h1>
            <p>Vista previa generada el {{ date('d/m/Y H:i') }}</p>
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
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ number_format($totalVentas) }}</div>
                <div class="stat-label">Total Ventas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">${{ number_format($ingresosTotales, 0, ',', '.') }}</div>
                <div class="stat-label">Ingresos Totales</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">${{ number_format($ventaPromedio, 0, ',', '.') }}</div>
                <div class="stat-label">Venta Promedio</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ number_format($productosVendidos) }}</div>
                <div class="stat-label">Productos Vendidos</div>
            </div>
        </div>
        
        <div class="table-container">
            <h3><i class="bx bx-list-ul"></i> Detalle de Ventas (Últimas {{ $ventas->count() }} registros)</h3>
            
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
                            <th>Cantidad</th>
                            <th>Precio Unit.</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas->take(50) as $venta)
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
                                        @case('completada') ✅ Completada @break
                                        @case('pendiente') ⏳ Pendiente @break
                                        @case('procesando') 🔄 Procesando @break
                                        @case('cancelada') ❌ Cancelada @break
                                        @case('cancelado') ❌ Cancelado @break
                                    @endswitch
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 40px; color: #666;">
                    <i class="bx bx-info-circle" style="font-size: 3em; margin-bottom: 10px;"></i>
                    <h3>No se encontraron ventas</h3>
                    <p>No hay ventas registradas en la base de datos que coincidan con los filtros seleccionados.</p>
                    <p><small>💡 <strong>Tip:</strong> Si no hay ventas directas, el sistema mostrará las compras de clientes como ventas alternativas.</small></p>
                </div>
            @endif
        </div>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; color: #666;">
            <p><i class="bx bx-info-circle"></i> Esta es una vista previa con datos reales de la base de datos.</p>
            <p><small>Los datos se obtienen de las tablas de ventas y compras registradas en el sistema.</small></p>
        </div>
    </div>
</body>
</html>
