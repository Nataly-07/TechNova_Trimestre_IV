<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $factura['id'] }} - Technova</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg, #87CEFA 0%, #87CEEB 50%, #B19CD9 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .factura-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .factura-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .factura-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .factura-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .factura-content {
            padding: 30px;
        }

        .factura-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .info-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3rem;
            border-bottom: 2px solid #667eea;
            padding-bottom: 8px;
        }

        .info-item {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }

        .info-label {
            font-weight: 600;
            color: #666;
        }

        .info-value {
            color: #333;
        }

        .productos-section {
            margin-bottom: 30px;
        }

        .productos-section h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.3rem;
            border-bottom: 2px solid #667eea;
            padding-bottom: 8px;
        }

        .producto-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 15px;
            background: #fafafa;
            transition: all 0.3s ease;
        }

        .producto-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .producto-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
            border: 2px solid #e0e0e0;
        }

        .producto-details {
            flex: 1;
        }

        .producto-nombre {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .producto-caracteristicas {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .producto-cantidad {
            color: #666;
            font-size: 0.9rem;
        }

        .producto-precio {
            text-align: right;
            min-width: 120px;
        }

        .precio-unitario {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .precio-subtotal {
            font-size: 1.2rem;
            font-weight: 700;
            color: #667eea;
        }

        .resumen-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            border-left: 5px solid #667eea;
        }

        .resumen-section h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .resumen-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
        }

        .resumen-label {
            font-weight: 600;
            color: #666;
        }

        .resumen-value {
            color: #333;
        }

        .total-item {
            border-top: 2px solid #667eea;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .total-value {
            color: #667eea;
            font-size: 1.5rem;
        }

        .factura-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-outline:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .estado-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .estado-badge.entregado {
            background: #d4edda;
            color: #155724;
        }

        .estado-badge.transito {
            background: #cce5ff;
            color: #004085;
        }

        .estado-badge.preparacion {
            background: #fff3cd;
            color: #856404;
        }

        .estado-badge.pendiente {
            background: #f8d7da;
            color: #721c24;
        }

        .estado-badge.cancelado {
            background: #f5c6cb;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .factura-info {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .producto-item {
                flex-direction: column;
                text-align: center;
            }

            .producto-img {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .producto-precio {
                text-align: center;
                margin-top: 10px;
            }

            .factura-actions {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .factura-container {
                box-shadow: none;
                border-radius: 0;
            }

            .factura-actions {
                display: none;
            }

            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="factura-container">
        <!-- Header de la factura -->
        <div class="factura-header">
            <h1><i class='bx bx-receipt'></i> FACTURA</h1>
            <p>Technova - Tecnología de Vanguardia</p>
        </div>

        <!-- Contenido de la factura -->
        <div class="factura-content">
            <!-- Información de la factura y cliente -->
            <div class="factura-info">
                <div class="info-section">
                    <h3><i class='bx bx-info-circle'></i> Información de la Factura</h3>
                    <div class="info-item">
                        <span class="info-label">Número de Factura:</span>
                        <span class="info-value">#{{ $factura['id'] }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Fecha de Compra:</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($factura['fecha'])->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Estado:</span>
                        <span class="estado-badge {{ $factura['estado'] }}">
                            @if($factura['estado'] == 'entregado')
                                <i class='bx bx-check-circle'></i>
                                Entregado
                            @elseif($factura['estado'] == 'transito')
                                <i class='bx bx-truck'></i>
                                En tránsito
                            @elseif($factura['estado'] == 'preparacion')
                                <i class='bx bx-time-five'></i>
                                En preparación
                            @elseif($factura['estado'] == 'cancelado')
                                <i class='bx bx-x-circle'></i>
                                Cancelado
                            @else
                                <i class='bx bx-time'></i>
                                Pendiente
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Método de Pago:</span>
                        <span class="info-value">{{ $factura['metodo_pago'] }}</span>
                    </div>
                </div>

                <div class="info-section">
                    <h3><i class='bx bx-user'></i> Información del Cliente</h3>
                    <div class="info-item">
                        <span class="info-label">Nombre:</span>
                        <span class="info-value">{{ $factura['cliente']['nombre'] }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $factura['cliente']['email'] }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Documento:</span>
                        <span class="info-value">{{ $factura['cliente']['documento'] }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value">{{ $factura['cliente']['telefono'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Productos comprados -->
            <div class="productos-section">
                <h3><i class='bx bx-package'></i> Productos Comprados</h3>
                @foreach($factura['productos'] as $producto)
                    <div class="producto-item">
                        @php
                            $imgSrc = $producto['imagen'];
                            if (!$imgSrc) {
                                $imgSrc = asset('frontend/imagenes/foto perfil.webp');
                            } elseif (!preg_match('/^https?:\/\//', $imgSrc)) {
                                $imgSrc = asset('frontend/imagenes/' . $imgSrc);
                            }
                        @endphp
                        <img src="{{ $imgSrc }}" alt="{{ $producto['nombre'] }}" class="producto-img">
                        <div class="producto-details">
                            <div class="producto-nombre">{{ $producto['nombre'] }}</div>
                            @if($producto['caracteristicas'])
                                <div class="producto-caracteristicas">
                                    {{ $producto['caracteristicas']->Marca ?? '' }} - {{ $producto['caracteristicas']->Color ?? '' }}
                                </div>
                            @endif
                            <div class="producto-cantidad">Cantidad: {{ $producto['cantidad'] }}</div>
                        </div>
                        <div class="producto-precio">
                            <div class="precio-original" style="text-decoration: line-through; color: #999; font-size: 0.9rem; margin-bottom: 4px;">
                                Antes: ${{ number_format($producto['precio'] * 1.05, 0, ',', '.') }} c/u
                            </div>
                            <div class="precio-unitario" style="color: #27ae60; font-weight: bold;">
                                ${{ number_format($producto['precio'], 0, ',', '.') }} c/u
                                <span class="descuento" style="background-color: #cce5cc; color: #006600; padding: 2px 6px; border-radius: 6px; font-size: 0.8rem; margin-left: 6px;">-5%</span>
                            </div>
                            <div class="precio-subtotal" style="color: #27ae60; font-weight: bold; margin-top: 4px;">
                                Subtotal: ${{ number_format($producto['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Resumen de la compra -->
            <div class="resumen-section">
                <h3><i class='bx bx-calculator'></i> Resumen de la Compra</h3>
                <div class="resumen-item">
                    <span class="resumen-label">Subtotal:</span>
                    <span class="resumen-value">${{ number_format($factura['total'], 0, ',', '.') }}</span>
                </div>
                <div class="resumen-item">
                    <span class="resumen-label">Envío:</span>
                    <span class="resumen-value">Gratis</span>
                </div>
                <div class="resumen-item">
                    <span class="resumen-label">IVA (19%):</span>
                    <span class="resumen-value">${{ number_format($factura['total'] * 0.19, 0, ',', '.') }}</span>
                </div>
                <div class="resumen-item total-item">
                    <span class="resumen-label">Total:</span>
                    <span class="resumen-value total-value">${{ number_format($factura['total'] * 1.19, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Información de envío -->
            @if($factura['estado'] != 'cancelado')
                <div class="info-section" style="margin-top: 30px;">
                    <h3><i class='bx bx-truck'></i> Información de Envío</h3>
                    <div class="info-item">
                        <span class="info-label">Dirección de Entrega:</span>
                        <span class="info-value">{{ $factura['direccion'] }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Transportadora:</span>
                        <span class="info-value">{{ $factura['transportadora'] }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Número de Guía:</span>
                        <span class="info-value">{{ $factura['numero_guia'] }}</span>
                    </div>
                </div>
            @endif

            <!-- Acciones -->
            <div class="factura-actions">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class='bx bx-printer'></i> Imprimir Factura
                </button>
                <a href="{{ route('pedidoscli') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Volver a Pedidos
                </a>
                <a href="{{ route('pedidoscli.factura.pdf', $factura['id']) }}" class="btn btn-outline">
                    <i class='bx bx-download'></i> Descargar PDF
                </a>
            </div>
        </div>
    </div>

    <script>
        // Auto-print si se accede con parámetro ?print=1
        if (window.location.search.includes('print=1')) {
            window.print();
        }
    </script>
</body>
</html>
