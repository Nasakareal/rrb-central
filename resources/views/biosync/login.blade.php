<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#062332">
    <title>Acceso | BioSync UTM</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/biosync.css') }}">
</head>
<body class="biosync-login-page">
    <main class="login-shell">
        <section class="login-brand" aria-label="BioSync UTM">
            <img src="{{ asset('utm.png') }}" alt="Universidad Tecnológica de Morelia">
            <div>
                <span class="eyebrow">Control de asistencia</span>
                <h1>BioSync</h1>
                <p>Consulta, importa y administra los registros de asistencia desde cualquier equipo.</p>
            </div>
        </section>

        <section class="login-card">
            <div class="login-card-heading">
                <span class="login-mark">B</span>
                <div>
                    <h2>Bienvenido</h2>
                    <p>Ingresa con tu cuenta autorizada.</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('biosync.login.store') }}" class="login-form">
                @csrf
                <label for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>

                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required>

                <label class="check-row" for="remember">
                    <input id="remember" name="remember" type="checkbox" value="1">
                    <span>Mantener mi sesión iniciada</span>
                </label>

                <button class="button button-primary button-block" type="submit">Ingresar a BioSync</button>
            </form>

            <p class="login-help">El acceso está limitado al personal autorizado por RRB Soluciones.</p>
        </section>
    </main>
</body>
</html>
