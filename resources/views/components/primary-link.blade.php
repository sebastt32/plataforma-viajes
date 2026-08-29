@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-warm-800 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-warm-900 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 transition duration-150']) }}>
    {{ $slot }}
</a>
