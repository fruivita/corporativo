<?php

/**
 * @see https://pestphp.com/docs/
 * @see https://laravel.com/docs/9.x/mocking
 */

use FruiVita\Corporativo\Importadores\ImportadorCargo;
use FruiVita\Corporativo\Models\Cargo;
use Illuminate\Support\Facades\Log;

// Falhas
test('cria os logs para cada cargo inválido', function () {
    Log::spy();

    ImportadorCargo::make()->importar($this->arquivo);

    Log::shouldHaveReceived('log')
        ->withArgs(fn ($level, $message) => $level === 'warning' && $message === __('Validação falhou'))
        ->times(6);

    expect(Cargo::count())->toBe(3);
});

// Caminho feliz
test('make retorna oobjeto da classe', function () {
    expect(ImportadorCargo::make())->toBeInstanceOf(ImportadorCargo::class);
});

test('importa os cargos do arquivo corporativo', function () {
    // força a execução de duas queries em pontos diferentes para testá-las
    config(['corporativo.max_upsert' => 2]);

    ImportadorCargo::make()->importar($this->arquivo);

    $cargos = Cargo::get();

    expect($cargos)->toHaveCount(3)
        ->and($cargos->pluck('nome'))->toMatchArray(['Cargo 1', 'Cargo 2', 'Cargo 3']);
});
