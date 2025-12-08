<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gallery::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_url'   => $this->faker->imageUrl(800, 600, 'nature', true), 
            'title'       => $this->faker->sentence(3),                         
            'description'  => $this->faker->paragraph(),                         
            'created_by'  => 1,                                                 // user ID dummy
            'updated_by'  => 1,                                                 // user ID dummy
            'like_id'     => null,                                              // bisa diisi relasi nanti
            'comment_id'  => null,                                              // bisa diisi relasi nanti
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
