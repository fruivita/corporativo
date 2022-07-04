<?php

/**
 * @see https://pestphp.com/docs/
 * @see https://laravel.com/docs/9.x/mocking
 */

use FruiVita\Corporativo\Importadores\ImportadorLotacao;
use FruiVita\Corporativo\Importadores\ImportadorFuncaoConfianca;
use FruiVita\Corporativo\Importadores\ImportadorCargo;
use FruiVita\Corporativo\Importadores\ImportadorUsuario;
use FruiVita\Corporativo\Models\Usuario;
use Illuminate\Support\Facades\Log;

// Falhas
test('cria os logs para cada usuário inválido', function () {
    ImportadorCargo::make()->importar($this->arquivo);
    ImportadorFuncaoConfianca::make()->importar($this->arquivo);
    ImportadorLotacao::make()->importar($this->arquivo);

    Log::spy();

    ImportadorUsuario::make()->importar($this->arquivo);

    Log::shouldHaveReceived('log')
    ->withArgs(fn ($level, $message) => $level === 'warning' && $message === __('Validação falhou'))
    ->times(13);

    expect(Usuario::count())->toBe(5);
});

// Caminho feliz
test('make retorna oobjeto da classe', function () {
    expect(ImportadorUsuario::make())->toBeInstanceOf(ImportadorUsuario::class);
});

test('importa os usuários do arquivo corporativo', function () {
    // força a execução de duas queries em pontos diferentes para testá-las
    config(['corporativo.max_upsert' => 2]);

    ImportadorCargo::make()->importar($this->arquivo);
    ImportadorFuncaoConfianca::make()->importar($this->arquivo);
    ImportadorLotacao::make()->importar($this->arquivo);
    ImportadorUsuario::make()->importar($this->arquivo);

    $usuarios = Usuario::get();

    expect($usuarios)->toHaveCount(5)
    ->and($usuarios->pluck('nome'))->toMatchArray(['Pessoa 1', 'Pessoa 2', 'Pessoa 3', 'Pessoa 4', 'Pessoa 5']);
});
