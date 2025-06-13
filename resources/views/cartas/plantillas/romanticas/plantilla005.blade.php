<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Corazones al Viento</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      margin: 0; padding: 0;
      overflow: hidden; height: 100vh;
      background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
      font-family: 'Dancing Script', cursive;
      color: #333;
    }
    .balloon {
      position: absolute; bottom: -80px;
      width: 40px; height: 60px;
      pointer-events: none;
      transform-origin: center bottom;
      /* sube solo una vez */
      animation: floatUp var(--duration) ease-in-out var(--delay) forwards;
    }
    .balloon .heart {
      position: absolute; top: 0; left: 0;
      width: 40px; height: 40px;
      background: #ff6b81; transform: rotate(45deg);
      border-radius: 50% 50% 0 0;
    }
    .balloon .heart::before,
    .balloon .heart::after {
      content: '';
      position: absolute; width: 40px; height: 40px;
      background: #ff6b81; border-radius: 50%;
    }
    .balloon .heart::before { top: -20px; left: 0; }
    .balloon .heart::after  { top: 0;  left: -20px;}
    .balloon .string {
      position: absolute; top: 40px; left: 19px;
      width: 2px; height: 60px; background: #aaa;
    }

    @keyframes floatUp {
      0%   { transform: translateY(0) translateX(0) scale(0.8); opacity: 0; }
      10%  { opacity: 1; }
      100% { transform: translateY(-120vh) translateX(var(--drift)) scale(1); opacity:1; }
    }

    /* Clase que dispara el “pop” */
    .balloon.pop {
      animation: pop 0.5s ease-out forwards !important;
    }
    @keyframes pop {
      to { transform: scale(2) !important; opacity: 0 !important; }
    }

    /* Mensaje final */
    .message {
      position: absolute; top:50%; left:50%;
      transform: translate(-50%,-50%);
      font-size:2rem; text-align:center;
      opacity:0;
    }
    .message.show {
      animation: fadeIn 1.5s forwards;
    }
    @keyframes fadeIn { to { opacity:1; } }

    .message span {
      opacity:0; display:inline-block;
      animation: letterIn 0.5s forwards;
    }
    @keyframes letterIn {
      from { opacity:0; transform:translateY(20px); }
      to   { opacity:1; transform:translateY(0); }
    }
  </style>
</head>
<body>

  <div class="message" id="msg"></div>

  <script>
    const TOTAL = 20;
    let popped = 0;
    const msg = document.getElementById('msg');

    for (let i = 0; i < TOTAL; i++) {
      const b = document.createElement('div');
      b.className = 'balloon';

      // valores aleatorios
      const delay    = Math.random() * 4;         // s
      const duration = Math.random() * 6 + 6;     // s
      b.style.left         = Math.random() * 100 + 'vw';
      b.style.setProperty('--delay',    delay   + 's');
      b.style.setProperty('--duration', duration+ 's');
      b.style.setProperty('--drift',    (Math.random()*40-20)+'vw');
      b.innerHTML = `<div class="heart"></div><div class="string"></div>`;
      document.body.appendChild(b);

      // programamos la explosión a la mitad del recorrido
      const midMs = (delay + duration/2) * 1000;
      setTimeout(() => {
        b.classList.add('pop');
        // tras 0.5s de “pop” lo eliminamos y contamos
        setTimeout(() => {
          b.remove();
          popped++;
          if (popped === TOTAL) showMessage();
        }, 500);
      }, midMs);
    }

    function showMessage() {
      const text = "Tu mensaje aqui.";
      for (let i = 0; i < text.length; i++) {
        const ch = text[i];
        if (ch === ' ') msg.appendChild(document.createTextNode(' '));
        else {
          const span = document.createElement('span');
          span.textContent = ch;
          span.style.animationDelay = (i * 0.05) + 's';
          msg.appendChild(span);
        }
      }
      msg.classList.add('show');
    }
  </script>

</body>
</html>
