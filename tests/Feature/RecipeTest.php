<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    public function test_receta_con_ingredientes_y_pivote()
    {
        // 1. Crear la receta
        $receta = Recipe::create([
            'titulo' => 'Pastel de Chocolate',
            'porciones' => 8,
            'instrucciones' => 'Mezclar ingredientes, hornear a 180 grados por 45 minutos.'
        ]);

        // 2. Crear los ingredientes
        $harina = Ingredient::create(['nombre' => 'Harina de trigo']);
        $cocoa = Ingredient::create(['nombre' => 'Cocoa en polvo']);

        // 3. Asociar los ingredientes a la receta mediante la tabla pivote
        $receta->ingredients()->attach($harina->id, [
            'cantidad' => 500.00,
            'unidadMedida' => 'gramos'
        ]);

        $receta->ingredients()->attach($cocoa->id, [
            'cantidad' => 100.00,
            'unidadMedida' => 'gramos'
        ]);

        // 4. Verificaciones y aserciones
        $this->assertDatabaseHas('recipes', ['titulo' => 'Pastel de Chocolate']);
        $this->assertDatabaseHas('ingredients', ['nombre' => 'Harina de trigo']);
        
        $this->assertEquals(2, $receta->ingredients()->count());
        $this->assertEquals(500.00, $receta->ingredients()->first()->pivot->cantidad);
        $this->assertEquals('gramos', $receta->ingredients()->first()->pivot->unidadMedida);
    }
}