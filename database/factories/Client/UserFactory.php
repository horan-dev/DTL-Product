<?php

namespace Database\Factories\Client;

use Domain\Client\Models\User;
use Illuminate\Support\Str;
use Shared\Bases\BaseFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Client\Models\User>
 */
class UserFactory extends BaseFactory
{
    protected $model = User::class;

    public function fields(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

}
