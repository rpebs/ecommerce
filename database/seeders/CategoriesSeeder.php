<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
