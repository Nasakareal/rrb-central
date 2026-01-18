<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Te Amo</title>
  <style>
    /* =========================
       RESET + BASE
    ========================== */
    * { margin:0; padding:0; box-sizing:border-box; }
    html, body { height:100%; }
    body{
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      color: #eaf2ff;
      background: #05070f;
      overflow: hidden;
    }

    /* =========================
       BACKGROUND: AURORA + STARS
    ========================== */
    .bg {
      position: fixed;
      inset: 0;
      overflow: hidden;
      z-index: 0;
      background:
        radial-gradient(1200px 600px at 50% 120%, rgba(120, 80, 255, 0.18), transparent 60%),
        radial-gradient(900px 500px at 10% 20%, rgba(0, 220, 255, 0.12), transparent 60%),
        radial-gradient(700px 400px at 90% 30%, rgba(255, 80, 180, 0.10), transparent 60%),
        linear-gradient(180deg, #040610 0%, #05070f 55%, #03040b 100%);
    }

    /* Aurora ribbons */
    .aurora {
      position: absolute;
      inset: -30%;
      filter: blur(20px);
      opacity: .9;
      transform: rotate(-8deg);
    }
    .aurora::before,
    .aurora::after{
      content:"";
      position:absolute;
      inset:0;
      background:
        conic-gradient(from 180deg at 50% 50%,
          rgba(0,255,210,.00),
          rgba(0,255,210,.18),
          rgba(160,120,255,.22),
          rgba(255,80,200,.18),
          rgba(0,210,255,.22),
          rgba(0,255,210,.00));
      animation: auroraMove 10s ease-in-out infinite alternate;
      mix-blend-mode: screen;
    }
    .aurora::after{
      opacity: .7;
      transform: scale(1.15) rotate(12deg);
      animation-duration: 14s;
    }

    @keyframes auroraMove{
      0%   { transform: translate(-2%, -1%) scale(1.02) rotate(0deg); }
      100% { transform: translate(2%,  1%) scale(1.08) rotate(10deg); }
    }

    /* Stars using multiple radial gradients */
    .stars {
      position: absolute;
      inset: 0;
      background:
        radial-gradient(1px 1px at 10% 20%, rgba(255,255,255,.75), transparent 50%),
        radial-gradient(1px 1px at 40% 10%, rgba(255,255,255,.65), transparent 50%),
        radial-gradient(1px 1px at 70% 18%, rgba(255,255,255,.60), transparent 50%),
        radial-gradient(1px 1px at 85% 35%, rgba(255,255,255,.55), transparent 50%),
        radial-gradient(1px 1px at 25% 55%, rgba(255,255,255,.55), transparent 50%),
        radial-gradient(1px 1px at 60% 60%, rgba(255,255,255,.60), transparent 50%),
        radial-gradient(1px 1px at 15% 75%, rgba(255,255,255,.55), transparent 50%),
        radial-gradient(1px 1px at 90% 80%, rgba(255,255,255,.55), transparent 50%),
        radial-gradient(2px 2px at 30% 35%, rgba(255,255,255,.25), transparent 55%),
        radial-gradient(2px 2px at 78% 72%, rgba(255,255,255,.22), transparent 55%),
        radial-gradient(2px 2px at 52% 28%, rgba(255,255,255,.18), transparent 55%);
      opacity: .75;
      animation: twinkle 6s ease-in-out infinite;
    }
    @keyframes twinkle{
      0%,100% { opacity: .55; transform: translateY(0); }
      50%     { opacity: .85; transform: translateY(-4px); }
    }

    /* Floating grain */
    .grain{
      position:absolute;
      inset:-30%;
      background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='160' height='160' filter='url(%23n)' opacity='.35'/%3E%3C/svg%3E");
      opacity: .12;
      mix-blend-mode: overlay;
      animation: grainMove 10s linear infinite;
      pointer-events:none;
    }
    @keyframes grainMove{
      0% { transform: translate(0,0); }
      100% { transform: translate(-10%, 8%); }
    }

    /* =========================
       LAYOUT
    ========================== */
    .wrap{
      position: relative;
      z-index: 2;
      height: 100%;
      display: grid;
      place-items: center;
      padding: 24px;
    }

    .container{
      width: min(980px, 100%);
      display: grid;
      gap: 18px;
      grid-template-columns: 1.05fr .95fr;
      align-items: center;
    }

    @media (max-width: 900px){
      .container{
        grid-template-columns: 1fr;
        gap: 14px;
      }
    }

    /* =========================
       HERO TEXT
    ========================== */
    .hero{
      padding: 10px 6px;
    }

    .badge{
      display:inline-flex;
      gap:10px;
      align-items:center;
      padding: 8px 12px;
      border-radius: 999px;
      border: 1px solid rgba(255,255,255,.14);
      background: rgba(255,255,255,.06);
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 30px rgba(0,0,0,.25);
      width: fit-content;
    }
    .dot{
      width: 8px; height: 8px;
      border-radius: 999px;
      background: rgba(140,255,230,.95);
      box-shadow: 0 0 14px rgba(140,255,230,.9);
      animation: pulse 1.8s ease-in-out infinite;
    }
    @keyframes pulse{
      0%,100%{ transform: scale(1); opacity: .9; }
      50%{ transform: scale(1.35); opacity: 1; }
    }

    h1{
      margin-top: 14px;
      font-size: clamp(2.4rem, 4vw, 3.6rem);
      line-height: 1.05;
      letter-spacing: -0.02em;
      text-shadow: 0 0 30px rgba(140,120,255,.25);
    }

    .shine{
      background: linear-gradient(90deg,
        rgba(255,255,255,.85),
        rgba(180,255,240,.95),
        rgba(255,140,220,.95),
        rgba(255,255,255,.85));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      filter: drop-shadow(0 0 18px rgba(160,120,255,.25));
      background-size: 220% 100%;
      animation: textShine 4.5s ease-in-out infinite;
    }
    @keyframes textShine{
      0%{ background-position: 0% 50%; }
      50%{ background-position: 100% 50%; }
      100%{ background-position: 0% 50%; }
    }

    .sub{
      margin-top: 12px;
      max-width: 52ch;
      font-size: 1.05rem;
      color: rgba(234,242,255,.82);
      line-height: 1.5;
    }

    .actions{
      margin-top: 18px;
      display:flex;
      gap: 12px;
      flex-wrap: wrap;
      align-items:center;
    }

    .btn{
      cursor:pointer;
      border: 1px solid rgba(255,255,255,.16);
      background: rgba(255,255,255,.06);
      color: rgba(234,242,255,.95);
      padding: 12px 16px;
      border-radius: 14px;
      font-weight: 650;
      letter-spacing: .2px;
      backdrop-filter: blur(12px);
      transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
      box-shadow: 0 14px 35px rgba(0,0,0,.25);
      user-select:none;
    }
    .btn:hover{
      transform: translateY(-2px);
      box-shadow: 0 18px 45px rgba(0,0,0,.32);
      background: rgba(255,255,255,.09);
    }
    .btn.primary{
      border-color: rgba(160,120,255,.35);
      background:
        radial-gradient(120px 60px at 20% 30%, rgba(180,255,240,.22), transparent 60%),
        radial-gradient(160px 90px at 70% 50%, rgba(255,140,220,.18), transparent 60%),
        rgba(255,255,255,.07);
    }
    .hint{
      font-size: .92rem;
      color: rgba(234,242,255,.70);
      display:flex;
      gap:8px;
      align-items:center;
      padding: 10px 12px;
      border-radius: 14px;
      border: 1px dashed rgba(255,255,255,.16);
      background: rgba(0,0,0,.14);
      backdrop-filter: blur(10px);
    }

    /* =========================
       CARD (LETTER)
    ========================== */
    .card{
      position: relative;
      border-radius: 22px;
      border: 1px solid rgba(255,255,255,.14);
      background:
        radial-gradient(180px 120px at 20% 15%, rgba(0,210,255,.10), transparent 60%),
        radial-gradient(260px 160px at 80% 25%, rgba(255,80,200,.10), transparent 55%),
        rgba(255,255,255,.06);
      backdrop-filter: blur(14px);
      box-shadow: 0 30px 90px rgba(0,0,0,.35);
      overflow: hidden;
      min-height: 360px;
    }

    .card::before{
      content:"";
      position:absolute;
      inset:-2px;
      background: linear-gradient(135deg, rgba(180,255,240,.0), rgba(180,255,240,.18), rgba(255,140,220,.16), rgba(160,120,255,.14));
      opacity: .35;
      filter: blur(18px);
      pointer-events:none;
    }

    .card-inner{
      position: relative;
      padding: 18px;
      height: 100%;
      display:flex;
      flex-direction: column;
      gap: 14px;
    }

    .mini{
      display:flex;
      align-items:center;
      justify-content: space-between;
      gap: 12px;
      opacity: .9;
    }

    .mini .title{
      font-weight: 700;
      letter-spacing: .3px;
      color: rgba(234,242,255,.95);
    }
    .mini .meta{
      font-size: .9rem;
      color: rgba(234,242,255,.72);
    }

    /* Envelope 3D */
    .envelopeStage{
      position: relative;
      height: 240px;
      display:grid;
      place-items:center;
      perspective: 1200px;
    }

    .envelope{
      width: min(360px, 92%);
      height: 210px;
      position: relative;
      transform-style: preserve-3d;
      filter: drop-shadow(0 25px 45px rgba(0,0,0,.35));
      animation: floaty 4.2s ease-in-out infinite;
    }
    @keyframes floaty{
      0%,100% { transform: translateY(0px) rotateX(6deg); }
      50% { transform: translateY(-10px) rotateX(10deg); }
    }

    .env-back{
      position:absolute;
      inset:0;
      border-radius: 18px;
      background: rgba(255,255,255,.92);
      transform: translateZ(-1px);
    }

    /* paper inside */
    .paper{
      position:absolute;
      left: 8%;
      right: 8%;
      top: 14%;
      height: 70%;
      border-radius: 14px;
      background:
        linear-gradient(180deg, rgba(255,255,255,.98), rgba(245,247,255,.96));
      transform: translateZ(15px) translateY(20px);
      box-shadow: inset 0 0 0 1px rgba(0,0,0,.06);
      overflow:hidden;
      transition: transform .9s cubic-bezier(.2,.9,.2,1);
    }

    .paper .lines{
      position:absolute;
      inset: 14px 16px;
      display:grid;
      gap: 8px;
      opacity: .8;
    }
    .paper .line{
      height: 10px;
      border-radius: 999px;
      background: linear-gradient(90deg, rgba(160,120,255,.18), rgba(0,210,255,.14), rgba(255,140,220,.12));
    }
    .paper .line:nth-child(3){ width: 78%; }
    .paper .line:nth-child(4){ width: 62%; }
    .paper .line:nth-child(5){ width: 86%; }

    /* envelope body front */
    .env-front{
      position:absolute;
      inset:0;
      border-radius: 18px;
      background: rgba(255,255,255,.92);
      overflow:hidden;
      transform: translateZ(20px);
    }

    /* bottom triangle */
    .env-front::before{
      content:"";
      position:absolute;
      inset:0;
      background: rgba(255,255,255,.95);
      clip-path: polygon(0 40%, 50% 82%, 100% 40%, 100% 100%, 0 100%);
      box-shadow: inset 0 0 0 1px rgba(0,0,0,.06);
    }

    /* top flap */
    .flap{
      position:absolute;
      inset:0;
      border-radius: 18px;
      background: rgba(255,255,255,.96);
      clip-path: polygon(0 0, 100% 0, 50% 55%);
      transform-origin: 50% 0%;
      transform: translateZ(30px) rotateX(0deg);
      transition: transform .9s cubic-bezier(.2,.9,.2,1);
      box-shadow: inset 0 0 0 1px rgba(0,0,0,.06);
    }

    /* seal heart */
    .seal{
      position:absolute;
      left: 50%;
      top: 62%;
      width: 52px;
      height: 52px;
      transform: translate(-50%,-50%) translateZ(40px);
      display:grid;
      place-items:center;
    }
    .seal .heart{
      width: 26px; height: 26px;
      position: relative;
      transform: rotate(-45deg);
      background: linear-gradient(135deg, rgba(255,70,170,.95), rgba(255,140,220,.85));
      border-radius: 6px;
      box-shadow: 0 0 20px rgba(255,140,220,.35);
      animation: beat 1.6s ease-in-out infinite;
    }
    .seal .heart::before,
    .seal .heart::after{
      content:"";
      position:absolute;
      width: 26px; height: 26px;
      border-radius: 50%;
      background: inherit;
    }
    .seal .heart::before{ top:-13px; left:0; }
    .seal .heart::after{ left:13px; top:0; }
    @keyframes beat{
      0%,100% { transform: rotate(-45deg) scale(1); }
      50% { transform: rotate(-45deg) scale(1.12); }
    }

    /* Open state */
    .open .flap{ transform: translateZ(30px) rotateX(-160deg); }
    .open .paper{ transform: translateZ(15px) translateY(-30px); }

    /* message area */
    .textBox{
      margin-top: -6px;
      padding: 14px 14px 16px 14px;
      border-radius: 18px;
      border: 1px solid rgba(255,255,255,.12);
      background: rgba(0,0,0,.18);
      backdrop-filter: blur(10px);
    }
    .textBox p{
      font-size: 1.05rem;
      line-height: 1.55;
      color: rgba(234,242,255,.88);
    }
    .author{
      margin-top: 10px;
      font-size: .92rem;
      color: rgba(234,242,255,.70);
    }

    /* =========================
       PARTICLES (hearts)
    ========================== */
    .fx{
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 3;
    }
    .heartFx{
      position:absolute;
      width: 14px;
      height: 14px;
      transform: rotate(-45deg);
      background: rgba(255,140,220,.9);
      border-radius: 3px;
      filter: drop-shadow(0 0 10px rgba(255,140,220,.25));
      opacity: 0;
      animation: floatUp var(--dur) ease-in forwards;
    }
    .heartFx::before,
    .heartFx::after{
      content:"";
      position:absolute;
      width: 14px;
      height: 14px;
      border-radius: 50%;
      background: inherit;
    }
    .heartFx::before{ top:-7px; left:0; }
    .heartFx::after{ left:7px; top:0; }

    @keyframes floatUp{
      0%{
        opacity:0;
        transform: translate(var(--x0), var(--y0)) rotate(-45deg) scale(.7);
      }
      10%{ opacity: .95; }
      100%{
        opacity:0;
        transform: translate(var(--x1), var(--y1)) rotate(-45deg) scale(1.25);
      }
    }

    /* subtle entrance */
    .container{
      animation: enter 1.2s ease-out both;
    }
    @keyframes enter{
      0% { opacity: 0; transform: translateY(10px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    /* footer hint */
    .sig{
      margin-top: 10px;
      font-size: .86rem;
      color: rgba(234,242,255,.60);
    }
  </style>
</head>
<body>
  <div class="bg">
    <div class="aurora"></div>
    <div class="stars"></div>
    <div class="grain"></div>
  </div>

  <div class="fx" id="fx"></div>

  <main class="wrap">
    <section class="container">

      <div class="hero">
        <div class="badge">
          <span class="dot"></span>
          <span style="opacity:.9;">Mensaje sellado · Solo para ti</span>
        </div>

        <h1>
          <span class="shine">Te Amo</span><br />
          <span style="opacity:.92;">más de lo que sé programar</span>
        </h1>

        <p class="sub">
          Hay cosas que no se dicen normal. Se mandan como si el universo tuviera UI propia.
        </p>

        <div class="actions">
          <button class="btn primary" id="btnOpen">Abrir carta</button>
          <button class="btn" id="btnMoment">Modo épico</button>
          <div class="hint">💫 Tip: dale “Modo épico” y luego abre la carta.</div>
        </div>

        <div class="sig">— RRB-Soluciones</div>
      </div>

      <div class="card" id="card">
        <div class="card-inner">
          <div class="mini">
            <div class="title">Carta</div>
            <div class="meta" id="meta">sellada</div>
          </div>

          <div class="envelopeStage">
            <div class="envelope" id="env">
              <div class="env-back"></div>

              <div class="paper" id="paper">
                <div class="lines">
                  <div class="line"></div>
                  <div class="line"></div>
                  <div class="line"></div>
                  <div class="line"></div>
                  <div class="line"></div>
                </div>
              </div>

              <div class="env-front"></div>
              <div class="flap"></div>

              <div class="seal" aria-hidden="true">
                <div class="heart"></div>
              </div>
            </div>
          </div>

          <div class="textBox">
            <p id="msg">
              Tu mensaje aquí. (Cámbialo por algo tuyo: una frase, un recuerdo, una promesa.)
            </p>
            <div class="author" id="author">— RRB-Soluciones</div>
          </div>
        </div>
      </div>

    </section>
  </main>

  <script>
    const env = document.getElementById('env');
    const meta = document.getElementById('meta');
    const fx = document.getElementById('fx');

    const btnOpen = document.getElementById('btnOpen');
    const btnMoment = document.getElementById('btnMoment');

    let epic = false;
    let opened = false;

    function spawnHearts(count, intensity = 1){
      const vw = window.innerWidth;
      const vh = window.innerHeight;

      for(let i=0; i<count; i++){
        const h = document.createElement('div');
        h.className = 'heartFx';

        const startX = (vw * (0.25 + Math.random()*0.5));
        const startY = (vh * (0.55 + Math.random()*0.2));

        const driftX = (Math.random() * 220 - 110) * intensity;
        const riseY  = -(vh * (0.35 + Math.random()*0.35)) * intensity;

        const dur = (1200 + Math.random()*900) / intensity;

        h.style.left = startX + 'px';
        h.style.top  = startY + 'px';
        h.style.setProperty('--x0', '0px');
        h.style.setProperty('--y0', '0px');
        h.style.setProperty('--x1', driftX + 'px');
        h.style.setProperty('--y1', riseY + 'px');
        h.style.setProperty('--dur', dur + 'ms');

        fx.appendChild(h);
        h.addEventListener('animationend', () => h.remove());
      }
    }

    function microShake(el){
      el.animate([
        { transform: 'translateY(0)' },
        { transform: 'translateY(-2px)' },
        { transform: 'translateY(0)' }
      ], { duration: 260, easing: 'ease-out' });
    }

    btnMoment.addEventListener('click', () => {
      epic = !epic;
      microShake(btnMoment);

      if(epic){
        spawnHearts(22, 1.25);
        meta.textContent = opened ? 'abierta · épico' : 'sellada · épico';
        btnMoment.textContent = 'Modo épico: ON';
      }else{
        meta.textContent = opened ? 'abierta' : 'sellada';
        btnMoment.textContent = 'Modo épico';
      }
    });

    btnOpen.addEventListener('click', () => {
      opened = !opened;
      microShake(btnOpen);

      if(opened){
        env.classList.add('open');
        meta.textContent = epic ? 'abierta · épico' : 'abierta';
        btnOpen.textContent = 'Cerrar carta';
        spawnHearts(epic ? 26 : 14, epic ? 1.35 : 1);
      }else{
        env.classList.remove('open');
        meta.textContent = epic ? 'sellada · épico' : 'sellada';
        btnOpen.textContent = 'Abrir carta';
        spawnHearts(epic ? 12 : 6, epic ? 1.1 : 1);
      }
    });

    // ambient small hearts occasionally
    setInterval(() => {
      if(epic || opened){
        spawnHearts(epic ? 4 : 2, epic ? 1.1 : 1);
      }
    }, 1200);
  </script>
</body>
</html>
