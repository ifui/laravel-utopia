<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminUser>
 */
class AdminUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => (string)Str::uuid(),
            'nickname' => $this->faker->unique()->name(4) . $this->faker->unique()->name(2),
            'username' => $this->faker->unique()->userName() . strtoupper(base_convert(time() - 1420070400, 10, 36)),
            'email' => $this->faker->unique()->userName(4) . $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => 'admin',
        ];
    }
}
