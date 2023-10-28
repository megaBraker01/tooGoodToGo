<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Recipe extends Model
{
    use HasFactory;
    
    public function ingredients()
    {
        //return $this->hasMany(Ingredient::class);
        return $this->belongsToMany(Ingredient::class);//->withPivot('ingredient_id');
        
    }
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function getUsersHaveSelectedAsFavorite()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
