<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mi Cuenta | Coffee.Dat</title>

    {{-- Tailwind CSS (CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">

    {{-- ==========================================
            HEADER (fijo arriba)
    =========================================== --}}
    <header class="fixed top-0 left-0 w-full z-[1000] h-40 flex flex-col items-center justify-center gap-3 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('img/ca.png') }}');">

        {{-- Overlay oscuro --}}
        <div class="absolute inset-0 bg-black/35"></div>

        {{-- Zona de Usuario --}}
        <div class="absolute z-30 top-5 right-8">
            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full text-white font-medium transition shadow-lg">
                        <span class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center font-bold shadow-inner">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                        <span class="hidden md:inline">{{ explode(' ', auth()->user()->name)[0] }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div x-show="open" style="display: none;"
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 scale-95" 
                         x-transition:enter-end="opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="opacity-100 scale-100" 
                         x-transition:leave-end="opacity-0 scale-95" 
                         class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden text-sm z-50">
                        <a href="{{ route('cuenta') }}" class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium transition">
                            Mi Cuenta
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 font-medium transition border-t border-gray-50">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <button type="button" x-data @click="$dispatch('open-login')"
                   class="w-[54px] h-[54px] rounded-full bg-green-700 hover:bg-green-800 flex items-center justify-center transition shadow-lg relative focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[26px] h-[26px] text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.4c-3.3 0-9.8 1.6-9.8 4.9v1.6h19.6v-1.6c0-3.3-6.5-4.9-9.8-4.9z"/>
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 w-[15px] h-[15px] rounded-full bg-yellow-400 border-2 border-white"></span></button>
            @endauth
        </div>

        {{-- Logo --}}
        <img src="{{ asset('img/logo-full.svg') }}" alt="Coffee Dat" class="relative z-20 h-14 mx-auto">

        {{-- Buscador --}}
        <div class="relative z-20 w-full flex justify-center px-6">
            <form action="{{ Route::has('productos.buscar') ? route('productos.buscar') : '#' }}" method="GET" class="relative w-full max-w-[700px]">
                <input
                    type="text"
                    name="q"
                    placeholder="Buscar en Coffee Dat..."
                    class="w-full rounded-full py-3 pl-5 pr-14 text-sm text-gray-700 placeholder-gray-400 shadow-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black hover:bg-gray-800 flex items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </button>
            </form>
        </div>

    </header>

    {{-- ==========================================
            NAVBAR (fijo justo debajo del header)
    =========================================== --}}
    @include('cliente.partials.navbar')

    {{-- ==========================================
            CONTENIDO PRINCIPAL
    =========================================== --}}
    <main class="min-h-screen bg-gray-50" style="padding-top:240px; padding-bottom:40px;">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row gap-6">

            {{-- BARRA LATERAL --}}
            <aside class="w-full md:w-[300px] flex-shrink-0 bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col h-max md:sticky md:top-[240px]">
                {{-- Header Sidebar --}}
                <div class="bg-[#1e293b] text-white p-8 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-gray-500 rounded-full flex items-center justify-center mb-4 border-2 border-white/20 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white/70" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold truncate w-full">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-400 truncate w-full">{{ auth()->user()->email }}</p>
                </div>

                {{-- Menú Sidebar --}}
                <div class="p-4 flex flex-col gap-1">
                    <a href="{{ route('cuenta') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Mi Perfil
                    </a>
                    <a href="{{ route('direcciones.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 text-green-700 font-bold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Mis Direcciones
                    </a>
                    <a href="{{ route('cuenta.pedidos') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        Mis Pedidos
                    </a>
                    <a href="{{ route('cuenta.compras') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        Mis Compras
                    </a>
                    <a href="{{ route('cuenta.seguridad') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        Seguridad
                    </a>

                    <hr class="my-2 border-gray-100">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 font-bold transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </aside>

            {{-- CONTENIDO PRINCIPAL --}}
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-sm p-6 md:p-10 border border-gray-100">
                    
                    {{-- Encabezado de la sección --}}
                    <div class="flex items-center justify-between mb-8">
                        <h1 class="text-2xl font-extrabold text-[#1e293b] flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Mis Direcciones
                        </h1>
                        @if($direcciones->count() > 0)
                            <a href="{{ route('direcciones.create') }}" class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Agregar Dirección
                            </a>
                        @endif
                    </div>

                    {{-- Lista de Direcciones --}}
                    @if($direcciones->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($direcciones as $direccion)
                                <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition bg-gray-50 relative group" x-data="{ showModal: false }">
                                    <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                                        <a href="{{ route('direcciones.edit', $direccion->id) }}" class="p-2 bg-white text-blue-600 hover:bg-blue-50 rounded-lg shadow border border-gray-100 transition" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </a>
                                        <button type="button" @click="showModal = true" class="p-2 bg-white text-red-600 hover:bg-red-50 rounded-lg shadow border border-gray-100 transition" title="Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>

                                    {{-- Delete Modal --}}
                                    <div x-show="showModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;" x-transition.opacity>
                                        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4 transform transition-all" @click.away="showModal = false" x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-900">Eliminar Dirección</h3>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-6">¿Estás seguro de que deseas eliminar la dirección <strong>"{{ $direccion->nombre_direccion }}"</strong>? Esta acción no se puede deshacer.</p>
                                            
                                            <div class="flex justify-end gap-3">
                                                <button type="button" @click="showModal = false" class="px-4 py-2 text-sm font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Cancelar</button>
                                                <form action="{{ route('direcciones.destroy', $direccion->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl transition shadow-md">Sí, eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $direccion->nombre_direccion }}
                                    </h3>
                                    <p class="text-gray-600 font-medium mb-1">{{ $direccion->nombre_completo }} <span class="text-gray-400">|</span> {{ $direccion->telefono }}</p>
                                    <p class="text-gray-500 text-sm mb-1">{{ $direccion->direccion }}</p>
                                    <p class="text-gray-500 text-sm mb-3">{{ $direccion->municipio }}, {{ $direccion->departamento }} {{ $direccion->codigo_postal }}</p>
                                    
                                    @if($direccion->referencias)
                                        <div class="mt-2 text-xs text-gray-500 bg-white p-2 rounded border border-gray-100">
                                            <span class="font-bold">Referencias:</span> {{ $direccion->referencias }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h3 class="text-lg font-bold text-gray-600 mb-2">No tienes direcciones guardadas</h3>
                            <p class="text-gray-400 mb-6">Agrega una dirección para facilitar tus futuras compras.</p>
                            <a href="{{ route('direcciones.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Agregar mi primera dirección
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>

    {{-- ==========================================
            FOOTER
    =========================================== --}}
    <footer style="background-color:#0f172a; color:#cbd5e1; margin-top:2.5rem;">

        <div style="max-width:1280px; margin:0 auto; padding:32px 24px; display:grid; grid-template-columns:1fr; gap:32px;" class="footer-grid">

            <div>
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <div style="width:40px; height:40px; border-radius:8px; background-color:#1e293b; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                        <img src="{{ asset('img/logo-full.svg') }}" alt="Coffee Dat" style="width:24px; height:24px; object-fit:contain;">
                    </div>
                    <span style="color:#fff; font-size:1.125rem; font-weight:700;">COFFEE<span style="color:#22c55e;">.</span>DAT</span>
                </div>
                <p style="font-size:0.875rem; line-height:1.6; color:#94a3b8;">
                    La mejor plataforma para gestionar y adquirir el mejor café y
                    productos relacionados, directo a tu puerta con la mejor calidad.
                </p>
            </div>

            <div>
                <h4 style="color:#fff; font-weight:600; margin-bottom:16px;">Enlaces Rápidos</h4>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px; font-size:0.875rem;">
                    <li><a href="{{ url('/') }}" style="color:#cbd5e1; text-decoration:none;">Inicio</a></li>
                    <li><a href="#" style="color:#cbd5e1; text-decoration:none;">Nuestros Productos</a></li>
                    <li><a href="#" style="color:#cbd5e1; text-decoration:none;">Sobre Nosotros</a></li>
                    <li><a href="#" style="color:#cbd5e1; text-decoration:none;">Contacto</a></li>
                </ul>
            </div>

            <div>
                <h4 style="color:#fff; font-weight:600; margin-bottom:16px;">Contacto</h4>
                <ul style="list-style:none; padding:0; margin:0 0 20px 0; display:flex; flex-direction:column; gap:12px; font-size:0.875rem;">
                    <li style="display:flex; align-items:center; gap:10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>info@coffeedat.com</span>
                    </li>
                    <li style="display:flex; align-items:center; gap:10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.05 11.05 0 005.516 5.517l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>+1 234 567 890</span>
                    </li>
                </ul>

                <div style="display:flex; gap:12px;">
                    <a href="#" aria-label="Facebook" class="footer-social" style="width:36px; height:36px; border-radius:50%; background-color:#1e293b; display:flex; align-items:center; justify-content:center; text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 24 24">
                            <path d="M22 12a10 10 0 10-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0022 12z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="footer-social" style="width:36px; height:36px; border-radius:50%; background-color:#1e293b; display:flex; align-items:center; justify-content:center; text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 24 24">
                            <path d="M12 2.2c3.2 0 3.6 0 4.9.07 1.2.06 2 .25 2.4.42.6.24 1 .53 1.5 1a4 4 0 011 1.5c.17.4.36 1.2.42 2.4.06 1.3.07 1.7.07 4.9s0 3.6-.07 4.9c-.06 1.2-.25 2-.42 2.4a4 4 0 01-1 1.5 4 4 0 01-1.5 1c-.4.17-1.2.36-2.4.42-1.3.06-1.7.07-4.9.07s-3.6 0-4.9-.07c-1.2-.06-2-.25-2.4-.42a4 4 0 01-1.5-1 4 4 0 01-1-1.5c-.17-.4-.36-1.2-.42-2.4C2.2 15.6 2.2 15.2 2.2 12s0-3.6.07-4.9c.06-1.2.25-2 .36-2.4a4 4 0 011-1.5 4 4 0 011.2-.79c.37-.14.93-.31 1.95-.36C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.15 0-3.52 0-4.76.07-1.02.05-1.58.22-1.95.36-.49.19-.84.42-1.2.79-.37.36-.6.71-.79 1.2-.14.37-.31.93-.36 1.95C2.8 8.48 2.8 8.85 2.8 12s0 3.52.07 4.76c.05 1.02.22 1.58.36 1.95.19.49.42.84.79 1.2.36.37.71.6 1.2.79.37.14.93.31 1.95.36 1.24.07 1.61.07 4.76.07s3.52 0 4.76-.07c1.02-.05 1.58-.22 1.95-.36.49-.19.84-.42 1.2-.79.37-.36.6-.71.79-1.2.14-.37.31-.93.36-1.95.07-1.24.07-1.61.07-4.76s0-3.52-.07-4.76c-.05-1.02-.22-1.58-.36-1.95a3.2 3.2 0 00-.79-1.2 3.2 3.2 0 00-1.2-.79c-.37-.14-.93-.31-1.95-.36C15.52 4 15.15 4 12 4zm0 3.6a4.4 4.4 0 110 8.8 4.4 4.4 0 010-8.8zm0 1.8a2.6 2.6 0 100 5.2 2.6 2.6 0 000-5.2zm4.6-2a1 1 0 110 2 1 1 0 010-2z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <div style="border-top:1px solid #1e293b;">
            <div style="max-width:1280px; margin:0 auto; padding:16px 24px; text-align:center; font-size:0.875rem; color:#64748b;">
                &copy; {{ date('Y') }} Coffee Dat. Todos los derechos reservados.
            </div>
        </div>

    </footer>

    <style>
        .footer-social:hover {
            background-color: #16a34a !important;
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }
    </style>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 1500)" 
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-green-600 text-white px-5 py-2.5 rounded-full shadow-lg z-[9999] flex items-center gap-2 font-medium text-sm whitespace-nowrap">
        <svg class="w-5 h-5 text-green-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif


    @include('cliente.partials.auth-modals')
    <script>
        window.addEventListener('beforeunload', () => {
            if (window.location.pathname.includes('/cuenta') || window.location.pathname.includes('/direcciones') || window.location.pathname.includes('/pedidos') || window.location.pathname.includes('/compras') || window.location.pathname.includes('/seguridad')) {
                sessionStorage.setItem('cuentaScrollPos', window.scrollY);
            }
        });
        window.addEventListener('DOMContentLoaded', () => {
            const scrollPos = sessionStorage.getItem('cuentaScrollPos');
            if (scrollPos && (window.location.pathname.includes('/cuenta') || window.location.pathname.includes('/direcciones') || window.location.pathname.includes('/pedidos') || window.location.pathname.includes('/compras') || window.location.pathname.includes('/seguridad'))) {
                setTimeout(() => window.scrollTo({ top: parseInt(scrollPos), behavior: 'instant' }), 10);
            } else {
                sessionStorage.removeItem('cuentaScrollPos');
            }
        });
    </script>
</body>
</html>
