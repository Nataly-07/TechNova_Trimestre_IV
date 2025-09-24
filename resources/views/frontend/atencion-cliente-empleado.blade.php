<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Atención al Cliente - Empleado</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    
    <style>
        /* Estilos específicos para Atención al Cliente Empleado */
        .atencion-empleado-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .welcome-section h1 {
            margin: 0 0 10px 0;
            font-size: 2rem;
        }

        .welcome-section p {
            margin: 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        /* Estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
            border-left: 3px solid #667eea;
        }

        .stat-card.consultas {
            border-left-color: #28a745;
        }

        .stat-card.mensajes {
            border-left-color: #ffc107;
        }

        .stat-card.pendientes {
            border-left-color: #dc3545;
        }

        .stat-number {
            font-size: 1.6rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .stat-card.clickable {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .stat-card.clickable:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .stat-card.clickable.active {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border-left-width: 6px;
        }

        /* Estilos para búsqueda */
        .search-section {
            margin-bottom: 25px;
        }

        .search-container {
            position: relative;
            max-width: 400px;
            margin: 0 auto;
        }

        .search-container i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.1rem;
        }

        .search-container input {
            width: 100%;
            padding: 12px 45px 12px 45px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-container input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-clear-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .btn-clear-search:hover {
            background: #f8f9fa;
            color: #dc3545;
        }

        /* Estilos para modal de conversación */
        .conversation-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
        }

        .conversation-modal-content {
            background-color: white;
            margin: 2% auto;
            padding: 0;
            border-radius: 15px;
            width: 90%;
            max-width: 800px;
            height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .conversation-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .conversation-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }

        .conversation-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .conversation-close:hover {
            background-color: rgba(255,255,255,0.2);
        }

        .conversation-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .conversation-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .message-bubble {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }

        .message-bubble.sent {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .message-bubble.sent .message-avatar {
            background: #667eea;
            color: white;
        }

        .message-bubble.received .message-avatar {
            background: #28a745;
            color: white;
        }

        .message-content {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            position: relative;
        }

        .message-bubble.sent .message-content {
            background: #667eea;
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message-bubble.received .message-content {
            background: white;
            color: #333;
            border: 1px solid #e9ecef;
            border-bottom-left-radius: 5px;
        }

        .message-text {
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .message-time {
            font-size: 0.7rem;
            opacity: 0.7;
            margin-top: 5px;
            text-align: right;
        }

        .message-bubble.received .message-time {
            text-align: left;
        }

        .conversation-input {
            padding: 20px;
            background: white;
            border-top: 1px solid #e9ecef;
            border-radius: 0 0 15px 15px;
        }

        .conversation-input-form {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .conversation-input textarea {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 20px;
            font-size: 0.9rem;
            resize: none;
            min-height: 40px;
            max-height: 120px;
            font-family: inherit;
            transition: border-color 0.3s ease;
        }

        .conversation-input textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .conversation-send-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .conversation-send-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .conversation-send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .conversation-empty {
            text-align: center;
            color: #6c757d;
            padding: 40px 20px;
        }

        .conversation-empty i {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }

        /* Estilos para último mensaje */
        .last-message {
            display: flex;
            align-items: flex-start;
            gap: 5px;
        }

        .sender-name {
            font-weight: 600;
            color: #495057;
            flex-shrink: 0;
        }

        .sender-name:after {
            content: " ";
        }

        /* Pestañas */
        .tabs-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .tabs-header {
            display: flex;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .tab-button {
            flex: 1;
            padding: 15px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            color: #6c757d;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .tab-button.active {
            background: white;
            color: #667eea;
            border-bottom: 3px solid #667eea;
        }

        .tab-button:hover {
            background: #e9ecef;
        }

        .tab-content {
            display: none;
            padding: 25px;
        }

        .tab-content.active {
            display: block;
        }

        /* Filtros */
        .filters-section {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .filter-button {
            padding: 8px 16px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .filter-button.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .filter-button:hover {
            border-color: #667eea;
            color: #667eea;
        }

        /* Lista de elementos */
        .items-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .item-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .item-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .item-title {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .item-meta {
            display: flex;
            gap: 15px;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .item-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .item-preview {
            color: #495057;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .item-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-abierto {
            background: #fff3cd;
            color: #856404;
        }

        .status-en_proceso {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-resuelto {
            background: #d4edda;
            color: #155724;
        }

        .status-cerrado {
            background: #f8d7da;
            color: #721c24;
        }

        .status-enviado {
            background: #fff3cd;
            color: #856404;
        }

        .status-leido {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-respondido {
            background: #d4edda;
            color: #155724;
        }

        /* Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            width: 90%;
            max-width: 700px;
            max-height: 80vh;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1.3rem;
        }

        .close-modal {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: background 0.3s ease;
        }

        .close-modal:hover {
            background: rgba(255,255,255,0.2);
        }

        .modal-body {
            padding: 25px;
            max-height: 60vh;
            overflow-y: auto;
        }

        /* Formularios */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        /* Estado vacío */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }

        .empty-state h3 {
            margin: 0 0 10px 0;
            color: #495057;
        }

        .empty-state p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .tabs-header {
                flex-direction: column;
            }
            
            .filters-section {
                flex-direction: column;
            }
            
            .item-header {
                flex-direction: column;
                gap: 10px;
            }
            
            .item-meta {
                flex-direction: column;
                gap: 5px;
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
    @include('frontend.layouts.sidebar-empleado')

    <main class="main-content">
      <div class="atencion-empleado-container">
        <div class="welcome-section">
          <h1><i class='bx bx-headphone'></i> Atención al Cliente</h1>
          <p>Gestiona las consultas y mensajes de los clientes de manera eficiente</p>
        </div>

        <!-- Estadísticas y Filtros -->
        <div class="stats-grid">
          <div class="stat-card consultas clickable" onclick="filtrarPorTipo('consultas')">
            <div class="stat-number">{{ $estadisticas['total_consultas'] }}</div>
            <div class="stat-label">Total Consultas</div>
          </div>
          <div class="stat-card pendientes clickable" onclick="filtrarPorTipo('pendientes')">
            <div class="stat-number">{{ $estadisticas['consultas_pendientes'] }}</div>
            <div class="stat-label">Pendientes</div>
          </div>
          <div class="stat-card mensajes clickable" onclick="filtrarPorTipo('mensajes')">
            <div class="stat-number">{{ $estadisticas['total_mensajes'] }}</div>
            <div class="stat-label">Mensajes</div>
          </div>
          <div class="stat-card pendientes clickable" onclick="filtrarPorTipo('no_leidos')">
            <div class="stat-number">{{ $estadisticas['mensajes_no_leidos'] }}</div>
            <div class="stat-label">No Leídos</div>
          </div>
        </div>

        <!-- Filtro por nombre de cliente -->
        <div class="search-section">
          <div class="search-container">
            <i class='bx bx-search'></i>
            <input type="text" id="clientSearch" placeholder="Buscar por nombre de cliente..." onkeyup="buscarPorCliente()">
            <button class="btn-clear-search" onclick="limpiarBusqueda()" style="display: none;">
              <i class='bx bx-x'></i>
            </button>
          </div>
        </div>

        <!-- Pestañas -->
        <div class="tabs-container">
          <div class="tabs-header">
            <button class="tab-button active" onclick="showTab('consultas')">
              <i class='bx bx-clipboard'></i>
              Consultas
            </button>
            <button class="tab-button" onclick="showTab('mensajes')">
              <i class='bx bx-envelope'></i>
              Mensajes Directos
            </button>
          </div>

          <!-- Contenido de Consultas -->
          <div id="consultas-tab" class="tab-content active">
            <div class="filters-section">
              <button class="filter-button active" onclick="filtrarConsultas('todas')">Todas</button>
              <button class="filter-button" onclick="filtrarConsultas('pendientes')">Pendientes</button>
              <button class="filter-button" onclick="filtrarConsultas('en_proceso')">En Proceso</button>
              <button class="filter-button" onclick="filtrarConsultas('resueltas')">Resueltas</button>
              <button class="filter-button" onclick="filtrarConsultas('cerradas')">Cerradas</button>
            </div>

            <div id="consultasList" class="items-list">
              @if($consultas->count() > 0)
                @foreach($consultas as $consulta)
                  <div class="item-card" onclick="mostrarDetalleConsulta({{ $consulta->id }})">
                    <div class="item-header">
                      <div>
                        <div class="item-title">{{ $consulta->Tema }}</div>
                        <div class="item-meta">
                          <span><i class='bx bx-user'></i> {{ $consulta->usuario->name ?? 'Cliente' }}</span>
                          <span><i class='bx bx-calendar'></i> {{ $consulta->Fecha_Consulta->format('d/m/Y H:i') }}</span>
                        </div>
                      </div>
                      <div class="item-status status-{{ $consulta->Estado }}">
                        <i class='bx bx-circle'></i>
                        {{ ucfirst($consulta->Estado) }}
                      </div>
                    </div>
                    <div class="item-preview">
                      {{ Str::limit($consulta->Descripcion, 150) }}
                    </div>
                    @if($consulta->Respuesta)
                      <div style="color: #28a745; font-size: 0.85rem; display: flex; align-items: center; gap: 5px;">
                        <i class='bx bx-check-circle'></i>
                        Tiene respuesta
                      </div>
                    @endif
                  </div>
                @endforeach
              @else
                <div class="empty-state">
                  <i class='bx bx-clipboard'></i>
                  <h3>No hay consultas</h3>
                  <p>Los clientes aún no han enviado consultas</p>
                </div>
              @endif
            </div>
          </div>

          <!-- Contenido de Mensajes -->
          <div id="mensajes-tab" class="tab-content">
            <div class="filters-section">
              <button class="filter-button active" onclick="filtrarMensajes('todos')">Todos</button>
              <button class="filter-button" onclick="filtrarMensajes('no_leidos')">No Leídos</button>
              <button class="filter-button" onclick="filtrarMensajes('leidos')">Leídos</button>
              <button class="filter-button" onclick="filtrarMensajes('respondidos')">Respondidos</button>
            </div>

            <div id="mensajesList" class="items-list">
              @if($conversaciones->count() > 0)
                @foreach($conversaciones as $conversacion)
                  <div class="item-card" onclick="mostrarDetalleMensaje({{ $conversacion->id }})">
                    <div class="item-header">
                      <div>
                        <div class="item-title">{{ $conversacion->asunto }}</div>
                        <div class="item-meta">
                          <span><i class='bx bx-user'></i> {{ $conversacion->usuario->name ?? 'Cliente' }}</span>
                          <span><i class='bx bx-calendar'></i> {{ $conversacion->created_at->format('d/m/Y H:i') }}</span>
                          <span><i class='bx bx-flag'></i> {{ ucfirst($conversacion->prioridad) }}</span>
                        </div>
                      </div>
                      <div class="item-status status-{{ $conversacion->estado }}">
                        <i class='bx bx-circle'></i>
                        {{ ucfirst($conversacion->estado) }}
                      </div>
                    </div>
                    <div class="item-preview">
                      <div class="last-message">
                        <span class="sender-name">
                          {{ $conversacion->sender_type === 'empleado' ? 'Tú' : ($conversacion->usuario ? $conversacion->usuario->name : 'Cliente') }}:
                        </span>
                        {{ Str::limit($conversacion->mensaje, 120) }}
                      </div>
                    </div>
                    @if($conversacion->respuesta)
                      <div style="color: #28a745; font-size: 0.85rem; display: flex; align-items: center; gap: 5px;">
                        <i class='bx bx-check-circle'></i>
                        Tiene respuesta
                      </div>
                    @endif
                  </div>
                @endforeach
              @else
                <div class="empty-state">
                  <i class='bx bx-envelope'></i>
                  <h3>No hay mensajes</h3>
                  <p>Los clientes aún no han enviado mensajes directos</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Modal de Detalle -->
      <div id="detailModal" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h3 id="modalTitle">Detalle</h3>
            <button class="close-modal" onclick="cerrarModal()">
              <i class='bx bx-x'></i>
            </button>
          </div>
          <div class="modal-body">
            <div id="modalContent">
              <!-- Contenido dinámico -->
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal de Conversación -->
  <div id="conversationModal" class="conversation-modal">
    <div class="conversation-modal-content">
      <div class="conversation-header">
        <h3 class="conversation-title" id="conversationTitle">Conversación</h3>
        <button class="conversation-close" onclick="closeConversationModal()">
          <i class='bx bx-x'></i>
        </button>
      </div>
      <div class="conversation-body">
        <div class="conversation-messages" id="conversationMessages">
          <div class="conversation-empty">
            <i class='bx bx-message-square-dots'></i>
            <p>Cargando conversación...</p>
          </div>
        </div>
        <div class="conversation-input">
          <form class="conversation-input-form" id="conversationReplyForm">
            <textarea 
              id="conversationReplyText" 
              placeholder="Escribe tu respuesta..." 
              rows="1"
              maxlength="2000"
            ></textarea>
            <button type="submit" class="conversation-send-btn" id="conversationSendBtn">
              <i class='bx bx-send'></i>
              Enviar
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Variables globales
    let currentItemId = null;
    let currentItemType = null;
    let currentFilter = 'todas';
    let currentSearch = '';

    // Funciones de pestañas
    function showTab(tabName) {
      // Ocultar todas las pestañas
      document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
      });
      
      // Remover clase active de todos los botones
      document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
      });
      
      // Mostrar pestaña seleccionada
      document.getElementById(tabName + '-tab').classList.add('active');
      
      // Activar botón correspondiente
      event.target.classList.add('active');
    }

    // Funciones de filtros por tipo (contadores)
    function filtrarPorTipo(tipo) {
      // Remover clase active de todos los contadores
      document.querySelectorAll('.stat-card.clickable').forEach(card => {
        card.classList.remove('active');
      });
      
      // Agregar clase active al contador clickeado
      event.target.closest('.stat-card').classList.add('active');
      
      currentFilter = tipo;
      
      // Aplicar filtro según el tipo
      switch(tipo) {
        case 'consultas':
          showTab('consultas');
          filtrarConsultas('todas');
          break;
        case 'pendientes':
          showTab('consultas');
          filtrarConsultas('pendientes');
          break;
        case 'mensajes':
          showTab('mensajes');
          filtrarMensajes('todos');
          break;
        case 'no_leidos':
          showTab('mensajes');
          filtrarMensajes('no_leidos');
          break;
      }
    }

    // Función de búsqueda por cliente
    function buscarPorCliente() {
      const searchTerm = document.getElementById('clientSearch').value.trim();
      currentSearch = searchTerm;
      
      // Mostrar/ocultar botón de limpiar
      const clearBtn = document.querySelector('.btn-clear-search');
      if (searchTerm.length > 0) {
        clearBtn.style.display = 'block';
      } else {
        clearBtn.style.display = 'none';
      }
      
      // Aplicar búsqueda
      if (searchTerm.length >= 2) {
        aplicarBusqueda(searchTerm);
      } else if (searchTerm.length === 0) {
        // Si no hay término de búsqueda, mostrar todos los elementos
        if (currentFilter === 'consultas' || currentFilter === 'pendientes') {
          filtrarConsultas('todas');
        } else {
          filtrarMensajes('todos');
        }
      }
    }

    function limpiarBusqueda() {
      document.getElementById('clientSearch').value = '';
      currentSearch = '';
      document.querySelector('.btn-clear-search').style.display = 'none';
      
      // Restaurar vista original
      if (currentFilter === 'consultas' || currentFilter === 'pendientes') {
        filtrarConsultas('todas');
      } else {
        filtrarMensajes('todos');
      }
    }

    function aplicarBusqueda(searchTerm) {
      // Filtrar elementos visibles por nombre de cliente
      const currentTab = document.querySelector('.tab-content.active');
      const items = currentTab.querySelectorAll('.item-card');
      
      items.forEach(item => {
        const clientName = item.querySelector('.item-meta span').textContent.toLowerCase();
        if (clientName.includes(searchTerm.toLowerCase())) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    }

    // Funciones de filtros
    function filtrarConsultas(filtro) {
      // Actualizar botones activos
      document.querySelectorAll('#consultas-tab .filter-button').forEach(btn => {
        btn.classList.remove('active');
      });
      event.target.classList.add('active');

      // Realizar petición AJAX
      fetch(`/empleado/atencion-cliente/filtrar-consultas?filtro=${filtro}`)
        .then(response => response.json())
        .then(data => {
          actualizarListaConsultas(data.consultas);
          // Aplicar búsqueda si hay término activo
          if (currentSearch.length >= 2) {
            aplicarBusqueda(currentSearch);
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }

    function filtrarMensajes(filtro) {
      // Actualizar botones activos
      document.querySelectorAll('#mensajes-tab .filter-button').forEach(btn => {
        btn.classList.remove('active');
      });
      event.target.classList.add('active');

      // Realizar petición AJAX
      fetch(`/empleado/atencion-cliente/filtrar-mensajes?filtro=${filtro}`)
        .then(response => response.json())
        .then(data => {
          actualizarListaMensajes(data.mensajes);
          // Aplicar búsqueda si hay término activo
          if (currentSearch.length >= 2) {
            aplicarBusqueda(currentSearch);
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }

    // Funciones de actualización de listas
    function actualizarListaConsultas(consultas) {
      const container = document.getElementById('consultasList');
      
      if (consultas.length === 0) {
        container.innerHTML = `
          <div class="empty-state">
            <i class='bx bx-clipboard'></i>
            <h3>No hay consultas</h3>
            <p>No se encontraron consultas con el filtro seleccionado</p>
          </div>
        `;
        return;
      }

      container.innerHTML = consultas.map(consulta => `
        <div class="item-card" onclick="mostrarDetalleConsulta(${consulta.id})">
          <div class="item-header">
            <div>
              <div class="item-title">${consulta.Tema}</div>
              <div class="item-meta">
                <span><i class='bx bx-user'></i> ${consulta.usuario ? consulta.usuario.name : 'Cliente'}</span>
                <span><i class='bx bx-calendar'></i> ${new Date(consulta.Fecha_Consulta).toLocaleDateString()}</span>
              </div>
            </div>
            <div class="item-status status-${consulta.Estado}">
              <i class='bx bx-circle'></i>
              ${consulta.Estado.charAt(0).toUpperCase() + consulta.Estado.slice(1)}
            </div>
          </div>
          <div class="item-preview">
            ${consulta.Descripcion.substring(0, 150)}${consulta.Descripcion.length > 150 ? '...' : ''}
          </div>
          ${consulta.Respuesta ? `
            <div style="color: #28a745; font-size: 0.85rem; display: flex; align-items: center; gap: 5px;">
              <i class='bx bx-check-circle'></i>
              Tiene respuesta
            </div>
          ` : ''}
        </div>
      `).join('');
    }

    function actualizarListaMensajes(conversaciones) {
      const container = document.getElementById('mensajesList');
      
      if (conversaciones.length === 0) {
        container.innerHTML = `
          <div class="empty-state">
            <i class='bx bx-envelope'></i>
            <h3>No hay mensajes</h3>
            <p>No se encontraron mensajes con el filtro seleccionado</p>
          </div>
        `;
        return;
      }

      container.innerHTML = conversaciones.map(conversacion => {
        const senderName = conversacion.sender_type === 'empleado' ? 'Tú' : (conversacion.usuario ? conversacion.usuario.name : 'Cliente');
        
        return `
          <div class="item-card" onclick="mostrarDetalleMensaje(${conversacion.id})">
            <div class="item-header">
              <div>
                <div class="item-title">${conversacion.asunto}</div>
                <div class="item-meta">
                  <span><i class='bx bx-user'></i> ${conversacion.usuario ? conversacion.usuario.name : 'Cliente'}</span>
                  <span><i class='bx bx-calendar'></i> ${new Date(conversacion.created_at).toLocaleDateString()}</span>
                  <span><i class='bx bx-flag'></i> ${conversacion.prioridad.charAt(0).toUpperCase() + conversacion.prioridad.slice(1)}</span>
                </div>
              </div>
              <div class="item-status status-${conversacion.estado}">
                <i class='bx bx-circle'></i>
                ${conversacion.estado.charAt(0).toUpperCase() + conversacion.estado.slice(1)}
              </div>
            </div>
            <div class="item-preview">
              <div class="last-message">
                <span class="sender-name">${senderName}:</span>
                ${conversacion.mensaje.substring(0, 120)}${conversacion.mensaje.length > 120 ? '...' : ''}
              </div>
            </div>
            ${conversacion.respuesta ? `
              <div style="color: #28a745; font-size: 0.85rem; display: flex; align-items: center; gap: 5px;">
                <i class='bx bx-check-circle'></i>
                Tiene respuesta
              </div>
            ` : ''}
          </div>
        `;
      }).join('');
    }

    // Funciones de modal
    function mostrarDetalleConsulta(id) {
      currentItemId = id;
      currentItemType = 'consulta';
      
      fetch(`/empleado/atencion-cliente/consultas/${id}`)
        .then(response => response.json())
        .then(data => {
          const consulta = data.consulta;
          const usuario = data.usuario;
          
          document.getElementById('modalTitle').textContent = consulta.Tema;
          
          document.getElementById('modalContent').innerHTML = `
            <div class="consulta-detalle">
              <div class="form-group">
                <label>Cliente:</label>
                <input type="text" value="${usuario ? usuario.name : 'Cliente'}" readonly>
              </div>
              
              <div class="form-group">
                <label>Fecha de consulta:</label>
                <input type="text" value="${new Date(consulta.Fecha_Consulta).toLocaleString()}" readonly>
              </div>
              
              <div class="form-group">
                <label>Estado actual:</label>
                <select id="estadoConsulta" onchange="actualizarEstadoConsulta()">
                  <option value="abierto" ${consulta.Estado === 'abierto' ? 'selected' : ''}>Abierto</option>
                  <option value="en_proceso" ${consulta.Estado === 'en_proceso' ? 'selected' : ''}>En Proceso</option>
                  <option value="resuelto" ${consulta.Estado === 'resuelto' ? 'selected' : ''}>Resuelto</option>
                  <option value="cerrado" ${consulta.Estado === 'cerrado' ? 'selected' : ''}>Cerrado</option>
                </select>
              </div>
              
              <div class="form-group">
                <label>Descripción del problema:</label>
                <textarea readonly>${consulta.Descripcion}</textarea>
              </div>
              
              <div class="form-group">
                <label>Respuesta:</label>
                <textarea id="respuestaConsulta" placeholder="Escribe tu respuesta aquí...">${consulta.Respuesta || ''}</textarea>
              </div>
              
              <div style="display: flex; gap: 10px;">
                <button class="btn-primary" onclick="enviarRespuestaConsulta()">
                  <i class='bx bx-send'></i> Enviar Respuesta
                </button>
                <button class="btn-secondary" onclick="cerrarModal()">Cerrar</button>
              </div>
            </div>
          `;
          
          document.getElementById('detailModal').style.display = 'flex';
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al cargar los detalles de la consulta');
        });
    }

    function mostrarDetalleMensaje(id) {
      currentItemId = id;
      currentItemType = 'mensaje';
      
      fetch(`/empleado/atencion-cliente/mensajes/${id}`)
        .then(response => response.json())
        .then(data => {
          const mensaje = data.mensaje;
          
          if (mensaje.conversation_id) {
            showConversationModal(mensaje.conversation_id, id);
          } else {
            // Fallback al detalle simple si no hay conversation_id
            const usuario = data.usuario;
            
            document.getElementById('modalTitle').textContent = mensaje.asunto;
            
            document.getElementById('modalContent').innerHTML = `
              <div class="mensaje-detalle">
                <div class="form-group">
                  <label>Cliente:</label>
                  <input type="text" value="${usuario ? usuario.name : 'Cliente'}" readonly>
                </div>
                
                <div class="form-group">
                  <label>Fecha del mensaje:</label>
                  <input type="text" value="${new Date(mensaje.created_at).toLocaleString()}" readonly>
                </div>
                
                <div class="form-group">
                  <label>Prioridad:</label>
                  <input type="text" value="${mensaje.prioridad.charAt(0).toUpperCase() + mensaje.prioridad.slice(1)}" readonly>
                </div>
                
                <div class="form-group">
                  <label>Estado:</label>
                  <input type="text" value="${mensaje.estado.charAt(0).toUpperCase() + mensaje.estado.slice(1)}" readonly>
                </div>
                
                <div class="form-group">
                  <label>Mensaje del cliente:</label>
                  <textarea readonly>${mensaje.mensaje}</textarea>
                </div>
                
                <div class="form-group">
                  <label>Respuesta:</label>
                  <textarea id="respuestaMensaje" placeholder="Escribe tu respuesta aquí...">${mensaje.respuesta || ''}</textarea>
                </div>
                
                <div style="display: flex; gap: 10px;">
                  <button class="btn-primary" onclick="enviarRespuestaMensaje()">
                    <i class='bx bx-send'></i> Enviar Respuesta
                  </button>
                  <button class="btn-secondary" onclick="cerrarModal()">Cerrar</button>
                </div>
              </div>
            `;
            
            document.getElementById('detailModal').style.display = 'flex';
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al cargar los detalles del mensaje');
        });
    }

    function cerrarModal() {
      document.getElementById('detailModal').style.display = 'none';
      currentItemId = null;
      currentItemType = null;
    }

    // Funciones de respuesta
    function enviarRespuestaConsulta() {
      const respuesta = document.getElementById('respuestaConsulta').value;
      const estado = document.getElementById('estadoConsulta').value;
      
      if (!respuesta.trim()) {
        alert('Por favor, escribe una respuesta');
        return;
      }
      
      fetch(`/empleado/atencion-cliente/consultas/${currentItemId}/responder`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          respuesta: respuesta,
          estado: estado
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Respuesta enviada correctamente');
          cerrarModal();
          // Recargar la lista
          location.reload();
        } else {
          alert('Error al enviar la respuesta');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar la respuesta');
      });
    }

    function enviarRespuestaMensaje() {
      const respuesta = document.getElementById('respuestaMensaje').value;
      
      if (!respuesta.trim()) {
        alert('Por favor, escribe una respuesta');
        return;
      }
      
      fetch(`/empleado/atencion-cliente/mensajes/${currentItemId}/responder`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          respuesta: respuesta
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Respuesta enviada correctamente');
          cerrarModal();
          // Recargar la lista
          location.reload();
        } else {
          alert('Error al enviar la respuesta');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar la respuesta');
      });
    }

    function actualizarEstadoConsulta() {
      const estado = document.getElementById('estadoConsulta').value;
      
      fetch(`/empleado/atencion-cliente/consultas/${currentItemId}/estado`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          estado: estado
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Actualizar visualmente el estado
          console.log('Estado actualizado correctamente');
        } else {
          alert('Error al actualizar el estado');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el estado');
      });
    }

    // Cerrar modal al hacer clic fuera
    document.getElementById('detailModal').addEventListener('click', function(e) {
      if (e.target === this) {
        cerrarModal();
      }
    });

    // Funcionalidad del modal de conversación
    let currentConversationId = null;
    let currentMessageId = null;

    function showConversationModal(conversationId, messageId) {
      currentConversationId = conversationId;
      currentMessageId = messageId;
      
      const modal = document.getElementById('conversationModal');
      const title = document.getElementById('conversationTitle');
      const messagesContainer = document.getElementById('conversationMessages');
      
      title.textContent = 'Conversación con Cliente';
      messagesContainer.innerHTML = '<div class="conversation-empty"><i class="bx bx-loader-alt bx-spin"></i><p>Cargando conversación...</p></div>';
      
      modal.style.display = 'block';
      
      // Cargar la conversación
      loadConversation(conversationId);
    }

    function closeConversationModal() {
      const modal = document.getElementById('conversationModal');
      modal.style.display = 'none';
      currentConversationId = null;
      currentMessageId = null;
    }

    function loadConversation(conversationId) {
      fetch(`/empleado/atencion-cliente/conversacion/${conversationId}`)
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            throw new Error(data.error);
          }
          displayConversation(data);
        })
        .catch(error => {
          console.error('Error:', error);
          document.getElementById('conversationMessages').innerHTML = 
            '<div class="conversation-empty"><i class="bx bx-error"></i><p>Error al cargar la conversación</p></div>';
        });
    }

    function displayConversation(messages) {
      const messagesContainer = document.getElementById('conversationMessages');
      
      if (messages.length === 0) {
        messagesContainer.innerHTML = 
          '<div class="conversation-empty"><i class="bx bx-message-square-dots"></i><p>No hay mensajes en esta conversación</p></div>';
        return;
      }

      messagesContainer.innerHTML = '';
      
      messages.forEach(message => {
        const isSent = message.sender_type === 'empleado';
        const messageElement = document.createElement('div');
        messageElement.className = `message-bubble ${isSent ? 'sent' : 'received'}`;
        
        const time = new Date(message.created_at).toLocaleTimeString('es-ES', {
          hour: '2-digit',
          minute: '2-digit'
        });
        
        messageElement.innerHTML = `
          <div class="message-avatar">${isSent ? '👨‍💼' : '👤'}</div>
          <div class="message-content">
            <p class="message-text">${message.mensaje}</p>
            <div class="message-time">${time}</div>
          </div>
        `;
        
        messagesContainer.appendChild(messageElement);
      });
      
      // Scroll al final
      messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Manejar envío de respuesta
    document.getElementById('conversationReplyForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const replyText = document.getElementById('conversationReplyText').value.trim();
      if (!replyText || !currentMessageId) return;
      
      const sendBtn = document.getElementById('conversationSendBtn');
      const originalText = sendBtn.innerHTML;
      
      sendBtn.disabled = true;
      sendBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Enviando...';
      
      fetch(`/empleado/atencion-cliente/mensajes/${currentMessageId}/responder-conversacion`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          mensaje: replyText
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          document.getElementById('conversationReplyText').value = '';
          // Recargar la conversación
          loadConversation(currentConversationId);
          showAlert('Respuesta enviada correctamente', 'success');
        } else {
          showAlert('Error al enviar la respuesta', 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showAlert('Error de conexión', 'error');
      })
      .finally(() => {
        sendBtn.disabled = false;
        sendBtn.innerHTML = originalText;
      });
    });

    // Auto-resize del textarea
    document.getElementById('conversationReplyText').addEventListener('input', function() {
      this.style.height = 'auto';
      this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Cerrar modal al hacer clic fuera
    document.getElementById('conversationModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeConversationModal();
      }
    });

    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeConversationModal();
      }
    });

    // Función para mostrar alertas
    function showAlert(message, type) {
      const alertContainer = document.querySelector('.welcome-section');
      const alert = document.createElement('div');
      alert.className = `alert alert-${type}`;
      alert.textContent = message;
      alert.style.marginTop = '20px';
      
      alertContainer.appendChild(alert);
      
      setTimeout(() => {
        alert.remove();
      }, 5000);
    }
  </script>
</body>
</html>
