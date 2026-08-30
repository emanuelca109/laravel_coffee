@extends('layouts.auth-modal')

@section('title', 'Confirmar Contraseña | Coffee Dat')

@section('content')
<h4 class="auth-title">Confirmar Contraseña</h4>
<p class="auth-subtitle mb-4">Verifica tu identidad</p>

<p class="text-muted small mb-4" style="line-height: 1.6; color: #64748b !important;">
    Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.
</p>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div class="mb-5">
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

    <button type="submit" class="btn-login">
        Confirmar Identidad <i class="bi bi-shield-lock-fill ms-2"></i>
    </button>
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
