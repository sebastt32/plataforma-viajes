<x-app-layout>
    <x-page-header title="Registrar producto" description="Añade un producto a uno de tus viajes." />

    @if (count($viajes) === 0)
        <x-empty-state
            title="Primero necesitas un viaje"
            description="Publica un viaje antes de registrar productos."
        >
            <x-slot:action>
                <x-primary-link :href="route('viajes.create')">Publicar viaje</x-primary-link>
            </x-slot:action>
        </x-empty-state>
    @else
        <x-card class="p-6 max-w-2xl">
            <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                @csrf
                @include('productos._form')
                <div class="mt-8 flex items-center justify-end gap-3">
                    <x-secondary-link :href="route('productos.index')">Cancelar</x-secondary-link>
                    <x-primary-button>Guardar producto</x-primary-button>
                </div>
            </form>
        </x-card>
    @endif
</x-app-layout>
