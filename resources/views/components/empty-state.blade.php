@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'surface-card p-10 text-center']) }}>
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-warm-100 text-stone-500">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
    </div>
    <h3 class="mt-4 text-base font-medium text-stone-800">{{ $title }}</h3>
    @if ($description)
        <p class="mt-2 text-sm text-muted max-w-sm mx-auto">{{ $description }}</p>
    @endif
    @isset($action)
        <div class="mt-6">
            {{ $action }}
        </div>
    @endisset
</div>
