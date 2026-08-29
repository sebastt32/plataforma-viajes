@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-white border border-warm-200 rounded-lg text-sm font-medium text-stone-700 hover:bg-warm-50 hover:border-warm-300 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 transition duration-150']) }}>
    {{ $slot }}
</a>
