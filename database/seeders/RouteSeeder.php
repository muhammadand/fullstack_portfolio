<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = [
            [
                'origin' => 'Ciamis',
                'destination' => 'Bandung',
                'base_price' => 190000,
            ],
            [
                'origin' => 'Bandung',
                'destination' => 'Ciamis',
                'base_price' => 190000,
            ],
        ];

        foreach ($routes as $route) {
            Route::updateOrCreate(
                [
                    'origin' => $route['origin'],
                    'destination' => $route['destination'],
                ],
                [
                    'base_price' => $route['base_price'],
                ]
            );
        }
    }
}
