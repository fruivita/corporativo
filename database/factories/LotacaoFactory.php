<?php

namespace FruiVita\Corporativo\Database\Factories;

use FruiVita\Corporativo\Models\Lotacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @see https://laravel.com/docs/9.x/database-testing
 * @see https://fakerphp.github.io/
 */
class LotacaoFactory extends Factory
{
    protected $model = Lotacao::class;

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'lotacao_pai' => null,
            'id' => fake()->unique()->randomNumber(),
            'nome' => fake()->company(),
            'sigla' => fake()->word(),
        ];
    }
}
