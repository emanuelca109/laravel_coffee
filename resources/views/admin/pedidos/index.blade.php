<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos | Coffee.dat</title>

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
        /* ===== Overlay ===== */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(15, 18, 25, 0.55);
            display: flex; align-items: center; justify-content: center; z-index: 999;
        }

        /* ===== Modal ===== */
        .modal-box {
            background: #fff; border-radius: 18px; width: 100%; max-width: 780px;
            overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.35); max-height: 90vh; display: flex; flex-direction: column;
        }

        /* ===== Header claro ===== */
        .modal-header {
            background: #fff; border-bottom: 1px solid #f0f1f3;
            padding: 22px 26px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;
        }
        .modal-header-left { display: flex; align-items: center; gap: 14px; }
        .modal-icon {
            width: 42px; height: 42px; border-radius: 10px; background: #d9f3e2;
            display: flex; align-items: center; justify-content: center; color: #1e8e4c; font-size: 17px; flex-shrink: 0;
        }
        .modal-title { font-size: 19px; font-weight: 700; color: #222; margin: 0; }
        .modal-subtitle { font-size: 13px; color: #9aa4b5; margin-top: 2px; }
        .modal-close {
            width: 34px; height: 34px; border-radius: 9px; background: #f1f2f4; border: none;
            color: #444; font-size: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .modal-close:hover { background: #e2e8f0; }

        /* ===== Stepper de estados ===== */
        .stepper {
            display: flex; align-items: center; padding: 22px 40px 18px; background: #fff; flex-shrink: 0;
        }
        .step { display: flex; flex-direction: column; align-items: center; gap: 8px; flex: 0 0 auto; }
        .step-circle {
            width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: 13px; border: 2px solid #dfe3e8; background: #fff; color: #b7bcc4;
        }
        .step.activo .step-circle {
            background: #1e8e4c; border-color: #1e8e4c; color: #fff; box-shadow: 0 0 0 5px #d9f3e2;
        }
        .step-label { font-size: 12px; font-weight: 700; color: #b7bcc4; }
        .step.activo .step-label { color: #1e8e4c; }
        .step-line { flex: 1; height: 2px; background: #e4e7ec; margin: 0 4px; margin-bottom: 26px; }

        /* ===== Body ===== */
        .modal-body { padding: 0 26px 20px; overflow-y: auto; }

        .info-row { display: flex; gap: 18px; margin-bottom: 18px; }
        .info-box { flex: 1; background: #f7f8fa; border-radius: 12px; padding: 18px 20px; border: 1px solid #eef0f3; }
        .info-box-title { font-size: 11px; font-weight: 700; color: #9aa0a8; letter-spacing: 0.5px; margin-bottom: 12px; }
        .info-item { display: flex; justify-content: space-between; padding: 7px 0; font-size: 13.5px; }
        .info-item span:first-child { color: #6b7280; }
        .info-item span:last-child { color: #1a1a1a; font-weight: 700; }

        .badge-pendiente { background: #fdf1d6; color: #b9821b; padding: 3px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; }

        /* ===== Dirección de envío ===== */
        .envio-box {
            background: #eafaf0; border: 1px solid #cdefda; border-radius: 12px; padding: 18px 22px;
            display: flex; justify-content: space-between; gap: 14px; flex-wrap: wrap;
        }
        .envio-col-title { font-size: 11px; font-weight: 700; color: #1e8e4c; letter-spacing: 0.5px; margin-bottom: 8px; }
        .envio-direccion { font-size: 14px; font-weight: 700; color: #1a1a1a; }
        .envio-ciudad { font-size: 13px; color: #6b7280; margin-top: 2px; }
        .envio-valor { font-size: 13.5px; font-weight: 700; color: #1a1a1a; }

        /* ===== Footer cambiar estado ===== */
        .modal-footer {
            display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 18px 26px;
            border-top: 1px solid #eef0f3; background: #f8f9fb; flex-shrink: 0;
        }
        .footer-left { display: flex; align-items: center; gap: 14px; }
        .footer-label { font-size: 12px; font-weight: 700; color: #6b7280; letter-spacing: 0.3px; text-transform: uppercase; }
        .footer-select {
            width: 180px; padding: 10px 14px; border-radius: 8px; border: 1px solid #dfe3e8; font-size: 13px; font-weight: 700; color: #333; background: #fff;
            appearance: none;
        }
        .footer-btn {
            background: #1e8e4c; color: #fff; border: none; padding: 11px 26px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;
        }
        .footer-btn:hover { background: #197a41; }
    </style>
</head>

<body class="bg-gray-50 h-screen overflow-hidden">

    {{-- Sidebar --}}
    @include('layouts.sidebaradmin')

    {{-- Header --}}
    @include('layouts.headeradmin')

    <div class="fixed top-16 right-0 bottom-0 left-64 flex flex-col overflow-y-auto">
        <main class="p-6 space-y-6 min-w-0 flex-1">

            {{-- Tarjetas de Estadísticas --}}
            <div class="flex flex-wrap items-center justify-start gap-4 lg:gap-5">
                {{-- TOTAL --}}
                <a href="{{ route('pedidos.index') }}" class="bg-white rounded-[1.25rem] p-4 shadow-sm border {{ empty($filtroActual) ? 'border-gray-300 ring-2 ring-gray-100 shadow-md' : 'border-gray-100 hover:border-gray-200 hover:shadow-md' }} w-48 flex items-center gap-3 transition-all cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-600 shadow-inner shrink-0">
                        <i class="fa-solid fa-list-ul text-xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest leading-none mb-1">Total</h3>
                        <p class="text-2xl font-black text-slate-800 leading-none">{{ $total ?? 0 }}</p>
                    </div>
                </a>

                {{-- PENDIENTES --}}
                <a href="{{ route('pedidos.index', ['estado' => 'Pendiente']) }}" class="bg-white rounded-[1.25rem] p-4 shadow-sm border {{ ($filtroActual ?? '') === 'Pendiente' ? 'border-amber-300 ring-2 ring-amber-50 shadow-md' : 'border-gray-100 hover:border-amber-200 hover:shadow-md' }} w-48 flex items-center gap-3 transition-all cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-inner shrink-0">
                        <i class="fa-solid fa-clock text-xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest leading-none mb-1">Pendientes</h3>
                        <p class="text-2xl font-black text-slate-800 leading-none">{{ $pendientes ?? 0 }}</p>
                    </div>
                </a>

                {{-- EN PROCESO --}}
                <a href="{{ route('pedidos.index', ['estado' => 'En Proceso']) }}" class="bg-white rounded-[1.25rem] p-4 shadow-sm border {{ ($filtroActual ?? '') === 'En Proceso' ? 'border-blue-300 ring-2 ring-blue-50 shadow-md' : 'border-gray-100 hover:border-blue-200 hover:shadow-md' }} w-48 flex items-center gap-3 transition-all cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-inner shrink-0">
                        <i class="fa-solid fa-gear text-xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest leading-none mb-1">En Proceso</h3>
                        <p class="text-2xl font-black text-slate-800 leading-none">{{ $enProceso ?? 0 }}</p>
                    </div>
                </a>

                {{-- ENVIADOS --}}
                <a href="{{ route('pedidos.index', ['estado' => 'Enviado']) }}" class="bg-white rounded-[1.25rem] p-4 shadow-sm border {{ ($filtroActual ?? '') === 'Enviado' ? 'border-purple-300 ring-2 ring-purple-50 shadow-md' : 'border-gray-100 hover:border-purple-200 hover:shadow-md' }} w-48 flex items-center gap-3 transition-all cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 shadow-inner shrink-0">
                        <i class="fa-solid fa-truck-fast text-xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest leading-none mb-1">Enviados</h3>
                        <p class="text-2xl font-black text-slate-800 leading-none">{{ $enviados ?? 0 }}</p>
                    </div>
                </a>

                {{-- ENTREGADOS --}}
                <a href="{{ route('pedidos.index', ['estado' => 'Entregado']) }}" class="bg-white rounded-[1.25rem] p-4 shadow-sm border {{ ($filtroActual ?? '') === 'Entregado' ? 'border-emerald-300 ring-2 ring-emerald-50 shadow-md' : 'border-gray-100 hover:border-emerald-200 hover:shadow-md' }} w-48 flex items-center gap-3 transition-all cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest leading-none mb-1">Entregados</h3>
                        <p class="text-2xl font-black text-slate-800 leading-none">{{ $entregados ?? 0 }}</p>
                    </div>
                </a>
            </div>

            {{-- Tabla de Pedidos --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mt-6">
                
                {{-- Header de la tabla --}}
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-clipboard-list text-green-600 text-xl"></i>
                        <h3 class="text-lg font-bold text-slate-800">
                            {{ empty($filtroActual) ? 'Todos los Pedidos' : 'Pedidos: ' . $filtroActual }}
                        </h3>
                    </div>
                    @if(!empty($filtroActual))
                    <a href="{{ route('pedidos.index') }}" class="text-gray-400 hover:text-gray-600 text-sm font-medium transition cursor-pointer">
                        <i class="fa-solid fa-xmark mr-1"></i> Limpiar filtro
                    </a>
                    @else
                    <span class="text-transparent text-sm font-medium select-none">
                        <i class="fa-solid fa-xmark mr-1"></i> Limpiar filtro
                    </span>
                    @endif
                </div>

                <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-y border-gray-100 text-gray-400">
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider w-24">N° Pedido</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider">Cliente</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-center w-32">Fecha</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-center w-28">Productos</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider w-36">Total</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-center w-36">Estado</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-center w-28">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($pedidos as $pedido)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-gray-500">
                                            #{{ $pedido->id }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-800">
                                            {{ $pedido->user->name ?? 'Cliente Desconocido' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center text-gray-500 text-sm">
                                        {{ $pedido->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="font-bold text-gray-700">
                                            {{ $pedido->numero_productos ?? $pedido->detalles->sum('cantidad') ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-800">
                                            ${{ number_format($pedido->total, 2, '.', ',') }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @php
                                            // Colors according to status
                                            $statusClass = 'bg-gray-100 text-gray-700'; // default
                                            if(in_array($pedido->estado, ['Activo', 'Pendiente'])) {
                                                $statusClass = 'bg-amber-100 text-amber-600';
                                            } elseif($pedido->estado === 'En Proceso') {
                                                $statusClass = 'bg-blue-100 text-blue-600';
                                            } elseif($pedido->estado === 'Enviado') {
                                                $statusClass = 'bg-purple-100 text-purple-600';
                                            } elseif($pedido->estado === 'Entregado') {
                                                $statusClass = 'bg-green-100 text-green-700';
                                            }
                                            $displayEstado = $pedido->estado === 'Activo' ? 'Pendiente' : $pedido->estado;
                                        @endphp
                                        <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-bold rounded-full {{ $statusClass }}">
                                            {{ $displayEstado }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                          <button type="button" onclick="document.getElementById('modal-pedido-{{ $pedido->id }}').style.display='flex'"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors"
                                           title="Ver detalles">
                                            <i class="fa-solid fa-eye text-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center gap-2">
                                            <i class="fa-solid fa-clipboard text-4xl"></i>
                                            <p class="font-medium">No hay pedidos registrados</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $pedidos->links() }}
                    </div>
                </div>

            </main>

            {{-- Footer --}}
            @include('layouts.footer')
        </div>

                {{-- Modales de Detalle de Pedido --}}
    @foreach($pedidos as $pedido)
    <div id="modal-pedido-{{ $pedido->id }}" class="modal-overlay" style="display: none;">
        <div class="modal-box">

            <!-- Header -->
            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="modal-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                    <div>
                        <p class="modal-title">Detalle de Pedido #{{ $pedido->id }}</p>
                        <div class="modal-subtitle">Pedido del {{ $pedido->created_at->isoFormat('D \d\e MMMM \d\e Y') }}</div>
                    </div>
                </div>
                <button type="button" class="modal-close" onclick="document.getElementById('modal-pedido-{{ $pedido->id }}').style.display='none'"><i class="fa-solid fa-xmark"></i></button>
            </div>

            @php
                $estados = ['Pendiente', 'En proceso', 'Enviado', 'Entregado'];
                $estadoDb = $pedido->estado === 'Activo' ? 'Pendiente' : $pedido->estado;
                
                // Normalizar
                $estadoActual = 'Pendiente';
                if (strtolower($estadoDb) == 'en proceso') $estadoActual = 'En proceso';
                if (strtolower($estadoDb) == 'enviado') $estadoActual = 'Enviado';
                if (strtolower($estadoDb) == 'entregado') $estadoActual = 'Entregado';

                $currentIndex = array_search($estadoActual, $estados);
                if ($currentIndex === false) $currentIndex = 0;
            @endphp

            <!-- Stepper -->
            <div class="stepper">
                @foreach($estados as $index => $estadoItem)
                    @php
                        $isCompleted = $index <= $currentIndex;
                        
                        $icon = '';
                        if ($estadoItem == 'Pendiente') $icon = 'fa-circle';
                        if ($estadoItem == 'En proceso') $icon = 'fa-gear';
                        if ($estadoItem == 'Enviado') $icon = 'fa-truck-fast';
                        if ($estadoItem == 'Entregado') $icon = 'fa-check';
                        
                        $stepClass = $isCompleted ? 'step activo' : 'step';
                        $iconStyle = $estadoItem == 'Pendiente' ? 'font-size:9px;' : '';
                    @endphp
                    <div class="{{ $stepClass }}">
                        <div class="step-circle"><i class="fa-solid {{ $icon }}" style="{{ $iconStyle }}"></i></div>
                        <div class="step-label">{{ $estadoItem }}</div>
                    </div>
                    @if(!$loop->last)
                        <div class="step-line" style="{{ $isCompleted && $index < $currentIndex ? 'background: #1e8e4c;' : '' }}"></div>
                    @endif
                @endforeach
            </div>

            <!-- Body -->
            <div class="modal-body">

                <div class="info-row">
                    <div class="info-box">
                        <div class="info-box-title">DATOS DEL PEDIDO</div>
                        <div class="info-item"><span>N° Pedido</span><span>#{{ $pedido->id }}</span></div>
                        <div class="info-item"><span>Fecha</span><span>{{ $pedido->created_at->isoFormat('D \d\e MMM \d\e Y') }}</span></div>
                        <div class="info-item"><span>Productos</span><span>{{ $pedido->numero_productos ?? $pedido->detalles->sum('cantidad') ?? 1 }}</span></div>
                        <div class="info-item">
                            <span>Estado</span>
                            <span class="badge-pendiente" style="{{ $estadoActual == 'Entregado' ? 'background: #d9f3e2; color: #1e8e4c;' : ($estadoActual == 'Enviado' ? 'background: #dbe6fb; color: #3763e0;' : '') }}">{{ $estadoActual }}</span>
                        </div>
                        <div class="info-item"><span>Método pago</span><span class="lowercase">{{ $pedido->pago->metodo_pago ?? 'efectivo' }}</span></div>
                        <div class="info-item"><span>Factura</span><span>FAC-{{ strtoupper(substr(md5($pedido->id), 0, 14)) }}</span></div>
                    </div>

                    <div class="info-box">
                        <div class="info-box-title">CLIENTE</div>
                        <div class="info-item"><span>Nombre</span><span>{{ $pedido->user->name ?? 'N/A' }}</span></div>
                        <div class="info-item"><span>Correo</span><span class="truncate max-w-[150px]">{{ $pedido->user->email ?? 'N/A' }}</span></div>
                        <div class="info-item"><span>Teléfono</span><span>{{ $pedido->direccion->telefono ?? 'N/A' }}</span></div>
                        <div class="info-item"><span>Documento</span><span>{{ $pedido->user->documento ?? '1066228899' }}</span></div>
                    </div>
                </div>

                <div class="envio-box">
                    <div>
                        <div class="envio-col-title">DIRECCIÓN DE ENVÍO</div>
                        <div class="envio-direccion">{{ $pedido->direccion->direccion ?? 'Sin dirección' }}</div>
                        <div class="envio-ciudad">{{ $pedido->direccion->ciudad ?? '' }}</div>
                    </div>
                    <div>
                        <div class="envio-col-title">FECHA ENVÍO</div>
                        <div class="envio-valor">
                            {{ $pedido->informacionEnvio && $pedido->informacionEnvio->fecha_envio 
                                ? \Carbon\Carbon::parse($pedido->informacionEnvio->fecha_envio)->isoFormat('D \d\e MMM \d\e Y') 
                                : $pedido->created_at->isoFormat('D \d\e MMM \d\e Y') 
                            }}
                        </div>
                    </div>
                    <div>
                        <div class="envio-col-title">TRANSPORTADORA</div>
                        <div class="envio-valor">{{ $pedido->informacionEnvio->transportadora ?? 'Por asignar' }}</div>
                    </div>
                </div>



            </div>

            <!-- Footer -->
            <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" class="modal-footer">
                @csrf
                @method('PUT')
                <div class="footer-left">
                    <span class="footer-label">CAMBIAR ESTADO:</span>
                    <div style="position: relative; display: inline-block;">
                        <select name="estado" class="footer-select" style="appearance: none; -webkit-appearance: none; padding-right: 32px; cursor: pointer;">
                            <option value="Pendiente" {{ $estadoActual == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="En Proceso" {{ $estadoActual == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                            <option value="Enviado" {{ $estadoActual == 'Enviado' ? 'selected' : '' }}>Enviado</option>
                            <option value="Entregado" {{ $estadoActual == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #6b7280; pointer-events: none; font-size: 12px;"></i>
                    </div>
                </div>
                <button type="submit" class="footer-btn"><i class="fa-solid fa-check"></i> Guardar</button>
            </form>

        </div>
    </div>
    @endforeach

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
