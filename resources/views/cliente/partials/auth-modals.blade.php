<style>
    /* ===========================
            ESTILOS DEL MODAL (LOGIN & REGISTER)
    ============================ */
    .auth-modal-container {
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 26px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25), inset 0 1px 1px rgba(255, 255, 255, 0.2);
    }
    .auth-form-label {
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 5px;
        display: block;
    }
    .auth-input-wrap {
        position: relative;
    }
    .auth-input-wrap > i {
        position: absolute;
        top: 50%;
        left: 14px;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 0.85rem;
        pointer-events: none;
    }
    .auth-form-control {
        width: 100%;
        height: 44px;
        border: none;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.85);
        padding-left: 38px;
        font-size: 0.87rem;
        transition: 0.3s;
        outline: none;
    }
    .auth-form-control:focus {
        background: white;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.25);
    }
    .auth-form-control.is-invalid {
        border: 1px solid #dc3545;
        background: white;
    }
    .auth-invalid-feedback {
        color: #fff3f3;
        font-weight: 500;
        font-size: 0.76rem;
        margin-top: 4px;
        display: block;
    }
    .auth-toggle-eye {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        padding: 0;
        line-height: 1;
        cursor: pointer;
        font-size: 0.85rem;
        z-index: 5;
    }
    .auth-toggle-eye:hover {
        color: #343a40;
    }
    .auth-btn-submit {
        width: 100%;
        height: 46px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, #198754, #146c43);
        color: white;
        font-size: 0.92rem;
        font-weight: 700;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 8px 20px rgba(20, 108, 67, 0.35);
        transition: 0.25s;
        cursor: pointer;
    }
    .auth-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(20, 108, 67, 0.5);
    }
    .auth-links {
        text-align: center;
        margin-top: 16px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.85rem;
    }
    .auth-links a {
        color: white;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
    }
    .auth-links a:hover {
        color: #d4edda;
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
     class="fixed inset-0 z-[2000] flex items-center justify-center bg-black/60 backdrop-blur-md p-4 overflow-y-auto"
     x-transition.opacity.duration.400ms>

    <div class="auth-modal-container w-full max-w-[440px] relative transition-all duration-300">
         
         <button type="button" @click="isOpen = false" class="absolute top-4 right-4 text-white hover:text-red-400 transition bg-black/20 rounded-full w-8 h-8 flex items-center justify-center z-[60]">
             <i class="bi bi-x-lg"></i>
         </button>

         {{-- LOGIN FORM --}}
         <div x-show="mode === 'login'" 
              style="display: none;"
              class="w-full p-[30px] sm:p-[40px]"
              x-transition:enter="transition-all duration-400 ease-out" 
              x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
              x-transition:enter-end="opacity-100 scale-100 translate-y-0">
              
             <div class="text-center mb-6">
                <img src="{{ asset('img/logo-full.svg') }}" alt="Coffee Dat" class="w-[280px] max-w-full h-auto mx-auto">
             </div>

             @if (session('status'))
                <div class="bg-white/85 border border-green-700 text-green-800 rounded-xl px-4 py-2 text-sm font-bold mb-4">
                    {{ session('status') }}
                </div>
             @endif

             <form method="POST" action="{{ route('login') }}">
                 @csrf
                 <input type="hidden" name="intended_favorite_product" :value="intendedFav">
                 <input type="hidden" name="intended_buy_product" :value="intendedBuyId">
                 <input type="hidden" name="intended_buy_quantity" :value="intendedBuyQty">

                 <div class="mb-4">
                     <label class="auth-form-label">Correo Electrónico</label>
                     <div class="auth-input-wrap">
                         <i class="bi bi-envelope-fill"></i>
                         <input type="email" name="email" value="{{ old('email') }}"
                                class="auth-form-control @if($errors->has('email') && !old('name')) is-invalid @endif"
                                placeholder="Ingrese su correo" required autofocus>
                     </div>
                     @if($errors->has('email') && !old('name'))
                         <span class="auth-invalid-feedback">{{ $errors->first('email') }}</span>
                     @endif
                 </div>

                 <div class="mb-4">
                     <label class="auth-form-label">Contraseña</label>
                     <div class="auth-input-wrap">
                         <i class="bi bi-lock-fill"></i>
                         <input id="login_password" type="password" name="password"
                                class="auth-form-control @if($errors->has('password') && !old('name')) is-invalid @endif"
                                placeholder="Ingrese su contraseña" required style="padding-right: 38px;">
                         <button type="button" class="auth-toggle-eye" @click="togglePass('login_password', 'login_eye')">
                             <i class="bi bi-eye-fill" id="login_eye"></i>
                         </button>
                     </div>
                     @if($errors->has('password') && !old('name'))
                         <span class="auth-invalid-feedback">{{ $errors->first('password') }}</span>
                     @endif
                 </div>

                 <div class="flex justify-between items-center mb-6 text-sm">
                     <label class="flex items-center text-white cursor-pointer gap-2">
                         <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                         <span>Recordarme</span>
                     </label>
                     @if (Route::has('password.request'))
                         <a href="{{ route('password.request') }}" class="text-white hover:text-green-200 font-medium transition">¿Olvidaste tu contraseña?</a>
                     @endif
                 </div>

                 <button type="submit" class="auth-btn-submit">
                     <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                 </button>

                 @if (Route::has('register'))
                     <div class="auth-links">
                         ¿No tienes cuenta?
                         <a @click.prevent="mode = 'register'">Regístrate</a>
                     </div>
                 @endif
             </form>
         </div>

         {{-- REGISTER FORM --}}
         <div x-show="mode === 'register'" 
              style="display: none;"
              class="w-full p-[30px] sm:p-[40px]"
              x-transition:enter="transition-all duration-400 ease-out" 
              x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
              x-transition:enter-end="opacity-100 scale-100 translate-y-0">
              
             <div class="text-center mb-2">
                <img src="{{ asset('img/logo-full.svg') }}" alt="Coffee Dat" class="w-[240px] max-w-full h-auto mx-auto">
             </div>
             <p class="text-center text-white/85 text-sm font-medium mb-5">Crea tu cuenta y empieza a comprar</p>

             <form method="POST" action="{{ route('register') }}">
                 @csrf
                 <input type="hidden" name="intended_favorite_product" :value="intendedFav">
                 <input type="hidden" name="intended_buy_product" :value="intendedBuyId">
                 <input type="hidden" name="intended_buy_quantity" :value="intendedBuyQty">

                 <div class="mb-3">
                     <label class="auth-form-label">Nombre</label>
                     <div class="auth-input-wrap">
                         <i class="bi bi-person-fill"></i>
                         <input type="text" name="name" value="{{ old('name') }}"
                                class="auth-form-control @error('name') is-invalid @enderror"
                                placeholder="Ingrese su nombre" required>
                     </div>
                     @error('name')
                         <span class="auth-invalid-feedback">{{ $message }}</span>
                     @enderror
                 </div>

                 <div class="mb-3">
                     <label class="auth-form-label">Correo Electrónico</label>
                     <div class="auth-input-wrap">
                         <i class="bi bi-envelope-fill"></i>
                         <input type="email" name="email" value="{{ old('email') }}"
                                class="auth-form-control @if($errors->has('email') && old('name')) is-invalid @endif"
                                placeholder="Ingrese su correo" required>
                     </div>
                     @if($errors->has('email') && old('name'))
                         <span class="auth-invalid-feedback">{{ $errors->first('email') }}</span>
                     @endif
                 </div>

                 <div class="mb-3">
                     <label class="auth-form-label">Contraseña</label>
                     <div class="auth-input-wrap">
                         <i class="bi bi-lock-fill"></i>
                         <input id="register_password" type="password" name="password"
                                class="auth-form-control @error('password') is-invalid @enderror"
                                placeholder="Ingrese su contraseña" required style="padding-right: 38px;">
                         <button type="button" class="auth-toggle-eye" @click="togglePass('register_password', 'register_eye')">
                             <i class="bi bi-eye-fill" id="register_eye"></i>
                         </button>
                     </div>
                     @error('password')
                         <span class="auth-invalid-feedback">{{ $message }}</span>
                     @enderror
                 </div>

                 <div class="mb-4">
                     <label class="auth-form-label">Confirmar Contraseña</label>
                     <div class="auth-input-wrap">
                         <i class="bi bi-lock-fill"></i>
                         <input id="register_password_confirmation" type="password" name="password_confirmation"
                                class="auth-form-control"
                                placeholder="Confirme su contraseña" required style="padding-right: 38px;">
                         <button type="button" class="auth-toggle-eye" @click="togglePass('register_password_confirmation', 'register_eye_confirm')">
                             <i class="bi bi-eye-fill" id="register_eye_confirm"></i>
                         </button>
                     </div>
                 </div>

                 <button type="submit" class="auth-btn-submit">
                     <i class="bi bi-person-plus-fill"></i> Registrarse
                 </button>

                 <div class="auth-links">
                     ¿Ya tienes una cuenta?
                     <a @click.prevent="mode = 'login'">Inicia sesión</a>
                 </div>
             </form>
         </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('authModals', () => ({
        mode: '{!! (count($errors) > 0 && old("name")) ? "register" : "login" !!}',
        isOpen: {{ (count($errors) > 0 || session()->has('open_login')) ? 'true' : 'false' }},
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
