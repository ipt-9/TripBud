<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserFactory extends Factory
{
    /**
     * Der Name des entsprechenden Modells.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Definiere das Modellzustand.
     *
     * @return array
     */
    public function definition()
    {
        $rawPassword = $this->faker->password();
        $encryptedPassword = Crypt::encrypt($rawPassword);
        $hashedPassword = Hash::make($encryptedPassword);

        return [
            'full_name' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $hashedPassword,
            'remember_token' => Str::random(10),
        ];
    }
}
