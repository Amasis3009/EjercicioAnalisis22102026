<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    protected $table = 'recipes';
    protected $fillable = ['titulo', 'porciones', 'instrucciones'];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient', 'recipe_id', 'ingredient_id')
                    ->using(RecipeIngredient::class)
                    ->withPivot('cantidad', 'unidadMedida')
                    ->withTimestamps();
    }
}