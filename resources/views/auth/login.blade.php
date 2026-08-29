<x-guest-layout>
    <h1 class="text-xl font-semibold text-stone-800 mb-6">Entrar</h1>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Correo" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-warm-200 text-accent focus:ring-accent" name="remember">
                <span class="ms-2 text-sm text-stone-600">Recordarme</span>
            </label>
        </div>

        <div class="flex items-center justify-between pt-2">
            @if (Route::has('password.request'))
                <a class="text-sm text-stone-600 hover:text-accent" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif

            <x-primary-button>Entrar</x-primary-button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-muted">
        ¿No tienes cuenta?
        <a href="{{ route('register') }}" class="text-accent hover:text-accent-dark font-medium">Regístrate</a>
    </p>
</x-guest-layout>
