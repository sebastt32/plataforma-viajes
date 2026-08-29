<x-app-layout>
    <x-page-header title="Perfil" description="Administra tu información personal y seguridad." />

    <div class="space-y-6 max-w-2xl">
        <x-card class="p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </x-card>

        <x-card class="p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </x-card>

        <x-card class="p-6 sm:p-8">
            @include('profile.partials.delete-user-form')
        </x-card>
    </div>
</x-app-layout>
