<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detalle del Pago #{{ $pago->ID_Pagos }} - Technova</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <style>
        .payment-detail-container {
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

        .payment-info {
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
        .status-aprobado { background: #d4edda; color: #155724; }
        .status-rechazado { background: #f8d7da; color: #721c24; }
        .status-cancelado { background: #e2e3e5; color: #383d41; }

        .amount-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 25px;
            text-align: center;
        }

        .amount-label {
            font-size: 1.1rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .amount-value {
            font-size: 3rem;
            font-weight: 700;
            margin: 0;
        }

        .related-order {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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
            <div class="payment-detail-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">
                        <i class='bx bx-credit-card'></i>
                        Detalle del Pago #{{ $pago->ID_Pagos }}
                    </h1>
                    <p class="page-subtitle">Información completa del pago</p>
                </div>

                <!-- Amount Section -->
                <div class="amount-section">
                    <div class="amount-label">Monto del Pago</div>
                    <div class="amount-value">${{ number_format($pago->Monto, 0, ',', '.') }}</div>
                </div>

                <!-- Payment Information -->
                <div class="payment-info">
                    <h3 style="margin: 0 0 20px 0; color: #2c3e50;">Información del Pago</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">ID del Pago</div>
                            <div class="info-value">#{{ $pago->ID_Pagos }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Número de Factura</div>
                            <div class="info-value">{{ $pago->Numero_Factura ?? 'N/A' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Fecha del Pago</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($pago->Fecha_Pago)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Fecha de Factura</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($pago->Fecha_Factura)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Estado del Pago</div>
                            <div class="info-value">
                                <span class="status-badge status-{{ $pago->Estado_Pago }}">
                                    {{ ucfirst($pago->Estado_Pago) }}
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Monto</div>
                            <div class="info-value"><strong>${{ number_format($pago->Monto, 0, ',', '.') }}</strong></div>
                        </div>
                    </div>
                </div>

                <!-- Related Order -->
                @if($compra)
                <div class="related-order">
                    <h3 style="margin: 0 0 20px 0; color: #2c3e50;">Pedido Relacionado</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">ID del Pedido</div>
                            <div class="info-value">#{{ $compra->ID_Compras }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Cliente</div>
                            <div class="info-value">{{ $compra->user->name ?? 'Cliente' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Fecha del Pedido</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($compra->Fecha_De_Compra)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Estado del Pedido</div>
                            <div class="info-value">
                                <span class="status-badge status-{{ $compra->Estado }}">
                                    {{ ucfirst($compra->Estado) }}
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Total del Pedido</div>
                            <div class="info-value"><strong>${{ number_format($compra->Total, 0, ',', '.') }}</strong></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Medio de Pago</div>
                            <div class="info-value">{{ $compra->medioPago->Metodo_pago ?? 'No especificado' }}</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Back Button -->
                <a href="{{ route('admin.payments.index') }}" class="btn-back">
                    <i class='bx bx-arrow-back'></i>
                    Volver a Pagos
                </a>
            </div>
        </main>
    </div>
</body>
</html>
