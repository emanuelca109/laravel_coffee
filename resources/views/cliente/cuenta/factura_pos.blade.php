<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura POS {{ $pedido->numero_pedido }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 10px;
            width: 100%;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .mb-2 { margin-bottom: 5px; }
        .mb-4 { margin-bottom: 10px; }
        .mt-4 { margin-top: 10px; }
        
        .divider {
            border-bottom: 1px dashed #000;
            margin: 5px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            text-align: left;
            vertical-align: top;
            padding: 2px 0;
        }
        
        .price-col {
            text-align: right;
            white-space: nowrap;
        }
        
        .header h1 {
            font-size: 16px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
        }
        
        .info-section {
            font-size: 10px;
            margin: 10px 0;
        }
        
        .total-section {
            margin-top: 10px;
            text-align: right;
            font-size: 12px;
        }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <div class="header text-center">
        <h1>COFFEE.DAT</h1>
        <p>Los mejores granos de café</p>
        <p>NIT: 900.123.456-7</p>
        <p>Tel: +57 300 123 4567</p>
    </div>

    <div class="divider"></div>

    <div class="text-center font-bold mb-4 mt-4">
        FACTURA DE VENTA
    </div>

    <div class="info-section">
        <p><strong>Factura No:</strong> {{ $pedido->numero_pedido }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') }}</p>
        <p><strong>Cliente:</strong> {{ $pedido->direccion->nombre_contacto ?? auth()->user()->name }}</p>
        <p><strong>Documento:</strong> {{ $pedido->direccion->documento_identidad ?? 'N/A' }}</p>
        <p><strong>Teléfono:</strong> {{ $pedido->direccion->telefono ?? 'N/A' }}</p>
        <p><strong>Dirección:</strong> {{ $pedido->direccion->direccion ?? 'N/A' }}</p>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>CANT x ARTICULO</th>
                <th class="price-col">VALOR</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="2"><div class="divider"></div></td></tr>
            @foreach($pedido->detalles as $detalle)
            <tr>
                <td>
                    {{ $detalle->cantidad }} x {{ $detalle->producto ? $detalle->producto->nombre : 'Producto' }}
                    <br>
                    <small>${{ number_format($detalle->precio_unitario ?? 0, 0) }} c/u</small>
                </td>
                <td class="price-col font-bold">
                    ${{ number_format($detalle->subtotal ?? 0, 0) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider mt-4"></div>

    <div class="total-section">
        <p><strong>TOTAL A PAGAR:</strong> <span style="font-size: 14px;">${{ number_format($pedido->total ?? 0, 0) }}</span></p>
    </div>

    <div class="divider mt-4"></div>

    <div class="info-section">
        <p><strong>Método de pago:</strong> {{ optional($pedido->pago)->metodo_pago ?? 'Contra entrega / Pendiente' }}</p>
        <p><strong>Estado de pago:</strong> {{ optional($pedido->pago)->estado_pago ?? 'Pendiente' }}</p>
    </div>

    <div class="footer">
        <p class="font-bold">¡GRACIAS POR SU COMPRA!</p>
        <p>Vuelva pronto</p>
        <br>
        <p>Generado por Sistema Coffee.Dat</p>
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
