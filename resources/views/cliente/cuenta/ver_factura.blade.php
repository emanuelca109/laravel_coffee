<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura POS {{ $pedido->numero_pedido }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">

    <div class="mb-6 flex gap-4">
        <a href="{{ route('cuenta.compras') }}" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition">Volver</a>
        <a href="{{ route('cuenta.compras.factura', $pedido->id) }}" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl flex items-center gap-2 hover:bg-slate-800 transition shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
            Descargar PDF
        </a>
    </div>

    <!-- Contenedor simulando el papel de POS -->
    <div class="bg-white shadow-xl rounded-sm w-[300px] sm:w-[350px] p-6 text-sm text-black" style="font-family: 'Courier New', Courier, monospace;">
        <div class="text-center mb-4">
            <h1 class="font-bold text-xl uppercase">COFFEE.DAT</h1>
            <p class="text-xs">Los mejores granos de café</p>
            <p class="text-xs mt-1">NIT: 900.123.456-7</p>
            <p class="text-xs">Tel: +57 300 123 4567</p>
        </div>

        <div class="border-b border-dashed border-gray-400 my-4"></div>

        <div class="text-center font-bold mb-4">
            FACTURA DE VENTA
        </div>

        <div class="text-xs space-y-1">
            <p><span class="font-bold">Factura No:</span> {{ $pedido->numero_pedido }}</p>
            <p><span class="font-bold">Fecha:</span> {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') }}</p>
            <p><span class="font-bold">Cliente:</span> {{ $pedido->direccion->nombre_contacto ?? auth()->user()->name }}</p>
            <p><span class="font-bold">Documento:</span> {{ $pedido->direccion->documento_identidad ?? 'N/A' }}</p>
            <p><span class="font-bold">Teléfono:</span> {{ $pedido->direccion->telefono ?? 'N/A' }}</p>
            <p><span class="font-bold">Dirección:</span> {{ $pedido->direccion->direccion ?? 'N/A' }}</p>
        </div>

        <div class="border-b border-dashed border-gray-400 my-4"></div>

        <table class="w-full text-xs">
            <thead>
                <tr>
                    <th class="text-left py-1">CANT x ARTICULO</th>
                    <th class="text-right py-1">VALOR</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="2"><div class="border-b border-dashed border-gray-400 my-2"></div></td></tr>
                @foreach($pedido->detalles as $detalle)
                <tr>
                    <td class="py-1 align-top">
                        {{ $detalle->cantidad }} x {{ $detalle->producto ? $detalle->producto->nombre : 'Producto' }}
                        <br>
                        <span class="text-[10px] text-gray-500">${{ number_format($detalle->precio_unitario ?? 0, 0) }} c/u</span>
                    </td>
                    <td class="py-1 align-top text-right font-bold">
                        ${{ number_format($detalle->subtotal ?? 0, 0) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="border-b border-dashed border-gray-400 my-4"></div>

        <div class="text-right mt-2">
            <p class="text-xs"><span class="font-bold">TOTAL A PAGAR:</span> <span class="text-base font-black">${{ number_format($pedido->total ?? 0, 0) }}</span></p>
        </div>

        <div class="border-b border-dashed border-gray-400 my-4"></div>

        <div class="text-xs space-y-1">
            <p><span class="font-bold">Método de pago:</span> {{ optional($pedido->pago)->metodo_pago ?? 'Contra entrega / Pendiente' }}</p>
            <p><span class="font-bold">Estado de pago:</span> {{ optional($pedido->pago)->estado_pago ?? 'Pendiente' }}</p>
        </div>

        <div class="text-center mt-6 text-xs">
            <p class="font-bold">¡GRACIAS POR SU COMPRA!</p>
            <p>Vuelva pronto</p>
            <p class="mt-4 text-[10px] text-gray-400">Generado por Sistema Coffee.Dat</p>
        </div>
    </div>

    <script>
        window.addEventListener('beforeunload', () => {
            if (window.location.pathname.includes('/cuenta') || window.location.pathname.includes('/direcciones') || window.location.pathname.includes('/pedidos') || window.location.pathname.includes('/compras') || window.location.pathname.includes('/seguridad')) {
                sessionStorage.setItem('cuentaScrollPos', window.scrollY);
            }
        });
        window.addEventListener('DOMContentLoaded', () => {
            const scrollPos = sessionStorage.getItem('cuentaScrollPos');
            if (scrollPos && (window.location.pathname.includes('/cuenta') || window.location.pathname.includes('/direcciones') || window.location.pathname.includes('/pedidos') || window.location.pathname.includes('/compras') || window.location.pathname.includes('/seguridad'))) {
                setTimeout(() => window.scrollTo({ top: parseInt(scrollPos), behavior: 'instant' }), 10);
            } else {
                sessionStorage.removeItem('cuentaScrollPos');
            }
        });
    </script>
</body>
</html>
