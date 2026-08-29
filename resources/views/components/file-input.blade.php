@props(['name', 'accept' => 'image/*'])

<div {{ $attributes->merge(['class' => 'mt-1']) }}>
    <label for="{{ $name }}" class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-warm-200 bg-warm-50/50 px-4 py-6 hover:border-warm-300 hover:bg-warm-50 transition-colors">
        <svg class="h-8 w-8 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span class="mt-2 text-sm text-stone-600">Seleccionar imagen</span>
        <span class="mt-1 text-xs text-stone-400">PNG, JPG hasta 2MB</span>
        <input id="{{ $name }}" type="file" name="{{ $name }}" accept="{{ $accept }}" class="sr-only">
    </label>
</div>
