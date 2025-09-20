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
    <div class="menu-dashboard">
      <div class="top-menu">
        <div class="logo">
          <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt=""> 
          <span>Dashboard Cliente</span>
        </div>
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
      </div>

      <div class="menu">
        <div class="enlace"><a href="{{ route('perfillcli') }}"><i class='bx bx-user-circle'></i> Mi Perfil</a></div>
        @if(auth()->user() && auth()->user()->role === 'admin')
        <div class="enlace"><a href="{{ route('usuarios.index') }}"><i class='bx bx-user'></i> Usuarios</a></div>
        <div class="enlace"><a href="{{ route('productos.index') }}"><i class='bx bx-package'></i> Inventario Productos</a></div>
        @endif
        <div class="enlace"><a href="{{ url('favoritos') }}"><i class='bx bx-heart'></i> Favoritos</a></div>
        <div class="enlace"><a href="{{ url('mensajescli') }}"><i class='bx bx-message'></i> Mensajes</a></div>
        <div class="enlace"><a href="{{ route('pedidoscli') }}"><i class='bx bx-cart'></i> Pedidos</a></div>
        <div class="enlace"><a href="{{ url('mediopagos') }}"><i class='bx bx-credit-card'></i>Medios De<br>Pagos</a></div>
        <div class="enlace"><a href="{{ url('miscompras') }}"><i class='bx bx-shopping-bag'></i> Mis Compras</a></div>
        <div class="enlace"><a href="{{ url('atencion') }}"><i class='bx bx-headphone'></i> Atencion Al Cliente</a></div>
        <div class="enlace">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;padding:0;">
              <i class='bx bx-log-out'></i> Cerrar Sesión
            </button>
          </form>
        </div>
      </div>
    </div><!-- /.menu-dashboard -->

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

      <div class="atencion-content">
            <!-- Chat en Vivo -->
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

            <!-- Consultas Anteriores -->
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
    </script>
</body>
</html>
