<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $producto->nombre }} | Coffee.Dat</title>

    {{-- Tailwind CSS (CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js for interactive components --}}
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
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Back button --}}
            <a href="{{ route('inicio') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 mb-6 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Volver
            </a>

            {{-- Main Product Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ cantidad: 1, maxStock: {{ $producto->stock_disponible }} }">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    
                    {{-- Left Column: Images --}}
                    @php
                        $todasLasImagenes = [];
                        if($producto->imagenPrincipal) {
                            $todasLasImagenes[] = asset('storage/' . $producto->imagenPrincipal->url_imagen);
                        } elseif ($producto->imagenes->count() == 0) {
                            $todasLasImagenes[] = asset('img/producto-default.png');
                        }
                        foreach($producto->imagenes->where('principal', false) as $img) {
                            $todasLasImagenes[] = asset('storage/' . $img->url_imagen);
                        }
                    @endphp
                    <div class="flex flex-col items-center relative" x-data="{ 
                        imagenes: {{ json_encode($todasLasImagenes) }},
                        indiceActual: 0,
                        siguiente() { this.indiceActual = (this.indiceActual + 1) % this.imagenes.length },
                        anterior() { this.indiceActual = (this.indiceActual - 1 + this.imagenes.length) % this.imagenes.length }
                    }">
                        {{-- Favorite Button --}}
                        @auth
                            <a href="{{ route('favorito.toggle', $producto->id) }}" class="absolute top-2 right-2 z-10 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center hover:bg-red-50 transition border border-gray-100 group">
                        @else
                            <button type="button" x-data @click.prevent="$dispatch('open-login', { productId: {{ $producto->id }} })" class="absolute top-2 right-2 z-10 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center hover:bg-red-50 transition border border-gray-100 group focus:outline-none">
                        @endauth
                            
                            @php
                                // Verificamos si este producto es favorito del usuario actual
                                $esFavorito = auth()->check() && auth()->user()->productosFavoritos->contains($producto->id);
                            @endphp

                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="h-6 w-6 transition {{ $esFavorito ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}" 
                                 fill="{{ $esFavorito ? 'currentColor' : 'none' }}" 
                                 viewBox="0 0 24 24" 
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z" />
                            </svg>
                        @auth
                            </a>
                        @else
                            </button>
                        @endauth
                        
                        {{-- Main Image Area with carrousel controls--}}
                        <div class="w-full relative flex items-center justify-center bg-white rounded-2xl mb-4 h-96 group">
                            
                            <!-- Left Arrow -->
                            <button @click="anterior()" x-show="imagenes.length > 1" class="absolute left-2 w-8 h-8 bg-white shadow rounded-full flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-gray-50 opacity-0 group-hover:opacity-100 transition-opacity z-10 border border-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <!-- Image -->
                            <img :src="imagenes[indiceActual]" alt="{{ $producto->nombre }}" class="h-full object-contain max-h-[350px]">

                            <!-- Right Arrow -->
                            <button @click="siguiente()" x-show="imagenes.length > 1" class="absolute right-2 w-8 h-8 bg-white shadow rounded-full flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-gray-50 opacity-0 group-hover:opacity-100 transition-opacity z-10 border border-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Indicators -->
                            <div x-show="imagenes.length > 1" class="absolute bottom-4 bg-gray-500 text-white text-xs px-3 py-1 rounded-full bg-opacity-70 font-semibold tracking-wide shadow-sm" x-text="`${indiceActual + 1}/${imagenes.length}`">
                            </div>
                        </div>

                        {{-- Thumbnail gallery --}}
                        <div class="flex items-center gap-3 justify-center mt-2 h-20" x-show="imagenes.length > 1">
                            <template x-for="(img, index) in imagenes" :key="index">
                                <div @click="indiceActual = index"
                                     :class="{'border-green-500': indiceActual === index, 'border-gray-200': indiceActual !== index}"
                                     class="w-16 h-16 rounded-lg border-2 p-1 flex items-center justify-center hover:border-green-400 cursor-pointer overflow-hidden bg-white transition">
                                    <img :src="img" alt="" class="h-full object-contain">
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Right Column: Details --}}
                    <div class="flex flex-col py-2">
                        <div class="text-sm font-bold text-green-600 tracking-widest uppercase mb-2">
                            {{ $producto->categoria->nombre ?? 'FUNGICIDAD' }}
                        </div>
                        
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1a202c] mb-4 leading-tight">
                            {{ $producto->nombre }}
                        </h1>
                        
                        <div class="flex items-baseline mb-6 gap-2">
                            <span class="text-4xl font-extrabold text-black">
                                ${{ number_format($producto->precio_venta, 2, '.', ',') }}
                            </span>
                            <span class="text-gray-500 text-lg font-semibold">COP</span>
                        </div>

                        {{-- Quantity selector --}}
                        <div class="flex items-center gap-4 mb-8">
                            <span class="font-bold text-gray-800">Cant.</span>
                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden h-10 w-32 bg-white">
                                <button type="button" @click="if(cantidad > 1) cantidad--" class="w-10 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-black transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                </button>
                                <input type="number" x-model="cantidad" class="w-full h-full text-center font-bold text-lg focus:outline-none border-none pointer-events-none p-0" min="1" :max="maxStock" readonly>
                                <button type="button" @click="if(cantidad < maxStock) cantidad++" class="w-10 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-black transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </div>
                            <span class="text-sm text-gray-500">
                                ({{ $producto->stock_disponible }} disponibles)
                            </span>
                        </div>

                        {{-- Buttons --}}
                        <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="flex flex-col gap-3 mt-auto mb-4 w-full">
                            @csrf
                            <input type="hidden" name="cantidad" :value="cantidad">
                            
                            @auth
                                <button type="submit" name="accion" value="comprar" class="w-full bg-[#1da051] hover:bg-green-700 text-white font-bold py-3.5 px-6 rounded-xl flex items-center justify-center gap-2 transition duration-200 shadow-sm border border-transparent">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd" />
                                    </svg>
                                    Comprar ahora
                                </button>
                            @else
                                <button type="button" @click.prevent="$dispatch('open-login', { buyProductId: {{ $producto->id }}, buyQuantity: cantidad })" class="w-full bg-[#1da051] hover:bg-green-700 text-white font-bold py-3.5 px-6 rounded-xl flex items-center justify-center gap-2 transition duration-200 shadow-sm border border-transparent focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd" />
                                    </svg>
                                    Comprar ahora
                                </button>
                            @endauth
                            
                            <button type="submit" name="accion" value="carrito" class="w-full bg-[#24b25b] hover:bg-green-600 text-white font-bold py-3.5 px-6 rounded-xl flex items-center justify-center gap-2 transition duration-200 shadow-sm border border-transparent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h12M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                                </svg>
                                Agregar al carrito
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            {{-- Description Section --}}
            <div class="mt-8">
                <h3 class="text-xl font-bold text-[#1e293b] flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Descripción del Producto
                </h3>
                
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100 text-gray-600 leading-relaxed text-sm md:text-base break-words">
                    {{ $producto->descripcion }}
                </div>
            </div>

        </div>
        
        @if(session('iniciar_compra') && session('modo') === 'directo')
            @include('cliente.partials.modal-directo')
        @endif
        
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
303:                         </svg>
304:                     </a>
305:                     <a href="#" aria-label="Twitter" class="footer-social" style="width:36px; height:36px; border-radius:50%; background-color:#1e293b; display:flex; align-items:center; justify-content:center; text-decoration:none;">
306:                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 24 24">
307:                             <path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.2-.8.5-1.7.8-2.6 1a4.1 4.1 0 00-7 3.7A11.6 11.6 0 013 4.6a4.1 4.1 0 001.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 01-1.9.1c.5 1.6 2.1 2.8 3.9 2.9A8.2 8.2 0 012 18.4a11.6 11.6 0 006.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/>
308:                         </svg>
309:                     </a>
310:                 </div>
311:             </div>
312: 
313:         </div>
314: 
315:         <div style="border-top:1px solid #1e293b;">
316:             <div style="max-width:1280px; margin:0 auto; padding:16px 24px; text-align:center; font-size:0.875rem; color:#64748b;">
317:                 &copy; {{ date('Y') }} Coffee Dat. Todos los derechos reservados.
318:             </div>
                        </svg>
                    </a>
                    <a href="#" aria-label="Twitter" class="footer-social" style="width:36px; height:36px; border-radius:50%; background-color:#1e293b; display:flex; align-items:center; justify-content:center; text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 24 24">
                            <path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.2-.8.5-1.7.8-2.6 1a4.1 4.1 0 00-7 3.7A11.6 11.6 0 013 4.6a4.1 4.1 0 001.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 01-1.9.1c.5 1.6 2.1 2.8 3.9 2.9A8.2 8.2 0 012 18.4a11.6 11.6 0 006.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/>
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

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-red-600 text-white px-5 py-2.5 rounded-full shadow-lg z-[9999] flex items-center gap-2 font-medium text-sm whitespace-nowrap">
        <svg class="w-5 h-5 text-red-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('error') }}
    </div>
    @endif

    @include('cliente.partials.auth-modals')
</body>
</html>
