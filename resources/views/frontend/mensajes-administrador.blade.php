<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Mensajes del Administrador - Technova</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Estilos específicos para mensajes de empleados */
        .messages-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .messages-header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border: 1px solid #dee2e6;
        }

        .messages-actions {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-action {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
            border: 1px solid #007bff;
        }

        .btn-action:hover {
            background: #0056b3;
            border-color: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        .btn-action.secondary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
        }

        .btn-action.secondary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            border-color: #5a67d8;
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }

        /* Estilos para el modal de empleados */
        .employees-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 400px;
            overflow-y: auto;
        }

        .employee-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .employee-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
        }

        .employee-info {
            flex: 1;
        }

        .employee-name {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .employee-email {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .employee-stats {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 5px;
        }

        .message-count {
            background: #667eea;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .unread-count {
            background: #dc3545;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .last-message {
            color: #6c757d;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        /* Estadísticas compactas */
        .stats-container {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            justify-content: center;
            flex-wrap: wrap;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 12px 16px;
            text-align: center;
            border: 1px solid #dee2e6;
            min-width: 100px;
            flex: 1;
            max-width: 120px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-card.clickable {
            cursor: pointer;
        }

        .stat-card.clickable:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-color: #007bff;
        }

        .stat-card.active {
            background: #007bff;
            color: white;
            border-color: #0056b3;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .stat-card.active .stat-number {
            color: white;
        }

        .stat-card.active .stat-label {
            color: rgba(255, 255, 255, 0.9);
        }

        .stat-number {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
            display: block;
            line-height: 1;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.7rem;
            margin-top: 4px;
            line-height: 1.1;
            font-weight: 500;
        }

        /* Lista de mensajes */
        .messages-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px 0;
        }

        .message-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-left: 4px solid #007bff;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .message-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .message-item.unread {
            background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
            border-left-color: #2196f3;
        }

        .message-item.unread::before {
            content: '';
            position: absolute;
            top: 15px;
            right: 15px;
            width: 8px;
            height: 8px;
            background: #2196f3;
            border-radius: 50%;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .message-subject {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
            flex: 1;
        }

        .message-meta {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .type-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .type-general { background: #e2e3e5; color: #383d41; }
        .type-notificacion { background: #d1ecf1; color: #0c5460; }
        .type-instruccion { background: #d4edda; color: #155724; }
        .type-urgencia { background: #f8d7da; color: #721c24; }

        .priority-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .priority-baja { background: #d4edda; color: #155724; }
        .priority-normal { background: #d1ecf1; color: #0c5460; }
        .priority-alta { background: #fff3cd; color: #856404; }
        .priority-urgente { background: #f8d7da; color: #721c24; }

        .message-preview {
            color: #6c757d;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .message-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .message-sender {
            color: #495057;
            font-weight: 500;
        }

        .message-date {
            color: #adb5bd;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }

        .modal-title {
            font-size: 1.5rem;
            color: #333;
            font-weight: 600;
            flex: 1;
            margin-right: 20px;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6c757d;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: #f8f9fa;
            color: #333;
        }

        .modal-meta {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .modal-body {
            line-height: 1.6;
            color: #495057;
            margin-bottom: 25px;
            font-size: 1.1rem;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 2px solid #f8f9fa;
        }

        .modal-sender {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        /* Historial */
        .history-modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .history-modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .history-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            max-width: 800px;
            width: 95%;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: modalSlideIn 0.3s ease-out;
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }

        .history-title {
            font-size: 1.5rem;
            color: #333;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .history-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .history-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #6c757d;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .history-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .history-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .history-item-subject {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
        }

        .history-item-meta {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .history-item-preview {
            color: #6c757d;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .history-item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .history-item-sender {
            color: #495057;
            font-weight: 500;
        }

        .history-item-date {
            color: #adb5bd;
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }

        .detail-subject {
            font-size: 1.5rem;
            color: #333;
            font-weight: 600;
            flex: 1;
        }

        .detail-meta {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .detail-content {
            line-height: 1.6;
            color: #495057;
            margin-bottom: 25px;
            font-size: 1.1rem;
        }

        .detail-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 2px solid #f8f9fa;
        }

        .detail-sender {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .detail-actions {
            display: flex;
            gap: 10px;
        }

        .btn-mark-read {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-mark-read:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }

        /* Formulario de Respuesta */
        .reply-section {
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .reply-header {
            margin-bottom: 15px;
        }

        .reply-header h4 {
            color: #333;
            font-size: 1.1rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-family: inherit;
            font-size: 0.9rem;
            resize: vertical;
            transition: border-color 0.3s ease;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .char-count {
            text-align: right;
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        .btn-send {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-send:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
        }

        .btn-reply {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-reply:hover {
            background: linear-gradient(135deg, #138496 0%, #117a8b 100%);
            transform: translateY(-1px);
        }

        .btn-mark-read:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Estado vacío */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .empty-state h3 {
            margin-bottom: 10px;
            color: #495057;
            font-size: 1.5rem;
        }

        .empty-state p {
            font-size: 1.1rem;
            line-height: 1.5;
        }

        /* Alertas */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .messages-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .messages-actions {
                justify-content: center;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .message-header {
                flex-direction: column;
                gap: 10px;
            }

            .message-meta {
                justify-content: flex-start;
            }

            .detail-header {
                flex-direction: column;
                gap: 15px;
            }

            .detail-meta {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo" style="cursor: default;">
            <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo">
            <span>TECHNOVA</span>
        </div>

        <div class="acciones-usuario">
            <a href="{{ route('perfilemp') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
            <a href="/logout" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
        </div>
    </header>

    <div class="dashboard-wrapper">
        <div class="menu-dashboard">
            <div class="top-menu">
                <div class="logo">
                    <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
                    <span>Panel Administrador</span>
                </div>
                <div class="toggle">
                    <i class='bx bx-menu'></i>
                </div>
            </div>

            <div class="menu">
                <div class="enlace"><a href="{{ route('perfilad') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
                <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
                <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-shopping-bag'></i> Movimiento de Artículos</a></div>
                <div class="enlace"><a href="{{ route('reportes.index') }}"><i class='bx bx-bar-chart'></i> Reportes</a></div>
                <div class="enlace"><a href="{{ route('proveedores.index') }}"><i class='bx bx-store'></i> Proveedores</a></div>
                <div class="enlace active"><a href="{{ route('admin.mensajes.index') }}"><i class='bx bx-message'></i> Mensajes</a></div>
                <div class="enlace">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;padding:0;">
                            <i class='bx bx-log-out'></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <main class="main-content">
            <div class="welcome-section">
                <h1><i class='bx bx-message'></i> Mensajes del Administrador</h1>
                <p>Gestiona la comunicación con empleados y administra mensajes del sistema</p>
            </div>

            <!-- Alertas -->
            <div id="alertContainer"></div>

            <div class="messages-container">
                <div class="messages-header">
                    <div class="messages-actions">
                        <button class="btn-action secondary" onclick="mostrarFormularioNuevoMensaje()">
                            <i class='bx bx-plus'></i>
                            Nuevo Mensaje
                        </button>
                        <button class="btn-action secondary" onclick="mostrarConversacionesEmpleados()">
                            <i class='bx bx-group'></i>
                            Conversaciones con Empleados
                        </button>
                        <button class="btn-action secondary" onclick="marcarTodosComoLeidos()">
                            <i class='bx bx-check-double'></i>
                            Marcar Todos como Leídos
                        </button>
                        <button class="btn-action secondary" onclick="mostrarHistorial()">
                            <i class='bx bx-history'></i>
                            Historial de Mensajes
                        </button>
                        <button class="btn-action" onclick="actualizarMensajes()">
                            <i class='bx bx-refresh'></i>
                            Actualizar
                        </button>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="stats-container">
                    <div class="stat-card clickable" onclick="filtrarMensajes('todos')" data-filtro="todos">
                        <span class="stat-number">{{ $totalMensajes }}</span>
                        <div class="stat-label">Total de Mensajes</div>
                    </div>
                    <div class="stat-card clickable" onclick="filtrarMensajes('no_leidos')" data-filtro="no_leidos">
                        <span class="stat-number">{{ $mensajesNoLeidos }}</span>
                        <div class="stat-label">No Leídos</div>
                    </div>
                    <div class="stat-card clickable" onclick="filtrarMensajes('leidos')" data-filtro="leidos">
                        <span class="stat-number">{{ $mensajesLeidos }}</span>
                        <div class="stat-label">Leídos</div>
                    </div>
                    <div class="stat-card clickable" onclick="filtrarMensajes('enviados')" data-filtro="enviados">
                        <span class="stat-number">{{ $mensajesEnviados }}</span>
                        <div class="stat-label">Enviados</div>
                    </div>
                    <div class="stat-card clickable" onclick="filtrarMensajes('recibidos')" data-filtro="recibidos">
                        <span class="stat-number">{{ $mensajesRecibidos }}</span>
                        <div class="stat-label">Recibidos</div>
                    </div>
                </div>

                <!-- Lista de Mensajes (solo no leídos del admin) -->
                @php
                    $mensajesNoLeidos = $mensajes->where('empleado_id', auth()->id())->where('leido', false);
                @endphp
                
                @if($mensajesNoLeidos->count() > 0)
                    <div class="messages-list" id="messagesList">
                        @foreach($mensajesNoLeidos as $mensaje)
                            <div class="message-item unread" onclick="showMessageModal({{ $mensaje->id }})">
                                <div class="message-header">
                                    <div class="message-subject">{{ $mensaje->asunto }}</div>
                                    <div class="message-meta">
                                        <span class="type-badge type-{{ $mensaje->tipo }}">
                                            <i class='bx bx-{{ $mensaje->icono_tipo }}'></i>
                                            {{ ucfirst($mensaje->tipo) }}
                                        </span>
                                        <span class="priority-badge priority-{{ $mensaje->prioridad }}">
                                            {{ ucfirst($mensaje->prioridad) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="message-preview">
                                    {{ Str::limit($mensaje->mensaje, 150) }}
                                </div>
                                <div class="message-footer">
                                    <div class="message-sender">
                                        <i class='bx bx-user'></i>
                                        {{ $mensaje->remitente->name ?? 'Sistema' }}
                                    </div>
                                    <div class="message-date">
                                        {{ $mensaje->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class='bx bx-message-square-check'></i>
                        <h3>No tienes mensajes pendientes</h3>
                        <p>Todos tus mensajes han sido leídos. Revisa el historial para ver mensajes anteriores.</p>
                    </div>
                @endif
            </div>

            <!-- Detalle del Mensaje -->
            <div class="message-detail" id="messageDetail">
                <div class="detail-header">
                    <div class="detail-subject" id="detailSubject"></div>
                    <div class="detail-meta" id="detailMeta"></div>
                </div>
                <div class="detail-content" id="detailContent"></div>
                <div class="detail-footer">
                    <div class="detail-sender" id="detailSender"></div>
                    <div class="detail-actions">
                        <button class="btn-mark-read" id="markReadBtn" onclick="marcarComoLeido()" style="display: none;">
                            <i class='bx bx-check'></i>
                            Marcar como Leído
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal de Mensaje -->
    <div class="modal" id="messageModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modalTitle"></div>
                <button class="modal-close" onclick="cerrarModal()">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <div class="modal-meta" id="modalMeta"></div>
            <div class="modal-body" id="modalBody"></div>
            
            <!-- Formulario de Respuesta -->
            <div class="reply-section" id="replySection" style="display: none;">
                <div class="reply-header">
                    <h4><i class='bx bx-reply'></i> Responder Mensaje</h4>
                </div>
                <form id="replyForm" onsubmit="enviarRespuesta(event)">
                    <div class="form-group">
                        <textarea 
                            id="replyText" 
                            name="respuesta" 
                            placeholder="Escribe tu respuesta aquí..." 
                            rows="4" 
                            required
                            maxlength="1000"
                        ></textarea>
                        <div class="char-count">
                            <span id="charCount">0</span>/1000 caracteres
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="toggleReplyForm()">
                            <i class='bx bx-x'></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn-send">
                            <i class='bx bx-send'></i>
                            Enviar Respuesta
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <div class="modal-sender" id="modalSender"></div>
                <div class="modal-actions">
                    <button class="btn-reply" onclick="toggleReplyForm()">
                        <i class='bx bx-reply'></i>
                        Responder
                    </button>
                    <button class="btn-mark-read" id="modalMarkReadBtn" onclick="marcarComoLeidoModal()" style="display: none;">
                        <i class='bx bx-check'></i>
                        Marcar como Leído
                    </button>
                    <button class="btn-close" onclick="cerrarModal()">
                        <i class='bx bx-x'></i>
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Historial -->
    <div class="history-modal" id="historyModal">
        <div class="history-content">
            <div class="history-header">
                <div class="history-title">
                    <i class='bx bx-history'></i>
                    Historial de Mensajes Leídos
                </div>
                <button class="modal-close" onclick="cerrarHistorial()">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <div class="history-list" id="historyList">
                <!-- Los mensajes del historial se cargarán aquí -->
            </div>
        </div>
    </div>

    <!-- Modal para Conversaciones con Empleados -->
    <div class="modal" id="employeesModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Conversaciones con Empleados</div>
                <button class="modal-close" onclick="cerrarModalEmpleados()">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <div class="employees-list" id="employeesList">
                <!-- Lista de empleados se cargará aquí -->
            </div>
        </div>
    </div>

    <!-- Modal para Nuevo Mensaje -->
    <div class="modal" id="newMessageModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Nuevo Mensaje</div>
                <button class="modal-close" onclick="cerrarModalNuevoMensaje()">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <form id="newMessageForm" onsubmit="enviarNuevoMensaje(event)">
                <div class="form-group">
                    <label for="empleado_id">Destinatario:</label>
                    <select id="empleado_id" name="empleado_id" required>
                        <option value="">Seleccionar empleado</option>
                        @foreach($empleados as $empleado)
                            <option value="{{ $empleado->id }}">{{ $empleado->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="asunto">Asunto:</label>
                    <input type="text" id="asunto" name="asunto" required maxlength="255">
                </div>
                <div class="form-group">
                    <label for="prioridad">Prioridad:</label>
                    <select id="prioridad" name="prioridad" required>
                        <option value="baja">Baja</option>
                        <option value="normal" selected>Normal</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" rows="6" required maxlength="1000"></textarea>
                    <div class="char-count">
                        <span id="charCountNew">0</span>/1000 caracteres
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="cerrarModalNuevoMensaje()">
                        <i class='bx bx-x'></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn-send">
                        <i class='bx bx-send'></i>
                        Enviar Mensaje
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Technova
    </footer>

    <script>
        let currentMessageId = null;

        // Mostrar mensaje en modal
        function showMessageModal(messageId) {
            currentMessageId = messageId;
            
            const modal = document.getElementById('messageModal');
            if (!modal) {
                console.error('Modal no encontrado');
                showAlert('Error al abrir el mensaje', 'error');
                return;
            }
            
            // Mostrar indicador de carga
            const modalTitle = document.getElementById('modalTitle');
            const modalBody = document.getElementById('modalBody');
            const modalMeta = document.getElementById('modalMeta');
            const modalSender = document.getElementById('modalSender');
            
            if (modalTitle) modalTitle.textContent = 'Cargando...';
            if (modalBody) modalBody.innerHTML = '<div style="text-align: center; padding: 20px;"><i class="bx bx-loader-alt bx-spin" style="font-size: 2rem; color: #667eea;"></i></div>';
            if (modalMeta) modalMeta.innerHTML = '';
            if (modalSender) modalSender.innerHTML = '';
            
            modal.classList.add('show');
            
            // Cargar datos reales del mensaje
            fetch(`/admin/mensajes/${messageId}`)
                .then(response => response.json())
                .then(data => {
                    if (modalTitle) modalTitle.textContent = data.asunto;
                    if (modalBody) modalBody.innerHTML = data.mensaje.replace(/\n/g, '<br>');
                    
                    if (modalMeta) {
                        const iconoTipo = data.tipo === 'general' ? 'bx-message' : 
                                        data.tipo === 'instruccion' ? 'bx-task' : 
                                        data.tipo === 'notificacion' ? 'bx-bell' : 
                                        data.tipo === 'respuesta' ? 'bx-reply' : 'bx-message';
                        
                        modalMeta.innerHTML = `
                            <span class="type-badge type-${data.tipo}">
                                <i class="bx bx-${iconoTipo}"></i>
                                ${data.tipo.charAt(0).toUpperCase() + data.tipo.slice(1)}
                            </span>
                            <span class="priority-badge priority-${data.prioridad}">
                                ${data.prioridad.charAt(0).toUpperCase() + data.prioridad.slice(1)}
                            </span>
                            <span style="color: #6c757d; font-size: 0.9rem;">${new Date(data.created_at).toLocaleString()}</span>
                        `;
                    }
                    
                    if (modalSender) {
                        modalSender.innerHTML = `
                            <i class='bx bx-user'></i>
                            Enviado por: ${data.remitente ? data.remitente.name : 'Sistema'}
                        `;
                    }
                    
                    // Marcar automáticamente como leído si no está leído y el admin es el destinatario
                    if (!data.leido && data.empleado_id == {{ auth()->id() }}) {
                        marcarComoLeidoAutomatico(messageId);
                    }
                    
                    // Mostrar botón de marcar como leído solo si no está leído
                    const markReadBtn = document.getElementById('modalMarkReadBtn');
                    if (markReadBtn) {
                        if (!data.leido) {
                            markReadBtn.style.display = 'block';
                        } else {
                            markReadBtn.style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error al cargar el mensaje', 'error');
                    cerrarModal();
                });
        }

        // Cerrar modal
        function cerrarModal() {
            document.getElementById('messageModal').classList.remove('show');
            currentMessageId = null;
            // Ocultar formulario de respuesta
            document.getElementById('replySection').style.display = 'none';
            document.getElementById('replyForm').reset();
            document.getElementById('charCount').textContent = '0';
        }

        // Marcar como leído desde modal
        function marcarComoLeidoModal() {
            if (!currentMessageId) {
                showAlert('No hay mensaje seleccionado', 'error');
                return;
            }
            
            const button = document.getElementById('modalMarkReadBtn');
            if (!button) {
                showAlert('Error: botón no encontrado', 'error');
                return;
            }
            
            const originalText = button.innerHTML;
            
            button.disabled = true;
            button.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Marcando...';
            
            fetch(`/admin/mensajes/${currentMessageId}/marcar-leido`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert('Mensaje marcado como leído', 'success');
                    button.innerHTML = '<i class="bx bx-check"></i> ¡Leído!';
                    button.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                    
                    // Cerrar modal y actualizar lista
                    setTimeout(() => {
                        cerrarModal();
                        actualizarMensajes();
                    }, 1500);
                } else {
                    showAlert(data.message || 'Error al marcar el mensaje', 'error');
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert(`Error al marcar el mensaje: ${error.message}`, 'error');
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }

        // Marcar todos como leídos
        function marcarTodosComoLeidos() {
            if (!confirm('¿Estás seguro de que quieres marcar todos los mensajes como leídos?')) {
                return;
            }
            
            const button = document.querySelector('button[onclick="marcarTodosComoLeidos()"]');
            if (!button) {
                showAlert('Error: botón no encontrado', 'error');
                return;
            }
            
            const originalText = button.innerHTML;
            
            button.disabled = true;
            button.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Marcando...';
            
            fetch('/admin/mensajes/marcar-todos-leidos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert('Todos los mensajes han sido marcados como leídos', 'success');
                    button.innerHTML = '<i class="bx bx-check-double"></i> ¡Todos leídos!';
                    button.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                    
                    // Actualizar la lista
                    setTimeout(() => {
                        actualizarMensajes();
                    }, 1500);
                } else {
                    showAlert(data.message || 'Error al marcar los mensajes', 'error');
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert(`Error al marcar los mensajes: ${error.message}`, 'error');
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }

        // Actualizar mensajes sin recargar página
        function actualizarMensajes() {
            const refreshBtn = document.querySelector('button[onclick="actualizarMensajes()"]');
            if (!refreshBtn) {
                console.error('Botón de actualizar no encontrado');
                return;
            }
            
            const originalText = refreshBtn.innerHTML;
            
            refreshBtn.disabled = true;
            refreshBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Actualizando...';
            
            // Obtener la vista actualizada del servidor
            fetch('/admin/mensajes')
                .then(response => response.text())
                .then(html => {
                    // Crear un elemento temporal para parsear el HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    
                    // Extraer la lista de mensajes y estadísticas
                    const newMessagesList = tempDiv.querySelector('#messagesList');
                    const newStatsContainer = tempDiv.querySelector('.stats-container');
                    
                    if (newMessagesList) {
                        document.getElementById('messagesList').innerHTML = newMessagesList.innerHTML;
                    }
                    
                    if (newStatsContainer) {
                        document.querySelector('.stats-container').innerHTML = newStatsContainer.innerHTML;
                    }
                    
                    showAlert('Mensajes actualizados', 'success');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error al actualizar mensajes', 'error');
                })
                .finally(() => {
                    refreshBtn.disabled = false;
                    refreshBtn.innerHTML = originalText;
                });
        }

        // Mostrar historial de mensajes
        function mostrarHistorial() {
            document.getElementById('historyModal').classList.add('show');
            cargarHistorial();
        }

        // Cerrar historial
        function cerrarHistorial() {
            document.getElementById('historyModal').classList.remove('show');
        }

        // Cargar mensajes del historial
        function cargarHistorial() {
            const historyList = document.getElementById('historyList');
            if (!historyList) {
                console.error('Elemento historyList no encontrado');
                return;
            }
            
            historyList.innerHTML = '<div style="text-align: center; padding: 20px;"><i class="bx bx-loader-alt bx-spin" style="font-size: 2rem; color: #667eea;"></i><br>Cargando historial...</div>';
            
            // Obtener todos los mensajes del administrador
            fetch('/admin/mensajes')
                .then(response => response.text())
                .then(html => {
                    // Crear un elemento temporal para parsear el HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    
                    // Extraer todos los mensajes
                    const allMessages = tempDiv.querySelectorAll('.message-item');
                    const readMessages = Array.from(allMessages).filter(item => !item.classList.contains('unread'));
                    
                    if (readMessages.length === 0) {
                        historyList.innerHTML = `
                            <div class="empty-state">
                                <i class='bx bx-message-square-x'></i>
                                <h3>No hay mensajes en el historial</h3>
                                <p>Los mensajes leídos aparecerán aquí</p>
                            </div>
                        `;
                        return;
                    }
                    
                    let historyHTML = '';
                    readMessages.forEach(messageElement => {
                        const subject = messageElement.querySelector('.message-subject')?.textContent || 'Sin asunto';
                        const preview = messageElement.querySelector('.message-preview')?.textContent || '';
                        const sender = messageElement.querySelector('.message-sender')?.textContent || 'Sistema';
                        const date = messageElement.querySelector('.message-date')?.textContent || '';
                        const typeBadge = messageElement.querySelector('.type-badge');
                        const priorityBadge = messageElement.querySelector('.priority-badge');
                        
                        const tipo = typeBadge ? typeBadge.className.match(/type-(\w+)/)?.[1] || 'general' : 'general';
                        const prioridad = priorityBadge ? priorityBadge.className.match(/priority-(\w+)/)?.[1] || 'normal' : 'normal';
                        
                        const iconoTipo = tipo === 'general' ? 'bx-message' : 
                                        tipo === 'instruccion' ? 'bx-task' : 
                                        tipo === 'notificacion' ? 'bx-bell' : 
                                        tipo === 'respuesta' ? 'bx-reply' : 'bx-message';
                        
                        historyHTML += `
                            <div class="history-item">
                                <div class="history-item-header">
                                    <div class="history-item-subject">${subject}</div>
                                    <div class="history-item-meta">
                                        <span class="type-badge type-${tipo}">
                                            <i class="bx bx-${iconoTipo}"></i>
                                            ${tipo.charAt(0).toUpperCase() + tipo.slice(1)}
                                        </span>
                                        <span class="priority-badge priority-${prioridad}">
                                            ${prioridad.charAt(0).toUpperCase() + prioridad.slice(1)}
                                        </span>
                                    </div>
                                </div>
                                <div class="history-item-preview">${preview}</div>
                                <div class="history-item-footer">
                                    <div class="history-item-sender">
                                        <i class='bx bx-user'></i>
                                        ${sender}
                                    </div>
                                    <div class="history-item-date">${date}</div>
                                </div>
                            </div>
                        `;
                    });
                    
                    historyList.innerHTML = historyHTML;
                })
                .catch(error => {
                    console.error('Error:', error);
                    historyList.innerHTML = `
                        <div class="empty-state">
                            <i class='bx bx-error'></i>
                            <h3>Error al cargar el historial</h3>
                            <p>No se pudieron cargar los mensajes del historial</p>
                        </div>
                    `;
                });
        }

        // Mostrar alertas
        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            
            alertContainer.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }

        // Cerrar modales al hacer clic fuera
        document.addEventListener('click', function(event) {
            const messageModal = document.getElementById('messageModal');
            const historyModal = document.getElementById('historyModal');
            
            if (event.target === messageModal) {
                cerrarModal();
            }
            
            if (event.target === historyModal) {
                cerrarHistorial();
            }
        });

        // Cerrar modales con tecla Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                cerrarModal();
                cerrarHistorial();
            }
        });

        // Funciones para el formulario de respuesta
        function toggleReplyForm() {
            const replySection = document.getElementById('replySection');
            if (replySection.style.display === 'none') {
                replySection.style.display = 'block';
                document.getElementById('replyText').focus();
            } else {
                replySection.style.display = 'none';
                document.getElementById('replyForm').reset();
                document.getElementById('charCount').textContent = '0';
            }
        }

        function enviarRespuesta(event) {
            event.preventDefault();
            
            if (!currentMessageId) {
                showAlert('No hay mensaje seleccionado', 'error');
                return;
            }

            const formData = new FormData(event.target);
            const replyText = formData.get('respuesta').trim();

            if (!replyText) {
                showAlert('Por favor escribe una respuesta', 'error');
                return;
            }

            const sendBtn = event.target.querySelector('button[type="submit"]');
            const originalText = sendBtn.innerHTML;
            
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Enviando...';

            fetch(`/admin/mensajes/${currentMessageId}/responder`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    respuesta: replyText
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Respuesta enviada correctamente', 'success');
                    toggleReplyForm();
                    // Actualizar la lista de mensajes
                    setTimeout(() => {
                        actualizarMensajes();
                    }, 1000);
                } else {
                    showAlert('Error al enviar la respuesta', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al enviar la respuesta', 'error');
            })
            .finally(() => {
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalText;
            });
        }

        // Contador de caracteres
        document.addEventListener('DOMContentLoaded', function() {
            const replyText = document.getElementById('replyText');
            const charCount = document.getElementById('charCount');
            
            if (replyText && charCount) {
                replyText.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
            }
        });

        // Filtrar mensajes por contadores
        function filtrarMensajes(filtro) {
            // Actualizar estado activo de los contadores
            document.querySelectorAll('.stat-card').forEach(card => {
                card.classList.remove('active');
            });
            
            const activeCard = document.querySelector(`[data-filtro="${filtro}"]`);
            if (activeCard) {
                activeCard.classList.add('active');
            }

            // Mostrar indicador de carga
            const messagesList = document.getElementById('messagesList');
            if (messagesList) {
                messagesList.innerHTML = '<div style="text-align: center; padding: 20px;"><i class="bx bx-loader-alt bx-spin" style="font-size: 2rem; color: #007bff;"></i><br>Cargando mensajes...</div>';
            }

            fetch(`/admin/mensajes-filtrar?filtro=${filtro}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        actualizarListaMensajes(data.mensajes);
                        actualizarEstadisticas(data.estadisticas);
                        showAlert(`Mostrando mensajes: ${filtro === 'todos' ? 'Todos' : filtro === 'no_leidos' ? 'No leídos' : filtro === 'leidos' ? 'Leídos' : filtro === 'enviados' ? 'Enviados' : 'Recibidos'}`, 'success');
                    } else {
                        showAlert(data.message || 'Error al filtrar mensajes', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert(`Error al filtrar mensajes: ${error.message}`, 'error');
                });
        }

        function actualizarListaMensajes(mensajes) {
            const messagesList = document.getElementById('messagesList');
            if (!messagesList) return;

            if (mensajes.length === 0) {
                messagesList.innerHTML = `
                    <div class="empty-state">
                        <i class='bx bx-message-square-x'></i>
                        <h3>No hay mensajes</h3>
                        <p>No se encontraron mensajes con el filtro seleccionado</p>
                    </div>
                `;
                return;
            }

            let messagesHTML = '';
            mensajes.forEach(mensaje => {
                const iconoTipo = mensaje.tipo === 'general' ? 'bx-message' : 
                                mensaje.tipo === 'instruccion' ? 'bx-task' : 
                                mensaje.tipo === 'notificacion' ? 'bx-bell' : 
                                mensaje.tipo === 'respuesta' ? 'bx-reply' : 'bx-message';
                
                const leidoClass = mensaje.leido ? '' : 'unread';
                const fechaFormateada = new Date(mensaje.created_at).toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                messagesHTML += `
                    <div class="message-item ${leidoClass}" onclick="showMessageModal(${mensaje.id})">
                        <div class="message-header">
                            <div class="message-subject">${mensaje.asunto}</div>
                            <div class="message-meta">
                                <span class="type-badge type-${mensaje.tipo}">
                                    <i class='bx bx-${iconoTipo}'></i>
                                    ${mensaje.tipo.charAt(0).toUpperCase() + mensaje.tipo.slice(1)}
                                </span>
                                <span class="priority-badge priority-${mensaje.prioridad}">
                                    ${mensaje.prioridad.charAt(0).toUpperCase() + mensaje.prioridad.slice(1)}
                                </span>
                            </div>
                        </div>
                        <div class="message-preview">${mensaje.mensaje.substring(0, 120)}...</div>
                        <div class="message-footer">
                            <div class="message-sender">
                                <i class='bx bx-user'></i>
                                ${mensaje.remitente ? mensaje.remitente.name : 'Sistema'}
                            </div>
                            <div class="message-date">${fechaFormateada}</div>
                        </div>
                    </div>
                `;
            });

            messagesList.innerHTML = messagesHTML;
        }

        function actualizarEstadisticas(estadisticas) {
            document.querySelector('[data-filtro="todos"] .stat-number').textContent = estadisticas.total;
            document.querySelector('[data-filtro="no_leidos"] .stat-number').textContent = estadisticas.no_leidos;
            document.querySelector('[data-filtro="leidos"] .stat-number').textContent = estadisticas.leidos;
            
            // Actualizar contadores de enviados y recibidos si están disponibles
            const enviadosElement = document.querySelector('[data-filtro="enviados"] .stat-number');
            const recibidosElement = document.querySelector('[data-filtro="recibidos"] .stat-number');
            
            if (enviadosElement && estadisticas.enviados !== undefined) {
                enviadosElement.textContent = estadisticas.enviados;
            }
            if (recibidosElement && estadisticas.recibidos !== undefined) {
                recibidosElement.textContent = estadisticas.recibidos;
            }
        }

        // Funciones para conversaciones con empleados
        function mostrarConversacionesEmpleados() {
            document.getElementById('employeesModal').classList.add('show');
            cargarConversacionesEmpleados();
        }

        function cerrarModalEmpleados() {
            document.getElementById('employeesModal').classList.remove('show');
        }

        function cargarConversacionesEmpleados() {
            const employeesList = document.getElementById('employeesList');
            if (!employeesList) return;
            
            employeesList.innerHTML = '<div style="text-align: center; padding: 20px;"><i class="bx bx-loader-alt bx-spin" style="font-size: 2rem; color: #667eea;"></i><br>Cargando empleados...</div>';
            
            fetch('/admin/conversaciones-empleados')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        mostrarListaEmpleados(data.empleados);
                    } else {
                        employeesList.innerHTML = `
                            <div class="empty-state">
                                <i class='bx bx-error'></i>
                                <h3>Error al cargar empleados</h3>
                                <p>${data.message || 'No se pudieron cargar las conversaciones'}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    employeesList.innerHTML = `
                        <div class="empty-state">
                            <i class='bx bx-error'></i>
                            <h3>Error al cargar empleados</h3>
                            <p>No se pudieron cargar las conversaciones con empleados</p>
                        </div>
                    `;
                });
        }

        function mostrarListaEmpleados(empleados) {
            const employeesList = document.getElementById('employeesList');
            if (!employeesList) return;
            
            if (empleados.length === 0) {
                employeesList.innerHTML = `
                    <div class="empty-state">
                        <i class='bx bx-group'></i>
                        <h3>No hay conversaciones</h3>
                        <p>No tienes conversaciones con empleados aún</p>
                    </div>
                `;
                return;
            }
            
            let employeesHTML = '';
            empleados.forEach(empleado => {
                employeesHTML += `
                    <div class="employee-item" onclick="filtrarMensajesPorEmpleado(${empleado.id})">
                        <div class="employee-info">
                            <div class="employee-name">${empleado.name}</div>
                            <div class="employee-email">${empleado.email}</div>
                            ${empleado.ultimo_mensaje ? `
                                <div class="last-message">
                                    <strong>Último mensaje:</strong> ${empleado.ultimo_mensaje.asunto} - ${empleado.ultimo_mensaje.fecha}
                                </div>
                            ` : ''}
                        </div>
                        <div class="employee-stats">
                            <div class="message-count">${empleado.total_mensajes} mensajes</div>
                            ${empleado.mensajes_no_leidos > 0 ? `
                                <div class="unread-count">${empleado.mensajes_no_leidos} no leídos</div>
                            ` : ''}
                        </div>
                    </div>
                `;
            });
            
            employeesList.innerHTML = employeesHTML;
        }

        function filtrarMensajesPorEmpleado(empleadoId) {
            // Filtrar mensajes por empleado específico
            fetch(`/admin/mensajes-filtrar?filtro=empleado&empleado_id=${empleadoId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        actualizarListaMensajes(data.mensajes);
                        cerrarModalEmpleados();
                        showAlert(`Mostrando mensajes con el empleado seleccionado`, 'success');
                    } else {
                        showAlert('Error al filtrar mensajes por empleado', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error al filtrar mensajes por empleado', 'error');
                });
        }

        // Funciones para nuevo mensaje
        function mostrarFormularioNuevoMensaje() {
            document.getElementById('newMessageModal').classList.add('show');
        }

        function cerrarModalNuevoMensaje() {
            document.getElementById('newMessageModal').classList.remove('show');
            document.getElementById('newMessageForm').reset();
            document.getElementById('charCountNew').textContent = '0';
        }

        function enviarNuevoMensaje(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const sendBtn = event.target.querySelector('button[type="submit"]');
            const originalText = sendBtn.innerHTML;
            
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Enviando...';

            fetch('/admin/mensajes/enviar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    empleado_id: formData.get('empleado_id'),
                    asunto: formData.get('asunto'),
                    mensaje: formData.get('mensaje'),
                    prioridad: formData.get('prioridad')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Mensaje enviado correctamente', 'success');
                    cerrarModalNuevoMensaje();
                    // Actualizar contadores en tiempo real
                    actualizarContadoresDespuesEnvio();
                    // Actualizar la lista de mensajes
                    setTimeout(() => {
                        actualizarMensajes();
                    }, 1000);
                } else {
                    showAlert('Error al enviar el mensaje', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al enviar el mensaje', 'error');
            })
            .finally(() => {
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalText;
            });
        }

        // Función para marcar como leído automáticamente
        function marcarComoLeidoAutomatico(messageId) {
            fetch(`/admin/mensajes/${messageId}/marcar-leido`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar contadores en tiempo real
                    actualizarContadoresTiempoReal();
                }
            })
            .catch(error => {
                console.error('Error al marcar como leído automáticamente:', error);
            });
        }

        // Función para actualizar contadores en tiempo real
        function actualizarContadoresTiempoReal() {
            fetch('/admin/mensajes-filtrar?filtro=todos')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        actualizarEstadisticas(data.estadisticas);
                    }
                })
                .catch(error => {
                    console.error('Error al actualizar contadores:', error);
                });
        }

        // Función para actualizar contadores después de enviar mensaje
        function actualizarContadoresDespuesEnvio() {
            setTimeout(() => {
                actualizarContadoresTiempoReal();
            }, 1000);
        }

        // Contador de caracteres para nuevo mensaje
        document.addEventListener('DOMContentLoaded', function() {
            const mensajeText = document.getElementById('mensaje');
            const charCount = document.getElementById('charCountNew');
            
            if (mensajeText && charCount) {
                mensajeText.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
            }
        });
    </script>
</body>
</html>
