<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'role' => 'admin', 
        ]);

DB::statement('PRAGMA foreign_keys=OFF;');

$this->call([
    CategorySeeder::class,
    ProductSeeder::class,
]);

DB::statement('PRAGMA foreign_keys=ON;');
    }
}
