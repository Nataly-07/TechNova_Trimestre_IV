<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $factura['id'] }} - Technova</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .factura-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .info-section {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 10px;
        }

        .info-section h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 5px;
        }

        .info-item {
            margin-bottom: 5px;
            display: table;
            width: 100%;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #666;
            width: 40%;
        }

        .info-value {
            display: table-cell;
            color: #333;
            width: 60%;
        }

        .estado-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
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

        .productos-section {
            margin-bottom: 20px;
        }

        .productos-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 14px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 5px;
        }

        .producto-item {
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 10px;
            background: #f9f9f9;
        }

        .producto-header {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .producto-details {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
        }

        .producto-precio {
            text-align: right;
            font-weight: bold;
            color: #667eea;
        }

        .resumen-section {
            background: #f8f9fa;
            padding: 15px;
            border-left: 5px solid #667eea;
            margin-bottom: 20px;
        }

        .resumen-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .resumen-item {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .resumen-label {
            display: table-cell;
            font-weight: bold;
            color: #666;
            width: 70%;
        }

        .resumen-value {
            display: table-cell;
            color: #333;
            text-align: right;
            width: 30%;
        }

        .total-item {
            border-top: 2px solid #667eea;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .total-value {
            color: #667eea;
            font-size: 16px;
        }

        .envio-section {
            margin-top: 20px;
        }

        .envio-section h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header de la factura -->
    <div class="header">
        <h1>FACTURA</h1>
        <p>Technova - Tecnología de Vanguardia</p>
    </div>

    <!-- Información de la factura y cliente -->
    <div class="factura-info">
        <div class="info-section">
            <h3>Información de la Factura</h3>
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
                <span class="info-value">
                    <span class="estado-badge {{ $factura['estado'] }}">
                        @if($factura['estado'] == 'entregado')
                            Entregado
                        @elseif($factura['estado'] == 'transito')
                            En tránsito
                        @elseif($factura['estado'] == 'preparacion')
                            En preparación
                        @elseif($factura['estado'] == 'cancelado')
                            Cancelado
                        @else
                            Pendiente
                        @endif
                    </span>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Método de Pago:</span>
                <span class="info-value">{{ $factura['metodo_pago'] }}</span>
            </div>
        </div>

        <div class="info-section">
            <h3>Información del Cliente</h3>
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
        <h3>Productos Comprados</h3>
        @foreach($factura['productos'] as $producto)
            <div class="producto-item">
                <div class="producto-header">{{ $producto['nombre'] }}</div>
                @if($producto['caracteristicas'])
                    <div class="producto-details">
                        {{ $producto['caracteristicas']->Marca ?? '' }} - {{ $producto['caracteristicas']->Color ?? '' }}
                    </div>
                @endif
                <div class="producto-details">Cantidad: {{ $producto['cantidad'] }} | Precio unitario: ${{ number_format($producto['precio'], 0, ',', '.') }}</div>
                <div class="producto-precio">Subtotal: ${{ number_format($producto['subtotal'], 0, ',', '.') }}</div>
            </div>
        @endforeach
    </div>

    <!-- Resumen de la compra -->
    <div class="resumen-section">
        <h3>Resumen de la Compra</h3>
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
        <div class="envio-section">
            <h3>Información de Envío</h3>
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

    <!-- Footer -->
    <div class="footer">
        <p>Gracias por su compra en Technova</p>
        <p>Este documento es una factura electrónica válida</p>
        <p>Generado el {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
