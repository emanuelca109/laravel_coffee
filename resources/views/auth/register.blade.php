@extends('layouts.auth-modal')

@section('title', 'Registro | Coffee Dat')

@section('content')
<div class="stagger-1">
    <h4 class="auth-title">Crear Cuenta</h4>
    <p class="auth-subtitle">Regístrate y descubre el mejor café</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- Nombre --}}
    <div class="mb-3 stagger-2">
        <label class="form-label">Nombre Completo</label>

        <div class="input-icon-wrap">
            <i class="bi bi-person-fill"></i>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Tu nombre y apellido"
                required
                autofocus
                autocomplete="name"
            >
        </div>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Correo --}}
    <div class="mb-3 stagger-3">
        <label class="form-label">Correo Electrónico</label>

        <div class="input-icon-wrap">
            <i class="bi bi-envelope-fill"></i>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Ej: usuario@correo.com"
                required
                autocomplete="username"
            >
        </div>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Contraseña --}}
    <div class="mb-3 stagger-4">
        <label class="form-label">Contraseña</label>

        <div class="input-icon-wrap">
            <i class="bi bi-lock-fill"></i>
            <input
                id="password"
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Mínimo 8 caracteres"
                required
                autocomplete="new-password"
                style="padding-right: 42px;"
            >
            <button type="button" class="toggle-eye" id="togglePassword">
                <i class="bi bi-eye-fill" id="eyeIcon"></i>
            </button>
        </div>

        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Confirmar contraseña --}}
    <div class="mb-3 stagger-5">
        <label class="form-label">Confirmar Contraseña</label>

        <div class="input-icon-wrap">
            <i class="bi bi-lock-fill"></i>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Repite la contraseña"
                required
                autocomplete="new-password"
                style="padding-right: 42px;"
            >
            <button type="button" class="toggle-eye" id="toggleConfirmPassword">
                <i class="bi bi-eye-fill" id="eyeIconConfirm"></i>
            </button>
        </div>
    </div>

    <div class="stagger-5 mt-2">
        <button type="submit" class="btn-login">
            Crear Cuenta <i class="bi bi-person-plus-fill"></i>
        </button>

        <div class="links mt-3">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}">
                Inicia sesión aquí
            </a>
        </div>
    </div>

</form>
@endsection

@push('scripts')
<script>
    function setupToggle(buttonId, inputId, iconId) {
        const button = document.getElementById(buttonId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if(button && input && icon) {
            button.addEventListener('click', function () {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('bi-eye-fill');
                icon.classList.toggle('bi-eye-slash-fill');
            });
        }
    }

    setupToggle('togglePassword', 'password', 'eyeIcon');
    setupToggle('toggleConfirmPassword', 'password_confirmation', 'eyeIconConfirm');
</script>
@endpush