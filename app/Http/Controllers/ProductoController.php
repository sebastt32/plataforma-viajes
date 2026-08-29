<?php

namespace App\Http\Controllers;

use App\Http\Requests\Producto\StoreProductoRequest;
use App\Http\Requests\Producto\UpdateProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Http\Resources\ViajeResource;
use App\Models\Producto;
use App\Services\ViajeProductoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function __construct(private ViajeProductoService $service) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Producto::class);

        return view('productos.index', [
            'productos' => ProductoResource::collection($this->service->listarProductos($request->user()))->resolve(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Producto::class);

        return view('productos.create', [
            'viajes' => ViajeResource::collection($this->service->listarViajes($request->user()))->resolve(),
        ]);
    }

    public function store(StoreProductoRequest $request): RedirectResponse
    {
        $this->service->crearProducto(
            $request->user(),
            $request->safe()->except('imagen'),
            $request->file('imagen'),
        );

        return redirect()->route('productos.index')->with('status', 'Producto registrado.');
    }

    public function edit(Request $request, Producto $producto): View
    {
        $this->authorize('update', $producto);

        $producto->load('viaje');

        return view('productos.edit', [
            'producto' => (new ProductoResource($producto))->resolve(),
            'modelo' => $producto,
            'viajes' => ViajeResource::collection($this->service->listarViajes($request->user()))->resolve(),
        ]);
    }

    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $this->service->actualizarProducto($producto, $request->safe()->except('imagen'), $request->file('imagen'));

        return redirect()->route('productos.index')->with('status', 'Producto actualizado.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $this->authorize('delete', $producto);
        $this->service->eliminarProducto($producto);

        return redirect()->route('productos.index')->with('status', 'Producto eliminado.');
    }
}
