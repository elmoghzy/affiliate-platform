<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FilamentAdminSeeder extends Seeder
{
    public function run()
    {
        $email = env('FILAMENT_ADMIN_EMAIL', 'admin@example.com');
        $password = env('FILAMENT_ADMIN_PASSWORD', 'password');

        $user = User::updateOrCreate([
            'email' => $email,
        ], [
            'name' => 'Filament Admin',
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Filament admin user created: ' . $email . ' (password: ' . $password . ')');
    }
}
