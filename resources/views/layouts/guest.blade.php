<x-layouts.base>
    <div class="min-h-[calc(100vh-8rem)] flex flex-col items-center justify-center px-4 py-12">
        <a href="{{ route('home') }}" class="text-xl font-semibold text-stone-800 tracking-tight mb-8">
            Viajes y Encargos
        </a>

        <div class="w-full max-w-md surface-card p-8">
            {{ $slot }}
        </div>
    </div>
</x-layouts.base>
