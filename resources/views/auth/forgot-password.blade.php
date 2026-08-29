<x-guest-layout>
    <h1 class="text-xl font-semibold text-stone-800 mb-2">Recuperar contraseña</h1>
    <p class="mb-6 text-sm text-muted">
        Indica tu correo y te enviaremos un enlace para restablecer tu contraseña.
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Correo" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end pt-2">
            <x-primary-button>Enviar enlace</x-primary-button>
        </div>
    </form>
</x-guest-layout>
