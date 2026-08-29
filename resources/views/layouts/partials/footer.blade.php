<footer class="mt-auto border-t border-warm-200/60 bg-white/50">
    <div class="page-container py-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-muted">
        <p>&copy; {{ date('Y') }} Viajes y Encargos</p>
        <nav class="flex items-center gap-6">
            <a href="{{ route('catalogo.index') }}" class="hover:text-stone-800">Catálogo</a>
            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-stone-800">Panel</a>
            @else
                <a href="{{ route('login') }}" class="hover:text-stone-800">Entrar</a>
            @endauth
        </nav>
    </div>
</footer>
