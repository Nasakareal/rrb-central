@php
    $nombre = 'JULIO ERNESTO';
    $apellido = 'BAUTISTA JIMÉNEZ';

    $fechaTexto = 'SÁBADO 26 DE SEPTIEMBRE';
    $fechaISO = '2026-09-26T14:00:00-06:00';
    $hora = '2:00 PM';

    $lugar = 'HERMOSO JARDÍN';
    $direccion = 'Filomena del valle esquina con margarita maza de Juárez, Morelia, Michoacán';
    $mapsUrl = 'https://maps.app.goo.gl/3vPj6PtmDGFTzzkf9';

    $whatsapp = '524431861365';
    $edad = '15';
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cumpleaños de {{ $nombre }}</title>

    <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('images/julio/julio-favicon-256.png') }}?v=1">
    <link rel="apple-touch-icon" href="{{ asset('images/julio/julio-favicon-256.png') }}?v=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Rock+Salt&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at 20% 10%, rgba(180, 0, 0, .16), transparent 28%),
                radial-gradient(circle at 80% 70%, rgba(180, 0, 0, .10), transparent 30%),
                #080808;
            color: #f2f2f2;
            font-family: 'Oswald', sans-serif;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: .12;
            z-index: 9998;
            background-image:
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 2px,
                    rgba(255,255,255,.03) 3px
                );
        }

        .rock-rain {
            position: fixed;
            inset: 0;
            z-index: 20;
            overflow: hidden;
            pointer-events: none;
        }

        .rock-drop {
            --size: 42px;
            --duration: 17s;
            --delay: 0s;
            --drift: 30px;
            position: absolute;
            top: -15vh;
            left: var(--left);
            width: var(--size);
            height: var(--size);
            object-fit: contain;
            opacity: .16;
            filter: grayscale(.2) drop-shadow(0 4px 8px rgba(0, 0, 0, .4));
            animation: rockRain var(--duration) linear var(--delay) infinite;
            will-change: transform;
        }

        .rock-drop:nth-child(1) { --left: 5%;  --size: 30px; --duration: 18s; --delay: -4s;  --drift: 24px; }
        .rock-drop:nth-child(2) { --left: 18%; --size: 46px; --duration: 22s; --delay: -15s; --drift: -35px; }
        .rock-drop:nth-child(3) { --left: 32%; --size: 34px; --duration: 20s; --delay: -8s;  --drift: 42px; }
        .rock-drop:nth-child(4) { --left: 47%; --size: 52px; --duration: 24s; --delay: -19s; --drift: -28px; }
        .rock-drop:nth-child(5) { --left: 61%; --size: 28px; --duration: 17s; --delay: -11s; --drift: 34px; }
        .rock-drop:nth-child(6) { --left: 73%; --size: 43px; --duration: 23s; --delay: -6s;  --drift: -40px; }
        .rock-drop:nth-child(7) { --left: 85%; --size: 32px; --duration: 19s; --delay: -16s; --drift: 26px; }
        .rock-drop:nth-child(8) { --left: 94%; --size: 48px; --duration: 25s; --delay: -12s; --drift: -32px; }

        @keyframes rockRain {
            0% {
                transform: translate3d(0, -15vh, 0) rotate(0deg);
            }

            50% {
                transform: translate3d(var(--drift), 55vh, 0) rotate(180deg);
            }

            100% {
                transform: translate3d(0, 125vh, 0) rotate(360deg);
            }
        }

        a {
            text-decoration: none;
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            padding: 40px 20px;
            background-image:
                linear-gradient(
                    to bottom,
                    rgba(0,0,0,.30),
                    rgba(0,0,0,.88)
                ),
                url('{{ asset("images/invitaciones/julio-ernesto/hero.jpg") }}');
            background-size: cover;
            background-position: center;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(110deg, transparent 30%, rgba(180,0,0,.16), transparent 60%);
            animation: luces 7s linear infinite;
        }

        @keyframes luces {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .hero-content {
            position: relative;
            z-index: 3;
            max-width: 1000px;
        }

        .eyebrow {
            display: inline-block;
            letter-spacing: 8px;
            font-size: .9rem;
            color: #bdbdbd;
            margin-bottom: 25px;
        }

        .hero h1 {
            margin: 0;
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(5rem, 16vw, 11rem);
            line-height: .72;
            letter-spacing: 3px;
            text-shadow:
                5px 5px 0 #8d0000,
                9px 9px 30px rgba(0,0,0,.9);
        }

        .hero .apellido {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(1.4rem, 4vw, 2.7rem);
            letter-spacing: 12px;
            color: #c7c7c7;
            margin-top: 25px;
        }

        .hero .rock-line {
            font-family: 'Rock Salt', cursive;
            color: #d90000;
            margin: 35px 0 0;
            font-size: clamp(.9rem, 2vw, 1.4rem);
            transform: rotate(-3deg);
        }

        .hero-arrow {
            position: absolute;
            bottom: 30px;
            left: 50%;
            z-index: 4;
            transform: translateX(-50%);
            color: white;
            font-size: 2rem;
            animation: bajar 1.5s infinite;
        }

        @keyframes bajar {
            0%, 100% {
                transform: translate(-50%, 0);
            }

            50% {
                transform: translate(-50%, 10px);
            }
        }

        .section {
            padding: 100px 20px;
            position: relative;
        }

        .container {
            width: min(100%, 1050px);
            margin: auto;
        }

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            text-align: center;
            font-size: clamp(3.5rem, 8vw, 6rem);
            margin: 0 0 15px;
            letter-spacing: 3px;
        }

        .red {
            color: #d00000;
        }

        .subtitle {
            text-align: center;
            color: #999;
            max-width: 650px;
            margin: 0 auto 60px;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }

        .divider {
            width: 120px;
            height: 4px;
            margin: 25px auto 40px;
            background: #b40000;
            box-shadow: 0 0 25px rgba(255,0,0,.6);
        }

        .intro {
            background: #0d0d0d;
            text-align: center;
        }

        .intro-text {
            max-width: 780px;
            margin: auto;
            font-size: clamp(1.3rem, 3vw, 1.8rem);
            font-weight: 300;
            line-height: 1.7;
            color: #d2d2d2;
        }

        .intro strong {
            color: white;
            font-weight: 600;
        }

        .date-section {
            background:
                linear-gradient(rgba(0,0,0,.85), rgba(0,0,0,.95)),
                url('{{ asset("images/invitaciones/julio-ernesto/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .date-main {
            text-align: center;
            margin-bottom: 60px;
        }

        .date-main .date {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.8rem, 7vw, 5rem);
            letter-spacing: 4px;
        }

        .date-main .time {
            font-size: 1.6rem;
            color: #d00000;
            font-weight: 600;
            letter-spacing: 4px;
        }

        .countdown {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            max-width: 800px;
            margin: auto;
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
        }

        .count-item {
            padding: 30px 10px;
            text-align: center;
            border-right: 1px solid #333;
        }

        .count-item:last-child {
            border-right: 0;
        }

        .count-number {
            display: block;
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3rem, 7vw, 5rem);
            line-height: 1;
            color: #fff;
        }

        .count-label {
            display: block;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 8px;
        }

        .location {
            background: #090909;
        }

        .location-card {
            max-width: 750px;
            margin: auto;
            padding: 60px 30px;
            text-align: center;
            background:
                linear-gradient(145deg, #171717, #0c0c0c);
            border: 1px solid #282828;
            position: relative;
            box-shadow: 0 30px 80px rgba(0,0,0,.5);
        }

        .location-card::before,
        .location-card::after {
            content: "";
            position: absolute;
            background: #a90000;
        }

        .location-card::before {
            width: 70px;
            height: 3px;
            left: -1px;
            top: -1px;
        }

        .location-card::after {
            width: 3px;
            height: 70px;
            left: -1px;
            top: -1px;
        }

        .location-icon {
            font-size: 3rem;
            color: #c00000;
        }

        .location-card h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.5rem;
            margin: 20px 0 10px;
        }

        .address {
            color: #aaa;
            font-size: 1.2rem;
            margin-bottom: 35px;
        }

        .rock-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-width: 210px;
            padding: 15px 28px;
            border: 2px solid #b90000;
            color: white;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: .25s;
            background: transparent;
        }

        .rock-button:hover {
            color: white;
            background: #b90000;
            box-shadow: 0 0 30px rgba(200,0,0,.4);
            transform: translateY(-3px);
        }

        .details {
            background: #111;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .detail-card {
            min-height: 230px;
            padding: 40px 25px;
            border: 1px solid #292929;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #0a0a0a;
            transition: .3s;
        }

        .detail-card:hover {
            transform: translateY(-8px);
            border-color: #930000;
        }

        .detail-card i {
            font-size: 2.4rem;
            color: #bd0000;
            margin-bottom: 20px;
        }

        .detail-card h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        .detail-card p {
            color: #999;
            margin: 0;
        }

        .rsvp {
            text-align: center;
            min-height: 650px;
            display: flex;
            align-items: center;
            background:
                linear-gradient(rgba(0,0,0,.82), rgba(0,0,0,.96)),
                url('{{ asset("images/invitaciones/julio-ernesto/footer.jpg") }}');
            background-size: cover;
            background-position: center;
        }

        .rsvp h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(4rem, 9vw, 7rem);
            margin: 0;
            line-height: .9;
        }

        .rsvp p {
            color: #aaa;
            font-size: 1.2rem;
            margin: 30px auto 40px;
            max-width: 600px;
        }

        .signature {
            font-family: 'Rock Salt', cursive;
            color: #c90000;
            margin-top: 60px;
            font-size: 1rem;
        }

        footer {
            padding: 35px 20px;
            background: #050505;
            text-align: center;
            color: #555;
            letter-spacing: 2px;
            font-size: .8rem;
        }

        #musicButton {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            border: 1px solid #b00000;
            background: rgba(10,10,10,.92);
            color: white;
            z-index: 9999;
            font-size: 1.3rem;
            cursor: pointer;
            box-shadow: 0 0 25px rgba(180,0,0,.3);
        }

        .playing {
            animation: pulseMusic 1.3s infinite;
        }

        @keyframes pulseMusic {
            0%, 100% {
                box-shadow: 0 0 10px rgba(180,0,0,.3);
            }

            50% {
                box-shadow: 0 0 35px rgba(230,0,0,.8);
            }
        }

        @media (max-width: 768px) {
            .rock-drop {
                --size: 30px;
                opacity: .12;
            }

            .rock-drop:nth-child(even) {
                display: none;
            }

            .hero h1 {
                line-height: .82;
            }

            .hero .apellido {
                letter-spacing: 6px;
            }

            .countdown {
                grid-template-columns: repeat(2, 1fr);
            }

            .count-item:nth-child(2) {
                border-right: 0;
            }

            .count-item:nth-child(1),
            .count-item:nth-child(2) {
                border-bottom: 1px solid #333;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .date-section {
                background-attachment: scroll;
            }

            .section {
                padding: 75px 18px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .rock-rain {
                display: none;
            }
        }
    </style>
</head>

<body>

<audio id="rockAudio" loop autoplay preload="auto">
    <source src="{{ asset('audio/julio/smells.mpeg') }}" type="audio/mpeg">
</audio>

<div class="rock-rain" aria-hidden="true">
    @for ($i = 0; $i < 8; $i++)
        <img class="rock-drop" src="{{ asset('images/julio/rock-n-roll.png') }}" alt="">
    @endfor
</div>

<section class="hero">
    <div class="hero-content">
        <div class="eyebrow">ESTÁS INVITADO</div>

        <h1>
            JULIO<br>
            ERNESTO
        </h1>

        <div class="apellido">{{ $apellido }}</div>

        <div class="rock-line">
            Birthday Rock Night
        </div>
    </div>

    <a href="#invitacion" class="hero-arrow">
        <i class="bi bi-chevron-double-down"></i>
    </a>
</section>

<section class="section intro" id="invitacion">
    <div class="container">

        <h2 class="section-title">
            KEEP CALM <span class="red">&</span> ROCK ON
        </h2>

        <div class="divider"></div>

        <p class="intro-text">
            Hay noches que se olvidan y otras que se convierten en historia.
            Esta vez celebramos un año más de vida de
            <strong>Julio Ernesto</strong>
            con buena música, buenos amigos y una noche que merece subirle al volumen.
        </p>

    </div>
</section>

<section class="section date-section">
    <div class="container">

        <h2 class="section-title">
            SAVE <span class="red">THE DATE</span>
        </h2>

        <div class="date-main">
            <div class="date">{{ $fechaTexto }}</div>
            <div class="time">{{ $hora }}</div>
        </div>

        <div class="countdown">

            <div class="count-item">
                <span class="count-number" id="days">00</span>
                <span class="count-label">Días</span>
            </div>

            <div class="count-item">
                <span class="count-number" id="hours">00</span>
                <span class="count-label">Horas</span>
            </div>

            <div class="count-item">
                <span class="count-number" id="minutes">00</span>
                <span class="count-label">Minutos</span>
            </div>

            <div class="count-item">
                <span class="count-number" id="seconds">00</span>
                <span class="count-label">Segundos</span>
            </div>

        </div>

    </div>
</section>

<section class="section location">
    <div class="container">

        <h2 class="section-title">
            THE <span class="red">VENUE</span>
        </h2>

        <p class="subtitle">
            Donde va a comenzar el ruido.
        </p>

        <div class="location-card">

            <i class="bi bi-geo-alt-fill location-icon"></i>

            <h3>{{ $lugar }}</h3>

            <p class="address">
                {{ $direccion }}
            </p>

            <a href="{{ $mapsUrl }}"
               target="_blank"
               class="rock-button">

                <i class="bi bi-map"></i>
                Cómo llegar

            </a>

        </div>

    </div>
</section>

<section class="section details">
    <div class="container">

        <h2 class="section-title">
            BEFORE <span class="red">THE SHOW</span>
        </h2>

        <div class="divider"></div>

        <div class="details-grid">

            <div class="detail-card">
                <i class="bi bi-calendar-event"></i>
                <h3>FECHA</h3>
                <p>{{ $fechaTexto }}</p>
            </div>

            <div class="detail-card">
                <i class="bi bi-clock"></i>
                <h3>HORA</h3>
                <p>{{ $hora }}</p>
            </div>

            <div class="detail-card">
                <i class="bi bi-lightning-charge-fill"></i>
                <h3>DRESS CODE</h3>
                <p>
                    Rock / Casual<br>
                    Negro siempre es buena idea.
                </p>
            </div>

        </div>

    </div>
</section>

<section class="section rsvp">
    <div class="container">

        <h2>
            ARE YOU<br>
            <span class="red">READY?</span>
        </h2>

        <p>
            Confirma tu asistencia y prepárate para celebrar con Julio Ernesto.
            La única regla de la noche es venir con ganas de pasarla bien.
        </p>

        <a
            href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('¡Hola! Confirmo mi asistencia al cumpleaños de Julio Ernesto 🤘🎸') }}"
            target="_blank"
            class="rock-button"
        >
            <i class="bi bi-whatsapp"></i>
            Confirmar asistencia
        </a>

        <div class="signature">
            Long Live Rock & Roll
        </div>

    </div>
