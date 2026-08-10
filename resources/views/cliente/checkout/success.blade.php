<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Gracias por tu compra! | Coffee.Dat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 font-sans">
    
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-12 max-w-lg w-full text-center">
        
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-3xl font-extrabold text-[#1e293b] mb-4">¡Compra Exitosa!</h1>
        <p class="text-gray-500 text-[15px] leading-relaxed mb-6">
            Tu pedido ha sido procesado correctamente y estamos preparando tus productos. 
            Te hemos enviado un correo con los detalles de tu compra.
        </p>

        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 mb-8">
            <div class="flex justify-between items-center mb-3 border-b border-gray-200 pb-3">
                <span class="text-gray-500 font-medium">Nº de Pedido</span>
                <span class="font-bold text-gray-900">{{ $pedido->numero_pedido }}</span>
            </div>
            <div class="flex justify-between items-center mb-3 border-b border-gray-200 pb-3">
                <span class="text-gray-500 font-medium">Fecha</span>
                <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($pedido->fecha)->format('d M, Y') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500 font-medium">Total Pagado</span>
                <span class="text-xl font-extrabold text-green-600">$ {{ number_format($pedido->total, 0, ',', '.') }} COP</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 font-bold py-3 px-6 rounded-xl transition text-center">
                Volver al Inicio
            </a>
            <a href="{{ route('cuenta') }}" class="bg-[#16a34a] hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition text-center flex items-center justify-center gap-2">
                Ir a mi cuenta
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        
    </div>

</body>
</html>
