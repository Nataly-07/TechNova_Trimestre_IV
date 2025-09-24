<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Pedidos - Technova</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <style>
        .orders-container {
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

        .filters-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn-filter {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .btn-filter:hover {
            background: #5a67d8;
        }

        .orders-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #e9ecef;
        }

        .table td {
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-pendiente { background: #fff3cd; color: #856404; }
        .status-procesando { background: #d1ecf1; color: #0c5460; }
        .status-enviado { background: #d4edda; color: #155724; }
        .status-entregado { background: #cce5ff; color: #004085; }
        .status-cancelado { background: #f8d7da; color: #721c24; }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 500;
            margin-right: 5px;
            transition: all 0.3s ease;
        }

        .btn-view { background: #17a2b8; color: white; }
        .btn-edit { background: #ffc107; color: #212529; }
        .btn-delete { background: #dc3545; color: white; }

        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }

        .pagination a {
            padding: 8px 16px;
            margin: 0 5px;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            color: #667eea;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination a:hover,
        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
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
            <div class="orders-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">
                        <i class='bx bx-cart'></i>
                        Gestión de Pedidos
                    </h1>
                    <p class="page-subtitle">Administra todos los pedidos de los clientes</p>
                </div>

                <!-- Filters -->
                <div class="filters-card">
                    <form method="GET" action="{{ route('admin.orders.index') }}">
                        <div class="filters-grid">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select name="estado" id="estado">
                                    <option value="">Todos los estados</option>
                                    @foreach($estados as $estado)
                                        <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>
                                            {{ ucfirst($estado) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="fecha_desde">Fecha Desde</label>
                                <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}">
                            </div>

                            <div class="form-group">
                                <label for="fecha_hasta">Fecha Hasta</label>
                                <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}">
                            </div>

                            <div class="form-group">
                                <label for="cliente">Cliente</label>
                                <input type="text" name="cliente" id="cliente" placeholder="Nombre o email" value="{{ request('cliente') }}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn-filter">
                                    <i class='bx bx-search'></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Orders Table -->
                <div class="orders-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Pedido</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pedidos as $pedido)
                                <tr>
                                    <td><strong>#{{ $pedido->ID_Compras }}</strong></td>
                                    <td>
                                        <div>
                                            <strong>{{ $pedido->user->name ?? 'Cliente' }}</strong><br>
                                            <small>{{ $pedido->user->email ?? 'Sin email' }}</small>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($pedido->Fecha_De_Compra)->format('d/m/Y H:i') }}</td>
                                    <td><strong>${{ number_format($pedido->Total, 0, ',', '.') }}</strong></td>
                                    <td>
                                        <span class="status-badge status-{{ $pedido->Estado }}">
                                            {{ ucfirst($pedido->Estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $pedido->ID_Compras) }}" class="btn-action btn-view">
                                            <i class='bx bx-show'></i> Ver
                                        </a>
                                        <button onclick="updateStatus({{ $pedido->ID_Compras }}, '{{ $pedido->Estado }}')" class="btn-action btn-edit">
                                            <i class='bx bx-edit'></i> Estado
                                        </button>
                                        <button onclick="deleteOrder({{ $pedido->ID_Compras }})" class="btn-action btn-delete">
                                            <i class='bx bx-trash'></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px; color: #6c757d;">
                                        <i class='bx bx-cart' style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                                        No se encontraron pedidos
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($pedidos->hasPages())
                    <div class="pagination">
                        {{ $pedidos->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 15px; min-width: 400px;">
            <h3 style="margin: 0 0 20px 0;">Actualizar Estado del Pedido</h3>
            <form id="statusForm">
                @csrf
                <div class="form-group">
                    <label for="new_status">Nuevo Estado</label>
                    <select name="estado" id="new_status" required>
                        @foreach($estados as $estado)
                            <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" onclick="closeStatusModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer;">
                        Cancelar
                    </button>
                    <button type="submit" style="padding: 10px 20px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer;">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentOrderId = null;

        function updateStatus(orderId, currentStatus) {
            currentOrderId = orderId;
            document.getElementById('new_status').value = currentStatus;
            document.getElementById('statusModal').style.display = 'block';
        }

        function closeStatusModal() {
            document.getElementById('statusModal').style.display = 'none';
            currentOrderId = null;
        }

        document.getElementById('statusForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            
            fetch(`/admin/orders/${currentOrderId}/status`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al actualizar el estado');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión');
            });
        });

        function deleteOrder(orderId) {
            if (confirm('¿Estás seguro de que quieres eliminar este pedido?')) {
                fetch(`/admin/orders/${orderId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al eliminar el pedido');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error de conexión');
                });
            }
        }
    </script>
</body>
</html>
