<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create default categories
        Category::factory()->create(['name' => 'Elektronik', 'slug' => 'elektronik']);
        Category::factory()->create(['name' => 'Pakaian', 'slug' => 'pakaian']);
        Category::factory()->create(['name' => 'Otomotif', 'slug' => 'otomotif']);
        Category::factory()->create(['name' => 'Rumah Tangga', 'slug' => 'rumah-tangga']);
        Category::factory()->create(['name' => 'Koleksi', 'slug' => 'koleksi']);
        
        // Create default admin user
        User::factory()->create([
            'name' => 'Admin Silebar',
            'email' => 'admin@silebar.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        
        // Create default seller user
        User::factory()->create([
            'name' => 'Penjual Contoh',
            'email' => 'seller@silebar.test',
            'password' => bcrypt('password'),
            'role' => 'seller',
        ]);
        
        // Create default buyer user
        User::factory()->create([
            'name' => 'Pembeli Contoh',
            'email' => 'buyer@silebar.test',
            'password' => bcrypt('password'),
            'role' => 'buyer',
        ]);
    }
}