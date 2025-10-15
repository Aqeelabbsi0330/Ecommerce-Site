<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Cart;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'total_price' => Cart::inRandomOrder()->limit(3)->get()->sum(fn($cart) => $cart->quantity * $cart->product->price),
            'status' => fake()->randomElement(['pending', 'paid', 'shipped']),
        ];
    }
}
