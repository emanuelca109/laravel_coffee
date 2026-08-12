<style>
    .input-sin-flechas::-webkit-outer-spin-button,
    .input-sin-flechas::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .input-sin-flechas {
        -moz-appearance: textfield;
    }
</style>

{{-- Modal Editar Producto --}}
<div id="modalEditarProducto"
     class="hidden"
     style="position: fixed; inset: 0; z-index: 50;">

    {{-- Fondo oscuro --}}
    <div style="position: absolute; inset: 0; background-color: rgba(0,0,0,0.55);"></div>

    {{-- Modal centrado --}}
    <div style="position: relative; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1rem;">

        <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); width: 100%; max-width: 30rem; overflow: hidden;">

            {{-- Header --}}
            <div style="background-color: #1e293b; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">

                <h2 style="font-size: 17px; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 10px; margin: 0;">
                    <i class="fa-solid fa-pen-to-square" style="color: #4ade80; font-size: 14px;"></i>
                    Editar Producto
                </h2>

                <button type="button" onclick="cerrarModalEditar()"
                        style="background: none; border: none; color: #ffffff; font-size: 18px; cursor: pointer; line-height: 1;">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

            {{-- Body --}}
            <div style="padding: 20px; max-height: 75vh; overflow-y: auto;">

                <form id="formEditarProducto" method="POST" enctype="multipart/form-data">

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
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Descripción
                            </label>

                            <textarea
                                id="edit_descripcion"
                                name="descripcion"
                                rows="3"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none; font-family: inherit; resize: none;"
                                onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';"></textarea>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Imágenes Guardadas
                            </label>

                            <div id="galeria_guardada" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px; margin-bottom: 10px;"></div>

                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Agregar Nuevas Imágenes
                            </label>

                            <input
                                type="file"
                                id="edit_imagenes_input"
                                name="imagenes[]"
                                accept="image/*"
                                multiple
                                onchange="previewImagenesEditar()"
                                style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 8px 12px; font-size: 13px; outline: none;">

                            <p style="margin: 6px 0 0; font-size: 12px; color: #9ca3af;">
                                Puedes agregar más imágenes. Se combinarán con las existentes.
                            </p>

                            <div id="galeria_preview_editar" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px; margin-top: 10px;"></div>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                Categoría
                            </label>

                            <div style="position: relative;">

                                <select
                                    id="edit_categoria_id"
                                    name="categoria_id"
                                    style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 36px 9px 12px; font-size: 14px; outline: none; background: #fff; appearance: none; -webkit-appearance: none; -moz-appearance: none; cursor: pointer;"
                                    onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                    onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">

                                    <option value="">Selecciona una categoría</option>

                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach

                                </select>

                                <i class="fa-solid fa-chevron-down"
                                   style="position: absolute; top: 50%; right: 14px; transform: translateY(-50%); font-size: 12px; color: #6b7280; pointer-events: none;"></i>

                            </div>
                        </div>

                        <div style="display: flex; gap: 12px;">

                            <div style="flex: 1;">
                                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                    Precio Compra *
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    id="edit_precio_compra"
                                    name="precio_compra"
                                    placeholder="0.00"
                                    class="input-sin-flechas"
                                    style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                    onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                            </div>

                            <div style="flex: 1;">
                                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                    Precio Venta *
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    id="edit_precio_venta"
                                    name="precio_venta"
                                    placeholder="0.00"
                                    class="input-sin-flechas"
                                    style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                    onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                            </div>

                        </div>

                        <div style="display: flex; gap: 12px;">

                            <div style="flex: 1;">
                                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                    Stock Actual *
                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    id="edit_stock_actual"
                                    name="stock_actual"
                                    placeholder="0"
                                    style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                    onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                            </div>

                            <div style="flex: 1;">
                                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                    Stock Mínimo *
                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    id="edit_stock_minimo"
                                    name="stock_minimo"
                                    placeholder="0"
                                    style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 12px; font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                    onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                            </div>

                        </div>

                        <div style="display: flex; gap: 12px;">

                            <div style="flex: 1;">
                                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                    Proveedor *
                                </label>

                                <div style="position: relative;">

                                    <select
                                        id="edit_proveedor_id"
                                        name="proveedor_id"
                                        required
                                        style="width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 9px 36px 9px 12px; font-size: 14px; outline: none; background: #fff; appearance: none; -webkit-appearance: none; -moz-appearance: none; cursor: pointer;"
                                        onfocus="this.style.borderColor='#16a34a'; this.style.boxShadow='0 0 0 2px rgba(22,163,74,0.4)';"
                                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">

                                        <option value="">Selecciona un proveedor</option>

                                        @forelse($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}">
                                                {{ $proveedor->nombre_empresa }}
                                            </option>
                                        @empty
                                            <option value="" disabled>No hay proveedores registrados</option>
                                        @endforelse

                                    </select>

                                    <i class="fa-solid fa-chevron-down"
                                       style="position: absolute; top: 50%; right: 14px; transform: translateY(-50%); font-size: 12px; color: #6b7280; pointer-events: none;"></i>

                                </div>
                            </div>

                            <div style="flex: 1;">
                                <label style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #374151;">
                                    Estado
                                </label>

                                <div style="position: relative;">

                                    <select
                                        id="edit_estado"
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

                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px;">

                        <button
                            type="button"
                            onclick="cerrarModalEditar()"
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

