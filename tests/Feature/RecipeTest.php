<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_y_consultar_receta_con_ingredientes_y_pivote()
    {
        // 1. Crear la receta
        $receta = Recipe::create([
            'titulo' => 'Ensalada César',
            'porciones' => 2,
            'instrucciones' => 'Mezclar la lechuga con el aderezo, el pollo y el queso parmesano.'
        ]);

        // 2. Crear el ingrediente
        $ingrediente = Ingredient::create(['nombre' => 'Lechuga Romana']);

        // 3. Adjuntar el ingrediente usando la tabla pivote con sus atributos específicos
        $receta->ingredients()->attach($ingrediente->id, [
            'cantidad' => 1.50,
            'unidadMedida' => 'tazas'
        ]);

        // 4. Verificaciones en base de datos y de relaciones Eloquent
        $this->assertDatabaseHas('recipes', ['titulo' => 'Ensalada César']);
        $this->assertDatabaseHas('ingredients', ['nombre' => 'Lechuga Romana']);
        
        $recetaRecuperada = Recipe::with('ingredients')->find($receta->id);
        $this->assertEquals(1, $recetaRecuperada->ingredients->count());
        $this->assertEquals('1.50', $recetaRecuperada->ingredients->first()->pivot->cantidad);
        $this->assertEquals('tazas', $recetaRecuperada->ingredients->first()->pivot->unidadMedida);
    }
}