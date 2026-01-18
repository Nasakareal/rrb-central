<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <title>Ritual</title>
  <style>
    *{margin:0;padding:0;box-sizing:border-box}
    html,body{height:100%}
    body{
      overflow:hidden;
      background:#04050a;
      color:#fff;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
      -webkit-tap-highlight-color: transparent;
      touch-action: none;
    }

    .bg{
      position:fixed; inset:0; z-index:0;
      background:
        radial-gradient(900px 600px at 50% 20%, rgba(140,90,255,.22), transparent 60%),
        radial-gradient(900px 600px at 20% 85%, rgba(0,220,255,.16), transparent 60%),
        radial-gradient(900px 600px at 85% 80%, rgba(255,120,200,.14), transparent 55%),
        linear-gradient(180deg, #04050a 0%, #020208 100%);
    }
    .fog{
      position:absolute; inset:-25%;
      background:
        conic-gradient(from 180deg at 50% 50%,
          rgba(0,0,0,0),
          rgba(180,140,255,.22),
          rgba(0,210,255,.16),
          rgba(255,120,200,.14),
          rgba(0,0,0,0));
      filter: blur(34px);
      opacity:.9;
      animation: fog 10s ease-in-out infinite alternate;
      mix-blend-mode: screen;
      pointer-events:none;
    }
    @keyframes fog{
      0%{transform:translate(-2%,-1%) rotate(-8deg) scale(1.03)}
      100%{transform:translate(2%,1%) rotate(10deg) scale(1.08)}
    }
    .vignette{
      position:fixed; inset:0; z-index:1;
      background: radial-gradient(900px 650px at 50% 45%, rgba(0,0,0,0) 45%, rgba(0,0,0,.55) 100%);
      pointer-events:none;
    }

    canvas{
      position:fixed; inset:0; width:100%; height:100%;
      z-index:2; display:block;
    }

    .ui{
      position:fixed;
      left: 14px;
      right: 14px;
      top: 14px;
      z-index:4;
      display:flex;
      justify-content:space-between;
      gap: 10px;
      pointer-events:none;
    }
    .panel{
      max-width: min(680px, 92vw);
      border-radius: 18px;
      border: 1px solid rgba(255,255,255,.14);
      background: rgba(0,0,0,.26);
      backdrop-filter: blur(12px);
      box-shadow: 0 22px 80px rgba(0,0,0,.40);
      padding: 12px 14px;
      color: rgba(255,255,255,.88);
      line-height: 1.35;
    }
    .badge{
      display:inline-flex; align-items:center; gap:10px;
      padding: 8px 12px;
      border-radius: 999px;
      border: 1px solid rgba(255,255,255,.14);
      background: rgba(255,255,255,.06);
      backdrop-filter: blur(10px);
      box-shadow: 0 16px 60px rgba(0,0,0,.35);
      font-weight: 800;
      letter-spacing:.2px;
      width: fit-content;
      margin-bottom: 10px;
      color: rgba(255,255,255,.92);
    }
    .dot{
      width:10px;height:10px;border-radius:999px;
      background: rgba(255,230,170,.95);
      box-shadow: 0 0 18px rgba(255,230,170,.55);
      animation: pulse 1.6s ease-in-out infinite;
    }
    @keyframes pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.35)}}
    .small{ font-size: .98rem; opacity:.95; }

    /* progress */
    .progress{
      margin-top: 10px;
      display:flex;
      align-items:center;
      gap:8px;
      opacity:.92;
      font-weight: 850;
      letter-spacing:.3px;
      color: rgba(255,255,255,.86);
    }
    .p-dot{
      width: 10px; height: 10px;
      border-radius: 999px;
      border: 1px solid rgba(255,255,255,.24);
      background: rgba(255,255,255,.08);
      box-shadow: 0 0 0 rgba(0,0,0,0);
    }
    .p-dot.on{
      background: rgba(255,230,170,.92);
      border-color: rgba(255,230,170,.45);
      box-shadow: 0 0 18px rgba(255,230,170,.30);
    }
    .p-line{
      flex: 1;
      height: 2px;
      background: rgba(255,255,255,.10);
      border-radius: 99px;
      overflow:hidden;
    }
    .p-fill{
      height: 100%;
      width: 0%;
      background: linear-gradient(90deg, rgba(255,230,170,.75), rgba(170,140,255,.55));
      border-radius: 99px;
      transition: width .25s ease;
    }

    .bottom{
      position:fixed;
      left: 14px;
      right: 14px;
      bottom: 14px;
      z-index:4;
      display:flex;
      justify-content:space-between;
      gap: 10px;
      pointer-events:auto;
    }
    .btn{
      cursor:pointer;
      border: 1px solid rgba(255,255,255,.16);
      background: rgba(255,255,255,.06);
      color: rgba(255,255,255,.92);
      padding: 12px 14px;
      border-radius: 14px;
      font-weight: 850;
      letter-spacing:.2px;
      backdrop-filter: blur(12px);
      box-shadow: 0 16px 60px rgba(0,0,0,.35);
      user-select:none;
      touch-action: manipulation;
    }
    .btn:active{transform: translateY(1px)}
    .btn.primary{
      border-color: rgba(255,230,170,.22);
      background:
        radial-gradient(160px 80px at 20% 40%, rgba(255,230,170,.18), transparent 60%),
        radial-gradient(240px 120px at 70% 55%, rgba(170,140,255,.14), transparent 60%),
        rgba(255,255,255,.06);
    }

    .reveal{
      position:fixed; inset:0;
      z-index:5;
      display:grid;
      place-items:center;
      pointer-events:none;
      opacity:0;
      transform: scale(.98);
      transition: opacity .6s ease, transform .6s ease;
    }
    .reveal.on{ opacity:1; transform: scale(1); }
    .card{
      width: min(920px, 92vw);
      border-radius: 26px;
      border: 1px solid rgba(255,255,255,.16);
      background: rgba(0,0,0,.40);
      backdrop-filter: blur(14px);
      box-shadow: 0 50px 160px rgba(0,0,0,.60);
      padding: 22px 18px;
      text-align:center;
    }
    .card h1{
      font-size: clamp(2.6rem, 9vw, 5.8rem);
      line-height: 1.02;
      letter-spacing: -0.02em;
      margin-bottom: 12px;
      background: linear-gradient(90deg,
        rgba(255,255,255,.92),
        rgba(255,230,170,.95),
        rgba(170,140,255,.92),
        rgba(255,120,200,.90),
        rgba(255,255,255,.92));
      -webkit-background-clip:text;
      background-clip:text;
      color: transparent;
      background-size: 240% 100%;
      animation: shine 4.5s ease-in-out infinite;
      filter: drop-shadow(0 0 22px rgba(255,230,170,.18));
      text-transform: uppercase;
    }
    @keyframes shine{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
    .card p{
      font-size: clamp(1.05rem, 3.6vw, 1.45rem);
      color: rgba(255,255,255,.86);
      line-height: 1.45;
    }
    .sig{
      margin-top: 14px;
      font-size: .98rem;
      color: rgba(255,255,255,.68);
      letter-spacing:.2px;
    }
  </style>
</head>

<body>
  <div class="bg"><div class="fog"></div></div>
  <div class="vignette"></div>

  <canvas id="c"></canvas>

  <div class="ui">
    <div class="panel">
      <div class="badge"><span class="dot"></span><span id="phaseTitle">Ritual</span></div>
      <div class="small" id="instructions">
        Mantén el dedo en pantalla y <b>atraviesa</b> los glifos en orden (1 → 2 → 3) sin soltar.<br>
        Luego cruza el portal hacia el centro.
      </div>

      <div class="progress">
        <span class="p-dot" id="pd1"></span>
        <div class="p-line"><div class="p-fill" id="pfill"></div></div>
        <span class="p-dot" id="pd2"></span>
        <div class="p-line"><div class="p-fill" id="pfill2"></div></div>
        <span class="p-dot" id="pd3"></span>
      </div>
    </div>
  </div>

  <div class="bottom">
    <button class="btn" id="btnReset">Reiniciar</button>
    <button class="btn primary" id="btnSkip">Revelar</button>
  </div>

  <div class="reveal" id="reveal">
    <div class="card">
      <h1 id="big">VAMOS A COMER O ALGO :(</h1>
      <p id="small">Y no lo digo normal… lo invoco.</p>
      <div class="sig">— Robertito</div>
    </div>
  </div>

  <script>
    // ======= PERSONALIZA AQUÍ =======
    const MESSAGE_BIG = "VAMOS A COMER O ALGO :(";
    const MESSAGE_SMALL = "Y no lo digo normal… lo invoco.";
    document.getElementById('big').textContent = MESSAGE_BIG;
    document.getElementById('small').textContent = MESSAGE_SMALL;

    // ======= Canvas setup =======
    const canvas = document.getElementById('c');
    const ctx = canvas.getContext('2d');
    const reveal = document.getElementById('reveal');
    const phaseTitle = document.getElementById('phaseTitle');
    const instructions = document.getElementById('instructions');

    const pd1 = document.getElementById('pd1');
    const pd2 = document.getElementById('pd2');
    const pd3 = document.getElementById('pd3');
    const pfill = document.getElementById('pfill');
    const pfill2 = document.getElementById('pfill2');

    function resize(){
      const dpr = Math.max(1, Math.min(2, window.devicePixelRatio || 1));
      canvas.width = Math.floor(innerWidth * dpr);
      canvas.height = Math.floor(innerHeight * dpr);
      ctx.setTransform(dpr,0,0,dpr,0,0);
    }
    addEventListener('resize', resize);
    resize();

    const rand = (a,b)=> a + Math.random()*(b-a);
    const clamp = (v,a,b)=> Math.max(a, Math.min(b,v));
    const dist = (ax,ay,bx,by)=> Math.hypot(ax-bx, ay-by);

    // ======= State =======
    // phase 0: drag through glyphs 1->2->3 in one continuous gesture
    // phase 1: portal open, must pass from outside->inside crossing ring band
    // phase 2: revealed
    let phase = 0;

    let portal = { x: innerWidth*0.5, y: innerHeight*0.56, r: Math.min(innerWidth, innerHeight)*0.18, open: 0 };

    let glyphs = [];
    let trail = [];
    let sparks = [];
    let rings = [];

    // gesture state
    let pointerDown = false;
    let px = innerWidth/2, py = innerHeight/2;

    let glyphIndex = 0;               // next glyph to cross (0..2)
    let crossedThisGesture = false;   // prevent multi-trigger in same place
    let passState = { wasOutside: true, crossedRing: false };

    function layout(){
      portal.x = innerWidth*0.5;
      portal.y = innerHeight*0.58;
      portal.r = Math.min(innerWidth, innerHeight) * 0.18;

      const baseR = Math.min(innerWidth, innerHeight) * 0.06;
      const positions = [
        { x: innerWidth*0.28, y: innerHeight*0.42 },
        { x: innerWidth*0.72, y: innerHeight*0.44 },
        { x: innerWidth*0.50, y: innerHeight*0.30 },
      ];
      glyphs = positions.map((p,i)=>({
        id: i+1,
        x: p.x, y: p.y,
        r: baseR,
        lit: false,
        pulse: rand(0, Math.PI*2)
      }));
    }
    layout();
    addEventListener('resize', layout);

    function vibrate(ms){
      try{ if(navigator.vibrate) navigator.vibrate(ms); }catch(e){}
    }

    function setPhase(p){
      phase = p;
      if(phase === 0){
        phaseTitle.textContent = "Ritual";
        instructions.innerHTML =
          "Mantén el dedo en pantalla y <b>atraviesa</b> los glifos en orden (1 → 2 → 3) sin soltar.<br>" +
          "Luego cruza el portal hacia el centro.";
      }else if(phase === 1){
        phaseTitle.textContent = "Portal abierto";
        instructions.innerHTML =
          "Ahora cruza el portal: desliza tu dedo <b>desde afuera</b> hacia el <b>centro</b> pasando por el aro.";
      }else{
        phaseTitle.textContent = "Revelado";
        instructions.innerHTML = "💫";
      }
      updateProgressUI();
    }

    function updateProgressUI(){
      pd1.classList.toggle('on', glyphIndex >= 1);
      pd2.classList.toggle('on', glyphIndex >= 2);
      pd3.classList.toggle('on', glyphIndex >= 3);
      pfill.style.width = (glyphIndex >= 2 ? "100%" : (glyphIndex >= 1 ? "50%" : "0%"));
      pfill2.style.width = (glyphIndex >= 3 ? "100%" : (glyphIndex >= 2 ? "50%" : "0%"));
    }

    function resetAll(){
      reveal.classList.remove('on');
      phase = 0;
      glyphIndex = 0;
      glyphs.forEach(g=> g.lit = false);
      portal.open = 0;
      trail.length = 0;
      sparks.length = 0;
      rings.length = 0;
      passState = { wasOutside: true, crossedRing: false };
      updateProgressUI();
      setPhase(0);
    }

    // Buttons
    document.getElementById('btnReset').addEventListener('click', resetAll);
    document.getElementById('btnSkip').addEventListener('click', ()=>{ triggerSpell(portal.x, portal.y, portal.r); revealNow(); });

    function revealNow(){
      if(phase === 2) return;
      setPhase(2);
      reveal.classList.add('on');
      vibrate(35);
      document.body.animate([
        { transform:'translate(0,0)' },
        { transform:'translate(-2px,1px)' },
        { transform:'translate(2px,-1px)' },
        { transform:'translate(0,0)' }
      ], { duration: 260, easing:'ease-out' });
    }

    // ======= FX =======
    function burst(x,y,count){
      for(let i=0;i<count;i++){
        const a = rand(0, Math.PI*2);
        const sp = rand(90, 640);
        sparks.push({
          x, y,
          vx: Math.cos(a)*sp,
          vy: Math.sin(a)*sp,
          life: rand(0.75, 1.35),
          t: 0,
          s: rand(1.4, 2.8)
        });
      }
    }

    function triggerSpell(x,y,r){
      for(let i=0;i<5;i++){
        rings.push({
          x,y,
          r: r*(0.45 + i*0.18),
          a: 0,
          life: 1,
          speed: 0.7 + i*0.35
        });
      }
      burst(x,y, 220);
    }

    // ======= Input logic (drag-through) =======
    function onPointerMove(x,y){
      px = x; py = y;

      // trail
      trail.push({ x, y, life: 1, s: rand(2.2, 4.2), j: rand(0.8,1.4) });
      if(trail.length > 170) trail.shift();

      if(!pointerDown) return;

      if(phase === 0){
        // Must cross glyphs in order without lifting finger.
        const g = glyphs[glyphIndex];
        if(g){
          const d = dist(x,y,g.x,g.y);
          if(d < g.r*1.15 && !crossedThisGesture){
            crossedThisGesture = true;
            g.lit = true;
            glyphIndex++;
            updateProgressUI();
            vibrate(18);
            burst(g.x, g.y, 90);

            // small ring emphasis
            rings.push({ x:g.x, y:g.y, r:g.r*0.75, a:0, life:0.85, speed:1.2 });

            if(glyphIndex >= glyphs.length){
              // open portal
              setPhase(1);
              vibrate(28);
              portal.open = 0.001;
              passState = { wasOutside: true, crossedRing: false };
              burst(portal.x, portal.y, 160);
            }
          }
          // allow next trigger when pointer exits current glyph
          if(d > g.r*1.45){
            crossedThisGesture = false;
          }
        }
      }else if(phase === 1){
        const d = dist(x,y, portal.x, portal.y);
        if(d > portal.r*1.15) passState.wasOutside = true;
        if(passState.wasOutside && d > portal.r*0.88 && d < portal.r*1.06){
          passState.crossedRing = true;
        }
        if(passState.wasOutside && passState.crossedRing && d < portal.r*0.55){
          triggerSpell(portal.x, portal.y, portal.r);
          revealNow();
        }
      }
    }

    function onPointerDown(x,y){
      pointerDown = true;
      crossedThisGesture = false;
      onPointerMove(x,y);

      if(phase === 0){
        // Start from wherever, but must keep finger down until finish.
        // No “tap” activation, only move-through.
      }else if(phase === 1){
        const d = dist(x,y, portal.x, portal.y);
        passState = { wasOutside: d > portal.r*1.15, crossedRing: false };
      }
    }

    function onPointerUp(){
      if(phase === 0 && glyphIndex > 0 && glyphIndex < 3){
        // If user lifted too soon -> reset ritual step (feels like “failed spell”)
        glyphIndex = 0;
        glyphs.forEach(g=> g.lit = false);
        updateProgressUI();
        burst(px, py, 40);
        vibrate(22);
      }
      pointerDown = false;
      crossedThisGesture = false;
      if(phase === 1) passState.crossedRing = false;
    }

    addEventListener('pointerdown', (e)=> { onPointerDown(e.clientX, e.clientY); });
    addEventListener('pointermove', (e)=> { onPointerMove(e.clientX, e.clientY); });
    addEventListener('pointerup', onPointerUp);
    addEventListener('pointercancel', onPointerUp);

    // ======= Render =======
    let last = performance.now();
    function loop(now){
      const dt = Math.min(0.033, (now - last)/1000);
      last = now;

      ctx.clearRect(0,0, innerWidth, innerHeight);

      // trail
      for(let i=trail.length-1;i>=0;i--){
        const p = trail[i];
        p.life -= dt * 1.25;
        if(p.life <= 0){ trail.splice(i,1); continue; }
        const a = p.life;
        const glowR = 24 * p.j;

        const g = ctx.createRadialGradient(p.x,p.y, 0, p.x,p.y, glowR);
        g.addColorStop(0, `rgba(255,230,170,${0.20*a})`);
        g.addColorStop(0.35,`rgba(170,140,255,${0.13*a})`);
        g.addColorStop(1, 'rgba(0,0,0,0)');
        ctx.fillStyle = g;
        ctx.beginPath();
        ctx.arc(p.x,p.y, glowR, 0, Math.PI*2);
        ctx.fill();

        ctx.fillStyle = `rgba(255,255,255,${0.22*a})`;
        ctx.beginPath();
        ctx.arc(p.x,p.y, p.s, 0, Math.PI*2);
        ctx.fill();
      }

      // glyphs (always visible until portal opens, then faint)
      for(const g of glyphs){
        g.pulse += dt*2.2;
        const tw = 0.6 + 0.4*Math.sin(g.pulse);
        const lit = g.lit ? 1 : 0;
        const fade = (phase === 1 || phase === 2) ? 0.35 : 1;

        const gg = ctx.createRadialGradient(g.x,g.y, 0, g.x,g.y, g.r*3.8);
        gg.addColorStop(0, `rgba(255,230,170,${((0.10 + 0.10*tw) + lit*0.13)*fade})`);
        gg.addColorStop(0.35,`rgba(170,140,255,${((0.06 + 0.08*tw) + lit*0.10)*fade})`);
        gg.addColorStop(1, 'rgba(0,0,0,0)');
        ctx.fillStyle = gg;
        ctx.beginPath();
        ctx.arc(g.x,g.y, g.r*3.8, 0, Math.PI*2);
        ctx.fill();

        ctx.lineWidth = 2;
        ctx.strokeStyle = g.lit ? `rgba(255,230,170,${0.60*fade})` : `rgba(255,255,255,${0.18*fade})`;
        ctx.beginPath();
        ctx.arc(g.x,g.y, g.r*(1.05 + 0.06*tw), 0, Math.PI*2);
        ctx.stroke();

        ctx.fillStyle = g.lit ? `rgba(255,250,240,${0.95*fade})` : `rgba(255,255,255,${0.78*fade})`;
        ctx.font = `900 ${Math.floor(g.r*0.9)}px ui-sans-serif, system-ui`;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(String(g.id), g.x, g.y + 1);
      }

      // portal open animation
      if(phase >= 1){
        portal.open = clamp(portal.open + dt*1.2, 0, 1);
        const k = portal.open;
        const wob = 0.85 + 0.15*Math.sin(now*0.012);
        const rr = portal.r * (0.55 + 0.45*k) * wob;

        const halo = ctx.createRadialGradient(portal.x, portal.y, rr*0.2, portal.x, portal.y, rr*1.35);
        halo.addColorStop(0, 'rgba(0,0,0,0)');
        halo.addColorStop(0.55, `rgba(255,230,170,${0.11*k})`);
        halo.addColorStop(0.80, `rgba(170,140,255,${0.085*k})`);
        halo.addColorStop(1, 'rgba(0,0,0,0)');
        ctx.fillStyle = halo;
        ctx.beginPath();
        ctx.arc(portal.x, portal.y, rr*1.35, 0, Math.PI*2);
        ctx.fill();

        ctx.lineWidth = 3;
        ctx.strokeStyle = `rgba(255,230,170,${0.18 + 0.18*k})`;
        ctx.beginPath();
        ctx.arc(portal.x, portal.y, rr, 0, Math.PI*2);
        ctx.stroke();

        for(let i=0;i<110;i++){
          const a = (i/110)*Math.PI*2 + now*0.0009;
          const x = portal.x + Math.cos(a)*rr;
          const y = portal.y + Math.sin(a)*rr;
          ctx.fillStyle = `rgba(255,230,170,${0.10*k})`;
          ctx.beginPath();
          ctx.arc(x,y, 1.5, 0, Math.PI*2);
          ctx.fill();
        }

        if(phase === 1){
          const alpha = 0.05 + 0.07*Math.sin(now*0.004);
          ctx.lineWidth = 1.5;
          ctx.strokeStyle = `rgba(234,242,255,${alpha})`;
          ctx.beginPath();
          ctx.moveTo(px,py);
          ctx.lineTo(portal.x, portal.y);
          ctx.stroke();
        }
      }

      // rings
      for(let i=rings.length-1;i>=0;i--){
        const r = rings[i];
        r.life -= dt * 0.55;
        r.a += dt * r.speed;
        if(r.life <= 0){ rings.splice(i,1); continue; }

        const alpha = Math.max(0, r.life);
        const rr = r.r * (1 + (1-r.life)*1.7);
        const wob = 6 * Math.sin(r.a*3);

        const g = ctx.createRadialGradient(r.x,r.y, rr*0.2, r.x,r.y, rr*1.2);
        g.addColorStop(0, 'rgba(0,0,0,0)');
        g.addColorStop(0.55,`rgba(255,230,170,${0.10*alpha})`);
        g.addColorStop(0.85,`rgba(170,140,255,${0.08*alpha})`);
        g.addColorStop(1, 'rgba(0,0,0,0)');
        ctx.fillStyle = g;
        ctx.beginPath();
        ctx.arc(r.x,r.y, rr*1.2, 0, Math.PI*2);
        ctx.fill();

        ctx.lineWidth = 2.5;
        ctx.strokeStyle = `rgba(255,230,170,${0.22*alpha})`;
        ctx.beginPath();
        ctx.arc(r.x,r.y, rr + wob, 0, Math.PI*2);
        ctx.stroke();
      }

      // sparks
      for(let i=sparks.length-1;i>=0;i--){
        const s = sparks[i];
        s.t += dt;
        const life = s.life - s.t;
        if(life <= 0){ sparks.splice(i,1); continue; }

        s.x += s.vx * dt;
        s.y += s.vy * dt;
        s.vx *= (1 - dt*1.7);
        s.vy *= (1 - dt*1.7);

        const a = Math.max(0, life / s.life);

        const g = ctx.createRadialGradient(s.x,s.y,0, s.x,s.y, 28);
        g.addColorStop(0, `rgba(255,255,255,${0.12*a})`);
        g.addColorStop(0.25,`rgba(255,230,170,${0.10*a})`);
        g.addColorStop(0.6, `rgba(170,140,255,${0.08*a})`);
        g.addColorStop(1,'rgba(0,0,0,0)');
        ctx.fillStyle = g;
        ctx.beginPath();
        ctx.arc(s.x,s.y, 28, 0, Math.PI*2);
        ctx.fill();

        ctx.fillStyle = `rgba(255,255,255,${0.55*a})`;
        ctx.beginPath();
        ctx.arc(s.x,s.y, s.s, 0, Math.PI*2);
        ctx.fill();
      }

      requestAnimationFrame(loop);
    }
    requestAnimationFrame(loop);

    // init
    setPhase(0);
    updateProgressUI();
  </script>
</body>
</html>
