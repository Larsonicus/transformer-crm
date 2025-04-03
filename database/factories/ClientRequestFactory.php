<?php

namespace Database\Factories;

use App\Models\ClientRequest;
use App\Models\User;
use App\Models\Partner;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientRequestFactory extends Factory
{
    protected $model = ClientRequest::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'user_id' => User::factory(),
            'partner_id' => Partner::factory(),
            'source_id' => Source::factory(),
            'status' => $this->faker->randomElement(['new', 'in_progress', 'completed']),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (ClientRequest $request) {
            // Дополнительная логика после создания
        })->afterCreating(function (ClientRequest $request) {
            // Дополнительная логика после сохранения
        });
    }
}
