<!-- Admin SPA & AJAX Engine -->
<div id="admin-toast-container" class="fixed top-6 right-6 z-[9999999] pointer-events-none flex flex-col items-end gap-2.5 max-w-[90vw]"></div>

<style>
@keyframes adminToastIn {
    0% { opacity: 0; transform: translateY(-16px) scale(0.92); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes adminToastOut {
    0% { opacity: 1; transform: translateY(0) scale(1); }
    100% { opacity: 0; transform: translateY(-12px) scale(0.92); }
}
@keyframes adminToastDrain {
    0% { width: 100%; }
    100% { width: 0%; }
}
.admin-toast-enter {
    animation: adminToastIn 0.18s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.admin-toast-leave {
    animation: adminToastOut 0.15s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.admin-toast-progress-bar {
    animation: adminToastDrain 2.2s linear forwards;
}
</style>

<script>
// Admin Toast Notification - Compact, beautiful, super-fast modern pill design
window.showAdminToast = function(message, type = 'success') {
    const container = document.getElementById('admin-toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    const isSuccess = type === 'success';
    const isError = type === 'error';

    toast.className = `admin-toast-enter pointer-events-auto bg-white border border-slate-100 rounded-2xl shadow-[0_12px_32px_-4px_rgba(0,0,0,0.13),0_2px_6px_rgba(0,0,0,0.04)] overflow-hidden flex flex-col cursor-pointer transition-all duration-150 active:scale-95 max-w-sm w-auto`;

    const iconBg = isSuccess ? 'bg-emerald-50 border-emerald-200 text-emerald-600' : (isError ? 'bg-rose-50 border-rose-200 text-rose-500' : 'bg-sky-50 border-sky-200 text-sky-600');
    const barColor = isSuccess ? 'bg-emerald-500' : (isError ? 'bg-rose-500' : 'bg-sky-500');

    const iconSvg = isSuccess 
        ? `<svg class="w-4 h-4 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>`
        : (isError ? `<svg class="w-4 h-4 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>` : `<svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`);

    toast.innerHTML = `
        <div class="px-4 py-2.5 flex items-center gap-3">
            <div class="w-7 h-7 rounded-full border-2 flex items-center justify-center flex-shrink-0 ${iconBg}">
                ${iconSvg}
            </div>
            <div class="text-[#1e293b] font-bold text-xs sm:text-[13px] leading-snug pr-2 select-none">
                ${message}
            </div>
        </div>
        <div class="h-[3px] w-full bg-slate-100 overflow-hidden">
            <div class="h-full ${barColor} admin-toast-progress-bar"></div>
        </div>
    `;

    const closeToast = () => {
        if (toast.classList.contains('admin-toast-leave')) return;
        toast.classList.remove('admin-toast-enter');
        toast.classList.add('admin-toast-leave');
        setTimeout(() => toast.remove(), 160);
    };

    toast.addEventListener('click', closeToast);
    container.appendChild(toast);

    setTimeout(closeToast, 2200);
};

// Admin In-Memory Cache
const adminCache = new Map();

// Prefetch admin pages on hover
window.adminPrefetch = async function(url) {
    if (!url || adminCache.has(url) || url.includes('/logout') || url.includes('#')) return;
    try {
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if (res.ok) {
            const html = await res.text();
            adminCache.set(url, { html, timestamp: Date.now() });
        }
    } catch (e) {}
};

let isAdminNavigating = false;

window.adminApplyNewPage = function(html, url, push = true) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');

    if (doc.title) {
        document.title = doc.title;
    }

    // Sync all CSS styles and stylesheet links from new page head and body
    doc.querySelectorAll('style, link[rel="stylesheet"]').forEach((el, idx) => {
        const idKey = el.tagName === 'STYLE' 
            ? 'style-' + (el.textContent.trim().substring(0, 50).replace(/[^a-zA-Z0-9]/g, '')) + '-' + el.textContent.length
            : (el.href || 'link-' + idx);
            
        if (!document.head.querySelector(`[data-spa-style="${idKey}"]`)) {
            const clone = el.cloneNode(true);
            clone.setAttribute('data-spa-style', idKey);
            document.head.appendChild(clone);
        }
    });

    // Update Header title / content
    const newHeader = doc.querySelector('header');
    const currentHeader = document.querySelector('header');
    if (newHeader && currentHeader) {
        currentHeader.innerHTML = newHeader.innerHTML;
    }

    // Update Main Container (the .left-64 container that holds main, modals, and footer)
    const newContainer = doc.querySelector('.left-64') || doc.querySelector('main');
    const currentContainer = document.querySelector('.left-64') || document.querySelector('main');

    if (newContainer && currentContainer) {
        currentContainer.innerHTML = newContainer.innerHTML;
        if (newContainer.className) currentContainer.className = newContainer.className;

        // Update active sidebar tab
        const sidebarLinks = document.querySelectorAll('aside nav a');
        sidebarLinks.forEach(link => {
            link.classList.remove('active-menu-item', 'bg-white/10', 'text-white', 'border-white', 'font-bold');
            link.classList.add('font-medium', 'text-white/85', 'border-transparent');

            const linkUrl = new URL(link.href, window.location.origin).pathname;
            const currentUrl = new URL(url, window.location.origin).pathname;

            if (linkUrl === currentUrl || (linkUrl !== '/dashboard' && currentUrl.startsWith(linkUrl))) {
                link.classList.remove('font-medium', 'text-white/85', 'border-transparent');
                link.classList.add('active-menu-item', 'bg-white/10', 'text-white', 'border-white', 'font-bold');
            }
        });

        // Clean up any old modals attached directly to document.body from previous page
        document.querySelectorAll('body > [id^="modal"], body > [id*="modal"]').forEach(m => m.remove());

        // Sync new Modals from new page into document.body
        doc.querySelectorAll('body > [id^="modal"], body > [id*="modal"]').forEach(modalEl => {
            document.body.appendChild(modalEl.cloneNode(true));
        });

        // Close any modals that might be open and restore body overflow
        document.body.classList.remove('overflow-hidden');
        document.querySelectorAll('[id^="modal"], .modal').forEach(m => m.classList.add('hidden'));

        // Execute view scripts from the new page
        doc.querySelectorAll('body script:not([src])').forEach(s => {
            if (!s.textContent.includes('adminCache') && !s.textContent.includes('adminApplyNewPage') && !s.textContent.includes('showAdminToast')) {
                try {
                    const newScript = document.createElement('script');
                    newScript.textContent = s.textContent;
                    document.body.appendChild(newScript);
                } catch (err) {}
            }
        });

        // Global context-aware modal helpers
        window.abrirModalProveedor = function() {
            const modal = document.getElementById('modalProveedor');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        };

        window.abrirModalCategoria = function() {
            const modal = document.getElementById('modalCategoria');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        };

        window.abrirModalProducto = function() {
            const modal = document.getElementById('modalProducto');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        };

        window.abrirModal = function() {
            const path = window.location.pathname.toLowerCase();
            let modal = null;
            if (path.includes('proveedor')) {
                modal = document.getElementById('modalProveedor');
            } else if (path.includes('categoria')) {
                modal = document.getElementById('modalCategoria');
            } else if (path.includes('producto')) {
                modal = document.getElementById('modalProducto');
            } else {
                modal = document.querySelector('[id^="modal"]:not(#modalEliminar):not(#modalEditar):not([id*="Editar"]):not([id*="Eliminar"])');
            }
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        };

        window.cerrarModal = function() {
            document.querySelectorAll('[id^="modal"]').forEach(m => m.classList.add('hidden'));
            document.body.classList.remove('overflow-hidden');
            const fileInput = document.getElementById('imagenes_input');
            if (fileInput) fileInput.value = '';
            const previewGal = document.getElementById('galeria_preview');
            if (previewGal) previewGal.innerHTML = '';
            if (typeof dtCrear !== 'undefined') dtCrear = new DataTransfer();
        };

        // Initialize Alpine
        if (window.Alpine) {
            try {
                Alpine.initTree(document.body);
            } catch (e) {}
        }

        currentContainer.scrollTo({ top: 0, behavior: 'instant' });

        if (push) {
            history.pushState({ adminSpa: true, url }, '', url);
        }
    }
};

window.adminSpaNavigate = async function(url, push = true) {
    if (isAdminNavigating) return;
    isAdminNavigating = true;

    // Check in-memory cache (< 15s)
    const cached = adminCache.get(url);
    if (cached && (Date.now() - cached.timestamp < 15000)) {
        window.adminApplyNewPage(cached.html, url, push);
        isAdminNavigating = false;
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.ok ? r.text() : null)
            .then(html => { if (html) adminCache.set(url, { html, timestamp: Date.now() }); });
        return;
    }

    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            window.location.href = url;
            return;
        }

        const html = await response.text();
        adminCache.set(url, { html, timestamp: Date.now() });
        window.adminApplyNewPage(html, url, push);
    } catch (err) {
        window.location.href = url;
    } finally {
        isAdminNavigating = false;
    }
};

function isAdminPath(pathname) {
    const p = (pathname || window.location.pathname).toLowerCase();
    return p.startsWith('/dashboard') || 
           p.startsWith('/productos') || 
           p.startsWith('/categorias') || 
           p.startsWith('/proveedores') || 
           p.startsWith('/inventarios') || 
           p.startsWith('/pedidos') || 
           p.startsWith('/ventas') || 
           p.startsWith('/movimientos') || 
           p.startsWith('/envios') || 
           p.startsWith('/devoluciones');
}

// Lock initial history in admin panel so browser back button cannot navigate back to welcome/storefront
if (window.history && window.history.replaceState) {
    window.history.replaceState({ adminSpa: true, url: window.location.href, adminLock: true }, '', window.location.href);
}

window.addEventListener('popstate', (e) => {
    const targetUrl = window.location.href;
    const targetPath = window.location.pathname;

    // If browser back button tries to navigate outside admin (to '/' or login)
    if (!isAdminPath(targetPath)) {
        // Prevent going to welcome; lock back to dashboard
        window.history.pushState({ adminSpa: true, url: '/dashboard', adminLock: true }, '', '/dashboard');
        window.adminSpaNavigate('/dashboard', false);
        return;
    }

    window.adminSpaNavigate(targetUrl, false);
});

// Interceptor for Admin Links and Form Submissions (Create, Edit, Delete, Filter)
document.addEventListener('DOMContentLoaded', () => {
    // Prefetch on hover
    document.addEventListener('mouseover', (e) => {
        const link = e.target.closest('aside nav a, .left-64 a[href]');
        if (link && link.href && link.origin === window.location.origin) {
            window.adminPrefetch(link.href);
        }
    });

    // Intercept clicks on links
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[href]');
        if (link && link.href) {
            const isSameOrigin = link.origin === window.location.origin;
            const isDownload = link.hasAttribute('download');
            const isTargetBlank = link.target === '_blank';
            const isAnchorOnly = link.getAttribute('href').startsWith('#');
            const isLogout = link.href.includes('/logout') || link.closest('form');

            if (isSameOrigin && !isDownload && !isTargetBlank && !isAnchorOnly && !isLogout) {
                e.preventDefault();
                window.adminSpaNavigate(link.href);
            }
        }
    }, true);

    // Intercept form submissions (Crear / Editar / Eliminar / Filtros)
    document.addEventListener('submit', async (e) => {
        const form = e.target;
        if (!form || !form.action) return;

        // Logout handling
        if (form.action.includes('/logout')) {
            e.preventDefault();
            adminCache.clear();
            try {
                await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
            } catch (err) {}
            window.location.href = '/';
            return;
        }

        e.preventDefault();
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75');
        }

        try {
            const isGet = (form.method || 'GET').toUpperCase() === 'GET';
            let targetUrl = form.action;
            let options = {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html, application/json'
                }
            };

            if (isGet) {
                const params = new URLSearchParams(new FormData(form)).toString();
                targetUrl = targetUrl + (targetUrl.includes('?') ? '&' : '?') + params;
                options.method = 'GET';
            } else {
                options.method = 'POST';
                options.body = new FormData(form);
            }

            const response = await fetch(targetUrl, options);
            const html = await response.text();

            // Clear cache for current view to reflect changes
            adminCache.clear();

            // Determine descriptive action message (Crear, Editar, Eliminar)
            let actionInfo = { message: 'Operación realizada con éxito', type: 'success' };
            if (!isGet) {
                const methodInput = form.querySelector('input[name="_method"]')?.value?.toUpperCase() || '';
                const formMethod = (form.method || 'POST').toUpperCase();
                const actionUrl = (form.action || '').toLowerCase();

                let isDelete = methodInput === 'DELETE';
                let isUpdate = methodInput === 'PUT' || methodInput === 'PATCH';
                let isCreate = !isDelete && !isUpdate && formMethod === 'POST';

                let entity = 'Registro';
                if (actionUrl.includes('/productos')) entity = 'Producto';
                else if (actionUrl.includes('/categorias')) entity = 'Categoría';
                else if (actionUrl.includes('/proveedores')) entity = 'Proveedor';
                else if (actionUrl.includes('/pedidos')) entity = 'Pedido';
                else if (actionUrl.includes('/inventarios')) entity = 'Inventario';
                else if (actionUrl.includes('/envios')) entity = 'Envío';
                else if (actionUrl.includes('/devoluciones')) entity = 'Devolución';

                if (isDelete) {
                    actionInfo = { message: `¡${entity} eliminado correctamente!`, type: 'error' };
                } else if (isUpdate) {
                    actionInfo = { message: `¡${entity} actualizado con éxito!`, type: 'success' };
                } else if (isCreate) {
                    actionInfo = { message: `¡${entity} creado exitosamente!`, type: 'success' };
                }
            }

            window.adminApplyNewPage(html, response.url || window.location.href, true);
            if (!isGet) {
                window.showAdminToast(actionInfo.message, actionInfo.type);
            }
        } catch (err) {
            console.error('Error procesando formulario:', err);
            window.showAdminToast('Error al procesar la solicitud', 'error');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75');
            }
        }
    });
});
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.showAdminToast(@json(session('success')), 'success');
    });
</script>
@endif
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.showAdminToast(@json(session('error')), 'error');
    });
</script>
@endif
