<?php

namespace App\Http\Controllers;

use App\Http\Requests\Solicitud\StoreSolicitudRequest;
use App\Http\Resources\SolicitudResource;
use App\Models\Producto;
use App\Models\Solicitud;
use App\Services\SolicitudService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SolicitudController extends Controller
{
    public function __construct(private SolicitudService $service) {}

    public function index(Request $request): View
    {
        return view('solicitudes.index', [
            'solicitudes' => SolicitudResource::collection($this->service->bandejaViajero($request->user()))->resolve(),
        ]);
    }

    public function store(StoreSolicitudRequest $request, Producto $producto): RedirectResponse
    {
        $this->authorize('create', Solicitud::class);

        $this->service->crear($request->user(), $producto, (int) $request->validated('cantidad'));

        return redirect()->route('pedidos.index')->with('status', 'Solicitud enviada. El viajero debe confirmarla.');
    }

    public function pedidos(Request $request): View
    {
        return view('pedidos.index', [
            'pedidos' => SolicitudResource::collection($this->service->pedidosComprador($request->user()))->resolve(),
        ]);
    }

    public function show(Solicitud $solicitud): View
    {
        $this->authorize('view', $solicitud);

        $solicitud->load(['producto.viaje', 'pago']);

        return view('pedidos.show', [
            'pedido' => (new SolicitudResource($solicitud))->resolve(),
            'modelo' => $solicitud,
        ]);
    }

    public function confirmar(Request $request, Solicitud $solicitud): RedirectResponse
    {
        $this->authorize('confirmar', $solicitud);
        $this->service->confirmar($request->user(), $solicitud);

        return back()->with('status', 'Solicitud confirmada.');
    }

    public function rechazar(Request $request, Solicitud $solicitud): RedirectResponse
    {
        $this->authorize('confirmar', $solicitud);
        $this->service->rechazar($request->user(), $solicitud);

        return back()->with('status', 'Solicitud rechazada.');
    }

    public function enCamino(Request $request, Solicitud $solicitud): RedirectResponse
    {
        $this->authorize('confirmar', $solicitud);
        $this->service->marcarEnCamino($request->user(), $solicitud);

        return back()->with('status', 'Pedido marcado en camino.');
    }

    public function entregar(Request $request, Solicitud $solicitud): RedirectResponse
    {
        $this->authorize('confirmar', $solicitud);
        $this->service->marcarEntregada($request->user(), $solicitud);

        return back()->with('status', 'Pedido marcado como entregado.');
    }
}
