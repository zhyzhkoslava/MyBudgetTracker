<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Manually seed USD and EUR currencies
        Currency::create([
            'name' => 'USD',
            'symbol' => '$',
        ]);

        Currency::create([
            'name' => 'EUR',
            'symbol' => '€',
        ]);

        // Manually seed Ukrainian hryvnia (UAH)
        Currency::create([
            'name' => 'UAH',
            'symbol' => '₴',
        ]);

    }
}
