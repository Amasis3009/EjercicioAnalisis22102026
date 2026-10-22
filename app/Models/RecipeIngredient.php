<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RecipeIngredient extends Pivot
{
    protected $table = 'recipe_ingredient';
    protected $fillable = ['recipe_id', 'ingredient_id', 'cantidad', 'unidadMedida'];
}