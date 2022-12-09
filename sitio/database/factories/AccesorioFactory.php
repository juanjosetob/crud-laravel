<?php

namespace Database\Factories;

use App\Models\Accesorio;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccesorioFactory extends Factory
{
    protected $model = Accesorio::class;

    public function definition()
    {
        return [
			'nombre' => $this->faker->name,
			'usuario' => $this->faker->name,
        ];
    }
}
