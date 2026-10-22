<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    protected $table = 'ingredients';
    protected $fillable = ['nombre'];

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredient', 'ingredient_id', 'recipe_id')
                    ->using(RecipeIngredient::class)
                    ->withPivot('cantidad', 'unidadMedida')
                    ->withTimestamps();
    }
}
