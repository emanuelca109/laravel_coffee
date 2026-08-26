{{-- Modal Eliminar Categoría --}}
<div id="modalEliminarCategoria"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">

    {{-- Fondo oscuro con efecto blur --}}
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" 
         onclick="cerrarModalEliminar()"></div>

    {{-- Modal card --}}
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 text-center transform transition-all scale-100">
        
        {{-- Icono animado/destacado --}}
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-5">
            <i class="fa-solid fa-trash-can text-4xl text-red-500"></i>
        </div>

        {{-- Textos --}}
        <h3 class="text-2xl font-bold text-gray-800 mb-2">
            ¿Eliminar categoría?
        </h3>
        
        <p class="text-gray-500 text-sm mb-6">
            Estás a punto de eliminar la categoría <br>
            <span id="delete_nombre_categoria" class="font-bold text-gray-800 text-base"></span>.<br>
            Esta acción <span class="font-semibold text-red-500">no se puede deshacer</span>.
        </p>

        {{-- Botones --}}
        <form id="formEliminarCategoria" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex items-center justify-center gap-3">
                <button
                    type="button"
                    onclick="cerrarModalEliminar()"
                    class="flex-1 px-4 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition-colors">
                    Cancelar
                </button> 

                <button
                    type="submit"
                    class="flex-1 px-4 py-3 rounded-2xl bg-red-500 hover:bg-red-600 text-white font-semibold transition-colors shadow-lg shadow-red-500/30">
                    Sí, eliminar
                </button>
            </div>
        </form>

    </div>
</div>

<script>
function abrirModalEliminar(id, nombre)
{
    document.getElementById('delete_nombre_categoria').textContent = '"' + nombre + '"';
    document.getElementById('formEliminarCategoria').action = '/categorias/' + id;
    
    const modal = document.getElementById('modalEliminarCategoria');
    const card = modal.querySelector('.bg-white');
    
    // Preparar estado inicial para animación
    card.classList.add('scale-95', 'opacity-0');
    card.classList.remove('scale-100', 'opacity-100', 'transition-all', 'duration-300');
    
    modal.classList.remove('hidden');
    
    // Forzar reflow
    void card.offsetWidth;
    
    // Activar transición
    card.classList.add('transition-all', 'duration-300', 'scale-100', 'opacity-100');
    card.classList.remove('scale-95', 'opacity-0');
}

function cerrarModalEliminar()
{
    const modal = document.getElementById('modalEliminarCategoria');
    const card = modal.querySelector('.bg-white');
    
    // Efecto de cierre
    card.classList.remove('scale-100', 'opacity-100');
    card.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200); // 200ms para permitir que la transición termine
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('modalEliminarCategoria');
        if (!modal.classList.contains('hidden')) {
            cerrarModalEliminar();
        }
    }
});
</script>
