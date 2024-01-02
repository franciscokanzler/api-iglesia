<?php

namespace Database\Factories;
use App\Models\Iglesia;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipo>
 */
class EquipoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $iglesia_id = Iglesia::orderByRaw("RAND()")->limit(1)->pluck("id");

        return [
            'correo' => $this->faker->unique()->safeEmail,
            'descripcion' => $this->faker->paragraph(),
            'nombre' => $this->faker->sentence(1),
            'iglesia_id' => $iglesia_id[0],
        ];
    }
}