let imagenesGuardadas = [];

function abrirModalEditar(id, nombre, descripcion, categoria_id, precio_compra, precio_venta, stock_actual, stock_minimo, proveedor_id, estado)
{
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_descripcion').value = descripcion;
    document.getElementById('edit_categoria_id').value = categoria_id;
    document.getElementById('edit_precio_compra').value = precio_compra;
    document.getElementById('edit_precio_venta').value = precio_venta;
    document.getElementById('edit_stock_actual').value = stock_actual;
    document.getElementById('edit_stock_minimo').value = stock_minimo;
    document.getElementById('edit_proveedor_id').value = proveedor_id;
    document.getElementById('edit_estado').value = estado;

    document.getElementById('formEditarProducto').action = '/productos/' + id;

    // Cargar imágenes guardadas desde el servidor
    cargarImagenesGuardadas(id);

    // Limpiar input de nuevas imágenes
    document.getElementById('edit_imagenes_input').value = '';
    document.getElementById('galeria_preview_editar').innerHTML = '';

    document.getElementById('modalEditarProducto').classList.remove('hidden');
}

function cerrarModalEditar()
{
    document.getElementById('modalEditarProducto').classList.add('hidden');
    document.getElementById('edit_imagenes_input').value = '';
    document.getElementById('galeria_preview_editar').innerHTML = '';
    imagenesGuardadas = [];
}

function cargarImagenesGuardadas(productoId) {
    // Obtener imágenes del servidor (esto se hace con un fetch)
    fetch(`/api/productos/${productoId}/imagenes`)
        .then(response => response.json())
        .then(imagenes => {
            imagenesGuardadas = imagenes;
            mostrarImagenesGuardadas();
        })
        .catch(error => {
            console.error('Error al cargar imágenes:', error);
        });
}

function eliminarImagenGuardada(id, index) {
    if (confirm('¿Desea eliminar esta imagen permanentemente al guardar el producto?')) {
        const form = document.getElementById('formEditarProducto');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'eliminar_imagenes[]';
        input.value = id;
        form.appendChild(input);

        imagenesGuardadas.splice(index, 1);
        mostrarImagenesGuardadas();
        validarCantidadImagenes();
    }
}

function validarCantidadImagenes() {
    const input = document.getElementById('edit_imagenes_input');
    const guardadas = imagenesGuardadas.length;
    const nuevas = input.files ? input.files.length : 0;
    
    if (guardadas + nuevas > 5) {
        alert(`Un producto puede tener máximo 5 imágenes en total. Tienes ${guardadas} guardadas y quieres agregar ${nuevas}.`);
        input.value = '';
        document.getElementById('galeria_preview_editar').innerHTML = '';
        return false;
    }
    return true;
}

function mostrarImagenesGuardadas() {
    const galeria = document.getElementById('galeria_guardada');
    galeria.innerHTML = '';

    imagenesGuardadas.forEach((imagen, index) => {
        const div = document.createElement('div');
        div.style.position = 'relative';
        div.style.width = '80px';
        div.style.height = '80px';
        div.style.borderRadius = '8px';
        div.style.overflow = 'hidden';
        div.style.background = '#f3f4f6';
        div.style.display = 'flex';
        div.style.alignItems = 'center';
        div.style.justifyContent = 'center';

        let badgeHTML = '';
        if (imagen.principal) {
            badgeHTML = '<div style="position: absolute; top: 2px; left: 2px; background: #16a34a; color: white; font-size: 10px; padding: 2px 4px; border-radius: 3px; font-weight: bold;">Principal</div>';
        }

        let btnEliminar = `<button type="button" onclick="eliminarImagenGuardada(${imagen.id}, ${index})" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; cursor: pointer; font-size: 14px; font-weight: bold; z-index: 10; display: flex; align-items: center; justify-content: center;">&times;</button>`;

        div.innerHTML = `
            ${btnEliminar}
            ${badgeHTML}
            <img src="/storage/${imagen.url_imagen}" alt="Imagen ${index}" style="width: 100%; height: 100%; object-fit: cover;">
        `;

        galeria.appendChild(div);
    });
}

function previewImagenesEditar() {
    if (!validarCantidadImagenes()) return;

    const input = document.getElementById('edit_imagenes_input');
    const galeria = document.getElementById('galeria_preview_editar');
    galeria.innerHTML = '';

    if (input.files && input.files.length > 0) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const div = document.createElement('div');
                div.style.position = 'relative';
                div.style.width = '80px';
                div.style.height = '80px';
                div.style.borderRadius = '8px';
                div.style.overflow = 'hidden';
                div.style.background = '#f3f4f6';
                div.style.display = 'flex';
                div.style.alignItems = 'center';
                div.style.justifyContent = 'center';

                let badgeHTML = '<div style="position: absolute; top: 2px; left: 2px; background: #fbbf24; color: #000; font-size: 10px; padding: 2px 4px; border-radius: 3px; font-weight: bold;">Nueva</div>';

                div.innerHTML = `
                    ${badgeHTML}
                    <img src="${e.target.result}" alt="Preview ${index}" style="width: 100%; height: 100%; object-fit: cover;">
                `;

                galeria.appendChild(div);
            };

            reader.readAsDataURL(file);
        });
    }
}

</script>