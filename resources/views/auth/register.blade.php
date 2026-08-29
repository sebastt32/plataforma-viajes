<x-guest-layout>
    <h1 class="text-xl font-semibold text-stone-800 mb-6">Crear cuenta</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" value="Nombre" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Correo" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="rol" value="Quiero registrarme como" />
            <x-select-input id="rol" name="rol" class="block mt-1 w-full" required>
                <option value="">Selecciona un rol</option>
                <option value="viajero" @selected(old('rol') === 'viajero')>Viajero (publico viajes y productos)</option>
                <option value="comprador" @selected(old('rol') === 'comprador')>Comprador (solicito encargos)</option>
            </x-select-input>
            <x-input-error :messages="$errors->get('rol')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirmar contraseña" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end pt-2">
            <x-primary-button>Registrarme</x-primary-button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-muted">
        ¿Ya tienes cuenta?
        <a href="{{ route('login') }}" class="text-accent hover:text-accent-dark font-medium">Entrar</a>
    </p>
</x-guest-layout>
