<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Amor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    /* Reset y tipografía */
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      background: linear-gradient(135deg, #ff758c, #ff7eb3);
      height: 100vh;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }

    /* Corazones flotantes */
    .heart {
      position: absolute;
      width: 20px; height: 20px;
      background: red;
      transform: rotate(-45deg);
      opacity: 0.8;
      animation: floatUp 6s infinite;
    }
    .heart::before,
    .heart::after {
      content: '';
      position: absolute;
      width: inherit; height: inherit;
      background: red;
      border-radius: 50%;
    }
    .heart::before { top: -10px; }
    .heart::after  { left: 10px; }

    @keyframes floatUp {
      0% { transform: translate(0, 0) rotate(-45deg); opacity: 0.8; }
      50% { opacity: 0.4; }
      100% { transform: translate(calc(-50px + var(--randX)), -600px) rotate(-45deg); opacity: 0; }
    }

    /* Tarjeta central */
    .card {
      position: relative;
      width: 280px;
      height: 160px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      transform: scale(0);
      animation: popIn 1s ease-out forwards 1s;
      overflow: hidden;
    }
    .card::before {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: pink;
      clip-path: polygon(0 0, 100% 0, 100% 50%, 50% 70%, 0 50%);
      transform: translateY(-100%);
      animation: flap 1s ease-out forwards 1.5s;
    }

    @keyframes popIn {
      to { transform: scale(1); }
    }
    @keyframes flap {
      to { transform: translateY(0); }
    }

    /* Mensaje */
    .message {
      position: absolute;
      bottom: 12px;
      left: 12px;
      right: 12px;
      color: #333;
      font-size: 1rem;
      line-height: 1.4;
      opacity: 0;
      animation: textAppear 1s ease-out forwards 2.5s;
    }
    @keyframes textAppear {
      to { opacity: 1; }
    }
    .message .author {
      margin-top: 8px;
      text-align: right;
      font-size: 0.9rem;
      color: #888;
    }
  </style>
</head>
<body>

  <!-- Genera 30 corazones con posiciones y retardos aleatorios -->
  <script>
    for (let i = 0; i < 30; i++) {
      const h = document.createElement('div');
      h.classList.add('heart');
      h.style.left = Math.random() * 100 + 'vw';
      h.style.bottom = -50 + 'px';
      h.style.animationDelay = (Math.random() * 4) + 's';
      h.style.setProperty('--randX', Math.random() * 100 + 'px');
      document.body.appendChild(h);
    }
  </script>

  <div class="card">
    <div class="message">
      <p>
        Tu mensaje aqui.
      </p>
      <div class="author">— Tu enamorado incondicional</div>
    </div>
  </div>

</body>
</html>
