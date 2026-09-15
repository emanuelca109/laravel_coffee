<div id="modalProveedor"
     class="hidden"
     style="position: fixed; inset: 0; z-index: 999999;">

    {{-- Fondo oscuro semitransparente con desenfoque / blur --}}
    <div style="position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.65); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 10;"
         onclick="cerrarModal()"></div>

    {{-- Modal centrado por encima del header --}}
    <div style="position: fixed; inset: 0; z-index: 20; display: flex; align-items: center; justify-content: center; padding: 1.25rem; overflow-y: auto; pointer-events: none;">

        <div style="pointer-events: auto; background: #ffffff; border-radius: 20px; box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1); width: 100%; max-width: 28rem; max-height: calc(100vh - 2.5rem); display: flex; flex-direction: column; overflow: hidden; margin: auto;">

            {{-- Header --}}
            <div style="background-color: #1e293b; padding: 16px 22px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.08); flex-shrink: 0;">

                <h2 style="font-size: 17px; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 10px; margin: 0;">
                    <i class="fa-solid fa-truck-fast" style="color: #4ade80; font-size: 14px;"></i>
                    Nuevo Proveedor
                </h2>

                <button type="button" onclick="cerrarModal()"
                        style="background: rgba(255,255,255,0.1); border: none; color: #ffffff; font-size: 16px; cursor: pointer; line-height: 1; width: 32px; height: 32px; border-radius: 9999px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                        onmouseover="this.style.backgroundColor='rgba(255,255,255,0.2)'"
                        onmouseout="this.style.backgroundColor='rgba(255,255,255,0.1)'">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

            {{-- Body --}}
            <div style="padding: 22px; overflow-y: auto; flex: 1;">

                <form action="{{ route('proveedores.store') }}" method="POST">

                    @csrf

                    <div style="display: flex; flex-direction: column; gap: 14px;">

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Nombre de la Empresa *
                            </label>

                            <input
                                type="text"
                                name="nombre_empresa"
                                placeholder="Ej: Café del Valle S.A.S"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Persona de Contacto
                            </label>

                            <input
                                type="text"
                                name="nombre_proveedor"
                                placeholder="Ej: Juan Pérez"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Teléfono
                            </label>

                            <input
                                type="text"
                                name="telefono"
                                placeholder="Ej: 300 123 4567"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Correo
                            </label>

                            <input
                                type="email"
                                name="correo"
                                placeholder="Ej: contacto@proveedor.com"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Dirección
                            </label>

                            <input
                                type="text"
                                name="direccion"
                                placeholder="Ej: Calle 10 #5-23, Pitalito, Huila"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Estado
                            </label>

                            <div style="position: relative;">

                                <select
                                    name="estado"
                                    style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 36px 9px 12px; font-size: 14px; outline: none; background: #fff; appearance: none; -webkit-appearance: none; -moz-appearance: none; cursor: pointer;"
                                    onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                    onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">

                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>

                                </select>

                                <i class="fa-solid fa-chevron-down"
                                   style="position: absolute; top: 50%; right: 14px; transform: translateY(-50%); font-size: 12px; color: #6b7280; pointer-events: none;"></i>

                            </div>
                        </div>

                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px;">

                        <button
                            type="button"
                            onclick="cerrarModal()"
                            style="padding: 9px 18px; border-radius: 10px; background-color: #e5e7eb; border: none; font-weight: 600; font-size: 14px; cursor: pointer;">

                            Cancelar

                        </button>

                        <button
                            type="submit"
                            style="padding: 9px 18px; border-radius: 10px; background-color: #16a34a; color: #ffffff; border: none; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center;">

                            <i class="fa-solid fa-floppy-disk" style="margin-right: 6px; font-size: 13px;"></i>
                            Guardar

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
    window.abrirModal = window.abrirModalProveedor = function() {
        const modal = document.getElementById('modalProveedor');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    };

    window.cerrarModal = window.cerrarModalProveedor = function() {
        const modal = document.getElementById('modalProveedor');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            window.cerrarModal();
        }
    });

    document.getElementById('modalProveedor')?.addEventListener('click', function (e) {
        if (e.target === this) {
            window.cerrarModal();
        }
    });
</script>