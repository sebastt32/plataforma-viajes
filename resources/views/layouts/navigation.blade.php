<nav x-data="{ open: false }" class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-warm-200/60">
    <div class="page-container">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-10">
                <a href="{{ route('home') }}" class="text-base font-semibold text-stone-800 tracking-tight shrink-0">
                    Viajes y Encargos
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Panel
                    </x-nav-link>
                    <x-nav-link :href="route('catalogo.index')" :active="request()->routeIs('catalogo.*')">
                        Catálogo
                    </x-nav-link>
                    @if (Auth::user()->esViajero())
                        <x-nav-link :href="route('viajes.index')" :active="request()->routeIs('viajes.*')">
                            Viajes
                        </x-nav-link>
                        <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                            Productos
                        </x-nav-link>
                        <x-nav-link :href="route('solicitudes.index')" :active="request()->routeIs('solicitudes.*')">
                            Solicitudes
                        </x-nav-link>
                    @endif
                    @if (Auth::user()->esComprador())
                        <x-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.*')">
                            Mis pedidos
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-warm-100 text-stone-600">{{ Auth::user()->rol->etiqueta() }}</span>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-stone-600 hover:text-stone-800 rounded-lg hover:bg-warm-50 transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Perfil
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Salir
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-stone-500 hover:text-stone-700 hover:bg-warm-50 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-warm-200/60 bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Panel</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('catalogo.index')" :active="request()->routeIs('catalogo.*')">Catálogo</x-responsive-nav-link>
            @if (Auth::user()->esViajero())
                <x-responsive-nav-link :href="route('viajes.index')" :active="request()->routeIs('viajes.*')">Viajes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">Productos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('solicitudes.index')" :active="request()->routeIs('solicitudes.*')">Solicitudes</x-responsive-nav-link>
            @endif
            @if (Auth::user()->esComprador())
                <x-responsive-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.*')">Mis pedidos</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-4 border-t border-warm-200/60">
            <div class="px-4 flex items-center gap-2">
                <div class="font-medium text-stone-800">{{ Auth::user()->name }}</div>
                <span class="text-xs px-2 py-0.5 rounded-full bg-warm-100 text-stone-600">{{ Auth::user()->rol->etiqueta() }}</span>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Perfil</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        Salir
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
