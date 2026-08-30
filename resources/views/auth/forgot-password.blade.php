@extends('layouts.auth-modal')

@section('title', 'Recuperar Contraseña | Coffee Dat')

@section('content')
<h4 class="auth-title">Recuperar Contraseña</h4>
<p class="auth-subtitle mb-4">¿Olvidaste tu contraseña? No hay problema.</p>

<p class="text-muted small mb-4" style="line-height: 1.6; color: #64748b !important;">
    Solo dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecerla que te permitirá elegir una nueva.
</p>

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-5">
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
            >
        </div>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn-login">
        Enviar Enlace de Recuperación <i class="bi bi-send-fill ms-2"></i>
    </button>
    
    <div class="links mt-4 text-center">
        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-arrow-left"></i> Volver al Inicio de Sesión
        </a>
    </div>
</form>
@endsection
