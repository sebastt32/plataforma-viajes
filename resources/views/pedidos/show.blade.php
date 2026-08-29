@php
    $estados = [
        ['key' => 'pendiente', 'label' => 'Pendiente'],
        ['key' => 'confirmada', 'label' => 'Confirmada'],
        ['key' => 'pagada', 'label' => 'Pagada'],
        ['key' => 'en_camino', 'label' => 'En camino'],
        ['key' => 'entregada', 'label' => 'Entregada'],
    ];
    $estadoActual = $pedido['estado'];
    $orden = ['pendiente', 'confirmada', 'pagada', 'en_camino', 'entregada'];
    $indiceActual = array_search($estadoActual, $orden);
    if ($estadoActual === 'rechazada') {
        $indiceActual = -1;
    }
@endphp

<x-app-layout>
    <x-page-header title="Seguimiento del pedido" :description="$pedido['producto']['nombre'] ?? ''" />

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <x-card class="p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="section-title">{{ $pedido['producto']['nombre'] ?? '' }}</h2>
                        <p class="text-sm text-muted mt-1">
                            {{ $pedido['producto']['viaje']['origen'] ?? '' }} → {{ $pedido['producto']['viaje']['destino'] ?? '' }}
                        </p>
                    </div>
                    <x-badge :color="$pedido['estado_color']">{{ $pedido['estado_etiqueta'] }}</x-badge>
                </div>
                <p class="mt-4 text-sm text-stone-600">Cantidad: <span class="font-medium text-stone-800">{{ $pedido['cantidad'] }}</span></p>
            </x-card>

            @if ($pedido['estado'] === 'confirmada')
                @php
                    $precio = ($pedido['producto']['precio'] ?? 0) * $pedido['cantidad'];
                    $fee = ($pedido['producto']['fee_transporte'] ?? 0) * $pedido['cantidad'];
                @endphp
                <x-card class="p-6 bg-warm-50/50">
                    <h3 class="font-medium text-stone-800 mb-4">Resumen de pago</h3>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-muted">Producto</dt>
                            <dd class="text-stone-800">${{ number_format($precio, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-muted">Fee de transporte</dt>
                            <dd class="text-stone-800">${{ number_format($fee, 2) }}</dd>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-warm-200 font-semibold">
                            <dt>Total</dt>
                            <dd>${{ number_format($precio + $fee, 2) }}</dd>
                        </div>
                    </dl>
                    <form method="POST" action="{{ route('pagos.store', $modelo) }}" class="mt-6">
                        @csrf
                        <x-primary-button>Pagar ahora (simulado)</x-primary-button>
                    </form>
                </x-card>
            @endif

            @if ($pedido['pago'])
                <x-card class="p-6">
                    <h3 class="font-medium text-stone-800">Pago registrado</h3>
                    <p class="text-sm text-muted mt-1">Referencia {{ $pedido['pago']['referencia'] }}</p>
                    <p class="mt-2 text-stone-800">${{ number_format($pedido['pago']['total'], 2) }} · {{ $pedido['pago']['estado_etiqueta'] }}</p>
                </x-card>
            @endif
        </div>

        <div>
            <x-card class="p-6">
                <h3 class="section-title mb-6">Estado del pedido</h3>
                @if ($estadoActual === 'rechazada')
                    <x-badge color="bg-red-100 text-red-800">Rechazada</x-badge>
                @else
                    <ol class="relative space-y-0">
                        @foreach ($estados as $i => $paso)
                            @php
                                $indicePaso = array_search($paso['key'], $orden);
                                $completado = $indiceActual !== false && $indicePaso <= $indiceActual;
                                $activo = $paso['key'] === $estadoActual;
                            @endphp
                            <li class="flex gap-4 pb-8 last:pb-0 relative">
                                @if (!$loop->last)
                                    <div class="absolute left-[11px] top-6 bottom-0 w-px {{ $completado ? 'bg-accent' : 'bg-warm-200' }}"></div>
                                @endif
                                <div class="relative z-10 flex h-6 w-6 shrink-0 items-center justify-center rounded-full {{ $completado ? 'bg-accent text-white' : 'bg-warm-100 text-stone-400' }}">
                                    @if ($completado && !$activo)
                                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <span class="h-2 w-2 rounded-full {{ $activo ? 'bg-white' : 'bg-stone-300' }}"></span>
                                    @endif
                                </div>
                                <div class="pt-0.5">
                                    <p class="text-sm font-medium {{ $completado || $activo ? 'text-stone-800' : 'text-stone-400' }}">{{ $paso['label'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
