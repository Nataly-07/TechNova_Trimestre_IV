<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Pagos - Technova</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <style>
        .payments-container {
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

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
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

        .payments-table {
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
        .status-aprobado { background: #d4edda; color: #155724; }
        .status-rechazado { background: #f8d7da; color: #721c24; }
        .status-cancelado { background: #e2e3e5; color: #383d41; }

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
            <div class="payments-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">
                        <i class='bx bx-credit-card'></i>
                        Gestión de Pagos
                    </h1>
                    <p class="page-subtitle">Administra todos los pagos realizados por los clientes</p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-cards">
                    <div class="stat-card">
                        <div class="stat-value">{{ $total_pagos }}</div>
                        <div class="stat-label">Total Pagos</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ $pagos_pendientes }}</div>
                        <div class="stat-label">Pendientes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">${{ number_format($total_monto, 0, ',', '.') }}</div>
                        <div class="stat-label">Total Recaudado</div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filters-card">
                    <form method="GET" action="{{ route('admin.payments.index') }}">
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
                                <label for="monto_min">Monto Mínimo</label>
                                <input type="number" name="monto_min" id="monto_min" placeholder="0" value="{{ request('monto_min') }}">
                            </div>

                            <div class="form-group">
                                <label for="monto_max">Monto Máximo</label>
                                <input type="number" name="monto_max" id="monto_max" placeholder="999999" value="{{ request('monto_max') }}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn-filter">
                                    <i class='bx bx-search'></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Payments Table -->
                <div class="payments-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Pago</th>
                                <th>Número Factura</th>
                                <th>Fecha Pago</th>
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pagos as $pago)
                                <tr>
                                    <td><strong>#{{ $pago->ID_Pagos }}</strong></td>
                                    <td>{{ $pago->Numero_Factura ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pago->Fecha_Pago)->format('d/m/Y H:i') }}</td>
                                    <td><strong>${{ number_format($pago->Monto, 0, ',', '.') }}</strong></td>
                                    <td>
                                        <span class="status-badge status-{{ $pago->Estado_Pago }}">
                                            {{ ucfirst($pago->Estado_Pago) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.payments.show', $pago->ID_Pagos) }}" class="btn-action btn-view">
                                            <i class='bx bx-show'></i> Ver
                                        </a>
                                        <button onclick="updateStatus({{ $pago->ID_Pagos }}, '{{ $pago->Estado_Pago }}')" class="btn-action btn-edit">
                                            <i class='bx bx-edit'></i> Estado
                                        </button>
                                        <button onclick="deletePayment({{ $pago->ID_Pagos }})" class="btn-action btn-delete">
                                            <i class='bx bx-trash'></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px; color: #6c757d;">
                                        <i class='bx bx-credit-card' style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                                        No se encontraron pagos
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($pagos->hasPages())
                    <nav class="pagination" aria-label="Paginación">
                        @php
                            $current = $pagos->currentPage();
                            $last = $pagos->lastPage();
                            $range = range(max(1, $current - 1), min($last, $current + 1));
                        @endphp

                        {{-- Prev --}}
                        @if($pagos->onFirstPage())
                            <span class="disabled" style="padding:8px 12px;border:1px solid #e9ecef;border-radius:6px;color:#adb5bd;">&laquo;</span>
                        @else
                            <a href="{{ $pagos->previousPageUrl() }}" style="padding:8px 12px;border:1px solid #e9ecef;border-radius:6px;color:#667eea;text-decoration:none;">&laquo;</a>
                        @endif

                        {{-- First --}}
                        @if(!in_array(1, $range))
                            <a href="{{ $pagos->url(1) }}" style="padding:8px 12px;border:1px solid #e9ecef;border-radius:6px;color:#667eea;text-decoration:none;margin-left:5px;">1</a>
                            @if($range[0] > 2)
                                <span style="margin:0 6px;color:#adb5bd;">…</span>
                            @endif
                        @endif

                        {{-- Range --}}
                        @foreach($range as $page)
                            @if($page == $current)
                                <span class="active" style="padding:8px 12px;border:1px solid #667eea;border-radius:6px;background:#667eea;color:#fff;margin-left:5px;">{{ $page }}</span>
                            @else
                                <a href="{{ $pagos->url($page) }}" style="padding:8px 12px;border:1px solid #e9ecef;border-radius:6px;color:#667eea;text-decoration:none;margin-left:5px;">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Last --}}
                        @if(!in_array($last, $range))
                            @if($range[count($range)-1] < $last - 1)
                                <span style="margin:0 6px;color:#adb5bd;">…</span>
                            @endif
                            <a href="{{ $pagos->url($last) }}" style="padding:8px 12px;border:1px solid #e9ecef;border-radius:6px;color:#667eea;text-decoration:none;margin-left:5px;">{{ $last }}</a>
                        @endif

                        {{-- Next --}}
                        @if($pagos->hasMorePages())
                            <a href="{{ $pagos->nextPageUrl() }}" style="padding:8px 12px;border:1px solid #e9ecef;border-radius:6px;color:#667eea;text-decoration:none;margin-left:5px;">&raquo;</a>
                        @else
                            <span class="disabled" style="padding:8px 12px;border:1px solid #e9ecef;border-radius:6px;color:#adb5bd;margin-left:5px;">&raquo;</span>
                        @endif
                    </nav>
                @endif
            </div>
        </main>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 15px; min-width: 400px;">
            <h3 style="margin: 0 0 20px 0;">Actualizar Estado del Pago</h3>
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
        let currentPaymentId = null;

        function updateStatus(paymentId, currentStatus) {
            currentPaymentId = paymentId;
            document.getElementById('new_status').value = currentStatus;
            document.getElementById('statusModal').style.display = 'block';
        }

        function closeStatusModal() {
            document.getElementById('statusModal').style.display = 'none';
            currentPaymentId = null;
        }

        document.getElementById('statusForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            
            fetch(`/admin/payments/${currentPaymentId}/status`, {
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

        function deletePayment(paymentId) {
            if (confirm('¿Estás seguro de que quieres eliminar este pago?')) {
                fetch(`/admin/payments/${paymentId}`, {
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
                        alert('Error al eliminar el pago');
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
