<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'contact_email' => $this->faker->unique()->companyEmail,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
