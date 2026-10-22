<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_instanciar_y_crear_una_receta_con_sus_ingredientes()
    {
        // 1. Crear una receta
        $recipe = Recipe::create([
            'titulo' => 'Pasta Carbonara',
            'porciones' => 4,
            'instrucciones' => 'Cocinar la pasta y mezclar con los huevos y el tocino.'
        ]);

        // 2. Crear los ingredientes
        $ingredient1 = Ingredient::create(['nombre' => 'Espagueti']);
        $ingredient2 = Ingredient::create(['nombre' => 'Tocino']);

        // 3. Asociar los ingredientes a la receta utilizando la tabla pivote (con cantidad y unidad de medida)
        $recipe->ingredients()->attach($ingredient1->id, [
            'cantidad' => 400.00,
            'unidadMedida' => 'gramos'
        ]);

        $recipe->ingredients()->attach($ingredient2->id, [
            'cantidad' => 150.00,
            'unidadMedida' => 'gramos'
        ]);

        // 4. Aserciones para verificar que todo se guardó y relacionó correctamente
        $this->assertDatabaseHas('recipes', ['titulo' => 'Pasta Carbonara']);
        $this->assertEquals(2, $recipe->ingredients()->count());
        $this->assertEquals(400.00, $recipe->ingredients()->first()->pivot->cantidad);
        $this->assertEquals('gramos', $recipe->ingredients()->first()->pivot->unidadMedida);
    }
}