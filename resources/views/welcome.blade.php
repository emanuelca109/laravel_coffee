<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Coffee.Dat | Tienda Virtual de Productos para Caficultura</title>

    {{-- Tailwind CSS (CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body class="font-sans antialiased bg-gray-100">

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
                    <span class="absolute -top-0.5 -right-0.5 w-[15px] h-[15px] rounded-full bg-yellow-400 border-2 border-white"></span>
                </button>
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
    <nav class="fixed left-0 w-full z-[900] bg-white shadow-lg border-b border-gray-200" style="top:160px;">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-center">
                <ul class="flex flex-wrap justify-center gap-2 md:gap-6">

                    <li>
                        <a href="{{ url('/') }}" class="flex items-center gap-2 px-5 py-4 font-semibold transition-all duration-300 {{ request()->routeIs('inicio') && !request()->has('categoria') && !request()->has('view') ? 'text-green-700 border-b-4 border-green-600 hover:bg-green-50' : 'text-gray-700 hover:text-green-700 hover:bg-green-50 border-b-4 border-transparent hover:border-green-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10.5L12 3l9 7.5V21H3V10.5z"/>
                            </svg>
                            Inicio
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/?view=categorias') }}" class="flex items-center gap-2 px-5 py-4 font-semibold transition-all duration-300 {{ request()->has('categoria') || request('view') === 'categorias' ? 'text-green-700 border-b-4 border-green-600 hover:bg-green-50' : 'text-gray-700 hover:text-green-700 hover:bg-green-50 border-b-4 border-transparent hover:border-green-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            Categorías
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('favoritos') }}" class="flex items-center gap-2 px-5 py-4 font-semibold transition-all duration-300 {{ request()->routeIs('favoritos') ? 'text-green-700 border-b-4 border-green-600 hover:bg-green-50' : 'text-gray-700 hover:text-green-700 hover:bg-green-50 border-b-4 border-transparent hover:border-green-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z"/>
                            </svg>
                            Favoritos
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('carrito') }}" class="flex items-center gap-2 px-5 py-4 font-semibold transition-all duration-300 {{ request()->routeIs('carrito') ? 'text-green-700 border-b-4 border-green-600 hover:bg-green-50' : 'text-gray-700 hover:text-green-700 hover:bg-green-50 border-b-4 border-transparent hover:border-green-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h12M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                            </svg>
                            Mi carrito
                            @php
                                $cartCount = session()->has('carrito') ? array_sum(array_column(session('carrito'), 'cantidad')) : 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cuenta') }}" class="flex items-center gap-2 px-5 py-4 font-semibold transition-all duration-300 {{ request()->routeIs('cuenta') ? 'text-green-700 border-b-4 border-green-600 hover:bg-green-50' : 'text-gray-700 hover:text-green-700 hover:bg-green-50 border-b-4 border-transparent hover:border-green-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Mi cuenta
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    {{-- ==========================================
            CONTENIDO PRINCIPAL
    =========================================== --}}
    <main class="min-h-screen bg-gray-100" style="padding-top:224px;">

        <!-- =============================
                AQUÍ IRÁN LAS CATEGORÍAS
        ============================== -->
        {{-- Cuando creemos el CRUD de categorías,
             aquí mostraremos las categorías
             creadas por el administrador. --}}

        @if(request()->has('view') || request()->has('categoria'))
        <section class="max-w-7xl mx-auto px-6 py-8">

            <div class="flex flex-wrap gap-3">

                <a href="{{ route('inicio', ['view' => 'categorias']) }}"
                    class="px-6 py-3 rounded-full {{ !request()->has('categoria') ? 'bg-green-600 text-white' : 'bg-white shadow text-gray-800 hover:bg-green-50' }} font-semibold">
                    Todos
                </a>

                @foreach($categorias as $categoria)

                    <a href="{{ route('inicio', ['categoria' => $categoria->id]) }}"
                        class="px-6 py-3 rounded-full {{ request('categoria') == $categoria->id ? 'bg-green-600 text-white' : 'bg-white shadow text-gray-800 hover:bg-green-50' }} font-semibold">

                        {{ $categoria->nombre }}

                    </a>

                @endforeach

            </div>

        </section>
        @endif

        <!-- =============================
            AQUÍ IRÁN LOS PRODUCTOS
        ============================== -->
        <section class="max-w-7xl mx-auto px-6 py-12">

            <h2 class="text-4xl font-bold text-gray-800 mb-10">
                Nuestros Productos
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                @foreach($productos as $producto)

                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 relative p-4">

                        {{-- Botón "Me encanta" (favorito) cambiado a enlace --}}
                        @auth
                            <a href="{{ route('favorito.toggle', $producto->id) }}"
                                class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-white shadow flex items-center justify-center hover:bg-red-50 transition group">
                        @else
                            <button type="button" x-data @click.prevent="$dispatch('open-login', { productId: {{ $producto->id }} })"
                                class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-white shadow flex items-center justify-center hover:bg-red-50 transition group focus:outline-none">
                        @endauth
                            
                            @php
                                // Comprobamos si el usuario actual tiene este producto como favorito
                                $esFavorito = auth()->check() && auth()->user()->productosFavoritos->contains($producto->id);
                            @endphp

                            {{-- El ícono se pinta de rojo y se rellena si es favorito --}}
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="w-5 h-5 transition {{ $esFavorito ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500' }}" 
                                 fill="{{ $esFavorito ? 'currentColor' : 'none' }}" 
                                 viewBox="0 0 24 24" 
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z"/>
                            </svg>
                        @auth
                            </a>
                        @else
                            </button>
                        @endauth

                        {{-- Imagen del producto --}}
                        <a href="{{ route('producto.ver', $producto->id) }}" class="block">
                            <div class="h-48 flex items-center justify-center rounded-2xl overflow-hidden mb-4 bg-white">

                                @if($producto->imagenPrincipal)

                                    <img
                                        src="{{ asset('storage/' . $producto->imagenPrincipal->url_imagen) }}"
                                        alt="{{ $producto->nombre }}"
                                        class="w-full h-full object-cover">

                                @else

                                    <img
                                        src="{{ asset('img/producto-default.png') }}"
                                        alt="Producto"
                                        class="w-full h-full object-cover">

                                @endif

                            </div>

                            {{-- Nombre --}}
                            <h3 class="font-bold text-lg text-gray-800 hover:text-green-600 transition">
                                {{ $producto->nombre }}
                            </h3>
                        </a>

                        {{-- Descripción --}}
                        <p class="text-gray-400 text-sm mt-1 leading-snug break-words line-clamp-2">
                            {{ $producto->descripcion }}
                        </p>

                        {{-- Precio --}}
                        <div class="mt-3 mb-4">
                            <span class="text-gray-900 font-extrabold text-2xl">
                                ${{ number_format($producto->precio_venta, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Botones de acción: Comprar (grande) + Carrito (pequeño) --}}
                        <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="flex items-center gap-3 w-full mt-auto">
                            @csrf
                            <input type="hidden" name="cantidad" value="1">
                            
                            @auth
                                <button type="submit" name="accion" value="comprar"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold text-base px-4 py-3 rounded-full transition">
                                    Comprar
                                </button>
                            @else
                                <button type="button" x-data @click.prevent="$dispatch('open-login', { buyProductId: {{ $producto->id }}, buyQuantity: 1 })"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold text-base px-4 py-3 rounded-full transition focus:outline-none">
                                    Comprar
                                </button>
                            @endauth

                            <button type="submit" name="accion" value="carrito"
                                    class="flex-shrink-0 w-12 h-12 rounded-full border-2 border-green-600 text-green-700 flex items-center justify-center hover:bg-green-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h12M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                                </svg>
                            </button>
                        </form>

                    </div>

                @endforeach

            </div>

        </section>

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