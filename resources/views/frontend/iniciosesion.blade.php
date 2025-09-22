<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TECHNOVA - Iniciar sesión</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/estilos.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/stilotech.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/color-palette.css') }}" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }

    .auth-container {
      flex: 1;
      position: relative;
      width: 100%;
      max-width: 1400px;
      padding: 40px 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
    }

    .form-wrapper {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      padding: 30px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      position: relative;
      z-index: 10;
      max-height: 90vh;
      overflow-y: auto;
    }

    .form-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 15px;
      box-shadow: 0 6px 24px rgba(102, 126, 234, 0.3);
    }

    .logo i {
      font-size: 24px;
      color: white;
    }

    .form-title {
      font-size: 24px;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 6px;
    }

    .form-subtitle {
      color: #718096;
      font-size: 16px;
    }

    .form-group {
      margin-bottom: 16px;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      color: #4a5568;
      font-weight: 600;
      font-size: 13px;
    }

    .input-wrapper {
      position: relative;
    }

    .form-group input {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 10px;
      font-size: 14px;
      transition: all 0.3s ease;
      background: #f8fafc;
    }

    .form-group input:focus {
      outline: none;
      border-color: #667eea;
      background: white;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .input-icon {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #a0aec0;
      font-size: 20px;
    }

    .form-group input:focus + .input-icon {
      color: #667eea;
    }

    .error-message {
      color: #e53e3e;
      font-size: 14px;
      margin-top: 6px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .error-message i {
      font-size: 16px;
    }

    .login-btn {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 8px;
      position: relative;
      overflow: hidden;
    }

    .login-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
    }

    .login-btn:active {
      transform: translateY(0);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 30px 0;
      color: #a0aec0;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e2e8f0;
    }

    .divider span {
      padding: 0 20px;
      font-size: 14px;
    }

    .register-link {
      text-align: center;
      margin-top: 20px;
    }

    .register-link a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .register-link a:hover {
      color: #764ba2;
    }

    /* Decoraciones flotantes */
    .floating-shape {
      position: absolute;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
      animation: float 6s ease-in-out infinite;
    }

    .shape-1 {
      width: 80px;
      height: 80px;
      top: 10%;
      left: 10%;
      animation-delay: 0s;
    }

    .shape-2 {
      width: 120px;
      height: 120px;
      top: 20%;
      right: 15%;
      animation-delay: 2s;
    }

    .shape-3 {
      width: 60px;
      height: 60px;
      bottom: 20%;
      left: 20%;
      animation-delay: 4s;
    }

    .shape-4 {
      width: 100px;
      height: 100px;
      bottom: 10%;
      right: 10%;
      animation-delay: 1s;
    }

    .shape-5 {
      width: 40px;
      height: 40px;
      top: 50%;
      left: 5%;
      animation-delay: 3s;
    }

    .shape-6 {
      width: 70px;
      height: 70px;
      top: 60%;
      right: 5%;
      animation-delay: 5s;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0px) rotate(0deg);
      }
      50% {
        transform: translateY(-20px) rotate(180deg);
      }
    }

    /* Responsive */
    @media (max-width: 768px) {
      .form-wrapper {
        margin: 20px;
        padding: 30px 20px;
      }

      .form-title {
        font-size: 24px;
      }

      .floating-shape {
        display: none;
      }
    }

    /* Animación de entrada */
    .form-wrapper {
      animation: slideInUp 0.6s ease-out;
    }

    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Animaciones 3D para dispositivos */
    .device-animations {
      position: absolute;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 1;
    }

    .device-3d {
      position: absolute;
      perspective: 1000px;
      transform-style: preserve-3d;
    }

    .laptop-3d {
      top: 50%;
      left: 5%;
      transform: translateY(-50%);
      animation: laptopFloat 8s ease-in-out infinite, laptopRotate 12s linear infinite;
    }

    .laptop-screen {
      font-size: 3em;
      transform: rotateX(15deg) rotateY(-10deg);
      animation: screenGlow 3s ease-in-out infinite;
      filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.6));
    }

    .laptop-base {
      width: 60px;
      height: 8px;
      background: linear-gradient(45deg, #667eea, #764ba2);
      border-radius: 4px;
      transform: rotateX(15deg) rotateY(-10deg) translateZ(-10px);
      box-shadow: 0 0 20px rgba(102, 126, 234, 0.4);
    }

    .phone-3d {
      top: 50%;
      right: 5%;
      transform: translateY(-50%);
      animation: phoneFloat 6s ease-in-out infinite, phoneRotate 10s linear infinite;
    }

    .phone-screen {
      font-size: 2.5em;
      transform: rotateX(20deg) rotateY(15deg);
      animation: phoneGlow 4s ease-in-out infinite;
      filter: drop-shadow(0 0 15px rgba(139, 92, 246, 0.6));
    }

    .phone-body {
      width: 30px;
      height: 50px;
      background: linear-gradient(45deg, #667eea, #764ba2);
      border-radius: 8px;
      transform: rotateX(20deg) rotateY(15deg) translateZ(-5px);
      box-shadow: 0 0 15px rgba(139, 92, 246, 0.4);
    }

    .tablet-3d {
      top: 20%;
      left: 50%;
      transform: translateX(-50%);
      animation: tabletFloat 7s ease-in-out infinite, tabletRotate 14s linear infinite;
    }

    .tablet-screen {
      font-size: 2.8em;
      transform: rotateX(-10deg) rotateY(-20deg);
      animation: tabletGlow 5s ease-in-out infinite;
      filter: drop-shadow(0 0 18px rgba(16, 185, 129, 0.6));
    }

    .tablet-body {
      width: 50px;
      height: 35px;
      background: linear-gradient(45deg, #10b981, #059669);
      border-radius: 6px;
      transform: rotateX(-10deg) rotateY(-20deg) translateZ(-8px);
      box-shadow: 0 0 18px rgba(16, 185, 129, 0.4);
    }

    /* Dispositivos adicionales */
    .smartwatch-3d {
      top: 15%;
      right: 20%;
      animation: smartwatchFloat 5s ease-in-out infinite, smartwatchRotate 8s linear infinite;
    }

    .smartwatch-screen {
      font-size: 2em;
      transform: rotateX(25deg) rotateY(20deg);
      animation: smartwatchGlow 3.5s ease-in-out infinite;
      filter: drop-shadow(0 0 12px rgba(255, 165, 0, 0.6));
    }

    .smartwatch-band {
      width: 20px;
      height: 30px;
      background: linear-gradient(45deg, #ff6b6b, #ee5a24);
      border-radius: 10px;
      transform: rotateX(25deg) rotateY(20deg) translateZ(-3px);
      box-shadow: 0 0 12px rgba(255, 107, 107, 0.4);
    }

    .headphones-3d {
      bottom: 30%;
      right: 15%;
      animation: headphonesFloat 6.5s ease-in-out infinite, headphonesRotate 11s linear infinite;
    }

    .headphones-icon {
      font-size: 2.2em;
      transform: rotateX(15deg) rotateY(-25deg);
      animation: headphonesGlow 4.5s ease-in-out infinite;
      filter: drop-shadow(0 0 16px rgba(155, 89, 182, 0.6));
    }

    .headphones-band {
      width: 40px;
      height: 8px;
      background: linear-gradient(45deg, #9b59b6, #8e44ad);
      border-radius: 4px;
      transform: rotateX(15deg) rotateY(-25deg) translateZ(-6px);
      box-shadow: 0 0 16px rgba(155, 89, 182, 0.4);
    }

    .camera-3d {
      top: 60%;
      left: 10%;
      animation: cameraFloat 7.5s ease-in-out infinite, cameraRotate 13s linear infinite;
    }

    .camera-icon {
      font-size: 2.3em;
      transform: rotateX(-15deg) rotateY(30deg);
      animation: cameraGlow 3.8s ease-in-out infinite;
      filter: drop-shadow(0 0 14px rgba(52, 152, 219, 0.6));
    }

    .camera-body {
      width: 35px;
      height: 25px;
      background: linear-gradient(45deg, #3498db, #2980b9);
      border-radius: 8px;
      transform: rotateX(-15deg) rotateY(30deg) translateZ(-7px);
      box-shadow: 0 0 14px rgba(52, 152, 219, 0.4);
    }

    .keyboard-3d {
      bottom: 15%;
      left: 25%;
      animation: keyboardFloat 8.5s ease-in-out infinite, keyboardRotate 15s linear infinite;
    }

    .keyboard-icon {
      font-size: 2.1em;
      transform: rotateX(20deg) rotateY(-15deg);
      animation: keyboardGlow 4.2s ease-in-out infinite;
      filter: drop-shadow(0 0 13px rgba(46, 204, 113, 0.6));
    }

    .keyboard-base {
      width: 60px;
      height: 12px;
      background: linear-gradient(45deg, #2ecc71, #27ae60);
      border-radius: 6px;
      transform: rotateX(20deg) rotateY(-15deg) translateZ(-9px);
      box-shadow: 0 0 13px rgba(46, 204, 113, 0.4);
    }

    .mouse-3d {
      top: 70%;
      right: 25%;
      animation: mouseFloat 6s ease-in-out infinite, mouseRotate 9s linear infinite;
    }

    .mouse-icon {
      font-size: 1.8em;
      transform: rotateX(10deg) rotateY(25deg);
      animation: mouseGlow 3.2s ease-in-out infinite;
      filter: drop-shadow(0 0 11px rgba(230, 126, 34, 0.6));
    }

    .mouse-body {
      width: 25px;
      height: 15px;
      background: linear-gradient(45deg, #e67e22, #d35400);
      border-radius: 12px;
      transform: rotateX(10deg) rotateY(25deg) translateZ(-4px);
      box-shadow: 0 0 11px rgba(230, 126, 34, 0.4);
    }

    .monitor-3d {
      top: 10%;
      left: 30%;
      animation: monitorFloat 9s ease-in-out infinite, monitorRotate 16s linear infinite;
    }

    .monitor-screen {
      font-size: 2.4em;
      transform: rotateX(-5deg) rotateY(10deg);
      animation: monitorGlow 4.8s ease-in-out infinite;
      filter: drop-shadow(0 0 17px rgba(142, 68, 173, 0.6));
    }

    .monitor-stand {
      width: 45px;
      height: 10px;
      background: linear-gradient(45deg, #8e44ad, #9b59b6);
      border-radius: 5px;
      transform: rotateX(-5deg) rotateY(10deg) translateZ(-12px);
      box-shadow: 0 0 17px rgba(142, 68, 173, 0.4);
    }

    /* Nuevos elementos dinámicos */
    .drone-3d {
      top: 35%;
      left: 20%;
      animation: droneFloat 4s ease-in-out infinite, droneRotate 6s linear infinite;
    }

    .drone-icon {
      font-size: 2.5em;
      transform: rotateX(10deg) rotateY(-15deg);
      animation: droneGlow 2.5s ease-in-out infinite;
      filter: drop-shadow(0 0 20px rgba(255, 193, 7, 0.8));
    }

    .drone-propellers {
      position: absolute;
      top: -10px;
      left: 50%;
      transform: translateX(-50%);
    }

    .propeller {
      position: absolute;
      width: 8px;
      height: 8px;
      background: radial-gradient(circle, #ffc107, #ff8f00);
      border-radius: 50%;
      animation: propellerSpin 0.1s linear infinite;
    }

    .prop-1 { top: -5px; left: -15px; }
    .prop-2 { top: -5px; right: -15px; }
    .prop-3 { bottom: -5px; left: -15px; }
    .prop-4 { bottom: -5px; right: -15px; }

    .robot-3d {
      bottom: 40%;
      right: 30%;
      animation: robotFloat 5.5s ease-in-out infinite, robotRotate 7s linear infinite;
    }

    .robot-icon {
      font-size: 2.2em;
      transform: rotateX(15deg) rotateY(20deg);
      animation: robotGlow 3.8s ease-in-out infinite;
      filter: drop-shadow(0 0 18px rgba(0, 150, 136, 0.8));
    }

    .robot-antenna {
      width: 3px;
      height: 20px;
      background: linear-gradient(45deg, #009688, #4db6ac);
      border-radius: 2px;
      transform: rotateX(15deg) rotateY(20deg) translateZ(5px);
      animation: antennaWave 2s ease-in-out infinite;
    }

    .vr-3d {
      top: 45%;
      right: 8%;
      animation: vrFloat 6.2s ease-in-out infinite, vrRotate 8.5s linear infinite;
    }

    .vr-icon {
      font-size: 2.3em;
      transform: rotateX(-20deg) rotateY(25deg);
      animation: vrGlow 4.2s ease-in-out infinite;
      filter: drop-shadow(0 0 19px rgba(156, 39, 176, 0.8));
    }

    .vr-strap {
      width: 30px;
      height: 6px;
      background: linear-gradient(45deg, #9c27b0, #ba68c8);
      border-radius: 3px;
      transform: rotateX(-20deg) rotateY(25deg) translateZ(-8px);
      box-shadow: 0 0 19px rgba(156, 39, 176, 0.4);
    }

    .gamepad-3d {
      bottom: 25%;
      left: 35%;
      animation: gamepadFloat 7.8s ease-in-out infinite, gamepadRotate 9.2s linear infinite;
    }

    .gamepad-icon {
      font-size: 2.1em;
      transform: rotateX(25deg) rotateY(-30deg);
      animation: gamepadGlow 3.6s ease-in-out infinite;
      filter: drop-shadow(0 0 16px rgba(255, 87, 34, 0.8));
    }

    .gamepad-buttons {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .button {
      position: absolute;
      width: 6px;
      height: 6px;
      background: linear-gradient(45deg, #ff5722, #ff7043);
      border-radius: 50%;
      animation: buttonBlink 1.5s ease-in-out infinite;
    }

    .btn-1 { top: -8px; left: -8px; }
    .btn-2 { top: -8px; right: -8px; }

    /* Partículas flotantes */
    .particle {
      position: absolute;
      font-size: 1.5em;
      pointer-events: none;
      animation: particleFloat 8s ease-in-out infinite;
    }

    .particle-1 {
      top: 10%;
      left: 15%;
      animation-delay: 0s;
      animation: particleFloat 8s ease-in-out infinite, particleGlow 3s ease-in-out infinite;
    }

    .particle-2 {
      top: 20%;
      right: 20%;
      animation-delay: 1s;
      animation: particleFloat 9s ease-in-out infinite, particleGlow 3.5s ease-in-out infinite;
    }

    .particle-3 {
      top: 60%;
      left: 25%;
      animation-delay: 2s;
      animation: particleFloat 7s ease-in-out infinite, particleGlow 2.8s ease-in-out infinite;
    }

    .particle-4 {
      top: 70%;
      right: 15%;
      animation-delay: 3s;
      animation: particleFloat 10s ease-in-out infinite, particleGlow 4s ease-in-out infinite;
    }

    .particle-5 {
      top: 40%;
      left: 5%;
      animation-delay: 4s;
      animation: particleFloat 6s ease-in-out infinite, particleGlow 2.5s ease-in-out infinite;
    }

    .particle-6 {
      top: 80%;
      right: 35%;
      animation-delay: 5s;
      animation: particleFloat 11s ease-in-out infinite, particleGlow 4.5s ease-in-out infinite;
    }

    /* Animaciones de flotación */
    @keyframes laptopFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-20px) rotateZ(5deg); }
    }

    @keyframes phoneFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-15px) rotateZ(-3deg); }
    }

    @keyframes tabletFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-25px) rotateZ(4deg); }
    }

    @keyframes smartwatchFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-12px) rotateZ(-2deg); }
    }

    @keyframes headphonesFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-18px) rotateZ(3deg); }
    }

    @keyframes cameraFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-22px) rotateZ(-4deg); }
    }

    @keyframes keyboardFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-16px) rotateZ(2deg); }
    }

    @keyframes mouseFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-14px) rotateZ(-1deg); }
    }

    @keyframes monitorFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-28px) rotateZ(6deg); }
    }

    @keyframes droneFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-30px) rotateZ(8deg); }
    }

    @keyframes robotFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-22px) rotateZ(-5deg); }
    }

    @keyframes vrFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-26px) rotateZ(7deg); }
    }

    @keyframes gamepadFloat {
      0%, 100% { transform: translateY(0px) rotateZ(0deg); }
      50% { transform: translateY(-24px) rotateZ(-6deg); }
    }

    @keyframes particleFloat {
      0%, 100% { transform: translateY(0px) translateX(0px) rotate(0deg); }
      25% { transform: translateY(-15px) translateX(10px) rotate(90deg); }
      50% { transform: translateY(-30px) translateX(-5px) rotate(180deg); }
      75% { transform: translateY(-15px) translateX(-10px) rotate(270deg); }
    }

    /* Animaciones de rotación 3D */
    @keyframes laptopRotate {
      0% { transform: rotateY(0deg) rotateX(0deg); }
      25% { transform: rotateY(90deg) rotateX(10deg); }
      50% { transform: rotateY(180deg) rotateX(0deg); }
      75% { transform: rotateY(270deg) rotateX(-10deg); }
      100% { transform: rotateY(360deg) rotateX(0deg); }
    }

    @keyframes phoneRotate {
      0% { transform: rotateX(0deg) rotateZ(0deg); }
      25% { transform: rotateX(90deg) rotateZ(10deg); }
      50% { transform: rotateX(180deg) rotateZ(0deg); }
      75% { transform: rotateX(270deg) rotateZ(-10deg); }
      100% { transform: rotateX(360deg) rotateZ(0deg); }
    }

    @keyframes tabletRotate {
      0% { transform: rotateY(0deg) rotateZ(0deg); }
      33% { transform: rotateY(120deg) rotateZ(15deg); }
      66% { transform: rotateY(240deg) rotateZ(-15deg); }
      100% { transform: rotateY(360deg) rotateZ(0deg); }
    }

    @keyframes smartwatchRotate {
      0% { transform: rotateX(0deg) rotateZ(0deg); }
      25% { transform: rotateX(90deg) rotateZ(15deg); }
      50% { transform: rotateX(180deg) rotateZ(0deg); }
      75% { transform: rotateX(270deg) rotateZ(-15deg); }
      100% { transform: rotateX(360deg) rotateZ(0deg); }
    }

    @keyframes headphonesRotate {
      0% { transform: rotateY(0deg) rotateX(0deg); }
      20% { transform: rotateY(72deg) rotateX(20deg); }
      40% { transform: rotateY(144deg) rotateX(0deg); }
      60% { transform: rotateY(216deg) rotateX(-20deg); }
      80% { transform: rotateY(288deg) rotateX(0deg); }
      100% { transform: rotateY(360deg) rotateX(0deg); }
    }

    @keyframes cameraRotate {
      0% { transform: rotateZ(0deg) rotateY(0deg); }
      30% { transform: rotateZ(108deg) rotateY(30deg); }
      60% { transform: rotateZ(216deg) rotateY(0deg); }
      90% { transform: rotateZ(324deg) rotateY(-30deg); }
      100% { transform: rotateZ(360deg) rotateY(0deg); }
    }

    @keyframes keyboardRotate {
      0% { transform: rotateX(0deg) rotateY(0deg); }
      25% { transform: rotateX(90deg) rotateY(25deg); }
      50% { transform: rotateX(180deg) rotateY(0deg); }
      75% { transform: rotateX(270deg) rotateY(-25deg); }
      100% { transform: rotateX(360deg) rotateY(0deg); }
    }

    @keyframes mouseRotate {
      0% { transform: rotateY(0deg) rotateZ(0deg); }
      50% { transform: rotateY(180deg) rotateZ(180deg); }
      100% { transform: rotateY(360deg) rotateZ(360deg); }
    }

    @keyframes monitorRotate {
      0% { transform: rotateY(0deg) rotateX(0deg); }
      16% { transform: rotateY(60deg) rotateX(15deg); }
      32% { transform: rotateY(120deg) rotateX(0deg); }
      48% { transform: rotateY(180deg) rotateX(-15deg); }
      64% { transform: rotateY(240deg) rotateX(0deg); }
      80% { transform: rotateY(300deg) rotateX(15deg); }
      100% { transform: rotateY(360deg) rotateX(0deg); }
    }

    @keyframes droneRotate {
      0% { transform: rotateY(0deg) rotateZ(0deg); }
      25% { transform: rotateY(90deg) rotateZ(15deg); }
      50% { transform: rotateY(180deg) rotateZ(0deg); }
      75% { transform: rotateY(270deg) rotateZ(-15deg); }
      100% { transform: rotateY(360deg) rotateZ(0deg); }
    }

    @keyframes robotRotate {
      0% { transform: rotateX(0deg) rotateY(0deg); }
      33% { transform: rotateX(120deg) rotateY(30deg); }
      66% { transform: rotateX(240deg) rotateY(0deg); }
      100% { transform: rotateX(360deg) rotateY(0deg); }
    }

    @keyframes vrRotate {
      0% { transform: rotateZ(0deg) rotateX(0deg); }
      20% { transform: rotateZ(72deg) rotateX(20deg); }
      40% { transform: rotateZ(144deg) rotateX(0deg); }
      60% { transform: rotateZ(216deg) rotateX(-20deg); }
      80% { transform: rotateZ(288deg) rotateX(0deg); }
      100% { transform: rotateZ(360deg) rotateX(0deg); }
    }

    @keyframes gamepadRotate {
      0% { transform: rotateY(0deg) rotateX(0deg); }
      25% { transform: rotateY(90deg) rotateX(25deg); }
      50% { transform: rotateY(180deg) rotateX(0deg); }
      75% { transform: rotateY(270deg) rotateX(-25deg); }
      100% { transform: rotateY(360deg) rotateX(0deg); }
    }

    /* Animaciones especiales */
    @keyframes propellerSpin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @keyframes antennaWave {
      0%, 100% { transform: rotateX(15deg) rotateY(20deg) translateZ(5px) rotateZ(0deg); }
      50% { transform: rotateX(15deg) rotateY(20deg) translateZ(5px) rotateZ(15deg); }
    }

    @keyframes buttonBlink {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.3; transform: scale(0.8); }
    }

    /* Efectos de brillo */
    @keyframes screenGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.6));
        text-shadow: 0 0 20px rgba(0, 212, 255, 0.8);
      }
      50% { 
        filter: drop-shadow(0 0 30px rgba(0, 212, 255, 0.9));
        text-shadow: 0 0 30px rgba(0, 212, 255, 1);
      }
    }

    @keyframes phoneGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 15px rgba(139, 92, 246, 0.6));
        text-shadow: 0 0 15px rgba(139, 92, 246, 0.8);
      }
      50% { 
        filter: drop-shadow(0 0 25px rgba(139, 92, 246, 0.9));
        text-shadow: 0 0 25px rgba(139, 92, 246, 1);
      }
    }

    @keyframes tabletGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 18px rgba(16, 185, 129, 0.6));
        text-shadow: 0 0 18px rgba(16, 185, 129, 0.8);
      }
      50% { 
        filter: drop-shadow(0 0 28px rgba(16, 185, 129, 0.9));
        text-shadow: 0 0 28px rgba(16, 185, 129, 1);
      }
    }

    @keyframes smartwatchGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 12px rgba(255, 165, 0, 0.6));
        text-shadow: 0 0 12px rgba(255, 165, 0, 0.8);
      }
      50% { 
        filter: drop-shadow(0 0 22px rgba(255, 165, 0, 0.9));
        text-shadow: 0 0 22px rgba(255, 165, 0, 1);
      }
    }

    @keyframes headphonesGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 16px rgba(155, 89, 182, 0.6));
        text-shadow: 0 0 16px rgba(155, 89, 182, 0.8);
      }
      50% { 
        filter: drop-shadow(0 0 26px rgba(155, 89, 182, 0.9));
        text-shadow: 0 0 26px rgba(155, 89, 182, 1);
      }
    }

    @keyframes cameraGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 14px rgba(52, 152, 219, 0.6));
        text-shadow: 0 0 14px rgba(52, 152, 219, 0.8);
      }
      50% { 
        filter: drop-shadow(0 0 24px rgba(52, 152, 219, 0.9));
        text-shadow: 0 0 24px rgba(52, 152, 219, 1);
      }
    }

    @keyframes keyboardGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 13px rgba(46, 204, 113, 0.6));
        text-shadow: 0 0 13px rgba(46, 204, 113, 0.8);
      }
      50% { 
        filter: drop-shadow(0 0 23px rgba(46, 204, 113, 0.9));
        text-shadow: 0 0 23px rgba(46, 204, 113, 1);
      }
    }

    @keyframes mouseGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 11px rgba(230, 126, 34, 0.6));
        text-shadow: 0 0 11px rgba(230, 126, 34, 0.8);
      }
      50% { 
        filter: drop-shadow(0 0 21px rgba(230, 126, 34, 0.9));
        text-shadow: 0 0 21px rgba(230, 126, 34, 1);
      }
    }

    @keyframes monitorGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 17px rgba(142, 68, 173, 0.6));
        text-shadow: 0 0 17px rgba(142, 68, 173, 0.8);
      }
      50% { 
        filter: drop-shadow(0 0 27px rgba(142, 68, 173, 0.9));
        text-shadow: 0 0 27px rgba(142, 68, 173, 1);
      }
    }

    @keyframes droneGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 20px rgba(255, 193, 7, 0.8));
        text-shadow: 0 0 20px rgba(255, 193, 7, 1);
      }
      50% { 
        filter: drop-shadow(0 0 30px rgba(255, 193, 7, 1));
        text-shadow: 0 0 30px rgba(255, 193, 7, 1);
      }
    }

    @keyframes robotGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 18px rgba(0, 150, 136, 0.8));
        text-shadow: 0 0 18px rgba(0, 150, 136, 1);
      }
      50% { 
        filter: drop-shadow(0 0 28px rgba(0, 150, 136, 1));
        text-shadow: 0 0 28px rgba(0, 150, 136, 1);
      }
    }

    @keyframes vrGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 19px rgba(156, 39, 176, 0.8));
        text-shadow: 0 0 19px rgba(156, 39, 176, 1);
      }
      50% { 
        filter: drop-shadow(0 0 29px rgba(156, 39, 176, 1));
        text-shadow: 0 0 29px rgba(156, 39, 176, 1);
      }
    }

    @keyframes gamepadGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 16px rgba(255, 87, 34, 0.8));
        text-shadow: 0 0 16px rgba(255, 87, 34, 1);
      }
      50% { 
        filter: drop-shadow(0 0 26px rgba(255, 87, 34, 1));
        text-shadow: 0 0 26px rgba(255, 87, 34, 1);
      }
    }

    @keyframes particleGlow {
      0%, 100% { 
        filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.8));
        text-shadow: 0 0 15px rgba(255, 255, 255, 1);
      }
      50% { 
        filter: drop-shadow(0 0 25px rgba(255, 255, 255, 1));
        text-shadow: 0 0 25px rgba(255, 255, 255, 1);
      }
    }

    /* Header y Footer */
    .header {
      position: relative;
      z-index: 100;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .header .logo {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: white;
      font-weight: bold;
      font-size: 24px;
      margin-left: 0;
    }

    .header .logo img {
      height: 40px;
      margin-right: 10px;
      filter: brightness(1.2) contrast(1.1);
    }

    .header .acciones-usuario {
      display: flex;
      gap: 15px;
    }

    .header .account {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 10px 20px;
      border-radius: 25px;
      text-decoration: none;
      font-weight: 500;
      border: 2px solid rgba(255, 255, 255, 0.2);
      transition: all 0.3s ease;
    }

    .header .account:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      border-color: rgba(255, 255, 255, 0.4);
    }

    footer {
      position: relative;
      z-index: 100;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      text-align: center;
      padding: 20px;
      color: white;
    }

    /* Responsive para animaciones 3D */
    @media (max-width: 768px) {
      .device-animations {
        display: none;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header">
    <a href="{{ route('index') }}" class="logo">
      <img src="{{ asset('frontend/imagenes/logo technova.png') }}" alt="Logo" style="cursor:pointer;">
      <span>TECHNOVA</span>
    </a>

    <div class="acciones-usuario">
      <a href="/iniciosesion" class="account">
        <span>Iniciar Sesión</span>
      </a>
      <a href="/creacioncuenta" class="account">
        <span>Crear Cuenta</span>
      </a>
    </div>
  </header>

  <div class="auth-container">
    <!-- Decoraciones flotantes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    <div class="floating-shape shape-4"></div>
    <div class="floating-shape shape-5"></div>
    <div class="floating-shape shape-6"></div>

    <!-- Animaciones 3D con dispositivos -->
    <div class="device-animations">
      <!-- Laptop principal -->
      <div class="device-3d laptop-3d">
        <div class="laptop-screen">💻</div>
        <div class="laptop-base"></div>
      </div>
      
      <!-- Teléfono principal -->
      <div class="device-3d phone-3d">
        <div class="phone-screen">📱</div>
        <div class="phone-body"></div>
      </div>
      
      <!-- Tablet principal -->
      <div class="device-3d tablet-3d">
        <div class="tablet-screen">📱</div>
        <div class="tablet-body"></div>
      </div>

      <!-- Dispositivos adicionales -->
      <div class="device-3d smartwatch-3d">
        <div class="smartwatch-screen">⌚</div>
        <div class="smartwatch-band"></div>
      </div>

      <div class="device-3d headphones-3d">
        <div class="headphones-icon">🎧</div>
        <div class="headphones-band"></div>
      </div>

      <div class="device-3d camera-3d">
        <div class="camera-icon">📷</div>
        <div class="camera-body"></div>
      </div>

      <div class="device-3d keyboard-3d">
        <div class="keyboard-icon">⌨️</div>
        <div class="keyboard-base"></div>
      </div>

      <div class="device-3d mouse-3d">
        <div class="mouse-icon">🖱️</div>
        <div class="mouse-body"></div>
      </div>

      <div class="device-3d monitor-3d">
        <div class="monitor-screen">🖥️</div>
        <div class="monitor-stand"></div>
      </div>

      <!-- Elementos adicionales con más dinamismo -->
      <div class="device-3d drone-3d">
        <div class="drone-icon">🚁</div>
        <div class="drone-propellers">
          <div class="propeller prop-1"></div>
          <div class="propeller prop-2"></div>
          <div class="propeller prop-3"></div>
          <div class="propeller prop-4"></div>
        </div>
      </div>

      <div class="device-3d robot-3d">
        <div class="robot-icon">🤖</div>
        <div class="robot-antenna"></div>
      </div>

      <div class="device-3d vr-3d">
        <div class="vr-icon">🥽</div>
        <div class="vr-strap"></div>
      </div>

      <div class="device-3d gamepad-3d">
        <div class="gamepad-icon">🎮</div>
        <div class="gamepad-buttons">
          <div class="button btn-1"></div>
          <div class="button btn-2"></div>
        </div>
      </div>

      <!-- Partículas flotantes -->
      <div class="particle particle-1">✨</div>
      <div class="particle particle-2">⭐</div>
      <div class="particle particle-3">💫</div>
      <div class="particle particle-4">🌟</div>
      <div class="particle particle-5">✨</div>
      <div class="particle particle-6">⭐</div>
    </div>

    <div class="form-wrapper">
      <div class="form-header">
        <div class="logo">
          <i class='bx bx-laptop'></i>
        </div>
        <h1 class="form-title">Iniciar Sesión</h1>
        <p class="form-subtitle">Bienvenido de vuelta a TechNova</p>
      </div>

      @if(session('error'))
        <div class="error-message">
          <i class='bx bx-error-circle'></i>
          {{ session('error') }}
        </div>
      @endif

      <form method="POST" action="{{ route('frontend.login.submit') }}">
        @csrf

        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <div class="input-wrapper">
            <input type="email" id="email" name="email" required placeholder="tu@email.com" />
            <i class='bx bx-envelope input-icon'></i>
          </div>
          @error('email')
            <div class="error-message">
              <i class='bx bx-error-circle'></i>
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Contraseña</label>
          <div class="input-wrapper">
            <input type="password" id="password" name="password" required placeholder="Ingresa tu contraseña" />
            <i class='bx bx-lock-alt input-icon'></i>
          </div>
          @error('password')
            <div class="error-message">
              <i class='bx bx-error-circle'></i>
              {{ $message }}
            </div>
          @enderror
        </div>

        <button type="submit" class="login-btn">
          <i class='bx bx-log-in' style="margin-right: 8px;"></i>
          Iniciar Sesión
        </button>
      </form>

      <div class="divider">
        <span>¿No tienes cuenta?</span>
      </div>

          <div class="register-link">
            <a href="/creacioncuenta">
              <i class='bx bx-user-plus' style="margin-right: 6px;"></i>
              Crear Cuenta
            </a>
          </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p>© 2025 TECHNOVA. Todos los derechos reservados.</p>
  </footer>

  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/68632ae6db555c190ce714bb/1iv1lv5no';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();</script>
  <!--End of Tawk.to Script-->
</body>
</html>