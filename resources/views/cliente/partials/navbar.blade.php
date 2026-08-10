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
                    <a href="{{ route('cuenta') }}" class="flex items-center gap-2 px-5 py-4 font-semibold transition-all duration-300 {{ request()->routeIs('cuenta') || request()->is('cuenta/*') || request()->is('direcciones*') ? 'text-green-700 border-b-4 border-green-600 hover:bg-green-50' : 'text-gray-700 hover:text-green-700 hover:bg-green-50 border-b-4 border-transparent hover:border-green-600' }}">
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
