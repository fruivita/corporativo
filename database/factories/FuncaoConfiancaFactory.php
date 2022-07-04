<?php

namespace FruiVita\Corporativo\Database\Factories;

use FruiVita\Corporativo\Models\FuncaoConfianca;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @see https://laravel.com/docs/9.x/database-testing
 * @see https://fakerphp.github.io/
 */
class FuncaoConfiancaFactory extends Factory
{
    protected $model = FuncaoConfianca::class;

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomNumber(),
            'nome' => $this->faker->jobTitle(),
        ];
    }
}
