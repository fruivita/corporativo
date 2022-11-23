<?php

namespace FruiVita\Corporativo\Database\Factories;

use FruiVita\Corporativo\Models\Cargo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @see https://laravel.com/docs/9.x/database-testing
 * @see https://fakerphp.github.io/
 */
class CargoFactory extends Factory
{
    protected $model = Cargo::class;

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'id' => fake()->unique()->randomNumber(),
            'nome' => fake()->jobTitle(),
        ];
    }
}
