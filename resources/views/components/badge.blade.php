@props(['color' => 'bg-stone-100 text-stone-700'])

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium '.$color]) }}>
    {{ $slot }}
</span>
