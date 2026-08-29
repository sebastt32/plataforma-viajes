<x-app-layout>
    <x-page-header title="Panel" description="Resumen de tu actividad en la plataforma." />

    @if (auth()->user()->esViajero())
        <div class="grid gap-4 sm:grid-cols-3 mb-8">
            <x-stat-card label="Viajes publicados" :value="count($viajes)" />
            <x-stat-card label="Productos" :value="count($productos)" />
            <x-stat-card label="Solicitudes pendientes" :value="collect($solicitudes)->where('estado', 'pendiente')->count()" />
        </div>

        <x-card class="p-6">
            <h2 class="section-title mb-4">Acciones rápidas</h2>
            <div class="flex flex-wrap gap-3">
                <x-primary-link :href="route('viajes.create')">Publicar viaje</x-primary-link>
                <x-secondary-link :href="route('productos.create')">Registrar producto</x-secondary-link>
                <x-secondary-link :href="route('solicitudes.index')">Ver solicitudes</x-secondary-link>
            </div>
        </x-card>
    @else
        <div class="grid gap-6 md:grid-cols-2">
            <x-stat-card label="Pedidos activos" :value="count($pedidos)" />
            <x-card class="p-6 flex flex-col justify-center">
                <h2 class="section-title">¿Buscas algo?</h2>
                <p class="text-sm text-muted mt-2">Explora viajes y solicita encargos de viajeros verificados.</p>
                <div class="mt-4">
                    <x-primary-link :href="route('catalogo.index')">Explorar catálogo</x-primary-link>
                </div>
            </x-card>
        </div>
    @endif
</x-app-layout>
