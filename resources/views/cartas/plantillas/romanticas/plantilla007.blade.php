<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carta Mágica</title>
  <style>
    *{margin:0;padding:0;box-sizing:border-box}
    html,body{height:100%}
    body{
      font-family: ui-serif, Georgia, "Times New Roman", serif;
      background: radial-gradient(1200px 700px at 50% 20%, rgba(120,80,255,.18), transparent 60%),
                  radial-gradient(900px 600px at 20% 90%, rgba(255,160,80,.14), transparent 60%),
                  radial-gradient(900px 600px at 80% 80%, rgba(0,210,255,.10), transparent 60%),
                  linear-gradient(180deg, #05060d 0%, #04040a 100%);
      color:#efe7d2;
      overflow:hidden;
    }

    /* ===== Fondo: estrellas + humo mágico ===== */
    .bg{position:fixed;inset:0;z-index:0;overflow:hidden}
    .stars{
      position:absolute;inset:0;
      background:
        radial-gradient(1px 1px at 10% 20%, rgba(255,255,255,.8), transparent 50%),
        radial-gradient(1px 1px at 30% 70%, rgba(255,255,255,.6), transparent 50%),
        radial-gradient(1px 1px at 60% 30%, rgba(255,255,255,.55), transparent 50%),
        radial-gradient(1px 1px at 85% 25%, rgba(255,255,255,.5), transparent 50%),
        radial-gradient(2px 2px at 70% 80%, rgba(255,255,255,.22), transparent 60%),
        radial-gradient(2px 2px at 40% 35%, rgba(255,255,255,.18), transparent 60%);
      opacity:.75;
      animation: twinkle 6s ease-in-out infinite;
    }
    @keyframes twinkle{
      0%,100%{opacity:.55;transform:translateY(0)}
      50%{opacity:.9;transform:translateY(-4px)}
    }

    .mist{
      position:absolute;
      inset:-30%;
      background:
        conic-gradient(from 200deg at 50% 50%,
          rgba(255,190,120,0),
          rgba(255,190,120,.08),
          rgba(140,120,255,.10),
          rgba(0,210,255,.08),
          rgba(255,190,120,0));
      filter: blur(26px);
      opacity:.85;
      mix-blend-mode: screen;
      animation: mist 10s ease-in-out infinite alternate;
    }
    @keyframes mist{
      0%{transform:translate(-2%,-1%) rotate(-6deg) scale(1.02)}
      100%{transform:translate(2%,1%) rotate(8deg) scale(1.08)}
    }

    /* ===== Layout ===== */
    .wrap{
      position:relative;
      z-index:2;
      min-height:100%;
      display:grid;
      place-items:center;
      padding:24px;
    }

    .stage{
      width:min(1040px, 100%);
      display:grid;
      grid-template-columns: 1.05fr .95fr;
      gap:18px;
      align-items:center;
    }
    @media (max-width: 920px){
      .stage{grid-template-columns:1fr}
    }

    /* ===== Columna izquierda ===== */
    .hero{
      padding: 10px 6px;
      animation: enter 1.1s ease-out both;
    }
    @keyframes enter{
      0%{opacity:0;transform:translateY(10px)}
      100%{opacity:1;transform:translateY(0)}
    }

    .crest{
      display:inline-flex;align-items:center;gap:12px;
      padding:10px 14px;border-radius:999px;
      border:1px solid rgba(255,255,255,.14);
      background: rgba(255,255,255,.06);
      backdrop-filter: blur(12px);
      box-shadow: 0 16px 40px rgba(0,0,0,.28);
      width: fit-content;
    }
    .sigil{
      width:22px;height:22px;border-radius:8px;
      background: radial-gradient(circle at 30% 30%, rgba(255,220,150,.9), rgba(255,170,80,.25));
      box-shadow: 0 0 18px rgba(255,190,120,.35);
      position:relative;
    }
    .sigil::after{
      content:"";
      position:absolute;inset:4px;
      border:1px solid rgba(30,20,10,.35);
      border-radius:6px;
      opacity:.65;
    }
    .crest span{opacity:.9}

    h1{
      margin-top: 14px;
      font-size: clamp(2.2rem, 4vw, 3.4rem);
      line-height:1.05;
      letter-spacing:-0.02em;
      text-shadow: 0 0 34px rgba(255,190,120,.12);
    }
    .glow{
      background: linear-gradient(90deg, rgba(255,240,210,.95), rgba(255,200,130,.95), rgba(180,160,255,.9), rgba(255,240,210,.95));
      -webkit-background-clip:text;
      background-clip:text;
      color:transparent;
      background-size: 220% 100%;
      animation: shine 4.8s ease-in-out infinite;
      filter: drop-shadow(0 0 18px rgba(255,190,120,.14));
    }
    @keyframes shine{
      0%{background-position:0% 50%}
      50%{background-position:100% 50%}
      100%{background-position:0% 50%}
    }

    .sub{
      margin-top: 12px;
      max-width: 55ch;
      font-size: 1.05rem;
      line-height:1.55;
      color: rgba(239,231,210,.85);
    }

    .actions{
      margin-top: 18px;
      display:flex;
      gap:12px;
      flex-wrap:wrap;
      align-items:center;
    }

    .btn{
      cursor:pointer;
      border: 1px solid rgba(255,255,255,.16);
      background: rgba(255,255,255,.06);
      color: rgba(239,231,210,.95);
      padding: 12px 16px;
      border-radius: 14px;
      font-weight: 700;
      letter-spacing: .2px;
      backdrop-filter: blur(12px);
      transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
      box-shadow: 0 16px 40px rgba(0,0,0,.28);
      user-select:none;
    }
    .btn:hover{transform: translateY(-2px); background: rgba(255,255,255,.09)}
    .btn.primary{
      border-color: rgba(255,190,120,.28);
      background:
        radial-gradient(140px 70px at 20% 40%, rgba(255,200,130,.18), transparent 60%),
        radial-gradient(200px 100px at 70% 55%, rgba(160,120,255,.14), transparent 60%),
        rgba(255,255,255,.06);
    }

    .hint{
      font-size:.92rem;
      color: rgba(239,231,210,.70);
      padding: 10px 12px;
      border-radius: 14px;
      border: 1px dashed rgba(255,255,255,.14);
      background: rgba(0,0,0,.18);
      backdrop-filter: blur(10px);
    }

    /* ===== Columna derecha: Pergamino ===== */
    .panel{
      position: relative;
      border-radius: 24px;
      border: 1px solid rgba(255,255,255,.14);
      background: rgba(255,255,255,.06);
      backdrop-filter: blur(14px);
      box-shadow: 0 35px 100px rgba(0,0,0,.38);
      overflow:hidden;
      min-height: 430px;
      animation: enter 1.1s ease-out both;
    }

    .panel::before{
      content:"";
      position:absolute;inset:-2px;
      background: linear-gradient(135deg, rgba(255,200,130,.10), rgba(180,160,255,.08), rgba(0,210,255,.07));
      filter: blur(22px);
      opacity: .6;
      pointer-events:none;
    }

    .panel-inner{
      position:relative;
      padding: 18px;
      height:100%;
      display:flex;
      flex-direction:column;
      gap: 14px;
    }

    .topbar{
      display:flex;align-items:center;justify-content:space-between;gap:12px;
      opacity:.92;
    }
    .topbar .label{font-weight:800;letter-spacing:.4px}
    .topbar .state{font-size:.92rem;color: rgba(239,231,210,.72)}

    /* Pergamino enrollado -> desenrolla */
    .scrollStage{
      position: relative;
      flex: 1;
      display:grid;
      place-items:center;
      padding: 6px;
    }

    .scroll{
      width: min(420px, 94%);
      height: 290px;
      position: relative;
      transform-style: preserve-3d;
      filter: drop-shadow(0 25px 45px rgba(0,0,0,.35));
      animation: floaty 4.4s ease-in-out infinite;
    }
    @keyframes floaty{
      0%,100%{transform: translateY(0) rotateX(6deg)}
      50%{transform: translateY(-10px) rotateX(10deg)}
    }

    .parchment{
      position:absolute;
      inset: 0;
      border-radius: 18px;
      background:
        radial-gradient(220px 120px at 20% 20%, rgba(255,255,255,.55), transparent 60%),
        linear-gradient(180deg, rgba(245,232,200,.96), rgba(235,214,170,.94));
      box-shadow: inset 0 0 0 1px rgba(0,0,0,.10);
      overflow:hidden;
    }

    /* bordes “quemados” */
    .parchment::before{
      content:"";
      position:absolute;inset:-10px;
      background:
        radial-gradient(20px 20px at 10% 10%, rgba(80,50,20,.35), transparent 70%),
        radial-gradient(22px 22px at 92% 12%, rgba(80,50,20,.30), transparent 70%),
        radial-gradient(26px 26px at 12% 92%, rgba(80,50,20,.28), transparent 70%),
        radial-gradient(24px 24px at 88% 88%, rgba(80,50,20,.26), transparent 70%);
      filter: blur(2px);
      opacity:.9;
      pointer-events:none;
      mix-blend-mode:multiply;
    }

    /* runas alrededor */
    .runes{
      position:absolute;
      inset: 10px;
      border-radius: 16px;
      border: 1px solid rgba(60,35,10,.18);
      opacity:.35;
      background:
        radial-gradient(2px 2px at 12% 18%, rgba(60,35,10,.5), transparent 60%),
        radial-gradient(2px 2px at 86% 22%, rgba(60,35,10,.5), transparent 60%),
        radial-gradient(2px 2px at 28% 78%, rgba(60,35,10,.5), transparent 60%),
        radial-gradient(2px 2px at 70% 84%, rgba(60,35,10,.5), transparent 60%);
    }

    /* Tapas enrolladas arriba/abajo */
    .rollTop, .rollBottom{
      position:absolute;
      left: 4%;
      right: 4%;
      height: 26px;
      border-radius: 999px;
      background: linear-gradient(180deg, rgba(225,198,150,.95), rgba(200,170,120,.95));
      box-shadow: inset 0 0 0 1px rgba(0,0,0,.10);
    }
    .rollTop{ top: -10px; }
    .rollBottom{ bottom: -10px; }

    /* contenido del pergamino */
    .content{
      position:absolute;
      inset: 26px 22px 30px 22px;
      color: rgba(40,25,10,.92);
      display:flex;
      flex-direction:column;
      gap: 10px;
      overflow:hidden;
    }

    .heading{
      font-weight: 900;
      letter-spacing: .2px;
      font-size: 1.1rem;
      opacity:.92;
    }

    /* “escritura” */
    .type{
      font-size: 1.06rem;
      line-height: 1.55;
      white-space: pre-wrap;
      min-height: 140px;
    }

    .type .cursor{
      display:inline-block;
      width: 10px;
      height: 1.15em;
      transform: translateY(3px);
      background: rgba(40,25,10,.65);
      margin-left: 3px;
      animation: blink .9s steps(1) infinite;
    }
    @keyframes blink{
      0%,49%{opacity:1}
      50%,100%{opacity:0}
    }

    .sign{
      margin-top:auto;
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap: 12px;
      font-size:.95rem;
      opacity:.9;
    }
    .sign .by{font-style: italic}
    .seal{
      width: 56px;
      height: 56px;
      border-radius: 999px;
      background: radial-gradient(circle at 30% 30%, rgba(255,90,140,.95), rgba(120,10,30,.92));
      box-shadow: 0 0 26px rgba(255,90,140,.25);
      position:relative;
      display:grid;
      place-items:center;
      transform: translateY(4px);
      animation: sealBeat 1.7s ease-in-out infinite;
      border: 1px solid rgba(20,10,10,.25);
    }
    @keyframes sealBeat{
      0%,100%{transform: translateY(4px) scale(1)}
      50%{transform: translateY(4px) scale(1.08)}
    }
    .seal::after{
      content:"";
      width: 18px;height:18px;
      transform: rotate(-45deg);
      background: rgba(255,220,220,.92);
      border-radius: 4px;
      box-shadow: 0 0 12px rgba(255,220,220,.18);
      position:relative;
    }
    .seal::before{
      content:"";
      position:absolute;
      width: 18px;height:18px;
      border-radius:50%;
      background: rgba(255,220,220,.92);
      transform: translate(0,-10px);
      opacity:.95;
    }
    .seal b{
      position:absolute;
      width: 18px;height:18px;
      border-radius:50%;
      background: rgba(255,220,220,.92);
      transform: translate(10px,0);
      opacity:.95;
      display:block;
    }

    /* Estado enrollado/cerrado (antes del hechizo) */
    .locked .parchment{ filter: blur(.2px) brightness(.92); }
    .locked .content{ transform: translateY(40px); opacity: 0; }
    .locked .rollTop{ transform: translateY(18px) scaleX(.96); }
    .locked .rollBottom{ transform: translateY(-18px) scaleX(.96); }

    /* Desenrollado */
    .unlock .content{
      transform: translateY(0);
      opacity: 1;
      transition: transform 900ms cubic-bezier(.2,.9,.2,1), opacity 900ms ease;
    }
    .unlock .rollTop{
      transform: translateY(0) scaleX(1);
      transition: transform 900ms cubic-bezier(.2,.9,.2,1);
    }
    .unlock .rollBottom{
      transform: translateY(0) scaleX(1);
      transition: transform 900ms cubic-bezier(.2,.9,.2,1);
    }

    /* ===== Pluma ===== */
    .quill{
      position:absolute;
      right: -10px;
      top: 18px;
      width: 120px;
      height: 120px;
      opacity: .85;
      transform: rotate(12deg);
      filter: drop-shadow(0 12px 18px rgba(0,0,0,.25));
      pointer-events:none;
    }
    .quill .shaft{
      position:absolute;
      left: 42px; top: 18px;
      width: 10px; height: 86px;
      border-radius: 999px;
      background: linear-gradient(180deg, rgba(80,50,20,.95), rgba(40,25,10,.95));
      transform: rotate(-18deg);
    }
    .quill .feather{
      position:absolute;
      left: 18px; top: 18px;
      width: 70px; height: 70px;
      border-radius: 70% 30% 70% 30%;
      background: linear-gradient(135deg, rgba(255,240,210,.92), rgba(255,200,130,.35), rgba(180,160,255,.25));
      transform: rotate(-28deg);
      filter: blur(.2px);
      opacity:.9;
    }
    .quill .tip{
      position:absolute;
      left: 60px; top: 92px;
      width: 18px; height: 18px;
      background: rgba(40,25,10,.9);
      clip-path: polygon(50% 0, 100% 40%, 50% 100%, 0 40%);
      transform: rotate(-18deg);
    }
    .writing .quill{
      animation: quillMove 2.2s ease-in-out infinite;
    }
    @keyframes quillMove{
      0%,100%{transform: translate(0,0) rotate(12deg)}
      50%{transform: translate(-10px,6px) rotate(9deg)}
    }

    /* ===== Partículas mágicas ===== */
    .fx{position:fixed;inset:0;pointer-events:none;z-index:3}
    .spark{
      position:absolute;
      width: 8px; height: 8px;
      border-radius: 999px;
      background: rgba(255,230,170,.95);
      box-shadow: 0 0 18px rgba(255,210,140,.35);
      opacity:0;
      animation: spark var(--dur) ease-out forwards;
    }
    @keyframes spark{
      0%{opacity:0;transform:translate(var(--x0), var(--y0)) scale(.6)}
      15%{opacity:1}
      100%{opacity:0;transform:translate(var(--x1), var(--y1)) scale(1.2)}
    }

    /* mini shake */
    .shake{
      animation: shake .25s ease-out;
    }
    @keyframes shake{
      0%{transform:translateY(0)}
      40%{transform:translateY(-2px)}
      100%{transform:translateY(0)}
    }
  </style>
</head>
<body>
  <div class="bg">
    <div class="mist"></div>
    <div class="stars"></div>
  </div>
  <div class="fx" id="fx"></div>

  <main class="wrap">
    <section class="stage">
      <div class="hero">
        <div class="crest">
          <div class="sigil"></div>
          <span>Carta encantada · Entrega inmediata</span>
        </div>

        <h1><span class="glow">Para ti.</span><br/>Con magia y verdad.</h1>
        <p class="sub">
          Esta carta no se lee: se revela. Cuando lanzas el hechizo, el pergamino se desenrolla
          y la pluma escribe sola lo que a veces cuesta decir.
        </p>

        <div class="actions">
          <button class="btn primary" id="btnSpell">Lanzar hechizo</button>
          <button class="btn" id="btnReplay">Repetir</button>
          <div class="hint">✨ Tip: lánzalo en pantalla completa. Se ve más “cine”.</div>
        </div>
      </div>

      <div class="panel">
        <div class="panel-inner">
          <div class="topbar">
            <div class="label">Pergamino</div>
            <div class="state" id="state">sellado</div>
          </div>

          <div class="scrollStage">
            <div class="scroll locked" id="scroll">
              <div class="parchment">
                <div class="runes"></div>

                <div class="rollTop"></div>
                <div class="rollBottom"></div>

                <div class="content" id="content">
                  <div class="heading">Para: <span id="to">Tu persona favorita</span></div>

                  <div class="type" id="type"
                       data-text="Tu mensaje aquí."
                  ></div>

                  <div class="sign">
                    <div class="by">— RRB-Soluciones</div>
                    <div class="seal" aria-hidden="true"><b></b></div>
                  </div>
                </div>

                <div class="quill" id="quill" aria-hidden="true">
                  <div class="feather"></div>
                  <div class="shaft"></div>
                  <div class="tip"></div>
                </div>

              </div>
            </div>
          </div>

          <div class="hint" style="text-align:center;">
            Sisis
          </div>
        </div>
      </div>

    </section>
  </main>

  <script>
    const fx = document.getElementById('fx');
    const btnSpell = document.getElementById('btnSpell');
    const btnReplay = document.getElementById('btnReplay');
    const scroll = document.getElementById('scroll');
    const state = document.getElementById('state');
    const typeEl = document.getElementById('type');
    const quill = document.getElementById('quill');

    let running = false;
    let typed = false;
    let timer = null;

    function spawnSparks(count, intensity=1){
      const vw = window.innerWidth;
      const vh = window.innerHeight;

      for(let i=0;i<count;i++){
        const s = document.createElement('div');
        s.className = 'spark';

        const startX = (vw * (0.55 + Math.random()*0.25));
        const startY = (vh * (0.40 + Math.random()*0.30));

        const driftX = (Math.random()*260 - 130) * intensity;
        const driftY = (Math.random()*-260 - 80) * intensity;

        const dur = (900 + Math.random()*900) / intensity;

        s.style.left = startX + 'px';
        s.style.top = startY + 'px';
        s.style.setProperty('--x0', '0px');
        s.style.setProperty('--y0', '0px');
        s.style.setProperty('--x1', driftX + 'px');
        s.style.setProperty('--y1', driftY + 'px');
        s.style.setProperty('--dur', dur + 'ms');

        fx.appendChild(s);
        s.addEventListener('animationend', ()=> s.remove());
      }
    }

    function typeText(el, speed=22){
      const full = el.getAttribute('data-text') || '';
      el.textContent = '';
      const cursor = document.createElement('span');
      cursor.className = 'cursor';
      el.appendChild(cursor);

      let i = 0;
      typed = false;
      quill.closest('.scroll').classList.add('writing');

      function step(){
        if(i < full.length){
          cursor.insertAdjacentText('beforebegin', full[i]);
          i++;
          timer = setTimeout(step, speed);
        }else{
          typed = true;
          quill.closest('.scroll').classList.remove('writing');
        }
      }
      step();
    }

    function unlock(){
      if(running) return;
      running = true;

      btnSpell.classList.add('shake');
      setTimeout(()=>btnSpell.classList.remove('shake'), 260);

      spawnSparks(26, 1.25);

      scroll.classList.remove('locked');
      scroll.classList.add('unlock');
      state.textContent = 'revelándose...';

      setTimeout(()=>{
        state.textContent = 'abierto';
        typeText(typeEl, 20);
        spawnSparks(18, 1.1);
        running = false;
      }, 900);
    }

    function replay(){
      if(timer) clearTimeout(timer);
      running = false;
      typed = false;

      scroll.classList.remove('unlock');
      scroll.classList.add('locked');
      state.textContent = 'sellado';

      // limpiar texto (dejar vacío)
      typeEl.textContent = '';

      spawnSparks(10, 1.0);
    }

    btnSpell.addEventListener('click', unlock);
    btnReplay.addEventListener('click', replay);

    // Ambient sparks ligeros
    setInterval(() => {
      if(scroll.classList.contains('unlock') || scroll.classList.contains('writing')){
        spawnSparks(3, 1.0);
      }
    }, 1200);
  </script>
</body>
</html>
