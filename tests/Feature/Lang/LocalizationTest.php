<?php

/**
 * @see https://pestphp.com/docs/
 */

use FruiVita\Corporativo\Exceptions\FileNotReadableException;
use Illuminate\Support\Facades\App;

// Caminho feliz
test('exception com mensagem padrão em português mudando o locale', function () {
    App::setLocale('pt-br');

    $exception = new FileNotReadableException();

    expect($exception->getMessage())->toBe('O arquivo informado não pôde ser lido');
});
