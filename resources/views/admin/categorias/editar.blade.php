{{-- Modal Editar Categoría --}}
<div id="modalEditarCategoria"
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
                    Editar Categoría
                </h2>

                <button type="button" onclick="cerrarModalEditar()"
                        style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer; line-height: 1;">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

            {{-- Body --}}
            <div style="padding: 20px;">

                <form id="formEditarCategoria" method="POST">

                    @csrf
                    @method('PUT')

                    <div style="display: flex; flex-direction: column; gap: 14px;">

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Nombre *
                            </label>

                            <input
                                type="text"
                                id="edit_nombre"
                                name="nombre"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px;">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Descripción
                            </label>

                            <textarea
                                id="edit_descripcion"
                                name="descripcion"
                                rows="3"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; resize: none;"></textarea>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Estado
                            </label>

                            <select
                                id="edit_estado"
                                name="estado"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px;">

                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>

                            </select>
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

function abrirModalEditar(id, nombre, descripcion, estado)
{
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_descripcion').value = descripcion;
    document.getElementById('edit_estado').value = estado;

    document.getElementById('formEditarCategoria').action =
        '/categorias/' + id;

    document.getElementById('modalEditarCategoria')
        .classList.remove('hidden');
}

function cerrarModalEditar()
{
    document.getElementById('modalEditarCategoria')
        .classList.add('hidden');
}

</script>