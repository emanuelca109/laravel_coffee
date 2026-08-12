<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Ventas | Coffee.dat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Estilos del Admin base */
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

        /* ===== Estilos del Dashboard de Ventas (Del Usuario) ===== */
        .ventas-container * { box-sizing: border-box; }
        .ventas-container {
            padding: 24px;
            background: #f0f2f5;
            font-family: 'Segoe UI', Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        /* Filtro de periodo */
        .filtro-bar {
            background: #fff;
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .filtro-btn {
            border: none;
            background: #f1f2f4;
            color: #444;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .filtro-btn:hover { background: #e2e8f0; }
        .filtro-btn.activo { background: #1e8e4c; color: #fff; }

        /* Tarjetas resumen */
        .cards-row { display: flex; gap: 18px; margin-bottom: 20px; flex-wrap: wrap; }
        .card {
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            flex: 1;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            min-width: 200px;
        }
        .card-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .icon-verde { background: #d9f3e2; color: #1e8e4c; }
        .icon-azul { background: #dbe6fb; color: #3763e0; }
        .icon-naranja { background: #fbe4d1; color: #e07a2b; }

        .card-label { font-size: 11px; font-weight: 700; color: #8a8f98; letter-spacing: 0.5px; margin-bottom: 4px; }
        .card-value { font-size: 24px; font-weight: 700; color: #1a1a1a; }
        .card-sub { font-size: 11px; color: #9aa0a8; margin-top: 2px; }

        .card-ganancia { background: linear-gradient(135deg, #1e8e4c, #197a41); color: #fff; }
        .card-ganancia .card-icon { background: rgba(255,255,255,0.2); color: #fff; }
        .card-ganancia .card-label { color: rgba(255,255,255,0.85); }
        .card-ganancia .card-value { color: #fff; }
        .card-ganancia .card-sub { color: rgba(255,255,255,0.85); }

        /* Distribución de ingresos */
        .distribucion-box {
            background: #fff;
            border-radius: 14px;
            padding: 20px 22px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .distribucion-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
        .distribucion-title { font-size: 12px; font-weight: 700; color: #444; letter-spacing: 0.5px; }
        .distribucion-total { font-size: 12px; color: #9aa0a8; }
        .barra {
            display: flex;
            height: 34px;
            border-radius: 8px;
            overflow: hidden;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            background: #f0f1f3;
        }
        .barra-costo { background: #f0923d; display: flex; align-items: center; justify-content: center; }
        .barra-ganancia { background: #34c471; display: flex; align-items: center; justify-content: center; }
        .leyenda { display: flex; gap: 24px; margin-top: 12px; font-size: 13px; color: #555; }
        .leyenda-item { display: flex; align-items: center; gap: 6px; }
        .dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; }
        .dot-naranja { background: #f0923d; }
        .dot-verde { background: #34c471; }
        .leyenda b.naranja { color: #f0923d; }
        .leyenda b.verde { color: #1e8e4c; }

        /* Registro de ventas */
        .registro-box {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            overflow: hidden;
        }
        .registro-header { display: flex; justify-content: space-between; align-items: center; padding: 18px 22px; }
        .registro-title { font-size: 15px; font-weight: 700; color: #222; display: flex; align-items: center; gap: 10px; }
        .registro-title i { color: #e07a2b; }
        .registro-tabla-note { font-size: 12px; color: #b5b9bf; }
        
        .ventas-container table { width: 100%; border-collapse: collapse; }
        .ventas-container thead tr { background: #f8f9fa; border-top: 1px solid #f0f1f3; border-bottom: 1px solid #f0f1f3; }
        .ventas-container thead th { color: #8a8f98; text-align: left; padding: 12px 22px; font-size: 11px; font-weight: 700; letter-spacing: 0.4px; }
        .ventas-container tbody td { padding: 14px 22px; font-size: 13px; color: #333; border-bottom: 1px solid #f0f1f3; }
        .ventas-container tbody tr:last-child td { border-bottom: none; }
        
        .venta-num { color: #444; font-weight: 600; }
        .cliente { font-weight: 700; color: #222; }
        .fecha { color: #9aa0a8; }
        .costo-compra { color: #e07a2b; font-weight: 700; }
        .precio-venta { color: #3763e0; font-weight: 700; }
        .ganancia { color: #1e8e4c; font-weight: 700; }
        .margen-badge { background: #d9f3e2; color: #1e8e4c; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; }
        
        .accion-btn {
            width: 30px; height: 30px; border-radius: 8px; background: #eaf0fe;
            color: #3763e0; border: none; display: flex; align-items: center; justify-content: center;
            cursor: pointer; text-decoration: none; transition: background 0.2s;
        }
        .accion-btn:hover { background: #dbe6fb; }
    </style>
</head>
<body class="bg-gray-50 h-screen overflow-hidden">
    {{-- Sidebar --}}
    @include('layouts.sidebaradmin')

    {{-- Header --}}
    @include('layouts.headeradmin')

    <div class="fixed top-16 right-0 bottom-0 left-64 flex flex-col overflow-y-auto bg-[#f0f2f5]">
        
        <div class="ventas-container">

            <!-- Filtro de periodo -->
            <div class="filtro-bar">
                <a href="{{ route('ventas.index', ['filtro' => 'hoy']) }}" class="filtro-btn {{ $filtro == 'hoy' ? 'activo' : '' }}"><i class="fa-regular fa-calendar-check"></i> Hoy</a>
                <a href="{{ route('ventas.index', ['filtro' => 'semana']) }}" class="filtro-btn {{ $filtro == 'semana' ? 'activo' : '' }}"><i class="fa-regular fa-calendar"></i> Semana</a>
                <a href="{{ route('ventas.index', ['filtro' => 'mes']) }}" class="filtro-btn {{ $filtro == 'mes' ? 'activo' : '' }}"><i class="fa-regular fa-calendar-days"></i> Mes</a>
                <a href="{{ route('ventas.index', ['filtro' => 'ano']) }}" class="filtro-btn {{ $filtro == 'ano' ? 'activo' : '' }}"><i class="fa-regular fa-calendar-alt"></i> Año</a>
                <a href="{{ route('ventas.index', ['filtro' => 'todo']) }}" class="filtro-btn {{ $filtro == 'todo' ? 'activo' : '' }}"><i class="fa-solid fa-list"></i> Todo</a>
            </div>

            <!-- Tarjetas resumen -->
            <div class="cards-row">
                <div class="card">
                    <div class="card-icon icon-verde"><i class="fa-solid fa-check"></i></div>
                    <div>
                        <div class="card-label">VENTAS COMPLETADAS</div>
                        <div class="card-value">{{ $ventasCompletadas }}</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-icon icon-azul"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div>
                        <div class="card-label">INGRESOS TOTALES</div>
                        <div class="card-value">${{ number_format($ingresosTotales, 2) }}</div>
                        <div class="card-sub">Precio de venta acumulado</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-icon icon-naranja"><i class="fa-solid fa-boxes-stacked"></i></div>
                    <div>
                        <div class="card-label">COSTO TOTAL</div>
                        <div class="card-value">${{ number_format($costoTotal, 2) }}</div>
                        <div class="card-sub">Precio de compra acumulado</div>
                    </div>
                </div>

                <div class="card card-ganancia">
                    <div class="card-icon"><i class="fa-solid fa-chart-line"></i></div>
                    <div>
                        <div class="card-label">GANANCIA NETA</div>
                        <div class="card-value">${{ number_format($gananciaNeta, 2) }}</div>
                        <div class="card-sub">Margen: {{ number_format($margenTotal, 1) }}%</div>
                    </div>
                </div>
            </div>

            <!-- Distribución de ingresos -->
            <div class="distribucion-box">
                <div class="distribucion-header">
                    <div class="distribucion-title">DISTRIBUCIÃ“N DE INGRESOS</div>
                    <div class="distribucion-total">Total: ${{ number_format($ingresosTotales, 2) }}</div>
                </div>
                <div class="barra">
                    @if($ingresosTotales > 0)
                        <div class="barra-costo" style="width:{{ $porcentajeCosto }}%;">
                            @if($porcentajeCosto > 10) Costo {{ number_format($porcentajeCosto, 1) }}% @endif
                        </div>
                        <div class="barra-ganancia" style="width:{{ $porcentajeGanancia }}%;">
                            @if($porcentajeGanancia > 10) Ganancia {{ number_format($porcentajeGanancia, 1) }}% @endif
                        </div>
                    @else
                        <div style="width: 100%; display: flex; align-items: center; justify-content: center; color: #9aa0a8;">Sin datos</div>
                    @endif
                </div>
                <div class="leyenda">
                    <div class="leyenda-item"><span class="dot dot-naranja"></span> Costo de compra <b class="naranja">${{ number_format($costoTotal, 2) }}</b></div>
                    <div class="leyenda-item"><span class="dot dot-verde"></span> Ganancia neta <b class="verde">${{ number_format($gananciaNeta, 2) }}</b></div>
                </div>
            </div>

            <!-- Registro de ventas -->
            <div class="registro-box">
                <div class="registro-header">
                    <div class="registro-title"><i class="fa-solid fa-user"></i> Registro de Ventas</div>
                    <div class="registro-tabla-note">Tabla: venta + detalle_venta</div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>N° VENTA</th>
                            <th>CLIENTE</th>
                            <th>FECHA</th>
                            <th>COSTO COMPRA</th>
                            <th>PRECIO VENTA</th>
                            <th>GANANCIA</th>
                            <th>MARGEN</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                        <tr>
                            <td class="venta-num">#{{ $venta->id }}</td>
                            <td class="cliente">{{ $venta->user->name ?? 'N/A' }}</td>
                            <td class="fecha">{{ $venta->created_at->format('d/m/Y') }}</td>
                            <td class="costo-compra">${{ number_format($venta->costo_compra_calculado, 2) }}</td>
                            <td class="precio-venta">${{ number_format($venta->total, 2) }}</td>
                            <td class="ganancia">${{ number_format($venta->ganancia_calculada, 2) }}</td>
                            <td><span class="margen-badge">{{ number_format($venta->margen_calculado, 1) }}%</span></td>
                            <td>
                                <button type="button" onclick="document.getElementById('modal-pedido-{{ $venta->id }}').classList.remove('hidden')" class="accion-btn">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #9aa0a8; padding: 30px;">
                                No se encontraron ventas en este periodo.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</body>
</html>

        {{-- Modales fuera de la tabla --}}
        @foreach($ventas as $venta)
        <div id="modal-pedido-{{ $venta->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/60 overflow-y-auto h-full w-full flex items-center justify-center p-4">
            <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh]">
                
                {{-- Header del Modal --}}
                <div class="bg-white border-b border-gray-100 p-4 flex items-center justify-between shrink-0 rounded-t-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                            <i class="fa-solid fa-clipboard-list text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-gray-800 tracking-tight">Detalle de Venta #{{ $venta->id }}</h2>
                            <p class="text-[11px] text-gray-500 font-medium">Venta del {{ $venta->created_at->isoFormat('D \d\e MMMM \d\e Y') }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('modal-pedido-{{ $venta->id }}').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition flex items-center justify-center">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                {{-- Contenido del Modal (Scrollable) --}}
                <div class="p-4 md:p-5 overflow-y-auto space-y-4 bg-white">
                    
                    {{-- Barra de Progreso (Stepper) --}}
                    <div class="relative flex items-center justify-between w-full px-6 md:px-8 mt-2 mb-4">
                        <div class="absolute left-10 right-10 top-1/2 h-[2px] bg-gray-200 -z-10 -translate-y-1/2"></div>
                        
                        @php
                            $estados = ['Pendiente', 'En proceso', 'Enviado', 'Entregado'];
                            $estadoDb = $venta->estado === 'Activo' ? 'Pendiente' : $venta->estado;
                            $estadoActual = '';
                            if (strtolower($estadoDb) == 'pendiente') $estadoActual = 'Pendiente';
                            if (strtolower($estadoDb) == 'en proceso') $estadoActual = 'En proceso';
                            if (strtolower($estadoDb) == 'enviado') $estadoActual = 'Enviado';
                            if (strtolower($estadoDb) == 'entregado') $estadoActual = 'Entregado';

                            $currentIndex = array_search($estadoActual, $estados);
                            if ($currentIndex === false) $currentIndex = 0;
                        @endphp

                        @foreach($estados as $index => $estadoItem)
                            @php
                                $isCompleted = $index < $currentIndex;
                                $isCurrent = $index === $currentIndex;
                                
                                $circleContainerClass = '';
                                $innerCircleClass = '';
                                $textClass = '';
                                $icon = '';

                                if ($estadoItem == 'Pendiente') $icon = 'fa-clock';
                                if ($estadoItem == 'En proceso') $icon = 'fa-gear';
                                if ($estadoItem == 'Enviado') $icon = 'fa-truck-fast';
                                if ($estadoItem == 'Entregado') $icon = 'fa-check';

                                if ($isCompleted || $isCurrent) {
                                    $circleContainerClass = 'bg-[#c1f0d0] p-1 rounded-full';
                                    $innerCircleClass = 'bg-[#16a34a] text-white';
                                    $textClass = 'text-[#16a34a] font-bold';
                                } else {
                                    $circleContainerClass = 'bg-transparent p-1 rounded-full';
                                    $innerCircleClass = 'bg-gray-200 text-gray-400';
                                    $textClass = 'text-gray-300 font-medium';
                                }
                            @endphp
                            <div class="flex flex-col items-center gap-1.5 bg-white px-2">
                                <div class="{{ $circleContainerClass }}">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] {{ $innerCircleClass }}">
                                        <i class="fa-solid {{ $icon }}"></i>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold tracking-wide {{ $textClass }}">{{ $estadoItem }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Grid 2 Columnas (Datos y Cliente) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        {{-- Datos del Pedido --}}
                        <div class="bg-gray-100 rounded-2xl p-4 md:p-5">
                            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Datos del pedido</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] text-gray-500">N° Venta</span>
                                    <span class="text-[12px] font-bold text-gray-800">#{{ $venta->id }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] text-gray-500">Fecha</span>
                                    <span class="text-[12px] font-bold text-gray-800">{{ $venta->created_at->isoFormat('D \d\e MMMM \d\e Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] text-gray-500">Productos</span>
                                    <span class="text-[12px] font-bold text-gray-800">{{ $venta->numero_productos ?? $venta->detalles->sum('cantidad') ?? 1 }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] text-gray-500">Estado</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full font-bold bg-[#fef3c7] text-[#b45309]">{{ $estadoActual }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] text-gray-500">Método pago</span>
                                    <span class="text-[12px] font-bold text-gray-800 lowercase">{{ $venta->pago->metodo_pago ?? 'efectivo' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] text-gray-500">Factura</span>
                                    <span class="text-[12px] font-bold text-gray-800">FAC-{{ strtoupper(substr(md5($venta->id), 0, 14)) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Cliente --}}
                        <div class="bg-gray-100 rounded-2xl p-4 md:p-5">
                            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Cliente</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] text-gray-500">Nombre</span>
                                    <span class="text-[12px] font-bold text-gray-800 truncate max-w-[120px]">{{ $venta->user->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] text-gray-500">Correo</span>
                                    <span class="text-[12px] font-bold text-gray-800 truncate max-w-[120px]">{{ $venta->user->email ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] text-gray-500">Teléfono</span>
                                    <span class="text-[12px] font-bold text-gray-800">{{ $venta->direccion->telefono ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] text-gray-500">Documento</span>
                                    <span class="text-[12px] font-bold text-gray-800">{{ $venta->user->documento ?? '1066228899' }}</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Dirección de Envío (Verde Suave) --}}
                    <div class="bg-green-50/50 rounded-2xl p-4 md:p-5 border border-green-200">
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-5">
                            <div class="sm:col-span-2">
                                <h3 class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-2.5 flex items-center gap-2">
                                    <div class="w-5 h-5 rounded bg-green-100 flex items-center justify-center text-green-600 shadow-sm">
                                        <i class="fa-solid fa-location-dot text-[9px]"></i>
                                    </div> 
                                    Dirección de envío
                                </h3>
                                <p class="text-[13px] font-bold text-gray-800 leading-tight ml-7">{{ $venta->direccion->direccion ?? 'Sin dirección' }}</p>
                                <p class="text-[12px] text-gray-500 leading-tight mt-0.5 ml-7">{{ $venta->direccion->ciudad ?? '' }}</p>
                            </div>
                            <div>
                                <h3 class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-2.5 flex items-center gap-2">
                                    <div class="w-5 h-5 rounded bg-green-100 flex items-center justify-center text-green-600 shadow-sm">
                                        <i class="fa-solid fa-calendar-day text-[9px]"></i>
                                    </div> 
                                    Fecha envío
                                </h3>
                                <p class="text-[13px] font-bold text-gray-800 ml-7">{{ $venta->created_at->isoFormat('D \d\e MMMM \d\e Y') }}</p>
                            </div>
                            <div>
                                <h3 class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-2.5 flex items-center gap-2">
                                    <div class="w-5 h-5 rounded bg-green-100 flex items-center justify-center text-green-600 shadow-sm">
                                        <i class="fa-solid fa-truck text-[9px]"></i>
                                    </div> 
                                    Transportadora
                                </h3>
                                <p class="text-[13px] font-bold text-gray-800 ml-7">Por asignar</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer de acciones del modal --}}
                <div class="p-4 md:px-5 md:py-4 border-t border-gray-100 bg-gray-50/50 shrink-0 rounded-b-2xl">
                    <form action="{{ route('pedidos.update', $venta->id) }}" method="POST" class="flex items-center justify-between w-full">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center gap-3">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                Cambiar Estado:
                            </span>
                            <select name="estado" class="pl-3 pr-8 py-2 bg-white border border-gray-200 hover:border-gray-300 text-[12px] font-bold text-gray-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all cursor-pointer outline-none w-40 shadow-sm">
                                <option value="Pendiente" {{ in_array($venta->estado, ['Pendiente', 'Activo']) ? 'selected' : '' }}>Pendiente</option>
                                <option value="En Proceso" {{ $venta->estado == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="Enviado" {{ $venta->estado == 'Enviado' ? 'selected' : '' }}>Enviado</option>
                                <option value="Entregado" {{ $venta->estado == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-[12px] font-bold py-2 px-6 rounded-lg transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                            <i class="fa-solid fa-check"></i> Guardar
                        </button>
                    </form>
                </div>

            </div>
        </div>
        @endforeach

