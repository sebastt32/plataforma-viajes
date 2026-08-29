<x-app-layout>
    <x-page-header title="Mis pedidos" description="Sigue el estado de tus solicitudes de compra." />

    @if (count($pedidos) === 0)
        <x-empty-state
            title="Todavía no tienes pedidos"
            description="Explora el catálogo y solicita productos en viajes disponibles."
        >
            <x-slot:action>
                <x-primary-link :href="route('catalogo.index')">Explorar catálogo</x-primary-link>
            </x-slot:action>
        </x-empty-state>
    @else
        <x-card class="divide-y divide-warm-200/60 overflow-hidden">
            <div class="hidden md:grid md:grid-cols-12 gap-4 px-6 py-3 bg-warm-50/80 text-xs font-medium uppercase tracking-wide text-muted">
                <div class="col-span-4">Producto</div>
                <div class="col-span-3">Destino</div>
                <div class="col-span-1">Cantidad</div>
                <div class="col-span-2">Estado</div>
                <div class="col-span-2 text-right">Acciones</div>
            </div>
            @foreach ($pedidos as $pedido)
                <div class="p-5 md:px-6 md:py-4 hover:bg-warm-50/30 transition-colors">
                    <div class="md:grid md:grid-cols-12 md:gap-4 md:items-center">
                        <div class="md:col-span-4 font-medium text-stone-800">{{ $pedido['producto']['nombre'] ?? '' }}</div>
                        <div class="md:col-span-3 text-sm text-stone-600">{{ $pedido['producto']['viaje']['destino'] ?? '' }}</div>
                        <div class="md:col-span-1 text-sm text-stone-600">{{ $pedido['cantidad'] }}</div>
                        <div class="md:col-span-2">
                            <x-badge :color="$pedido['estado_color']">{{ $pedido['estado_etiqueta'] }}</x-badge>
                        </div>
                        <div class="mt-4 md:mt-0 md:col-span-2 flex md:justify-end">
                            <x-secondary-link :href="route('pedidos.show', $pedido['id'])" class="!px-3 !py-1.5 !text-xs">Seguimiento</x-secondary-link>
                        </div>
                    </div>
                </div>
            @endforeach
        </x-card>
    @endif
</x-app-layout>
