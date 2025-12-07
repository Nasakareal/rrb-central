<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Centauros | RRB Soluciones</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fuente chida -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --centauro-gold: #f5c453;
            --centauro-dark: #05060a;
            --centauro-red:  #e63946;
            --centauro-purple: #5a189a;
        }

        body {
            background: radial-gradient(circle at top, #1b1b2f 0, #05060a 45%, #000 100%);
            color: #f5f5f5;
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            position: relative;
            z-index: 0;
        }

        /* Fondo con la foto fondo.jpg */
        .centauros-body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url("{{ asset('img/centauros/fondo.jpg') }}") center center / cover no-repeat fixed;
            opacity: 0.22; /* súbelo o bájalo según qué tanto quieras que se vea la foto */
            z-index: -1;
        }

        .navbar-centauros {
            background: linear-gradient(90deg, #000, #231942, #000);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .logo-centauro {
            font-family: 'Oswald', sans-serif;
            letter-spacing: 0.18em;
            font-size: 1.1rem;
            text-transform: uppercase;
        }

        .logo-centauro span {
            color: var(--centauro-gold);
        }

        .tagline {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.22em;
            color: rgba(255,255,255,0.7);
        }

        /* HERO */
        .hero-section {
            position: relative;
            padding: 5rem 1rem 4rem;
            overflow: hidden;
        }

        .hero-glow {
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 10% 0%, rgba(245,196,83,0.14), transparent 55%),
                radial-gradient(circle at 90% 10%, rgba(90,24,154,0.40), transparent 60%),
                radial-gradient(circle at 0% 90%, rgba(230,57,70,0.35), transparent 60%);
            opacity: 0.9;
            filter: blur(18px);
            z-index: -2;
        }

        .hero-card {
            border-radius: 30px;
            border: 1px solid rgba(255,255,255,0.08);
            background: linear-gradient(135deg, rgba(5,6,10,0.92), rgba(14,16,29,0.96));
            box-shadow:
                0 0 35px rgba(0,0,0,0.9),
                0 0 60px rgba(245,196,83,0.22);
        }

        .badge-sector {
            font-size: 0.7rem;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            border-radius: 999px;
            padding: 0.28rem 0.9rem;
            background: rgba(0,0,0,0.4);
            border: 1px solid rgba(245,196,83,0.5);
            color: var(--centauro-gold);
        }

        .hero-title {
            font-family: 'Oswald', sans-serif;
            font-size: clamp(2.6rem, 5vw, 3.5rem);
            text-transform: uppercase;
            letter-spacing: 0.18em;
            line-height: 1.1;
        }

        .hero-title span {
            display: block;
        }

        .hero-title .stroke {
            -webkit-text-stroke: 1px rgba(245,196,83,0.8);
            color: transparent;
        }

        .hero-title .fill {
            color: var(--centauro-gold);
            text-shadow:
                0 0 14px rgba(245,196,83,0.9),
                0 0 30px rgba(230,57,70,0.7);
        }

        .hero-subtitle {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.85);
        }

        .hero-subtitle strong {
            color: var(--centauro-gold);
        }

        .stat-pill {
            padding: 0.7rem 1.2rem;
            border-radius: 999px;
            background: radial-gradient(circle at top left, rgba(245,196,83,0.25), rgba(0,0,0,0.9));
            border: 1px solid rgba(245,196,83,0.4);
            font-size: 0.8rem;
        }

        .stat-pill span {
            display: block;
            line-height: 1.1;
        }

        .stat-number {
            font-weight: 700;
            color: var(--centauro-gold);
            font-size: 1rem;
        }

        /* BOTÓN INTERCAMBIO */
        .btn-intercambio {
            position: relative;
            overflow: hidden;
            border-radius: 999px;
            border: none;
            padding: 0.95rem 2.6rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-weight: 600;
            background: linear-gradient(120deg, var(--centauro-red), var(--centauro-purple));
            color: #fff;
            box-shadow:
                0 0 16px rgba(230,57,70,0.8),
                0 0 40px rgba(90,24,154,0.9);
        }

        .btn-intercambio::before {
            content: "";
            position: absolute;
            inset: -40%;
            background: radial-gradient(circle at 0 50%, rgba(255,255,255,0.35), transparent 60%);
            transform: translateX(-60%);
            transition: transform 0.5s ease-out;
            opacity: 0.8;
        }

        .btn-intercambio:hover::before {
            transform: translateX(40%);
        }

        .btn-intercambio:hover {
            transform: translateY(-1px);
            box-shadow:
                0 0 26px rgba(230,57,70,1),
                0 0 60px rgba(90,24,154,1);
        }

        /* GALERÍA */
        .gallery-section {
            padding-bottom: 4rem;
        }

        .gallery-title {
            font-family: 'Oswald', sans-serif;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            font-size: 1.1rem;
            color: var(--centauro-gold);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 1.5rem;
        }

        .photo-card {
            position: relative;
            border-radius: 22px;
            overflow: hidden;
            background: radial-gradient(circle at top, #1b1b2f, #000);
            border: 1px solid rgba(255,255,255,0.07);
            box-shadow: 0 20px 40px rgba(0,0,0,0.9);
            cursor: pointer;
            transform-origin: center;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .photo-card:hover {
            transform: translateY(-6px) rotate3d(0.3, -0.3, 0, 5deg);
            border-color: rgba(245,196,83,0.6);
            box-shadow:
                0 30px 80px rgba(0,0,0,1),
                0 0 35px rgba(245,196,83,0.5);
        }

        .photo-badge {
            position: absolute;
            top: 10px;
            left: 12px;
            padding: 0.25rem 0.7rem;
            border-radius: 999px;
            background: rgba(0,0,0,0.7);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: rgba(255,255,255,0.8);
        }

        .photo-label {
            position: absolute;
            bottom: 10px;
            left: 12px;
            right: 12px;
            padding: 0.4rem 0.7rem;
            border-radius: 14px;
            background: linear-gradient(90deg, rgba(0,0,0,0.8), rgba(5,6,10,0.95));
            font-size: 0.75rem;
        }

        .photo-label span {
            display: block;
        }

        .photo-label-title {
            font-weight: 600;
            color: var(--centauro-gold);
        }

        .photo-label-sub {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.8);
        }

        .photo-img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            filter: saturate(1.2) contrast(1.1);
        }

        /* FOOTER MINI */
        .mini-footer {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.5);
        }

        @media (max-width: 767px) {
            .hero-section {
                padding-top: 3rem;
            }

            .hero-card {
                border-radius: 24px;
            }

            .photo-img {
                height: 220px;
            }
        }
    </style>
