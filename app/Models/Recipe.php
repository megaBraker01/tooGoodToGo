<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Recipe extends Model
{
    use HasFactory;
    
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::class);
    }
    
    public function getUsersHaveSelectedAsFavorite()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
