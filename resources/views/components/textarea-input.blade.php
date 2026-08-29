@props(['disabled' => false])

<textarea @disabled($disabled) {{ $attributes->merge(['class' => 'border-warm-200 focus:border-accent focus:ring-accent rounded-lg shadow-sm text-stone-800 placeholder:text-stone-400']) }}>{{ $slot }}</textarea>
