@props(['type' => 'success', 'dismissible' => true])

@php
$styles = match ($type) {
    'error' => 'bg-red-50 border-red-200 text-red-800',
    'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
    default => 'bg-emerald-50 border-emerald-200 text-emerald-800',
};
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    {{ $attributes->merge(['class' => 'mb-4 rounded-lg border p-4 text-sm '.$styles]) }}
>
    <div class="flex items-start justify-between gap-3">
        <div class="flex-1">{{ $slot }}</div>
        @if ($dismissible)
            <button type="button" @click="show = false" class="shrink-0 text-current opacity-60 hover:opacity-100">
                <span class="sr-only">Cerrar</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>
</div>
