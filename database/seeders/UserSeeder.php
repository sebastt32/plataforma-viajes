<?php

namespace Database\Seeders;

use App\Enums\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public const VIAJERO_EMAIL = 'viajero@demo.com';

    public const COMPRADOR_EMAIL = 'comprador@demo.com';

    public const DEMO_PASSWORD = 'password';

    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => self::VIAJERO_EMAIL],
            [
                'name' => 'Ana Viajera',
                'password' => self::DEMO_PASSWORD,
                'rol' => Rol::Viajero,
                'email_verified_at' => now(),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => self::COMPRADOR_EMAIL],
            [
                'name' => 'Carlos Comprador',
                'password' => self::DEMO_PASSWORD,
                'rol' => Rol::Comprador,
                'email_verified_at' => now(),
            ],
        );
    }
}
