<?php

/**
 * @see https://pestphp.com/docs/
 * @see https://laravel.com/docs/9.x/mocking
 */

use FruiVita\Corporativo\Exceptions\FileNotReadableException;
use FruiVita\Corporativo\Exceptions\UnsupportedFileTypeException;
use FruiVita\Corporativo\Facades\Corporativo;
use FruiVita\Corporativo\Models\Cargo;
use FruiVita\Corporativo\Models\FuncaoConfianca;
use FruiVita\Corporativo\Models\Lotacao;
use FruiVita\Corporativo\Models\Usuario;
use Illuminate\Support\Facades\Log;

// Exceptions
test('lança exception ao tentar realizar a importação com arquivo inválido', function ($arquivo) {
    expect(
        fn () => Corporativo::importar($arquivo)
    )->toThrow(FileNotReadableException::class);
})->with([
    'foo.xml',
    '',
]);

test('lança exception ao tentar realizar a importação com mime type do arquivo não suportado', function () {
    $arquivo = 'corporativo.txt';
    $this->file_system->put($arquivo, 'conteúdo qualquer');

    expect(
        fn () => Corporativo::importar($this->file_system->path($arquivo))
    )->toThrow(UnsupportedFileTypeException::class, 'XML');
});

// Caminho feliz
test('nas configurações, se o max upsert for inválido, usa o valor default. Também, cria os logs mínimos (logs de validação), mesmo se configurado para não registrar o log.', function () {
    config(['corporativo.max_upsert' => -1]); // inválido. pois menor ou igual a zero
    config(['corporativo.log_completo' => false]);

    $warnings
        = 6   // Para cada cargo inválido
        + 6   // Para cada funcao de confiança inválida
        + 18  // Para cada lotacao inválida
        + 13; // Para cada usuario/pessoa inválida

    Log::spy();

    Corporativo::importar($this->arquivo);

    Log::shouldNotHaveReceived(
        'log',
        fn ($level, $message) => $level === 'info' && $message === __('Início da importação da estrutura corporativa')
    );
    Log::shouldNotHaveReceived(
        'log',
        fn ($level, $message) => $level === 'info' && $message === __('Fim da importação da estrutura corporativa')
    );
    Log::shouldHaveReceived('log')
    ->withArgs(fn ($level, $message) => $level === 'warning' && $message === __('Validação falhou'))
    ->times($warnings);

    expect(Cargo::count())->toBe(3)
    ->and(FuncaoConfianca::count())->toBe(3)
    ->and(Lotacao::count())->toBe(5)
    ->and(Usuario::count())->toBe(5);
});

test('importa o arquivo corporativo e cria todos os logs', function () {
    $warnings
        = 6   // Para cada cargo inválido
        + 6   // Para cada funcao de confiança inválida
        + 18  // Para cada lotacao inválida
        + 13; // Para cada usuario/pessoa inválida

    Log::spy();

    Corporativo::importar($this->arquivo);

    Log::shouldHaveReceived('log')
    ->withArgs(fn ($level, $message) => $level === 'info' && $message === __('Início da importação da estrutura corporativa'))
    ->once();
    Log::shouldHaveReceived('log')
    ->withArgs(fn ($level, $message) => $level === 'warning' && $message === __('Validação falhou'))
    ->times($warnings);
    Log::shouldHaveReceived('log')
    ->withArgs(fn ($level, $message) => $level === 'info' && $message === __('Fim da importação da estrutura corporativa'))
    ->once();

    expect(Cargo::count())->toBe(3)
    ->and(FuncaoConfianca::count())->toBe(3)
    ->and(Lotacao::count())->toBe(5)
    ->and(Usuario::count())->toBe(5);
});
