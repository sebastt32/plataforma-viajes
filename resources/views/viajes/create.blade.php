<x-app-layout>
    <x-page-header title="Publicar viaje" description="Comparte los detalles de tu próximo viaje." />

    <x-card class="p-6 max-w-2xl">
        <form method="POST" action="{{ route('viajes.store') }}" enctype="multipart/form-data">
            @csrf
            @include('viajes._form')
            <div class="mt-8 flex items-center justify-end gap-3">
                <x-secondary-link :href="route('viajes.index')">Cancelar</x-secondary-link>
                <x-primary-button>Publicar</x-primary-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
