<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detalle del Pedido #{{ $pedido->ID_Compras }} - Technova</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <style>
        .order-detail-container {
            padding: 25px;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .page-header {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-subtitle {
            color: #6c757d;
            margin: 0;
        }

        .order-info {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .info-value {
            color: #6c757d;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-pendiente { background: #fff3cd; color: #856404; }
        .status-procesando { background: #d1ecf1; color: #0c5460; }
        .status-enviado { background: #d4edda; color: #155724; }
        .status-entregado { background: #cce5ff; color: #004085; }
        .status-cancelado { background: #f8d7da; color: #721c24; }

        .order-items {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #e9ecef;
        }

        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
        }

        .total-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: right;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .btn-back {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s ease;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
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
            <div class="order-detail-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">
                        <i class='bx bx-cart'></i>
                        Detalle del Pedido #{{ $pedido->ID_Compras }}
                    </h1>
                    <p class="page-subtitle">Información completa del pedido</p>
                </div>

                <!-- Order Information -->
                <div class="order-info">
                    <h3 style="margin: 0 0 20px 0; color: #2c3e50;">Información del Pedido</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">ID del Pedido</div>
                            <div class="info-value">#{{ $pedido->ID_Compras }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Cliente</div>
                            <div class="info-value">{{ $pedido->user->name ?? 'Cliente' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $pedido->user->email ?? 'Sin email' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Fecha de Compra</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($pedido->Fecha_De_Compra)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Estado</div>
                            <div class="info-value">
                                <span class="status-badge status-{{ $pedido->Estado }}">
                                    {{ ucfirst($pedido->Estado) }}
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Medio de Pago</div>
                            <div class="info-value">{{ $pedido->medioPago->Metodo_pago ?? 'No especificado' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tiempo de Entrega</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($pedido->Tiempo_De_Entrega)->format('d/m/Y') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Total</div>
                            <div class="info-value"><strong>${{ number_format($pedido->Total, 0, ',', '.') }}</strong></div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-items">
                    <h3 style="margin: 0 0 20px 0; color: #2c3e50;">Productos del Pedido</h3>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pedido->detalles as $detalle)
                                <tr>
                                    <td>
                                        <strong>{{ $detalle->producto->Nombre ?? 'Producto' }}</strong><br>
                                        <small>{{ $detalle->producto->Codigo ?? 'Sin código' }}</small>
                                    </td>
                                    <td>{{ $detalle->Cantidad }}</td>
                                    <td>${{ number_format($detalle->Precio, 0, ',', '.') }}</td>
                                    <td><strong>${{ number_format($detalle->Precio * $detalle->Cantidad, 0, ',', '.') }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 40px; color: #6c757d;">
                                        No se encontraron productos en este pedido
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="total-section">
                        <div class="total-amount">
                            Total: ${{ number_format($pedido->Total, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <a href="{{ route('admin.orders.index') }}" class="btn-back">
                    <i class='bx bx-arrow-back'></i>
                    Volver a Pedidos
                </a>
            </div>
        </main>
    </div>
</body>
</html>
