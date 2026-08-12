<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Movimientos | Coffee.dat</title>

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

        /* ===== Tarjetas resumen ===== */
        .cards-row {
            display: flex;
            gap: 18px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .card {
            background: #fff;
            border-radius: 14px;
            padding: 16px 22px;
            flex: 1;
            min-width: 200px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.08);
        }
        .card.active-card {
            border: 2px solid #1e8e4c;
        }
        .card-total.active-card {
            border: 2px solid #1a1a1a;
            background: #f8f9fa;
            box-shadow: none;
        }
        .card-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .icon-gris { background: #eef0f2; color: #333; }
        .icon-verde { background: #d9f3e2; color: #1e8e4c; }
        .icon-rojo { background: #fbdcdc; color: #d64545; }
        .icon-amarillo { background: #fdeec7; color: #d99a17; }

        .card-label {
            font-size: 11px;
            font-weight: 700;
            color: #9aa0a8;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .card-value {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1;
        }
        .card-value.verde { color: #1e8e4c; }
        .card-value.rojo { color: #d64545; }
        .card-value.naranja { color: #e0912b; }

        /* ===== Filtros ===== */
        .filtro-bar {
            background: #fff;
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            flex-wrap: wrap;
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
            white-space: nowrap;
            text-decoration: none;
        }
        .filtro-btn:hover {
            background: #e2e8f0;
        }
        .filtro-btn.activo {
            background: #1e8e4c;
            color: #fff;
        }
        .buscar-box {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f7f8fa;
            border: 1px solid #e6e8eb;
            border-radius: 9px;
            padding: 10px 16px;
            color: #9aa0a8;
            min-width: 200px;
        }
        .buscar-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            flex: 1;
            color: #333;
        }
        .filtrar-btn {
            background: #1e8e4c;
            color: #fff;
            border: none;
            padding: 11px 22px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }
        .filtrar-btn:hover { background: #197a41; }

        /* ===== Tabla ===== */
        .registro-box {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            overflow: hidden;
        }
        .registro-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 22px;
            font-size: 13px;
            color: #6b7280;
        }
        .registro-header b { color: #1a1a1a; }
        .registro-header .pagina { color: #b5b9bf; }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            background: #f8f9fa;
            border-bottom: 1px solid #f0f1f3;
        }
        thead th {
            color: #6b7280;
            text-align: left;
            padding: 12px 22px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        thead th.center { text-align: center; }
        tbody td {
            padding: 14px 22px;
            font-size: 13.5px;
            color: #333;
            border-bottom: 1px solid #f0f1f3;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody td.center { text-align: center; }

        .fecha-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
        }
        .fecha-cell i { color: #b5b9bf; font-size: 12px; }
        .producto-nombre { font-weight: 700; color: #222; }

        .movimiento-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-salida {
            background: #fbdcdc;
            color: #d64545;
        }
        .badge-reserva {
            background: #fdeec7;
            color: #e0912b;
        }
        .badge-entrada {
            background: #d9f3e2;
            color: #1e8e4c;
        }

        .cantidad { font-weight: 700; color: #1a1a1a; }
        .stock-anterior { color: #3763e0; font-weight: 600; }
        .stock-nuevo { font-weight: 700; }
        .stock-nuevo.rojo { color: #d64545; }
        .stock-nuevo.verde { color: #1e8e4c; }
        
        .pagination-container {
            padding: 16px 22px;
            border-top: 1px solid #f0f1f3;
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

            <!-- Tarjetas resumen -->
            <div class="cards-row">
                <a href="{{ request()->fullUrlWithQuery(['tipo' => null]) }}" class="card card-total {{ !request('tipo') ? 'active-card' : '' }}">
                    <div class="card-icon icon-gris"><i class="fa-solid fa-bars"></i></div>
                    <div>
                        <div class="card-label">TOTAL</div>
                        <div class="card-value">{{ $totalMovimientos }}</div>
                    </div>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['tipo' => 'entrada']) }}" class="card {{ request('tipo') == 'entrada' ? 'active-card' : '' }}">
                    <div class="card-icon icon-verde"><i class="fa-solid fa-arrow-up"></i></div>
                    <div>
                        <div class="card-label">ENTRADAS</div>
                        <div class="card-value verde">{{ $entradas }}</div>
                    </div>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['tipo' => 'salida']) }}" class="card {{ request('tipo') == 'salida' ? 'active-card' : '' }}">
                    <div class="card-icon icon-rojo"><i class="fa-solid fa-arrow-down"></i></div>
                    <div>
                        <div class="card-label">SALIDAS</div>
                        <div class="card-value rojo">{{ $salidas }}</div>
                    </div>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['tipo' => 'reserva']) }}" class="card {{ request('tipo') == 'reserva' ? 'active-card' : '' }}">
                    <div class="card-icon icon-amarillo"><i class="fa-solid fa-clock"></i></div>
                    <div>
                        <div class="card-label">RESERVAS</div>
                        <div class="card-value naranja">{{ $reservas }}</div>
                    </div>
                </a>
            </div>

            <!-- Filtros -->
            <form action="{{ route('movimientos.index') }}" method="GET" class="filtro-bar">
                @if(request('tipo'))
                    <input type="hidden" name="tipo" value="{{ request('tipo') }}">
                @endif
                <a href="{{ request()->fullUrlWithQuery(['filtro' => null]) }}" class="filtro-btn {{ !request('filtro') ? 'activo' : '' }}"><i class="fa-solid fa-list"></i> Todo</a>
                <a href="{{ request()->fullUrlWithQuery(['filtro' => 'hoy']) }}" class="filtro-btn {{ request('filtro') == 'hoy' ? 'activo' : '' }}"><i class="fa-regular fa-calendar-check"></i> Hoy</a>
                <a href="{{ request()->fullUrlWithQuery(['filtro' => 'semana']) }}" class="filtro-btn {{ request('filtro') == 'semana' ? 'activo' : '' }}"><i class="fa-regular fa-calendar"></i> Semana</a>
                <a href="{{ request()->fullUrlWithQuery(['filtro' => 'mes']) }}" class="filtro-btn {{ request('filtro') == 'mes' ? 'activo' : '' }}"><i class="fa-regular fa-calendar-days"></i> Mes</a>
                <a href="{{ request()->fullUrlWithQuery(['filtro' => 'ano']) }}" class="filtro-btn {{ request('filtro') == 'ano' ? 'activo' : '' }}"><i class="fa-regular fa-calendar-alt"></i> Año</a>
                
                <div class="buscar-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" placeholder="Buscar por producto..." value="{{ request('search') }}">
                    @if(request('filtro'))
                        <input type="hidden" name="filtro" value="{{ request('filtro') }}">
                    @endif
                </div>
                <button type="submit" class="filtrar-btn"><i class="fa-solid fa-filter"></i> Filtrar</button>
            </form>

            <!-- Tabla -->
            <div class="registro-box">
                <div class="registro-header">
                    <div>Mostrando <b>{{ $movimientos->count() }}</b> de <b>{{ $movimientos->total() }}</b> registros</div>
                    <div class="pagina">Página {{ $movimientos->currentPage() }} de {{ max($movimientos->lastPage(), 1) }}</div>
                </div>
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>FECHA</th>
                                <th>PRODUCTO</th>
                                <th>TIPO DE MOVIMIENTO</th>
                                <th class="center">CANTIDAD</th>
                                <th class="center">STOCK ANTERIOR</th>
                                <th class="center">STOCK NUEVO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movimientos as $movimiento)
                                @php
                                    $isEntrada = str_contains(strtolower($movimiento->tipo_movimiento), 'entrada');
                                    $isReserva = str_contains(strtolower($movimiento->tipo_movimiento), 'reserva');
                                    
                                    if ($isEntrada) {
                                        $badgeClass = 'badge-entrada';
                                        $iconClass = 'fa-arrow-up';
                                        $stockNuevoClass = 'verde';
                                    } elseif ($isReserva) {
                                        $badgeClass = 'badge-reserva';
                                        $iconClass = 'fa-clock';
                                        $stockNuevoClass = 'naranja';
                                    } else {
                                        $badgeClass = 'badge-salida';
                                        $iconClass = 'fa-arrow-down';
                                        $stockNuevoClass = 'rojo';
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <span class="fecha-cell">
                                            <i class="fa-regular fa-calendar"></i> 
                                            {{ $movimiento->fecha_movimiento->format('d/m/Y H:i') }}
                                        </span>
                                    </td>
                                    <td class="producto-nombre">{{ $movimiento->producto->nombre ?? 'Producto Eliminado' }}</td>
                                    <td>
                                        <span class="movimiento-badge {{ $badgeClass }}">
                                            <i class="fa-solid {{ $iconClass }}"></i> {{ $movimiento->tipo_movimiento }}
                                        </span>
                                    </td>
                                    <td class="center cantidad">{{ $movimiento->cantidad }}</td>
                                    <td class="center stock-anterior">{{ $movimiento->stock_anterior }}</td>
                                    <td class="center stock-nuevo {{ $stockNuevoClass }}">{{ $movimiento->stock_nuevo }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="center" style="padding: 40px;">
                                        <div style="color: #9aa0a8; font-size: 16px;">
                                            <i class="fa-solid fa-box-open" style="font-size: 32px; margin-bottom: 10px;"></i>
                                            <p>No hay movimientos registrados.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($movimientos->hasPages())
                <div class="pagination-container">
                    {{ $movimientos->links() }}
                </div>
                @endif
            </div>

        </main>
        
        {{-- Footer --}}
        @include('layouts.footer')
    </div>
</body>
</html>
