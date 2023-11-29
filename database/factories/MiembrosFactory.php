<?php

namespace Database\Factories;

use App\Models\Estado;
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
        $estado = Estado::find($this->faker->numberBetween(1, 24));
        $municipio = $estado->municipios->random();
        if ($municipio->parroquias->isNotEmpty()) {
            $parroquia = $municipio->parroquias->random();
        } else {
            $parroquia = NULL;
        }

        return [
            'nombre' => $this->faker->sentence(1),
            'apellido' => $this->faker->sentence(1),
            'fecha_nacimiento' => $this->faker->date(),
            'ci' => "V-".$this->faker->numberBetween(5000000,23000000),
            'edad' => $this->faker->numberBetween(21,80),
            'iglesia_id' => $iglesia_id[0],
            'correo' => $this->faker->unique()->safeEmail,
            'estado_id' => $estado->id,
            'municipio_id' => $municipio->id,
            'parroquia_id' => $parroquia->id,
        ];
    }
}
