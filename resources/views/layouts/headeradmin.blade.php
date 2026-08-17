<header class="fixed top-0 left-72 right-0 bg-white shadow-sm border-b border-gray-200 z-40 h-16">
    {{-- Header fijo - Alineado a la derecha del sidebar (left-72 = 18rem / 288px) --}}
    <div class="flex items-center justify-between px-8 h-full">
        <!-- Título -->
        <h1 class="text-2xl font-bold text-gray-800">Panel de Control</h1>

        <!-- Usuario y botón -->
        <div class="flex items-center gap-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <span class="font-semibold text-gray-700">Hola, {{ Auth::user()->name ?? 'Administrador' }}</span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H9m4 8H7a2 2 0 01-2-2V6a2 2 0 012-2h6"/>
                    </svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</header>
