<?php

$insertLink = <<<HTML
                    </a>
                    <a href="{{ route('cuenta.compras') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        Mis Compras
HTML;

// 1. Insert in cuenta files
$cuentaFiles = [
    'resources/views/cliente/cuenta/index.blade.php',
    'resources/views/cliente/cuenta/pedidos.blade.php',
    'resources/views/cliente/cuenta/seguridad.blade.php'
];

foreach ($cuentaFiles as $file) {
    $content = file_get_contents($file);
    // Find Mis Pedidos link ending tag
    $search = <<<HTML
                        Mis Pedidos
                    </a>
HTML;
    $content = str_replace($search, $search . "\n" . ltrim($insertLink), $content);
    file_put_contents($file, $content);
}

// 2. Replace in direcciones files
$direccionesFiles = [
    'resources/views/cliente/direcciones/index.blade.php',
    'resources/views/cliente/direcciones/create.blade.php',
    'resources/views/cliente/direcciones/edit.blade.php'
];

foreach ($direccionesFiles as $file) {
    $content = file_get_contents($file);
    // Find the Mis Compras href="#" link
    $search = <<<HTML
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        Mis Compras
                    </a>
HTML;
    $replace = <<<HTML
                    <a href="{{ route('cuenta.compras') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        Mis Compras
                    </a>
HTML;
    $content = str_replace($search, $replace, $content);
    file_put_contents($file, $content);
}

echo "Done\n";
