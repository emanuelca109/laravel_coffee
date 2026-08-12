<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | Coffee.dat</title>

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

            {{-- Encabezado --}}
            <div class="relative bg-gradient-to-r from-green-800 to-green-600 rounded-3xl shadow-xl p-8 text-white overflow-hidden">

                <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full"></div>

                <div class="absolute bottom-0 right-24 w-24 h-24 bg-white/10 rounded-full"></div>

                <div class="relative z-10">

                    <h2 class="text-3xl font-bold mb-2">
                        Gestión de Productos
                    </h2>

                    <p class="text-green-100 text-lg max-w-2xl">
                        Administra los productos de Coffee Dat y mantén actualizado tu catálogo.
                    </p>

                </div>

            </div>

            {{-- Contenedor principal --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">

                <div class="flex items-center justify-between mb-8">

                    <div>

                        <h3 class="text-2xl font-bold text-slate-800">
                            Productos Registrados
                        </h3>

                        <p class="text-gray-500 mt-1">
                            Gestiona todos los productos del sistema.
                        </p>

                    </div>

                    <button
                        onclick="abrirModal()"
                        class="bg-green-700 hover:bg-green-800 text-white px-5 py-3 rounded-xl font-semibold transition">

                        <i class="fa-solid fa-plus mr-2"></i>
                        Nuevo Producto

                    </button>

                </div>

                <div class="overflow-hidden">

                    <table class="w-full table-fixed">

                        <thead>

                            <tr class="border-b border-gray-200">

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-14">
                                    ID
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-20">
                                    Imagen
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600">
                                    Nombre
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600">
                                    Descripción
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-28">
                                    Precio Compra
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-24">
                                    Precio
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-20">
                                    Stock
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-32">
                                    Categoría
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-24">
                                    Estado
                                </th>

                                <th class="text-center py-4 px-2 font-semibold text-gray-600 w-24">
                                    Acciones
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @if($productos->count())

                                @foreach($productos as $producto)

                                    <tr class="hover:bg-green-50/50 transition-colors">

                                        <td class="text-center py-4 px-2">
                                            <span class="text-gray-400 font-medium text-sm">
                                                #{{ $producto->id }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <div class="flex justify-center">
                                                @php
                                                    $imagenPrincipal = $producto->imagenes()->where('principal', true)->first();
                                                    if (!$imagenPrincipal && $producto->imagenes()->count() > 0) {
                                                        $imagenPrincipal = $producto->imagenes()->first();
                                                    }
                                                @endphp

                                                @if($imagenPrincipal)
                                                    <img src="{{ asset('storage/'.$imagenPrincipal->url_imagen) }}"
                                                         alt="{{ $producto->nombre }}"
                                                         class="w-12 h-12 object-cover rounded-lg"
                                                         title="Imágenes: {{ $producto->imagenes()->count() }}">
                                                @else
                                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                                        <i class="fa-solid fa-image text-gray-300"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="font-semibold text-slate-800 break-words">
                                                {{ $producto->nombre }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">

                                            <span
                                                title="{{ $producto->descripcion }}"
                                                class="block text-gray-500 text-sm mx-auto overflow-hidden"
                                                style="
                                                    display: -webkit-box;
                                                    -webkit-line-clamp: 2;
                                                    -webkit-box-orient: vertical;
                                                    line-height: 1.4;
                                                    max-height: 2.8em;
                                                    word-break: break-all;
                                                    overflow-wrap: break-word;
                                                ">

                                                {{ $producto->descripcion ?? '—' }}

                                            </span>

                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="text-gray-600 text-sm">
                                                ${{ number_format($producto->precio_compra, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="text-gray-600 text-sm">
                                                ${{ number_format($producto->precio_venta, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="inline-flex items-center justify-center min-w-[2rem] h-8 px-2 bg-gray-100 text-gray-700 text-sm font-normal rounded-lg">
                                                {{ $producto->stock_actual }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            <span class="text-gray-600 text-sm">
                                                {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                                            </span>
                                        </td>

                                        <td class="text-center py-4 px-2">
                                            @if($producto->estado === 'Activo')
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
                                                    title="Editar producto"
                                                    onclick="abrirModalEditar(
                                                        '{{ $producto->id }}',
                                                        '{{ $producto->nombre }}',
                                                        '{{ $producto->descripcion }}',
                                                        '{{ $producto->categoria_id }}',
                                                        '{{ $producto->precio_compra }}',
                                                        '{{ $producto->precio_venta }}',
                                                        '{{ $producto->stock_actual }}',
                                                        '{{ $producto->stock_minimo }}',
                                                        '{{ $producto->proveedor_id }}',
                                                        '{{ $producto->estado }}'
                                                    )"
                                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">

                                                    <i class="fa-solid fa-pen text-sm"></i>

                                                </button>

                                                <form action="{{ route('productos.destroy', $producto->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('¿Deseas eliminar este producto?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        title="Eliminar producto"
                                                        class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors">

                                                        <i class="fa-solid fa-trash text-sm"></i>

                                                    </button>

                                                </form>

                                            </div>
                                        </td>

                                    </tr>

                                @endforeach

                            @else

                                <tr>

                                    <td colspan="10" class="py-16 text-center">

                                        <div class="flex flex-col items-center gap-3 text-gray-400">
                                            <i class="fa-solid fa-box-open text-4xl"></i>
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

        {{-- Crear nuevo producto --}}
        @include('admin.productos.crear')

        @include('admin.productos.editar')

        {{-- Footer --}}
        @include('layouts.footer')

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sidebarLinks = document.querySelectorAll('aside nav a');

            sidebarLinks.forEach(link => {

                if (link.textContent.trim().includes('Productos')) {

                    link.classList.remove('text-white/85', 'border-transparent');

                    link.classList.add('active-menu-item');

                }

            });

        });
    </script>

</body>
</html>