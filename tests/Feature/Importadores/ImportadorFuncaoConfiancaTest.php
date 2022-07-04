<?php

/**
 * @see https://pestphp.com/docs/
 * @see https://laravel.com/docs/9.x/mocking
 */

use FruiVita\Corporativo\Importadores\ImportadorFuncaoConfianca;
use FruiVita\Corporativo\Models\FuncaoConfianca;
use Illuminate\Support\Facades\Log;

// Failure
test('cria os logs para cada função de confiaça inválida', function () {
    Log::spy();

    ImportadorFuncaoConfianca::make()->importar($this->arquivo);

    Log::shouldHaveReceived('log')
    ->withArgs(fn ($level, $message) => $level === 'warning' && $message === __('Validação falhou'))
    ->times(6);

    expect(FuncaoConfianca::count())->toBe(3);
});

// Caminho feliz
test('make retorna oobjeto da classe', function () {
    expect(ImportadorFuncaoConfianca::make())->toBeInstanceOf(ImportadorFuncaoConfianca::class);
});

test('importa as funções de confiança do arquivo corporativo', function () {
    // força a execução de duas queries em pontos diferentes para testá-las
    config(['corporativo.max_upsert' => 2]);

    ImportadorFuncaoConfianca::make()->importar($this->arquivo);

    $funcoes = FuncaoConfianca::get();

    expect($funcoes)->toHaveCount(3)
    ->and($funcoes->pluck('nome'))->toMatchArray(['Função 1', 'Função 2', 'Função 3']);
});
