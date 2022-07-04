<?php

/**
 * @see https://pestphp.com/docs/
 * @see https://laravel.com/docs/9.x/mocking
 */

use FruiVita\Corporativo\Importadores\ImportadorLotacao;
use FruiVita\Corporativo\Models\Lotacao;
use Illuminate\Support\Facades\Log;

// Falhas
test('cria os logs para cada lotação inválida', function () {
    Log::spy();

    ImportadorLotacao::make()->importar($this->arquivo);

    Log::shouldHaveReceived('log')
    ->withArgs(fn ($level, $message) => $level === 'warning' && $message === __('Validação falhou'))
    ->times(18);

    expect(Lotacao::count())->toBe(5);
});

// Caminho feliz
test('make retorna oobjeto da classe', function () {
    expect(ImportadorLotacao::make())->toBeInstanceOf(ImportadorLotacao::class);
});

test('importa as lotações do arquivo corporativo e cria o relacionamento com as lotações pai', function () {
    // força a execução de duas queries em pontos diferentes para testá-las
    config(['corporativo.max_upsert' => 2]);

    ImportadorLotacao::make()->importar($this->arquivo);

    $lotacaos = Lotacao::get();

    expect($lotacaos)->toHaveCount(5)
    ->and($lotacaos->pluck('nome'))->toMatchArray(['Lotação 1', 'Lotação 2', 'Lotação 3', 'Lotação 4', 'Lotação 5'])
    ->and($lotacaos->pluck('sigla'))->toMatchArray(['Sigla 1', 'Sigla 2', 'Sigla 3', 'Sigla 4', 'Sigla 5'])
    ->and(Lotacao::has('lotacaoPai')->count())->toBe(2)
    ->and(Lotacao::has('lotacoesFilhas')->count())->toBe(1)
    ->and(
        Lotacao::with('lotacoesFilhas')
            ->find('1')
            ->lotacoesFilhas
            ->pluck('nome')
    )->toMatchArray(['Lotação 3', 'Lotação 5'])
    ->and(
        Lotacao::with('lotacaoPai')
            ->find('1')
            ->nome
    )->toBe('Lotação 1');
});
