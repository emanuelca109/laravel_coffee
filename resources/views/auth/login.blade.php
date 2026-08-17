<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Coffee Dat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            background-image:
                linear-gradient(
                    rgba(0,0,0,.15),
                    rgba(0,0,0,.15)
                ),
                url('{{ asset('img/fon.png') }}');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .login-container{
            width: 420px;

            background: rgba(255,255,255,0.20);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);

            border: 1px solid rgba(255,255,255,.3);
            border-radius: 25px;

            padding: 40px;

            box-shadow: 0 8px 32px rgba(0,0,0,.3);
        }

        .logo-container{
            text-align: center;
            margin-bottom: 35px;
        }

        .logo{
            width: 390px;
            max-width: 100%;
            height: auto;
        }

        .form-label{
            color: white;
            font-weight: 600;
        }

        /* ===========================
                INPUTS CON ICONO
        ============================ */
        .input-icon-wrap{
            position: relative;
        }

        .input-icon-wrap > i{
            position: absolute;
            top: 50%;
            left: 18px;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: .95rem;
            pointer-events: none;
        }

        .form-control{
            height: 50px;
            border-radius: 50px;
            border: none;
            padding-left: 46px;

            background: rgba(255,255,255,.85);
        }

        .form-control:focus{
            box-shadow: none;
            background: white;
        }

        .form-control.is-invalid{
            border: 1px solid #dc3545;
            background: white;
        }

        .invalid-feedback{
            color: #fff3f3;
            font-weight: 500;
        }

        .toggle-eye{
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            padding: 0;
            line-height: 1;
            cursor: pointer;
            z-index: 5;
        }

        .toggle-eye:hover{
            color: #343a40;
        }

        .form-check-label{
            color: white;
        }

        .btn-login{
            width: 100%;
            height: 50px;

            border: none;
            border-radius: 50px;

            background: #198754;
            color: white;

            font-weight: bold;
            transition: .3s;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover{
            background: #146c43;
        }

        .links{
            text-align: center;
            margin-top: 20px;
            color: white;
        }

        .links a{
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        .links a:hover{
            color: #d4edda;
        }

        .forgot{
            color: white;
            text-decoration: none;
        }

        .forgot:hover{
            color: #d4edda;
        }

        .alert-status{
            background: rgba(255,255,255,.85);
            border: 1px solid #198754;
            color: #146c43;
            border-radius: 12px;
            padding: 10px 15px;
            font-size: .9rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        @media(max-width: 500px){

            .login-container{
                width: 90%;
                padding: 30px;
            }

            .titulo{
                font-size: 2rem;
            }
        }
    </style>

</head>
<body>

    <div class="login-container">

        <div class="logo-container">
            <img src="{{ asset('img/logo-full.svg') }}"
                alt="Coffee Dat"
                class="logo">
        </div>

        {{-- Mensaje de estado (ej. recuperación de contraseña) --}}
        @if (session('status'))
            <div class="alert-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
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
                        placeholder="Ingrese su correo"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>

                @error('email')
                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
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
                        placeholder="Ingrese su contraseña"
                        required
                        autocomplete="current-password"
                        style="padding-right: 46px;"
                    >
                    <button type="button" class="toggle-eye" id="togglePassword">
                        <i class="bi bi-eye-fill" id="eyeIcon"></i>
                    </button>
                </div>

                @error('password')
                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mb-4">

                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember_me"
                    >

                    <label class="form-check-label" for="remember_me">
                        Recordarme
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Iniciar Sesión
            </button>

            @if (Route::has('register'))
                <div class="links">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}">
                        Regístrate
                    </a>
                </div>
            @endif

        </form>

    </div>

    {{-- Mostrar / ocultar contraseña --}}
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('bi-eye-fill');
            eyeIcon.classList.toggle('bi-eye-slash-fill');
        });
    </script>

</body>
</html>