<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Sam',
                'username' => 'sam',
                'role_id' => 1,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Kosa',
                'username' => 'kosa',
                'role_id' => 2,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'jane',
                'username' => 'jane',
                'role_id' => 3,
                'password' => Hash::make('password'),
            ],
        ]);
    }
}
