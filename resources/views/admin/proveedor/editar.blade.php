{{-- Modal Editar Proveedor --}}
<div id="modalEditarProveedor"
     class="hidden"
     style="position: fixed; inset: 0; z-index: 50;">

    {{-- Fondo oscuro --}}
    <div style="position: absolute; inset: 0; background-color: rgba(0,0,0,0.55);"></div>

    {{-- Modal centrado --}}
    <div style="position: relative; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1rem;">

        <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); width: 100%; max-width: 26rem; overflow: hidden;">

            {{-- Header --}}
            <div style="background-color: #1e293b; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">

                <h2 style="font-size: 17px; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 10px; margin: 0;">
                    <i class="fa-solid fa-pen-to-square" style="color: #4ade80; font-size: 14px;"></i>
                    Editar Proveedor
                </h2>

                <button type="button" onclick="cerrarModalEditar()"
                        style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer; line-height: 1;">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

            {{-- Body --}}
            <div style="padding: 20px; max-height: 75vh; overflow-y: auto;">

                <form id="formEditarProveedor" method="POST">

                    @csrf
                    @method('PUT')

                    <div style="display: flex; flex-direction: column; gap: 14px;">

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Nombre de la Empresa *
                            </label>

                            <input
                                type="text"
                                id="edit_nombre_empresa"
                                name="nombre_empresa"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Persona de Contacto
                            </label>

                            <input
                                 type="text"
                                id="edit_contacto"
                                name="nombre_proveedor"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Teléfono
                            </label>

                            <input
                                type="text"
                                id="edit_telefono"
                                name="telefono"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Correo
                            </label>

                            <input
                                type="email"
                                id="edit_correo"
                                name="correo"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Dirección
                            </label>

                            <input
                                type="text"
                                id="edit_direccion"
                                name="direccion"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Estado
                            </label>

                            <div style="position: relative;">

                                <select
                                    id="edit_estado"
                                    name="estado"
                                    style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 36px 9px 12px; font-size: 14px; background: #fff; appearance: none; -webkit-appearance: none; -moz-appearance: none; cursor: pointer;"
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
                            onclick="cerrarModalEditar()"
                            style="padding: 9px 18px; border-radius: 10px; background-color: #e5e7eb; border: none; font-weight: 600; cursor: pointer;">

                            Cancelar

                        </button>

                        <button
                            type="submit"
                            style="padding: 9px 18px; border-radius: 10px; background-color: #16a34a; color: white; border: none; font-weight: 600; cursor: pointer;">

                            <i class="fa-solid fa-pen-to-square" style="margin-right: 6px;"></i>
                            Actualizar

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>

function abrirModalEditar(id, nombre_empresa, contacto, telefono, correo, direccion, estado)
{
    document.getElementById('edit_nombre_empresa').value = nombre_empresa;
    document.getElementById('edit_contacto').value = contacto;
    document.getElementById('edit_telefono').value = telefono;
    document.getElementById('edit_correo').value = correo;
    document.getElementById('edit_direccion').value = direccion;
    document.getElementById('edit_estado').value = estado;

    document.getElementById('formEditarProveedor').action =
        '/proveedores/' + id;

    document.getElementById('modalEditarProveedor')
        .classList.remove('hidden');
}

function cerrarModalEditar()
{
    document.getElementById('modalEditarProveedor')
        .classList.add('hidden');
}

</script>