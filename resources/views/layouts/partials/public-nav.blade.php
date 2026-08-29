<header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-warm-200/60">
    <div class="page-container h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-base font-semibold text-stone-800 tracking-tight">
            Viajes y Encargos
        </a>
        <nav class="flex items-center gap-6 text-sm">
            <a href="{{ route('catalogo.index') }}"
               class="{{ request()->routeIs('catalogo.*') ? 'text-accent font-medium' : 'text-stone-600 hover:text-stone-800' }}">
                Catálogo
            </a>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'text-accent font-medium' : 'text-stone-600 hover:text-stone-800' }}">
                    Panel
                </a>
            @else
                <a href="{{ route('login') }}" class="text-stone-600 hover:text-stone-800">Entrar</a>
                <a href="{{ route('register') }}" class="text-stone-800 font-medium hover:text-accent">Registrarme</a>
            @endauth
        </nav>
    </div>
</header>
