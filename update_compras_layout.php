<?php
$f = 'resources/views/cliente/cuenta/compras.blade.php';
$c = file_get_contents($f);

// Find the progress bar block
$startMarker = '{{-- Barra de Progreso de Estados --}}';
$endMarker = '{{-- Cuadro: Info de Envío --}}';

$startPos = strpos($c, $startMarker);
$endPos = strpos($c, $endMarker);

if ($startPos !== false && $endPos !== false) {
    // We want to remove everything from $startMarker up to the end of the div containing it,
    // which is just before $endMarker. Actually let's just remove that chunk and a bit before it.
    // Let's use preg_replace for safety or just substr.
    
    // Instead of regex, let's just remove lines 178 to 204.
}

// Alternatively:
$c = preg_replace('/\{\{-- Barra de Progreso de Estados --\}\}.*?<\/div>\s*<\/div>\s*<\/div>/s', '', $c);

// Add "Descargar Factura" button
$footerSearch = <<<HTML
                                <div class="bg-[#1e293b] p-6 flex flex-col sm:flex-row items-center justify-between gap-4 relative z-10">
HTML;

$footerReplace = <<<HTML
                                <div class="bg-[#1e293b] p-6 flex flex-col sm:flex-row items-center justify-between gap-4 relative z-10">
                                    <div>
                                        <a href="{{ route('cuenta.compras.factura', \$pedido->id) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Descargar Factura POS
                                        </a>
                                    </div>
HTML;

$c = str_replace($footerSearch, $footerReplace, $c);

file_put_contents($f, $c);
echo "Done";
