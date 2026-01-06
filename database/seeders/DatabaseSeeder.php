<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\DB;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\GallerySeeder;
use Database\Seeders\EventSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



DB::statement('PRAGMA foreign_keys=OFF;');

$this->call([
    CategorySeeder::class,
    UserSeeder::class
]);

DB::statement('PRAGMA foreign_keys=ON;');
    }
}
