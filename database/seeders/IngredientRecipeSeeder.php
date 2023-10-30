<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;


class IngredientRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipes = \App\Models\Recipe::factory()->count(10)->create();
        $ingredients = \App\Models\Ingredient::factory()->count(20)->create();
        
        foreach($recipes as $recipe) {
            $recipe->ingredients()->attach(
                $ingredients->random(rand(1, 5))->pluck('id')
            );
        }
    }
}
