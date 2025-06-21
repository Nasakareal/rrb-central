<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <meta charset="UTF-8">
  <title>Invitación de XV Años • Camila Millan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <!-- Bootstrap & Animate.css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Tipografías -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Great+Vibes&display=swap"
        rel="stylesheet">

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/plantillas/graduacion/plantilla001.css') }}?v={{ time() }}">


</head>
<body>
    <audio id="bg-audio" autoplay loop>
        <source src="{{ asset('images/plantillas/xv/plantilla001/song.mp3') }}" type="audio/mpeg">
        Tu navegador no soporta audio HTML5.
    </audio>

    <!-- 1) HERO DE LA QUINCEAÑERA -->
    <section class="hero">
        <img src="{{ asset('images/plantillas/graduacion/plantilla001/demon.jpg') }}"
             alt="Foto de los novios">
    </section>

    <!-- 2) RECUERDO -->
    <section class="memory animate__animated animate__fadeInUp">
      <div class="container">

        <img src="{{ asset('images/plantillas/graduacion/plantilla001/school.jpg') }}" alt="Instituto Rousvelt Morelia" class="logo">

        <div class="icon">
          <img src="{{ asset('images/plantillas/graduacion/plantilla001/education.png') }}" alt="Birrete">
        </div>

        <p class="intro">Instituto Rousvelt Morelia, tiene el honor de invitarlo a la:</p>

        <h1 class="title">Ceremonia de Graduación</h1>

        <div class="generation-banner">
          <span class="generation-text">2021 – 2025</span>
        </div>

        <div class="date-time">
          <div class="day-of-week">Jueves</div>
          <div class="day-number">10</div>
          <div class="time">10:00 hrs.</div>
        </div>

        <p class="footer">Instalaciones del Instituto Rousvelt Morelia</p>

      </div>
    </section>


    <!-- 3) TARJETA BLANCA CON INFO Y PADRINOS -->
    <section class="info-card animate__animated animate__fadeInUp">
      <!-- ... (todo lo que ya tienes antes) ... -->

      <p class="invite-text">
        Con la bendición de Dios y el amor de mi familia,  
        tengo el honor de invitarte a mi graduación.
      </p>

      <!-- NUEVO BLOQUE INSERTADO -->
      <div class="graduates-list" style="margin-top: 3rem;">
        <h2>Graduados<br><small>Generación 2024 – 2025</small></h2>
        <ol style="text-align: left; max-width: 600px; margin: 1rem auto; padding-left: 1.5rem;">
          <li>BAUTISTA CASTAÑO JULIO ERNESTO</li>
          <li>BOLAÑOS LÓPEZ DULCE SOFÍA</li>
          <li>CHAVEZ CALIZ SAMANTHA ADALY</li>
          <li>CORTES ROSAS MATEO</li>
          <li>FIGUEROA CARRANZA IKER ELÍAS</li>
          <li>FIGUEROA CORTÉS MATÍAS</li>
          <li>GALLARDO VILLASEÑOR PAULA</li>
          <li>GONZÁLEZ MURILLO ADRIÁN</li>
          <li>HEREDIA ESPINO FABRICIO</li>
          <li>HERRERA ADAME SIOMARA ERIN</li>
          <li>MEDINA DIANNE</li>
          <li>RUIZ ZAMORA IKER SANTIAGO</li>
          <li>SORDO FRANCO MILA ASHLYN</li>
          <li>VARGAS GÓMEZ LLUVIA ALHELI</li>
        </ol>
      </div>
    </section>


        <!-- 4) FECHA -->
    <section class="wedding-date text-center py-5 animate__animated animate__fadeInUp">
        <div style="text-align:center; margin: 2rem 0;">
            <img src="{{ asset('images/plantillas/graduacion/plantilla001/minecraft.png') }}" alt="Divisor decorativo" style="width: 150px;">
        </div>

        <div class="container">
            <h2 class="mb-4" style="font-family: 'Playfair Display', serif; font-size: 2rem;">¿CUÁNDO?</h2>
            <hr class="mx-auto mb-4" style="width: 200px; border-top: 2px solid #c5a900;">

            <div class="mb-4">
                <span style="font-size: 1.5rem; font-family: 'Great Vibes', cursive;">Julio</span>
                <span style="font-size: 5rem; font-weight: bold; color: #258d6a;">10</span>
                <span style="font-size: 1.5rem;">2025</span>
            </div>

            <div class="d-flex justify-content-center gap-4 flex-wrap" id="countdown">
                <div class="text-center">
                    <div class="fs-1 fw-bold" id="days">00</div>
                    <div style="font-family: 'Playfair Display', serif;">Días</div>
                </div>
                <div class="text-center">
                    <div class="fs-1 fw-bold" id="hours">00</div>
                    <div style="font-family: 'Playfair Display', serif;">Horas</div>
                </div>
                <div class="text-center">
                    <div class="fs-1 fw-bold" id="minutes">00</div>
                    <div style="font-family: 'Playfair Display', serif;">Min.</div>
                </div>
                <div class="text-center">
                    <div class="fs-1 fw-bold" id="seconds">00</div>
                    <div style="font-family: 'Playfair Display', serif;">Seg.</div>
                </div>
            </div>
        </div>
    </section>


    <!-- 4) LUGAR -->
    <section class="location-section text-center py-5 animate__animated animate__fadeInUp">
        <div class="container">
            
            <!-- Ícono de anillos -->
            <div style="text-align:center; margin: 2rem 0;">
              <img src="{{ asset('images/plantillas/graduacion/plantilla001/game.png') }}" alt="Divisor decorativo" style="width: 150px;">
            </div>

            <!-- Título -->
            <h2 class="mt-3" style="font-family: 'Great Vibes', cursive; font-size: 2.5rem;">
                Ceremonia <span style="color: #258d6a;">&</span> Recepción
            </h2>

            <!-- Hora -->
            <p class="mt-2 mb-1" style="font-size: 1.5rem; font-weight: bold; color: #258d6a;">
                10:00 HRS
            </p>

            <!-- Lugar -->
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; letter-spacing: 2px;">
                INSTITUTO ROUSVELT MORELIA
            </h3>

            <!-- Mapa -->
            <div class="mt-4 mb-3">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d558.3898571516285!2d-101.25813672920975!3d19.69625906972641!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842d09c583425a8d%3A0xa29ccdd5dd6fd913!2sINSTITUTO%20ROUSVELT%20MORELIA!5e0!3m2!1ses-419!2smx!4v1750529926587!5m2!1ses-419!2smx"
                        width="100%" height="300" style="border:0; border-radius: 1rem;" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>


            <!-- Dirección -->
            <p style="font-size: 1rem;">
                C. Puerto de Manzanillo 100, Tiníjaro, 58337 Morelia, Mich.
            </p>

            <!-- Botón -->
            <a href="https://maps.app.goo.gl/YDD6DNiMRQ8BmUtj9" target="_blank"
               class="btn btn-outline-dark px-4 py-2 mt-2" style="border-color: #258d6a; color: #000;">
                <i class="bi bi-geo-alt-fill"></i> CÓMO LLEGAR
            </a>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        let mariposasActivas = 0;
        const limiteMariposas = 20;

        function crearMariposa() {
            if (mariposasActivas >= limiteMariposas) return;

            const mariposa = document.createElement('div');
            mariposa.classList.add('mariposa');

            mariposa.style.left = Math.random() * 100 + 'vw';
            const size = 20 + Math.random() * 15;
            mariposa.style.width = size + 'px';
            mariposa.style.height = size + 'px';
            mariposa.style.animationDuration = (4 + Math.random() * 4) + 's';
            mariposa.style.transform = `rotate(${Math.random() * 360}deg)`;
            mariposa.style.animationDelay = Math.random() * 5 + 's';

            document.body.appendChild(mariposa);
            mariposasActivas++;

            setTimeout(() => {
                mariposa.remove();
                mariposasActivas--;
            }, 10000);
        }

        setInterval(crearMariposa, 500); // cada 0.5s, pero limitado a 20 vivas

    </script>

    <script>
        const countDownDate = new Date("Jul 10, 2025 00:00:00").getTime();

        setInterval(function () {
            const now = new Date().getTime();
            const distance = countDownDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("days").innerText = days.toString().padStart(2, '0');
            document.getElementById("hours").innerText = hours.toString().padStart(2, '0');
            document.getElementById("minutes").innerText = minutes.toString().padStart(2, '0');
            document.getElementById("seconds").innerText = seconds.toString().padStart(2, '0');
        }, 1000);
    </script>

    <script>
      function selectSlide(index) {
        const carousel = new bootstrap.Carousel(document.querySelector('#photoCarousel'));
        carousel.to(index);
      }
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('activar-musica');
        const audio = document.getElementById('bg-audio');

        btn.addEventListener('click', () => {
          audio.play();
          btn.style.display = 'none';
        });
      });
    </script>

    <button id="activar-musica"
            class="btn btn-sm btn-outline-dark"
            style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
      🔊 Activar Música
    </button>


    




</body>
</html>
