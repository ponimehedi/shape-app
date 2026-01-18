<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';
    protected $fillable =[
        'name',
        'recipe_image',
        'preparation_time',
        'cook_time',
        'description',
        'ingredients',
        'category',
        'difficulty',
        'how_to_cook'
    ]; 
    // relation
    public function comments()
    {
        return $this->hasMany(Comments::class, 'recipe_id');
    }
}
