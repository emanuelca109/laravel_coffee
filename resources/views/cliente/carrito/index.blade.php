<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Carrito de Compras | Coffee.Dat</title>

    {{-- Tailwind CSS (CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body class="font-sans antialiased bg-gray-50">

    {{-- ==========================================
            HEADER (fijo arriba)
    =========================================== --}}
    <header class="fixed top-0 left-0 w-full z-[1000] h-40 flex flex-col items-center justify-center gap-3 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('img/ca.png') }}');">

        {{-- Overlay oscuro --}}
        <div class="absolute inset-0 bg-black/35"></div>

        {{-- Zona de Usuario --}}
        <div class="absolute z-30 top-5 right-8">
            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full text-white font-medium transition shadow-lg">
                        <span class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center font-bold shadow-inner">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                        <span class="hidden md:inline">{{ explode(' ', auth()->user()->name)[0] }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div x-show="open" style="display: none;"
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 scale-95" 
                         x-transition:enter-end="opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="opacity-100 scale-100" 
                         x-transition:leave-end="opacity-0 scale-95" 
                         class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden text-sm z-50">
                        <a href="{{ route('cuenta') }}" class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium transition">
                            Mi Cuenta
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 font-medium transition border-t border-gray-50">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <button type="button" x-data @click="$dispatch('open-login')"
                   class="w-[54px] h-[54px] rounded-full bg-green-700 hover:bg-green-800 flex items-center justify-center transition shadow-lg relative focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[26px] h-[26px] text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.4c-3.3 0-9.8 1.6-9.8 4.9v1.6h19.6v-1.6c0-3.3-6.5-4.9-9.8-4.9z"/>
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 w-[15px] h-[15px] rounded-full bg-yellow-400 border-2 border-white"></span>
                </button>
            @endauth
        </div>

        {{-- Logo --}}
        <img src="{{ asset('img/logo-full.svg') }}" alt="Coffee Dat" class="relative z-20 h-14 mx-auto">

        {{-- Buscador --}}
        <div class="relative z-20 w-full flex justify-center px-6">
            <form action="{{ Route::has('productos.buscar') ? route('productos.buscar') : '#' }}" method="GET" class="relative w-full max-w-[700px]">
                <input
                    type="text"
                    name="q"
                    placeholder="Buscar en Coffee Dat..."
                    class="w-full rounded-full py-3 pl-5 pr-14 text-sm text-gray-700 placeholder-gray-400 shadow-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black hover:bg-gray-800 flex items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </button>
            </form>
        </div>

    </header>

    {{-- ==========================================
            NAVBAR (fijo justo debajo del header)
    =========================================== --}}
    @include('cliente.partials.navbar')

    {{-- ==========================================
            CONTENIDO PRINCIPAL
    =========================================== --}}
    <main class="min-h-screen bg-gray-50" style="padding-top:240px; padding-bottom:40px;">
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8" x-data="cartLogic()">
            
            <h1 class="text-3xl font-extrabold text-[#1a202c] mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h12M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                </svg>
                Carrito de Compras
            </h1>

            {{-- Si hay sesión iniciar_compra, se abrirá el modal automáticamente (ver script al final) --}}
            
            {{-- MODAL PROCESO DE COMPRA --}}
            <div x-show="showCheckoutModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 sm:p-6" style="display: none;" x-transition.opacity>
                
                {{-- Contenedor Principal del Modal --}}
                <div class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden flex flex-col relative max-h-[90vh]" @click.away="showCheckoutModal = false" x-show="showCheckoutModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-8">
                    
                    {{-- Header --}}
                    <div class="px-8 py-6 flex items-center justify-between border-b border-gray-100 bg-white z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#16a34a] rounded-xl flex items-center justify-center shadow-lg shadow-green-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-black text-gray-900 leading-tight">Finalizar Compra</h2>
                                <p class="text-sm text-gray-500 font-medium">Confirma tus datos de envío y pago</p>
                            </div>
                        </div>
                        <button @click="showCheckoutModal = false" class="text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full p-2 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </div>

                    {{-- Stepper Progress --}}
                    <div class="flex border-b border-gray-100 bg-white">
                        <div class="flex-1 text-center py-4 font-bold text-sm transition" :class="step === 1 ? 'text-[#16a34a] border-b-2 border-[#16a34a]' : 'text-gray-400'">
                            1. Envío
                        </div>
                        <div class="flex-1 text-center py-4 font-bold text-sm transition" :class="step === 2 ? 'text-[#16a34a] border-b-2 border-[#16a34a]' : 'text-gray-400'">
                            2. Pago
                        </div>
                        <div class="flex-1 text-center py-4 font-bold text-sm text-gray-400">
                            3. Confirmación
                        </div>
                    </div>

                    {{-- Cuerpo Desplazable --}}
                    <div class="flex-1 overflow-y-auto p-8 bg-white pb-32">
                        <form action="{{ route('checkout.procesar') }}" method="POST" id="checkout-form">
                            @csrf
                            <input type="hidden" name="modo" value="{{ $modo ?? '' }}">
                            
                            {{-- PASO 1: Envío --}}
                            <div x-show="step === 1" x-transition.opacity x-data="{ formNuevaDir: {{ session('show_form_nueva_dir') || $errors->any() ? 'true' : 'false' }} }">
                                <h2 class="text-2xl font-black text-gray-900 mb-6">¿Dónde quieres recibirlo?</h2>
                                <h3 class="font-bold text-gray-900 mb-1">Elige dónde quieres recibir tu compra</h3>
                                <p class="text-sm text-gray-500 mb-6">Selecciona una dirección o agrega una nueva</p>
                                
                                @if($errors->any())
                                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                                        <p class="text-red-700 font-bold text-sm">Por favor corrige los errores del formulario de dirección.</p>
                                    </div>
                                @endif
                                
                                @if(isset($direcciones) && count($direcciones) > 0)
                                    <div class="space-y-4 mb-6">
                                        @foreach($direcciones as $index => $direccion)
                                        <label class="block border-2 rounded-2xl p-5 cursor-pointer relative transition has-[:checked]:border-[#16a34a] has-[:checked]:bg-green-50/30 border-gray-200 hover:border-green-300">
                                            <input type="radio" name="direccion_id" value="{{ $direccion->id }}" {{ $index === count($direcciones) - 1 ? 'checked' : '' }} class="absolute opacity-0">
                                            
                                            {{-- Ãcono Editar --}}
                                            <button type="button" @click.prevent="editDirId = {{ $direccion->id }}" class="absolute top-4 right-4 text-gray-400 hover:text-[#16a34a] transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                  <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.379-8.379-2.828-2.828z" />
                                                </svg>
                                            </button>

                                            <div class="flex items-start gap-4">
                                                <div class="mt-1 w-10 h-10 rounded-xl bg-green-100 text-[#16a34a] flex items-center justify-center flex-shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <span id="display_nombre_direccion_{{ $direccion->id }}" class="font-extrabold text-gray-800 uppercase tracking-widest text-xs">{{ $direccion->nombre_direccion }}</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#16a34a] check-icon hidden" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <p id="display_nombre_completo_{{ $direccion->id }}" class="font-extrabold text-gray-900 text-[15px] mb-1">{{ $direccion->nombre_completo }}</p>
                                                    <p id="display_direccion_{{ $direccion->id }}" class="text-gray-500 text-[13px] leading-relaxed">
                                                        <span class="dir-line1">{{ $direccion->direccion }}</span><br>
                                                        <span class="dir-line2">{{ $direccion->municipio }}, {{ $direccion->departamento }}</span>
                                                    </p>
                                                    <p id="display_referencias_{{ $direccion->id }}" class="text-gray-400 text-[12px] mt-1 items-start gap-1" style="display: {{ $direccion->referencias ? 'flex' : 'none' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mt-0.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                                                        <span class="ref-text">{{ $direccion->referencias }}</span>
                                                    </p>
                                                    <p id="display_telefono_{{ $direccion->id }}" class="text-gray-500 text-[13px] flex items-center gap-1 mt-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#16a34a]" viewBox="0 0 20 20" fill="currentColor"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" /></svg>
                                                        <span class="tel-text">{{ $direccion->telefono }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </label>
                                        
                                        {{-- FORMULARIO DE EDICIÃ“N (INLINE) --}}
                                        <div id="edit-container-{{ $direccion->id }}" x-show="editDirId === {{ $direccion->id }}" x-collapse class="mt-4 mb-6 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm relative">
                                            <button type="button" @click="editDirId = null" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                            </button>
                                            <h4 class="font-bold text-gray-800 mb-4">Editar Dirección</h4>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                {{-- Tipo de Dirección --}}
                                                <div class="md:col-span-2">
                                                    <select name="nombre_direccion" :required="editDirId === {{ $direccion->id }}" :disabled="editDirId !== {{ $direccion->id }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm text-gray-700">
                                                        <option value="" disabled>Tipo de dirección (Casa, Trabajo, etc) *</option>
                                                        <option value="Casa" {{ $direccion->nombre_direccion == 'Casa' ? 'selected' : '' }}>Casa</option>
                                                        <option value="Trabajo" {{ $direccion->nombre_direccion == 'Trabajo' ? 'selected' : '' }}>Trabajo</option>
                                                        <option value="Otro" {{ $direccion->nombre_direccion == 'Otro' ? 'selected' : '' }}>Otro</option>
                                                    </select>
                                                </div>
                                                
                                                {{-- Nombre Completo --}}
                                                <div>
                                                    <input type="text" name="nombre_completo" value="{{ $direccion->nombre_completo }}" placeholder="Nombre completo *" :required="editDirId === {{ $direccion->id }}" :disabled="editDirId !== {{ $direccion->id }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm">
                                                </div>
                                                
                                                {{-- Teléfono --}}
                                                <div>
                                                    <input type="text" name="telefono" value="{{ $direccion->telefono }}" placeholder="Teléfono *" :required="editDirId === {{ $direccion->id }}" :disabled="editDirId !== {{ $direccion->id }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm">
                                                </div>
                                                
                                                {{-- Dirección Completa --}}
                                                <div class="md:col-span-2">
                                                    <input type="text" name="direccion" value="{{ $direccion->direccion }}" placeholder="Dirección completa (Calle 10 # 5-20) *" :required="editDirId === {{ $direccion->id }}" :disabled="editDirId !== {{ $direccion->id }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm">
                                                </div>
                                                
                                                {{-- Departamento --}}
                                                <div>
                                                    <input type="text" name="departamento" value="{{ $direccion->departamento }}" placeholder="Departamento *" :required="editDirId === {{ $direccion->id }}" :disabled="editDirId !== {{ $direccion->id }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm">
                                                </div>
                                                
                                                {{-- Municipio --}}
                                                <div>
                                                    <input type="text" name="municipio" value="{{ $direccion->municipio }}" placeholder="Municipio *" :required="editDirId === {{ $direccion->id }}" :disabled="editDirId !== {{ $direccion->id }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm">
                                                </div>
                                                
                                                {{-- Código Postal --}}
                                                <div>
                                                    <input type="text" name="codigo_postal" value="{{ $direccion->codigo_postal }}" placeholder="Código Postal (Opcional)" :disabled="editDirId !== {{ $direccion->id }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm">
                                                </div>
                                                
                                                {{-- Referencias --}}
                                                <div class="md:col-span-2">
                                                    <textarea name="referencias" rows="2" placeholder="Referencias (Opcional)" :disabled="editDirId !== {{ $direccion->id }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm resize-none">{{ $direccion->referencias }}</textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-4 flex justify-end">
                                                <button type="button" @click.prevent="updateDir({{ $direccion->id }}, '{{ route('direcciones.update', $direccion->id) }}')" class="bg-[#16a34a] hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition">
                                                    Guardar Cambios
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <button x-show="!formNuevaDir" type="button" @click="formNuevaDir = true" class="w-full border-2 border-dashed border-gray-300 rounded-2xl p-4 text-center font-bold text-gray-500 hover:border-gray-400 hover:text-gray-700 hover:bg-gray-50 transition flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                    </svg>
                                    Agregar nueva dirección
                                </button>
                                
                                <div x-show="formNuevaDir" id="nueva-direccion-container" class="mt-6 bg-white border border-green-200 rounded-2xl p-6 shadow-sm relative" style="display: none;">
                                    @if(isset($direcciones) && count($direcciones) > 0)
                                    <button type="button" @click="formNuevaDir = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 font-bold text-[13px] flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                        Volver
                                    </button>
                                    @endif
                                    
                                    <div class="flex items-center gap-2 mb-1">
                                        <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                        <h4 class="font-extrabold text-gray-800 text-lg">Nueva Dirección de Envío</h4>
                                    </div>
                                    <p class="text-[11px] text-gray-400 mb-6 ml-7">Completa los datos para agregar tu dirección</p>
                                    
                                    <input type="hidden" name="from_checkout" value="1" :disabled="!formNuevaDir">
                                    
                                    <div class="flex flex-col gap-4">
                                        <div class="flex flex-col md:flex-row gap-4">
                                            {{-- Tipo de Dirección --}}
                                            <div class="md:w-1/3">
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Tipo de dirección *</label>
                                                <select name="nombre_direccion" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm text-gray-600 h-[46px] font-medium">
                                                    <option value="" disabled selected>Selecciona</option>
                                                    <option value="Casa">Casa</option>
                                                    <option value="Trabajo">Trabajo</option>
                                                    <option value="Otro">Otro</option>
                                                </select>
                                            </div>
                                            
                                            {{-- Nombre Completo --}}
                                            <div class="md:w-2/3">
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Nombre completo *</label>
                                                <input type="text" name="nombre_completo" placeholder="Quien recibe" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-col md:flex-row gap-4">
                                            {{-- Teléfono --}}
                                            <div class="md:w-1/3">
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Teléfono *</label>
                                                <input type="text" name="telefono" placeholder="3001234567" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                            </div>
                                            
                                            {{-- Dirección Completa --}}
                                            <div class="md:w-2/3">
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Dirección completa *</label>
                                                <input type="text" name="direccion" placeholder="Calle 10 # 5-20" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            {{-- Departamento --}}
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Departamento *</label>
                                                <input type="text" name="departamento" placeholder="Ej: Huila" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                            </div>
                                            
                                            {{-- Municipio --}}
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Municipio *</label>
                                                <input type="text" name="municipio" placeholder="Ej: Pitalito" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                            </div>
                                            
                                            {{-- Código Postal --}}
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Código Postal</label>
                                                <input type="text" name="codigo_postal" placeholder="Opcional" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                            </div>
                                        </div>
                                        
                                        {{-- Referencias --}}
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Referencias (Opcional)</label>
                                            <textarea name="referencias" rows="2" placeholder="Ej: Casa blanca con portón negro" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm resize-none text-gray-600 placeholder-gray-400 font-medium"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-5 border border-gray-200 rounded-xl p-3.5 flex items-center gap-3">
                                        <input type="checkbox" name="is_principal" class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500 cursor-pointer">
                                        <span class="text-[13px] text-gray-500 font-medium cursor-pointer" onclick="this.previousElementSibling.click()">Guardar como dirección principal</span>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button type="submit" formaction="{{ route('direcciones.store') }}" formmethod="POST" class="w-full bg-[#1da44a] hover:bg-green-700 text-white font-extrabold py-3.5 rounded-xl shadow-[0_4px_14px_0_rgba(22,163,74,0.39)] hover:shadow-[0_6px_20px_rgba(22,163,74,0.23)] hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 text-base">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                              <path d="M8 2a1 1 0 000 2h2a1 1 0 100-2H8z" />
                                              <path d="M3 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V9zM7 9a1 1 0 00-2 0v4a1 1 0 102 0V9z" />
                                            </svg>
                                            Guardar y Continuar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- PASO 2: Pago --}}
                            <div x-show="step === 2" x-transition.opacity style="display: none;">
                                
                                <button type="button" @click="step = 1" class="text-[#16a34a] text-sm font-bold flex items-center gap-1 mb-4 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Volver a Envío
                                </button>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-1">Elige tu método de pago</h3>
                                <p class="text-sm text-gray-500 mb-6">Selecciona cómo deseas pagar tu compra</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="border-2 rounded-2xl p-6 cursor-pointer relative transition has-[:checked]:border-[#16a34a] has-[:checked]:bg-green-50/50 border-gray-200 hover:border-green-300 flex flex-col items-center justify-center text-center">
                                        <input type="radio" name="metodo_pago" value="Nequi" checked class="absolute opacity-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#16a34a] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                        <span class="block font-extrabold text-gray-800 text-lg">Nequi</span>
                                        <span class="block text-gray-500 text-sm mt-1">Transferencia directa</span>
                                    </label>
                                    
                                    <label class="border-2 rounded-2xl p-6 cursor-pointer relative transition has-[:checked]:border-[#16a34a] has-[:checked]:bg-green-50/50 border-gray-200 hover:border-green-300 flex flex-col items-center justify-center text-center">
                                        <input type="radio" name="metodo_pago" value="Daviplata" class="absolute opacity-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                        <span class="block font-extrabold text-gray-800 text-lg">Daviplata</span>
                                        <span class="block text-gray-500 text-sm mt-1">Transferencia directa</span>
                                    </label>

                                    <label class="border-2 rounded-2xl p-6 cursor-pointer relative transition has-[:checked]:border-[#16a34a] has-[:checked]:bg-green-50/50 border-gray-200 hover:border-green-300 flex flex-col items-center justify-center text-center">
                                        <input type="radio" name="metodo_pago" value="PSE" class="absolute opacity-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        <span class="block font-extrabold text-gray-800 text-lg">PSE</span>
                                        <span class="block text-gray-500 text-sm mt-1">Pago seguro en línea</span>
                                    </label>

                                    <label class="border-2 rounded-2xl p-6 cursor-pointer relative transition has-[:checked]:border-[#16a34a] has-[:checked]:bg-green-50/50 border-gray-200 hover:border-green-300 flex flex-col items-center justify-center text-center">
                                        <input type="radio" name="metodo_pago" value="Tarjeta" class="absolute opacity-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                        <span class="block font-extrabold text-gray-800 text-lg">Tarjeta</span>
                                        <span class="block text-gray-500 text-sm mt-1">Crédito o Débito</span>
                                    </label>
                                </div>
                            </div>

                            {{-- PASO 3: Confirmación --}}
                            <div x-show="step === 3" x-transition.opacity style="display: none;">
                                <h3 class="text-xl font-bold text-gray-900 mb-1">Confirma tu pedido</h3>
                                <p class="text-sm text-gray-500 mb-6">Revisa que todo esté correcto antes de finalizar</p>
                                
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-full bg-green-100 text-[#16a34a] flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 font-bold">Total a Pagar</p>
                                            <p class="text-2xl font-black text-[#16a34a]" x-text="formatMoney(total)"></p>
                                        </div>
                                    </div>
                                    <hr class="border-gray-200 my-4">
                                    <ul class="text-sm text-gray-600 space-y-2">
                                        <li class="flex items-start gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                                            <span>La dirección seleccionada en el <strong>Paso 1</strong> será usada para el envío.</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" /><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" /></svg>
                                            <span>El método de pago elegido en el <strong>Paso 2</strong> será procesado.</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            {{-- PASO 4: Ã‰xito --}}
                            <div x-show="step === 4" x-transition.opacity style="display: none;" class="py-10 flex flex-col items-center justify-center text-center">
                                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6 shadow-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#16a34a]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <h3 class="text-3xl font-black text-gray-900 mb-2">¡Pedido Confirmado!</h3>
                                <p class="text-gray-500 mb-8 max-w-sm">Tu compra se ha procesado correctamente. En breve prepararemos tus productos.</p>
                                
                                <a href="{{ route('cuenta.pedidos') ?? '#' }}" class="bg-[#16a34a] hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-full shadow-[0_4px_14px_0_rgba(22,163,74,0.39)] transition-all duration-200">
                                    Ir a Mis Pedidos
                                </a>
                            </div>

                        </form>
                    </div>

                    {{-- Footer Sticky (Oculto en paso 4) --}}
                    <div x-show="step !== 4" class="absolute bottom-0 left-0 w-full bg-white border-t border-gray-100 p-6 shadow-[0_-10px_20px_rgba(0,0,0,0.02)] flex flex-col sm:flex-row items-center justify-between gap-4 z-20">
                        <div class="w-full sm:w-auto text-center sm:text-left">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Monto Total</p>
                            <p class="text-3xl font-black text-[#16a34a]" x-text="formatMoney(total)"></p>
                        </div>
                        
                        <div class="w-full sm:w-auto flex flex-col-reverse sm:flex-row items-center gap-3">
                            {{-- Botón Regresar (Solo en paso 3) --}}
                            <button x-show="step === 3" @click="step = 2" type="button" class="w-full sm:w-auto text-gray-500 hover:text-gray-800 font-bold py-3.5 px-6 rounded-full transition duration-300">
                                Regresar
                            </button>
                            
                            {{-- Botones de Continuar --}}
                            <button x-show="step === 1" @click="step = 2" type="button" class="w-full sm:w-auto bg-[#16a34a] hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-full flex items-center justify-center gap-2 transition duration-300 shadow-lg text-lg">
                                Continuar
                            </button>
                            
                            <button x-show="step === 2" @click="step = 3" type="button" class="w-full sm:w-auto bg-[#16a34a] hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-full flex items-center justify-center gap-2 transition duration-300 shadow-lg text-lg" style="display: none;">
                                Continuar
                            </button>
                            
                            {{-- Botón Finalizar --}}
                            <button id="btn-finalizar-compra" x-show="step === 3" @click.prevent="submitCheckout('{{ route('checkout.procesar') }}')" type="button" class="w-full sm:w-auto bg-[#1da44a] hover:bg-green-700 text-white font-black py-3.5 px-8 rounded-full flex items-center justify-center gap-2 transition duration-300 shadow-[0_4px_14px_0_rgba(22,163,74,0.39)] hover:-translate-y-0.5 text-lg" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Finalizar compra
                            </button>
                        </div>
                    </div>

                    {{-- CSS helper para mostrar el check verde si el label tiene :has(:checked) --}}
                    <style>
                        label:has(input:checked) .check-icon { display: block; }
                    </style>


                </div>
            </div>

            @if(count($carrito) > 0)
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    {{-- Lado Izquierdo: Lista de Productos --}}
                    <div class="flex-1 flex flex-col gap-4">
                        
                        {{-- Cabecera: Seleccionar todo --}}
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center justify-between">
                            <label class="flex items-center gap-3 cursor-pointer text-gray-700 font-medium">
                                <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-500" 
                                       :checked="allSelected" @change="toggleAll($event)">
                                Seleccionar todo
                            </label>
                            <span class="text-gray-400 text-sm font-medium">{{ count($carrito) }} producto(s)</span>
                        </div>

                        {{-- Lista de items --}}
                        @foreach($carrito as $item)
                        @php
                            $producto = $item['producto'];
                        @endphp
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-col sm:flex-row items-center gap-6 relative">
                            
                            {{-- Checkbox --}}
                            <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-500 flex-shrink-0" 
                                   value="{{ $producto->id }}" x-model.number="selected">

                            {{-- Imagen --}}
                            <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                @if($producto->imagenPrincipal)
                                    <img src="{{ asset('storage/' . $producto->imagenPrincipal->url_imagen) }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('img/producto-default.png') }}" alt="Producto" class="w-full h-full object-cover">
                                @endif
                            </div>

                            {{-- Detalles --}}
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-800">{{ $producto->nombre }}</h3>
                                <p class="text-gray-400 text-sm mb-3">{{ $producto->categoria->nombre ?? 'General' }}</p>

                                <div class="flex items-center gap-4">
                                    {{-- Controles de cantidad con form --}}
                                    <form action="{{ route('carrito.actualizar', $producto->id) }}" method="POST" class="flex items-center border border-gray-300 rounded-lg overflow-hidden h-9 w-28 bg-white">
                                        @csrf
                                        <button type="submit" name="cantidad" value="{{ $item['cantidad'] - 1 }}" class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-black transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                        </button>
                                        <input type="text" value="{{ $item['cantidad'] }}" class="w-full h-full text-center font-bold text-sm focus:outline-none border-none pointer-events-none p-0" readonly>
                                        <button type="submit" name="cantidad" value="{{ $item['cantidad'] + 1 }}" {{ $item['cantidad'] >= $producto->stock_disponible ? 'disabled' : '' }} class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-black transition {{ $item['cantidad'] >= $producto->stock_disponible ? 'opacity-50 cursor-not-allowed' : '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                        </button>
                                    </form>

                                    <span class="text-gray-400 text-xs font-medium">
                                        $ {{ number_format($producto->precio_venta, 0, ',', '.') }} COP c/u
                                    </span>
                                </div>
                            </div>

                            {{-- Total y Eliminar --}}
                            <div class="flex flex-col items-end gap-2 justify-center ml-auto">
                                <span class="text-xl font-extrabold text-gray-900">
                                    $ {{ number_format($item['subtotal'], 0, ',', '.') }} COP
                                </span>
                                
                                <form action="{{ route('carrito.eliminar', $producto->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition p-1" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                        </div>
                        @endforeach

                    </div>

                    {{-- Lado Derecho: Resumen --}}
                    <div class="w-full lg:w-[350px] flex-shrink-0">
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sticky top-44">
                            <h2 class="text-xl font-extrabold text-gray-900 mb-6">Resumen</h2>

                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-500 font-medium">Subtotal</span>
                                <span class="font-bold text-gray-800" x-text="formatMoney(total)"></span>
                            </div>

                            <div class="flex justify-between items-center mb-6">
                                <span class="text-gray-500 font-medium">Envío</span>
                                <span class="font-bold text-green-500">Gratis</span>
                            </div>

                            <hr class="border-gray-200 mb-6">

                            <div class="flex justify-between items-center mb-8">
                                <span class="text-gray-900 font-bold text-lg">Total</span>
                                <span class="text-2xl font-extrabold text-gray-900" x-text="formatMoney(total)"></span>
                            </div>

                            @auth
                                <button type="button" 
                                   @click="submitCompra($event, true)"
                                   :disabled="selected.length === 0"
                                   :class="selected.length > 0 ? 'bg-green-600 hover:bg-green-700 text-white cursor-pointer' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                   class="w-full font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition duration-300">
                                    Comprar
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            @else
                                <a href="{{ route('carrito.comprar') }}" 
                                   @click="submitCompra($event, false)"
                                   :class="selected.length > 0 ? 'bg-green-600 hover:bg-green-700 text-white cursor-pointer' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                   class="w-full font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition duration-300">
                                    Comprar
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            @endauth

                            <div class="mt-4 flex items-center justify-center gap-2 text-gray-400 text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Pago 100% seguro
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center flex flex-col items-center justify-center min-h-[350px]">
                    
                    {{-- Icono caja --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-[#cbd5e1] mb-6" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm4.707 3.707a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L8.414 9H10a3 3 0 013 3v1a1 1 0 102 0v-1a5 5 0 00-5-5H8.414l1.293-1.293z" clip-rule="evenodd" />
                    </svg>

                    <p class="text-[#94a3b8] font-medium text-[15px] mb-5">
                        Tu carrito está vacío. ¡Anímate a agregar productos!
                    </p>

                    <a href="{{ route('inicio') }}" class="text-[#22c55e] font-bold hover:text-green-700 transition">
                        Explorar productos
                    </a>
                </div>
            @endif

        </div>

    </main>

    {{-- ==========================================
            FOOTER
    =========================================== --}}
    <footer style="background-color:#0f172a; color:#cbd5e1; margin-top:2.5rem;">

        <div style="max-width:1280px; margin:0 auto; padding:32px 24px; display:grid; grid-template-columns:1fr; gap:32px;" class="footer-grid">

            <div>
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <div style="width:40px; height:40px; border-radius:8px; background-color:#1e293b; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                        <img src="{{ asset('img/logo-full.svg') }}" alt="Coffee Dat" style="width:24px; height:24px; object-fit:contain;">
                    </div>
                    <span style="color:#fff; font-size:1.125rem; font-weight:700;">COFFEE<span style="color:#22c55e;">.</span>DAT</span>
                </div>
                <p style="font-size:0.875rem; line-height:1.6; color:#94a3b8;">
                    La mejor plataforma para gestionar y adquirir el mejor café y
                    productos relacionados, directo a tu puerta con la mejor calidad.
                </p>
            </div>

            <div>
                <h4 style="color:#fff; font-weight:600; margin-bottom:16px;">Enlaces Rápidos</h4>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px; font-size:0.875rem;">
                    <li><a href="{{ url('/') }}" style="color:#cbd5e1; text-decoration:none;">Inicio</a></li>
                    <li><a href="#" style="color:#cbd5e1; text-decoration:none;">Nuestros Productos</a></li>
                    <li><a href="#" style="color:#cbd5e1; text-decoration:none;">Sobre Nosotros</a></li>
                    <li><a href="#" style="color:#cbd5e1; text-decoration:none;">Contacto</a></li>
                </ul>
            </div>

            <div>
                <h4 style="color:#fff; font-weight:600; margin-bottom:16px;">Contacto</h4>
                <ul style="list-style:none; padding:0; margin:0 0 20px 0; display:flex; flex-direction:column; gap:12px; font-size:0.875rem;">
                    <li style="display:flex; align-items:center; gap:10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>info@coffeedat.com</span>
                    </li>
                    <li style="display:flex; align-items:center; gap:10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.05 11.05 0 005.516 5.517l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>+1 234 567 890</span>
                    </li>
                </ul>

                <div style="display:flex; gap:12px;">
                    <a href="#" aria-label="Facebook" class="footer-social" style="width:36px; height:36px; border-radius:50%; background-color:#1e293b; display:flex; align-items:center; justify-content:center; text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 24 24">
                            <path d="M22 12a10 10 0 10-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0022 12z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="footer-social" style="width:36px; height:36px; border-radius:50%; background-color:#1e293b; display:flex; align-items:center; justify-content:center; text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 24 24">
                            <path d="M12 2.2c3.2 0 3.6 0 4.9.07 1.2.06 2 .25 2.4.42.6.24 1 .53 1.5 1a4 4 0 011 1.5c.17.4.36 1.2.42 2.4.06 1.3.07 1.7.07 4.9s0 3.6-.07 4.9c-.06 1.2-.25 2-.42 2.4a4 4 0 01-1 1.5 4 4 0 01-1.5 1c-.4.17-1.2.36-2.4.42-1.3.06-1.7.07-4.9.07s-3.6 0-4.9-.07c-1.2-.06-2-.25-2.4-.42a4 4 0 01-1.5-1 4 4 0 01-1-1.5c-.17-.4-.36-1.2-.42-2.4C2.2 15.6 2.2 15.2 2.2 12s0-3.6.07-4.9c.06-1.2.25-2 .36-2.4a4 4 0 011-1.5 4 4 0 011.2-.79c.37-.14.93-.31 1.95-.36C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.15 0-3.52 0-4.76.07-1.02.05-1.58.22-1.95.36-.49.19-.84.42-1.2.79-.37.36-.6.71-.79 1.2-.14.37-.31.93-.36 1.95C2.8 8.48 2.8 8.85 2.8 12s0 3.52.07 4.76c.05 1.02.22 1.58.36 1.95.19.49.42.84.79 1.2.36.37.71.6 1.2.79.37.14.93.31 1.95.36 1.24.07 1.61.07 4.76.07s3.52 0 4.76-.07c1.02-.05 1.58-.22 1.95-.36.49-.19.84-.42 1.2-.79.37-.36.6-.71.79-1.2.14-.37.31-.93.36-1.95.07-1.24.07-1.61.07-4.76s0-3.52-.07-4.76c-.05-1.02-.22-1.58-.36-1.95a3.2 3.2 0 00-.79-1.2 3.2 3.2 0 00-1.2-.79c-.37-.14-.93-.31-1.95-.36C15.52 4 15.15 4 12 4zm0 3.6a4.4 4.4 0 110 8.8 4.4 4.4 0 010-8.8zm0 1.8a2.6 2.6 0 100 5.2 2.6 2.6 0 000-5.2zm4.6-2a1 1 0 110 2 1 1 0 010-2z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Twitter" class="footer-social" style="width:36px; height:36px; border-radius:50%; background-color:#1e293b; display:flex; align-items:center; justify-content:center; text-decoration:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 24 24">
                            <path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.2-.8.5-1.7.8-2.6 1a4.1 4.1 0 00-7 3.7A11.6 11.6 0 013 4.6a4.1 4.1 0 001.3 5.5c-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4a4.1 4.1 0 01-1.9.1c.5 1.6 2.1 2.8 3.9 2.9A8.2 8.2 0 012 18.4a11.6 11.6 0 006.3 1.8c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.1z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <div style="border-top:1px solid #1e293b;">
            <div style="max-width:1280px; margin:0 auto; padding:16px 24px; text-align:center; font-size:0.875rem; color:#64748b;">
                &copy; {{ date('Y') }} Coffee Dat. Todos los derechos reservados.
            </div>
        </div>

    </footer>

    <style>
        .footer-social:hover {
            background-color: #16a34a !important;
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }
    </style>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 1500)" 
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-green-600 text-white px-5 py-2.5 rounded-full shadow-lg z-[9999] flex items-center gap-2 font-medium text-sm whitespace-nowrap">
        <svg class="w-5 h-5 text-green-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cartLogic', () => ({
                showCheckoutModal: {{ session('iniciar_compra') ? 'true' : 'false' }},
                step: {{ request('step', 1) }},
                editDirId: null,
                
                // Empieza con todos los productos seleccionados
                selected: [
                    @foreach($carrito as $item)
                        {{ $item['producto']->id }},
                    @endforeach
                ],
                
                // Objeto con los subtotales para poder calcular el total en tiempo real
                items: {
                    @foreach($carrito as $item)
                        {{ $item['producto']->id }}: {{ $item['subtotal'] }},
                    @endforeach
                },

                get allSelected() {
                    let totalItems = Object.keys(this.items).length;
                    return this.selected.length === totalItems && totalItems > 0;
                },

                toggleAll(event) {
                    if (event.target.checked) {
                        this.selected = Object.keys(this.items).map(id => parseInt(id));
                    } else {
                        this.selected = [];
                    }
                },

                get total() {
                    return this.selected.reduce((sum, id) => sum + this.items[id], 0);
                },

                formatMoney(amount) {
                    return '$ ' + new Intl.NumberFormat('es-CO').format(amount) + ' COP';
                },

                submitCompra(e, isLogged) {
                    if (this.selected.length === 0) {
                        e.preventDefault();
                        return;
                    }
                    if (isLogged) {
                        this.showCheckoutModal = true;
                    }
                },
                
                async updateDir(id, url) {
                    let container = document.getElementById('edit-container-' + id);
                    if (!container) return;
                    
                    let inputs = container.querySelectorAll('input, select, textarea');
                    let formData = new FormData();
                    
                    // Laravel requiere el token CSRF y el method PUT
                    let csrf = document.querySelector('meta[name="csrf-token"]') 
                                ? document.querySelector('meta[name="csrf-token"]').content 
                                : document.querySelector('input[name="_token"]').value;
                                
                    formData.append('_token', csrf);
                    formData.append('_method', 'PUT');
                    
                    inputs.forEach(input => {
                        if(input.name && input.name !== '_method' && input.name !== 'from_checkout') {
                            formData.append(input.name, input.value);
                        }
                    });
                    
                    // Add some loading state to the button? Just normal fetch
                    let btn = container.querySelector('button[type="button"]');
                    let originalText = btn.innerHTML;
                    btn.innerHTML = 'Guardando...';
                    btn.disabled = true;
                    
                    try {
                        let response = await fetch(url, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (response.ok) {
                            let data = await response.json();
                            if (data.success) {
                                // Update DOM
                                let d = data.direccion;
                                document.getElementById('display_nombre_direccion_' + id).innerText = d.nombre_direccion;
                                document.getElementById('display_nombre_completo_' + id).innerText = d.nombre_completo;
                                document.getElementById('display_direccion_' + id).innerHTML = `<span class="dir-line1">${d.direccion}</span><br><span class="dir-line2">${d.municipio}, ${d.departamento}</span>`;
                                
                                let refEl = document.getElementById('display_referencias_' + id);
                                if (refEl) {
                                    if (d.referencias) {
                                        refEl.querySelector('.ref-text').innerText = d.referencias;
                                        refEl.style.display = 'flex';
                                    } else {
                                        refEl.style.display = 'none';
                                    }
                                }
                                
                                let telEl = document.getElementById('display_telefono_' + id);
                                if (telEl) telEl.querySelector('.tel-text').innerText = d.telefono;
                                
                                // Cerrar el edit mode
                                this.editDirId = null;
                            }
                        } else {
                            alert('Hubo un error al actualizar los datos. Revisa los campos requeridos.');
                        }
                    } catch (e) {
                        alert('Error de conexión.');
                    } finally {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                },
                
                async submitCheckout(url) {
                    let form = document.getElementById('checkout-form');
                    let formData = new FormData(form);
                    
                    let btn = document.getElementById('btn-finalizar-compra');
                    let originalText = btn.innerHTML;
                    btn.innerHTML = 'Procesando...';
                    btn.disabled = true;
                    
                    try {
                        let response = await fetch(url, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (response.ok) {
                            let data = await response.json();
                            if (data.success) {
                                this.step = 4; // Ir a paso 4 (Ã‰xito)
                            }
                        } else {
                            alert('Hubo un error procesando el pago. Verifica tus datos.');
                        }
                    } catch (e) {
                        alert('Error de conexión al procesar el pedido.');
                    } finally {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                }
            }))
        })
    </script>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 1500)" 
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-green-600 text-white px-5 py-2.5 rounded-full shadow-lg z-[9999] flex items-center gap-2 font-medium text-sm whitespace-nowrap">
        <svg class="w-5 h-5 text-green-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-red-600 text-white px-5 py-2.5 rounded-full shadow-lg z-[9999] flex items-center gap-2 font-medium text-sm whitespace-nowrap">
        <svg class="w-5 h-5 text-red-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('error') }}
    </div>
    @endif
    
    @include('cliente.partials.auth-modals')
    
</body>
</html>
