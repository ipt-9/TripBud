<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt($this->faker->password(12, 16)),
            'theme' => $this->faker->randomElement(['light', 'dark']),
            'language' => $this->faker->randomElement(['en', 'de']),
            'notifications' => $this->faker->boolean,
            'profile_image' => $this->faker->imageUrl(400, 400, 'people'),
            'subscription_plan' => $this->faker->randomElement(['free', 'premium', 'business']),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'payment_method_details' => $this->faker->text(20),
        ];
    }
}
