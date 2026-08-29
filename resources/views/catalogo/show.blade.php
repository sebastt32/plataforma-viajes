<x-public-layout>
    <nav class="mb-6 text-sm text-muted">
        <a href="{{ route('catalogo.index') }}" class="hover:text-accent">Catálogo</a>
        <span class="mx-2">/</span>
        <span class="text-stone-800">{{ $viaje['origen'] }} → {{ $viaje['destino'] }}</span>
    </nav>

    <div class="grid gap-8 lg:grid-cols-5">
        <div class="lg:col-span-3">
            <x-card class="overflow-hidden">
                @if ($viaje['imagen_url'])
                    <img src="{{ $viaje['imagen_url'] }}" alt="{{ $viaje['origen'] }} a {{ $viaje['destino'] }}" class="aspect-[16/10] w-full object-cover">
                @else
                    <div class="aspect-[16/10] bg-gradient-to-br from-warm-100 to-warm-200 flex items-center justify-center text-stone-400">
                        Sin foto — el viajero puede subirla desde su panel
                    </div>
                @endif
                <div class="p-6">
                    <x-badge color="bg-accent-light text-accent-dark">{{ $viaje['tipo_etiqueta'] }}</x-badge>
                    <h1 class="page-title mt-2">{{ $viaje['origen'] }} → {{ $viaje['destino'] }}</h1>
                    @if ($viaje['notas'])
                        <p class="mt-3 text-stone-600 leading-relaxed">{{ $viaje['notas'] }}</p>
                    @endif
                    <dl class="mt-6 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-muted">Salida</dt>
                            <dd class="mt-1 font-medium text-stone-800">{{ $viaje['fecha_salida'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-muted">Viajero</dt>
                            <dd class="mt-1 font-medium text-stone-800">{{ $viaje['viajero']['name'] ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-2">
            @if (count($productos) > 0)
                <h2 class="section-title mb-4">Encargos disponibles</h2>
                <div class="space-y-4">
                    @foreach ($productos as $producto)
                        <x-card class="p-5">
                            @if ($producto['imagen_url'])
                                <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}" class="mb-4 h-32 w-full rounded-lg object-cover">
                            @endif
                            <h3 class="font-medium text-stone-800">{{ $producto['nombre'] }}</h3>
                            @if ($producto['descripcion'])
                                <p class="text-sm text-muted mt-1">{{ $producto['descripcion'] }}</p>
                            @endif
                            <p class="mt-3 text-lg font-semibold text-stone-800">
                                ${{ number_format($producto['precio'], 2) }}
                                <span class="text-sm font-normal text-muted">+ fee ${{ number_format($producto['fee_transporte'], 2) }}</span>
                            </p>
                            <p class="text-xs text-muted mt-1">{{ $producto['cantidad_disponible'] }} / {{ $producto['cantidad_max'] }} disponibles</p>

                            @auth
                                @if (auth()->user()->esComprador() && $producto['cantidad_disponible'] > 0)
                                    <form method="POST" action="{{ route('solicitudes.store', $producto['id']) }}" class="mt-4 flex items-end gap-3">
                                        @csrf
                                        <div>
                                            <x-input-label for="cantidad-{{ $producto['id'] }}" value="Cantidad" />
                                            <x-text-input id="cantidad-{{ $producto['id'] }}" type="number" name="cantidad" min="1" max="{{ $producto['cantidad_disponible'] }}" value="1" class="mt-1 w-20" />
                                        </div>
                                        <x-primary-button>Solicitar</x-primary-button>
                                    </form>
                                @endif
                            @else
                                <x-primary-link :href="route('login')" class="mt-4">Entrar para solicitar</x-primary-link>
                            @endauth
                        </x-card>
                    @endforeach
                </div>
            @else
                <x-card class="p-6 text-center text-muted">
                    Este viaje aún no tiene productos registrados.
                </x-card>
            @endif
        </div>
    </div>
</x-public-layout>
