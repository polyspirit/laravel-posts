<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::latest()->first()->id,
            'title' => $this->faker->sentence(3),
            'image' => 'posts/' . $this->faker->image('storage/app/public/posts', 640, 480, null, false),
            'description' => $this->faker->paragraphs(3, true)
        ];
    }
}
