<link rel="preload" as="image" href="{{ asset('img/fon.webp') }}" type="image/webp">
<script>
    if (typeof window.__preloadedLoginImg === 'undefined') {
        window.__preloadedLoginImg = new Image();
        window.__preloadedLoginImg.src = "{{ asset('img/fon.webp') }}";
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    /* ===========================
            ESTILOS DEL MODAL ELEGANTE + SÚPER ANIMACIONES
    ============================ */
    .modal-login {
        font-family: 'Poppins', sans-serif;
    }

    /* Animación de entrada con efecto rebote (Bounce In) */
    .modal-login .modal-dialog {
        max-width: 950px;
        width: 100%;
        margin: auto;
        animation: bounceIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @keyframes bounceIn {
        0% { opacity: 0; transform: scale(0.8) translateY(50px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }

    .modal-login .modal-content {
        border: none;
        border-radius: 30px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        background: #ffffff;
        min-height: 550px;
    }

    /* La imagen entra deslizando desde la izquierda */
    .modal-login .modal-image {
        width: 45%;
        background-image: url('{{ asset('img/fon.webp') }}');
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
        animation: slideInLeft 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    @keyframes slideInLeft {
        0% { transform: translateX(-40px); opacity: 0; }
        100% { transform: translateX(0); opacity: 1; }
    }

    /* Efecto de zoom lento en la imagen de fondo */
    .modal-login .modal-image::before {
        content: "";
        position: absolute;
        inset: -10%;
        background-image: url('{{ asset('img/fon.webp') }}');
        background-size: cover;
        background-position: center;
        animation: slowPan 20s linear infinite alternate;
        z-index: 0;
    }

    @keyframes slowPan {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }

    .modal-login .modal-image::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(20, 108, 67, 0.4), rgba(0, 0, 0, 0.8));
        z-index: 1;
    }

    .modal-login .modal-image .logo {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px;
        text-align: center;
        color: #ffffff;
    }

    /* Animación flotante + resplandor para el logo */
    .modal-login .modal-image .logo img {
        width: 100%;
        max-width: 240px;
        height: auto;
        margin-bottom: 20px;
        animation: floating 4s ease-in-out infinite, pulseGlow 3s infinite alternate;
    }

    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-12px); }
        100% { transform: translateY(0px); }
    }

    @keyframes pulseGlow {
        0% { filter: drop-shadow(0 4px 6px rgba(0,0,0,0.4)) brightness(1); }
        100% { filter: drop-shadow(0 0 15px rgba(255,255,255,0.3)) brightness(1.1); }
    }
    
    .modal-login .modal-image .logo p {
        font-size: 1rem;
        font-weight: 300;
        letter-spacing: 0.5px;
        opacity: 0.9;
        line-height: 1.5;
        animation: fadeUp 0.8s ease-out forwards 0.5s;
        opacity: 0;
    }

    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* El formulario entra deslizando desde la derecha */
    .modal-login .modal-form {
        width: 55%;
        background: #ffffff;
        padding: 35px 45px;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        animation: slideInRight 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    @keyframes slideInRight {
        0% { transform: translateX(40px); opacity: 0; }
        100% { transform: translateX(0); opacity: 1; }
    }

    .modal-login .btn-close-custom {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 50;
        background: #f1f5f9;
        color: #64748b;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    .modal-login .btn-close-custom:hover {
        background: #fee2e2;
        color: #ef4444;
        transform: rotate(90deg) scale(1.1);
    }

    .form-label {
        font-weight: 600;
        display: block;
        margin-bottom: 0.3rem;
        color: #334155;
        font-size: 0.85rem;
    }

    /* ANIMACIONES EN CASCADA PARA LOS CAMPOS DEL FORMULARIO */
    .stagger-1 { animation: fadeUp 0.5s ease-out forwards 0.3s; opacity: 0; }
    .stagger-2 { animation: fadeUp 0.5s ease-out forwards 0.4s; opacity: 0; }
    .stagger-3 { animation: fadeUp 0.5s ease-out forwards 0.5s; opacity: 0; }
    .stagger-4 { animation: fadeUp 0.5s ease-out forwards 0.6s; opacity: 0; }
    .stagger-5 { animation: fadeUp 0.5s ease-out forwards 0.7s; opacity: 0; }

    /* INPUTS CON ICONO */
    .input-icon-wrap {
        position: relative;
        transition: transform 0.3s ease;
    }

    /* Pequeño salto al hacer focus en el input */
    .input-icon-wrap:focus-within {
        transform: translateY(-2px);
    }

    .input-icon-wrap > i {
        position: absolute;
        top: 50%;
        left: 18px;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.05rem;
        pointer-events: none;
        transition: color 0.3s, transform 0.3s;
    }

    .form-control {
        width: 100%;
        height: 48px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        padding-left: 50px;
        background: #f8fafc;
        outline: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        color: #334155;
    }

    .form-control::placeholder {
        color: #cbd5e1;
    }

    /* Pulso continuo al enfocar el input */
    .form-control:focus {
        border-color: #16a34a;
        background: #ffffff;
        animation: inputPulse 1.5s infinite;
    }
    
    @keyframes inputPulse {
        0% { box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.4); }
        70% { box-shadow: 0 0 0 5px rgba(22, 163, 74, 0); }
        100% { box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
    }
    
    .input-icon-wrap:focus-within > i {
        color: #16a34a;
        transform: translateY(-50%) scale(1.15) rotate(-5deg);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .invalid-feedback {
        color: #ef4444;
        font-weight: 500;
        font-size: 0.75rem;
        margin-top: 0.3rem;
        display: block;
    }

    .toggle-eye {
        position: absolute;
        top: 50%;
        right: 18px;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        padding: 0;
        line-height: 1;
        cursor: pointer;
        z-index: 5;
        font-size: 1.05rem;
        transition: all 0.3s;
    }

    .toggle-eye:hover {
        color: #334155;
        transform: translateY(-50%) scale(1.1);
    }

    /* BOTÓN CON GRADIENTE FLUIDO ANIMADO */
    .btn-login {
        width: 100%;
        height: 48px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(270deg, #16a34a, #15803d, #22c55e, #16a34a);
        background-size: 300% 300%;
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        margin-top: 10px;
        box-shadow: 0 6px 15px rgba(22, 163, 74, 0.25);
        animation: gradientFlow 4s ease infinite;
    }

    @keyframes gradientFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .btn-login:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 10px 20px rgba(22, 163, 74, 0.35);
    }
    
    .btn-login i {
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .btn-login:hover i.bi-arrow-right {
        transform: translateX(5px) scale(1.1);
    }

    .btn-login:active {
        transform: translateY(0) scale(0.98);
        box-shadow: 0 4px 10px rgba(22, 163, 74, 0.3);
    }

    .links {
        text-align: center;
        margin-top: 15px;
        font-size: 0.85rem;
        color: #64748b;
    }

    .links a {
        color: #16a34a;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 4px;
        display: inline-block;
    }

    .links a:hover {
        color: #15803d;
        transform: scale(1.05);
    }

    .forgot {
        color: #16a34a;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .forgot:hover {
        color: #15803d;
        text-decoration: underline;
    }

    .auth-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.1rem;
        text-align: center;
    }
    
    .auth-subtitle {
        color: #64748b;
        font-size: 0.85rem;
        margin-bottom: 1.2rem;
        text-align: center;
    }

    @media(max-width: 767px) {
        .modal-login .modal-content {
            flex-direction: column;
            border-radius: 20px;
        }

        .modal-login .modal-image {
            width: 100%;
            height: 140px;
        }

        .modal-login .modal-form {
            width: 100%;
            padding: 30px 25px;
        }
        
        .modal-login .btn-close-custom {
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,0.9);
        }
    }
</style>

<!-- Import Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<div x-data="authModals()" 
     @open-login.window="isOpen = true; mode = 'login'; setIntendedFav($event.detail?.productId || ''); setIntendedBuy($event.detail?.buyProductId || '', $event.detail?.buyQuantity || 1);" 
     @open-register.window="isOpen = true; mode = 'register'; setIntendedFav($event.detail?.productId || ''); setIntendedBuy($event.detail?.buyProductId || '', $event.detail?.buyQuantity || 1);"
     @keydown.escape.window="isOpen = false"
     x-show="isOpen"
     style="display: none;"
     class="fixed inset-0 z-[2000] flex items-center justify-center bg-slate-900/70 backdrop-blur-md p-4 overflow-y-auto modal-login"
     x-transition.opacity.duration.400ms>

    <div class="modal-dialog">
        
        <div class="modal-content relative w-full h-auto">
            
            <button type="button" @click="isOpen = false" class="btn-close-custom" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="modal-image hidden md:block">
                <div class="logo">
                    <img src="{{ asset('img/logo-full.svg') }}" alt="Coffee Dat">
                    <p>Las mejores herramientas e insumos para la caficultura.</p>
                </div>
            </div>
            
            <div class="modal-form">
                
                 {{-- LOGIN FORM --}}
                 <div x-show="mode === 'login'" 
                      x-transition:enter="transition-all duration-400 ease-out" 
                      x-transition:enter-start="opacity-0 translate-x-8" 
                      x-transition:enter-end="opacity-100 translate-x-0">
                      
                     <div class="stagger-1">
                         <h4 class="auth-title">Bienvenido</h4>
                         <p class="auth-subtitle">Inicia sesión para continuar en Coffee Dat</p>
                     </div>

                     @if (session('status'))
                        <div class="bg-green-50 border border-green-600 text-green-700 rounded-xl px-4 py-3 text-sm font-bold mb-3 flex items-center gap-2 stagger-1">
                            <i class="bi bi-check-circle-fill"></i>
                            {{ session('status') }}
                        </div>
                     @endif

                     <form method="POST" action="{{ route('login') }}">
                         @csrf
                         <input type="hidden" name="intended_favorite_product" :value="intendedFav">
                         <input type="hidden" name="intended_buy_product" :value="intendedBuyId">
                         <input type="hidden" name="intended_buy_quantity" :value="intendedBuyQty">

                         <div class="mb-3 stagger-2">
                             <label class="form-label">Correo Electrónico</label>
                             <div class="input-icon-wrap">
                                 <i class="bi bi-envelope-fill"></i>
                                 <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control @if($errors->has('email') && !old('name')) is-invalid @endif"
                                        placeholder="Ej: usuario@correo.com" required autofocus>
                             </div>
                             @if($errors->has('email') && !old('name'))
                                 <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                             @endif
                         </div>

                         <div class="mb-3 stagger-3">
                             <label class="form-label">Contraseña</label>
                             <div class="input-icon-wrap">
                                 <i class="bi bi-lock-fill"></i>
                                 <input id="login_password" type="password" name="password"
                                        class="form-control @if($errors->has('password') && !old('name')) is-invalid @endif"
                                        placeholder="••••••••" required style="padding-right: 42px;">
                                 <button type="button" class="toggle-eye" @click="togglePass('login_password', 'login_eye')">
                                     <i class="bi bi-eye-fill" id="login_eye"></i>
                                 </button>
                             </div>
                             @if($errors->has('password') && !old('name'))
                                 <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                             @endif
                         </div>

                         <div class="flex justify-between items-center mb-3 mt-1 stagger-4">
                             <label class="flex items-center text-slate-600 cursor-pointer gap-2 text-sm font-medium">
                                 <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-green-600 focus:ring-green-500 transition">
                                 <span>Recordarme</span>
                             </label>
                             @if (Route::has('password.request'))
                                 <a @click.prevent="mode = 'forgot'" class="forgot cursor-pointer">¿Olvidaste tu contraseña?</a>
                             @endif
                         </div>

                         <div class="stagger-5">
                             <button type="submit" class="btn-login">
                                 Iniciar Sesión <i class="bi bi-arrow-right"></i>
                             </button>

                             @if (Route::has('register'))
                                 <div class="links">
                                     ¿No tienes cuenta?
                                     <a @click.prevent="mode = 'register'">Regístrate aquí</a>
                                 </div>
                             @endif
                         </div>
                     </form>
                 </div>

                 {{-- REGISTER FORM --}}
                 <div x-show="mode === 'register'" 
                      style="display: none;"
                      x-transition:enter="transition-all duration-400 ease-out" 
                      x-transition:enter-start="opacity-0 translate-x-8" 
                      x-transition:enter-end="opacity-100 translate-x-0">
                      
                      <div class="stagger-1">
                          <h4 class="auth-title">Crear Cuenta</h4>
                          <p class="auth-subtitle">Regístrate y descubre el mejor café</p>
                      </div>

                     <form method="POST" action="{{ route('register') }}">
                         @csrf
                         <input type="hidden" name="intended_favorite_product" :value="intendedFav">
                         <input type="hidden" name="intended_buy_product" :value="intendedBuyId">
                         <input type="hidden" name="intended_buy_quantity" :value="intendedBuyQty">

                         <div class="mb-3 stagger-2">
                             <label class="form-label">Nombre Completo</label>
                             <div class="input-icon-wrap">
                                 <i class="bi bi-person-fill"></i>
                                 <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Tu nombre y apellido" required>
                             </div>
                             @error('name')
                                 <span class="invalid-feedback">{{ $message }}</span>
                             @enderror
                         </div>

                         <div class="mb-3 stagger-3">
                             <label class="form-label">Correo Electrónico</label>
                             <div class="input-icon-wrap">
                                 <i class="bi bi-envelope-fill"></i>
                                 <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control @if($errors->has('email') && old('name')) is-invalid @endif"
                                        placeholder="Ej: usuario@correo.com" required>
                             </div>
                             @if($errors->has('email') && old('name'))
                                 <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                             @endif
                         </div>

                         <div class="mb-3 stagger-4">
                             <label class="form-label">Contraseña</label>
                             <div class="input-icon-wrap">
                                 <i class="bi bi-lock-fill"></i>
                                 <input id="register_password" type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Mínimo 8 caracteres" required style="padding-right: 42px;">
                                 <button type="button" class="toggle-eye" @click="togglePass('register_password', 'register_eye')">
                                     <i class="bi bi-eye-fill" id="register_eye"></i>
                                 </button>
                             </div>
                             @error('password')
                                 <span class="invalid-feedback">{{ $message }}</span>
                             @enderror
                         </div>

                         <div class="mb-3 stagger-5">
                             <label class="form-label">Confirmar Contraseña</label>
                             <div class="input-icon-wrap">
                                 <i class="bi bi-lock-fill"></i>
                                 <input id="register_password_confirmation" type="password" name="password_confirmation"
                                        class="form-control"
                                        placeholder="Repite la contraseña" required style="padding-right: 42px;">
                                 <button type="button" class="toggle-eye" @click="togglePass('register_password_confirmation', 'register_eye_confirm')">
                                     <i class="bi bi-eye-fill" id="register_eye_confirm"></i>
                                 </button>
                             </div>
                         </div>

                         <div class="stagger-5 mt-2">
                             <button type="submit" class="btn-login">
                                 Crear Cuenta <i class="bi bi-person-plus-fill"></i>
                             </button>

                             <div class="links mt-3">
                                 ¿Ya tienes una cuenta?
                                 <a @click.prevent="mode = 'login'">Inicia sesión aquí</a>
                             </div>
                         </div>
                     </form>
                 </div>

                 {{-- FORGOT PASSWORD FORM --}}
                 <div x-show="mode === 'forgot'" 
                      style="display: none;"
                      x-transition:enter="transition-all duration-400 ease-out" 
                      x-transition:enter-start="opacity-0 translate-x-8" 
                      x-transition:enter-end="opacity-100 translate-x-0">
                      
                      <div class="stagger-1">
                          <h4 class="auth-title">Recuperar</h4>
                          <p class="auth-subtitle">Te ayudaremos a entrar.</p>
                      </div>

                     <div class="stagger-2 mb-4">
                         <p class="text-slate-500 text-sm text-center" style="line-height: 1.5;">
                             Ingresa tu correo electrónico y te enviaremos un enlace seguro para restablecer tu contraseña.
                         </p>
                     </div>

                     <form method="POST" action="{{ route('password.email') }}">
                         @csrf

                         <div class="mb-4 stagger-3">
                             <label class="form-label">Correo Electrónico</label>
                             <div class="input-icon-wrap">
                                 <i class="bi bi-envelope-fill"></i>
                                 <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control @if($errors->has('email') && !old('password') && !old('name')) is-invalid @endif"
                                        placeholder="Ej: usuario@correo.com" required>
                             </div>
                             @if($errors->has('email') && !old('password') && !old('name'))
                                 <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                             @endif
                         </div>

                         <div class="stagger-4 mt-2">
                             <button type="submit" class="btn-login">
                                 Enviar Enlace <i class="bi bi-send-fill"></i>
                             </button>

                             <div class="links mt-4">
                                 <a @click.prevent="mode = 'login'" class="flex items-center justify-center gap-1">
                                     <i class="bi bi-arrow-left"></i> Volver al inicio
                                 </a>
                             </div>
                         </div>
                     </form>
                 </div>

            </div>
        </div>
    </div>
</div>

<style>
@keyframes cartBadgeBounce {
    0% { transform: scale(1); }
    50% { transform: scale(1.4); }
    100% { transform: scale(1); }
}
.cart-badge-bounce {
    animation: cartBadgeBounce 0.4s ease-out;
}
@keyframes fastToastIn {
    0% { opacity: 0; transform: translateY(-16px) scale(0.92); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes fastToastOut {
    0% { opacity: 1; transform: translateY(0) scale(1); }
    100% { opacity: 0; transform: translateY(-12px) scale(0.92); }
}
@keyframes toastDrain {
    0% { width: 100%; }
    100% { width: 0%; }
}
.toast-card-enter {
    animation: fastToastIn 0.18s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.toast-card-leave {
    animation: fastToastOut 0.15s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.toast-progress-bar {
    animation: toastDrain 2.2s linear forwards;
}
</style>

<div id="ajax-toast-container" class="fixed top-6 right-6 z-[9999999] pointer-events-none flex flex-col items-end gap-2.5 max-w-[90vw]"></div>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    window.showAjaxToast(@json(session('success')), 'success');
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    window.showAjaxToast(@json(session('error')), 'error');
});
</script>
@endif

@if(session('status'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    window.showAjaxToast(@json(session('status')), 'info');
});
</script>
@endif

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('authModals', () => ({
        mode: '{!! session('status') ? 'forgot' : ((count($errors) > 0 && old("name")) ? "register" : ((count($errors) > 0 && !old("password")) ? "forgot" : "login")) !!}',
        isOpen: {{ (count($errors) > 0 || session()->has('open_login') || session('status')) ? 'true' : 'false' }},
        intendedFav: '',
        intendedBuyId: '',
        intendedBuyQty: 1,
        
        setIntendedFav(id) {
            this.intendedFav = id;
        },

        setIntendedBuy(id, qty) {
            this.intendedBuyId = id;
            this.intendedBuyQty = qty || 1;
        },
        
        togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if(input && icon) {
                if(input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye-fill');
                    icon.classList.add('bi-eye-slash-fill');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash-fill');
                    icon.classList.add('bi-eye-fill');
                }
            }
        }
    }));
});

