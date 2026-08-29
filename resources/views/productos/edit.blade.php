<x-app-layout>
    <x-page-header title="Editar producto" :description="$producto['nombre'] ?? ''" />

    <x-card class="p-6 max-w-2xl">
        <form method="POST" action="{{ route('productos.update', $modelo) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('productos._form')
            <div class="mt-8 flex items-center justify-end gap-3">
                <x-secondary-link :href="route('productos.index')">Cancelar</x-secondary-link>
                <x-primary-button>Guardar cambios</x-primary-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
