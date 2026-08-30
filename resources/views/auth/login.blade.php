@extends('layouts.auth-modal')

@section('title', 'Login | Coffee Dat')

@section('content')
<div class="stagger-1">
    <h4 class="auth-title">Bienvenido</h4>
    <p class="auth-subtitle">Inicia sesión para continuar en Coffee Dat</p>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3 stagger-2">
        <label class="form-label">
            Correo Electrónico
        </label>

        <div class="input-icon-wrap">
            <i class="bi bi-envelope-fill"></i>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Ej: usuario@correo.com"
                required
                autofocus
                autocomplete="username"
            >
        </div>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4 stagger-3">
        <label class="form-label">
            Contraseña
        </label>

        <div class="input-icon-wrap">
            <i class="bi bi-lock-fill"></i>
            <input
                id="password"
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="••••••••"
                required
                autocomplete="current-password"
                style="padding-right: 46px;"
            >
            <button type="button" class="toggle-eye" id="togglePassword">
                <i class="bi bi-eye-fill" id="eyeIcon"></i>
            </button>
        </div>

        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between mb-5 mt-2 align-items-center stagger-4">
        <div class="form-check m-0 d-flex align-items-center gap-2">
            <input
                class="form-check-input m-0"
                type="checkbox"
                name="remember"
                id="remember_me"
                style="width: 1.1rem; height: 1.1rem; cursor: pointer;"
            >
            <label class="form-check-label m-0" for="remember_me" style="font-size: 0.9rem; cursor: pointer; color: #64748b !important;">
                Recordarme
            </label>
        </div>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot">
                ¿Olvidaste tu contraseña?
            </a>
        @endif
    </div>

    <div class="stagger-5">
        <button type="submit" class="btn-login">
            Iniciar Sesión <i class="bi bi-arrow-right"></i>
        </button>

        @if (Route::has('register'))
            <div class="links">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}">
                    Regístrate aquí
                </a>
            </div>
        @endif
    </div>
</form>
@endsection

@push('scripts')
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if(togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('bi-eye-fill');
            eyeIcon.classList.toggle('bi-eye-slash-fill');
        });
    }
</script>
@endpush