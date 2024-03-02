<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Product 1',
                'description' => 'Details of the product 1',
                'price' => 250.50,
                'quantity' => 5,
            ],
            [
                'name' => 'Product 2',
                'description' => 'Details of the product 2',
                'price' => 780.50,
                'quantity' => 2,
            ],
            [
                'name' => 'Product 3',
                'description' => 'Details of the product 3',
                'price' => 400,
                'quantity' => 10,
            ],
        ]);
    }
}
