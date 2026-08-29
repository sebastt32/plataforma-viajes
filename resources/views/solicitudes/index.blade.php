<x-app-layout>
    <x-page-header title="Solicitudes de compra" description="Gestiona las solicitudes de tus productos." />

    @if (count($solicitudes) === 0)
        <x-empty-state
            title="No hay solicitudes todavía"
            description="Cuando un comprador solicite un producto, aparecerá aquí."
        />
    @else
        <x-card class="divide-y divide-warm-200/60 overflow-hidden">
            <div class="hidden md:grid md:grid-cols-12 gap-4 px-6 py-3 bg-warm-50/80 text-xs font-medium uppercase tracking-wide text-muted">
                <div class="col-span-3">Comprador</div>
                <div class="col-span-3">Producto</div>
                <div class="col-span-1">Cantidad</div>
                <div class="col-span-2">Estado</div>
                <div class="col-span-3 text-right">Acciones</div>
            </div>
            @foreach ($solicitudes as $solicitud)
                <div class="p-5 md:px-6 md:py-4 hover:bg-warm-50/30 transition-colors">
                    <div class="md:grid md:grid-cols-12 md:gap-4 md:items-center">
                        <div class="md:col-span-3 font-medium text-stone-800">{{ $solicitud['comprador']['name'] ?? '' }}</div>
                        <div class="md:col-span-3 text-sm text-stone-600">{{ $solicitud['producto']['nombre'] ?? '' }}</div>
                        <div class="md:col-span-1 text-sm text-stone-600">{{ $solicitud['cantidad'] }}</div>
                        <div class="md:col-span-2">
                            <x-badge :color="$solicitud['estado_color']">{{ $solicitud['estado_etiqueta'] }}</x-badge>
                        </div>
                        <div class="mt-4 md:mt-0 md:col-span-3 flex flex-wrap gap-2 md:justify-end">
                            @if ($solicitud['estado'] === 'pendiente')
                                <form method="POST" action="{{ route('solicitudes.confirmar', $solicitud['id']) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-primary-button class="!px-3 !py-1.5 !text-xs">Confirmar</x-primary-button>
                                </form>
                                <form method="POST" action="{{ route('solicitudes.rechazar', $solicitud['id']) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-danger-button class="!px-3 !py-1.5 !text-xs">Rechazar</x-danger-button>
                                </form>
                            @endif
                            @if ($solicitud['estado'] === 'pagada')
                                <form method="POST" action="{{ route('solicitudes.en-camino', $solicitud['id']) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-primary-button class="!px-3 !py-1.5 !text-xs">En camino</x-primary-button>
                                </form>
                            @endif
                            @if ($solicitud['estado'] === 'en_camino')
                                <form method="POST" action="{{ route('solicitudes.entregar', $solicitud['id']) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-primary-button class="!px-3 !py-1.5 !text-xs">Entregado</x-primary-button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </x-card>
    @endif
</x-app-layout>
