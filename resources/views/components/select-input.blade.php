@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'border-warm-200 focus:border-accent focus:ring-accent rounded-lg shadow-sm text-stone-800']) }}>
    {{ $slot }}
</select>
