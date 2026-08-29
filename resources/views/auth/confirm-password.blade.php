<x-guest-layout>
    <h1 class="text-xl font-semibold text-stone-800 mb-2">Confirmar contraseña</h1>
    <p class="mb-6 text-sm text-muted">
        Esta es un área segura. Confirma tu contraseña para continuar.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end pt-2">
            <x-primary-button>Confirmar</x-primary-button>
        </div>
    </form>
</x-guest-layout>
