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
test('lança exception ao criar usuários duplicados, isto é, com matrícula, username ou email iguais', function ($campo) {
    expect(
        fn () => Usuario::factory(2)->create([$campo => 'foo'])
    )->toThrow(QueryException::class, 'Duplicate entry');
})->with([
    'matricula',
    'username',
    'email',
]);

test('lança exception ao criar usuário com campos inválidos', function ($campo, $valor, $mensagem) {
    expect(
        fn () => Usuario::factory()->create([$campo => $valor])
    )->toThrow(QueryException::class, $mensagem);
})->with([
    ['matricula', Str::random(21),  'Data too long for column'], // máximo 20 characters
    ['username',  Str::random(21),  'Data too long for column'], // máximo 20 characters
    ['username',  null,             'cannot be null'],           // obrigatório
    ['email',     Str::random(256), 'Data too long for column'], // máximo 255 caracteres
    ['nome',      Str::random(256), 'Data too long for column'], // máximo 255 caracteres
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
test('campos em seu tamanho máximo são aceitos', function ($campo, $tamanho) {
    Usuario::factory()->create([$campo => Str::random($tamanho)]);

    expect(Usuario::count())->toBe(1);
})->with([
    ['matricula', 20],
    ['username', 20],
    ['email', 255],
    ['nome', 255],
]);

test('campos opcionais estão definidos', function () {
    Usuario::factory()->create([
        'matricula' => null,
        'email' => null,
        'nome' => null,
    ]);

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
