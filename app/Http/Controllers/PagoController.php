<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Services\PagoNotificacionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function store(Request $request, Solicitud $solicitud, PagoNotificacionService $service): RedirectResponse
    {
        $this->authorize('pagar', $solicitud);
        $service->procesar($request->user(), $solicitud);

        return redirect()->route('pedidos.show', $solicitud)->with('status', 'Pago procesado. Te enviamos una notificación.');
    }
}
