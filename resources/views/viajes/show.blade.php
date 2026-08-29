<x-app-layout>
    <x-page-header title="{{ $viaje['origen'] }} → {{ $viaje['destino'] }}" description="Detalle de tu viaje publicado.">
        <x-slot:actions>
            <x-secondary-link :href="route('viajes.edit', $modelo)">Editar</x-secondary-link>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <x-card class="overflow-hidden">
                @if ($viaje['imagen_url'] ?? null)
                    <img src="{{ $viaje['imagen_url'] }}" alt="" class="aspect-[16/10] w-full object-cover">
                @else
                    <div class="aspect-[16/10] bg-gradient-to-br from-warm-100 to-warm-200 flex items-center justify-center text-stone-400">
                        Sin foto
                    </div>
                @endif
                <div class="p-6">
                    @if ($viaje['notas'] ?? null)
                        <p class="text-stone-600 leading-relaxed">{{ $viaje['notas'] }}</p>
                    @endif
                </div>
            </x-card>
        </div>

        <div>
            <x-card class="p-6 space-y-4">
                <div>
                    <dt class="text-sm text-muted">Tipo</dt>
                    <dd class="mt-1"><x-badge color="bg-accent-light text-accent-dark">{{ $viaje['tipo_etiqueta'] }}</x-badge></dd>
                </div>
                <div>
                    <dt class="text-sm text-muted">Salida</dt>
                    <dd class="mt-1 font-medium text-stone-800">{{ $viaje['fecha_salida'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-muted">Estado</dt>
                    <dd class="mt-1"><x-badge color="bg-warm-100 text-stone-700">{{ $viaje['estado_etiqueta'] }}</x-badge></dd>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