// Toast notification utility - Compact, beautiful, super-fast modern pill design
window.showAjaxToast = function(message, type = 'success') {
    const container = document.getElementById('ajax-toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    const isSuccess = type === 'success';
    const isError = type === 'error';

    toast.className = `toast-card-enter pointer-events-auto bg-white border border-slate-100 rounded-2xl shadow-[0_12px_32px_-4px_rgba(0,0,0,0.13),0_2px_6px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col cursor-pointer transition-all duration-150 active:scale-95 max-w-sm w-auto`;

    const iconBg = isSuccess ? 'bg-emerald-50 border-emerald-200 text-emerald-600' : (isError ? 'bg-rose-50 border-rose-200 text-rose-500' : 'bg-sky-50 border-sky-200 text-sky-600');
    const barColor = isSuccess ? 'bg-emerald-500' : (isError ? 'bg-rose-500' : 'bg-sky-500');

    const iconSvg = isSuccess 
        ? `<svg class="w-4 h-4 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>`
        : (isError ? `<svg class="w-4 h-4 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>` : `<svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`);

    toast.innerHTML = `
        <div class="px-4 py-2.5 flex items-center gap-3">
            <div class="w-7 h-7 rounded-full border-2 flex items-center justify-center flex-shrink-0 ${iconBg}">
                ${iconSvg}
            </div>
            <div class="text-[#1e293b] font-bold text-xs sm:text-[13px] leading-snug pr-2 select-none">
                ${message}
            </div>
        </div>
        <div class="h-[3px] w-full bg-slate-100 overflow-hidden">
            <div class="h-full ${barColor} toast-progress-bar"></div>
        </div>
    `;

    const closeToast = () => {
        if (toast.classList.contains('toast-card-leave')) return;
        toast.classList.remove('toast-card-enter');
        toast.classList.add('toast-card-leave');
        setTimeout(() => toast.remove(), 160);
    };

    toast.addEventListener('click', closeToast);
    container.appendChild(toast);

    setTimeout(closeToast, 2200);
};

// Update cart counter badges everywhere
window.updateCartBadgeCount = function(count) {
    document.querySelectorAll('.cart-count-badge').forEach(badge => {
        badge.textContent = count;
        if (count > 0) {
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
        badge.classList.remove('cart-badge-bounce');
        void badge.offsetWidth; // Trigger reflow
        badge.classList.add('cart-badge-bounce');
    });
};

// Ultra-fast In-Memory SPA Cache & Prefetcher
const spaCache = new Map();

// Prefetch URL on hover
window.spaPrefetch = async function(url) {
    if (!url || spaCache.has(url) || url.includes('/logout') || url.includes('#')) return;
    try {
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if (res.ok) {
            const html = await res.text();
            spaCache.set(url, { html, timestamp: Date.now() });
        }
    } catch (e) {}
};

let isSpaNavigating = false;

window.applyNewPage = function(html, url, push = true) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');

    const newMain = doc.querySelector('main');
    const currentMain = document.querySelector('main');

    if (newMain && currentMain) {
        if (doc.title) {
            document.title = doc.title;
        }

        // Update Header (user auth status, profile picture/button, login button)
        const newHeader = doc.querySelector('header');
        const currentHeader = document.querySelector('header');
        if (newHeader && currentHeader) {
            currentHeader.innerHTML = newHeader.innerHTML;
        }

        // Update Main Content
        currentMain.innerHTML = newMain.innerHTML;
        currentMain.className = newMain.className;
        if (newMain.getAttribute('style')) {
            currentMain.setAttribute('style', newMain.getAttribute('style'));
        }

        // Update Navbar active tab styles
        const newNav = doc.querySelector('nav');
        const currentNav = document.querySelector('nav');
        if (newNav && currentNav) {
            currentNav.innerHTML = newNav.innerHTML;
        }

        // Execute any new inline scripts
        doc.querySelectorAll('main script, body > script:not([src])').forEach(s => {
            if (s.textContent.includes('Alpine') || s.textContent.includes('cartLogic') || s.textContent.includes('function')) {
                try {
                    const newScript = document.createElement('script');
                    newScript.textContent = s.textContent;
                    document.body.appendChild(newScript);
                    setTimeout(() => newScript.remove(), 50);
                } catch (err) {}
            }
        });

        // Initialize Alpine components across document
        if (window.Alpine) {
            try {
                Alpine.initTree(document.body);
            } catch (e) {}
        }

        // Scroll top unless filtering categories
        if (!url.includes('categoria=') && !url.includes('view=')) {
            window.scrollTo({ top: 0, behavior: 'instant' });
        }

        if (push) {
            history.pushState({ spa: true, url }, '', url);
        }
    }
};

window.spaNavigate = async function(url, push = true) {
    if (isSpaNavigating) return;
    isSpaNavigating = true;

    // If cached and fresh (< 20s), render instantly!
    const cached = spaCache.get(url);
    if (cached && (Date.now() - cached.timestamp < 20000)) {
        window.applyNewPage(cached.html, url, push);
        isSpaNavigating = false;
        // Background revalidate
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.ok ? r.text() : null)
            .then(html => { if (html) spaCache.set(url, { html, timestamp: Date.now() }); });
        return;
    }

    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            window.location.href = url;
            return;
        }

        const html = await response.text();
        spaCache.set(url, { html, timestamp: Date.now() });
        window.applyNewPage(html, url, push);
    } catch (err) {
        window.location.href = url;
    } finally {
        isSpaNavigating = false;
    }
};

