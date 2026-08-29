<?php

namespace App\Http\Controllers;

use App\Enums\EstadoViaje;
use App\Enums\TipoViaje;
use App\Http\Requests\Viaje\StoreViajeRequest;
use App\Http\Requests\Viaje\UpdateViajeRequest;
use App\Http\Resources\ViajeResource;
use App\Models\Viaje;
use App\Services\ViajeProductoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ViajeController extends Controller
{
    public function __construct(private ViajeProductoService $service) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Viaje::class);

        return view('viajes.index', [
            'viajes' => ViajeResource::collection($this->service->listarViajes($request->user()))->resolve(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Viaje::class);

        return view('viajes.create', [
            'tipos' => TipoViaje::cases(),
        ]);
    }

    public function store(StoreViajeRequest $request): RedirectResponse
    {
        $this->service->crearViaje(
            $request->user(),
            $request->safe()->except('imagen'),
            $request->file('imagen'),
        );

        return redirect()->route('viajes.index')->with('status', 'Viaje publicado.');
    }

    public function show(Viaje $viaje): View
    {
        $this->authorize('view', $viaje);

        $viaje->load('productos');

        return view('viajes.show', [
            'viaje' => (new ViajeResource($viaje))->resolve(),
            'modelo' => $viaje,
        ]);
    }

    public function edit(Viaje $viaje): View
    {
        $this->authorize('update', $viaje);

        return view('viajes.edit', [
            'viaje' => (new ViajeResource($viaje))->resolve(),
            'modelo' => $viaje,
            'tipos' => TipoViaje::cases(),
            'estados' => EstadoViaje::cases(),
        ]);
    }

    public function update(UpdateViajeRequest $request, Viaje $viaje): RedirectResponse
    {
        $this->service->actualizarViaje(
            $viaje,
            $request->safe()->except('imagen'),
            $request->file('imagen'),
        );

        return redirect()->route('viajes.index')->with('status', 'Viaje actualizado.');
    }

    public function destroy(Viaje $viaje): RedirectResponse
    {
        $this->authorize('delete', $viaje);
        $this->service->eliminarViaje($viaje);

        return redirect()->route('viajes.index')->with('status', 'Viaje eliminado.');
    }
}
