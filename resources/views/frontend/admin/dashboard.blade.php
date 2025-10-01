<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Administrador - Technova</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-container {
            padding: 25px;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .welcome-section h1 {
            margin: 0 0 10px 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .welcome-section p {
            margin: 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 4px solid;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .stat-card.primary { border-left-color: #667eea; }
        .stat-card.success { border-left-color: #28a745; }
        .stat-card.warning { border-left-color: #ffc107; }
        .stat-card.danger { border-left-color: #dc3545; }
        .stat-card.info { border-left-color: #17a2b8; }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-title {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .stat-icon.primary { background: #667eea; }
        .stat-icon.success { background: #28a745; }
        .stat-icon.warning { background: #ffc107; }
        .stat-icon.danger { background: #dc3545; }
        .stat-icon.info { background: #17a2b8; }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-change {
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-change.positive { color: #28a745; }
        .stat-change.negative { color: #dc3545; }

        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .chart-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-title i {
            color: #667eea;
        }

        .chart-container {
            position: relative;
            height: 350px;
            max-height: 350px;
            width: 100%;
        }

        .chart-container canvas {
            max-height: 100%;
        }

        .recent-activity {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .activity-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .activity-title i {
            color: #667eea;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
            color: white;
        }

        .activity-icon.blue { background: #667eea; }
        .activity-icon.green { background: #28a745; }
        .activity-icon.orange { background: #ffc107; }
        .activity-icon.red { background: #dc3545; }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .action-btn {
            background: white;
            border: 2px solid #e9ecef;
            padding: 20px;
            border-radius: 10px;
            text-decoration: none;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .action-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .action-text {
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .chart-container {
                height: 300px;
                max-height: 300px;
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
            <a href="{{ route('perfilad') }}" class="account">
                <i class='bx bx-user-circle'></i> 
                <span>Perfil</span>
            </a>
            <a href="/logout" class="account">
                <i class='bx bx-log-out'></i> 
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </header>

    <div class="dashboard-wrapper">
        @include('frontend.layouts.sidebar-admin')

        <main class="main-content">
            <div class="dashboard-container">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h1><i class='bx bx-tachometer'></i> Dashboard Administrador</h1>
                    <p>Bienvenido, {{ auth()->user()->name ?? 'Administrador' }}. Aquí tienes un resumen completo del estado de tu sistema.</p>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-header">
                            <div class="stat-title">Total Usuarios</div>
                            <div class="stat-icon primary">
                                <i class='bx bx-user'></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ number_format($stats['total_usuarios']) }}</div>
                        <div class="stat-change positive">
                            <i class='bx bx-trending-up'></i>
                            {{ $stats['total_clientes'] }} clientes, {{ $stats['total_empleados'] }} empleados
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-header">
                            <div class="stat-title">Ventas del Mes</div>
                            <div class="stat-icon success">
                                <i class='bx bx-trending-up'></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $ventas_stats['ventas_mes_actual'] }}</div>
                        <div class="stat-change {{ $ventas_stats['ventas_mes_actual'] > $ventas_stats['ventas_mes_anterior'] ? 'positive' : 'negative' }}">
                            <i class='bx bx-{{ $ventas_stats['ventas_mes_actual'] > $ventas_stats['ventas_mes_anterior'] ? 'trending-up' : 'trending-down' }}'></i>
                            vs {{ $ventas_stats['ventas_mes_anterior'] }} mes anterior
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-header">
                            <div class="stat-title">Pedidos Pendientes</div>
                            <div class="stat-icon warning">
                                <i class='bx bx-time'></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $compras_stats['compras_pendientes'] }}</div>
                        <div class="stat-change">
                            <i class='bx bx-info-circle'></i>
                            Requieren atención
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-header">
                            <div class="stat-title">Total Productos</div>
                            <div class="stat-icon info">
                                <i class='bx bx-package'></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ number_format($stats['total_productos']) }}</div>
                        <div class="stat-change">
                            <i class='bx bx-info-circle'></i>
                            En inventario
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <a href="{{ route('admin.orders.index') }}" class="action-btn">
                        <div class="action-icon">
                            <i class='bx bx-cart'></i>
                        </div>
                        <div class="action-text">Gestionar Pedidos</div>
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="action-btn">
                        <div class="action-icon">
                            <i class='bx bx-credit-card'></i>
                        </div>
                        <div class="action-text">Ver Pagos</div>
                    </a>
                    <a href="{{ route('usuarios.index') }}" class="action-btn">
                        <div class="action-icon">
                            <i class='bx bx-user'></i>
                        </div>
                        <div class="action-text">Gestionar Usuarios</div>
                    </a>
                    <a href="{{ route('productos.index') }}" class="action-btn">
                        <div class="action-icon">
                            <i class='bx bx-package'></i>
                        </div>
                        <div class="action-text">Inventario</div>
                    </a>
                </div>

                <!-- Charts Grid -->
                <div class="charts-grid">
                    <div class="chart-card">
                        <div class="chart-title">
                            <i class='bx bx-bar-chart'></i>
                            Ventas y Compras Mensuales
                        </div>
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-title">
                            <i class='bx bx-pie-chart'></i>
                            Productos Más Vendidos
                        </div>
                        <div class="chart-container">
                            <canvas id="productsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="recent-activity">
                    <div class="activity-title">
                        <i class='bx bx-time-five'></i>
                        Actividad Reciente
                    </div>

                    @if($pedidos_recientes->count() > 0)
                        @foreach($pedidos_recientes->take(5) as $pedido)
                            <div class="activity-item">
                                <div class="activity-icon blue">
                                    <i class='bx bx-cart'></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">
                                        Nuevo pedido #{{ $pedido->ID_Compras }} de {{ $pedido->user->name ?? 'Cliente' }}
                                    </div>
                                    <div class="activity-time">
                                        {{ \Carbon\Carbon::parse($pedido->Fecha_De_Compra)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if($mensajes_recientes->count() > 0)
                        @foreach($mensajes_recientes->take(3) as $mensaje)
                            <div class="activity-item">
                                <div class="activity-icon green">
                                    <i class='bx bx-message'></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">
                                        Mensaje: {{ Str::limit($mensaje->asunto, 50) }}
                                    </div>
                                    <div class="activity-time">
                                        {{ $mensaje->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        // Gráfico de Ventas y Compras
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesData = @json($grafico_ventas_mensual);
        
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesData.map(item => item.mes),
                datasets: [{
                    label: 'Ventas',
                    data: salesData.map(item => item.ventas),
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Compras',
                    data: salesData.map(item => item.compras),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Productos Más Vendidos
        const productsCtx = document.getElementById('productsChart').getContext('2d');
        const productsData = @json($grafico_productos_mas_vendidos);
        
        new Chart(productsCtx, {
            type: 'doughnut',
            data: {
                labels: productsData.map(item => item.Nombre_Producto),
                datasets: [{
                    data: productsData.map(item => item.total_vendido),
                    backgroundColor: [
                        '#667eea',
                        '#28a745',
                        '#ffc107',
                        '#dc3545',
                        '#17a2b8',
                        '#6f42c1',
                        '#fd7e14',
                        '#20c997'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
</body>
</html>
