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

        /* ===== Estilos del Dashboard de Ventas ===== */
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

        /* ===== Overlay ===== */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(15, 18, 25, 0.55);
            display: flex; align-items: center; justify-content: center; z-index: 999;
        }

        /* ===== Modal ===== */
        .modal-box {
            background: #fff; border-radius: 18px; width: 100%; max-width: 760px;
            overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.35); max-height: 90vh; display: flex; flex-direction: column;
        }

        /* ===== Header claro (Personalizado) ===== */
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

        /* ===== Body Modal ===== */
        .modal-body { padding: 24px 26px 26px; overflow-y: auto; }
        .detalle-box { border-radius: 12px; overflow: hidden; border: 1px solid #eef0f3; }
        .detalle-header { background: #f8f9fb; padding: 14px 22px; border-bottom: 1px solid #eef0f3; }
        .detalle-header-title { color: #444; font-size: 12px; font-weight: 700; letter-spacing: 0.5px; }

        .modal-body table { width: 100%; border-collapse: collapse; }
        .modal-body thead tr { background: #f4f5f7; border: none; }
        .modal-body thead th { text-align: left; padding: 12px 22px; font-size: 11px; font-weight: 700; color: #9aa0a8; letter-spacing: 0.4px; }
        .modal-body thead th.right { text-align: right; }
        .modal-body thead th.center { text-align: center; }

        .modal-body tbody td { padding: 14px 22px; font-size: 14px; color: #222; border-bottom: 1px solid #f0f1f3; }
        .modal-body tbody tr:last-child td { border-bottom: none; }
        .producto-nombre { font-weight: 600; color: #222; }
        .cantidad { text-align: center; color: #444; }
        .precio-unitario { text-align: right; color: #3763e0; font-weight: 700; }
        .subtotal { text-align: right; color: #1e8e4c; font-weight: 700; }

        .modal-body tfoot td { padding: 16px 22px; background: #f8f9fb; font-size: 14px; border-top: 1px solid #eef0f3; }
        .total-label { text-align: right; color: #9aa0a8; font-weight: 600; }
        .total-valor { text-align: right; color: #1e8e4c; font-size: 18px; font-weight: 800; }
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
                    <div class="distribucion-title">DISTRIBUCIÓN DE INGRESOS</div>
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
                                <button type="button" onclick="document.getElementById('modal-venta-{{ $venta->id }}').style.display='flex'" class="accion-btn">
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
            
            <div class="mt-4" style="margin-top: 15px;">
                {{ $ventas->links() }}
            </div>

        </div>
    </div>

    {{-- Modales de Detalle de Venta --}}
    @foreach($ventas as $venta)
    <div id="modal-venta-{{ $venta->id }}" class="modal-overlay" style="display: none;">
        <div class="modal-box">

            <!-- Header -->
            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="modal-icon"><i class="fa-solid fa-file-lines"></i></div>
                    <div>
                        <p class="modal-title">Detalle de Venta #{{ $venta->id }}</p>
                        <div class="modal-subtitle">Fecha: {{ $venta->created_at->format('d/m/Y h:i A') }}</div>
                    </div>
                </div>
                <button class="modal-close" onclick="document.getElementById('modal-venta-{{ $venta->id }}').style.display='none'"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="detalle-box">
                    <div class="detalle-header">
                        <span class="detalle-header-title">DETALLE DE PRODUCTOS</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>PRODUCTO</th>
                                <th class="center">CANTIDAD</th>
                                <th class="right">PRECIO UNITARIO</th>
                                <th class="right">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($venta->detalles as $detalle)
                            <tr>
                                <td class="producto-nombre">{{ $detalle->producto->nombre ?? 'Producto Eliminado' }}</td>
                                <td class="cantidad">{{ $detalle->cantidad }}</td>
                                <td class="precio-unitario">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                <td class="subtotal">${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td class="total-label">TOTAL:</td>
                                <td class="total-valor">${{ number_format($venta->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
    @endforeach

</body>
</html>