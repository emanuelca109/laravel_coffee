<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario | Coffee.dat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        aside.fixed.left-0 {
            width: 16rem !important;
        }

        aside.fixed.left-0 img {
            height: 3rem !important;
            max-height: none !important;
        }

        header.fixed {
            left: 16rem !important;
        }

        .left-64 {
            left: 16rem !important;
        }

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

            {{-- Tarjetas de resumen, lado a lado forzado con inline CSS --}}
            <div style="display:flex; gap:24px; align-items:stretch;">

                <div style="flex:1;" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">

                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center" style="min-width:48px;">
                        <i class="fa-solid fa-box text-blue-600 text-lg"></i>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">
                            Total Productos
                        </p>
                        <p class="text-2xl font-bold text-slate-800">
                            {{ $totalProductos }}
                        </p>
                    </div>

                </div>

                <div style="flex:1;" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">

                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center" style="min-width:48px;">
                        <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg"></i>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">
                            Alertas de Stock
                        </p>
                        <p class="text-2xl font-bold text-red-600">
                            {{ $alertas }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- Contenedor principal --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="flex items-center justify-between px-8 py-6">

                    <h3 class="text-xl font-bold text-slate-800">
                        Estado del Stock
                    </h3>

                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                            Crítico
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Bajo
                        </span>
                    </div>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>

                            <tr class="border-b border-gray-200">

                                <th class="text-left py-4 px-6 font-semibold text-gray-600">Producto</th>
                                <th class="text-center py-4 px-2 font-semibold text-gray-600">Categoría</th>
                                <th class="text-center py-4 px-2 font-semibold text-gray-600">Stock Total</th>
                                <th class="text-center py-4 px-2 font-semibold text-gray-600">Reservado</th>
                                <th class="text-center py-4 px-2 font-semibold text-gray-600">Disponible</th>
                                <th class="text-center py-4 px-2 font-semibold text-gray-600">Stock Mínimo</th>
                                <th class="text-center py-4 px-6 font-semibold text-gray-600">Estado</th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @if($productos->count())

                                @foreach($productos as $producto)

                                    <tr class="hover:bg-green-50/50 transition-colors">

                                        <td class="py-4 px-6">
                                            <span class="block font-semibold text-slate-800">
                                                {{ $producto->nombre }}
                                            </span>
                                            <span class="block text-gray-400 text-xs mt-0.5">
                                                ID: #{{ $producto->id }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="text-gray-500 text-sm">
                                                {{ $producto->categoria->nombre ?? 'N/A' }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="text-slate-800 text-sm font-bold">
                                                {{ $producto->stock_actual }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            @if($producto->stock_reservado > 0)
                                                <span class="inline-flex items-center justify-center bg-amber-100 text-amber-700 text-xs font-semibold w-7 h-7 rounded-full">
                                                    {{ $producto->stock_reservado }}
                                                </span>
                                            @else
                                                <span class="text-gray-300">—</span>
                                            @endif
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="text-sm font-bold {{ $producto->stock_disponible > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $producto->stock_disponible }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="text-gray-500 text-sm">
                                                {{ $producto->stock_minimo }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-6">
                                            @switch($producto->estado_stock)
                                                @case('Disponible')
                                                    <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                        Disponible
                                                    </span>
                                                    @break

                                                @case('Bajo')
                                                    <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                        Bajo
                                                    </span>
                                                    @break

                                                @case('Crítico')
                                                    <span class="inline-flex items-center gap-1.5 bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                                        Crítico
                                                    </span>
                                                    @break

                                                @case('Agotado')
                                                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                        Agotado
                                                    </span>
                                                    @break
                                            @endswitch
                                        </td>

                                    </tr>

                                @endforeach

                            @else

                                <tr>

                                    <td colspan="7" class="py-16 text-center">

                                        <div class="flex flex-col items-center gap-3 text-gray-400">
                                            <i class="fa-solid fa-boxes-stacked text-4xl"></i>
                                            <p class="font-medium">No hay productos registrados</p>
                                        </div>

                                    </td>

                                </tr>

                            @endif

                        </tbody>

                    </table>
                </div>

                <div class="mt-4">
                    {{ $productos->links() }}
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

                if (link.textContent.trim().includes('Inventario')) {

                    link.classList.remove('text-white/85', 'border-transparent');

                    link.classList.add('active-menu-item');

                }

            });

        });
    </script>

</body>
</html>