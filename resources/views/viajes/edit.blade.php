<x-app-layout>
    <x-page-header title="Editar viaje" :description="$viaje['origen'].' → '.$viaje['destino']" />

    <x-card class="p-6 max-w-2xl">
        <form method="POST" action="{{ route('viajes.update', $modelo) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('viajes._form', ['viaje' => $viaje, 'estados' => $estados])
            <div class="mt-8 flex items-center justify-end gap-3">
                <x-secondary-link :href="route('viajes.index')">Cancelar</x-secondary-link>
                <x-primary-button>Guardar</x-primary-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
