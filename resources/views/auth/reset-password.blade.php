@extends('layouts.auth-modal')

@section('title', 'Restablecer Contraseña | Coffee Dat')

@section('content')
<h4 class="auth-title">Restablecer Contraseña</h4>
<p class="auth-subtitle">Ingresa tu nueva contraseña</p>

<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="mb-4">
        <label class="form-label">
            Correo Electrónico
        </label>

        <div class="input-icon-wrap">
            <i class="bi bi-envelope-fill"></i>
            <input
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Ej: usuario@correo.com"
                required
                autofocus
            >
        </div>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">
            Nueva Contraseña
        </label>

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

    <div class="mb-5">
        <label class="form-label">
            Confirmar Contraseña
        </label>

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
                style="padding-right: 46px;"
            >
            <button type="button" class="toggle-eye" id="toggleConfirmPassword">
                <i class="bi bi-eye-fill" id="eyeIconConfirm"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn-login">
        Restablecer Contraseña <i class="bi bi-check2-circle ms-2"></i>
    </button>
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