</section>

<footer>
    {{ $nombre }} · {{ $apellido }}
</footer>

<button id="musicButton" aria-label="Activar música">
    <i id="musicIcon" class="bi bi-volume-up-fill"></i>
</button>

<script>
    const targetDate = new Date(@json($fechaISO)).getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance <= 0) {
            document.getElementById('days').innerText = '00';
            document.getElementById('hours').innerText = '00';
            document.getElementById('minutes').innerText = '00';
            document.getElementById('seconds').innerText = '00';
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) /
            (1000 * 60 * 60)
        );

        const minutes = Math.floor(
            (distance % (1000 * 60 * 60)) /
            (1000 * 60)
        );

        const seconds = Math.floor(
            (distance % (1000 * 60)) /
            1000
        );

        document.getElementById('days').innerText =
            days.toString().padStart(2, '0');

        document.getElementById('hours').innerText =
            hours.toString().padStart(2, '0');

        document.getElementById('minutes').innerText =
            minutes.toString().padStart(2, '0');

        document.getElementById('seconds').innerText =
            seconds.toString().padStart(2, '0');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);

    const audio = document.getElementById('rockAudio');
    const musicButton = document.getElementById('musicButton');
    const musicIcon = document.getElementById('musicIcon');

    audio.volume = 0.45;

    function updateMusicButton() {
        const playing = !audio.paused;

        if (playing) {
            musicButton.classList.add('playing');
            musicIcon.classList.remove('bi-volume-up-fill');
            musicIcon.classList.add('bi-pause-fill');
            musicButton.setAttribute('aria-label', 'Pausar música');
        } else {
            musicButton.classList.remove('playing');
            musicIcon.classList.remove('bi-pause-fill');
            musicIcon.classList.add('bi-volume-up-fill');
            musicButton.setAttribute('aria-label', 'Activar música');
        }
    }

    async function startMusic() {
        try {
            await audio.play();
            return true;
        } catch (error) {
            return false;
        }
    }

    function removeUnlockListeners() {
        document.removeEventListener('pointerdown', unlockMusic);
        document.removeEventListener('keydown', unlockMusic);
    }

    async function unlockMusic(event) {
        if (event.target.closest && event.target.closest('#musicButton')) {
            return;
        }

        if (await startMusic()) {
            removeUnlockListeners();
        }
    }

    audio.addEventListener('play', updateMusicButton);
    audio.addEventListener('pause', updateMusicButton);

    window.addEventListener('load', async function () {
        if (!(await startMusic())) {
            document.addEventListener('pointerdown', unlockMusic);
            document.addEventListener('keydown', unlockMusic);
        }
    }, { once: true });

    musicButton.addEventListener('click', async function () {
        if (audio.paused) {
            if (await startMusic()) {
                removeUnlockListeners();
            }
        } else {
            audio.pause();
        }
    });
</script>

</body>
</html>
