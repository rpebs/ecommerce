<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Categories::create([
            'name' => 'Electronics',
        ]);
        \App\Models\Categories::create([
            'name' => 'Tshirt',
        ]);
        \App\Models\Categories::create([
            'name' => 'Shoes',
        ]);
        \App\Models\Categories::create([
            'name' => 'Handphone',
        ]);
        \App\Models\Categories::create([
            'name' => 'Mouse',
        ]);
    }
}
