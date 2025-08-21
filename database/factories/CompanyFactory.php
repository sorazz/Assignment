<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
class CompanyFactory extends Factory
{
    public function definition(): array
    {
       return [
            'title' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'status' => $this->faker->boolean(), // 0 or 1
            'image' => null,
        ];
    }
}
