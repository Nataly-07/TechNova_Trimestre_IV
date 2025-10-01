<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* Estilos para el Centro de Soporte */
        .centro-soporte-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 25px;
        }

        .soporte-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e9ecef;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .section-title {
            font-size: 1.2rem;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-weight: 600;
        }

        .section-title i {
            color: #3498db;
        }

        .status-indicator {
            font-size: 0.9rem;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-indicator.online {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .btn-new-message {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-new-message:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
        }

        .message-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            border: 1px solid #e9ecef;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .message-item:hover {
            border-color: #3498db;
            box-shadow: 0 2px 8px rgba(52, 152, 219, 0.1);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .message-subject {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .message-meta {
            display: flex;
            gap: 8px;
        }

        .priority-badge, .status-badge {
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 500;
        }

        .priority-badge.priority-alta {
            background: #f8d7da;
            color: #721c24;
        }

        .priority-badge.priority-urgente {
            background: #f5c6cb;
            color: #721c24;
        }

        .priority-badge.priority-normal {
            background: #d1ecf1;
            color: #0c5460;
        }

        .priority-badge.priority-baja {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.status-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.status-resuelto {
            background: #d4edda;
            color: #155724;
        }

        .message-preview {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 8px;
        }

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

        .message-footer {
            display: flex;
            justify-content: flex-end;
        }

        .message-date {
            font-size: 0.8rem;
            color: #adb5bd;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .empty-state h3 {
            margin: 0 0 8px 0;
            color: #495057;
        }

        .empty-state p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Estilos para Mis Consultas */
        .consultas-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f8f9fa;
        }

        .consultas-title {
            font-size: 1.5rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .btn-new-consulta {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-new-consulta:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
        }

        .consulta-form {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #e9ecef;
        }

        .consulta-form .form-group {
            margin-bottom: 15px;
        }

        .consulta-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #2c3e50;
        }

        .consulta-form input,
        .consulta-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        .consulta-form input:focus,
        .consulta-form textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.1);
        }

        .consulta-form textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn-enviar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-enviar:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
        }

        /* Estilos para Chat en Vivo */
        .chat-vivo-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .agent-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .agent-avatar {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .agent-details h3 {
            margin: 0;
            font-size: 1.2rem;
        }

        .chat-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            background: rgba(255,255,255,0.3);
        }

        .chat-box {
            height: 400px;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }

        .message {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
            gap: 10px;
        }

        .message.user {
            flex-direction: row-reverse;
        }

        .message .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .message.bot .avatar {
            background: #667eea;
            color: white;
        }

        .message.user .avatar {
            background: #28a745;
            color: white;
        }

        .bubble {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .message.bot .bubble {
            background: white;
            color: #333;
            border: 1px solid #e9ecef;
        }

        .message.user .bubble {
            background: #667eea;
            color: white;
        }

        .timestamp {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 5px;
            text-align: center;
        }

        .input-box {
            display: flex;
            padding: 20px;
            background: white;
            border-top: 1px solid #e9ecef;
        }

        .input-box input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 0.9rem;
            outline: none;
        }

        .input-box input:focus {
            border-color: #667eea;
        }

        .input-box button {
            background: #667eea;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-left: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .input-box button:hover {
            background: #5a67d8;
            transform: scale(1.05);
        }

        /* Estilos para Mensajes Directos */
        .mensajes-directos-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 25px;
        }

        /* Estilos para Consultas Mejoradas */
        .consultas-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .consulta-item {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .consulta-item:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .consulta-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .consulta-info {
            flex: 1;
        }

        .consulta-tema {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .consulta-fecha {
            color: #6c757d;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .consulta-meta {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: flex-end;
        }

        .consulta-estado {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .consulta-estado.estado-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .consulta-estado.estado-en-proceso {
            background: #d1ecf1;
            color: #0c5460;
        }

        .consulta-estado.estado-resuelta {
            background: #d4edda;
            color: #155724;
        }

        .consulta-agente {
            color: #6c757d;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .consulta-preview {
            color: #495057;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .consulta-respuesta-indicator {
            color: #28a745;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }

        /* Modal de Consulta */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
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

        /* Estilos para el contenido del modal de consulta */
        .consulta-detalle {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .detalle-header {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 15px;
        }

        .detalle-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .detalle-descripcion h4 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .detalle-descripcion p {
            color: #495057;
            line-height: 1.6;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .detalle-respuesta {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #e9ecef;
        }

        .detalle-respuesta h4 {
            color: #28a745;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .respuesta-content p {
            color: #495057;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .respuesta-fecha {
            color: #6c757d;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
            font-style: italic;
        }

        .sin-respuesta {
            text-align: center;
            color: #6c757d;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 2px dashed #dee2e6;
        }

        .sin-respuesta i {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
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

        @media (max-width: 768px) {
            .atencion-content {
                grid-template-columns: 1fr;
            }
            
            .centro-soporte-container {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 15px;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
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
              <button class="tab-button active" onclick="showTab('chat-vivo')">
                    <i class='bx bx-message-dots'></i>
                    Chat en Vivo
              </button>
              <button class="tab-button" onclick="showTab('mensajes-directos')">
                  <i class='bx bx-envelope'></i>
                  Mensajes Directos
              </button>
              <button class="tab-button" onclick="showTab('consultas')">
                  <i class='bx bx-clipboard'></i>
                  Mis Consultas
              </button>
          </div>

          <!-- Contenido de Chat en Vivo -->
          <div id="chat-vivo-tab" class="tab-content active">
              <div class="chat-vivo-container">
                  <div class="chat-header">
                      <div class="agent-info">
                          <div class="agent-avatar">👤</div>
                          <div class="agent-details">
                              <h3>Agente de Soporte</h3>
                              <span class="status-indicator online">● En línea</span>
                          </div>
                      </div>
                      <div class="chat-actions">
                          <button class="btn-action" onclick="limpiarChat()">
                              <i class='bx bx-trash'></i>
                              Limpiar Chat
                          </button>
                      </div>
                  </div>
                
                <div class="chat-box" id="chatBox">
                    <div class="message bot">
                        <div class="avatar">👤</div>
                        <div class="bubble">
                              ¡Hola! Soy tu agente de soporte. ¿En qué te puedo ayudar hoy?
                        </div>
                          <div class="timestamp">{{ now()->format('H:i') }}</div>
                    </div>
                    <div class="message bot">
                        <div class="avatar">👤</div>
                        <div class="bubble">
                              Puedes preguntarme sobre productos, envíos, pagos o cualquier duda general. Estoy aquí para ayudarte.
                        </div>
                          <div class="timestamp">{{ now()->format('H:i') }}</div>
                    </div>
                </div>

                <div class="input-box">
                    <input type="text" id="chatInput" placeholder="Escribe tu mensaje aquí...">
                      <button onclick="enviarMensaje()">
                          <i class='bx bx-send'></i>
                      </button>
                  </div>
                </div>
            </div>

          <!-- Contenido de Mensajes Directos -->
          <div id="mensajes-directos-tab" class="tab-content">
              <div class="mensajes-directos-container">
                  <div class="mensajes-header">
                      <h2 class="mensajes-title">
                          <i class='bx bx-envelope'></i>
                          Mensajes Directos
                      </h2>
                      <button class="btn-new-message" onclick="toggleMessageForm()">
                          <i class='bx bx-plus'></i>
                          Nuevo Mensaje
                      </button>
                  </div>

                    @if($conversaciones->count() > 0)
                        <div id="messagesList">
                            @foreach($conversaciones as $conversacion)
                                <div class="message-item" onclick="showMessageDetail({{ $conversacion->id }})">
                                    <div class="message-header">
                                        <div class="message-subject">{{ $conversacion->asunto }}</div>
                                        <div class="message-meta">
                                            <span class="priority-badge priority-{{ $conversacion->prioridad }}">
                                                {{ ucfirst($conversacion->prioridad) }}
                                            </span>
                                            <span class="status-badge status-{{ $conversacion->estado }}">
                                                {{ ucfirst($conversacion->estado) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="message-preview">
                                        <div class="last-message">
                                            <span class="sender-name">
                                                {{ $conversacion->sender_type === 'cliente' ? 'Tú' : 'Soporte' }}:
                                            </span>
                                            {{ Str::limit($conversacion->mensaje, 80) }}
                                        </div>
                                    </div>
                                    <div class="message-footer">
                                        <div class="message-date">{{ $conversacion->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class='bx bx-message-square-x'></i>
                            <h3>No tienes mensajes</h3>
                            <p>Envía tu primer mensaje directo al equipo de soporte</p>
                        </div>
                    @endif

                  <!-- Formulario de Nuevo Mensaje -->
                  <div class="message-form" id="messageForm" style="display: none;">
                      <form id="newMessageForm">
                          @csrf
                          <div class="form-group">
                              <label for="asunto">Asunto</label>
                              <input type="text" id="asunto" name="asunto" required placeholder="Ej: Consulta sobre mi pedido">
                          </div>
                          
                          <div class="form-group">
                              <label for="prioridad">Prioridad</label>
                              <select id="prioridad" name="prioridad" required>
                                  <option value="normal">Normal</option>
                                  <option value="alta">Alta</option>
                                  <option value="urgente">Urgente</option>
                              </select>
                          </div>
                          
                          <div class="form-group">
                              <label for="mensaje">Mensaje</label>
                              <textarea id="mensaje" name="mensaje" required placeholder="Describe tu consulta o problema..."></textarea>
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

          <!-- Contenido de Mis Consultas -->
          <div id="consultas-tab" class="tab-content">
            <div class="consultas-section">
                  <div class="consultas-header">
                <h2 class="consultas-title">
                          <i class='bx bx-clipboard'></i>
                    Mis Consultas
                </h2>
                      <button class="btn-new-consulta" onclick="toggleConsultaForm()">
                          <i class='bx bx-plus'></i>
                          Nueva Consulta
                      </button>
                  </div>

                  <!-- Formulario de Nueva Consulta -->
                  <div class="consulta-form" id="consultaForm" style="display: none;">
                      <form action="{{ route('atencion-cliente.store') }}" method="POST">
                          @csrf
                          <div class="form-group">
                              <label for="tema">Tema de la consulta</label>
                              <input type="text" id="tema" name="tema" required placeholder="Ej: Problema con mi pedido #12345">
                          </div>
                          
                          <div class="form-group">
                              <label for="categoria">Categoría</label>
                              <select id="categoria" name="categoria" required>
                                  <option value="pedido">Problema con Pedido</option>
                                  <option value="pago">Problema con Pago</option>
                                  <option value="producto">Problema con Producto</option>
                                  <option value="envio">Problema con Envío</option>
                                  <option value="cuenta">Problema con Cuenta</option>
                                  <option value="otro">Otro</option>
                              </select>
                          </div>
                          
                          <div class="form-group">
                              <label for="prioridad">Prioridad</label>
                              <select id="prioridad" name="prioridad" required>
                                  <option value="normal">Normal</option>
                                  <option value="alta">Alta</option>
                                  <option value="urgente">Urgente</option>
                              </select>
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

                @if($consultas->count() > 0)
                      <div class="consultas-list">
                    @foreach($consultas as $consulta)
                              <div class="consulta-item" onclick="mostrarDetalleConsulta({{ $consulta->id }})">
                            <div class="consulta-header">
                                      <div class="consulta-info">
                                <div class="consulta-tema">{{ $consulta->Tema }}</div>
                                          <div class="consulta-fecha">
                                              <i class='bx bx-calendar'></i>
                                              {{ $consulta->Fecha_Consulta->format('d/m/Y H:i') }}
                                          </div>
                                      </div>
                                      <div class="consulta-meta">
                                <div class="consulta-estado estado-{{ $consulta->Estado }}">
                                              <i class='bx bx-circle'></i>
                                    {{ ucfirst($consulta->Estado) }}
                                </div>
                                          @if($consulta->Agente_Asignado)
                                              <div class="consulta-agente">
                                                  <i class='bx bx-user'></i>
                                                  {{ $consulta->Agente_Asignado }}
                            </div>
                                          @endif
                            </div>
                            </div>
                                  <div class="consulta-preview">
                                      {{ Str::limit($consulta->Descripcion, 150) }}
                                  </div>
                            @if($consulta->Respuesta)
                                      <div class="consulta-respuesta-indicator">
                                          <i class='bx bx-check-circle'></i>
                                          Tiene respuesta
                                </div>
                            @endif
                        </div>
                    @endforeach
                      </div>
                @else
                      <div class="empty-state">
                          <i class='bx bx-clipboard'></i>
                          <h3>No tienes consultas</h3>
                          <p>Crea tu primera consulta para recibir soporte especializado</p>
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

                  @if($conversaciones->count() > 0)
                      <div id="messagesList">
                          @foreach($conversaciones as $conversacion)
                              <div class="message-item" onclick="showMessageDetail({{ $conversacion->id }})">
                                  <div class="message-header">
                                      <div class="message-subject">{{ $conversacion->asunto }}</div>
                                      <div class="message-meta">
                                          <span class="priority-badge priority-{{ $conversacion->prioridad }}">
                                              {{ ucfirst($conversacion->prioridad) }}
                                          </span>
                                          <span class="status-badge status-{{ $conversacion->estado }}">
                                              {{ ucfirst($conversacion->estado) }}
                                          </span>
                                      </div>
                                  </div>
                                  <div class="message-preview">
                                      <div class="last-message">
                                          <span class="sender-name">
                                              {{ $conversacion->sender_type === 'cliente' ? 'Tú' : 'Soporte' }}:
                                          </span>
                                          {{ Str::limit($conversacion->mensaje, 80) }}
                                      </div>
                                  </div>
                                  <div class="message-date">
                                      {{ $conversacion->created_at->format('d/m/Y H:i') }}
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

      <!-- Modal de Detalle de Consulta -->
      <div id="consultaModal" class="modal" style="display: none;">
          <div class="modal-content">
              <div class="modal-header">
                  <h3 id="modalTitulo">Detalle de Consulta</h3>
                  <button class="close-modal" onclick="cerrarModalConsulta()">
                      <i class='bx bx-x'></i>
                  </button>
              </div>
              <div class="modal-body">
                  <div id="modalContenido">
                      <!-- Contenido dinámico -->
                  </div>
              </div>
          </div>
      </div>

    </main><!-- /main-content -->

  </div><!-- /dashboard-wrapper -->

  <footer>
    &copy; {{ date('Y') }} Technova
  </footer>

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

        // Funcionalidad de nueva consulta
        function toggleConsultaForm() {
            const form = document.getElementById('consultaForm');
            const isVisible = form.style.display !== 'none';
            
            if (isVisible) {
                form.style.display = 'none';
            } else {
                form.style.display = 'block';
                form.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Funcionalidad para limpiar chat
        function limpiarChat() {
            const chatBox = document.getElementById('chatBox');
            const messages = chatBox.querySelectorAll('.message.user');
            
            messages.forEach(message => {
                message.remove();
            });
            
            showAlert('Chat limpiado correctamente', 'success');
        }

        // Funcionalidad para mostrar detalle de consulta
        function mostrarDetalleConsulta(consultaId) {
            // Simular datos de consulta (en implementación real sería una llamada AJAX)
            const consultaData = {
                id: consultaId,
                tema: 'Problema con mi pedido #12345',
                categoria: 'pedido',
                prioridad: 'alta',
                estado: 'en-proceso',
                agente: 'María González',
                fecha: '15/01/2024 14:30',
                descripcion: 'Mi pedido no ha llegado en la fecha estimada. El tracking muestra que está en tránsito desde hace 5 días.',
                respuesta: 'Hola, hemos revisado tu pedido y encontramos que hubo un retraso en el envío. Tu paquete ya está en camino y debería llegar mañana. Te enviaremos un email con la confirmación de entrega.',
                fechaRespuesta: '16/01/2024 09:15'
            };

            const modal = document.getElementById('consultaModal');
            const titulo = document.getElementById('modalTitulo');
            const contenido = document.getElementById('modalContenido');

            titulo.textContent = consultaData.tema;
            
            contenido.innerHTML = `
                <div class="consulta-detalle">
                    <div class="detalle-header">
                        <div class="detalle-meta">
                            <span class="meta-item">
                                <i class='bx bx-calendar'></i>
                                ${consultaData.fecha}
                            </span>
                            <span class="meta-item">
                                <i class='bx bx-user'></i>
                                Agente: ${consultaData.agente}
                            </span>
                            <span class="meta-item">
                                <i class='bx bx-circle'></i>
                                Estado: ${consultaData.estado}
                            </span>
                        </div>
                    </div>
                    
                    <div class="detalle-descripcion">
                        <h4>Descripción del problema:</h4>
                        <p>${consultaData.descripcion}</p>
                    </div>
                    
                    ${consultaData.respuesta ? `
                        <div class="detalle-respuesta">
                            <h4><i class='bx bx-check-circle'></i> Respuesta del Equipo:</h4>
                            <div class="respuesta-content">
                                <p>${consultaData.respuesta}</p>
                                <div class="respuesta-fecha">
                                    <i class='bx bx-time'></i>
                                    Respondido el ${consultaData.fechaRespuesta}
                                </div>
                            </div>
                        </div>
                    ` : `
                        <div class="sin-respuesta">
                            <i class='bx bx-time'></i>
                            <p>Tu consulta está siendo revisada por nuestro equipo de soporte.</p>
                        </div>
                    `}
                </div>
            `;

            modal.style.display = 'flex';
        }

        // Funcionalidad para cerrar modal de consulta
        function cerrarModalConsulta() {
            const modal = document.getElementById('consultaModal');
            modal.style.display = 'none';
        }

        function showMessageDetail(messageId) {
            // Mostrar indicador de carga
            showAlert('Cargando mensaje...', 'info');
            
            // Obtener información del mensaje para abrir la conversación
            fetch(`/atencion-cliente/mensajes/${messageId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 404) {
                        throw new Error('Mensaje no encontrado. Es posible que no tengas permisos para ver este mensaje.');
                    } else if (response.status === 401) {
                        throw new Error('No estás autenticado. Por favor, inicia sesión nuevamente.');
                    } else {
                        throw new Error(`Error del servidor: ${response.status}`);
                    }
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                
                if (data.conversation_id) {
                    showConversationModal(data.conversation_id, messageId);
                } else {
                    // Fallback al detalle simple si no hay conversation_id
                    document.getElementById('detailSubject').textContent = data.asunto || 'Sin asunto';
                    document.getElementById('detailContent').textContent = data.mensaje || 'Sin contenido';
                    
                    const meta = document.getElementById('detailMeta');
                    meta.innerHTML = `
                        <span class="priority-badge priority-${data.prioridad || 'normal'}">${(data.prioridad || 'normal').charAt(0).toUpperCase() + (data.prioridad || 'normal').slice(1)}</span>
                        <span class="status-badge status-${data.estado || 'enviado'}">${(data.estado || 'enviado').charAt(0).toUpperCase() + (data.estado || 'enviado').slice(1)}</span>
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
                }
            })
            .catch(error => {
                console.error('Error al cargar el mensaje:', error);
                showAlert(`Error al cargar el mensaje: ${error.message}`, 'error');
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
            const originalText = submitBtn.innerHTML;
            
            // Validar campos requeridos
            const asunto = formData.get('asunto');
            const mensaje = formData.get('mensaje');
            const prioridad = formData.get('prioridad');
            
            if (!asunto || !mensaje || !prioridad) {
                showAlert('Por favor, completa todos los campos requeridos', 'error');
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Enviando...';
            
            fetch('/atencion-cliente/mensajes', {
                method: 'POST',
                body: formData,
                headers: {
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
                    showAlert(data.message || 'Mensaje enviado correctamente', 'success');
                    this.reset();
                    document.getElementById('messageForm').style.display = 'none';
                    // Refrescar la lista de mensajes después de un breve delay
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert(data.message || 'Error al enviar el mensaje', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error de conexión. Por favor, intenta nuevamente.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
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
            
            title.textContent = 'Conversación';
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
            fetch(`/atencion-cliente/conversacion/${conversationId}`)
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
                const isSent = message.sender_type === 'cliente';
                const messageElement = document.createElement('div');
                messageElement.className = `message-bubble ${isSent ? 'sent' : 'received'}`;
                
                const time = new Date(message.created_at).toLocaleTimeString('es-ES', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                messageElement.innerHTML = `
                    <div class="message-avatar">${isSent ? '👤' : '👨‍💼'}</div>
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
            
            fetch(`/atencion-cliente/mensajes/${currentMessageId}/responder`, {
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

        // (Eliminado botón de "Probar Autenticación")
    </script>
</body>
</html>
