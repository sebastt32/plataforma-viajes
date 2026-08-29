<x-app-layout>
    <x-page-header title="Mis viajes" description="Administra los viajes que has publicado.">
        <x-slot:actions>
            <x-primary-link :href="route('viajes.create')">Publicar viaje</x-primary-link>
        </x-slot:actions>
    </x-page-header>

    @if (count($viajes) === 0)
        <x-empty-state
            title="Aún no publicas viajes"
            description="Comparte tu próximo viaje para que otros puedan hacer encargos."
        >
            <x-slot:action>
                <x-primary-link :href="route('viajes.create')">Publicar mi primer viaje</x-primary-link>
            </x-slot:action>
        </x-empty-state>
    @else
        <x-card class="divide-y divide-warm-200/60 overflow-hidden">
            <div class="hidden md:grid md:grid-cols-12 gap-4 px-6 py-3 bg-warm-50/80 text-xs font-medium uppercase tracking-wide text-muted">
                <div class="col-span-3">Ruta</div>
                <div class="col-span-2">Tipo</div>
                <div class="col-span-2">Salida</div>
                <div class="col-span-2">Estado</div>
                <div class="col-span-1">Productos</div>
                <div class="col-span-2 text-right">Acciones</div>
            </div>
            @foreach ($viajes as $viaje)
                <div class="p-5 md:px-6 md:py-4 hover:bg-warm-50/30 transition-colors">
                    <div class="md:grid md:grid-cols-12 md:gap-4 md:items-center">
                        <div class="md:col-span-3">
                            <p class="font-medium text-stone-800">{{ $viaje['origen'] }} → {{ $viaje['destino'] }}</p>
                            <p class="md:hidden text-sm text-muted mt-1">{{ $viaje['tipo_etiqueta'] }} · {{ $viaje['fecha_salida'] }}</p>
                        </div>
                        <div class="hidden md:block md:col-span-2 text-sm text-stone-600">{{ $viaje['tipo_etiqueta'] }}</div>
                        <div class="hidden md:block md:col-span-2 text-sm text-stone-600">{{ $viaje['fecha_salida'] }}</div>
                        <div class="hidden md:block md:col-span-2">
                            <x-badge color="bg-warm-100 text-stone-700">{{ $viaje['estado_etiqueta'] }}</x-badge>
                        </div>
                        <div class="hidden md:block md:col-span-1 text-sm text-stone-600">{{ $viaje['productos_count'] ?? 0 }}</div>
                        <div class="mt-4 md:mt-0 md:col-span-2 flex flex-wrap gap-2 md:justify-end">
                            <x-secondary-link :href="route('viajes.show', $viaje['id'])" class="!px-3 !py-1.5 !text-xs">Ver</x-secondary-link>
                            <x-secondary-link :href="route('viajes.edit', $viaje['id'])" class="!px-3 !py-1.5 !text-xs">Editar</x-secondary-link>
                            <form method="POST" action="{{ route('viajes.destroy', $viaje['id']) }}" onsubmit="return confirm('¿Eliminar este viaje?')">
                                @csrf
                                @method('DELETE')
                                <x-danger-button class="!px-3 !py-1.5 !text-xs">Eliminar</x-danger-button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </x-card>
    @endif
</x-app-layout>
