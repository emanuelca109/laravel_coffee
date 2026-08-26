@php
    $direcciones = auth()->check() ? auth()->user()->direcciones : [];
    $producto_id = session('direct_producto_id');
    $producto = \App\Models\Producto::find($producto_id);
    $cantidad = session('compra_directa')[$producto_id]['cantidad'] ?? 1;
    $total = $producto ? $producto->precio_venta * $cantidad : 0;
@endphp

@if($producto)
<div x-data="directCheckoutLogic()" x-show="showCheckoutModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 sm:p-6" x-transition.opacity>
    
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
                    <h2 class="text-xl font-black text-gray-900 leading-tight">Compra Directa</h2>
                    <p class="text-sm text-gray-500 font-medium">{{ $producto->nombre }} x{{ $cantidad }}</p>
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
            <form action="{{ route('checkout.procesar') }}" method="POST" id="direct-checkout-form">
                @csrf
                <input type="hidden" name="modo" value="directo">
                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                <input type="hidden" name="cantidad" value="{{ $cantidad }}">
                
                {{-- PASO 1: Envío --}}
                <div x-show="step === 1" x-transition.opacity x-data="{ formNuevaDir: {{ session('show_form_nueva_dir') || $errors->any() ? 'true' : 'false' }} }">
                    <h2 class="text-2xl font-black text-gray-900 mb-6">¿Dónde quieres recibirlo?</h2>
                    
                    @if($errors->any())
                        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                            <p class="text-red-700 font-bold text-sm">Por favor corrige los errores del formulario de dirección.</p>
                        </div>
                    @endif
                    
                    @if(isset($direcciones) && count($direcciones) > 0)
                        <div class="space-y-4 mb-6">
                            @foreach($direcciones as $index => $direccion)
                            <label class="block border-2 rounded-2xl p-5 cursor-pointer relative transition has-[:checked]:border-[#16a34a] has-[:checked]:bg-green-50/30 border-gray-200 hover:border-green-300">
                                <input type="radio" name="direccion_id" value="{{ $direccion->id }}" {{ $index === 0 ? 'checked' : '' }} class="absolute opacity-0">
                                <div class="flex items-start gap-4">
                                    <div class="mt-1 w-10 h-10 rounded-xl bg-green-100 text-[#16a34a] flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="font-extrabold text-gray-800 uppercase tracking-widest text-xs">{{ $direccion->nombre_direccion }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#16a34a] check-icon hidden" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <p class="font-extrabold text-gray-900 text-[15px] mb-1">{{ $direccion->nombre_completo }}</p>
                                        <p class="text-gray-500 text-[13px] leading-relaxed">
                                            <span>{{ $direccion->direccion }}</span><br>
                                            <span>{{ $direccion->municipio }}, {{ $direccion->departamento }}</span>
                                        </p>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    @endif
                    
                    <button x-show="!formNuevaDir" type="button" @click="formNuevaDir = true" class="w-full border-2 border-dashed border-gray-300 rounded-2xl p-4 text-center font-bold text-gray-500 hover:border-gray-400 hover:text-gray-700 hover:bg-gray-50 transition flex items-center justify-center gap-2 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Agregar nueva dirección
                    </button>
                    
                    <div x-show="formNuevaDir" id="nueva-direccion-container" class="mt-2 bg-white border border-green-200 rounded-2xl p-6 shadow-sm relative mb-6" style="display: none;">
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
                        <input type="hidden" name="direct_buy" value="1" :disabled="!formNuevaDir">
                        
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="md:w-1/3">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Tipo de dirección *</label>
                                    <select name="nombre_direccion" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm text-gray-600 h-[46px] font-medium">
                                        <option value="" disabled selected>Selecciona</option>
                                        <option value="Casa">Casa</option>
                                        <option value="Trabajo">Trabajo</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                                
                                <div class="md:w-2/3">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Nombre completo *</label>
                                    <input type="text" name="nombre_completo" placeholder="Quien recibe" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                </div>
                            </div>
                            
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="md:w-1/3">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Teléfono *</label>
                                    <input type="text" name="telefono" placeholder="3001234567" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                </div>
                                
                                <div class="md:w-2/3">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Dirección completa *</label>
                                    <input type="text" name="direccion" placeholder="Calle 10 # 5-20" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Departamento *</label>
                                    <input type="text" name="departamento" placeholder="Ej: Huila" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Municipio *</label>
                                    <input type="text" name="municipio" placeholder="Ej: Pitalito" :required="formNuevaDir" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1.5">Código Postal</label>
                                    <input type="text" name="codigo_postal" placeholder="Opcional" :disabled="!formNuevaDir" class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-[#16a34a] focus:border-[#16a34a] text-sm h-[46px] text-gray-600 placeholder-gray-400 font-medium">
                                </div>
                            </div>
                            
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
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Confirma tu pedido</h3>
                    
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 text-[#16a34a] flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" /></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-bold">Total a Pagar</p>
                                <p class="text-2xl font-black text-[#16a34a]">${{ number_format($total, 0, ',', '.') }} COP</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- PASO 4: Éxito --}}
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
                <p class="text-3xl font-black text-[#16a34a]">${{ number_format($total, 0, ',', '.') }} COP</p>
            </div>
            
            <div class="w-full sm:w-auto flex flex-col-reverse sm:flex-row items-center gap-3">
                <button x-show="step === 3" @click="step = 2" type="button" class="w-full sm:w-auto text-gray-500 hover:text-gray-800 font-bold py-3.5 px-6 rounded-full transition duration-300">
                    Regresar
                </button>
                
                <button x-show="step === 1" @click="step = 2" type="button" class="w-full sm:w-auto bg-[#16a34a] hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-full transition duration-300 shadow-lg text-lg">
                    Continuar
                </button>
                
                <button x-show="step === 2" @click="step = 3" type="button" class="w-full sm:w-auto bg-[#16a34a] hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-full transition duration-300 shadow-lg text-lg" style="display: none;">
                    Continuar
                </button>
                
                <button id="btn-finalizar-compra-directa" x-show="step === 3" @click.prevent="submitDirectCheckout('{{ route('checkout.procesar') }}')" type="button" class="w-full sm:w-auto bg-[#1da44a] hover:bg-green-700 text-white font-black py-3.5 px-8 rounded-full transition duration-300 shadow-[0_4px_14px_0_rgba(22,163,74,0.39)] text-lg" style="display: none;">
                    Finalizar compra
                </button>
            </div>
        </div>

        <style>
            label:has(input:checked) .check-icon { display: block; }
        </style>
    </div>
</div>

<script>
    function directCheckoutLogic() {
        return {
            showCheckoutModal: true,
            step: 1,
            
            async submitDirectCheckout(url) {
                let form = document.getElementById('direct-checkout-form');
                let formData = new FormData(form);
                
                let btn = document.getElementById('btn-finalizar-compra-directa');
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
                        if(data.success) {
                            this.step = 4;
                        } else {
                            alert('Hubo un problema al procesar tu compra.');
                        }
                    } else {
                        alert('Por favor selecciona una dirección y método de pago.');
                    }
                } catch (e) {
                    alert('Error de conexión.');
                } finally {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            }
        }
    }
</script>
@endif
