<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Baby Shower — Anya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('favicon.ico') }}">

  <!-- Fuentes y librerías livianas -->
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/plantillas/convivios/plantilla001.css') }}?v={{ time() }}">
</head>
<body>

@php
  /* ====== Config rápida ====== */
  use Carbon\Carbon;
  $evento = [
      'nombre_bebe' => 'Anya',
      'fecha'       => '2025-10-25',  /* YYYY-MM-DD */
      'hora'        => '14:00',       /* 24h */
      'lugar'       => 'Por confirmar',
      'rsvp'        => '452-165-9680',
      'frase_larga' => 'Con mucho amor y alegría te invitamos a compartir un momento especial mientras nos preparamos para recibir a nuestra pequeña princesa'
  ];
  $dt   = Carbon::parse($evento['fecha']);
  $dias = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
  $meses= ['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
  $diaNombre = ucfirst($dias[$dt->dayOfWeek]);
  $diaNum    = $dt->format('d');
  $mesTxt    = $meses[$dt->month-1];

  $numPlano = preg_replace('/\D+/', '', $evento['rsvp']);     // 4521659680
  if (substr($numPlano, 0, 2) !== '52') $numPlano = '52'.$numPlano; // MX (+52)

  $hora12   = \Carbon\Carbon::parse($evento['hora'])->isoFormat('h:mm A');
  $fechaTxt = "{$diaNombre} {$diaNum} de {$mesTxt}";
  $waText   = "Hola, confirmo asistencia al baby shower de {$evento['nombre_bebe']} el {$fechaTxt} a las {$hora12}.";
  $waURL    = "https://wa.me/{$numPlano}?text=" . rawurlencode($waText);
@endphp

<!-- ====== INTRO DE 20 SEGUNDOS ====== -->
<section id="intro" class="intro">
  <button id="skipIntro" class="intro__skip">Saltar</button>

  <div class="intro__content animate__animated animate__fadeIn">
    <div class="intro__line-1">Con el gusto de invitarte</div>
    <div class="intro__line-2 mt-3">
      a celebrar mi cumpleaños y la llegada de nuestra bebé
    </div>

    <div class="mt-4">
      <img src="{{ asset('images/baby/centro-globo.gif') }}" alt="" style="max-width:240px; opacity:.95">
    </div>
  </div>

  <div class="intro__progress"><div class="intro__bar"></div></div>
</section>

<!-- ====== TARJETA PRINCIPAL ====== -->
<main class="invite" id="invite">
  <article class="card-baby">
    <div class="ribbon" aria-hidden="true"></div>

    <div class="inner">
      <div class="badge-top"><span>¡ES NIÑA!</span></div>

      <h1 class="title animate__animated animate__fadeInDown">¡Es niña!</h1>
      <p class="subtitle animate__animated animate__fadeInUp">
        {{ $evento['frase_larga'] }}
      </p>

      <div class="centerpiece">
        <img src="{{ asset('images/baby/globo_osito_bobbing.gif') }}" alt="Globo con osito">
      </div>

      <div class="text-center my-2">
        <span class="name-banner">{{ $evento['nombre_bebe'] }}</span>
      </div>

      <div class="when">
        <div class="divider"></div>
        <div class="date-block">
          <div class="date-box">
            <h4>{{ $diaNombre }}</h4>
            <div class="small">DÍA</div>
          </div>

          <div class="date-box">
            <div class="big">{{ $diaNum }}</div>
            <div class="small">{{ $mesTxt }}</div>
          </div>

          <div class="date-box">
            <h4>{{ \Carbon\Carbon::parse($evento['hora'])->format('g:i') }} <small style="font-weight:800;">{{ \Carbon\Carbon::parse($evento['hora'])->format('A') }}</small></h4>
            <div class="small">HORA</div>
          </div>
        </div>
        <div class="divider"></div>
      </div>

      <p class="place">
        <strong>Lugar:</strong> {{ $evento['lugar'] }}
      </p>

        <p class="rsvp">
          Confirma tu asistencia:&nbsp;
          <a href="{{ $waURL }}" class="btn btn-success btn-sm" target="_blank" rel="noopener">
            Confirmar por WhatsApp
          </a>
        </p>


      <div class="footer-pink">
        <!-- footer -->
        <img src="{{ asset('images/baby/footer.png') }}" alt="" style="height:46px; opacity:.9">
      </div>
    </div>
  </article>
</main>

<!-- Audio opcional -->
<audio id="bg-audio" preload="auto">
  <source src="{{ asset('audio/baby/tema.mp3') }}" type="audio/mpeg">
</audio>

<script>
  // ====== Control de intro (20s) ======
  const INTRO_MS = 3000; /* 3 segundos */
  const intro = document.getElementById('intro');
  const skip  = document.getElementById('skipIntro');
  const audio = document.getElementById('bg-audio');

  let introTimeout = setTimeout(hideIntro, INTRO_MS);
  skip.addEventListener('click', hideIntro);

  function hideIntro(){
    if(!intro) return;
    clearTimeout(introTimeout);
    intro.classList.add('intro--hide');
    setTimeout(()=> intro.remove(), 800);
    audio.play().catch(()=>{});
  }

    // ====== Hearts suaves subiendo (decorativo) ======
    const heartsLayer = document.createElement('div');
    heartsLayer.className = 'hearts-layer';
    document.body.appendChild(heartsLayer);

    let heartsInterval = setInterval(()=>{
      const h = document.createElement('div');
      h.className = 'heart';
      h.style.left = (Math.random()*100)+'vw';
      h.style.bottom = '-20px';
      h.style.background = `hsl(${330 + Math.random()*20}, 85%, 75%)`;
      h.style.animationDuration = (6 + Math.random()*6)+'s';
      h.style.opacity = .08 + Math.random()*.12;
      heartsLayer.appendChild(h);
      setTimeout(()=>h.remove(), 14000);
    }, 300);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
