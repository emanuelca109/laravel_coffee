<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores | Coffee.dat</title>

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

        <main class="p-6 space-y-8 min-w-0 flex-1">

            {{-- Banner --}}
            <div class="relative bg-gradient-to-r from-green-800 to-green-600 rounded-3xl shadow-xl p-8 text-white overflow-hidden">

                <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full"></div>

                <div class="absolute bottom-0 right-24 w-24 h-24 bg-white/10 rounded-full"></div>

                <div class="relative z-10">

                    <h2 class="text-3xl font-bold mb-2">
                        Gestión de Proveedores
                    </h2>

                    <p class="text-green-100 text-lg max-w-2xl">
                        Administra los proveedores de Coffee Dat y mantén actualizada tu red de abastecimiento.
                    </p>

                </div>

            </div>

            {{-- Contenedor principal --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">

                <div class="flex items-center justify-between mb-8">

                    <div>

                        <h3 class="text-2xl font-bold text-slate-800">
                            Proveedores Registrados
                        </h3>

                        <p class="text-gray-500 mt-1">
                            Administra todos los proveedores del sistema.
                        </p>

                    </div>

                    <button
                        onclick="abrirModal()"
                        class="bg-green-700 hover:bg-green-800 text-white px-5 py-3 rounded-xl font-semibold transition">

                        <i class="fa-solid fa-plus mr-2"></i>
                        Nuevo Proveedor

                    </button>

                </div>

                <div class="overflow-hidden">

                    <table class="w-full table-fixed">

                        <thead>

                            <tr class="border-b border-gray-200">

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-16">
                                    Id
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-56">
                                    Empresa
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-36">
                                    Contacto
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-32">
                                    Teléfono
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600">
                                    Correo
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-28">
                                    Estado
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-28">
                                    Acciones
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @if($proveedores->count())

                                @foreach($proveedores as $proveedor)

                                    <tr class="hover:bg-green-50/50 transition-colors">

                                        <td class="text-center py-4 px-2">
                                            <span class="text-gray-400 font-medium text-sm">
                                                #{{ $proveedor->id }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">

                                            <span class="block font-semibold text-slate-800 break-words">
                                                {{ $proveedor->nombre_empresa }}
                                            </span>

                                            @if($proveedor->direccion)
                                                <span
                                                    title="{{ $proveedor->direccion }}"
                                                    class="block text-gray-400 text-xs mt-0.5 truncate">
                                                    <i class="fa-solid fa-location-dot mr-1"></i>{{ $proveedor->direccion }}
                                                </span>
                                            @endif

                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="text-gray-600 text-sm break-words">
                                                {{ $proveedor->nombre_proveedor }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="text-gray-600 text-sm">
                                                {{ $proveedor->telefono }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span
                                                title="{{ $proveedor->correo }}"
                                                class="block text-gray-600 text-sm truncate"
                                                style="word-break: break-all; overflow-wrap: break-word;">
                                                {{ $proveedor->correo }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            @if($proveedor->estado === 'Activo')
                                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                    Activo
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                    Inactivo
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-4 px-2">
                                            <div class="flex items-center justify-center gap-2">

                                                <button
                                                    type="button"
                                                    title="Editar proveedor"
                                                    onclick="abrirModalEditar(
                                                        '{{ $proveedor->id }}',
                                                        '{{ $proveedor->nombre_empresa }}',
                                                        '{{ $proveedor->nombre_proveedor }}',
                                                        '{{ $proveedor->telefono }}',
                                                        '{{ $proveedor->correo }}',
                                                        '{{ $proveedor->direccion }}',
                                                        '{{ $proveedor->estado }}'
                                                    )"
                                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">

                                                    <i class="fa-solid fa-pen text-sm"></i>

                                                </button>

                                                <button
                                                    type="button"
                                                    title="Eliminar proveedor"
                                                    onclick="abrirModalEliminar(
                                                        '{{ $proveedor->id }}',
                                                        '{{ addslashes($proveedor->nombre_empresa) }}'
                                                    )"
                                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors">

                                                    <i class="fa-solid fa-trash text-sm"></i>

                                                </button>

                                            </div>
                                        </td>

                                    </tr>

                                @endforeach

                            @else

                                <tr>

                                    <td colspan="7" class="py-16 text-center">

                                        <div class="flex flex-col items-center gap-3 text-gray-400">
                                            <i class="fa-solid fa-truck-fast text-4xl"></i>
                                            <p class="font-medium">No hay proveedores registrados</p>
                                        </div>

                                    </td>

                                </tr>

                            @endif

                        </tbody>

                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $proveedores->links() }}
                </div>
            </div>

        </main>

        {{-- Crear nuevo proveedor --}}
        @include('admin.proveedor.crear')

        @include('admin.proveedor.editar')
        @include('admin.proveedor.eliminar')

        {{-- Footer --}}
        @include('layouts.footer')

    </div>

    <script>
        function abrirModal()
        {
            document.getElementById('modalProveedor').classList.remove('hidden');
        }

        function cerrarModal()
        {
            document.getElementById('modalProveedor').classList.add('hidden');
        }
        document.addEventListener('DOMContentLoaded', function () {

            const sidebarLinks = document.querySelectorAll('aside nav a');

            sidebarLinks.forEach(link => {

                if (link.textContent.trim().includes('Proveedores')) {

                    link.classList.remove('text-white/85', 'border-transparent');

                    link.classList.add('active-menu-item');

                }

            });

        });
    </script>

</body>
</html>