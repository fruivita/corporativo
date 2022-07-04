<?php

/**
 * @see https://pestphp.com/docs/
 */

use FruiVita\Corporativo\Models\Lotacao;
use FruiVita\Corporativo\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

// Exceptions
test('lança exception ao criar lotações duplicadas, isto é, com ids iguais', function () {
    expect(
        fn () => Lotacao::factory(2)->create(['id' => 10])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exception ao criar lotação com campos inválidos', function ($campo, $valor, $mensagem) {
    expect(
        fn () => Lotacao::factory()->create([$campo => $valor])
    )->toThrow(QueryException::class, $mensagem);
})->with([
    ['id',    'foo',            'Incorrect integer value'],  // valor não conversível em inteiro
    ['id',    null,             'cannot be null'],           // obrigatório
    ['nome',  Str::random(256), 'Data too long for column'], // máximo 255 caracteres
    ['nome',  null,             'cannot be null'],           // obrigatório
    ['sigla', Str::random(51),  'Data too long for column'], // máximo 50 caracteres
    ['sigla', null,             'cannot be null'],           // obrigatório
]);

test('lança exception ao tentar definir relacionamento inválido, isto é, com lotação pai não existente', function () {
    expect(
        fn () => Lotacao::factory()->create(['lotacao_pai' => 10])
    )->toThrow(QueryException::class, 'Cannot add or update a child row');
});

// Caminho feliz
test('cria múltiplas lotações', function () {
    Lotacao::factory()->count(30)->create();

    expect(Lotacao::count())->toBe(30);
});

test('campos em seu tamanho máximo são aceitos', function ($campo, $tamanho) {
    Lotacao::factory()->create([$campo => Str::random($tamanho)]);

    expect(Lotacao::count())->toBe(1);
})->with([
    ['nome', 255],
    ['sigla', 50],
]);

test('lotação pai é opcional', function () {
    Lotacao::factory()->create(['lotacao_pai' => null]);

    expect(Lotacao::count())->toBe(1);
});

test('uma lotação pai possui muitos lotações filhos e uma lotação filha possui uma só lotação pai', function () {
    $qtd_filhos = 3;
    $id_pai = 1000000;

    Lotacao::factory()->create(['id' => $id_pai]);

    Lotacao::factory($qtd_filhos)->create(['lotacao_pai' => $id_pai]);

    $lotacao_pai = Lotacao::with(['lotacoesFilhas', 'lotacaoPai'])
            ->find($id_pai);
    $lotacao_filha = Lotacao::with(['lotacoesFilhas', 'lotacaoPai'])
                ->where('lotacao_pai', '=', $id_pai)
                ->get()
                ->random();

    expect($lotacao_pai->lotacoesFilhas)->toHaveCount($qtd_filhos)
    ->and($lotacao_pai->lotacaoPai)->toBeNull()
    ->and($lotacao_filha->lotacaoPai->id)->toBe($lotacao_pai->id)
    ->and($lotacao_filha->lotacoesFilhas)->toHaveCount(0);
});

test('uma lotação possui muitos usuários', function () {
    Lotacao::factory()
        ->has(Usuario::factory(3), 'usuarios')
        ->create();

    $lotacao = Lotacao::with(['usuarios'])->first();

    expect($lotacao->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($lotacao->usuarios)->toHaveCount(3);
});
