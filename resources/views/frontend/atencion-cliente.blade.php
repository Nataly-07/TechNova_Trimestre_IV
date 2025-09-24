<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Atención al Cliente - Technova</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    <style>
        .atencion-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 20px;
        }

        .chat-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .chat-title {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chat-title i {
            color: #3498db;
        }

        .chat-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .message {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            gap: 10px;
        }

        .message.bot {
            flex-direction: row;
        }

        .message.user {
            flex-direction: row-reverse;
        }

        .message .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .bot .avatar {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .user .avatar {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
        }

        .bubble {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.4;
        }

        .bot .bubble {
            background: white;
            color: #2c3e50;
            border: 1px solid #e9ecef;
        }

        .user .bubble {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .time {
            font-size: 11px;
            color: #95a5a6;
            margin-top: 5px;
            text-align: center;
        }

        .input-box {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .input-box input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            outline: none;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .input-box input:focus {
            border-color: #3498db;
        }

        .input-box button {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .input-box button:hover {
            transform: scale(1.05);
        }

        .consultas-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .consultas-title {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .consultas-title i {
            color: #e74c3c;
        }

        .consulta-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
        }

        .consulta-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .consulta-tema {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .consulta-estado {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .estado-abierto {
            background: #fff3cd;
            color: #856404;
        }

        .estado-respondido {
            background: #d4edda;
            color: #155724;
        }

        .consulta-fecha {
            color: #7f8c8d;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .consulta-descripcion {
            color: #2c3e50;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .consulta-respuesta {
            background: #e8f5e8;
            border-radius: 8px;
            padding: 15px;
            border-left: 3px solid #2ecc71;
        }

        .consulta-respuesta h4 {
            color: #27ae60;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .consulta-respuesta p {
            color: #2c3e50;
            margin: 0;
            line-height: 1.4;
        }

        /* Estilos para pestañas */
        .tabs-container {
            background: white;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .tabs-header {
            display: flex;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-bottom: none;
        }

        .tab-button {
            flex: 1;
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .tab-button:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .tab-button.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-bottom: 3px solid white;
        }

        .tab-content {
            display: none;
            padding: 0;
        }

        .tab-content.active {
            display: block;
        }

        /* Estilos para mensajes directos */
        .mensajes-section {
            padding: 25px;
        }

        .mensajes-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f8f9fa;
        }

        .mensajes-title {
            font-size: 1.5rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-new-message {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-new-message:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .message-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .message-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .message-subject {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
        }

        .message-meta {
            display: flex;
            gap: 10px;
            align-items: center;
        }

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

        .status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-enviado { background: #e2e3e5; color: #383d41; }
        .status-leido { background: #d1ecf1; color: #0c5460; }
        .status-respondido { background: #d4edda; color: #155724; }
        .status-cerrado { background: #e2e3e5; color: #383d41; }

        .message-preview {
            color: #6c757d;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .message-date {
            color: #adb5bd;
            font-size: 0.9rem;
        }

        .message-form {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-top: 20px;
            display: none;
        }

        .form-title {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .btn-send {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }

        .btn-send:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .message-detail {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-top: 20px;
            display: none;
        }

        .message-detail.show {
            display: block;
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .detail-subject {
            font-size: 1.4rem;
            color: #333;
            font-weight: 600;
        }

        .detail-meta {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .detail-content {
            line-height: 1.6;
            color: #495057;
            margin-bottom: 20px;
        }

        .detail-response {
            background: white;
            border-radius: 8px;
            padding: 20px;
            border-left: 4px solid #28a745;
        }

        .detail-response h4 {
            color: #28a745;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nueva-consulta {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .nueva-consulta h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #3498db;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .btn-enviar {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.3s ease;
        }

        .btn-enviar:hover {
            transform: scale(1.05);
        }

        .alert {
            padding: 15px 20px;
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

        @media (max-width: 768px) {
            .atencion-content {
                grid-template-columns: 1fr;
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
      <a href="{{ route('perfillcli') }}" class="account"><i class='bx bx-user-circle'></i> <span>Perfil</span></a>
      <a href="/logout" class="account"><i class='bx bx-log-out'></i> <span>Cerrar Sesión</span></a>
    </div>
  </header>

  <div class="dashboard-wrapper">
    @include('frontend.layouts.sidebar-cliente')

    <main class="main-content">
      <div class="welcome-section">
        <h1><i class='bx bx-headphone'></i> Atención al Cliente</h1>
        <p>Estamos aquí para ayudarte. Envíanos tu consulta y te responderemos lo antes posible.</p>
      </div>

      <!-- Alertas -->
      @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      @if(session('error'))
          <div class="alert alert-error">
              {{ session('error') }}
          </div>
      @endif

      <!-- Pestañas de Atención al Cliente -->
      <div class="tabs-container">
          <div class="tabs-header">
              <button class="tab-button active" onclick="showTab('chat')">
                  <i class='bx bx-message-dots'></i>
                  Chat en Vivo
              </button>
              <button class="tab-button" onclick="showTab('consultas')">
                  <i class='bx bx-history'></i>
                  Mis Consultas
              </button>
              <button class="tab-button" onclick="showTab('mensajes')">
                  <i class='bx bx-envelope'></i>
                  Mensajes Directos
              </button>
          </div>

          <!-- Contenido del Chat en Vivo -->
          <div id="chat-tab" class="tab-content active">
              <div class="chat-section">
                  <h2 class="chat-title">
                      <i class='bx bx-message-dots'></i>
                      Chat en Vivo
                  </h2>
                  
                  <div class="chat-box" id="chatBox">
                      <div class="message bot">
                          <div class="avatar">👤</div>
                          <div class="bubble">
                              ¡Hola! ¿En qué te podemos ayudar hoy?
                          </div>
                      </div>
                      <div class="message bot">
                          <div class="avatar">👤</div>
                          <div class="bubble">
                              Puedes escribirnos cualquier duda sobre productos, envíos, pagos o cualquier otro tema.
                          </div>
                      </div>
                  </div>

                  <div class="input-box">
                      <input type="text" id="chatInput" placeholder="Escribe tu mensaje aquí...">
                      <button onclick="enviarMensaje()">➤</button>
                  </div>
              </div>
          </div>

          <!-- Contenido de Mis Consultas -->
          <div id="consultas-tab" class="tab-content">
              <div class="consultas-section">
                  <h2 class="consultas-title">
                      <i class='bx bx-history'></i>
                      Mis Consultas
                  </h2>

                  @if($consultas->count() > 0)
                      @foreach($consultas as $consulta)
                          <div class="consulta-item">
                              <div class="consulta-header">
                                  <div class="consulta-tema">{{ $consulta->Tema }}</div>
                                  <div class="consulta-estado estado-{{ $consulta->Estado }}">
                                      {{ ucfirst($consulta->Estado) }}
                                  </div>
                              </div>
                              <div class="consulta-fecha">
                                  {{ $consulta->Fecha_Consulta->format('d/m/Y H:i') }}
                              </div>
                              <div class="consulta-descripcion">
                                  {{ $consulta->Descripcion }}
                              </div>
                              
                              @if($consulta->Respuesta)
                                  <div class="consulta-respuesta">
                                      <h4><i class='bx bx-check-circle'></i> Respuesta del Equipo</h4>
                                      <p>{{ $consulta->Respuesta }}</p>
                                  </div>
                              @endif
                          </div>
                      @endforeach
                  @else
                      <div style="text-align: center; color: #7f8c8d; padding: 40px;">
                          <i class='bx bx-message-square-x' style="font-size: 48px; margin-bottom: 15px;"></i>
                          <p>No tienes consultas anteriores</p>
                      </div>
                  @endif
              </div>
          </div>

          <!-- Contenido de Mensajes Directos -->
          <div id="mensajes-tab" class="tab-content">
              <div class="mensajes-section">
                  <div class="mensajes-header">
                      <h2 class="mensajes-title">
                          <i class='bx bx-envelope'></i>
                          Mensajes Directos a Soporte
                      </h2>
                      <button class="btn-new-message" onclick="toggleMessageForm()">
                          <i class='bx bx-plus'></i>
                          Nuevo Mensaje
                      </button>
                  </div>

                  @if($mensajes->count() > 0)
                      <div id="messagesList">
                          @foreach($mensajes as $mensaje)
                              <div class="message-item" onclick="showMessageDetail({{ $mensaje->id }})">
                                  <div class="message-header">
                                      <div class="message-subject">{{ $mensaje->asunto }}</div>
                                      <div class="message-meta">
                                          <span class="priority-badge priority-{{ $mensaje->prioridad }}">
                                              {{ ucfirst($mensaje->prioridad) }}
                                          </span>
                                          <span class="status-badge status-{{ $mensaje->estado }}">
                                              {{ ucfirst($mensaje->estado) }}
                                          </span>
                                      </div>
                                  </div>
                                  <div class="message-preview">
                                      {{ Str::limit($mensaje->mensaje, 100) }}
                                  </div>
                                  <div class="message-date">
                                      {{ $mensaje->created_at->format('d/m/Y H:i') }}
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  @else
                      <div style="text-align: center; color: #7f8c8d; padding: 40px;">
                          <i class='bx bx-message-square-x' style="font-size: 48px; margin-bottom: 15px;"></i>
                          <h3>No tienes mensajes</h3>
                          <p>Envía tu primer mensaje directo a nuestro equipo de soporte</p>
                      </div>
                  @endif

                  <!-- Formulario de Nuevo Mensaje -->
                  <div class="message-form" id="messageForm">
                      <h3 class="form-title">
                          <i class='bx bx-edit'></i>
                          Nuevo Mensaje
                      </h3>
                      
                      <form id="newMessageForm">
                          @csrf
                          <div class="form-group">
                              <label for="asunto">Asunto</label>
                              <input type="text" id="asunto" name="asunto" required maxlength="200" placeholder="Describe brevemente tu consulta">
                          </div>
                          
                          <div class="form-group">
                              <label for="prioridad">Prioridad</label>
                              <select id="prioridad" name="prioridad" required>
                                  <option value="normal">Normal</option>
                                  <option value="baja">Baja</option>
                                  <option value="alta">Alta</option>
                                  <option value="urgente">Urgente</option>
                              </select>
                          </div>
                          
                          <div class="form-group">
                              <label for="mensaje">Mensaje</label>
                              <textarea id="mensaje" name="mensaje" required maxlength="2000" placeholder="Describe detalladamente tu consulta o problema..."></textarea>
                          </div>
                          
                          <button type="submit" class="btn-send">
                              <i class='bx bx-send'></i>
                              Enviar Mensaje
                          </button>
                      </form>
                  </div>

                  <!-- Detalle del Mensaje -->
                  <div class="message-detail" id="messageDetail">
                      <div class="detail-header">
                          <div class="detail-subject" id="detailSubject"></div>
                          <div class="detail-meta" id="detailMeta"></div>
                      </div>
                      <div class="detail-content" id="detailContent"></div>
                      <div class="detail-response" id="detailResponse" style="display: none;">
                          <h4><i class='bx bx-check-circle'></i> Respuesta del Equipo</h4>
                          <p id="responseContent"></p>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Nueva Consulta -->
      @auth
      <div class="nueva-consulta">
          <h3><i class='bx bx-plus-circle'></i> Nueva Consulta</h3>
          
          <form action="{{ route('atencion-cliente.store') }}" method="POST">
              @csrf
              <div class="form-group">
                  <label for="tema">Tema de la consulta</label>
                  <input type="text" id="tema" name="tema" required placeholder="Ej: Problema con mi pedido">
              </div>
              
              <div class="form-group">
                  <label for="descripcion">Descripción detallada</label>
                  <textarea id="descripcion" name="descripcion" required placeholder="Describe tu consulta o problema de manera detallada..."></textarea>
              </div>
              
              <button type="submit" class="btn-enviar">
                  <i class='bx bx-send'></i> Enviar Consulta
              </button>
          </form>
      </div>
      @else
      <div class="nueva-consulta">
          <h3><i class='bx bx-info-circle'></i> Iniciar Sesión</h3>
          <p>Para enviar consultas y ver el historial, necesitas <a href="{{ route('login') }}" style="color: #3498db; text-decoration: none; font-weight: 600;">iniciar sesión</a>.</p>
      </div>
      @endauth
    </main><!-- /main-content -->

  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

    <script>
        // Funcionalidad de pestañas
        function showTab(tabName) {
            // Ocultar todas las pestañas
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Remover clase active de todos los botones
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(button => button.classList.remove('active'));
            
            // Mostrar la pestaña seleccionada
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Activar el botón correspondiente
            event.target.classList.add('active');
        }

        // Funcionalidad del chat
        function enviarMensaje() {
            const input = document.getElementById('chatInput');
            const mensaje = input.value.trim();
            
            if (mensaje) {
                // Agregar mensaje del usuario
                const chatBox = document.getElementById('chatBox');
                const userMessage = document.createElement('div');
                userMessage.className = 'message user';
                userMessage.innerHTML = `
                    <div class="avatar">👤</div>
                    <div class="bubble">${mensaje}</div>
                `;
                chatBox.appendChild(userMessage);
                
                // Limpiar input
                input.value = '';
                
                // Scroll al final
                chatBox.scrollTop = chatBox.scrollHeight;
                
                // Simular respuesta del bot (en una implementación real, esto sería una llamada AJAX)
                setTimeout(() => {
                    const botMessage = document.createElement('div');
                    botMessage.className = 'message bot';
                    botMessage.innerHTML = `
                        <div class="avatar">👤</div>
                        <div class="bubble">Gracias por tu mensaje. Un agente se pondrá en contacto contigo pronto.</div>
                    `;
                    chatBox.appendChild(botMessage);
                    chatBox.scrollTop = chatBox.scrollHeight;
                }, 1000);
            }
        }
        
        // Enviar mensaje con Enter
        document.getElementById('chatInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                enviarMensaje();
            }
        });

        // Funcionalidad de mensajes directos
        function toggleMessageForm() {
            const form = document.getElementById('messageForm');
            const isVisible = form.style.display !== 'none';
            
            if (isVisible) {
                form.style.display = 'none';
            } else {
                form.style.display = 'block';
                form.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function showMessageDetail(messageId) {
            fetch(`/atencion-cliente/mensajes/${messageId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailSubject').textContent = data.asunto;
                    document.getElementById('detailContent').textContent = data.mensaje;
                    
                    const meta = document.getElementById('detailMeta');
                    meta.innerHTML = `
                        <span class="priority-badge priority-${data.prioridad}">${data.prioridad.charAt(0).toUpperCase() + data.prioridad.slice(1)}</span>
                        <span class="status-badge status-${data.estado}">${data.estado.charAt(0).toUpperCase() + data.estado.slice(1)}</span>
                        <span style="color: #6c757d; font-size: 0.9rem;">${new Date(data.created_at).toLocaleString()}</span>
                    `;
                    
                    if (data.respuesta) {
                        document.getElementById('responseContent').textContent = data.respuesta;
                        document.getElementById('detailResponse').style.display = 'block';
                    } else {
                        document.getElementById('detailResponse').style.display = 'none';
                    }
                    
                    document.getElementById('messageDetail').classList.add('show');
                    document.getElementById('messageDetail').scrollIntoView({ behavior: 'smooth' });
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error al cargar el mensaje', 'error');
                });
        }

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

        // Envío de mensajes directos
        document.getElementById('newMessageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('.btn-send');
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Enviando...';
            
            fetch('/atencion-cliente/mensajes', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    this.reset();
                    document.getElementById('messageForm').style.display = 'none';
                    location.reload(); // Refrescar la lista de mensajes
                } else {
                    showAlert('Error al enviar el mensaje', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al enviar el mensaje', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bx bx-send"></i> Enviar Mensaje';
            });
        });
    </script>
</body>
</html>