</head>
<body class="centauros-body">

<nav class="navbar navbar-centauros navbar-dark">
    <div class="container py-2 d-flex justify-content-between align-items-center">
        <div>
            <div class="logo-centauro">
                <span>CENTAUROS</span>
            </div>
            <div class="tagline">
                ACADEMIA · DISCIPLINA · DESMADRE LEGENDARIO
            </div>
        </div>
        <div class="d-none d-md-flex align-items-center gap-3">
            <span class="badge-sector">Grupo Centauros</span>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="hero-glow"></div>
    <div class="container">
        <div class="row g-4 align-items-center hero-card p-4 p-md-5">
            <div class="col-md-7">
                <div class="badge-sector mb-3">
                    ACADEMIA · GENERACIÓN INOLVIDABLE
                </div>
                <h1 class="hero-title mb-3">
                    <span class="stroke">UNIDAD</span>
                    <span class="fill">CENTAUROS</span>
                </h1>
                <p class="hero-subtitle mb-4">
                    Fotos que jamás irían al expediente (pero sí aquí), recuerdos del salón,
                    prácticas, risas, <strong>y todo el desmadre controlado</strong> que nos representa.
                </p>

                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <div class="stat-pill d-flex align-items-center gap-3">
                        <span class="stat-number">24/7</span>
                        <span>Centauros<br>en modo academia</span>
                    </div>
                    <div class="stat-pill d-flex align-items-center gap-3">
                        <span class="stat-number">+100</span>
                        <span>Momentos<br>que no se olvidan</span>
                    </div>
                </div>

                <a href="{{ route('centauros.intercambio') }}" class="btn btn-intercambio">
                    IR AL INTERCAMBIO
                </a>

                <p class="mt-3 mb-0" style="font-size: 0.78rem; color: rgba(255,255,255,0.7);">
                    Entra con el usuario y contraseña que se te dieron para ver
                    <strong>a quién te tocó</strong>. Sin spoilers, sin chisme… bueno, casi.
                </p>
            </div>

            <div class="col-md-5">
                <div class="gallery-mini">
                    <div class="gallery-grid">
                        @foreach($fotos as $index => $foto)
                            <div class="photo-card">
                                <span class="photo-badge">
                                    {{ $index + 1 < 10 ? '0' . ($index+1) : $index+1 }} · CENTAUROS
                                </span>
                                <img src="{{ asset('img/centauros/' . $foto) }}"
                                     alt="Foto Centauros {{ $index+1 }}"
                                     class="photo-img">

                                <div class="photo-label">
                                    <span class="photo-label-title">
                                        @if($index === 0)
                                            REVISIÓN DE VEHÍCULOS
                                        @elseif($index === 1)
                                            ULISES
                                        @elseif($index === 2)
                                            PRÁCTICAS DE MANEJO
                                        @elseif($index === 3)
                                            GAS LACRIMÓGENO
                                        @elseif($index === 4)
                                            CAFEÍNA OFICIAL
                                        @else
                                            MOMENTO LEGENDARIO
                                        @endif
                                    </span>
                                    <span class="photo-label-sub">
                                        Centauros de fuego.
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="gallery-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="gallery-title mb-0">
                GALERÍA CENTAUROS · SOLO GENTE SERIA
            </h2>
            <span style="font-size: 0.75rem; color: rgba(255,255,255,0.65);">
                Más fotos se pueden agregar cuando quieran.
            </span>
        </div>
        {{-- Aquí podrían ir más fotos, videos, o un carrusel si luego quieres --}}
    </div>
</section>

</body>
</html>
