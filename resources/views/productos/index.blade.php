<x-app-layout>
    <x-page-header title="Mis productos" description="Productos que puedes traer en tus viajes (máx. 3 unidades).">
        <x-slot:actions>
            <x-primary-link :href="route('productos.create')">Registrar producto</x-primary-link>
        </x-slot:actions>
    </x-page-header>

    @if (count($productos) === 0)
        <x-empty-state
            title="Sin productos registrados"
            description="Registra los productos que puedes traer en tus viajes."
        >
            <x-slot:action>
                <x-primary-link :href="route('productos.create')">Registrar producto</x-primary-link>
            </x-slot:action>
        </x-empty-state>
    @else
        <x-card class="divide-y divide-warm-200/60 overflow-hidden">
            <div class="hidden md:grid md:grid-cols-12 gap-4 px-6 py-3 bg-warm-50/80 text-xs font-medium uppercase tracking-wide text-muted">
                <div class="col-span-3">Producto</div>
                <div class="col-span-3">Viaje</div>
                <div class="col-span-2">Precio</div>
                <div class="col-span-2">Unidades</div>
                <div class="col-span-2 text-right">Acciones</div>
            </div>
            @foreach ($productos as $producto)
                <div class="p-5 md:px-6 md:py-4 hover:bg-warm-50/30 transition-colors">
                    <div class="md:grid md:grid-cols-12 md:gap-4 md:items-center">
                        <div class="md:col-span-3 font-medium text-stone-800">{{ $producto['nombre'] }}</div>
                        <div class="md:col-span-3 text-sm text-stone-600">
                            {{ $producto['viaje']['origen'] ?? '' }} → {{ $producto['viaje']['destino'] ?? '' }}
                        </div>
                        <div class="md:col-span-2 text-sm font-medium text-stone-800">${{ number_format($producto['precio'], 2) }}</div>
                        <div class="md:col-span-2 text-sm text-stone-600">{{ $producto['cantidad_disponible'] }}/{{ $producto['cantidad_max'] }}</div>
                        <div class="mt-4 md:mt-0 md:col-span-2 flex flex-wrap gap-2 md:justify-end">
                            <x-secondary-link :href="route('productos.edit', $producto['id'])" class="!px-3 !py-1.5 !text-xs">Editar</x-secondary-link>
                            <form method="POST" action="{{ route('productos.destroy', $producto['id']) }}" onsubmit="return confirm('¿Eliminar este producto?')">
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
