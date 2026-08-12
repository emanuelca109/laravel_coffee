
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
