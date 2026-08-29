@props(['label', 'value', 'icon' => null])

<div {{ $attributes->merge(['class' => 'surface-card p-6']) }}>
    <div class="flex items-start justify-between">
        <div>
            <p class="text-sm text-muted">{{ $label }}</p>
            <p class="mt-2 text-3xl font-semibold text-stone-800 tracking-tight">{{ $value }}</p>
        </div>
        @if ($icon)
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-warm-100 text-accent">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
