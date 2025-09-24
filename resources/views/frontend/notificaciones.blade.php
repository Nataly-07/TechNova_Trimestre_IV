<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notificaciones - Technova</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/css/estilodas.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}">
    <script src="{{ asset('frontend/js/app.js') }}" defer></script>
    
    <style>
        .notifications-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .notifications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }

        .notifications-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .notifications-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 10px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-mark-all {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-mark-all:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
            background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
        }

        .btn-mark-all:active {
            transform: translateY(0);
        }

        .btn-mark-all.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-mark-all.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .notifications-stats {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .notifications-stats::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
        }

        .stats-grid {
            display: flex;
            justify-content: space-around;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .stat-item {
            text-align: center;
            flex: 1;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 8px 12px;
            border-radius: 8px;
        }

        .stat-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .stat-item.active {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .stat-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 30px;
            background: rgba(255, 255, 255, 0.3);
        }

        .stat-number {
            font-size: 1.4rem;
            font-weight: 700;
            color: white;
            margin-bottom: 2px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .stat-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .notifications-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .notification-item {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            margin-bottom: 5px;
        }

        .notification-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .notification-item.unread {
            border-left: 4px solid #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .notification-icon i {
            font-size: 20px;
            color: white;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 5px 0;
        }

        .notification-message {
            color: #7f8c8d;
            font-size: 0.95rem;
            line-height: 1.5;
            margin: 0 0 10px 0;
        }

        .notification-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .notification-date {
            font-size: 0.85rem;
            color: #95a5a6;
        }

        .notification-type {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .type-bienvenida {
            background: #e8f5e8;
            color: #27ae60;
        }

        .type-promocion {
            background: #fff3cd;
            color: #856404;
        }

        .type-pedido {
            background: #d1ecf1;
            color: #0c5460;
        }

        .type-producto {
            background: #f8d7da;
            color: #721c24;
        }

        .type-pago {
            background: #d4edda;
            color: #155724;
        }

        .type-soporte {
            background: #e2e3e5;
            color: #383d41;
        }

        .mark-read-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .mark-read-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }

        .mark-read-btn:active {
            transform: translateY(0);
        }

        .mark-read-btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .mark-unread-btn {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border: none;
            color: white;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);
        }

        .mark-unread-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
            background: linear-gradient(135deg, #e0a800 0%, #e55a00 100%);
        }

        .mark-unread-btn:active {
            transform: translateY(0);
        }

        .mark-unread-btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .unread-indicator {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 8px;
            height: 8px;
            background: #e74c3c;
            border-radius: 50%;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #bdc3c7;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .empty-state p {
            font-size: 1rem;
            margin: 0;
        }

        @media (max-width: 768px) {
            .notifications-container {
                padding: 15px;
            }

            .notifications-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .notifications-title {
                font-size: 1.5rem;
            }

            .notifications-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .notifications-stats {
                padding: 12px 16px;
            }

            .stat-number {
                font-size: 1.2rem;
            }

            .stat-label {
                font-size: 0.7rem;
            }

            .notification-item {
                padding: 15px;
                margin-bottom: 8px;
            }

            .notification-header {
                flex-direction: column;
                gap: 10px;
            }

            .notification-icon {
                width: 35px;
                height: 35px;
                margin-right: 0;
            }

            .notification-icon i {
                font-size: 18px;
            }

            .notification-meta {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .btn-action {
                padding: 8px 16px;
                font-size: 0.85rem;
            }

            .mark-read-btn {
                padding: 5px 10px;
                font-size: 0.75rem;
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
      <div class="notifications-container">
        <div class="notifications-header">
          <h1 class="notifications-title">
            <i class='bx bx-bell'></i> Notificaciones
          </h1>
          <div class="notifications-actions">
            <button class="btn-action btn-mark-all" onclick="marcarTodasComoLeidas()">
              <i class='bx bx-check-double'></i> Marcar todas como leídas
            </button>
          </div>
        </div>

        <div class="notifications-stats">
        <div class="stats-grid">
          <div class="stat-item active" onclick="filtrarNotificaciones('todas')" data-filtro="todas">
            <div class="stat-number">{{ $estadisticas['total'] }}</div>
            <div class="stat-label">Total</div>
          </div>
          <div class="stat-item" onclick="filtrarNotificaciones('no_leidas')" data-filtro="no_leidas">
            <div class="stat-number">{{ $estadisticas['no_leidas'] }}</div>
            <div class="stat-label">No leídas</div>
          </div>
          <div class="stat-item" onclick="filtrarNotificaciones('leidas')" data-filtro="leidas">
            <div class="stat-number">{{ $estadisticas['leidas'] }}</div>
            <div class="stat-label">Leídas</div>
          </div>
        </div>
        </div>

        @if(count($notificaciones) > 0)
          <div class="notifications-list" id="notificationsList">
            @foreach($notificaciones as $notificacion)
              <div class="notification-item {{ !$notificacion->leida ? 'unread' : '' }}">
                @if(!$notificacion->leida)
                  <div class="unread-indicator"></div>
                @endif
                
                <div class="notification-header">
                  <div class="notification-icon">
                    <i class='bx {{ $notificacion->icono }}'></i>
                  </div>
                  <div class="notification-content">
                    <h3 class="notification-title">{{ $notificacion->titulo }}</h3>
                    <p class="notification-message">{{ $notificacion->mensaje }}</p>
                  </div>
                </div>
                
                <div class="notification-meta">
                  <div>
                    <span class="notification-type type-{{ $notificacion->tipo }}">
                      {{ ucfirst($notificacion->tipo) }}
                    </span>
                    <span class="notification-date">
                      {{ $notificacion->fecha_creacion->diffForHumans() }}
                    </span>
                  </div>
                  @if(!$notificacion->leida)
                    <button class="mark-read-btn" onclick="marcarComoLeida({{ $notificacion->id }})">
                      <i class='bx bx-check'></i> Marcar como leída
                    </button>
                  @else
                    <button class="mark-unread-btn" onclick="marcarComoNoLeida({{ $notificacion->id }})">
                      <i class='bx bx-undo'></i> Marcar como no leída
                    </button>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="empty-state" id="emptyState">
            <i class='bx bx-bell-off'></i>
            <h3>No hay notificaciones</h3>
            <p>No tienes notificaciones en este momento. Te notificaremos cuando tengamos algo importante que compartir contigo.</p>
          </div>
        @endif
      </div>
    </main>
  </div>

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

  <script>
    function marcarComoLeida(id) {
      var button = event.target.closest('.mark-read-btn');
      var originalText = button.innerHTML;
      
      // Mostrar estado de carga
      button.classList.add('loading');
      button.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Marcando...';
      
      var csrfToken = document.querySelector('meta[name="csrf-token"]');
      var token = csrfToken ? csrfToken.getAttribute('content') : '';
      
      fetch('/notificaciones/' + id + '/marcar-leida', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token
        }
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        if (data.success) {
          // Mostrar éxito
          button.innerHTML = '<i class="bx bx-check"></i> ¡Leída!';
          button.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
          
          // Actualizar contadores
          actualizarContadores(data.estadisticas);
          
          // Cambiar botón después de un momento
          setTimeout(function() {
            var notificationItem = button.closest('.notification-item');
            notificationItem.classList.remove('unread');
            var unreadIndicator = notificationItem.querySelector('.unread-indicator');
            if (unreadIndicator) {
              unreadIndicator.remove();
            }
            
            // Cambiar a botón "marcar como no leída"
            button.className = 'mark-unread-btn';
            button.innerHTML = '<i class="bx bx-undo"></i> Marcar como no leída';
            button.setAttribute('onclick', 'marcarComoNoLeida(' + id + ')');
            button.style.background = 'linear-gradient(135deg, #ffc107 0%, #fd7e14 100%)';
          }, 1500);
        }
      })
      .catch(function(error) {
        console.error('Error:', error);
        button.classList.remove('loading');
        button.innerHTML = originalText;
        alert('Error al marcar la notificación como leída');
      });
    }

    function marcarComoNoLeida(id) {
      var button = event.target.closest('.mark-unread-btn');
      var originalText = button.innerHTML;
      
      // Mostrar estado de carga
      button.classList.add('loading');
      button.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Marcando...';
      
      var csrfToken = document.querySelector('meta[name="csrf-token"]');
      var token = csrfToken ? csrfToken.getAttribute('content') : '';
      
      fetch('/notificaciones/' + id + '/marcar-no-leida', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token
        }
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        if (data.success) {
          // Mostrar éxito
          button.innerHTML = '<i class="bx bx-undo"></i> ¡No leída!';
          button.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
          
          // Actualizar contadores
          actualizarContadores(data.estadisticas);
          
          // Cambiar botón después de un momento
          setTimeout(function() {
            var notificationItem = button.closest('.notification-item');
            notificationItem.classList.add('unread');
            
            // Agregar indicador de no leída
            var unreadIndicator = document.createElement('div');
            unreadIndicator.className = 'unread-indicator';
            notificationItem.appendChild(unreadIndicator);
            
            // Cambiar a botón "marcar como leída"
            button.className = 'mark-read-btn';
            button.innerHTML = '<i class="bx bx-check"></i> Marcar como leída';
            button.setAttribute('onclick', 'marcarComoLeida(' + id + ')');
            button.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
          }, 1500);
        }
      })
      .catch(function(error) {
        console.error('Error:', error);
        button.classList.remove('loading');
        button.innerHTML = originalText;
        alert('Error al marcar la notificación como no leída');
      });
    }

    function marcarTodasComoLeidas() {
      var button = document.querySelector('.btn-mark-all');
      var originalText = button.innerHTML;
      
      // Mostrar estado de carga
      button.classList.add('loading');
      button.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Marcando todas...';
      
      var csrfToken = document.querySelector('meta[name="csrf-token"]');
      var token = csrfToken ? csrfToken.getAttribute('content') : '';
      
      fetch('/notificaciones/marcar-todas-leidas', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token
        }
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        if (data.success) {
          // Mostrar éxito
          button.innerHTML = '<i class="bx bx-check-double"></i> ¡Todas leídas!';
          button.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
          
          // Actualizar contadores
          actualizarContadores(data.estadisticas);
          
          // Ocultar todos los botones de marcar como leída
          setTimeout(function() {
            var markButtons = document.querySelectorAll('.mark-read-btn');
            markButtons.forEach(function(btn) {
              btn.style.display = 'none';
            });
            
            // Remover indicadores de no leídas
            var unreadItems = document.querySelectorAll('.notification-item.unread');
            unreadItems.forEach(function(item) {
              item.classList.remove('unread');
              var unreadIndicator = item.querySelector('.unread-indicator');
              if (unreadIndicator) {
                unreadIndicator.remove();
              }
            });
            
            // Ocultar botón principal
            button.style.display = 'none';
          }, 2000);
        }
      })
      .catch(function(error) {
        console.error('Error:', error);
        button.classList.remove('loading');
        button.innerHTML = originalText;
        alert('Error al marcar todas las notificaciones como leídas');
      });
    }

    function actualizarContadores(estadisticas) {
      // Actualizar contadores con datos del servidor
      var statNumbers = document.querySelectorAll('.stat-number');
      if (statNumbers.length >= 3 && estadisticas) {
        statNumbers[0].textContent = estadisticas.total;
        statNumbers[1].textContent = estadisticas.no_leidas;
        statNumbers[2].textContent = estadisticas.leidas;
      }
    }

    // Inicializar contadores al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
      actualizarContadores();
    });

    // Función para filtrar notificaciones
    function filtrarNotificaciones(filtro) {
      // Actualizar estado activo de los contadores
      document.querySelectorAll('.stat-item').forEach(item => {
        item.classList.remove('active');
      });
      document.querySelector(`[data-filtro="${filtro}"]`).classList.add('active');

      // Mostrar indicador de carga
      const notificationsList = document.getElementById('notificationsList');
      const emptyState = document.getElementById('emptyState');
      
      if (notificationsList) {
        notificationsList.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="bx bx-loader-alt bx-spin" style="font-size: 2rem; color: #667eea;"></i><br><p style="margin-top: 10px; color: #6c757d;">Cargando notificaciones...</p></div>';
      }

      // Realizar petición al backend
      fetch(`/notificaciones-filtrar?filtro=${filtro}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            actualizarListaNotificaciones(data.notificaciones);
            actualizarEstadisticas(data.estadisticas);
          } else {
            showAlert('Error al filtrar notificaciones', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showAlert('Error al filtrar notificaciones', 'error');
        });
    }

    // Función para actualizar la lista de notificaciones
    function actualizarListaNotificaciones(notificaciones) {
      const notificationsList = document.getElementById('notificationsList');
      const emptyState = document.getElementById('emptyState');
      
      if (!notificationsList && !emptyState) return;

      if (notificaciones.length === 0) {
        if (notificationsList) {
          notificationsList.style.display = 'none';
        }
        if (emptyState) {
          emptyState.style.display = 'block';
          emptyState.innerHTML = `
            <i class='bx bx-bell-off'></i>
            <h3>No hay notificaciones</h3>
            <p>No se encontraron notificaciones con el filtro seleccionado.</p>
          `;
        }
        return;
      }

      if (emptyState) {
        emptyState.style.display = 'none';
      }
      if (notificationsList) {
        notificationsList.style.display = 'block';
        
        let notificationsHTML = '';
        notificaciones.forEach(notificacion => {
          const leidaClass = notificacion.leida ? '' : 'unread';
          const fechaFormateada = new Date(notificacion.fecha_creacion).toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
          });
          
          notificationsHTML += `
            <div class="notification-item ${leidaClass}" style="margin-bottom: 5px;">
              ${!notificacion.leida ? '<div class="unread-indicator"></div>' : ''}
              <div class="notification-icon">
                <i class='bx bx-${notificacion.icono}'></i>
              </div>
              <div class="notification-content">
                <div class="notification-header">
                  <h4 class="notification-title">${notificacion.titulo}</h4>
                  <span class="notification-type type-${notificacion.tipo}">${notificacion.tipo}</span>
                </div>
                <p class="notification-message">${notificacion.mensaje}</p>
                <div class="notification-footer">
                  <span class="notification-date">${fechaFormateada}</span>
                  <div class="notification-actions">
                    ${!notificacion.leida ? 
                      `<button class="mark-read-btn" onclick="marcarComoLeida(${notificacion.id})">
                        <i class='bx bx-check'></i> Marcar como leída
                      </button>` : 
                      `<button class="mark-unread-btn" onclick="marcarComoNoLeida(${notificacion.id})">
                        <i class='bx bx-undo'></i> Marcar como no leída
                      </button>`
                    }
                  </div>
                </div>
              </div>
            </div>
          `;
        });
        
        notificationsList.innerHTML = notificationsHTML;
      }
    }

    // Función para actualizar las estadísticas
    function actualizarEstadisticas(estadisticas) {
      document.querySelector('[data-filtro="todas"] .stat-number').textContent = estadisticas.total;
      document.querySelector('[data-filtro="no_leidas"] .stat-number').textContent = estadisticas.no_leidas;
      document.querySelector('[data-filtro="leidas"] .stat-number').textContent = estadisticas.leidas;
    }
  </script>
</body>
</html>
