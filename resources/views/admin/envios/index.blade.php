<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envíos | Coffee.dat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js para modales (opcional pero muy útil) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

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
            border: 2px solid #3b82f6;
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
        
        .icon-pendientes { background: #fef3c7; color: #d97706; }
        .icon-encamino { background: #dbeafe; color: #2563eb; }
        .icon-entregados { background: #d1fae5; color: #059669; }
        .icon-cancelados { background: #fee2e2; color: #dc2626; }

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

        /* ===== Tabla Header Bar ===== */
        .tabla-header-bar {
            background: #fff;
            border-radius: 14px 14px 0 0;
            padding: 20px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f1f3;
        }
        .tabla-title-box {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }
        .tabla-title-box i {
            color: #2563eb;
        }
        .filtro-badge {
            background: #dbeafe;
            color: #1d4ed8;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .limpiar-filtro {
            color: #6b7280;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .limpiar-filtro:hover {
            color: #1a1a1a;
        }

        /* ===== Tabla ===== */
        .registro-box {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            overflow: hidden;
        }

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
        tbody td {
            padding: 14px 22px;
            font-size: 13.5px;
            color: #333;
            border-bottom: 1px solid #f0f1f3;
        }
        tbody tr:last-child td { border-bottom: none; }

        .cliente-info { display: flex; flex-direction: column; }
        .cliente-nombre { font-weight: 700; color: #1a1a1a; }
        .cliente-email { font-size: 12px; color: #6b7280; }

        .pedido-numero { font-weight: 700; color: #1a1a1a; }

        .estado-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-pendiente { background: #fef3c7; color: #d97706; }
        .badge-encamino { background: #dbeafe; color: #2563eb; }
        .badge-entregado { background: #d1fae5; color: #059669; }
        .badge-cancelado { background: #fee2e2; color: #dc2626; }

        .btn-edit {
            background: #f0fdf4;
            color: #16a34a;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-edit:hover {
            background: #dcfce7;
            color: #15803d;
        }

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
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                  <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tarjetas resumen -->
            <div class="cards-row">
                <a href="{{ request()->fullUrlWithQuery(['estado' => 'Pendiente']) }}" class="card {{ request('estado') == 'Pendiente' ? 'active-card' : '' }}">
                    <div class="card-icon icon-pendientes"><i class="fa-solid fa-clock"></i></div>
                    <div>
                        <div class="card-label">PENDIENTES</div>
                        <div class="card-value">{{ $pendientes }}</div>
                    </div>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['estado' => 'En camino']) }}" class="card {{ request('estado') == 'En camino' ? 'active-card' : '' }}">
                    <div class="card-icon icon-encamino"><i class="fa-solid fa-truck"></i></div>
                    <div>
                        <div class="card-label">EN CAMINO</div>
                        <div class="card-value">{{ $enCamino }}</div>
                    </div>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['estado' => 'Entregado']) }}" class="card {{ request('estado') == 'Entregado' ? 'active-card' : '' }}">
                    <div class="card-icon icon-entregados"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <div class="card-label">ENTREGADOS</div>
                        <div class="card-value">{{ $entregados }}</div>
                    </div>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['estado' => 'Cancelado']) }}" class="card {{ request('estado') == 'Cancelado' ? 'active-card' : '' }}">
                    <div class="card-icon icon-cancelados"><i class="fa-solid fa-circle-xmark"></i></div>
                    <div>
                        <div class="card-label">CANCELADOS</div>
                        <div class="card-value">{{ $cancelados }}</div>
                    </div>
                </a>
            </div>

            <!-- Tabla -->
            <div class="registro-box">
                <div class="tabla-header-bar">
                    <div class="tabla-title-box">
                        <i class="fa-solid fa-truck"></i> Todos los Envíos 
                        @if(request('estado'))
                            <span class="filtro-badge">{{ request('estado') }}</span>
                        @endif
                    </div>
                    @if(request('estado'))
                        <a href="{{ route('envios.index') }}" class="limpiar-filtro"><i class="fa-solid fa-xmark"></i> Limpiar filtro</a>
                    @endif
                </div>
                
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>PEDIDO</th>
                                <th>CLIENTE</th>
                                <th>DIRECCIÓN</th>
                                <th>MUNICIPIO</th>
                                <th>TRANSPORTADORA</th>
                                <th>F. ENVÍO</th>
                                <th>F. ENTREGA</th>
                                <th>ESTADO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pedidos as $pedido)
                                @php
                                    $infoEnvio = $pedido->informacionEnvio;
                                    $estadoActual = $infoEnvio ? $infoEnvio->estado : 'Pendiente';
                                    $transpActual = $infoEnvio ? $infoEnvio->transportadora : 'Por asignar';
                                    
                                    // Direccion fallback
                                    $direccionStr = $infoEnvio ? $infoEnvio->direccion : ($pedido->direccion ? $pedido->direccion->direccion : '');
                                    $ciudadStr = $infoEnvio ? $infoEnvio->ciudad : ($pedido->direccion ? $pedido->direccion->municipio : '');

                                    $fechaEnvio = $infoEnvio && $infoEnvio->fecha_envio ? $infoEnvio->fecha_envio->format('Y-m-d') : '';
                                    $fechaEntrega = $infoEnvio && $infoEnvio->fecha_entrega ? $infoEnvio->fecha_entrega->format('Y-m-d') : '';
                                    
                                    $fEnvioDisplay = $infoEnvio && $infoEnvio->fecha_envio ? $infoEnvio->fecha_envio->format('d/m/Y') : '-';
                                    $fEntregaDisplay = $infoEnvio && $infoEnvio->fecha_entrega ? $infoEnvio->fecha_entrega->format('d/m/Y') : '-';

                                    $estadoStrLC = strtolower($estadoActual);
                                    if (str_contains($estadoStrLC, 'pendiente')) {
                                        $badgeClass = 'badge-pendiente';
                                    } elseif (str_contains($estadoStrLC, 'camino')) {
                                        $badgeClass = 'badge-encamino';
                                    } elseif (str_contains($estadoStrLC, 'entregado')) {
                                        $badgeClass = 'badge-entregado';
                                    } else {
                                        $badgeClass = 'badge-cancelado';
                                    }
                                @endphp
                                <tr>
                                    <td class="pedido-numero">#{{ $pedido->id }}</td>
                                    <td>
                                        <div class="cliente-info">
                                            <span class="cliente-nombre">{{ $pedido->user->name ?? 'Usuario Desconocido' }}</span>
                                            <span class="cliente-email">{{ $pedido->user->email ?? '' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $direccionStr }}</td>
                                    <td>{{ $ciudadStr }}</td>
                                    <td>{{ $transpActual }}</td>
                                    <td>{{ $fEnvioDisplay }}</td>
                                    <td>{{ $fEntregaDisplay }}</td>
                                    <td>
                                        <span class="estado-badge {{ $badgeClass }}">
                                            {{ $estadoActual }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <button type="button" class="btn-edit" 
                                            onclick="openModalEnvio({{ $pedido->id }}, {
                                                fecha_envio: '{{ $fechaEnvio }}',
                                                entrega_estimada: '{{ $fechaEntrega }}',
                                                direccion_entrega: '{{ addslashes($direccionStr) }}',
                                                municipio: '{{ addslashes($ciudadStr) }}',
                                                transportadora: '{{ addslashes($transpActual) }}',
                                                estado_envio: '{{ $estadoActual }}'
                                            })">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center" style="padding: 40px;">
                                        <div style="color: #9aa0a8; font-size: 16px;">
                                            <i class="fa-solid fa-box-open" style="font-size: 32px; margin-bottom: 10px;"></i>
                                            <p>No hay pedidos registrados.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($pedidos->hasPages())
                <div class="pagination-container">
                    {{ $pedidos->links() }}
                </div>
                @endif
            </div>

        </main>
        
        {{-- Footer --}}
        @include('layouts.footer')
    </div>

    <!-- MODAL: Editar Envío -->
    <div id="modalEditarEnvio"
         style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.6);
                z-index:1000; align-items:center; justify-content:center; padding:16px;">

        <div style="background:#ffffff; width:100%; max-width:540px; border-radius:16px;
                    overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.35);
                    max-height:90vh; display:flex; flex-direction:column;">

            <!-- HEADER -->
            <div style="background:#1e293b; padding:20px 24px; display:flex;
                        align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:14px;">
                    <div style="background:rgba(255,255,255,0.12); width:42px; height:42px;
                                border-radius:10px; display:flex; align-items:center;
                                justify-content:center;">
                        <i class="fa-solid fa-truck" style="color:#ffffff; font-size:18px;"></i>
                    </div>
                    <div>
                        <h3 style="color:#ffffff; font-size:17px; font-weight:700; margin:0;">
                            Editar Envío
                        </h3>
                        <p id="envioModalSubtitulo" style="color:#94a3b8; font-size:13px; margin:2px 0 0;">
                            Pedido #0
                        </p>
                    </div>
                </div>
                <button type="button" onclick="closeModalEnvio()"
                        style="background:rgba(255,255,255,0.12); border:none; color:#ffffff;
                               width:34px; height:34px; border-radius:8px; cursor:pointer;
                               font-size:15px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- BODY -->
            <form id="formEditarEnvio" method="POST" style="padding:24px; overflow-y:auto;">
                @csrf
                @method('PUT')
                <input type="hidden" name="pedido_id" id="envio_pedido_id">

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#64748b;
                                      letter-spacing:.03em; text-transform:uppercase; margin-bottom:8px;">
                            Fecha de Envío
                        </label>
                        <input type="date" name="fecha_envio" id="envio_fecha_envio"
                               style="width:100%; padding:12px 14px; border:1px solid #e2e8f0;
                                      border-radius:10px; background:#f8fafc; font-size:14px;
                                      color:#1e293b; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#64748b;
                                      letter-spacing:.03em; text-transform:uppercase; margin-bottom:8px;">
                            Entrega Estimada
                        </label>
                        <input type="date" name="fecha_entrega" id="envio_entrega_estimada"
                               style="width:100%; padding:12px 14px; border:1px solid #e2e8f0;
                                      border-radius:10px; background:#f8fafc; font-size:14px;
                                      color:#1e293b; box-sizing:border-box;">
                    </div>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#64748b;
                                  letter-spacing:.03em; text-transform:uppercase; margin-bottom:8px;">
                        Dirección de Entrega
                    </label>
                    <input type="text" id="envio_direccion" readonly
                           style="width:100%; padding:12px 14px; border:1px solid #e2e8f0;
                                  border-radius:10px; background:#f8fafc; font-size:14px;
                                  color:#1e293b; box-sizing:border-box;">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#64748b;
                                      letter-spacing:.03em; text-transform:uppercase; margin-bottom:8px;">
                            Municipio
                        </label>
                        <input type="text" id="envio_municipio" readonly
                               style="width:100%; padding:12px 14px; border:1px solid #e2e8f0;
                                      border-radius:10px; background:#f8fafc; font-size:14px;
                                      color:#1e293b; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#64748b;
                                      letter-spacing:.03em; text-transform:uppercase; margin-bottom:8px;">
                            Transportadora
                        </label>
                        <select name="transportadora" id="envio_transportadora"
                                style="width:100%; padding:12px 14px; border:1px solid #e2e8f0;
                                       border-radius:10px; background:#f8fafc; font-size:14px;
                                       color:#1e293b; box-sizing:border-box; appearance:auto;">
                            <option value="Por asignar">Por asignar</option>
                            <option value="Inter Rapidísimo">Inter Rapidísimo</option>
                            <option value="Servientrega">Servientrega</option>
                            <option value="Envía">Envía</option>
                            <option value="Coordinadora">Coordinadora</option>
                            <option value="TCC">TCC</option>
                            <option value="Mensajería Local">Mensajería Local</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom:24px;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#64748b;
                                  letter-spacing:.03em; text-transform:uppercase; margin-bottom:8px;">
                        Estado del Envío
                    </label>
                    <select name="estado" id="envio_estado" required
                            style="width:100%; padding:12px 14px; border:1px solid #e2e8f0;
                                   border-radius:10px; background:#f8fafc; font-size:14px;
                                   color:#1e293b; box-sizing:border-box; appearance:auto;">
                        <option value="Pendiente">Pendiente</option>
                        <option value="En camino">En camino</option>
                        <option value="Entregado">Entregado</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>

                <!-- BOTONES -->
                <div style="display:flex; gap:12px;">
                    <button type="submit"
                            style="flex:1; background:#16a34a; color:#ffffff; border:none;
                                   padding:15px; border-radius:10px; font-size:15px; font-weight:700;
                                   cursor:pointer;">
                        Guardar Cambios
                    </button>
                    <button type="button" onclick="closeModalEnvio()"
                            style="background:#f1f5f9; color:#334155; border:none;
                                   padding:15px 28px; border-radius:10px; font-size:15px;
                                   font-weight:700; cursor:pointer;">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModalEnvio(pedidoId, datos = {}) {
            document.getElementById('envio_pedido_id').value = pedidoId;
            document.getElementById('envioModalSubtitulo').textContent = 'Pedido #' + pedidoId;

            document.getElementById('envio_fecha_envio').value = datos.fecha_envio ?? '';
            document.getElementById('envio_entrega_estimada').value = datos.entrega_estimada ?? '';
            document.getElementById('envio_direccion').value = datos.direccion_entrega ?? '';
            document.getElementById('envio_municipio').value = datos.municipio ?? '';
            document.getElementById('envio_transportadora').value = datos.transportadora ?? 'Por asignar';
            document.getElementById('envio_estado').value = datos.estado_envio ?? 'Pendiente';

            // Ajustar la action del form
            document.getElementById('formEditarEnvio').action = `/envios/${pedidoId}`;

            document.getElementById('modalEditarEnvio').style.display = 'flex';
        }

        function closeModalEnvio() {
            document.getElementById('modalEditarEnvio').style.display = 'none';
        }

        // Cerrar al hacer click fuera del contenido
        document.getElementById('modalEditarEnvio').addEventListener('click', function (e) {
            if (e.target === this) {
                closeModalEnvio();
            }
        });
    </script>

</body>
</html>
