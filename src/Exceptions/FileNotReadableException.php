<?php

namespace FruiVita\Corporativo\Exceptions;

use Exception;

/**
 * Aquivo não pode ser lido.
 *
 * @see https://laravel.com/docs/9.x/errors
 */
class FileNotReadableException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('O arquivo informado não pôde ser lido'));
    }
}
