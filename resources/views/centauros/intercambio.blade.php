{{-- resources/views/centauros/intercambio.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Intercambio Centauros | RRB Soluciones</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --centauro-gold: #f5c453;
            --centauro-dark: #05060a;
            --centauro-red:  #e63946;
            --centauro-purple: #5a189a;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at top, #261c3f 0, #05060a 40%, #000 100%);
            color: #f5f5f5;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glow-bg {
            position: fixed;
            inset: -30%;
            background:
                radial-gradient(circle at 10% 10%, rgba(245,196,83,0.35), transparent 60%),
                radial-gradient(circle at 90% 0%, rgba(90,24,154,0.5), transparent 60%),
                radial-gradient(circle at 50% 100%, rgba(230,57,70,0.6), transparent 65%);
            filter: blur(18px);
            opacity: 0.9;
            z-index: -1;
        }

        .card-intercambio {
            width: 100%;
            max-width: 450px;
            border-radius: 26px;
            border: 1px solid rgba(255,255,255,0.12);
            background: linear-gradient(145deg, rgba(5,6,10,0.96), rgba(14,16,33,0.98));
            box-shadow:
                0 0 40px rgba(0,0,0,0.9),
                0 0 55px rgba(245,196,83,0.2);
            padding: 2.2rem 2rem 2.4rem;
        }

        .badge-logo {
            font-family: 'Oswald', sans-serif;
            letter-spacing: 0.16em;
            font-size: 0.78rem;
            text-transform: uppercase;
            color: var(--centauro-gold);
        }

        .title {
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-size: 1.2rem;
            margin-bottom: 0.4rem;
        }

        .subtitle {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.75);
        }

        .form-label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: rgba(255,255,255,0.8);
        }

        .form-control {
            border-radius: 999px;
            background: rgba(0,0,0,0.7);
            border: 1px solid rgba(255,255,255,0.18);
            color: #fff;
            font-size: 0.85rem;
        }

        .form-control:focus {
            border-color: var(--centauro-gold);
            box-shadow: 0 0 0 1px rgba(245,196,83,0.6);
            background: rgba(0,0,0,0.9);
            color: #fff;
        }

        .btn-centauro {
            border-radius: 999px;
            background: linear-gradient(120deg, var(--centauro-red), var(--centauro-purple));
            border: none;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            padding: 0.85rem 1.8rem;
            width: 100%;
            color: #fff;
            box-shadow:
                0 0 16px rgba(230,57,70,0.8),
                0 0 36px rgba(90,24,154,0.9);
        }

        .btn-centauro:hover {
            transform: translateY(-1px);
        }

        .error-text {
            font-size: 0.75rem;
            color: #ff9b9b;
        }

        /* RESULTADO */
        .resultado-box {
            margin-top: 1.6rem;
            padding: 1.3rem 1rem;
            border-radius: 22px;
            background: radial-gradient(circle at top, rgba(245,196,83,0.25), rgba(0,0,0,0.95));
            border: 1px solid rgba(245,196,83,0.55);
            box-shadow: 0 0 28px rgba(245,196,83,0.5);
        }

        .resultado-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: rgba(0,0,0,0.85);
            background: rgba(245,196,83,0.9);
            border-radius: 999px;
            padding: 0.25rem 0.9rem;
            display: inline-block;
            margin-bottom: 0.8rem;
        }

        .resultado-nombre {
            font-family: 'Oswald', sans-serif;
            font-size: 1.3rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--centauro-gold);
            text-shadow:
                0 0 15px rgba(245,196,83,0.8),
                0 0 40px rgba(230,57,70,0.7);
        }

        .hint {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.75);
        }

        .back-link {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
        }

        .back-link:hover {
            color: rgba(255,255,255,0.9);
        }
    </style>
</head>
<body>

<div class="glow-bg"></div>

<div class="card-intercambio">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="badge-logo">CENTAUROS</div>
            <div class="title">INTERCAMBIO SECRETO</div>
        </div>
        <div style="font-size: 0.7rem; text-align: right; color: rgba(255,255,255,0.65);">
            Solo para la banda<br>de la academia
        </div>
    </div>

    @if(!isset($datos))
        <p class="subtitle mb-4">
            Escribe el <strong>usuario</strong> y la <strong>contraseña</strong> que se te asignó.
            Al entrar, vas a ver el nombre de la persona que te tocó.  
            <span style="font-size:0.75rem; display:block; margin-top:0.3rem;">
                No le tomes captura si no quieres que te linchen en el salón.
            </span>
        </p>

        @if($errors->any())
            <div class="mb-3">
                <div class="error-text">
                    {{ $errors->first('usuario') }}
                </div>
            </div>
        @endif

        <form action="{{ route('centauros.intercambio.procesar') }}" method="POST" class="mt-2">
            @csrf
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input
                    type="text"
                    name="usuario"
                    id="usuario"
                    class="form-control @error('usuario') is-invalid @enderror"
                    value="{{ old('usuario') }}"
                    autocomplete="off"
                    autofocus
                >
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                >
            </div>

            <button type="submit" class="btn btn-centauro">
                VER A QUIÉN TE TOCÓ
            </button>
        </form>

        <div class="mt-4 d-flex justify-content-between align-items-center">
            <span class="hint">
                Si se te olvidó el usuario o la clave,<br>
                ya sabes con quién chingar: el admin del grupo.
            </span>
            <a href="{{ route('centauros.index') }}" class="back-link">
                ← Volver a la galería
            </a>
        </div>
    @else
        {{-- RESULTADO DEL INTERCAMBIO --}}
        <p class="subtitle mb-3">
            Bien ahí, <strong>{{ $datos['nombre'] }}</strong>.  
            Guarda bien este nombre, es a quien le vas a armar el regalo.
        </p>

        <div class="resultado-box mb-4">
            <div class="resultado-label">
                TE TOCÓ:
            </div>
            <div class="resultado-nombre">
                {{ $datos['asignado'] }}
            </div>
        </div>

        <p class="hint mb-4">
            Tip: no vayas a andar enseñando la pantalla a todo mundo,
            la idea es que el intercambio quede chido y con sorpresa.
        </p>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('centauros.index') }}" class="back-link">
                ← Volver a la galería Centauros
            </a>
            <span style="font-size: 0.75rem; color: rgba(255,255,255,0.65);">
                Puedes cerrar esta pestaña, ya quedó grabado en tu conciencia.
            </span>
        </div>
    @endif
</div>

</body>
</html>
