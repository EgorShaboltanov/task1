<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

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

     protected $model = Order::class;  // связана с моделью Order

    public function definition(): array
    {
        return [
            'provider_id' => random_int(1,10),
            'service_id' => random_int(1,10),
            'total_time' => rand(1,50),
            'earnings' => rand(1000,100000),
            'status' => Arr::random(['created','payed','started','finished','confirmed','closed','canceled']),
        ];
    }
}
