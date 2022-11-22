<?php

/**
 * @see https://pestphp.com/docs/
 */

use FruiVita\Corporativo\Models\FuncaoConfianca;
use FruiVita\Corporativo\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

// Exception
test('lança exception ao criar funções de confiança duplicados, isto é, com ids iguais', function () {
    expect(
        fn () => FuncaoConfianca::factory(2)->create(['id' => 10])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exception ao criar função de confiança com campos inválidos', function ($campo, $valor, $mensagem) {
    expect(
        fn () => FuncaoConfianca::factory()->create([$campo => $valor])
    )->toThrow(QueryException::class, $mensagem);
})->with([
    ['id',   'foo',            'Incorrect integer value'],  // valor não conversível em inteiro
    ['id',   null,             'cannot be null'],           // obrigatório
    ['nome', Str::random(256), 'Data too long for column'], // máximo 255 caracteres
    ['nome', null,             'cannot be null'],           // obrigatório
]);

// Caminho feliz
test('campos em seu tamanho máximo são aceitos', function () {
    FuncaoConfianca::factory()->create(['nome' => Str::random(255)]);

    expect(FuncaoConfianca::count())->toBe(1);
});

test('uma função de confiança possui muitos usuários', function () {
    FuncaoConfianca::factory()
        ->has(Usuario::factory()->count(3), 'usuarios')
        ->create();

    $funcao = FuncaoConfianca::with('usuarios')->first();

    expect($funcao->usuarios->random())->toBeInstanceOf(Usuario::class)
        ->and($funcao->usuarios)->toHaveCount(3);
});
