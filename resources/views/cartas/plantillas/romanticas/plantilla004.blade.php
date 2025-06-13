<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iluminas mi Cielo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    /* Reset y fondo nocturno */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      overflow: hidden;
      height: 100vh;
      background: radial-gradient(ellipse at bottom, #020024 0%, #090979 60%, #00d4ff 100%);
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
    }

    /* Estrellas parpadeantes */
    .star {
      position: absolute;
      width: 2px; height: 2px;
      background: #fff;
      border-radius: 50%;
      opacity: 0;
      animation: twinkle linear infinite;
    }
    @keyframes twinkle {
      0%,100% { opacity: 0; }
      50%     { opacity: 1; }
    }

    /* Farolillos ascendentes */
    .lantern {
      position: absolute;
      bottom: -60px;
      width: 20px; height: 30px;
      background: radial-gradient(circle at 50% 30%, #ffecb3, #ff9800);
      border-radius: 50% 50% 45% 45%;
      box-shadow: 0 0 12px rgba(255,200,50,0.6);
      animation: rise linear infinite;
    }
    .lantern::before {
      content: '';
      position: absolute;
      top: -6px; left: 8px;
      width: 4px; height: 10px;
      background: #8d6e63;
      border-radius: 2px;
    }
    @keyframes rise {
      0% { transform: translateX(0) translateY(0) scale(0.8); opacity: 0; }
      10% { opacity: 1; }
      100% { transform: translateX(var(--dx)) translateY(-120vh) scale(1); opacity: 0; }
    }

    /* Mensaje con destello en cada letra */
    .message {
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      font-size: 1.5rem;
      text-align: center;
      /* permitimos que los espacios sean visibles */
      white-space: pre-wrap;
    }
    .message span {
      opacity: 0;
      display: inline-block;  /* mantiene el efecto por letra */
      animation: shine 0.6s forwards;
    }
    @keyframes shine {
      0%   { opacity: 0; text-shadow: none; }
      50%  { opacity: 1; text-shadow: 0 0 8px #fff, 0 0 16px #ffdd57; }
      100% { opacity: 1; text-shadow: none; }
    }
  </style>
</head>
<body>

  <div class="message" id="msg"></div>

  <script>
    // 1) Generar estrellas
    for (let i = 0; i < 100; i++) {
      const s = document.createElement('div');
      s.classList.add('star');
      s.style.top   = Math.random() * 100 + 'vh';
      s.style.left  = Math.random() * 100 + 'vw';
      s.style.animationDuration = (Math.random() * 3 + 2) + 's';
      s.style.animationDelay    = Math.random() * 5 + 's';
      document.body.appendChild(s);
    }

    // 2) Generar linternas
    for (let i = 0; i < 20; i++) {
      const l = document.createElement('div');
      l.classList.add('lantern');
      l.style.left             = Math.random() * 100 + 'vw';
      l.style.setProperty('--dx', (Math.random() * 60 - 30) + 'vw');
      l.style.animationDuration = (Math.random() * 8 + 6) + 's';
      l.style.animationDelay    = Math.random() * 5 + 's';
      document.body.appendChild(l);
    }

    // 3) Destello por letra, preservando espacios
    const texto = "Tu mensaje aqui.";
    const cont = document.getElementById('msg');

    for (let i = 0; i < texto.length; i++) {
      const ch = texto[i];
      if (ch === ' ') {
        // inserta un espacio en blanco real
        cont.appendChild(document.createTextNode(' '));
      } else {
        const span = document.createElement('span');
        span.textContent = ch;
        span.style.animationDelay = (i * 0.1 + 2) + 's';
        cont.appendChild(span);
      }
    }
  </script>

</body>
</html>
