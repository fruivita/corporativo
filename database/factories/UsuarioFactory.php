<?php

namespace FruiVita\Corporativo\Database\Factories;

use FruiVita\Corporativo\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @see https://laravel.com/docs/9.x/database-testing
 * @see https://fakerphp.github.io/
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'lotacao_id' => null,
            'cargo_id' => null,
            'funcao_confianca_id' => null,

            'matricula' => fake()->unique()->numerify('#####'),
            'username' => fake()->unique()->word(),
            'email' => fake()->unique()->email(),
            'nome' => fake()->optional()->name(),
        ];
    }
}
