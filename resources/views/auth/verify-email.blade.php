<x-guest-layout>
    <h1 class="text-xl font-semibold text-stone-800 mb-2">Verifica tu correo</h1>
    <p class="mb-6 text-sm text-muted">
        Gracias por registrarte. Antes de continuar, verifica tu correo haciendo clic en el enlace que te enviamos. Si no lo recibiste, podemos enviarte otro.
    </p>

    @if (session('status') == 'verification-link-sent')
        <x-alert type="success" class="mb-4">
            Se ha enviado un nuevo enlace de verificación a tu correo.
        </x-alert>
    @endif

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>Reenviar correo</x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-stone-600 hover:text-accent">
                Salir
            </button>
        </form>
    </div>
</x-guest-layout>
