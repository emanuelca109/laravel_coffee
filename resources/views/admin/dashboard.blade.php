<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control | Coffee.dat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Ajustar ancho del sidebar a 16rem (256px) */
        aside.fixed.left-0 {
            width: 16rem !important;
        }
        /* Ampliar el logo del sidebar */
        aside.fixed.left-0 img {
            height: 3rem !important;
            max-height: none !important;
        }
        /* Alinear header con el nuevo sidebar */
        header.fixed {
            left: 16rem !important;
        }
        /* Alinear contenedor principal con el nuevo sidebar */
        .left-64 {
            left: 16rem !important;
        }
    </style>
</head>

<body class="bg-gray-50 h-screen overflow-hidden">
    {{-- Sidebar fijo --}}
    @include('layouts.sidebaradmin')

    {{-- Header fijo --}}
    @include('layouts.headeradmin')

    {{-- Contenedor principal (al lado del sidebar, debajo del header) --}}
    <div class="fixed top-16 right-0 bottom-0 left-64 flex flex-col overflow-y-auto">
        <main class="p-6 space-y-8 min-w-0 flex-1">
            {{-- Bienvenida --}}
            <div class="relative bg-gradient-to-r from-green-800 to-green-600 rounded-3xl shadow-xl p-8 text-white overflow-hidden">
                <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full"></div>
                <div class="absolute bottom-0 right-24 w-24 h-24 bg-white/10 rounded-full"></div>

                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-2">
                        Bienvenido, {{ Auth::user()->name ?? 'Emanuel' }}
                    </h2>

                    <p class="text-green-100 text-lg max-w-2xl">
                        Gestiona tu tienda con precisión. Aquí tienes un vistazo rápido al
                        rendimiento actual de <span class="font-bold text-white">Coffee Dat</span>.
                    </p>
                </div>
            </div>

            {{-- Tarjetas --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Tarjeta 1: Usuarios --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:-translate-y-1.5 hover:shadow-md transition-all duration-300 flex flex-col justify-between h-56">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-inner">
                            <i class="fa-solid fa-users text-2xl"></i>
                        </div>
                        <span class="px-3.5 py-1 text-xs font-semibold text-blue-600 bg-blue-50/70 border border-blue-100 rounded-full tracking-wide">
                            Comunidad
                        </span>
                    </div>
                    <div class="mt-auto">
                        <h3 class="text-gray-400 uppercase text-xs font-bold tracking-widest">
                            Usuarios Registrados
                        </h3>
                        <p class="text-5xl font-extrabold text-slate-800 mt-2 tracking-tight">
                            {{ $usuarios ?? 0 }}
                        </p>
                    </div>
                </div>

                {{-- Tarjeta 2: Ingresos --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:-translate-y-1.5 hover:shadow-md transition-all duration-300 flex flex-col justify-between h-56">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner">
                            <i class="fa-solid fa-wallet text-2xl"></i>
                        </div>
                        <span class="px-3.5 py-1 text-xs font-semibold text-emerald-600 bg-emerald-50/70 border border-emerald-100 rounded-full tracking-wide">
                            Finanzas
                        </span>
                    </div>
                    <div class="mt-auto">
                        <h3 class="text-gray-400 uppercase text-xs font-bold tracking-widest">
                            Ingresos Totales
                        </h3>
                        <p class="text-5xl font-extrabold text-emerald-600 mt-2 tracking-tight">
                            ${{ number_format($ingresos ?? 0,0,',','.') }}
                        </p>
                    </div>
                </div>

                {{-- Tarjeta 3: Stock --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:-translate-y-1.5 hover:shadow-md transition-all duration-300 flex flex-col justify-between h-56">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 shadow-inner">
                            <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                        </div>
                        <span class="px-3.5 py-1 text-xs font-semibold text-rose-600 bg-rose-50/70 border border-rose-100 rounded-full tracking-wide">
                            Inventario
                        </span>
                    </div>
                    <div class="mt-auto">
                        <h3 class="text-gray-400 uppercase text-xs font-bold tracking-widest">
                            Alertas de Stock
                        </h3>
                        <p class="text-5xl font-extrabold text-rose-600 mt-2 tracking-tight">
                            {{ $stockBajo ?? 0 }}
                        </p>
                    </div>
                </div>

                {{-- Tarjeta 4: Productos --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:-translate-y-1.5 hover:shadow-md transition-all duration-300 flex flex-col justify-between h-56">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-inner">
                            <i class="fa-solid fa-boxes-stacked text-2xl"></i>
                        </div>
                        <span class="px-3.5 py-1 text-xs font-semibold text-amber-600 bg-amber-50/70 border border-amber-100 rounded-full tracking-wide">
                            Productos
                        </span>
                    </div>
                    <div class="mt-auto">
                        <h3 class="text-gray-400 uppercase text-xs font-bold tracking-widest">
                            Catálogo Activo
                        </h3>
                        <p class="text-5xl font-extrabold text-slate-800 mt-2 tracking-tight">
                            {{ $productos ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>
        </main>

        {{-- Footer al final del scroll, al lado del sidebar --}}
        @include('layouts.footer')
    </div>

</body>
</html>
