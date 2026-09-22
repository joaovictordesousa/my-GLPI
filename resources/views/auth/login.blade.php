<x-guest-layout>
    <div class="login-heading">
        <span class="login-heading-icon"><i class="bi bi-shield-lock"></i></span>
        <div><h2>Bem-vindo de volta</h2><p>Entre para acessar seus chamados.</p></div>
    </div>

    <x-auth-session-status class="login-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="login-field">
            <label for="email">E-mail</label>
            <div class="login-input-wrap"><i class="bi bi-envelope"></i><input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="seuemail@empresa.com"></div>
            @error('email')<p class="login-error">{{ $message }}</p>@enderror
        </div>

        <div class="login-field">
            <label for="password">Senha</label>
            <div class="login-input-wrap"><i class="bi bi-lock"></i><input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Sua senha"></div>
            @error('password')<p class="login-error">{{ $message }}</p>@enderror
        </div>

        <!-- Remember Me -->
        <div class="login-options">
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember"><span>Manter conectado</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Esqueci minha senha</a>
            @endif
        </div>

        <button class="login-submit" type="submit"><span>Entrar no sistema</span><i class="bi bi-arrow-right"></i></button>

        @if (Route::has('register'))
            <p class="login-register">Ainda não tem uma conta? <a href="{{ route('register') }}">Criar cadastro</a></p>
        @endif
    </form>

    <style>
        .login-heading { display: flex; align-items: center; gap: .85rem; margin-bottom: 2rem; }
        .login-heading-icon { display: grid; width: 46px; height: 46px; place-items: center; color: #1463e8; font-size: 1.25rem; border-radius: 13px; background: #eaf2ff; }
        .login-heading h2 { margin: 0 0 .2rem; font-size: 1.35rem; letter-spacing: -.03em; }
        .login-heading p { margin: 0; color: #64748b; font-size: .88rem; }
        .login-field { margin-bottom: 1.15rem; }
        .login-field label { display: block; margin-bottom: .45rem; color: #334155; font-size: .84rem; font-weight: 650; }
        .login-input-wrap { position: relative; }
        .login-input-wrap i { position: absolute; top: 50%; left: .9rem; color: #8b99ad; transform: translateY(-50%); }
        .login-input-wrap input { width: 100%; height: 47px; padding: 0 .85rem 0 2.55rem; color: #182033; border: 1px solid #d9e1ed; border-radius: 9px; outline: 0; transition: .2s; }
        .login-input-wrap input:focus { border-color: #71a1f7; box-shadow: 0 0 0 4px rgba(20,99,232,.11); }
        .login-error { margin: .4rem 0 0; color: #dc3545; font-size: .78rem; }
        .login-options { display: flex; justify-content: space-between; align-items: center; margin: 1.4rem 0 1.5rem; font-size: .82rem; }
        .login-options label { display: flex; gap: .45rem; align-items: center; color: #64748b; cursor: pointer; }
        .login-options input { accent-color: #1463e8; }
        .login-options a, .login-register a { color: #1463e8; font-weight: 650; text-decoration: none; }
        .login-submit { display: flex; width: 100%; min-height: 48px; align-items: center; justify-content: space-between; padding: 0 1rem 0 1.15rem; color: #fff; border: 0; border-radius: 9px; background: #1463e8; box-shadow: 0 8px 16px rgba(20,99,232,.22); font-weight: 700; cursor: pointer; transition: .2s; }
        .login-submit:hover { background: #0d4fbe; transform: translateY(-1px); }
        .login-submit i { display: grid; width: 27px; height: 27px; place-items: center; border-radius: 7px; background: rgba(255,255,255,.16); }
        .login-register { margin: 1.5rem 0 0; color: #64748b; font-size: .84rem; text-align: center; }
        .login-status { margin-bottom: 1rem; color: #15803d; font-size: .85rem; }
    </style>
</x-guest-layout>
