<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro | Coffee Dat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;

            background-image:
                linear-gradient(
                    rgba(0,0,0,.20),
                    rgba(0,0,0,.20)
                ),
                url('{{ asset('img/fon.png') }}');

            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
        }

        .register-container{

            width:440px;

            background:rgba(255,255,255,.18);

            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);

            border:1px solid rgba(255,255,255,.25);

            border-radius:26px;

            padding:26px 28px;

            box-shadow:
                0 8px 32px rgba(0,0,0,.25),
                inset 0 1px 1px rgba(255,255,255,.2);
        }

        .logo-container{
            text-align:center;
            margin-bottom:6px;
        }

        .logo{
            width:280px;
            max-width:100%;
            height:auto;
        }

        .subtitle{
            text-align:center;
            color:rgba(255,255,255,.85);
            font-size:.82rem;
            font-weight:500;
            margin-bottom:20px;
        }

        .form-label{
            color:white;
            font-weight:600;
            font-size:.85rem;
            margin-bottom:5px;
        }

        /* ===========================
                INPUTS CON ICONO
        ============================ */
        .input-icon-wrap{
            position:relative;
        }

        .input-icon-wrap > i{
            position:absolute;
            top:50%;
            left:14px;
            transform:translateY(-50%);
            color:#6c757d;
            font-size:.85rem;
            pointer-events:none;
        }

        .form-control{
            height:44px;

            border:none;
            border-radius:14px;

            background:rgba(255,255,255,.85);

            padding-left:38px;
            font-size:.87rem;

            transition:.3s;
        }

        .form-control:focus{
            background:white;
            box-shadow:0 0 0 3px rgba(25,135,84,.25);
        }

        .form-control.is-invalid{
            border:1px solid #dc3545;
            background:white;
        }

        .invalid-feedback{
            color:#fff3f3;
            font-weight:500;
            font-size:.76rem;
        }

        .toggle-eye{
            position:absolute;
            top:50%;
            right:14px;
            transform:translateY(-50%);
            background:none;
            border:none;
            color:#6c757d;
            padding:0;
            line-height:1;
            cursor:pointer;
            font-size:.85rem;
            z-index:5;
        }

        .toggle-eye:hover{
            color:#343a40;
        }

        .btn-register{

            width:100%;
            height:46px;

            border:none;
            border-radius:14px;

            background:linear-gradient(
                135deg,
                #198754,
                #146c43
            );

            color:white;
            font-size:.92rem;
            font-weight:700;

            margin-top:6px;

            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;

            box-shadow:0 8px 20px rgba(20,108,67,.35);

            transition:.25s;
        }

        .btn-register:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 24px rgba(20,108,67,.5);
        }

        .btn-register:active{
            transform:translateY(0);
        }

        .links{
            text-align:center;
            margin-top:16px;
            color:rgba(255,255,255,.8);
            font-size:.85rem;
        }

        .links a{
            color:white;
            font-weight:bold;
            text-decoration:none;
        }

        .links a:hover{
            color:#d4edda;
        }

        @media(max-width:576px){

            .register-container{
                width:92%;
                padding:24px 22px;
            }

            .logo{
                width:220px;
            }
        }

    </style>

</head>
<body>

    <div class="register-container">

        <div class="logo-container">
            <img
                src="{{ asset('img/logo-full.svg') }}"
                alt="Coffee Dat"
                class="logo"
            >
        </div>

        <p class="subtitle">Crea tu cuenta y empieza a comprar</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nombre --}}
            <div class="mb-3">
                <label class="form-label">Nombre</label>

                <div class="input-icon-wrap">
                    <i class="bi bi-person-fill"></i>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Ingrese su nombre"
                        required
                        autofocus
                        autocomplete="name"
                    >
                </div>

                @error('name')
                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Correo --}}
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>

                <div class="input-icon-wrap">
                    <i class="bi bi-envelope-fill"></i>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Ingrese su correo"
                        required
                        autocomplete="username"
                    >
                </div>

                @error('email')
                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div class="mb-3">
                <label class="form-label">Contraseña</label>

                <div class="input-icon-wrap">
                    <i class="bi bi-lock-fill"></i>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Ingrese su contraseña"
                        required
                        autocomplete="new-password"
                        style="padding-right: 38px;"
                    >
                    <button type="button" class="toggle-eye" id="togglePassword">
                        <i class="bi bi-eye-fill" id="eyeIcon"></i>
                    </button>
                </div>

                @error('password')
                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div class="mb-3">
                <label class="form-label">Confirmar Contraseña</label>

                <div class="input-icon-wrap">
                    <i class="bi bi-lock-fill"></i>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirme su contraseña"
                        required
                        autocomplete="new-password"
                        style="padding-right: 38px;"
                    >
                    <button type="button" class="toggle-eye" id="toggleConfirmPassword">
                        <i class="bi bi-eye-fill" id="eyeIconConfirm"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus-fill"></i>
                Registrarse
            </button>

            <div class="links">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}">
                    Inicia sesión
                </a>
            </div>

        </form>

    </div>

    {{-- Mostrar / ocultar contraseñas --}}
    <script>
        function setupToggle(buttonId, inputId, iconId) {
            const button = document.getElementById(buttonId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            button.addEventListener('click', function () {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('bi-eye-fill');
                icon.classList.toggle('bi-eye-slash-fill');
            });
        }

        setupToggle('togglePassword', 'password', 'eyeIcon');
        setupToggle('toggleConfirmPassword', 'password_confirmation', 'eyeIconConfirm');
    </script>

</body>
</html>