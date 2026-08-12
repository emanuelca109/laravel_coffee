<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devoluciones | Coffee.dat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        aside.fixed.left-0 { width: 16rem !important; }
        aside.fixed.left-0 img { height: 3rem !important; max-height: none !important; }
        header.fixed { left: 16rem !important; }
        .left-64 { left: 16rem !important; }
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
            width: 42px; height: 42px; border-radius: 10px; background: #fee2e2;
            display: flex; align-items: center; justify-content: center; color: #dc2626; font-size: 17px; flex-shrink: 0;
        }
        .modal-title { font-size: 19px; font-weight: 700; color: #222; margin: 0; }
        .modal-subtitle { font-size: 13px; color: #9aa4b5; margin-top: 2px; }
        .modal-close {
            width: 34px; height: 34px; border-radius: 9px; background: #f1f2f4; border: none;
            color: #444; font-size: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .modal-close:hover { background: #e2e8f0; }

        /* ===== Body ===== */
        .modal-body { padding: 20px 26px; overflow-y: auto; }

        .info-row { display: flex; gap: 18px; margin-bottom: 18px; }
        .info-box { flex: 1; background: #f7f8fa; border-radius: 12px; padding: 18px 20px; border: 1px solid #eef0f3; }
        .info-box-title { font-size: 11px; font-weight: 700; color: #9aa0a8; letter-spacing: 0.5px; margin-bottom: 12px; }
        .info-item { display: flex; justify-content: space-between; padding: 7px 0; font-size: 13.5px; }
        .info-item span:first-child { color: #6b7280; }
        .info-item span:last-child { color: #1a1a1a; font-weight: 700; }

        /* ===== Productos box ===== */
        .productos-box {
            background: #fff; border: 1px solid #eef0f3; border-radius: 12px; padding: 18px 22px;
            margin-bottom: 18px;
        }
        .productos-title { font-size: 11px; font-weight: 700; color: #475569; letter-spacing: 0.5px; margin-bottom: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;}
        .producto-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px dashed #e2e8f0; }
        .producto-item:last-child { border-bottom: none; }
        .producto-name { font-size: 14px; font-weight: 700; color: #1a1a1a; }
        .producto-qty { font-size: 13px; color: #64748b; font-weight: bold; background: #f1f5f9; padding: 2px 8px; border-radius: 6px; }

        /* ===== Motivo box ===== */
        .motivo-box {
            background: #fff5f5; border: 1px solid #fed7d7; border-radius: 12px; padding: 18px 22px;
        }
        .motivo-col-title { font-size: 11px; font-weight: 700; color: #c53030; letter-spacing: 0.5px; margin-bottom: 8px; }
        .motivo-texto { font-size: 14px; font-weight: 500; color: #2d3748; font-style: italic;}

        /* ===== Footer cambiar estado ===== */
        .modal-footer {
            display: flex; align-items: center; justify-content: flex-end; gap: 14px; padding: 18px 26px;
            border-top: 1px solid #eef0f3; background: #f8f9fb; flex-shrink: 0;
        }
        
        .btn-aprobar {
            background: #16a34a; color: #fff; border: none; padding: 11px 26px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;
        }
        .btn-aprobar:hover { background: #15803d; }
        
        .btn-rechazar {
            background: #ef4444; color: #fff; border: none; padding: 11px 26px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;
        }
        .btn-rechazar:hover { background: #dc2626; }
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
                
                {{-- TODAS --}}
                <a href="{{ route('devoluciones.index') }}" class="bg-white rounded-[1.25rem] p-4 shadow-sm border {{ empty($estado) ? 'border-gray-300 ring-2 ring-gray-100 shadow-md' : 'border-gray-100 hover:border-gray-200 hover:shadow-md' }} w-48 flex items-center gap-3 transition-all cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-600 shadow-inner shrink-0">
                        <i class="fa-solid fa-list-ul text-xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest leading-none mb-1">Total</h3>
                        <p class="text-2xl font-black text-slate-800 leading-none">{{ ($pendientes ?? 0) + ($aprobadas ?? 0) + ($rechazadas ?? 0) }}</p>
                    </div>
                </a>

                {{-- PENDIENTES --}}
                <a href="{{ route('devoluciones.index', ['estado' => 'PENDIENTE']) }}" class="bg-white rounded-[1.25rem] p-4 shadow-sm border {{ ($estado ?? '') === 'PENDIENTE' ? 'border-amber-400 ring-4 ring-amber-100 shadow-lg' : 'border-gray-100 hover:border-amber-200 hover:shadow-md' }} w-48 flex items-center gap-3 transition-all cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-inner shrink-0">
                        <i class="fa-solid fa-clock text-xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest leading-none mb-1">Pendientes</h3>
                        <p class="text-2xl font-black text-slate-800 leading-none">{{ $pendientes ?? 0 }}</p>
                    </div>
                </a>

                {{-- APROBADAS --}}
                <a href="{{ route('devoluciones.index', ['estado' => 'APROBADA']) }}" class="bg-white rounded-[1.25rem] p-4 shadow-sm border {{ ($estado ?? '') === 'APROBADA' ? 'border-emerald-400 ring-4 ring-emerald-100 shadow-lg' : 'border-gray-100 hover:border-emerald-200 hover:shadow-md' }} w-48 flex items-center gap-3 transition-all cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest leading-none mb-1">Aprobadas</h3>
                        <p class="text-2xl font-black text-slate-800 leading-none">{{ $aprobadas ?? 0 }}</p>
                    </div>
                </a>

                {{-- RECHAZADAS --}}
                <a href="{{ route('devoluciones.index', ['estado' => 'RECHAZADA']) }}" class="bg-white rounded-[1.25rem] p-4 shadow-sm border {{ ($estado ?? '') === 'RECHAZADA' ? 'border-red-400 ring-4 ring-red-100 shadow-lg' : 'border-gray-100 hover:border-red-200 hover:shadow-md' }} w-48 flex items-center gap-3 transition-all cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-600 shadow-inner shrink-0">
                        <i class="fa-solid fa-circle-xmark text-xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest leading-none mb-1">Rechazadas</h3>
                        <p class="text-2xl font-black text-slate-800 leading-none">{{ $rechazadas ?? 0 }}</p>
                    </div>
                </a>
            </div>

            {{-- Tabla de Solicitudes --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mt-6">
                
                {{-- Header de la tabla --}}
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-arrow-rotate-left text-slate-600 text-xl"></i>
                        <h3 class="text-lg font-bold text-slate-800">
                            {{ empty($estado) ? 'Todas las Solicitudes' : 'Solicitudes: ' . $estado }}
                        </h3>
                    </div>
                    @if(!empty($estado))
                    <a href="{{ route('devoluciones.index') }}" class="text-gray-400 hover:text-gray-600 text-sm font-medium transition cursor-pointer">
                        <i class="fa-solid fa-xmark mr-1"></i> Limpiar filtro
                    </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-y border-gray-100 text-gray-400">
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider w-24">ID</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider">Pedido</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider">Cliente</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-center w-36">Fecha Solicitud</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-center w-36">Estado</th>
                                    <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-center w-28">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($devoluciones as $dev)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-gray-500">
                                            #{{ $dev->id }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-800">
                                            Pedido #{{ $dev->pedido->numero_pedido ?? $dev->pedido_id }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-800">
                                            {{ $dev->user->name ?? 'Cliente Desconocido' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center text-gray-500 text-sm font-medium">
                                        {{ $dev->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @php
                                            $statusClass = 'bg-gray-100 text-gray-700';
                                            if($dev->estado === 'PENDIENTE') $statusClass = 'bg-amber-100 text-amber-600';
                                            if($dev->estado === 'APROBADA') $statusClass = 'bg-emerald-100 text-emerald-600';
                                            if($dev->estado === 'RECHAZADA') $statusClass = 'bg-red-100 text-red-600';
                                        @endphp
                                        <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-bold rounded-full {{ $statusClass }}">
                                            {{ $dev->estado }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                          <button type="button" onclick="document.getElementById('modal-dev-{{ $dev->id }}').style.display='flex'"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors"
                                           title="Ver detalles">
                                            <i class="fa-solid fa-eye text-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center gap-2">
                                            <i class="fa-solid fa-box-open text-4xl"></i>
                                            <p class="font-medium">No hay solicitudes de devolución</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $devoluciones->links() }}

            </main>

            {{-- Footer --}}
            @include('layouts.footer')
        </div>

        {{-- Modales de Detalle de Devolución --}}
    @foreach($devoluciones as $dev)
    <div id="modal-dev-{{ $dev->id }}" class="modal-overlay" style="display: none;">
        <div class="modal-box">

            <!-- Header -->
            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="modal-icon"><i class="fa-solid fa-arrow-rotate-left"></i></div>
                    <div>
                        <p class="modal-title">Solicitud de Devolución #{{ $dev->id }}</p>
                        <div class="modal-subtitle">Solicitada el {{ $dev->created_at->isoFormat('D \d\e MMMM \d\e Y') }}</div>
                    </div>
                </div>
                <button type="button" class="modal-close" onclick="document.getElementById('modal-dev-{{ $dev->id }}').style.display='none'"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                
                <div class="info-row">
                    <div class="info-box">
                        <div class="info-box-title">DATOS DEL PEDIDO ORIGINAL</div>
                        <div class="info-item"><span>N° Pedido</span><span>#{{ $dev->pedido->numero_pedido ?? $dev->pedido_id }}</span></div>
                        <div class="info-item"><span>Total Compra</span><span>${{ number_format($dev->pedido->total ?? 0, 2) }}</span></div>
                        <div class="info-item"><span>Método Pago</span><span class="lowercase">{{ $dev->pedido->pago->metodo_pago ?? 'N/A' }}</span></div>
                    </div>

                    <div class="info-box">
                        <div class="info-box-title">DATOS DEL CLIENTE</div>
                        <div class="info-item"><span>Nombre</span><span>{{ $dev->user->name ?? 'N/A' }}</span></div>
                        <div class="info-item"><span>Correo</span><span class="truncate max-w-[150px]">{{ $dev->user->email ?? 'N/A' }}</span></div>
                        <div class="info-item"><span>Teléfono</span><span>{{ $dev->user->telefono ?? $dev->pedido->direccion->telefono ?? 'N/A' }}</span></div>
                    </div>
                </div>

                <!-- Productos Devueltos -->
                <div class="productos-box">
                    <div class="productos-title">PRODUCTOS A DEVOLVER</div>
                    @if(is_array($dev->productos) && count($dev->productos) > 0)
                        @foreach($dev->productos as $prod)
                            @php
                                $productoModel = \App\Models\Producto::find($prod['producto_id']);
                            @endphp
                            <div class="producto-item">
                                <span class="producto-name">{{ $productoModel ? $productoModel->nombre : 'Producto #'.$prod['producto_id'] }}</span>
                                <span class="producto-qty">Cant: {{ $prod['cantidad'] }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-sm text-gray-500 italic py-2">No se especificaron productos.</div>
                    @endif
                </div>

                <!-- Motivo -->
                <div class="motivo-box">
                    <div class="motivo-col-title">MOTIVO DE LA DEVOLUCIÓN</div>
                    <div class="motivo-texto">"{{ $dev->motivo }}"</div>
                </div>

            </div>

            <!-- Footer (Solo si está PENDIENTE) -->
            @if($dev->estado === 'PENDIENTE')
            <div class="modal-footer">
                
                {{-- Botones principales --}}
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('modal-rechazo-{{ $dev->id }}').style.display='flex'" class="btn-rechazar">
                        <i class="fa-solid fa-xmark"></i> Rechazar
                    </button>
                    <button type="button" onclick="document.getElementById('modal-aprobar-{{ $dev->id }}').style.display='flex'" class="btn-aprobar">
                        <i class="fa-solid fa-check"></i> Aprobar
                    </button>
                </div>

                {{-- Modal Confirmar Rechazo --}}
                <div id="modal-rechazo-{{ $dev->id }}" style="display: none;" class="modal-overlay z-[2000]">
                    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" onclick="document.getElementById('modal-rechazo-{{ $dev->id }}').style.display='none'"></div>
                    <div class="relative bg-white rounded-2xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-slate-100 w-[320px] p-6 text-center z-10 flex flex-col items-center overflow-hidden">
                        
                        {{-- Fondo sutil decorativo --}}
                        <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-b from-red-50/50 to-transparent -z-10"></div>
                        
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center text-red-500 mb-4 ring-4 ring-white shadow-sm">
                            <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-1.5 tracking-tight">¿Rechazar Devolución?</h3>
                        <p class="text-slate-500 mb-6 text-[13px] leading-relaxed">El pedido será marcado como entregado y el cliente no recibirá el reembolso.</p>
                        
                        <form action="{{ route('devoluciones.update', $dev->id) }}" method="POST" class="w-full flex gap-3">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="estado" value="RECHAZADA">
                            <button type="button" onclick="document.getElementById('modal-rechazo-{{ $dev->id }}').style.display='none'" class="flex-1 px-3 py-2.5 rounded-xl font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-colors text-sm shadow-sm">
                                Cancelar
                            </button>
                            <button type="submit" class="flex-1 px-3 py-2.5 rounded-xl font-semibold text-white bg-red-500 hover:bg-red-600 transition-all text-sm shadow-md shadow-red-500/20">
                                Rechazar
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Modal Confirmar Aprobación --}}
                <div id="modal-aprobar-{{ $dev->id }}" style="display: none;" class="modal-overlay z-[2000]">
                    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" onclick="document.getElementById('modal-aprobar-{{ $dev->id }}').style.display='none'"></div>
                    <div class="relative bg-white rounded-2xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-slate-100 w-[320px] p-6 text-center z-10 flex flex-col items-center overflow-hidden">
                        
                        {{-- Fondo sutil decorativo --}}
                        <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-b from-emerald-50/50 to-transparent -z-10"></div>
                        
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center text-emerald-600 mb-4 ring-4 ring-white shadow-sm">
                            <i class="fa-solid fa-check text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-1.5 tracking-tight">¿Aprobar Devolución?</h3>
                        <p class="text-slate-500 mb-6 text-[13px] leading-relaxed">El cliente será notificado y el pedido pasará oficialmente a devolución.</p>
                        
                        <form action="{{ route('devoluciones.update', $dev->id) }}" method="POST" class="w-full flex gap-3">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="estado" value="APROBADA">
                            <button type="button" onclick="document.getElementById('modal-aprobar-{{ $dev->id }}').style.display='none'" class="flex-1 px-3 py-2.5 rounded-xl font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-colors text-sm shadow-sm">
                                Cancelar
                            </button>
                            <button type="submit" class="flex-1 px-3 py-2.5 rounded-xl font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition-all text-sm shadow-md shadow-emerald-600/20">
                                Aprobar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
    @endforeach

</body>
</html>
