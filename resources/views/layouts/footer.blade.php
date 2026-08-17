<footer style="background-color:#0f172a; color:#cbd5e1; margin-top:auto; padding: 32px 24px; width: 100%;">

    <div style="max-width:100%; margin:0; padding:0; display:grid; grid-template-columns:1fr; gap:32px;" class="footer-grid">

        <div>
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                <div style="width:40px; height:40px; border-radius:8px; background-color:#1e293b; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                    <img src="{{ asset('img/logo-icon.svg') }}" alt="Coffee Dat" style="width:24px; height:24px; object-fit:contain;">
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
                        <path d="M12 2.2c3.2 0 3.6 0 4.9.07 1.2.06 2 .25 2.4.42.6.24 1 .53 1.5 1a4 4 0 011 1.5c.17.4.36 1.2.42 2.4.06 1.3.07 1.7.07 4.9s0 3.6-.07 4.9c-.06 1.2-.25 2-.42 2.4a4 4 0 01-1 1.5 4 4 0 01-1.5 1c-.4.17-1.2.36-2.4.42-1.3.06-1.7.07-4.9.07s-3.6 0-4.9-.07c-1.2-.06-2-.25-2.4-.42a4 4 0 01-1.5-1 4 4 0 01-1-1.5c-.17-.4-.36-1.2-.42-2.4C2.2 15.6 2.2 15.2 2.2 12s0-3.6.07-4.9c.06-1.2.25-2 .42-2.4a4 4 0 011-1.5 4 4 0 011.5-1c.4-.17 1.2-.36 2.4-.42C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.15 0-3.52 0-4.76.07-1.02.05-1.58.22-1.95.36-.49.19-.84.42-1.2.79-.37.36-.6.71-.79 1.2-.14.37-.31.93-.36 1.95C2.8 8.48 2.8 8.85 2.8 12s0 3.52.07 4.76c.05 1.02.22 1.58.36 1.95.19.49.42.84.79 1.2.36.37.71.6 1.2.79.37.14.93.31 1.95.36 1.24.07 1.61.07 4.76.07s3.52 0 4.76-.07c1.02-.05 1.58-.22 1.95-.36.49-.19.84-.42 1.2-.79.37-.36.6-.71.79-1.2.14-.37.31-.93.36-1.95.07-1.24.07-1.61.07-4.76s0-3.52-.07-4.76c-.05-1.02-.22-1.58-.36-1.95a3.2 3.2 0 00-.79-1.2 3.2 3.2 0 00-1.2-.79c-.37-.14-.93-.31-1.95-.36C15.52 4 15.15 4 12 4zm0 3.6a4.4 4.4 0 110 8.8 4.4 4.4 0 010-8.8zm0 1.8a2.6 2.6 0 100 5.2 2.6 2.6 0 000-5.2zm4.6-2a1 1 0 110 2 1 1 0 010-2z"/>
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
        <div style="max-width:100%; margin:0; padding:16px 24px; text-align:center; font-size:0.875rem; color:#64748b;">
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