<?php

namespace Database\Factories;
use App\Models\Entidad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entidad>
 */
class EntidadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Entidad::class;

    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->randomNumber(3),
            'subSector' => $this->faker->word(),
            'nivelGobierno' => $this->faker->randomElement(['NACIONAL', 'REGIONAL']),
            'estado' => 'ACTIVO',
            'fechaCreacion' => now(),
            'fechaActualizacion' => now(),
        ];
    }
}
