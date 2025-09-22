<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Ventas - Technova</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            color: var(--gradient-primary);
            font-size: 2.5em;
            margin: 0;
        }
        
        .close-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .close-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .stat-icon {
            font-size: 2.5em;
            margin-right: 15px;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 1.1em;
            font-weight: 500;
        }
        
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .chart-title {
            color: #333;
            font-size: 1.5em;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .table-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
        }
        
        .table-responsive {
            overflow-x: auto;
            margin-top: 15px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
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
            border-radius: 8px 8px 0 0;
        }
        
        tr:hover {
            background: rgba(0, 212, 255, 0.05);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
        }
        
        .status-completada { background: #d4edda; color: #155724; }
        .status-pendiente { background: #fff3cd; color: #856404; }
        .status-procesando { background: #cce5ff; color: #004085; }
        .status-cancelada { background: #f8d7da; color: #721c24; }
        
        .currency {
            font-weight: 600;
            color: #28a745;
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .stat-card {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <div>
                <h1><i class="bx bx-bar-chart-alt-2"></i> Dashboard de Ventas</h1>
                <p style="color: #666; margin: 10px 0 0 0;">Análisis interactivo en tiempo real</p>
            </div>
            <button class="close-btn" onclick="window.close()">
                <i class="bx bx-x"></i> Cerrar Dashboard
            </button>
        </div>

        <!-- Estadísticas Principales -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <i class="bx bx-shopping-cart stat-icon"></i>
                </div>
                <div class="stat-number">{{ number_format($estadisticas['total_ventas']) }}</div>
                <div class="stat-label">Total de Ventas</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="bx bx-dollar stat-icon"></i>
                </div>
                <div class="stat-number">${{ number_format($estadisticas['ingresos_totales'], 0, ',', '.') }}</div>
                <div class="stat-label">Ingresos Totales</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="bx bx-trending-up stat-icon"></i>
                </div>
                <div class="stat-number">${{ number_format($estadisticas['venta_promedio'], 0, ',', '.') }}</div>
                <div class="stat-label">Venta Promedio</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="bx bx-package stat-icon"></i>
                </div>
                <div class="stat-number">{{ number_format($estadisticas['productos_vendidos']) }}</div>
                <div class="stat-label">Productos Vendidos</div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="charts-grid">
            <div class="chart-card">
                <div class="chart-title">
                    <i class="bx bx-pie-chart-alt-2"></i>
                    Ventas por Estado
                </div>
                <canvas id="estadosChart" width="400" height="300"></canvas>
            </div>
            
            <div class="chart-card">
                <div class="chart-title">
                    <i class="bx bx-bar-chart-alt"></i>
                    Ingresos por Categoría
                </div>
                <canvas id="categoriasChart" width="400" height="300"></canvas>
            </div>
        </div>

        <!-- Top Productos -->
        <div class="table-card">
            <div class="chart-title">
                <i class="bx bx-trophy"></i>
                Top 5 Productos Más Vendidos
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Posición</th>
                            <th>Producto</th>
                            <th>Cantidad Vendida</th>
                            <th>Ingresos</th>
                            <th>Participación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $posicion = 1; @endphp
                        @foreach($estadisticas['top_productos'] as $producto => $datos)
                        <tr>
                            <td>
                                @if($posicion == 1) 🥇
                                @elseif($posicion == 2) 🥈
                                @elseif($posicion == 3) 🥉
                                @else {{ $posicion }}º
                                @endif
                            </td>
                            <td><strong>{{ $producto }}</strong></td>
                            <td>{{ number_format($datos['cantidad']) }} unidades</td>
                            <td class="currency">${{ number_format($datos['ingresos'], 0, ',', '.') }}</td>
                            <td>{{ number_format(($datos['ingresos'] / $estadisticas['ingresos_totales']) * 100, 1) }}%</td>
                        </tr>
                        @php $posicion++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Últimas Ventas -->
        <div class="table-card">
            <div class="chart-title">
                <i class="bx bx-time"></i>
                Últimas Ventas Registradas
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cliente</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas->take(10) as $venta)
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($venta->fecha)) }}</td>
                            <td>{{ $venta->producto_nombre }}</td>
                            <td>{{ $venta->cliente }}</td>
                            <td>{{ $venta->cantidad }}</td>
                            <td class="currency">${{ number_format($venta->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-badge status-{{ $venta->estado }}">
                                    @switch($venta->estado)
                                        @case('completada') ✅ Completada @break
                                        @case('pendiente') ⏳ Pendiente @break
                                        @case('procesando') 🔄 Procesando @break
                                        @case('cancelada') ❌ Cancelada @break
                                    @endswitch
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Configuración de Chart.js
        Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
        Chart.defaults.color = '#333';

        // Gráfico de Estados
        const estadosCtx = document.getElementById('estadosChart').getContext('2d');
        const estadosData = @json($estadisticas['ventas_por_estado']);
        
        new Chart(estadosCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(estadosData).map(estado => {
                    const estados = {
                        'completada': '✅ Completada',
                        'pendiente': '⏳ Pendiente', 
                        'procesando': '🔄 Procesando',
                        'cancelada': '❌ Cancelada'
                    };
                    return estados[estado] || estado;
                }),
                datasets: [{
                    data: Object.values(estadosData),
                    backgroundColor: [
                        '#28a745',
                        '#ffc107', 
                        '#17a2b8',
                        '#dc3545'
                    ],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Gráfico de Categorías
        const categoriasCtx = document.getElementById('categoriasChart').getContext('2d');
        const categoriasData = @json($estadisticas['ventas_por_categoria']);
        
        new Chart(categoriasCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(categoriasData),
                datasets: [{
                    label: 'Ingresos ($)',
                    data: Object.values(categoriasData),
                    backgroundColor: 'rgba(7, 153, 182, 0.8)',
                    borderColor: 'rgba(7, 153, 182, 1)',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Actualización automática cada 30 segundos (simulada)
        setInterval(function() {
            const timestamp = new Date().toLocaleTimeString();
            document.title = `Dashboard de Ventas - Actualizado ${timestamp}`;
        }, 30000);
    </script>
</body>
</html>


