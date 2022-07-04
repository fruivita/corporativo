<?php

/**
 * @see https://pestphp.com/docs/
 */

use FruiVita\Corporativo\Models\Cargo;
use FruiVita\Corporativo\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

// Exceptions
test('lança exception ao criar cargos duplicados, isto é, com ids iguais', function () {
    expect(
        fn () => Cargo::factory(2)->create(['id' => 10])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exception ao criar cargos com campos inválidos', function ($campo, $valor, $mensagem) {
    expect(
        fn () => Cargo::factory()->create([$campo => $valor])
    )->toThrow(QueryException::class, $mensagem);
})->with([
    ['id',   'foo',            'Incorrect integer value'],  // valor não conversível em inteiro
    ['id',   null,             'cannot be null'],           // obrigatório
    ['nome', Str::random(256), 'Data too long for column'], // máximo 255 caracteres
    ['nome', null,             'cannot be null'],           // obrigatório
]);

// Caminho feliz
test('cria múltiplos cargos', function () {
    Cargo::factory(30)->create();

    expect(Cargo::count())->toBe(30);
});

test('campos em seu tamanho máximo são aceitos', function () {
    Cargo::factory()->create(['nome' => Str::random(255)]);

    expect(Cargo::count())->toBe(1);
});

test('um cargo possui muitos usuários', function () {
    Cargo::factory()
        ->has(Usuario::factory()->count(3), 'usuarios')
        ->create();

    $cargo = Cargo::with('usuarios')->first();

    expect($cargo->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($cargo->usuarios)->toHaveCount(3);
});
