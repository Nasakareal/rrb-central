<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Te Amo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    /* reset y fondo */
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      background: #111;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      overflow: hidden;
      font-family: sans-serif;
    }

    /* Contenedor de la carta voladora */
    .envelope-container {
      position: relative;
      animation: flyIn 2s ease-out forwards;
      animation-delay: 0.5s;
    }

    /* Cuerpo de la carta (rectángulo blanco) */
    .envelope {
      position: relative;
      width: 220px;
      height: 130px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.3);
      overflow: hidden;
    }
    /* Solapa superior (triángulo) */
    .envelope::before {
      content:"";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: #fff;
      clip-path: polygon(0 0, 100% 0, 50% 60%);
    }

    /* Corazón en el centro */
    .envelope .heart {
      position: absolute;
      top: 50%; left: 50%;
      width: 40px; height: 40px;
      background: red;
      transform: translate(-50%,-50%) rotate(-45deg);
    }
    .envelope .heart::before,
    .envelope .heart::after {
      content:"";
      position: absolute;
      width: 40px; height: 40px;
      background: red;
      border-radius: 50%;
    }
    .envelope .heart::before { top: -20px; left: 0; }
    .envelope .heart::after  { left: 20px; top: 0; }

    /* Alas */
    .wings {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
    }
    .wing {
      width: 50px; height: 30px;
      background: #fff;
      clip-path: polygon(50% 0%,100% 50%,50% 100%,0% 50%);
      transform-origin: 50% 100%;
      animation: flap 0.8s ease-in-out infinite;
    }
    .wing.right { transform: scaleX(-1); }

    /* Animación alas */
    @keyframes flap {
      0%,100% { transform: rotate(0deg); }
      50%     { transform: rotate(20deg); }
    }

    /* Animación de entrada volando */
    @keyframes flyIn {
      0%   { transform: translateY(-300px) scale(0.5) rotate(-15deg); opacity: 0; }
      60%  { transform: translateY(20px)  scale(1.1) rotate(5deg);  opacity: 1; }
      100% { transform: translateY(0)      scale(1)   rotate(0deg);  opacity: 1; }
    }

    /* Mensaje debajo */
    .message {
      margin-top: 40px;
      max-width: 360px;
      background: #fff;
      color: #111;
      padding: 1.2rem;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      opacity: 0;
      animation: fadeIn 1s ease-out forwards;
      animation-delay: 3s;
    }
    @keyframes fadeIn {
      to { opacity: 1; }
    }
    .message p {
      font-size: 1.1rem;
      line-height: 1.4;
    }
    .message .author {
      margin-top: 0.8rem;
      font-size: 0.9rem;
      color: #555;
    }
  </style>
</head>
<body>

  <div class="envelope-container">
    <div class="envelope">
      <div class="wings">
        <div class="wing"></div>
        <div class="wing right"></div>
      </div>
      <div class="heart"></div>
    </div>
  </div>

  <div class="message">
    <p>Tu mensaje aqui.</p>
    <div class="author">— RRB-Soluciones</div>
  </div>

</body>
</html>
