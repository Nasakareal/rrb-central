<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tu Amor Eterno</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    /* Fondo crepuscular */
    body {
      margin: 0;
      padding: 0;
      overflow: hidden;
      height: 100vh;
      background: radial-gradient(circle at bottom, #2b5876 0%, #4e4376 100%);
      color: #fff;
      font-family: 'cursive';
    }

    /* Pétalos flotantes */
    .petal {
      position: absolute;
      top: -20px;
      width: 15px;
      height: 20px;
      background: #e27ea6;
      border-radius: 60% 40% 60% 40%;
      opacity: 0.8;
      animation: fall linear infinite;
    }
    @keyframes fall {
      0% {
        transform: translateX(0) rotate(0deg);
        opacity: 0.8;
      }
      100% {
        transform: translate(calc(var(--dx) * 1vw), 110vh) rotate(360deg);
        opacity: 0;
      }
    }

    /* Mensaje central con efecto máquina de escribir */
    .message {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
    }
    .text {
      font-size: 2rem;
      white-space: nowrap;
      overflow: hidden;
      border-right: .1em solid #fff;
      width: 0;
      animation:
        typing 4s steps(40) forwards 3s,
        blink-caret .7s step-end infinite 7s;
    }
    @keyframes typing {
      to { width: 100%; }
    }
    @keyframes blink-caret {
      50% { border-color: transparent; }
    }

    /* Autor aparece al final */
    .author {
      margin-top: 1rem;
      font-size: 1rem;
      opacity: 0;
      animation: fadeIn 2s forwards 7s;
    }
    @keyframes fadeIn {
      to { opacity: 1; }
    }
  </style>
</head>
<body>

  <div class="message">
    <div class="text">Cada latido de mi corazón susurra tu nombre y acaricia tu alma.</div>
    <div class="author">— Tu amor eterno</div>
  </div>

  <script>
    // Genera 40 pétalos con desplazamiento y tiempos aleatorios
    for (let i = 0; i < 40; i++) {
      const p = document.createElement('div');
      p.classList.add('petal');
      // desplazamiento horizontal en vw (-50 a +50)
      p.style.setProperty('--dx', (Math.random() * 100 - 50).toFixed(2));
      p.style.left = Math.random() * 100 + 'vw';
      p.style.animationDuration = (Math.random() * 5 + 5).toFixed(2) + 's';
      p.style.animationDelay = (Math.random() * 3).toFixed(2) + 's';
      document.body.appendChild(p);
    }
  </script>

</body>
</html>
