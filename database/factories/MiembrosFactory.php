<?php

namespace Database\Factories;

use App\Models\Iglesia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Miembros>
 */
class MiembrosFactory extends Factory
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
            'nombre' => $this->faker->sentence(1),
            'apellido' => $this->faker->sentence(1),
            'fecha_nacimiento' => $this->faker->date(),
            'ci' => $this->faker->numberBetween(5000000,23000000),
            'edad' => $this->faker->numberBetween(21,80),
            'iglesia_id' => $iglesia_id[0],
            'correo' => $this->faker->unique()->safeEmail,
            'estado_id' => 1,
            'municipio_id' => 2,
            'parroquia_id' => 3
        ];
    }
}
