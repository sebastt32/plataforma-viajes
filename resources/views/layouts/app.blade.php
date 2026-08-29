<x-layouts.base>
    <x-slot name="nav">
        @include('layouts.navigation')
    </x-slot>

    <div class="page-container py-8 sm:py-10">
        {{ $slot }}
    </div>
</x-layouts.base>
