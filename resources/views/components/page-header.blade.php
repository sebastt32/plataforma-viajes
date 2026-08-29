@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8']) }}>
    <div>
        <h1 class="page-title">{{ $title }}</h1>
        @if ($description)
            <p class="mt-2 text-muted">{{ $description }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="flex flex-wrap items-center gap-3 shrink-0">
            {{ $actions }}
        </div>
    @endisset
</div>
