<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductoResource;
use App\Http\Resources\SolicitudResource;
use App\Http\Resources\ViajeResource;
use App\Services\SolicitudService;
use App\Services\ViajeProductoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request, ViajeProductoService $viajes, SolicitudService $solicitudes): View
    {
        $user = $request->user();

        if ($user->esViajero()) {
            return view('dashboard', [
                'viajes' => ViajeResource::collection($viajes->listarViajes($user))->resolve(),
                'productos' => ProductoResource::collection($viajes->listarProductos($user))->resolve(),
                'solicitudes' => SolicitudResource::collection($solicitudes->bandejaViajero($user))->resolve(),
            ]);
        }

        return view('dashboard', [
            'pedidos' => SolicitudResource::collection($solicitudes->pedidosComprador($user))->resolve(),
        ]);
    }
}
