<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * Description of IngredientFactory
 *
 * @author makina
 */
class IngredientFactory extends Factory {    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ingredient_names = [
            "Salt","Sugar","Olive Oil","Garlic","Onion",
            "Flour","Butter","Eggs","Black Pepper","Tomato",
            "Milk","Rice","Chicken","Beef","Lemon",
            "Lime","Parsley","Vinegar","Cheese","Sour Cream",
            "Yogurt","Wheat Flour","Cilantro","Cinnamon","Nutmeg",
            "Ginger","Red Bell Pepper","Green Bell Pepper","Bay Leaf","Cumin",
            "Chilies","Soy Sauce","Honey","Mustard","Basil",
            "Carrots","Celery","Lemon","Chili Powder","Turmeric",
            "Orange","Thyme","Oregano","Basil","Green Onions",
            "Cucumber","Swiss Chard","Rosemary","Cloves","Cayenne Pepper",
        ];
        
        return [
            'name' => Arr::sort($ingredient_names),
        ];
    }
}
