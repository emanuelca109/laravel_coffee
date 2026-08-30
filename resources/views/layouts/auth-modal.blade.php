<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Coffee Dat')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.4)), url('{{ asset('img/fon.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        /* ===========================
                MODAL LOGIN ELEGANTE + SÚPER ANIMACIONES
        ============================ */
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

        .modal-login .modal-form {
            width: 55%;
            background: #ffffff;
            padding: 50px;
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
            width: 40px;
            height: 40px;
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
            margin-bottom: 0.5rem;
            color: #334155;
            font-size: 0.9rem;
        }

        .stagger-1 { animation: fadeUp 0.5s ease-out forwards 0.3s; opacity: 0; }
        .stagger-2 { animation: fadeUp 0.5s ease-out forwards 0.4s; opacity: 0; }
        .stagger-3 { animation: fadeUp 0.5s ease-out forwards 0.5s; opacity: 0; }
        .stagger-4 { animation: fadeUp 0.5s ease-out forwards 0.6s; opacity: 0; }
        .stagger-5 { animation: fadeUp 0.5s ease-out forwards 0.7s; opacity: 0; }

        .input-icon-wrap {
            position: relative;
            transition: transform 0.3s ease;
        }

        .input-icon-wrap:focus-within {
            transform: translateY(-2px);
        }

        .input-icon-wrap > i {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            pointer-events: none;
            transition: color 0.3s, transform 0.3s;
        }

        .form-control {
            width: 100%;
            height: 54px;
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            padding-left: 54px;
            background: #f8fafc;
            outline: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            color: #334155;
        }

        .form-control::placeholder {
            color: #cbd5e1;
        }

        .form-control:focus {
            border-color: #16a34a;
            background: #ffffff;
            animation: inputPulse 1.5s infinite;
        }

        @keyframes inputPulse {
            0% { box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(22, 163, 74, 0); }
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
            font-size: 0.8rem;
            margin-top: 0.4rem;
            display: block;
        }

        .toggle-eye {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            padding: 0;
            line-height: 1;
            cursor: pointer;
            z-index: 5;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .toggle-eye:hover {
            color: #334155;
            transform: translateY(-50%) scale(1.1);
        }

        .btn-login {
            width: 100%;
            height: 54px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(270deg, #16a34a, #15803d, #22c55e, #16a34a);
            background-size: 300% 300%;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            margin-top: 15px;
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3);
            animation: gradientFlow 4s ease infinite;
        }

        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .btn-login:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 25px rgba(22, 163, 74, 0.4);
        }
        
        .btn-login i {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .btn-login:hover i.bi-arrow-right {
            transform: translateX(6px) scale(1.1);
        }

        .btn-login:active {
            transform: translateY(0) scale(0.98);
            box-shadow: 0 4px 10px rgba(22, 163, 74, 0.3);
        }

        .links {
            text-align: center;
            margin-top: 25px;
            font-size: 0.95rem;
            color: #64748b;
        }

        .links a {
            color: #16a34a;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 5px;
            display: inline-block;
        }

        .links a:hover {
            color: #15803d;
            transform: scale(1.05);
        }

        .forgot {
            color: #16a34a;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .forgot:hover {
            color: #15803d;
            text-decoration: underline;
        }

        .auth-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.2rem;
            text-align: center;
        }
        
        .auth-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        @media(max-width: 767px) {
            .modal-login .modal-content {
                flex-direction: column;
                border-radius: 20px;
            }

            .modal-login .modal-image {
                width: 100%;
                height: 180px;
            }

            .modal-login .modal-form {
                width: 100%;
                padding: 35px 25px;
            }
            
            .modal-login .btn-close-custom {
                top: 10px;
                right: 10px;
                background: rgba(255,255,255,0.9);
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="modal fade show modal-login"
        id="loginModal"
        tabindex="-1"
        style="display: block;"
        aria-modal="true"
        role="dialog">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content position-relative">

                <a href="{{ url('/') }}" class="btn-close-custom" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>

                <div class="modal-image d-none d-md-block">
                    <div class="logo">
                        <img src="{{ asset('img/logo-full.svg') }}" alt="Coffee Dat">
                        <p>Las mejores herramientas e insumos para la caficultura.</p>
                    </div>
                </div>

                <div class="modal-form">
                    @if (session('status'))
                        <div class="alert-status bg-success bg-opacity-10 text-success border border-success rounded-3 p-3 mb-4 d-flex align-items-center gap-2 font-weight-bold stagger-1" style="font-size: 0.85rem;">
                            <i class="bi bi-check-circle-fill"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    @yield('content')
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
