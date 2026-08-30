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
        background-image: url('{{ asset('img/fon.png') }}');
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
        background-image: url('{{ asset('img/fon.png') }}');
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
</script>
