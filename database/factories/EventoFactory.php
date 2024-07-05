<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fechaInicio = $this->faker->dateTimeBetween('-1 month', '+1 month');

        // Calcular fecha máxima para fecha fin (como máximo 5 días después de fechaInicio)
        $fechaMaximaFin = Carbon::parse($fechaInicio)->addDays(2);

        // Generar fecha de fin entre fechaInicio y fechaMaximaFin
        $fechaFin = $this->faker->dateTimeBetween($fechaInicio, $fechaMaximaFin);

        return [
            'titulo' => $this->faker->sentence(),
            'fecha_inicio' => $fechaInicio->format('Y-m-d\TH:i:s'),
            'fecha_fin' => $fechaFin->format('Y-m-d\TH:i:s'),
            'tipo_evento_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
