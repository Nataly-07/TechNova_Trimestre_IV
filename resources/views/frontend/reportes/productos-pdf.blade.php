<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Productos - Technova</title>
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

        .precio {
            font-weight: bold;
            color: #00d4ff !important;
        }

        .stock-bajo {
            color: #ff4757;
            font-weight: bold;
        }

        .stock-normal {
            color: #2ed573;
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
        <h1>REPORTE DE PRODUCTOS</h1>
        <p>Technova - Sistema de Inventario</p>
        <p>Generado el: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    @if($request->hasAny(['categoria', 'marca', 'precio_min', 'precio_max', 'stock_min']))
    <div class="filtros-info">
        <h3>Filtros Aplicados:</h3>
        <div class="filtros-grid">
            @if($request->categoria)
                <div class="filtro-item"><strong>Categoría:</strong> {{ $request->categoria }}</div>
            @endif
            @if($request->marca)
                <div class="filtro-item"><strong>Marca:</strong> {{ $request->marca }}</div>
            @endif
            @if($request->precio_min)
                <div class="filtro-item"><strong>Precio Mín:</strong> ${{ number_format($request->precio_min, 0, ',', '.') }}</div>
            @endif
            @if($request->precio_max)
                <div class="filtro-item"><strong>Precio Máx:</strong> ${{ number_format($request->precio_max, 0, ',', '.') }}</div>
            @endif
            @if($request->stock_min)
                <div class="filtro-item"><strong>Stock Mín:</strong> {{ $request->stock_min }}</div>
            @endif
        </div>
    </div>
    @endif

    <div class="resumen">
        <h3>Resumen del Reporte</h3>
        <div class="resumen-grid">
            <div class="resumen-item">
                <div class="numero">{{ $productos->count() }}</div>
                <div class="label">Total Productos</div>
            </div>
            <div class="resumen-item">
                <div class="numero">${{ number_format($productos->sum(function($p) { return $p->caracteristicas->Precio_Venta ?? 0; }), 0, ',', '.') }}</div>
                <div class="label">Valor Total</div>
            </div>
            <div class="resumen-item">
                <div class="numero">{{ $productos->sum('Stock') }}</div>
                <div class="label">Stock Total</div>
            </div>
            <div class="resumen-item">
                <div class="numero">{{ $productos->where('Stock', '<', 10)->count() }}</div>
                <div class="label">Stock Bajo</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Marca</th>
                <th>Precio Venta</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Stock</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
            <tr>
                <td>{{ $producto->Codigo }}</td>
                <td>{{ $producto->Nombre }}</td>
                <td>{{ $producto->caracteristicas->Categoria ?? '' }}</td>
                <td>{{ $producto->caracteristicas->Marca ?? '' }}</td>
                <td class="precio">${{ number_format($producto->caracteristicas->Precio_Venta ?? 0, 0, ',', '.') }}</td>
                <td>{{ $producto->Ingreso ?? 0 }}</td>
                <td>{{ $producto->Salida ?? 0 }}</td>
                <td class="{{ $producto->Stock < 10 ? 'stock-bajo' : 'stock-normal' }}">
                    {{ $producto->Stock }}
                </td>
                <td>
                    @if($producto->Stock < 10)
                        <span style="color: #ff4757;">Stock Bajo</span>
                    @elseif($producto->Stock == 0)
                        <span style="color: #ff4757;">Agotado</span>
                    @else
                        <span style="color: #2ed573;">Disponible</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; padding: 20px; color: #666;">
                    No se encontraron productos con los filtros aplicados
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Reporte generado automáticamente por el Sistema Technova</p>
        <p>Página 1 de 1 - {{ $productos->count() }} registros</p>
    </div>
</body>
</html>
