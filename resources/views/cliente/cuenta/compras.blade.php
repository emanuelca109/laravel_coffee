<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mis Compras | Coffee.Dat</title>

    {{-- Tailwind CSS (CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">

    {{-- HEADER (fijo arriba) --}}
    <header class="fixed top-0 left-0 w-full z-[1000] h-40 flex flex-col items-center justify-center gap-3 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('img/ca.png') }}');">
        <div class="absolute inset-0 bg-black/35"></div>
        
        <div class="absolute z-30 top-5 right-8">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full text-white font-medium transition shadow-lg">
                    <span class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center font-bold shadow-inner">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </span>
                    <span class="hidden md:inline">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="open" style="display: none;" class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden text-sm z-50">
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
        </div>
        <img src="{{ asset('img/logo-full.svg') }}" alt="Coffee Dat" class="relative z-20 h-14 mx-auto">
        <div class="relative z-20 w-full flex justify-center px-6">
            <form action="{{ Route::has('productos.buscar') ? route('productos.buscar') : '#' }}" method="GET" class="relative w-full max-w-[700px]">
                <input type="text" name="q" placeholder="Buscar en Coffee Dat..." class="w-full rounded-full py-3 pl-5 pr-14 text-sm text-gray-700 placeholder-gray-400 shadow-md focus:outline-none focus:ring-2 focus:ring-green-500">
                <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black hover:bg-gray-800 flex items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" /></svg>
                </button>
            </form>
        </div>
    </header>

    {{-- NAVBAR (fijo justo debajo del header) --}}
    @include('cliente.partials.navbar')

    {{-- MAIN CONTENT --}}
    <main class="min-h-screen bg-gray-50" style="padding-top:240px; padding-bottom:40px;">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row gap-6">

            {{-- BARRA LATERAL --}}
            <aside class="w-full md:w-[300px] flex-shrink-0 bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col h-max md:sticky md:top-[240px]">
                <div class="bg-[#1e293b] text-white p-8 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-gray-500 rounded-full flex items-center justify-center mb-4 border-2 border-white/20 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white/70" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold truncate w-full">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-400 truncate w-full">{{ auth()->user()->email }}</p>
                </div>

                <div class="p-4 flex flex-col gap-1">
                    <a href="{{ route('cuenta') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Mi Perfil
                    </a>
                    <a href="{{ route('direcciones.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Mis Direcciones
                    </a>
                    <a href="{{ route('cuenta.pedidos') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        Mis Pedidos
                    </a>
                    <a href="{{ route('cuenta.compras') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 text-green-700 font-bold transition">
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
                    <div class="flex items-center gap-3 mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                        </svg>
                        <h1 class="text-2xl font-extrabold text-[#1e293b]">Mis Compras</h1>
                    </div>

                    @if(count($pedidos) > 0)
                        <div class="space-y-6">
                            @foreach($pedidos as $pedido)
                            <div x-data="{ open: false, confirmReturn: false }" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                                {{-- Header Premium --}}
                                <div class="bg-gradient-to-r from-[#0f172a] to-[#1e293b] px-6 py-5 flex flex-col sm:flex-row sm:justify-between sm:items-center text-white gap-4 relative overflow-hidden">
                                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
                                    <div class="flex items-center gap-4 relative z-10">
                                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/10 flex items-center justify-center shadow-inner">
                                            <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-3 mb-1">
                                                <p class="text-[11px] font-extrabold text-slate-300 uppercase tracking-widest">Orden #{{ $pedido->numero_pedido }}</p>
                                                @if($pedido->estado == 'Entregado')
                                                    <span class="bg-green-500/20 text-green-300 border border-green-500/30 text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span> Entregado
                                                    </span>
                                                @elseif($pedido->estado == 'Devolución solicitada')
                                                    <span class="bg-orange-500/20 text-orange-300 border border-orange-500/30 text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span> Devolución en proceso
                                                    </span>
                                                @elseif($pedido->estado == 'Devuelto')
                                                    <span class="bg-red-500/20 text-red-300 border border-red-500/30 text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Devuelto
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-sm font-medium text-slate-200 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                {{ \Carbon\Carbon::parse($pedido->fecha)->isoFormat('D \d\e MMMM, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-left sm:text-right relative z-10">
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Monto Total</p>
                                        <p class="text-2xl font-black text-white tracking-tight">${{ number_format($pedido->total ?? 0, 0) }}</p>
                                    </div>
                                </div>

                                {{-- Details Trigger --}}
                                <button type="button" @click.prevent="open = !open" class="w-full bg-white border-b border-gray-100 px-6 py-4 flex justify-between items-center hover:bg-slate-50 transition cursor-pointer text-slate-600 focus:outline-none group">
                                    <div class="flex items-center gap-3">
                                        <div class="flex -space-x-3 overflow-hidden p-1">
                                            @foreach($pedido->detalles->take(3) as $detalle)
                                                @if($detalle->producto && $detalle->producto->imagenes->count() > 0)
                                                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover" src="{{ asset('storage/' . $detalle->producto->imagenes->first()->url_imagen) }}" alt=""/>
                                                @else
                                                    <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-slate-200 flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" /></svg>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if($pedido->detalles->count() > 3)
                                                <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                                                    +{{ $pedido->detalles->count() - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                        <span class="font-bold text-xs uppercase tracking-wide text-slate-500 group-hover:text-slate-800 transition">
                                            Ver {{ $pedido->detalles->count() }} producto(s)
                                        </span>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-slate-200 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 transform transition-transform duration-300" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </button>

                                {{-- Details Content --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" style="display: none;" class="bg-[#f8fafc] p-6 border-b border-gray-100 shadow-inner">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($pedido->detalles as $detalle)
                                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                            <div class="w-16 h-16 rounded-xl bg-gray-50 shrink-0 overflow-hidden border border-gray-100">
                                                @if($detalle->producto && $detalle->producto->imagenes->count() > 0)
                                                    <img src="{{ asset('storage/' . $detalle->producto->imagenes->first()->url_imagen) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-extrabold text-slate-800 truncate" title="{{ $detalle->producto ? $detalle->producto->nombre : 'Producto eliminado' }}">
                                                    {{ $detalle->producto ? $detalle->producto->nombre : 'Producto eliminado' }}
                                                </p>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded">Cant: {{ $detalle->cantidad }}</span>
                                                    <span class="text-xs font-medium text-slate-500">${{ number_format($detalle->precio_unitario ?? 0, 0) }} c/u</span>
                                                </div>
                                            </div>
                                            <div class="text-base font-black text-slate-800 pl-2">
                                                ${{ number_format($detalle->subtotal ?? 0, 0) }}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Actions Footer --}}
                                <div class="bg-white px-6 py-5 flex flex-col sm:flex-row justify-between items-center gap-4">
                                    <div class="w-full sm:w-auto flex items-center gap-3">
                                        @if($pedido->estado == 'Entregado')
                                            <button @click="confirmReturn = true" class="w-full sm:w-auto px-5 py-2.5 rounded-xl text-sm font-bold text-orange-600 bg-orange-50 border border-orange-200 hover:bg-orange-600 hover:text-white transition flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                                                Solicitar Devolución
                                            </button>
                                        @endif
                                    </div>
                                    
                                    <div class="w-full sm:w-auto flex flex-wrap items-center gap-3 justify-end">
                                        <a href="{{ route('cuenta.compras.ver_factura', $pedido->id) }}" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-bold text-[#0f172a] bg-slate-100 hover:bg-slate-200 transition flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            Ver Factura
                                        </a>
                                        <a href="{{ route('cuenta.compras.factura', $pedido->id) }}" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-green-600 hover:bg-green-700 transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                            PDF
                                        </a>
                                    </div>
                                </div>

                                {{-- Return Confirmation Modal --}}
                                <div x-show="confirmReturn" style="display: none;" class="fixed inset-0 z-[2000] flex items-center justify-center p-4">
                                    <div x-show="confirmReturn" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="confirmReturn = false"></div>
                                    <div x-show="confirmReturn" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-90 translate-y-8"
                                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 scale-90 translate-y-8"
                                         class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg z-10 overflow-hidden flex flex-col">
                                        
                                        {{-- Header --}}
                                        <div class="bg-[#1e8b45] text-white px-6 py-4 flex justify-between items-center">
                                            <div class="flex items-center gap-3">
                                                <div class="bg-white/20 p-2 rounded-xl">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold leading-tight">Solicitar Devolución</h3>
                                                    <p class="text-green-100 text-sm">Pedido #{{ $pedido->numero_pedido }}</p>
                                                </div>
                                            </div>
                                            <button @click="confirmReturn = false" class="text-green-100 hover:text-white transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        {{-- Form --}}
                                        <form action="{{ route('cuenta.compras.devolucion', $pedido->id) }}" method="POST" class="flex flex-col p-6">
                                            @csrf
                                            
                                            <div class="max-h-[250px] overflow-y-auto mb-6 pr-2 space-y-3">
                                                @foreach($pedido->detalles as $detalle)
                                                <div class="border border-gray-100 rounded-2xl p-4 flex items-center justify-between gap-4 bg-gray-50/50">
                                                    <div class="flex items-center gap-4">
                                                        <input type="checkbox" name="productos[]" value="{{ $detalle->producto_id }}" class="w-5 h-5 text-[#1e8b45] bg-white rounded border-gray-300 focus:ring-[#1e8b45] cursor-pointer" checked>
                                                        <div>
                                                            <p class="font-bold text-slate-800 text-sm">{{ $detalle->producto ? $detalle->producto->nombre : 'Producto eliminado' }}</p>
                                                            <p class="text-xs text-slate-400">Cantidad comprada: {{ $detalle->cantidad }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <input type="number" name="cantidades[{{ $detalle->producto_id }}]" min="1" max="{{ $detalle->cantidad }}" value="{{ $detalle->cantidad }}" class="w-16 h-8 text-center border border-[#1e8b45] rounded-lg text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1e8b45]/20">
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>

                                            <div class="mb-6">
                                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Motivo de la devolución</label>
                                                <textarea name="motivo" rows="3" class="w-full rounded-xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-[#1e8b45]/20 focus:border-[#1e8b45] text-sm p-4 resize-none transition-all placeholder:text-gray-400" placeholder="Explica detalladamente por qué deseas devolver los productos..." required></textarea>
                                            </div>

                                            <div class="flex gap-3">
                                                <button type="submit" class="flex-1 px-5 py-3.5 rounded-xl font-bold text-white bg-[#1e8b45] hover:bg-green-700 transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                                    </svg>
                                                    Enviar Solicitud
                                                </button>
                                                <button type="button" @click="confirmReturn = false" class="px-8 py-3.5 rounded-xl font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            <h3 class="text-xl font-bold text-gray-400">Aún no tienes compras entregadas</h3>
                            <p class="text-sm text-gray-400 mt-2">Agrega productos al carrito y finaliza tu compra.</p>
                            <a href="{{ route('inicio') }}" class="inline-block mt-6 px-6 py-3 bg-[#16a34a] text-white font-bold rounded-xl hover:bg-green-700 transition">Ir a comprar</a>
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
