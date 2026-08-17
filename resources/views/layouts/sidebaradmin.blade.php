<aside class="fixed top-0 left-0 w-72 h-screen bg-[#1a5632] text-white flex flex-col z-30">    {{-- Logo --}}
    <!-- DEBUG_ROUTE: {{ Route::currentRouteName() ?? 'NULL' }} -->
    <div class="flex items-center justify-center px-4 py-5 border-b border-white/10">
        <img src="{{ asset('img/logo-full.svg') }}" alt="Coffee Dat" class="h-10 w-auto">
    </div>

    {{-- Menú --}}
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        @php
            $menuItems = [
                ['label' => 'Dashboard', 'icon' => 'fa-gauge', 'route' => 'dashboard'],
                ['label' => 'Categorías', 'icon' => 'fa-tags', 'route' => 'categorias.index'],
                ['label' => 'Productos', 'icon' => 'fa-box', 'route' => 'productos.index'],
                ['label' => 'Proveedores', 'icon' => 'fa-people-group', 'route' => 'proveedores.index'],
                ['label' => 'Ventas', 'icon' => 'fa-cash-register', 'route' => 'ventas.index'],
                ['label' => 'Pedidos', 'icon' => 'fa-clipboard-list', 'route' => 'pedidos.index'],
                ['label' => 'Inventario', 'icon' => 'fa-warehouse', 'route' => 'inventarios.index'],
                ['label' => 'Movimientos', 'icon' => 'fa-right-left', 'route' => 'movimientos.index'],
                ['label' => 'Envíos', 'icon' => 'fa-truck', 'route' => 'envios.index'],
                ['label' => 'Devoluciones', 'icon' => 'fa-rotate-left', 'route' => 'devoluciones.index'],
            ];
        @endphp

        @foreach ($menuItems as $item)
            @php 
                $itemPrefix = explode('.', $item['route'])[0];
                $isActive = request()->routeIs($item['route']) || ($itemPrefix !== 'dashboard' && request()->routeIs($itemPrefix . '.*'));
            @endphp
            <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
               class="flex items-center gap-3 px-4 py-2.5 text-sm transition-colors border-l-4
                      {{ $isActive
                            ? 'bg-white/10 text-white border-white font-bold'
                            : 'font-medium text-white/85 border-transparent hover:bg-white/10 hover:text-white' }}">
                <i class="fa-solid {{ $item['icon'] }} w-4 text-center"></i>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</aside>