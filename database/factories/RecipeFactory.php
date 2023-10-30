<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * Description of RecipeFactory
 *
 * @author makina
 */
class RecipeFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $recipe_names = [
            "Grilled Chicken with Herbs and Lemon.",
            "Spaghetti Bolognese.",
            "Lentil Soup with Chorizo.",
            "Chicken Enchiladas.",
            "Al Pastor Tacos.",
            "Mushroom Risotto.",
            "Honey Mustard Salmon.",
            "Margherita Pizza.",
            "Homemade Apple Pie.",
            "Salmon Sushi.",
            "Meatballs in Tomato Sauce.",
            "Shrimp Pad Thai.",
            "Grilled Asparagus with Aioli.",
            "Roast Turkey with Stuffing.",
            "Orange Chicken Breast.",
            "Fish Ceviche.",
            "Chicken Curry with Basmati Rice.",
            "Beef Lasagna.",
            "Fish Tacos.",
            "Grilled Chicken and Avocado Sandwich.",
        ];
        
        return [
            'name' => Arr::random($recipe_names),
            'user_id' => rand(1, 10),
        ];
    }
}
