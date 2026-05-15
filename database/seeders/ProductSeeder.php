<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $products = [
            [
                'name' => 'iPhone 13',
                'category' => 'Electronics',
                'description' => 'The latest iPhone with A15 Bionic chip.',
                'price' => 999.99,
            ],
            [
                'name' => 'MacBook Pro',
                'category' => 'Computers',
                'description' => 'Powerful laptop with M1 Pro chip.',
                'price' => 1999.99,
            ],
            [
                'name' => 'AirPods Pro',
                'category' => 'Audio',
                'description' => 'Noise-cancelling wireless earbuds.',
                'price' => 249.99,
            ],
            [
                'name' => 'Apple Watch Series 7',
                'category' => 'Wearables',
                'description' => 'Smartwatch with health tracking features.',
                'price' => 399.99,
            ],
            [
                'name' => 'iPad Pro',
                'category' => 'Tablets',
                'description' => 'High-performance tablet with M1 chip.',
                'price' => 1099.99,
            ],
            [
                'name' => 'HomePod mini',
                'category' => 'Smart Home',
                'description' => 'Compact smart speaker with great sound.',
                'price' => 99.99,
            ],
            [
                'name' => 'Apple TV 4K',
                'category' => 'Entertainment',
                'description' => 'Stream 4K content with HDR support.',
                'price' => 179.99,
            ],
            [
                'name' => 'Magic Keyboard',
                'category' => 'Accessories',
                'description' => 'Wireless keyboard with built-in trackpad.',
                'price' => 299.99,
            ],
            [
                'name' => 'Samsung Galaxy S21',
                'category' => 'Electronics',
                'description' => 'Flagship smartphone with advanced camera system.',
                'price' => 79.99,
            ],
            [
                'name' => 'Dell XPS 13',
                'category' => 'Computers',
                'description' => 'Ultra-portable laptop with InfinityEdge display.',
                'price' => 1499.99,
            ],
            [
                'name' => 'Sony WH-1000XM4',
                'category' => 'Audio',
                'description' => 'Industry-leading noise-cancelling headphones.',
                'price' => 349.99,
            ]
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
