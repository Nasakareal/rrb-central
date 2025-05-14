<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <meta charset="UTF-8">
  <title>Invitación de Boda • Plantilla 001</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <!-- Bootstrap & Animate.css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Tipografías -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Great+Vibes&display=swap"
        rel="stylesheet">

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/plantillas/boda/plantilla003.css') }}">

</head>
<body>

  <div id="template003">
      <div class="invitation-card">

        <!-- — VISTA “UN RECUERDO ESPECIAL” — -->
        <section class="welcome-section text-center mb-4">
          <h2 class="welcome-title">Un Recuerdo Especial</h2>
          <p class="welcome-text">
            Gracias por ser parte de nuestro gran día. Este momento quedará grabado en nuestro corazón para siempre.
          </p>
        </section>

        <!-- — GIF CENTRAL — -->
        <img src="{{ asset('images/plantillas/boda/plantilla003/central1.gif') }}"
             alt="Invitación Animada"
             class="invitation-gif">

        <!-- — BOTONES ALREDEDOR — -->
        @php
          $sections = [
            1 => 'Bienvenida',
            2 => 'Padrinos',
            3 => '¿Cuándo?',
            4 => 'Itinerario',
            5 => 'Código de Vestimenta',
            6 => 'Nuestros Momentos',
            7 => 'Confirmación',
          ];
        @endphp

        <div class="buttons-container">
          @foreach($sections as $pos => $label)
            <button
              class="btn-invitation"
              data-pos="{{ $pos }}"
              data-bs-toggle="modal"
              data-bs-target="#modal-{{ $pos }}">
              {{ $label }}
            </button>
          @endforeach
        </div>

      </div>
    </div>

    <!-- Modal 1 (Foto de los novios) -->
    <div class="modal fade" id="modal-1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
      
          <div class="modal-header border-0">
            <h5 class="modal-title" id="modal1Label">Nosotros</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
      
          <div class="modal-body p-0 d-flex justify-content-center">
            <img
              src="{{ asset('images/plantillas/boda/plantilla001/hero.jpg') }}"
              alt="Foto de los novios"
              class="img-fluid"
            >
          </div>
      
        </div>
      </div>
    </div>

    <!-- Modal 2 Padrinos -->
    <div class="modal fade" id="modal-2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
      
          <div class="modal-header border-0">
            <center><h5 class="modal-title" id="modal2Label">Nuestros Padrinos</h5></center>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
      
          <div class="modal-body">
            <div class="d-flex flex-column align-items-center text-center">
          
              <h2>Nos vamos a casar</h2>
              <p class="couple mb-4">Génesis &amp; Jorge</p>
          
              <div class="padrino-group mb-3">
                <h5>Padrino de Arras</h5>
                <p>Víctor Hugo Guerra Escamilla</p>
              </div>
              <hr style="width:80%;">
          
              <div class="padrino-group mb-3">
                <h5>Padrinos de Biblia y Lazo</h5>
                <p>Cyntia Aguirre</p>
                <p>Claudia Aguirre</p>
              </div>
              <hr style="width:80%;">
          
              <div class="padrino-group mb-3">
                <h5>Padrinos de Anillos</h5>
                <p>Mónica Cervantes</p>
                <p>Ramón Pérez</p>
              </div>
              <hr style="width:80%;">
          
              <div class="padrino-group mb-4">
                <h5>Padrinos de Velación</h5>
                <p>Marta López</p>
                <p>Ricardo Hernández</p>
              </div>
          
              <p class="invite-text">
                Tenemos el honor de invitarles a la celebración de nuestro Enlace Matrimonial.<br>
                Con la bendición de Dios y nuestros padres.
              </p>
          
            </div>
          </div>
      
        </div>
      </div>
    </div>

    <!-- Modal 3 Tarjeta con info -->
    <div class="modal fade" id="modal-3" tabindex="-1" aria-labelledby="modal3Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
      
          <div class="modal-header border-0">
            <center><h5 class="modal-title" id="modal3Label">Nuestros Padrinos</h5></center>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
      
          <div class="modal-body">
            <div class="d-flex flex-column align-items-center text-center">
          
              <h2 class="mb-4" style="font-family: 'Playfair Display', serif; font-size: 2rem;">¿CUÁNDO?</h2>
              <hr class="mx-auto mb-4" style="width: 200px; border-top: 2px solid #c5a900;">
          
                <div class="mb-4">
                    <span style="font-size: 1.5rem; font-family: 'Great Vibes', cursive;">Julio</span>
                    <span style="font-size: 5rem; font-weight: bold; color: #9a7d00;">07</span>
                    <span style="font-size: 1.5rem;">2029</span>
                </div>
              <hr style="width:80%;">
          
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
                <h2 class="mt-3" style="font-family: 'Great Vibes', cursive; font-size: 2.5rem;">
                        Ceremonia <span style="color: #c5a900;">&</span> Recepción
                </h2>

                <!-- Hora -->
                <p class="mt-2 mb-1" style="font-size: 1.5rem; font-weight: bold; color: #9a7d00;">
                    15:00 HRS
                </p>

                <!-- Lugar -->
                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; letter-spacing: 2px;">
                    FISCALIA
                </h3>

                <!-- Mapa -->
                <div class="mt-4 mb-3">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1328.206070747865!2d-101.23381553534821!3d19.68134731777631!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842d0c199bf43a9f%3A0x106262e15efd43d2!2sState%20Attorney%20General%20of%20the%20State%20of%20Michoac%C3%A1n!5e0!3m2!1sen!2smx!4v1747012633441!5m2!1sen!2smx"
                            width="100%" height="300" style="border:0; border-radius: 1rem;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>


                <!-- Dirección -->
                <p style="font-size: 1rem;">
                    Fiscalia.
                </p>

                <!-- Botón -->
                <a href="https://www.google.com/maps/place/Hacienda+de+Tenango/" target="_blank"
                    class="btn btn-outline-dark px-4 py-2 mt-2" style="border-color: #c5a900; color: #000;">
                    <i class="bi bi-geo-alt-fill"></i> CÓMO LLEGAR
                </a>
              <hr style="width:80%;">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 4 Padrinos -->
    <div class="modal fade" id="modal-4" tabindex="-1" aria-labelledby="modal4Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
      
          <div class="modal-header border-0">
            <h2 class="text-center mb-5" style="font-family: 'Playfair Display', serif; letter-spacing: 2px;">
                        ITINERARIO
            </h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
      
          <div class="modal-body">
            <div class="d-flex flex-column align-items-center text-center">
          
                <!-- Evento -->
                <div class="row align-items-center mb-5">
                    <div class="col-4 text-end text-warning-emphasis fw-bold">14:00hrs</div>
                    <div class="col-4 text-center position-relative">
                        <div class="icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px; z-index: 2;">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="vertical-line d-none d-md-block"></div>
                    </div>
                    <div class="col-4 text-start text-uppercase fw-bold text-warning-emphasis">MISA</div>
                </div>
                <!-- Evento -->
                <div class="row align-items-center mb-5">
                    <div class="col-4 text-end text-warning-emphasis fw-bold">15:00hrs</div>
                    <div class="col-4 text-center position-relative">
                        <div class="icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px; z-index: 2;">
                            <i class="bi bi-cup-straw"></i>
                        </div>
                        <div class="vertical-line d-none d-md-block"></div>
                    </div>
                    <div class="col-4 text-start text-uppercase fw-bold text-warning-emphasis">COCKTAIL</div>
                </div>

                <div class="row align-items-center mb-5">
                    <div class="col-4 text-end text-warning-emphasis fw-bold">16:30hrs</div>
                    <div class="col-4 text-center position-relative">
                        <div class="icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px; z-index: 2;">
                            <i class="bi bi-egg-fried"></i>
                        </div>
                        <div class="vertical-line d-none d-md-block"></div>
                    </div>
                    <div class="col-4 text-start text-uppercase fw-bold text-warning-emphasis">COMIDA</div>
                </div>

                <div class="row align-items-center mb-5">
                    <div class="col-4 text-end text-warning-emphasis fw-bold">18:00hrs</div>
                    <div class="col-4 text-center position-relative">
                        <div class="icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px; z-index: 2;">
                            <i class="bi bi-emoji-smile"></i>
                        </div>
                        <div class="vertical-line d-none d-md-block"></div>
                    </div>
                    <div class="col-4 text-start text-uppercase fw-bold text-warning-emphasis">¡FIESTA!</div>
                </div>

                <div class="row align-items-center mb-5">
                    <div class="col-4 text-end text-warning-emphasis fw-bold">23:30hrs</div>
                    <div class="col-4 text-center position-relative">
                        <div class="icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px; z-index: 2;">
                            <i class="bi bi-controller"></i>
                        </div>
                        <div class="vertical-line d-none d-md-block"></div>
                    </div>
                    <div class="col-4 text-start text-uppercase fw-bold text-warning-emphasis">TORNA FIESTA</div>
                </div>

                <div class="row align-items-center">
                    <div class="col-4 text-end text-warning-emphasis fw-bold">01:00hrs</div>
                    <div class="col-4 text-center position-relative">
                        <div class="icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px; z-index: 2;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                    <div class="col-4 text-start text-uppercase fw-bold text-warning-emphasis">FIN</div>
                </div>
          
            </div>
          </div>
      
        </div>
      </div>
    </div>

    <!-- Modal 5 Codigo de Vestimenta y Mesa de Regalos -->
    <div class="modal fade" id="modal-5" tabindex="-1" aria-labelledby="modal5Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
      
          <div class="modal-header border-0">
            <h2 class="mb-2" style="font-family: 'Playfair Display', serif; letter-spacing: 2px;">
                        CÓDIGO DE VESTIMENTA
            </h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
      
          <div class="modal-body">
            <div class="d-flex flex-column align-items-center text-center">
          
                <div class="container text-center">
                    <h3 class="mb-5" style="font-family: 'Great Vibes', cursive; font-size: 2.5rem;">
                        Semi–Formal
                    </h3>

                    <div class="row justify-content-center">
                        <!-- HOMBRES -->
                        <div class="col-md-6 mb-4">
                            <div class="p-4 border rounded-4 border-warning">
                                <h5 class="text-uppercase text-warning-emphasis mb-3">Hombres</h5>
                                <p style="font-size: 1rem;">
                                    Trajes en colores claros. <br>
                                    <strong class="text-danger">Evitar:</strong> blanco, azul marino, negro o rojo.
                                </p>
                            </div>
                        </div>

                        <!-- MUJERES -->
                        <div class="col-md-6 mb-4">
                            <div class="p-4 border rounded-4 border-warning">
                                <h5 class="text-uppercase text-warning-emphasis mb-3">Mujeres</h5>
                                <p style="font-size: 1rem;">
                                    Vestidos largos vaporosos y tacón delgado. <br>
                                    <strong class="text-danger">Evitar:</strong> blanco, negro, rojo, plateado o turquesa.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="container text-center">
                    <h2 class="mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: 2px;">
                        MESA DE REGALOS
                    </h2>

                    <p class="mb-5" style="max-width: 700px; margin: auto;">
                        ¡El mejor regalo es compartir con ustedes este gran día!
                        Si deseas hacernos un obsequio, pronto compartiremos aquí nuestras mesas de regalos.
                        Gracias por acompañarnos en esta nueva etapa.
                    </p>

                    <div class="row justify-content-center g-4">
                        <!-- Caja simbólica 1 -->
                        <div class="col-md-6">
                            <div class="border border-warning rounded-4 p-4">
                                <div style="font-size: 2rem;">🎁</div>
                                <h5 class="mt-2">Amazon / Liverpool</h5>
                                <p class="text-muted">Muy pronto encontrarás aquí nuestras opciones de regalo.</p>
                                <button class="btn btn-outline-dark mt-2" disabled>
                                    <i class="bi bi-gift"></i> Ver mesa de regalos
                                </button>
                            </div>
                        </div>

                        <!-- Caja simbólica 2 -->
                        <div class="col-md-6">
                            <div class="border border-warning rounded-4 p-4">
                                <div style="font-size: 2rem;">💳</div>
                                <h5 class="mt-2">Transferencias o Sobres</h5>
                                <p class="text-muted">Pronto habilitaremos también esta opción para tu comodidad.</p>
                                <button class="btn btn-outline-dark mt-2" disabled>
                                    <i class="bi bi-wallet2"></i> Ver datos bancarios
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
          
            </div>
          </div>
      
        </div>
      </div>
    </div>

    <!-- Modal 7: Invitación / Confirmación -->
    <div class="modal fade" id="modal-7" tabindex="-1" aria-labelledby="modal7Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="modal7Label">¡Te Esperamos!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>

          <div class="modal-body text-center px-4">

            <!-- Invitado / Boletos -->
            <div class="mx-auto mb-4 p-4" style="
              max-width: 750px;
              background: linear-gradient(to right, #e3dfd1, #f9f7f1);
              border: 2px solid var(--gold);
              border-radius: 1.5rem;
              box-shadow: 0 4px 18px rgba(0,0,0,0.1);
            ">
              <div class="row align-items-center">
                <div class="col-6 text-start">
                  <p class="text-uppercase fw-bold text-warning mb-1">Invitado</p>
                  <h6 style="font-family: 'Playfair Display', serif;">Roberto Gómez y familia</h6>
                </div>
                <div class="col-6 text-end">
                  <p class="text-uppercase fw-bold text-warning mb-1">Boletos</p>
                  <h6 style="font-family: 'Playfair Display', serif;">Adultos 2<br>Niños 1</h6>
                </div>
              </div>
            </div>

            <!-- Nota Sólo Adultos -->
            <div class="mb-4">
              <div style="font-size: 2rem; color: #9a7d00;">👶🚫</div>
              <p style="max-width: 600px; margin: auto; font-size: 1rem;">
                Aunque nos gustan los niños y adoramos a tus hijos, creemos que necesitas una noche libre.
                Esta será una celebración <strong>SÓLO PARA ADULTOS</strong>.
              </p>
            </div>

            <hr>

            <!-- Formulario de Confirmación -->
            <div class="mb-4">
              <h5>Confirmar Asistencia</h5>
              <p style="max-width: 700px; margin: auto;">
                Nos gustaría que pudieras asistir y compartir con nosotros este día tan especial.
                Te rogamos confirmar tu asistencia antes del 
                <strong style="color: var(--gold);">09 de DICIEMBRE del 2025</strong>.
              </p>
              <form action="#" method="POST" class="mx-auto text-start" style="max-width: 750px;">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control" id="nombre" required>
                  </div>
                  <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" required>
                  </div>
                  <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                  </div>
                  <div class="col-md-6">
                    <label for="asistencia" class="form-label">¿Asistes?</label>
                    <select class="form-select" id="asistencia" required>
                      <option selected disabled value="">Selecciona una opción</option>
                      <option>Sí, estaré presente</option>
                      <option>No podré asistir</option>
                    </select>
                  </div>
                  <div class="col-12">
                    <label for="mensaje" class="form-label">Deseo para los novios</label>
                    <textarea class="form-control" id="mensaje" rows="3" placeholder="Opcional"></textarea>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <button type="submit" class="btn btn-outline-warning px-5 py-2">
                    ✉️ Enviar
                  </button>
                </div>
              </form>
            </div>

            <hr>

            <!-- WhatsApp -->
            <div class="mb-2">
              <p>¿Dudas sobre nuestro evento?</p>
              <a href="https://wa.me/5210000000000" target="_blank" class="btn btn-success">
                <i class="bi bi-whatsapp"></i> WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 6 Codigo de Vestimenta y Mesa de Regalos -->
    <div class="modal fade" id="modal-6" tabindex="-1" aria-labelledby="modal6Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
      
          <div class="modal-header border-0">
            <h2 class="mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: 2px;">
                        NUESTROS MOMENTOS
            </h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
      
          <div class="modal-body">
            <div class="d-flex flex-column align-items-center text-center">
          
                <div class="container text-center">
                    <div class="container text-center">
                    

                    <div id="photoCarousel" class="carousel slide mb-3 border border-warning rounded-4" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <!-- Imagen 1 -->
                            <div class="carousel-item active">
                                <img src="{{ asset('images/galeria/foto1.jpg') }}" class="d-block w-100" alt="Foto 1">
                            </div>
                            <!-- Imagen 2 -->
                            <div class="carousel-item">
                                <img src="{{ asset('images/galeria/foto2.jpg') }}" class="d-block w-100" alt="Foto 2">
                            </div>
                            <!-- Imagen 3 -->
                            <div class="carousel-item">
                                <img src="{{ asset('images/galeria/foto3.jpeg') }}" class="d-block w-100" alt="Foto 3">
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
                        <img src="{{ asset('images/galeria/foto1.jpg') }}" alt="Miniatura 1" width="80" class="img-thumbnail" style="cursor:pointer;" onclick="selectSlide(0)">
                        <img src="{{ asset('images/galeria/foto2.jpg') }}" alt="Miniatura 2" width="80" class="img-thumbnail" style="cursor:pointer;" onclick="selectSlide(1)">
                        <img src="{{ asset('images/galeria/foto3.jpeg') }}" alt="Miniatura 3" width="80" class="img-thumbnail" style="cursor:pointer;" onclick="selectSlide(2)">
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        function crearPetalo() {
            const petalo = document.createElement('div');
            petalo.classList.add('petalo');

            // Posición aleatoria
            petalo.style.left = Math.random() * 100 + 'vw';

            // Tamaño y duración aleatoria
            const size = 15 + Math.random() * 15;
            petalo.style.width = size + 'px';
            petalo.style.height = size + 'px';
            petalo.style.animationDuration = (4 + Math.random() * 4) + 's';

            // Rotación aleatoria
            petalo.style.transform = `rotate(${Math.random() * 360}deg)`;

            document.body.appendChild(petalo);

            setTimeout(() => {
                petalo.remove();
            }, 10000);
        }

        setInterval(crearPetalo, 250);
    </script>
    <script>
        const countDownDate = new Date("Jul 07, 2029 00:00:00").getTime();

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
    // Abrir modal al pulsar el botón
    document.querySelectorAll('.btn-invitation').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.pos;
        document.getElementById(`modal-${id}`)
                .classList.add('show');
      });
    });

    // Cerrar modal con la “×”
    document.querySelectorAll('.modal-close').forEach(closeBtn => {
      closeBtn.addEventListener('click', () => {
        closeBtn.closest('.modal')
                .classList.remove('show');
      });
    });

    // Cerrar al clicar fuera del contenido
    document.querySelectorAll('.modal').forEach(modal => {
      modal.addEventListener('click', e => {
        if (e.target === modal) {
          modal.classList.remove('show');
        }
      });
    });
    </script>


</body>
</html>
