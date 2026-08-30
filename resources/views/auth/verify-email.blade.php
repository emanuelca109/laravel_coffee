@extends('layouts.auth-modal')

@section('title', 'Verificar Correo | Coffee Dat')

@section('content')
<h4 class="auth-title">Verifica tu Correo</h4>
<p class="auth-subtitle mb-4">Solo un paso más</p>

<p class="text-muted small mb-4" style="line-height: 1.6; color: #64748b !important;">
    ¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no recibiste el correo, con gusto te enviaremos otro.
</p>

@if (session('status') == 'verification-link-sent')
    <div class="alert-status bg-success bg-opacity-10 text-success border border-success rounded-3 p-3 mb-4 d-flex align-items-center gap-2 font-weight-bold" style="font-size: 0.85rem;">
        <i class="bi bi-check-circle-fill"></i>
        Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.
    </div>
@endif

<div class="d-flex flex-column gap-3 mt-5">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-login m-0">
            Reenviar Correo de Verificación <i class="bi bi-envelope-check-fill ms-2"></i>
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link text-decoration-none w-100 p-0 border-0" style="color: #94a3b8; font-size: 0.9rem; font-weight: 500;">
            Cerrar Sesión
        </button>
    </form>
</div>
@endsection
