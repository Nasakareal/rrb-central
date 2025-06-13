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
    <link rel="stylesheet" href="{{ asset('css/plantillas/xv/plantilla001.css') }}?v={{ time() }}">


</head>
<body>
    <audio id="bg-audio" autoplay loop>
        <source src="{{ asset('images/plantillas/xv/plantilla001/song.mp3') }}" type="audio/mpeg">
        Tu navegador no soporta audio HTML5.
    </audio>

    <!-- 1) HERO DE LA QUINCEAÑERA -->
    <section class="hero">
        <img src="{{ asset('images/plantillas/xv/plantilla001/scar2.png') }}"
             alt="Foto de los novios">
    </section>

    <!-- 2) RECUERDO -->
    <section class="memory animate__animated animate__fadeInUp">
        <div class="container">
            <h2>Mis xv años<br>Zara Camila Millán Calderón</h2>
            <p>
                Gracias por ser parte de este momento tan especial.  
                Mis XV años marcan el inicio de un nuevo capítulo en mi vida,  
                y tenerte a mi lado lo hace aún más inolvidable.
            </p>
        </div>
    </section>

    <!-- 3) TARJETA BLANCA CON INFO Y PADRINOS -->
    <section class="info-card animate__animated animate__fadeInUp">
        <div style="text-align:center; margin: 2rem 0;">
          <img src="{{ asset('images/plantillas/xv/plantilla001/ornamental.png') }}" alt="Divisor decorativo" style="width: 150px;">
        </div>
        <h2>Mis Padres</h2>
        <p class="couple">Adolfo Millán Montes &amp; Maricela Calderón Cortes</p>
        
        <hr>
        <div class="padrino-group">
            <h5>Mi Padrino</h5>
            <p>Roberto Carlos Duarte Baez</p>
        </div>

        <div class="padrino-group">
            <h5>Mi Madrina</h5>
            <p>Alondra Melchor Hernández</p>
        </div>
        <hr>

        <div style="text-align:center; margin: 2rem 0;">
          <img src="{{ asset('images/plantillas/xv/plantilla001/crown.png') }}" alt="Divisor decorativo" style="width: 150px;">
        </div>

        <p class="invite-text">
            Con la bendición de Dios y el amor de mi familia,  
            tengo el honor de invitarte a la celebración de mis XV años.
        </p>

    </section>

    <!-- 4) FECHA -->
    <section class="wedding-date text-center py-5 animate__animated animate__fadeInUp">
        <div style="text-align:center; margin: 2rem 0;">
            <img src="{{ asset('images/plantillas/xv/plantilla001/lion.png') }}" alt="Divisor decorativo" style="width: 150px;">
        </div>

        <div class="container">
            <h2 class="mb-4" style="font-family: 'Playfair Display', serif; font-size: 2rem;">¿CUÁNDO?</h2>
            <hr class="mx-auto mb-4" style="width: 200px; border-top: 2px solid #c5a900;">

            <div class="mb-4">
                <span style="font-size: 1.5rem; font-family: 'Great Vibes', cursive;">Julio</span>
                <span style="font-size: 5rem; font-weight: bold; color: #258d6a;">19</span>
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
              <img src="{{ asset('images/plantillas/xv/plantilla001/church.png') }}" alt="Divisor decorativo" style="width: 150px;">
            </div>

            <!-- Título -->
            <h2 class="mt-3" style="font-family: 'Great Vibes', cursive; font-size: 2.5rem;">
                Misa
            </h2>

            <!-- Hora -->
            <p class="mt-2 mb-1" style="font-size: 1.5rem; font-weight: bold; color: #258d6a;">
                17:00 HRS
            </p>

            <!-- Lugar -->
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; letter-spacing: 2px;">
                Parroquía Divino Niño Jesús
            </h3>

            <!-- Mapa -->
            <div class="mt-4 mb-3">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3756.9038747615377!2d-101.23154542500663!3d19.674105981657597!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842d0c3dfab26031%3A0x4fa154b671c03365!2zUGFycm9xdcOtYSBEaXZpbm8gTmnDsW8gSmVzw7pz!5e0!3m2!1ses-419!2smx!4v1749597628363!5m2!1ses-419!2smx"
                        width="100%" height="300" style="border:0; border-radius: 1rem;" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>


            <!-- Dirección -->
            <p style="font-size: 1rem;">
                Benito Rocha y Pardinas 15, Praderas de Morelia, 58195 Morelia, Mich.
            </p>

            <!-- Botón -->
            <a href="https://maps.app.goo.gl/1fe7bNdXmnrozK6b8" target="_blank"
               class="btn btn-outline-dark px-4 py-2 mt-2" style="border-color: #258d6a; color: #000;">
                <i class="bi bi-geo-alt-fill"></i> CÓMO LLEGAR
            </a>

            <!-- Ícono de anillos -->
            <div style="text-align:center; margin: 2rem 0;">
              <img src="{{ asset('images/plantillas/xv/plantilla001/princess.png') }}" alt="Divisor decorativo" style="width: 150px;">
            </div>

            <!-- Título -->
            <h2 class="mt-3" style="font-family: 'Great Vibes', cursive; font-size: 2.5rem;">
                Ceremonia <span style="color: #258d6a;">&</span> Recepción
            </h2>

            <!-- Hora -->
            <p class="mt-2 mb-1" style="font-size: 1.5rem; font-weight: bold; color: #258d6a;">
                18:30 HRS
            </p>

            <!-- Lugar -->
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; letter-spacing: 2px;">
                Quinta Antonelli
            </h3>

            <!-- Mapa -->
            <div class="mt-4 mb-3">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5312.630095900274!2d-101.25372582815626!3d19.687201352303134!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842d0daa507c34a3%3A0x47ab1e55624acaa7!2sQuinta%20Antonelli!5e0!3m2!1ses-419!2smx!4v1749597921933!5m2!1ses-419!2smx"
                        width="100%" height="300" style="border:0; border-radius: 1rem;" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>


            <!-- Dirección -->
            <p style="font-size: 1rem;">
                Av San Juanito Itzícuaro 2343, La Nueva Esperanza, 58337 Morelia, Mich.
            </p>

            <!-- Botón -->
            <a href="https://maps.app.goo.gl/YDD6DNiMRQ8BmUtj9" target="_blank"
               class="btn btn-outline-dark px-4 py-2 mt-2" style="border-color: #258d6a; color: #000;">
                <i class="bi bi-geo-alt-fill"></i> CÓMO LLEGAR
            </a>
        </div>
    </section>

    <!-- 5) ITINERARIO -->
    <section class="itinerary-section py-5 animate__animated animate__fadeInUp">

        <div class="container">
            <h2 class="text-center mb-5" style="font-family: 'Playfair Display', serif; letter-spacing: 2px;">
                ITINERARIO
            </h2>

            <div class="timeline-v1 position-relative" style="max-width: 800px; margin: auto;">
                <!-- Evento -->
                <div class="row align-items-center mb-5">
                    <div class="col-4 text-end text-warning-emphasis fw-bold">17:00hrs</div>
                    <div class="col-4 text-center position-relative">
                        <div class="icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px; z-index: 2;">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="vertical-line d-none d-md-block"></div>
                    </div>
                    <div class="col-4 text-start text-uppercase fw-bold text-warning-emphasis">MISA</div>
                </div>

                <!-- Recepción -->
                <div class="row align-items-center mb-5">
                    <div class="col-4 text-end text-warning-emphasis fw-bold">18:30hrs</div>
                    <div class="col-4 text-center position-relative">
                        <div class="icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px; z-index: 2;">
                            <i class="bi bi-bell"></i>
                        </div>
                        <div class="vertical-line d-none d-md-block"></div>
                    </div>
                    <div class="col-4 text-start text-uppercase fw-bold text-warning-emphasis">RECEPCIÓN</div>
                </div>

                <!-- Vals -->
                <div class="row align-items-center mb-5">
                    <div class="col-4 text-end text-warning-emphasis fw-bold">20:00hrs</div>
                    <div class="col-4 text-center position-relative">
                        <div class="icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px; z-index: 2;">
                            <i class="bi bi-egg-fried"></i>
                        </div>
                        <div class="vertical-line d-none d-md-block"></div>
                    </div>
                    <div class="col-4 text-start text-uppercase fw-bold text-warning-emphasis">VALS</div>
                </div>

                <!-- Cena -->
                <div class="row align-items-center mb-5">
                    <div class="col-4 text-end text-warning-emphasis fw-bold">21:00hrs</div>
                    <div class="col-4 text-center position-relative">
                        <div class="icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px; z-index: 2;">
                            <i class="bi bi-cup-hot-fill"></i>
                        </div>
                        <div class="vertical-line d-none d-md-block"></div>
                    </div>
                    <div class="col-4 text-start text-uppercase fw-bold text-warning-emphasis">CENA</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6) VESTIMENTA -->
    <section class="dresscode-section py-5 animate__animated animate__fadeInUp">

        <div style="text-align:center; margin: 2rem 0;">
            <img src="{{ asset('images/plantillas/xv/plantilla001/wedding.png') }}" alt="Divisor decorativo" style="width: 150px;">
        </div>

        <div class="container text-center">
            <h2 class="mb-2" style="font-family: 'Playfair Display', serif; letter-spacing: 2px;">
                CÓDIGO DE VESTIMENTA
            </h2>
            <h3 class="mb-5" style="font-family: 'Great Vibes', cursive; font-size: 2.5rem;">
                Formal
            </h3>

            <div class="row justify-content-center">

                <!-- MUJERES -->
                <div class="col-md-5 mb-4">
                    <div class="p-4 border rounded-4 border-warning">
                        <h5 class="text-uppercase text-warning-emphasis mb-3">Mujeres</h5>
                        <p style="font-size: 1rem;">
                            <strong class="text-danger">Evitar:</strong> negro y café.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7) MESA DE REGALOS -->
    <section class="gift-section py-5 animate__animated animate__fadeInUp">

        <div style="text-align:center; margin: 2rem 0;">
            <img src="{{ asset('images/plantillas/xv/plantilla001/money.png') }}" alt="Divisor decorativo" style="width: 150px;">
        </div>

        <div class="container text-center">
            <h2 class="mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: 2px;">
                MESA DE REGALOS
            </h2>

            <p class="mb-5" style="max-width: 700px; margin: auto;">
                Libre opción, si no encuentras que regalarme, habrá lluvia de sobres, en la entrada se te proporcionará un sobre para la cantidad que desees regalarme, y  podrás depositar en una caja que estará en el interior del Salón.
            </p>
        </div>
    </section>

    <!-- 8) FOTOS -->
    <section class="gallery-section py-5 animate__animated animate__fadeInUp">
        <div class="container text-center">
            <h2 class="mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: 2px;">
                MIS MOMENTOS
            </h2>

            <div id="photoCarousel" class="carousel slide mb-3 border border-warning rounded-4" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Imagen 1 -->
                    <div class="carousel-item active">
                        <img src="{{ asset('images/cami2.jpg') }}" class="d-block w-100" alt="Foto 1">
                    </div>
                </div>

                <!-- Controles -->
                <button class="carousel-control-prev" type="button" data-bs-target="#photoCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#photoCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>

            <!-- Miniaturas -->
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <img src="{{ asset('images/cami2.jpg') }}" alt="Miniatura 1"
                     class="img-thumbnail"
                     style="width: 80px; height: 100px; object-fit: cover; cursor: pointer;"
                     onclick="selectSlide(0)">
            </div>
        </div>
    </section>

    <!-- 7.5) GALERÍA DE FOTOS DE INVITADOS -->
    <section class="photo-upload-section py-5 animate__animated animate__fadeInUp">
        <div class="container text-center">
            <div style="text-align:center; margin: 2rem 0;">
                <img src="{{ asset('images/plantillas/xv/plantilla001/photographer.png') }}" alt="Divisor decorativo" style="width: 150px;">
            </div>

            <h2 class="mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: 2px;">
                TU FOTO EN MI RECUERDO
            </h2>

            <p class="mb-4" style="max-width: 700px; margin: auto;">
                Si tomaste una foto bonita durante la fiesta, súbela a mi galería y haz este momento aún más especial.
            </p>

            <a href="{{ route('camila.galeria') }}" class="btn btn-outline-warning px-5 py-2">
                📸 Ver y subir fotos
            </a>
        </div>
    </section>


    <!-- 10) INVITACIÓN -->
    <section class="confirm-section py-5 animate__animated animate__fadeInUp">
      <div class="container text-center">
        <h2 class="mb-3" style="font-family: 'Playfair Display', serif; font-size: 2rem;">
          CONFIRMAR ASISTENCIA
        </h2>

        <p class="mb-5" style="max-width: 700px; margin: auto;">
          Nos gustaría que pudieras asistir y compartir con nosotros este día tan especial.  
          Te rogamos confirmar tu asistencia antes del  
          <strong style="color: #258d6a;">30 de JUNIO del 2025</strong>.
        </p>

        <form action="{{ route('camila.confirmacion') }}" method="POST" class="text-start mx-auto" style="max-width: 750px;">
          @csrf
            <input type="hidden" name="evento_id" value="{{ $evento->id }}">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nombre" class="form-label">Nombre completo del invitado</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="col-md-6">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="tel" class="form-control" id="telefono" name="telefono" required>
            </div>

            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="col-md-6">
              <label for="asistencia" class="form-label">¿Podrás asistir?</label>
              <select class="form-select" id="asistencia" name="asistencia" required>
                <option selected disabled value="">Selecciona una opción</option>
                <option value="Sí">Sí, voy a ir.</option>
                <option value="No">No podré asistir.</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="boletos" class="form-label">¿Usarás todos tus boletos asignados?</label>
              <select class="form-select" id="boletos" name="boletos">
                <option value="Sí">Sí</option>
                <option value="No">No</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="mensaje" class="form-label">¿Deseo para la quinceañera?</label>
              <textarea class="form-control" id="mensaje" name="mensaje" rows="3" placeholder="Opcional"></textarea>
            </div>
          </div>

          <div class="text-center mt-4">
            <button type="submit" class="btn btn-outline-warning px-5 py-2">
              ✉️ Enviar
            </button>
          </div>
        </form>


        <!-- WhatsApp info -->
        <div class="mt-5">
          <p class="mb-2">¿Dudas sobre nuestro evento?</p>
          <a href="https://wa.me/5210000000000" target="_blank" class="btn btn-success">
            <i class="bi bi-whatsapp"></i> WhatsApp
          </a>
        </div>
      </div>
    </section>



    </div>
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
        const countDownDate = new Date("Jul 19, 2025 00:00:00").getTime();

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
