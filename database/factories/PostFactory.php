<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(mt_rand(2,4)),
            'slug' => $this->faker->slug(),
            'excerpt'=> $this->faker->paragraph(),
            // 'body'=>'<p>' . implode('</p><p>' . $this->faker->paragraphs(mt_rand(1,2))) . '</p>',
            'body'=>collect($this->faker->paragraphs(mt_rand(1,2)))->map(fn($p)=>"<p>$p</p>")->implode(''),
            'user_id' => mt_rand(1,3),
            'category_id' =>mt_rand(1,3),
            'condition_id' => mt_rand(1,2)
        ];
    }
}
