<?php

namespace Database\Seeders;

use App\Models\Plant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin Account ──────────────────────────────────────────────────────
        User::create([
            'name'     => 'FloraFetch Admin',
            'email'    => 'admin@florafetch.com',
            'password' => Hash::make('Admin@1234'),
            'role'     => 'admin',
        ]);

        // ── Demo Customer ──────────────────────────────────────────────────────
        User::create([
            'name'     => 'Jane Doe',
            'email'    => 'jane@example.com',
            'password' => Hash::make('Customer@1234'),
            'role'     => 'customer',
        ]);

        // ── Sample Plants ──────────────────────────────────────────────────────
        $plants = [
            ['name' => 'Monstera Deliciosa',    'category' => 'Indoor',     'price' => 3500, 'sunlight_requirement' => 'Bright Indirect Light', 'watering_need' => 'Moderate', 'stock_quantity' => 25, 'description' => 'The Swiss cheese plant. Iconic tropical leaves with natural splits.'],
            ['name' => "Snake Plant 'Laurentii'",'category' => 'Indoor',     'price' => 1899, 'sunlight_requirement' => 'Low to Bright Indirect',  'watering_need' => 'Low',      'stock_quantity' => 40, 'description' => 'Nearly indestructible air purifier. Perfect for beginners.'],
            ['name' => 'Aloe Vera Barbadensis',  'category' => 'Succulents', 'price' => 1250, 'sunlight_requirement' => 'Full Sun',               'watering_need' => 'Low',      'stock_quantity' => 60, 'description' => 'Medicinal succulent with soothing gel inside the leaves.'],
            ['name' => "Lavender 'Hidcote'",     'category' => 'Outdoor',    'price' => 2200, 'sunlight_requirement' => 'Full Sun',               'watering_need' => 'Low',      'stock_quantity' => 30, 'description' => 'Fragrant purple blooms. Drought-tolerant once established.'],
            ['name' => 'Peace Lily',             'category' => 'Indoor',     'price' => 2800, 'sunlight_requirement' => 'Low Light',              'watering_need' => 'Moderate', 'stock_quantity' => 20, 'description' => 'Elegant white blooms. Excellent air purifier for shaded rooms.'],
            ['name' => 'Basil (Sweet)',           'category' => 'Herbs',      'price' => 450,  'sunlight_requirement' => 'Full Sun',               'watering_need' => 'High',     'stock_quantity' => 80, 'description' => 'Classic culinary herb. Fresh and aromatic for cooking.'],
            ['name' => 'Echeveria Elegans',      'category' => 'Succulents', 'price' => 950,  'sunlight_requirement' => 'Full Sun',               'watering_need' => 'Low',      'stock_quantity' => 50, 'description' => 'Rosette-shaped succulent with silvery-blue leaves.'],
            ['name' => 'Fiddle Leaf Fig',        'category' => 'Indoor',     'price' => 4500, 'sunlight_requirement' => 'Bright Indirect Light', 'watering_need' => 'Moderate', 'stock_quantity' => 12, 'description' => 'Dramatic statement plant with large, violin-shaped leaves.'],
            ['name' => 'Mint (Spearmint)',        'category' => 'Herbs',      'price' => 380,  'sunlight_requirement' => 'Partial Shade',          'watering_need' => 'High',     'stock_quantity' => 70, 'description' => 'Refreshing herb for teas, cooking, and mojitos.'],
            ['name' => 'Bougainvillea',           'category' => 'Outdoor',    'price' => 3200, 'sunlight_requirement' => 'Full Sun',               'watering_need' => 'Low',      'stock_quantity' => 18, 'description' => 'Vibrant pink and purple flowering climber for walls and pergolas.'],
        ];

        foreach ($plants as $plant) {
            Plant::create($plant);
        }
    }
}
