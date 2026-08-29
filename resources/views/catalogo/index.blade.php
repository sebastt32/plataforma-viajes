<x-public-layout>
    <x-page-header
        title="Viajes disponibles"
        description="Explora rutas y encuentra encargos en viajes de confianza."
    />

    <x-card class="p-5 mb-8">
        <form method="GET" action="{{ route('catalogo.index') }}" class="flex flex-col sm:flex-row gap-3">
            <x-text-input type="search" name="q" :value="$q" class="w-full sm:flex-1" placeholder="Origen, destino o descripción" />
            <x-select-input name="tipo" class="w-full sm:max-w-xs">
                <option value="">Todos los tipos</option>
                @foreach ($tipos as $opcion)
                    <option value="{{ $opcion->value }}" @selected($tipo === $opcion->value)>{{ $opcion->etiqueta() }}</option>
                @endforeach
            </x-select-input>
            <x-primary-button class="shrink-0">Buscar</x-primary-button>
        </form>
    </x-card>

    <div class="mb-8 flex flex-wrap gap-2">
        @foreach ($tipos as $opcion)
            <a href="{{ route('catalogo.index', ['tipo' => $opcion->value, 'q' => $q]) }}"
               class="filter-pill {{ $tipo === $opcion->value ? 'filter-pill-active' : 'filter-pill-inactive' }}">
                {{ $opcion->etiqueta() }}
            </a>
        @endforeach
    </div>

    @if (count($viajes) === 0)
        <x-empty-state
            title="No hay viajes con ese criterio"
            description="Prueba con otros filtros o vuelve más tarde."
        />
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($viajes as $viaje)
                <a href="{{ route('catalogo.show', $viaje['id']) }}" class="surface-card overflow-hidden hover:shadow-card-hover transition-shadow duration-200 group">
                    @if ($viaje['imagen_url'])
                        <img src="{{ $viaje['imagen_url'] }}" alt="{{ $viaje['origen'] }} a {{ $viaje['destino'] }}" class="aspect-[4/3] w-full object-cover">
                    @else
                        <div class="aspect-[4/3] bg-gradient-to-br from-warm-100 to-warm-200 flex items-center justify-center text-stone-400 text-sm">
                            Sin foto
                        </div>
                    @endif
                    <div class="p-5">
                        <x-badge color="bg-accent-light text-accent-dark">{{ $viaje['tipo_etiqueta'] }}</x-badge>
                        <h2 class="font-semibold mt-2 text-stone-800 group-hover:text-accent transition-colors">{{ $viaje['origen'] }} → {{ $viaje['destino'] }}</h2>
                        <p class="text-sm text-muted mt-1">Salida {{ $viaje['fecha_salida'] }}</p>
                        <p class="text-sm text-muted">{{ $viaje['viajero']['name'] ?? 'Viajero' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-public-layout>
