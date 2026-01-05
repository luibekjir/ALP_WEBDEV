<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Category::create([
           'name' => 'Batik A',
           'description' => 'Devices and gadgets including phones, laptops, and accessories.',
       ]);
       Category::create([
           'name' => 'Batik B',
           'description' => 'Devices and gadgets including phones, laptops, and accessories.',
       ]);
       Category::create([
           'name' => 'Batik C',
           'description' => 'Devices and gadgets including phones, laptops, and accessories.',
       ]);
       Category::create([
           'name' => 'Batik D',
           'description' => 'Devices and gadgets including phones, laptops, and accessories.',
       ]);
       Category::create([
           'name' => 'Batik E',
           'description' => 'Devices and gadgets including phones, laptops, and accessories.',
       ]);
    }
}
