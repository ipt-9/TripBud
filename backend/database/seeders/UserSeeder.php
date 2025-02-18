<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Führe die Datenbank-Seeds aus.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->count(10)->create();

        User::factory()->create([
            'full_name' => 'Max Mustermann',
            'username' => 'max123',
            'email' => 'max@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'full_name' => 'Lisa Beispiel',
            'username' => 'lisa456',
            'email' => 'lisa@example.com',
            'password' => Hash::make('secret456'),
        ]);
    }
}
