<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function inicio(Request $request)
    {
        if (auth()->check() && session()->has('pending_direct_buy')) {
            $data = session()->pull('pending_direct_buy');
            session()->put('compra_directa', [
                $data['producto_id'] => ['cantidad' => $data['cantidad']]
            ]);
            session()->flash('iniciar_compra', true);
            session()->flash('modo', 'directo');
            session()->flash('direct_producto_id', $data['producto_id']);
        }

        $categorias = Categoria::where('estado', 'Activo')->get();

        $productos = Producto::with(['imagenPrincipal', 'categoria']);

        if ($request->categoria) {
            $productos->where('categoria_id', $request->categoria);
        }

        if ($request->q) {
            $search = $request->q;
            $productos->where(function($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%")
                      ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        $productos = $productos->latest()->get();

        return view('welcome', compact('productos', 'categorias'));
    }


    public function verProducto($id)
    {
        if (auth()->check() && session()->has('pending_direct_buy')) {
            $data = session()->pull('pending_direct_buy');
            session()->put('compra_directa', [
                $data['producto_id'] => ['cantidad' => $data['cantidad']]
            ]);
            session()->flash('iniciar_compra', true);
            session()->flash('modo', 'directo');
            session()->flash('direct_producto_id', $data['producto_id']);
        }

        $producto = Producto::with([
            'categoria',
            'proveedor',
            'imagenes',
            'imagenPrincipal',
            'inventario'
        ])->findOrFail($id);

        return view('cliente.productos.detalles', compact('producto'));
    }

    // Muestra la vista de favoritos con los productos guardados si el usuario ha iniciado sesión
    public function favoritos()
    {
        $favoritos = collect(); // Por defecto, una colección vacía

        // Si el usuario inició sesión, cargamos sus productos favoritos
        if (auth()->check()) {
            $favoritos = auth()->user()->productosFavoritos;
        }

        return view('cliente.favoritos.index', compact('favoritos'));
    }

    // Alternar (agregar o quitar) un producto de favoritos
    public function toggleFavorito($producto_id)
    {
        $user = auth()->user();

        // El método toggle agrega el ID si no existe, o lo quita si ya existe en la tabla pivote
        // Le pasamos un array extra para guardar la 'fecha' actual
        $user->productosFavoritos()->toggle([
            $producto_id => ['fecha' => now()]
        ]);

        // Si venimos de intentar dar like sin login (el middleware guardó la url intentada),
        // queremos redirigir de vuelta a donde estábamos (ej: inicio o detalles) en lugar de quedarnos en la ruta toggle.
        // Redirigimos a la página anterior
        return redirect()->back();
    }

    public function carrito(Request $request)
    {
        $modo = $request->query('modo');
        
        // Obtener el carrito de la sesión correcta
        if ($modo === 'directo' && session()->has('compra_directa')) {
            $carritoSession = session()->get('compra_directa');
        } else {
            $carritoSession = session()->get('carrito', []);
        }
        $carrito = [];
        $total = 0;
        
        $direcciones = [];
        if (auth()->check()) {
            $direcciones = auth()->user()->direcciones;
        }

        if (count($carritoSession) > 0) {
            $ids = array_keys($carritoSession);
            $productos = Producto::whereIn('id', $ids)->get();

            foreach ($productos as $producto) {
                $cantidad = $carritoSession[$producto->id]['cantidad'];
                $subtotal = $producto->precio_venta * $cantidad;
                $total += $subtotal;

                $carrito[] = [
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal
                ];
            }
        }

        return view('cliente.carrito.index', compact('carrito', 'total', 'direcciones', 'modo'));
    }

    public function compraDirecta(Request $request, $producto_id)
    {
        $cantidad = $request->input('cantidad', 1);
        $producto = Producto::findOrFail($producto_id);

        if ($cantidad > $producto->stock_disponible) {
            return redirect()->back()->with('error', 'Solo hay '.$producto->stock_disponible.' unidades disponibles en stock.');
        }

        // Guardamos el producto único en una sesión aparte
        session()->put('compra_directa', [
            $producto_id => ['cantidad' => $cantidad]
        ]);

        // Redirigimos de vuelta con los datos para abrir el modal en la misma página
        return redirect()->back()->with([
            'iniciar_compra' => true,
            'modo' => 'directo',
            'direct_producto_id' => $producto_id
        ]);
    }

    public function agregarAlCarrito(Request $request, $producto_id)
    {
        if ($request->input('accion') === 'comprar') {
            if (!auth()->check()) {
                session()->put('url.intended', url()->previous());
                session()->put('pending_direct_buy', [
                    'producto_id' => $producto_id,
                    'cantidad' => $request->input('cantidad', 1)
                ]);
                return redirect()->route('login');
            }
            // Si eligen comprar, llamamos a la compra directa sin afectar el carrito
            return $this->compraDirecta($request, $producto_id);
        }

        $carrito = session()->get('carrito', []);
        $cantidad = $request->input('cantidad', 1);
        $producto = Producto::findOrFail($producto_id);

        $cantidadActual = isset($carrito[$producto_id]) ? $carrito[$producto_id]['cantidad'] : 0;
        $nuevaCantidad = $cantidadActual + $cantidad;

        if ($nuevaCantidad > $producto->stock_disponible) {
            return redirect()->back()->with('error', 'No puedes agregar más unidades de las disponibles en stock ('.$producto->stock_disponible.').');
        }

        $carrito[$producto_id] = [
            'cantidad' => $nuevaCantidad
        ];

        session()->put('carrito', $carrito);
        $this->sincronizarCarritoBD();

        return redirect()->back()->with('success', 'Producto añadido al carrito exitosamente');
    }

    public function actualizarCarrito(Request $request, $producto_id)
    {
        $carrito = session()->get('carrito', []);
        $cantidad = $request->input('cantidad', 1);
        $producto = Producto::findOrFail($producto_id);

        if (isset($carrito[$producto_id])) {
            if ($cantidad > $producto->stock_disponible) {
                return redirect()->back()->with('error', 'Solo hay '.$producto->stock_disponible.' unidades disponibles en stock.');
            }

            if ($cantidad > 0) {
                $carrito[$producto_id]['cantidad'] = $cantidad;
            } else {
                unset($carrito[$producto_id]);
            }
            session()->put('carrito', $carrito);
            $this->sincronizarCarritoBD();
        }

        return redirect()->back();
    }

    public function eliminarDelCarrito($producto_id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$producto_id])) {
            unset($carrito[$producto_id]);
            session()->put('carrito', $carrito);
            $this->sincronizarCarritoBD();
        }

        return redirect()->back();
    }

    public function comprarCarrito()
    {
        // Esta ruta está protegida por middleware('auth')
        // Si el usuario llega aquí, significa que está logueado.
        // Lo redirigimos de vuelta al carrito pero con un parámetro o variable de sesión
        // para indicarle que debe seguir con los pasos de compra.
        return redirect()->route('carrito')->with('iniciar_compra', true);
    }

    // Método para mostrar la página de la cuenta del usuario
    public function cuenta()
    {
        if (!auth()->check()) {
            return view('cliente.cuenta.guest');
        }
        
        return view('cliente.cuenta.index');
    }

    public function actualizarPerfil(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'documento' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'documento' => $request->documento,
            'telefono' => $request->telefono,
        ]);

        return redirect()->back()->with('success', 'Perfil actualizado exitosamente.');
    }

    // Método para mostrar la página de seguridad
    public function seguridad()
    {
        return view('cliente.cuenta.seguridad');
    }

    // Método para actualizar la contraseña
    public function actualizarPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Contraseña actualizada exitosamente.');
    }

    public function misPedidos()
    {
        $pedidos = \App\Models\Pedido::with(['detalles.producto.imagenes', 'direccion', 'informacionEnvio'])
            ->where('user_id', auth()->id())
            ->whereNotIn('estado', ['Entregado', 'Devolución solicitada', 'Devuelto'])
            ->latest()
            ->get();

        return view('cliente.cuenta.pedidos', compact('pedidos'));
    }

    public function misCompras()
    {
        // En compras mostramos los pedidos con estado "Entregado", "Devolución solicitada" o "Devuelto"
        $pedidos = \App\Models\Pedido::with(['detalles.producto.imagenes', 'direccion', 'informacionEnvio'])
            ->where('user_id', auth()->id())
            ->whereIn('estado', ['Entregado', 'Devolución solicitada', 'Devuelto'])
            ->latest()
            ->get();

        return view('cliente.cuenta.compras', compact('pedidos'));
    }

    public function solicitarDevolucion(Request $request, $id)
    {
        $pedido = \App\Models\Pedido::where('user_id', auth()->id())
            ->where('id', $id)
            ->where('estado', 'Entregado')
            ->firstOrFail();

        $productosRequest = $request->input('productos', []);
        $cantidadesRequest = $request->input('cantidades', []);
        
        $productosDevueltos = [];
        foreach ($productosRequest as $prodId) {
            if (isset($cantidadesRequest[$prodId])) {
                $productosDevueltos[] = [
                    'producto_id' => $prodId,
                    'cantidad' => $cantidadesRequest[$prodId]
                ];
            }
        }

        \App\Models\Devolucion::create([
            'pedido_id' => $pedido->id,
            'user_id' => auth()->id(),
            'motivo' => $request->input('motivo', 'Sin motivo especificado'),
            'estado' => 'PENDIENTE',
            'productos' => $productosDevueltos
        ]);
            
        $pedido->estado = 'Devolución solicitada';
        $pedido->save();
        
        return redirect()->back()->with('success', 'Tu solicitud de devolución ha sido enviada exitosamente.');
    }

    public function verFactura($id)
    {
        $pedido = \App\Models\Pedido::with(['detalles.producto', 'direccion', 'informacionEnvio', 'pago'])
            ->where('user_id', auth()->id())
            ->where('estado', 'Entregado')
            ->findOrFail($id);

        return view('cliente.cuenta.ver_factura', compact('pedido'));
    }

    public function descargarFactura($id)
    {
        $pedido = \App\Models\Pedido::with(['detalles.producto', 'direccion', 'informacionEnvio', 'pago'])
            ->where('user_id', auth()->id())
            ->where('estado', 'Entregado')
            ->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('cliente.cuenta.factura_pos', compact('pedido'));
        
        // Configurar el papel como Ticket (ancho 80mm aprox 226pt, altura auto)
        $pdf->setPaper([0, 0, 226, 1000], 'portrait');
        return $pdf->download('Factura_POS_' . $pedido->numero_pedido . '.pdf');
    }

    private function sincronizarCarritoBD()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->carrito = json_encode(session()->get('carrito', []));
            $user->save();
        }
    }
}