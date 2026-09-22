<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Entrar | Sistema de Chamados</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased login-page">
        <main class="login-shell">
            <section class="login-branding">
                <a href="/" class="login-logo">
                    <img src="{{ asset('img/Logo_JvS.png') }}" alt="JvS">
                    <span>Sistema de Chamados</span>
                </a>
                <div class="login-branding-content">
                    <span class="login-eyebrow">CENTRAL DE ATENDIMENTO</span>
                    <h1>Atendimento de TI<br>simples e organizado.</h1>
                    <p>Abra, acompanhe e resolva solicitações em um único lugar.</p>
                </div>
                <p class="login-copyright">© {{ date('Y') }} Sistema de Chamados</p>
            </section>
            <section class="login-panel">
                <div class="login-card">{{ $slot }}</div>
            </section>
        </main>
        <style>
            :root { --login-primary: #1463e8; --login-text: #182033; --login-muted: #64748b; }
            * { box-sizing: border-box; }
            .login-page { margin: 0; color: var(--login-text); font-family: Figtree, Inter, "Segoe UI", sans-serif; background: #f7f9fd; }
            .login-shell { min-height: 100vh; display: grid; grid-template-columns: minmax(360px, 46%) 1fr; }
            .login-branding { position: relative; display: flex; flex-direction: column; padding: 3rem clamp(2rem, 6vw, 6rem); color: #fff; overflow: hidden; background: linear-gradient(145deg, #0c3d9c 0%, #1463e8 57%, #5a99ff 100%); }
            .login-branding::before, .login-branding::after { content: ""; position: absolute; border-radius: 50%; border: 1px solid rgba(255,255,255,.16); }
            .login-branding::before { width: 39rem; height: 39rem; right: -20rem; bottom: -19rem; }
            .login-branding::after { width: 23rem; height: 23rem; left: -12rem; top: -9rem; }
            .login-logo { position: relative; z-index: 1; display: inline-flex; align-items: center; gap: .75rem; color: #fff; font-size: 1.05rem; font-weight: 700; text-decoration: none; }
            .login-logo img { width: 62px; height: auto; filter: brightness(0) invert(1); }
            .login-branding-content { position: relative; z-index: 1; margin: auto 0; max-width: 34rem; }
            .login-eyebrow { font-size: .7rem; font-weight: 700; letter-spacing: .15em; opacity: .75; }
            .login-branding h1 { margin: 1rem 0 1.25rem; font-size: clamp(2.15rem, 4vw, 3.6rem); line-height: 1.12; letter-spacing: -.045em; }
            .login-branding p { margin: 0; font-size: 1.05rem; line-height: 1.65; color: rgba(255,255,255,.8); }
            .login-copyright { position: relative; z-index: 1; font-size: .78rem !important; }
            .login-panel { display: grid; place-items: center; padding: 2rem; background: radial-gradient(circle at 100% 0, #e8f0ff, transparent 30rem), #f8faff; }
            .login-card { width: min(100%, 430px); padding: 2.6rem; border: 1px solid #e6ebf3; border-radius: 20px; background: #fff; box-shadow: 0 20px 50px rgba(30, 60, 110, .12); }
            @media (max-width: 800px) { .login-shell { display: block; } .login-branding { min-height: 180px; padding: 1.5rem 2rem; } .login-branding-content, .login-copyright { display: none; } .login-panel { min-height: calc(100vh - 180px); padding: 1.25rem; } .login-card { padding: 2rem 1.5rem; } }
        </style>
    </body>
</html>
