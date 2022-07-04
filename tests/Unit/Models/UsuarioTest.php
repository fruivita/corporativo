<?php

/**
 * @see https://pestphp.com/docs/
 */

use FruiVita\Corporativo\Models\Cargo;
use FruiVita\Corporativo\Models\FuncaoConfianca;
use FruiVita\Corporativo\Models\Lotacao;
use FruiVita\Corporativo\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

// Exceptions
test('lança exception ao criar usuários duplicados, isto é, com username iguais', function () {
    expect(
        fn () => Usuario::factory(2)->create(['username' => 'aduser'])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exception ao criar usuário com campos inválidos', function ($campo, $valor, $mensagem) {
    expect(
        fn () => Usuario::factory()->create([$campo => $valor])
    )->toThrow(QueryException::class, $mensagem);
})->with([
    ['nome',     Str::random(256), 'Data too long for column'], // máximo 255 caracteres
    ['username', Str::random(21),  'Data too long for column'], // maximum 20 characters
    ['username', null,             'cannot be null'],           // obrigatório
]);

test('lança exception ao tentar definir relacionamento inválido, isto é, com modelos não existentes', function ($campo, $valor, $mensagem) {
    expect(
        fn () => Usuario::factory()->create([$campo => $valor])
    )->toThrow(QueryException::class, $mensagem);
})->with([
    ['cargo_id',            10, 'Cannot add or update a child row'],
    ['funcao_confianca_id', 10, 'Cannot add or update a child row'],
    ['lotacao_id',          10, 'Cannot add or update a child row'],
]);

// Caminho feliz
test('cria múltiplos usuários', function () {
    Usuario::factory(30)->create();

    expect(Usuario::count())->toBe(30);
});

test('campos em seu tamanho máximo são aceitos', function ($campo, $tamanho) {
    Usuario::factory()->create([$campo => Str::random($tamanho)]);

    expect(Usuario::count())->toBe(1);
})->with([
    ['nome', 255],
    ['username', 20],
]);

test('nome é opcional', function () {
    Usuario::factory()->create(['nome' => null]);

    expect(Usuario::count())->toBe(1);
});

test('cargo, função de confiança e lotação são opcionais', function ($campo) {
    Usuario::factory()->create([$campo => null]);

    expect(Usuario::count())->toBe(1);
})->with([
    'cargo_id',
    'funcao_confianca_id',
    'lotacao_id',
]);

test('um usuário possui um cargo, uma função de confiança e/ou uma lotação', function () {
    $cargo = Cargo::factory()->create();
    $funcao = FuncaoConfianca::factory()->create();
    $lotacao = Lotacao::factory()->create();

    $usuario = Usuario::factory()
                ->for($cargo, 'cargo')
                ->for($funcao, 'funcaoConfianca')
                ->for($lotacao, 'lotacao')
                ->create();

    $usuario->load(['cargo', 'funcaoConfianca', 'lotacao']);

    expect($usuario->cargo)->toBeInstanceOf(Cargo::class)
    ->and($usuario->funcaoConfianca)->toBeInstanceOf(FuncaoConfianca::class)
    ->and($usuario->lotacao)->toBeInstanceOf(Lotacao::class);
});