window.addEventListener('popstate', () => {
    window.spaNavigate(window.location.href, false);
});

// Global Interceptor for SPA links, Cart AJAX, and Favorite Toggle
document.addEventListener('DOMContentLoaded', () => {
    let clickedSubmitButton = null;

    // Prefetch links on hover for instant 0ms transitions
    document.addEventListener('mouseover', (e) => {
        const link = e.target.closest('a[href]');
        if (link && link.href && link.origin === window.location.origin) {
            window.spaPrefetch(link.href);
        }
    });

    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('button[type="submit"]');
        if (btn) {
            clickedSubmitButton = btn;
        }

        // Intercept favorite toggle buttons/links
        const favLink = e.target.closest('a[href*="/favorito/"]') && e.target.closest('a[href*="/toggle"]');
        if (favLink) {
            e.preventDefault();
            const heartSvg = favLink.querySelector('svg');
            
            // Optimistic UI toggle immediately
            let isNowFav = true;
            if (heartSvg) {
                heartSvg.style.transition = 'transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                heartSvg.style.transform = 'scale(1.4)';
                setTimeout(() => { heartSvg.style.transform = 'scale(1)'; }, 200);

                const currentlyFav = heartSvg.getAttribute('fill') === 'currentColor' || heartSvg.classList.contains('text-red-500');
                isNowFav = !currentlyFav;

                if (isNowFav) {
                    heartSvg.setAttribute('fill', 'currentColor');
                    heartSvg.classList.add('text-red-500');
                    heartSvg.classList.remove('text-gray-400');
                } else {
                    heartSvg.setAttribute('fill', 'none');
                    heartSvg.classList.remove('text-red-500');
                    heartSvg.classList.add('text-gray-400');
                }
            }

            window.showAjaxToast(isNowFav ? '¡Añadido a favoritos!' : 'Eliminado de favoritos', 'success');

            // Invalidate favorites cache so next visit has updated list
            spaCache.delete(window.location.origin + '/favoritos');

            try {
                const res = await fetch(favLink.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                if (res.ok) {
                    const data = await res.json();
                    if (heartSvg && typeof data.isFavorito !== 'undefined') {
                        if (data.isFavorito) {
                            heartSvg.setAttribute('fill', 'currentColor');
                            heartSvg.classList.add('text-red-500');
                            heartSvg.classList.remove('text-gray-400');
                        } else {
                            heartSvg.setAttribute('fill', 'none');
                            heartSvg.classList.remove('text-red-500');
                            heartSvg.classList.add('text-gray-400');
                            // If on favoritos page, smoothly remove the card
                            const favCard = favLink.closest('.bg-white.rounded-3xl') || favLink.closest('.relative.p-4');
                            if (window.location.pathname.includes('/favoritos') && favCard) {
                                favCard.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                                favCard.style.opacity = '0';
                                favCard.style.transform = 'scale(0.9)';
                                setTimeout(() => favCard.remove(), 260);
                            }
                        }
                    }
                }
            } catch (err) {
                console.error('Favorito sync error:', err);
            }
            return;
        }

        // Intercept internal client navigation links
        const link = e.target.closest('a[href]');
        if (link && link.href) {
            const isSameOrigin = link.origin === window.location.origin;
            const isDownload = link.hasAttribute('download');
            const isTargetBlank = link.target === '_blank';
            const isAnchorOnly = link.getAttribute('href').startsWith('#');
            const isLogout = link.href.includes('/logout') || link.closest('form');
            const isToggleFav = link.href.includes('/favorito/') && link.href.includes('/toggle');
            const isAdmin = link.pathname.startsWith('/admin') || link.pathname.startsWith('/categorias') || link.pathname.startsWith('/productos') || link.pathname.startsWith('/proveedores') || link.pathname.startsWith('/ventas') || link.pathname.startsWith('/pedidos') || link.pathname.startsWith('/inventarios') || link.pathname.startsWith('/movimientos') || link.pathname.startsWith('/envios') || link.pathname.startsWith('/devoluciones');

            if (isSameOrigin && !isDownload && !isTargetBlank && !isAnchorOnly && !isLogout && !isAdmin && !isToggleFav) {
                e.preventDefault();
                window.spaNavigate(link.href);
            }
        }
    }, true);

    document.addEventListener('submit', async (e) => {
        const form = e.target;
        if (!form || !form.action) return;

        // Intercept Login for ultra-fast instant login
        if (form.action.endsWith('/login') || form.action.includes('/login?')) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75');
            }

            // Clear previous errors
            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    spaCache.clear();
                    
                    if (data.csrf_token) {
                        document.querySelectorAll('input[name="_token"]').forEach(input => input.value = data.csrf_token);
                        const metaCsrf = document.querySelector('meta[name="csrf-token"]');
                        if (metaCsrf) metaCsrf.setAttribute('content', data.csrf_token);
                    }

                    // Close auth modal
                    const authModalEl = document.querySelector('[x-data*="authModals"]');
                    if (authModalEl && window.Alpine) {
                        try {
                            const modalData = Alpine.$data(authModalEl);
                            if (modalData) modalData.isOpen = false;
                        } catch (e) {}
                    }

                    if (data.role_id === 1) {
                        // Instant transition to dashboard and replace history so Back button doesn't go to welcome
                        window.location.replace(data.redirect || '/dashboard');
                    } else {
                        window.showAjaxToast(data.message || '¡Sesión iniciada con éxito!', 'success');
                        // Instant update of current view without full page reload
                        window.spaNavigate(window.location.href, false);
                    }
                } else {
                    const errorMsg = data.errors?.email?.[0] || data.errors?.password?.[0] || data.message || 'Credenciales inválidas';
                    window.showAjaxToast(errorMsg, 'error');

                    const emailInput = form.querySelector('input[name="email"]');
                    if (emailInput) {
                        emailInput.classList.add('is-invalid');
                        const errorSpan = document.createElement('span');
                        errorSpan.className = 'invalid-feedback';
                        errorSpan.textContent = errorMsg;
                        emailInput.closest('.input-icon-wrap')?.after(errorSpan);
                    }
                }
            } catch (err) {
                console.error('Error al iniciar sesión:', err);
                form.submit();
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75');
                }
            }
            return;
        }

        // Intercept Register for ultra-fast registration
        if (form.action.endsWith('/register') || form.action.includes('/register?')) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75');
            }

            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.showAjaxToast(data.message || '¡Cuenta creada! Por favor inicia sesión.', 'success');
                    // Switch to login tab in modal
                    const authModalEl = document.querySelector('[x-data*="authModals"]');
                    if (authModalEl && window.Alpine) {
                        try {
                            const modalData = Alpine.$data(authModalEl);
                            if (modalData) {
                                modalData.mode = 'login';
                                modalData.isOpen = true;
                            }
                        } catch (e) {}
                    }
                } else {
                    const errorFields = data.errors || {};
                    let firstMsg = data.message || 'Error al crear la cuenta';
                    for (const [field, messages] of Object.entries(errorFields)) {
                        firstMsg = messages[0];
                        const input = form.querySelector(`input[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const errorSpan = document.createElement('span');
                            errorSpan.className = 'invalid-feedback';
                            errorSpan.textContent = messages[0];
                            input.closest('.input-icon-wrap')?.after(errorSpan);
                        }
                    }
                    window.showAjaxToast(firstMsg, 'error');
                }
            } catch (err) {
                form.submit();
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75');
                }
            }
            return;
        }

        // Intercept logout for seamless instant logout without reload
        if (form.action.includes('/logout')) {
            e.preventDefault();
            spaCache.clear();

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.csrf_token) {
                    document.querySelectorAll('input[name="_token"]').forEach(input => input.value = data.csrf_token);
                    const metaCsrf = document.querySelector('meta[name="csrf-token"]');
                    if (metaCsrf) metaCsrf.setAttribute('content', data.csrf_token);
                }

                window.showAjaxToast('Has cerrado sesión exitosamente.', 'success');
                window.spaNavigate(data.redirect || '/', true);
            } catch (err) {
                form.submit();
            }
            return;
        }

        // Check if the form is updating cart quantity or deleting item
        if (form.action.includes('/carrito/actualizar') || form.action.includes('/carrito/eliminar')) {
            e.preventDefault();
            const submitter = e.submitter || clickedSubmitButton;

            const button = submitter || form.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                button.classList.add('opacity-50');
            }

            try {
                const formData = new FormData(form);
                if (submitter && submitter.name && typeof submitter.value !== 'undefined') {
                    formData.set(submitter.name, submitter.value);
                }

                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.updateCartBadgeCount(data.cartCount);
                    spaCache.delete(window.location.origin + '/carrito');

                    const pid = data.producto_id;

                    // If on /carrito page, update row elements without page reload!
                    if (data.eliminado) {
                        const itemRow = document.getElementById('cart-item-' + pid);
                        if (itemRow) {
                            itemRow.style.transition = 'all 0.3s ease';
                            itemRow.style.opacity = '0';
                            itemRow.style.transform = 'scale(0.95) translateY(-10px)';
                            setTimeout(() => {
                                itemRow.remove();
                                if (data.cartCount === 0) {
                                    // If empty, navigate to update view
                                    window.spaNavigate(window.location.href, false);
                                }
                            }, 300);
                        }
                        
                        // Update Alpine data if present
                        const alpineContainer = document.querySelector('[x-data*="cartLogic"]');
                        if (alpineContainer && window.Alpine) {
                            try {
                                const alpineData = Alpine.$data(alpineContainer);
                                if (alpineData && alpineData.items) {
                                    delete alpineData.items[pid];
                                    alpineData.selected = alpineData.selected.filter(id => id !== pid);
                                }
                            } catch (e) {}
                        }

                        // Update count text
                        const countEl = document.getElementById('cart-item-count');
                        if (countEl) countEl.textContent = `${data.cartCount} producto(s)`;
                    } else {
                        // Update quantity input
                        const qtyInput = document.getElementById('cart-qty-' + pid);
                        if (qtyInput) qtyInput.value = data.cantidad;

                        // Update minus button value
                        const minusBtn = document.getElementById('cart-minus-' + pid);
                        if (minusBtn) minusBtn.value = data.cantidad - 1;

                        // Update plus button value and disabled state
                        const plusBtn = document.getElementById('cart-plus-' + pid);
                        if (plusBtn) {
                            plusBtn.value = data.cantidad + 1;
                            if (data.cantidad >= data.stock_disponible) {
                                plusBtn.disabled = true;
                                plusBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            } else {
                                plusBtn.disabled = false;
                                plusBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            }
                        }

                        // Update subtotal text
                        const subtotalEl = document.getElementById('cart-subtotal-' + pid);
                        if (subtotalEl && data.subtotal_formateado) {
                            subtotalEl.textContent = data.subtotal_formateado;
                        }

                        // Update Alpine data if present
                        const alpineContainer = document.querySelector('[x-data*="cartLogic"]');
                        if (alpineContainer && window.Alpine) {
                            try {
                                const alpineData = Alpine.$data(alpineContainer);
                                if (alpineData && alpineData.items) {
                                    alpineData.items[pid] = data.subtotal;
                                }
                            } catch (e) {}
                        }
                    }
                } else {
                    window.showAjaxToast(data.message || 'No se pudo actualizar el carrito', 'error');
                }
            } catch (err) {
                console.error('Error al actualizar carrito:', err);
                window.showAjaxToast('Ocurrió un error al actualizar el carrito', 'error');
            } finally {
                if (button) {
                    button.disabled = false;
                    button.classList.remove('opacity-50');
                }
            }
            return;
        }

        // Check if the form is targeting cart addition
        if (form.action.includes('/carrito/agregar')) {
            const submitter = e.submitter || clickedSubmitButton;
            const isBuyAction = submitter && (submitter.name === 'accion' && submitter.value === 'comprar');

            if (isBuyAction) return;

            e.preventDefault();

            const button = submitter || form.querySelector('button[type="submit"]');

            if (button) {
                button.disabled = true;
                button.classList.add('opacity-75', 'scale-95');
            }

            try {
                const formData = new FormData(form);
                if (!formData.has('accion')) {
                    formData.append('accion', 'carrito');
                }

                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.updateCartBadgeCount(data.cartCount);
                    window.showAjaxToast(data.message || '¡Producto añadido al carrito!', 'success');
                    spaCache.delete(window.location.origin + '/carrito');
                } else {
                    window.showAjaxToast(data.message || 'No se pudo agregar el producto', 'error');
                }
            } catch (err) {
                console.error('Error al agregar al carrito:', err);
                window.showAjaxToast('Ocurrió un error al actualizar el carrito', 'error');
            } finally {
                if (button) {
                    button.disabled = false;
                    button.classList.remove('opacity-75', 'scale-95');
                }
            }
        }
    });
});
</script>
