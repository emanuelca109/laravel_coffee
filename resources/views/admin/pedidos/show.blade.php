<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pedido | Coffee.dat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        aside.fixed.left-0 { width: 16rem !important; }
        aside.fixed.left-0 img { height: 3rem !important; max-height: none !important; }
        header.fixed { left: 16rem !important; }
        .left-64 { left: 16rem !important; }
        .active-menu-item {
            background-color: rgba(255,255,255,.12) !important;
            color: white !important;
            border-left: 4px solid white !important;
            border-bottom: 2px solid transparent !important;
            padding-left: 10px !important;
            font-weight: 600 !important;
        }
    </style>
</head>

<body class="bg-gray-50 h-screen overflow-hidden">

    {{-- Sidebar --}}
    @include('layouts.sidebaradmin')

    {{-- Header --}}
    @include('layouts.headeradmin')

    <div class="fixed top-16 right-0 bottom-0 left-64 flex flex-col overflow-y-auto">
        <main class="p-6 space-y-6 min-w-0 flex-1">
            
            {{-- Cabecera --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('pedidos.index') }}" class="w-10 h-10 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-500 hover:text-slate-800 hover:bg-gray-50 transition-all">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-black text-slate-800 tracking-tight">Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</h1>
                        <p class="text-sm text-gray-500 font-medium">Realizado el {{ $pedido->created_at->format('d M, Y h:i A') }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    @if(session('success'))
                        <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-green-200">
                            <i class="fa-solid fa-check mr-1"></i> {{ session('success') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Columna Izquierda: Detalles e Info --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Tarjeta de Información --}}
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Información del Cliente y Envío</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $pedido->user->name ?? 'Cliente' }}</p>
                                        <p class="text-xs text-gray-500">{{ $pedido->user->email ?? 'Sin email' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="flex gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">Dirección de Entrega</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $pedido->direccion->direccion ?? 'Sin dirección' }}<br>
                                            {{ $pedido->direccion->ciudad ?? '' }}, {{ $pedido->direccion->estado ?? '' }}<br>
                                            Código Postal: {{ $pedido->direccion->codigo_postal ?? '' }}<br>
                                            Teléfono: {{ $pedido->direccion->telefono ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="flex gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0">
                                        <i class="fa-solid fa-truck"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">Transportadora</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            @if($pedido->informacionEnvio)
                                                {{ $pedido->informacionEnvio->transportadora }}<br>
                                                <span class="text-xs font-semibold text-blue-600">{{ $pedido->informacionEnvio->estado }}</span>
                                            @else
                                                Por asignar<br>
                                                <span class="text-xs font-semibold text-gray-400">Pendiente</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tarjeta de Productos --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Productos del Pedido</h3>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/50">
                                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Producto</th>
                                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Precio</th>
                                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Cantidad</th>
                                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($pedido->detalles as $detalle)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="p-4">
                                            <div class="flex items-center gap-3">
                                                @if($detalle->producto && $detalle->producto->imagen_url)
                                                    <img src="{{ asset('storage/' . $detalle->producto->imagen_url) }}" alt="{{ $detalle->producto->nombre }}" class="w-12 h-12 rounded-lg object-cover bg-gray-100">
                                                @else
                                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                                        <i class="fa-solid fa-image"></i>
                                                    </div>
                                                @endif
                                                <span class="font-bold text-slate-800">{{ $detalle->producto->nombre ?? 'Producto Desconocido' }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4 text-center font-medium text-gray-600">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                        <td class="p-4 text-center font-bold text-slate-800">{{ $detalle->cantidad }}</td>
                                        <td class="p-4 text-right font-black text-slate-800">${{ number_format($detalle->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="p-6 bg-slate-50/50 flex justify-end">
                            <div class="w-64 space-y-3">
                                <div class="flex justify-between text-sm font-bold text-slate-800">
                                    <span>Total del Pedido:</span>
                                    <span class="text-xl font-black text-slate-800">${{ number_format($pedido->total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-xs font-medium text-gray-500">
                                    <span>Método de Pago:</span>
                                    <span>{{ $pedido->pago->metodo_pago ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Columna Derecha: Estado --}}
                <div class="space-y-6">
                    
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Actualizar Estado</h3>
                        
                        <div class="mb-6 flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0
                                @if(in_array($pedido->estado, ['Pendiente', 'Activo'])) bg-amber-100 text-amber-600
                                @elseif($pedido->estado == 'En Proceso') bg-blue-100 text-blue-600
                                @elseif($pedido->estado == 'Enviado') bg-purple-100 text-purple-600
                                @elseif($pedido->estado == 'Entregado') bg-emerald-100 text-emerald-600
                                @else bg-gray-100 text-gray-600 @endif">
                                @if(in_array($pedido->estado, ['Pendiente', 'Activo'])) <i class="fa-solid fa-clock text-xl"></i>
                                @elseif($pedido->estado == 'En Proceso') <i class="fa-solid fa-gear text-xl"></i>
                                @elseif($pedido->estado == 'Enviado') <i class="fa-solid fa-truck-fast text-xl"></i>
                                @elseif($pedido->estado == 'Entregado') <i class="fa-solid fa-circle-check text-xl"></i>
                                @else <i class="fa-solid fa-question text-xl"></i> @endif
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Estado Actual</p>
                                <p class="text-lg font-black text-slate-800">{{ $pedido->estado === 'Activo' ? 'Pendiente' : $pedido->estado }}</p>
                            </div>
                        </div>

                        <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="estado" class="block text-sm font-bold text-slate-700 mb-2">Nuevo Estado</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="fa-solid fa-rotate"></i>
                                        </div>
                                        <select name="estado" id="estado" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 text-slate-800 rounded-xl focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition font-medium appearance-none">
                                            <option value="Pendiente" {{ in_array($pedido->estado, ['Pendiente', 'Activo']) ? 'selected' : '' }}>Pendiente</option>
                                            <option value="En Proceso" {{ $pedido->estado == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                                            <option value="Enviado" {{ $pedido->estado == 'Enviado' ? 'selected' : '' }}>Enviado</option>
                                            <option value="Entregado" {{ $pedido->estado == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-slate-800 text-white font-bold py-3 px-4 rounded-xl hover:bg-slate-700 transition flex items-center justify-center gap-2 shadow-sm">
                                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                    
                </div>

            </div>

        </main>

        {{-- Footer --}}
        @include('layouts.footer')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarLinks = document.querySelectorAll('aside nav a');
            sidebarLinks.forEach(link => {
                if (link.textContent.trim().includes('Pedidos')) {
                    link.classList.remove('text-white/85', 'border-transparent');
                    link.classList.add('active-menu-item');
                }
            });
        });
    </script>
</body>
</html>
