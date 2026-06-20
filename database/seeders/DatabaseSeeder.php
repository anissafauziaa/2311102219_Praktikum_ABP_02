<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Pak Cokomi',
            'email' => 'cokomi@example.com',
            'password' => bcrypt('cokomiganteng'),
            'role' => 'admin',
        ]);
        Product::factory(10)->create();
    }
}
