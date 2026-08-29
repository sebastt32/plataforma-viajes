<?php

namespace App\Http\Controllers;

use App\Enums\TipoViaje;
use App\Http\Resources\ProductoResource;
use App\Http\Resources\ViajeResource;
use App\Models\Viaje;
use App\Services\ViajeProductoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogoController extends Controller
{
    public function index(Request $request, ViajeProductoService $service): View
    {
        $viajes = $service->catalogo(
            $request->string('q')->toString() ?: null,
            $request->string('tipo')->toString() ?: null,
        );

        return view('catalogo.index', [
            'viajes' => ViajeResource::collection($viajes)->resolve(),
            'q' => $request->string('q')->toString(),
            'tipo' => $request->string('tipo')->toString(),
            'tipos' => TipoViaje::cases(),
        ]);
    }

    public function show(Viaje $viaje): View
    {
        $viaje->load(['viajero', 'productos']);

        return view('catalogo.show', [
            'viaje' => (new ViajeResource($viaje))->resolve(),
            'productos' => ProductoResource::collection($viaje->productos)->resolve(),
            'modelo' => $viaje,
        ]);
    }
}
