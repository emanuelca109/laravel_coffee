<?php
$file = 'resources/views/cliente/cuenta/compras.blade.php';
$c = file_get_contents($file);
$c = str_replace('<title>Mis Pedidos', '<title>Mis Compras', $c);
$c = str_replace('<h1 class="text-2xl font-extrabold text-[#1e293b]">Mis Pedidos</h1>', '<h1 class="text-2xl font-extrabold text-[#1e293b]">Mis Compras</h1>', $c);
$c = str_replace('Aún no tienes pedidos', 'Aún no tienes compras entregadas', $c);

// Sidebar updates
$activeClass = 'flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 text-green-700 font-bold transition';
$inactiveClass = 'flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition';

$c = str_replace('href="{{ route(\'cuenta.pedidos\') }}" class="' . $activeClass . '"', 'href="{{ route(\'cuenta.pedidos\') }}" class="' . $inactiveClass . '"', $c);
$c = str_replace('href="{{ route(\'cuenta.compras\') }}" class="' . $inactiveClass . '"', 'href="{{ route(\'cuenta.compras\') }}" class="' . $activeClass . '"', $c);

file_put_contents($file, $c);
echo "Done";
