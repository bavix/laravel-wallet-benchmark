<?php

declare(strict_types=1);

namespace Bavix\WalletBench\Test\Infra\Factories;

use Bavix\WalletBench\Test\Infra\Models\Buyer;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuyerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Buyer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()
                ->safeEmail,
        ];
    }
}
