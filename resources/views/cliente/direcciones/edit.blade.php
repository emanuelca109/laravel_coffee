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
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 relative overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-green-50 to-green-100 absolute top-0 left-0"></div>
                    
                    <div class="p-8 pt-10">
                        {{-- Encabezado --}}
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h1 class="text-2xl font-extrabold text-[#0f172a]">Editar Dirección</h1>
                                <p class="text-[13px] text-gray-500 mt-1">Modifica los datos de tu dirección</p>
                            </div>
                            <a href="{{ route('direcciones.index') }}" class="text-gray-400 hover:text-gray-600 transition p-1 rounded-md hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </div>

                    <hr class="border-gray-100 mb-6">

                    {{-- Errores de Validación --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600">
                            <ul class="list-disc pl-5 space-y-1 text-sm font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulario --}}
                    <form action="{{ route('direcciones.update', $direccion->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-x-4 gap-y-5">
                            
                            {{-- Tipo Dirección --}}
                            <div class="flex flex-col gap-1.5 md:col-span-6">
                                <label class="text-sm font-bold text-[#1e293b] flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    Tipo de dirección *
                                </label>
                                <select name="nombre_direccion" required
                                        class="w-full px-4 py-2.5 rounded-xl border-2 border-green-500 focus:ring-0 focus:border-green-600 text-sm font-medium text-gray-700 bg-white shadow-sm appearance-none cursor-pointer">
                                    <option value="Casa" {{ old('nombre_direccion', $direccion->nombre_direccion) == 'Casa' ? 'selected' : '' }}>Casa</option>
                                    <option value="Trabajo" {{ old('nombre_direccion', $direccion->nombre_direccion) == 'Trabajo' ? 'selected' : '' }}>Trabajo</option>
                                    <option value="Otro" {{ old('nombre_direccion', $direccion->nombre_direccion) == 'Otro' ? 'selected' : (old('nombre_direccion', $direccion->nombre_direccion) != 'Casa' && old('nombre_direccion', $direccion->nombre_direccion) != 'Trabajo' ? 'selected' : '') }}>Otro</option>
                                </select>
                                <p class="text-[11px] text-gray-400 font-medium">Para identificar fácilmente esta dirección</p>
                            </div>

                            {{-- Nombre Completo --}}
                            <div class="flex flex-col gap-1.5 md:col-span-3">
                                <label class="text-sm font-bold text-[#1e293b] flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    Nombre completo *
                                </label>
                                <input type="text" name="nombre_completo" value="{{ old('nombre_completo', $direccion->nombre_completo) }}" required
                                       placeholder="Quien recibe el pedido"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-100 focus:border-green-500 text-sm transition-all font-medium placeholder-gray-400">
                            </div>

                            {{-- Teléfono --}}
                            <div class="flex flex-col gap-1.5 md:col-span-3">
                                <label class="text-sm font-bold text-[#1e293b] flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    Teléfono *
                                </label>
                                <input type="text" name="telefono" value="{{ old('telefono', $direccion->telefono) }}" required
                                       placeholder="3001234567"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-100 focus:border-green-500 text-sm transition-all font-medium placeholder-gray-400">
                            </div>

                            {{-- Dirección Completa --}}
                            <div class="flex flex-col gap-1.5 md:col-span-6">
                                <label class="text-sm font-bold text-[#1e293b] flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    Dirección completa *
                                </label>
                                <input type="text" name="direccion" value="{{ old('direccion', $direccion->direccion) }}" required
                                       placeholder="Calle 10 # 5-20"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-100 focus:border-green-500 text-sm transition-all font-medium placeholder-gray-400">
                            </div>

                            {{-- Departamento --}}
                            <div class="flex flex-col gap-1.5 md:col-span-2">
                                <label class="text-[13px] font-bold text-[#1e293b]">Departamento *</label>
                                <input type="text" name="departamento" value="{{ old('departamento', $direccion->departamento) }}" required
                                       placeholder="Ej: Huila"
                                       class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-100 focus:border-green-500 text-sm transition-all font-medium placeholder-gray-400">
                            </div>

                            {{-- Municipio --}}
                            <div class="flex flex-col gap-1.5 md:col-span-2">
                                <label class="text-[13px] font-bold text-[#1e293b]">Municipio *</label>
                                <input type="text" name="municipio" value="{{ old('municipio', $direccion->municipio) }}" required
                                       placeholder="Ej: Pitalito"
                                       class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-100 focus:border-green-500 text-sm transition-all font-medium placeholder-gray-400">
                            </div>

                            {{-- Código Postal --}}
                            <div class="flex flex-col gap-1.5 md:col-span-2">
                                <label class="text-[13px] font-bold text-[#1e293b]">Código Postal</label>
                                <input type="text" name="codigo_postal" value="{{ old('codigo_postal', $direccion->codigo_postal) }}" 
                                       placeholder="Opcional"
                                       class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-100 focus:border-green-500 text-sm transition-all font-medium placeholder-gray-400">
                            </div>

                            {{-- Referencias --}}
                            <div class="flex flex-col gap-1.5 md:col-span-6 mt-1">
                                <label class="text-sm font-bold text-[#1e293b] flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    Referencias (Opcional)
                                </label>
                                <textarea name="referencias" rows="2" 
                                          placeholder="Ej: Casa blanca con portón negro, al lado del parque"
                                          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-100 focus:border-green-500 text-sm transition-all font-medium placeholder-gray-400 resize-none">{{ old('referencias', $direccion->referencias) }}</textarea>
                                <p class="text-[11px] text-gray-400 font-medium">Ayuda al repartidor a encontrar tu dirección más fácil</p>
                            </div>

                        </div>

                        <hr class="border-gray-100 mt-6 mb-6">

                        {{-- Botones Footer --}}
                        <div class="flex items-center gap-3">
                            <button type="submit" class="flex-1 bg-[#15a34a] hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-md flex items-center justify-center gap-2 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Guardar Dirección
                            </button>
                            <a href="{{ route('direcciones.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition text-sm text-center">
                                Cancelar
                            </a>
                        </div>
                    </form>
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
