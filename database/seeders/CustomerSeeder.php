<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::insert(
            [
                'name' => 'customer 1',
                'phone' => '0123456789'
            ],
            [
                'name' => 'customer 2',
                'phone' => '0011223366'
            ]
        );
    }
}
