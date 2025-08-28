<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <title>{{ $rifa->titulo }} — Rifa con causa</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

  <style>
    :root{
      --primary:#ff6a3d;
      --primary-2:#ff3d7f;
      --accent:#ffd166;
      --dark:#0f1226;
      --glass-bg:rgba(255,255,255,.08);
      --glass-br:rgba(255,255,255,.2);
    }
    *{box-sizing:border-box}
    html,body{height:100%;background:radial-gradient(1200px 800px at 10% 10%, #1a1f3a, #0a0c1a 60%, #070814);color:#f3f6ff}
    body{font-family:Poppins, system-ui, -apple-system, Segoe UI, Roboto, sans-serif; overflow-x:hidden}

    /* HERO */
    .hero{
      position:relative; min-height:56vh; display:flex; align-items:center; justify-content:center; overflow:hidden;
      isolation:isolate; /* FIX: stacking propio */
    }
    .hero::before{
      content:""; position:absolute; inset:0;
      background-image: linear-gradient(45deg, rgba(255,106,61,.3), rgba(255,61,127,.3)),
                        url('{{ $rifa->imagen ?? "https://images.unsplash.com/photo-1520975922284-5f5730c5a91d?q=80&w=2070&auto=format&fit=crop" }}');
      background-size:cover; background-position:center;
      filter: saturate(1.15) brightness(.75) blur(1px);
      transform: scale(1.02);
      z-index:0; pointer-events:none !important; /* FIX clicks */
    }
    .hero::after{
      content:""; position:absolute; inset:0; background:
        radial-gradient(80% 120% at 20% 0%, rgba(255,255,255,.08), transparent 60%),
        linear-gradient(to top, rgba(7,8,20,.75), rgba(7,8,20,0) 60%);
      z-index:0; pointer-events:none !important; /* FIX clicks */
    }
    .halo{
      position:absolute; width:120vmax; height:120vmax; border-radius:50%;
      background: conic-gradient(from 0deg, var(--primary), var(--primary-2), var(--accent), var(--primary));
      filter: blur(80px) opacity(.08); animation: spin 30s linear infinite;
      z-index:0; pointer-events:none !important; /* FIX clicks */
    }
    @keyframes spin{to{transform: rotate(360deg)}}

    .hero-content{position:relative; text-align:center; max-width:1100px; padding:32px; z-index:3}
    .title{
      font-family: "Playfair Display", serif;
      font-weight:900; letter-spacing:.5px; line-height:1.05;
      font-size: clamp(2.2rem, 6.8vw, 4.2rem);
      margin:0; background: linear-gradient(90deg,#fff, #ffdede);
      -webkit-background-clip:text; background-clip:text; color:transparent;
      text-shadow: 0 8px 40px rgba(255,97,97,.25);
    }
    .cause{
      margin-top:.5rem; font-weight:600; font-size:clamp(1rem, 2.4vw, 1.25rem);
      color:#fff; opacity:.95;
    }
    .cause .chip{
      display:inline-block; padding:.35rem .7rem; border-radius:999px;
      background: rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.18);
      backdrop-filter: blur(6px);
    }
    .mantra{
      margin-top:1rem; font-weight:300; font-size:clamp(.95rem, 2.2vw, 1.1rem);
      color:#e8ecff; opacity:.9
    }
    .mantra strong{color:#fff; font-weight:700}

    /* CARD GLASS */
    .glass{
      background: var(--glass-bg);
      border:1px solid var(--glass-br);
      border-radius:24px; padding:22px; backdrop-filter: blur(10px);
      box-shadow: 0 10px 40px rgba(0,0,0,.25);
      position:relative; z-index:4; /* arriba de overlays */
    }
    .metric{
      display:flex; align-items:baseline; gap:.4rem; color:#fff
    }
    .metric .n{
      font-weight:800; font-size:clamp(1.6rem, 4.8vw, 2.6rem); line-height:1;
    }
    .metric .sub{opacity:.8; font-size:.95rem}

    /* PROGRESO */
    .progress-wrap{margin:.6rem 0 1rem}
    .progress{
      height:14px; background:rgba(255,255,255,.12); border-radius:999px; overflow:hidden
    }
    .progress-bar{
      background: linear-gradient(90deg, var(--primary), var(--primary-2));
    }
    .tag{
      display:inline-flex; align-items:center; gap:.4rem; padding:.35rem .7rem; border-radius:999px;
      border:1px solid rgba(255,255,255,.18); background:rgba(255,255,255,.07); font-size:.9rem
    }

    /* GRID NÚMEROS */
    .numbers{
      display:grid; grid-template-columns:repeat(4,1fr); gap:10px; max-height:380px; overflow:auto; padding:6px;
      position:relative; z-index:4; /* arriba de overlays */
    }
    @media (min-width: 560px){ .numbers{ grid-template-columns:repeat(6,1fr)} }
    @media (min-width: 992px){ .numbers{ grid-template-columns:repeat(8,1fr)} }
    .num{
      position:relative; display:block; width:100%; border:none; border-radius:14px;
      padding:.8rem .6rem; text-align:center; font-weight:700; color:#0a0c1a;
      background:#fff; cursor:pointer; transition:.15s transform, .15s box-shadow, .15s opacity;
      box-shadow: 0 4px 16px rgba(255,255,255,.08), inset 0 -2px 0 rgba(0,0,0,.08);
      user-select:none; pointer-events:auto;
    }
    .num:hover{ transform: translateY(-2px) }
    .num[disabled]{ opacity:.35; text-decoration: line-through; cursor:not-allowed; background:#eaeaea; color:#666 }
    .num.selected{
      background: linear-gradient(180deg,#ffe8ef, #ffd7eb);
      box-shadow:0 6px 18px rgba(255,61,127,.35), inset 0 -2px 0 rgba(0,0,0,.06);
      color:#7a0c3a; outline:2px solid rgba(255,61,127,.45)
    }
    /* Checkbox invisible pero presente */
    .vh-check{
      position:absolute; inset:0; opacity:0; pointer-events:none;
    }

    /* CTA STICKY */
    .cta-sticky{
      position:sticky; bottom:10px; z-index:5; display:flex; justify-content:center; margin-top:10px
    }
    .btn-joy{
      --p: var(--primary); --q: var(--primary-2);
      border:none; border-radius:16px; padding:.95rem 1.1rem; font-weight:800; letter-spacing:.3px;
      background: linear-gradient(90deg, var(--p), var(--q));
      box-shadow: 0 10px 28px rgba(255,61,127,.35);
    }
    .btn-joy:hover{ filter:brightness(1.05); transform:translateY(-1px) }

    /* EMOJI CONFETTI */
    .confetti{ position:fixed; top:-10vh; font-size:18px; pointer-events:none; animation: fall linear forwards }
    @keyframes fall{
      from{ transform: translateY(-10vh) rotate(0deg) }
      to{ transform: translateY(120vh) rotate(360deg) }
    }

    .footer-note{opacity:.7; font-size:.9rem}
    .divider{height:1px; background:linear-gradient(90deg, transparent, rgba(255,255,255,.25), transparent); margin:10px 0 16px}
    .shadow-soft{ box-shadow: 0 10px 40px rgba(0,0,0,.28) }
  </style>
</head>
<body>

  <section class="hero">
    <div class="halo"></div>
    <div class="hero-content">
      <h1 class="title">{{ $rifa->titulo }}</h1>
      <div class="cause mt-2">
        <span class="chip"><i class="fa-solid fa-heart me-1"></i> {{ $rifa->causa }}</span>
      </div>
      <p class="mantra">
        Cada boleto es un <strong>abrazo</strong> que llega a tiempo. Gracias por sumar luz cuando más se necesita. <i class="fa-solid fa-sparkles"></i>
      </p>

      <div class="container px-0 mt-4">
        @php
          $vendidos = (int)($vendidos ?? 0);
          $total    = (int)($rifa->total_boletos ?? 0);
          $restan   = max($total - $vendidos, 0);
          $pct      = $total > 0 ? round(($vendidos / $total) * 100) : 0;
          $precio   = (float)($rifa->precio_boleto ?? 0);
        @endphp

        <div class="row g-3">
          <div class="col-md-8">
            <div class="glass shadow-soft">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="metric">
                  <span class="n">${{ number_format($precio,2) }}</span>
                  <span class="sub">por boleto</span>
                </div>
                <div class="tag"><i class="fa-regular fa-clock me-2"></i> Vigencia:
                  <span class="ms-1">
                    {{ optional($rifa->fecha_inicio)->format('d/m/Y H:i') }} — {{ optional($rifa->fecha_fin)->format('d/m/Y H:i') }}
                  </span>
                </div>
                <div class="tag text-uppercase"><strong>{{ $rifa->estado }}</strong></div>
              </div>

              <div class="progress-wrap">
                <div class="d-flex justify-content-between small mb-1">
                  <span>Avance</span>
                  <span>{{ $vendidos }} / {{ $total }} ({{ $pct }}%)</span>
                </div>
                <div class="progress" role="progressbar" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar" style="width: {{ $pct }}%"></div>
                </div>
              </div>

              <div class="divider"></div>

              <div class="mb-2">
                <p class="mb-0" style="white-space:pre-line">{{ $rifa->descripcion }}</p>
              </div>
            </div>

            <div class="glass mt-3 shadow-soft">
              <form method="POST" action="{{ route('rifas.reservar', $rifa) }}" id="formReservar">
                @csrf
                <input type="hidden" name="minutos" value="15">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                  <h5 class="mb-0"><i class="fa-solid fa-ticket me-2"></i>Selecciona tus números</h5>
                  <div class="small opacity-75">
                    Máx por persona:
                    <strong>{{ $rifa->max_boletos_por_usuario ?? 'Sin límite' }}</strong>
                  </div>
                </div>

                @php
                  $desde = (int)$rifa->numeracion_desde;
                  $hasta = (int)$rifa->numeracion_hasta;
                  $setDisponibles = collect($disponibles ?? [])->flip();
                @endphp

                <div class="numbers">
                  @for($n=$desde; $n<=$hasta; $n++)
                    @php $free = $setDisponibles->has($n); @endphp
                    <label class="num" {{ $free ? '' : 'disabled' }}>
                      <input type="checkbox" class="pick vh-check" name="numeros[]" value="{{ $n }}" {{ $free ? '' : 'disabled' }}>
                      #{{ $n }}
                    </label>
                  @endfor
                </div>

                <div class="cta-sticky mt-3">
                  <button type="submit" class="btn btn-joy text-white">
                    <i class="fa-solid fa-hourglass-half me-2"></i>Reservar 15 minutos
                  </button>
                </div>
              </form>
            </div>

            <div class="glass mt-3 shadow-soft">
              <form method="POST" action="{{ route('rifas.pagar', $rifa) }}" id="formPagar">
                @csrf
                <h5 class="mb-2"><i class="fa-solid fa-hand-holding-heart me-2"></i>Pagar ahora</h5>
                <div class="row g-2">
                  <div class="col-12">
                    <label class="form-label small">Pega aquí tus números seleccionados (ej. 10,11,12)</label>
                    <input type="text" class="form-control" name="numeros_manual" placeholder="Ej: 10,11,12">
                    <input type="hidden" name="numeros[]" id="numerosHidden">
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label">Método de pago *</label>
                    <select name="metodo_pago" class="form-select" required>
                      <option value="efectivo">Efectivo</option>
                      <option value="transferencia">Transferencia</option>
                      <option value="oxxo">OXXO</option>
                    </select>
                  </div>
                  <div class="col-sm-8">
                    <label class="form-label">Referencia</label>
                    <input type="text" name="referencia_pago" class="form-control" placeholder="Últimos 4, folio o nota">
                  </div>
                </div>

                <div class="row g-2 mt-1">
                  <div class="col-md-4">
                    <label class="form-label">Nombre comprador</label>
                    <input type="text" name="comprador_nombre" class="form-control">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="comprador_telefono" class="form-control">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="comprador_email" class="form-control">
                  </div>
                </div>

                <div class="cta-sticky mt-3">
                  <button type="submit" class="btn btn-success fw-bold px-4"
                    onclick="document.getElementById('numerosHidden').setAttribute('name','numeros[]');document.getElementById('numerosHidden').value='';if(document.querySelector('[name=numeros_manual]').value.trim()){document.getElementById('numerosHidden').value=document.querySelector('[name=numeros_manual]').value.split(',').map(s=>s.trim()).filter(Boolean).join(',');}">
                    <i class="fa-solid fa-bolt me-2"></i>Pagar ahora
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="col-md-4">
            <div class="glass shadow-soft">
              @if($rifa->imagen)
                <img src="{{ $rifa->imagen }}" class="img-fluid rounded mb-2" alt="Portada de la rifa">
              @endif
              <div class="d-grid gap-2">
                <div class="metric"><span class="n">{{ $vendidos }}</span><span class="sub">vendidos</span></div>
                <div class="metric"><span class="n">{{ $restan }}</span><span class="sub">disponibles</span></div>
                <div class="metric"><span class="n">${{ number_format($vendidos * $precio, 2) }}</span><span class="sub">recaudado</span></div>
              </div>
              <div class="divider"></div>
              <div class="small">
                <div class="mb-1"><i class="fa-solid fa-circle-info me-2"></i>Máx por usuario: <strong>{{ $rifa->max_boletos_por_usuario ?? 'Sin límite' }}</strong></div>
                <div class="mb-1"><i class="fa-regular fa-calendar me-2"></i><span id="countdown">–</span></div>
              </div>

              @auth
                <a href="{{ route('rifas.mis_boletos', $rifa) }}" class="btn btn-outline-light w-100 mt-2">
                  <i class="fa-solid fa-ticket me-2"></i>Mis boletos
                </a>
              @endauth
            </div>

            <div class="footer-note text-center mt-3">
              <i class="fa-solid fa-heart"></i> Gracias por creer. Tu ayuda cambia historias.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  @if(session('success'))
    <div class="container mt-3">
      <div class="alert alert-success glass border-0">
        <i class="fa-solid fa-party-horn me-2"></i>{{ session('success') }}
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="container mt-3">
      <div class="alert alert-danger glass border-0">
        <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
      </div>
    </div>
  @endif

  <script>
    // --- Config global para usar en todos lados ---
    const MAX_PER = {{ (int)($rifa->max_boletos_por_usuario ?? 0) }};

    function countSelected(){
      return Array.from(document.querySelectorAll('.pick')).filter(x => x.checked).length;
    }
    function syncSelected(){
      document.querySelectorAll('.num').forEach(el=>{
        const input = el.querySelector('input.pick');
        if(input) el.classList.toggle('selected', input.checked);
      });
    }
    function enforceMax(triggerInput){
      if(!MAX_PER || MAX_PER <= 0) return true;
      const current = countSelected();
      if(current > MAX_PER){
        if(triggerInput){ triggerInput.checked = false; }
        alert(`Máximo permitido: ${MAX_PER} boletos por persona.`);
        syncSelected();
        return false;
      }
      return true;
    }

    // Límite por usuario + sincronización cuando cambie el checkbox
    (function(){
      const picks = document.querySelectorAll('.pick');
      picks.forEach(cb => cb.addEventListener('change', () => {
        enforceMax(cb);
        syncSelected();
      }));
      syncSelected();
    })();

    // Click sobre la tarjeta del número (label .num)
    (function(){
      document.querySelectorAll('.num').forEach(btn=>{
        const input = btn.querySelector('input.pick');
        if(!input || input.disabled) return;
        btn.addEventListener('click', (e)=>{
          if(e.target.tagName !== 'INPUT'){
            input.checked = !input.checked;                 // toggle manual
            if(!enforceMax(input)){ return; }               // respeta máximo
            syncSelected();                                  // pinta seleccionado
          }
        });
      });
    })();

    // Countdown a fecha_fin
    (function(){
      const end = `{{ optional($rifa->fecha_fin)->format('Y-m-d H:i:s') }}`;
      const out = document.getElementById('countdown');
      if(!end || !out) return;
      const endDate = new Date(end.replace(' ', 'T'));
      function tick(){
        const diff = endDate - new Date();
        if(diff <= 0){ out.textContent = 'Cerrado'; return; }
        const d = Math.floor(diff/86400000);
        const h = Math.floor((diff%86400000)/3600000);
        const m = Math.floor((diff%3600000)/60000);
        const s = Math.floor((diff%60000)/1000);
        out.textContent = `Cierra en ${d}d ${String(h).padStart(2,'0')}h ${String(m).padStart(2,'0')}m ${String(s).padStart(2,'0')}s`;
        requestAnimationFrame(()=>setTimeout(tick, 250));
      }
      tick();
    })();

    // Confetti de emojis cuando hay success
    (function(){
      const hasSuccess = {{ session('success') ? 'true' : 'false' }};
      if(!hasSuccess) return;
      const EMO = ["💖","✨","🎉","🎊","💝","💫","🫶"];
      for(let i=0;i<80;i++){
        const e = document.createElement('div');
        e.className='confetti';
        e.textContent = EMO[Math.floor(Math.random()*EMO.length)];
        e.style.left = Math.random()*100 + 'vw';
        e.style.animationDuration = (4 + Math.random()*3) + 's';
        e.style.fontSize = (16 + Math.random()*14) + 'px';
        e.style.filter = 'drop-shadow(0 4px 6px rgba(0,0,0,.2))';
        document.body.appendChild(e);
        setTimeout(()=>e.remove(), 8000);
      }
    })();
  </script>

</body>
</html>
