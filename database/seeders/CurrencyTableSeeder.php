<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::create([
            'name' => 'USD',
            'symbol' => '$',
        ]);

        Currency::create([
            'name' => 'EUR',
            'symbol' => '€',
        ]);

        Currency::create([
            'name' => 'UAH',
            'symbol' => '₴',
        ]);

        Currency::create([
            'name' => 'GBP',
            'symbol' => '£',
        ]);

        Currency::create([
            'name' => 'CAD',
            'symbol' => 'C$',
        ]);
    }
}
