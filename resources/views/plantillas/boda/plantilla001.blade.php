<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Invitación de Boda • Plantilla 001</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Animate.css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Tipografías -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Great+Vibes&display=swap"
        rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Playfair Display', serif;
      background: #f0f0f0;
    }

    /* 1) HERO */
    .hero {
      height: 80vh;
      overflow: hidden;
    }
    .hero img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* 2) RECUERDO */
    .memory {
      padding: 4rem 1rem;
      background: #f8f9fa;
      text-align: center;
    }
    .memory h2 {
      font-family: 'Great Vibes', cursive;
      font-size: 3rem;
      margin-bottom: 1rem;
      color: #4e54c8;
    }
    .memory p {
      font-size: 1.25rem;
      color: #333;
      max-width: 700px;
      margin: auto;
      line-height: 1.6;
    }

    /* 3) TARJETA BLANCA (ahora en flujo normal, debajo de memory) */
    .info-card {
      max-width: 800px;
      margin: 2rem auto;          /* espacio arriba y abajo */
      background: #ffffff;        /* fondo blanco sólido */
      padding: 2rem;
      border-radius: .5rem;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    .info-card h2 {
      font-family: 'Great Vibes', cursive;
      font-size: 3rem;
      text-align: center;
      margin-bottom: .5rem;
    }
    .info-card .couple {
      font-size: 1.25rem;
      text-align: center;
      margin-bottom: 1.5rem;
      color: #555;
    }
    .info-card hr {
      border-color: #ccc;
      margin: 2rem 0;
    }
    .padrino-group {
      margin-bottom: 2rem;
    }
    .padrino-group h5 {
      font-weight: 700;
      text-align: center;
      margin-bottom: .5rem;
      color: #333;
    }
    .padrino-group p {
      font-family: 'Great Vibes', cursive;
      font-size: 1.5rem;
      text-align: center;
      margin: .5rem 0;
      position: relative;
    }
    .padrino-group p + p::before {
      content: "—";
      position: absolute;
      left: 50%;
      top: -1rem;
      transform: translateX(-50%);
      color: #ccc;
    }
    .invite-text {
      text-align: center;
      color: #444;
      font-size: 1rem;
      line-height: 1.6;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

  <!-- 1) HERO DE LOS NOVIOS -->
  <section class="hero">
    <img
      src="{{ asset('images/plantillas/boda/plantilla001/hero.jpg') }}"
      alt="Foto de los novios">
  </section>

  <!-- 2) RECUERDO -->
  <section class="memory animate__animated animate__fadeInUp">
    <div class="container">
      <h2>Un Recuerdo Especial</h2>
      <p>
        Gracias por ser parte de nuestro gran día.  
        Este momento quedará grabado en nuestro corazón para siempre.
      </p>
    </div>
  </section>

  <!-- 3) TARJETA BLANCA CON INFO Y PADRINOS -->
  <section class="info-card animate__animated animate__fadeInUp">
    <h2>Nos vamos a casar</h2>
    <p class="couple">Génesis &amp; Jorge</p>

    <div class="padrino-group">
      <h5>Padrino de Arras</h5>
      <p>Víctor Hugo Guerra Escamilla</p>
    </div>
    <hr>

    <div class="padrino-group">
      <h5>Padrinos de Biblia y Lazo</h5>
      <p>Cyntia Aguirre</p>
      <p>Claudia Aguirre</p>
    </div>
    <hr>

    <div class="padrino-group">
      <h5>Padrinos de Anillos</h5>
      <p>Mónica Cervantes</p>
      <p>Ramón Pérez</p>
    </div>
    <hr>

    <div class="padrino-group">
      <h5>Padrinos de Velación</h5>
      <p>Marta López</p>
      <p>Ricardo Hernández</p>
    </div>

    <p class="invite-text">
      Tenemos el honor de invitarles a la celebración de nuestro Enlace Matrimonial.<br>
      Con la bendición de Dios y nuestros padres.
    </p>
  </section>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
</body>
</html>
