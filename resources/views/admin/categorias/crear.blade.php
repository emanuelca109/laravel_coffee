{{-- Modal Nueva Categoría --}}
<div id="modalCategoria"
     class="hidden"
     style="position: fixed; inset: 0; z-index: 50;">

    {{-- Fondo oscuro (nítido, sin blur) --}}
    <div style="position: absolute; inset: 0; background-color: rgba(0,0,0,0.55);"></div>

    {{-- Modal centrado --}}
    <div style="position: relative; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1rem;">

        <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); width: 100%; max-width: 26rem; overflow: hidden;">

            {{-- Header --}}
            <div style="background-color: #1e293b; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">

                <h2 style="font-size: 17px; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 10px; margin: 0;">
                    <i class="fa-solid fa-tags" style="color: #4ade80; font-size: 14px;"></i>
                    Nueva Categoría
                </h2>

                <button type="button" onclick="cerrarModal()"
                        style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer; line-height: 1;">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

            {{-- Body --}}
            <div style="padding: 20px;">

                <form action="{{ route('categorias.store') }}" method="POST">

                    @csrf

                    <div style="display: flex; flex-direction: column; gap: 14px;">

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Nombre *
                            </label>

                            <input
                                type="text"
                                name="nombre"
                                placeholder="Ej: Café de Especialidad"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Descripción
                            </label>

                            <textarea
                                name="descripcion"
                                rows="3"
                                placeholder="Descripción breve..."
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none; font-family: inherit; resize: none;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';"></textarea>
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
    function abrirModal() {
        document.getElementById('modalCategoria').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function cerrarModal() {
        document.getElementById('modalCategoria').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            cerrarModal();
        }
    });

    document.getElementById('modalCategoria')?.addEventListener('click', function (e) {
        if (e.target === this) {
            cerrarModal();
        }
    });
</script>