<?php

namespace FruiVita\Corporativo\Exceptions;

/**
 * Tipo de arquivo não suportado.
 *
 * @see https://laravel.com/docs/9.x/errors
 */
class UnsupportedFileTypeException extends \Exception
{
    public function __construct()
    {
        parent::__construct(__('O arquivo precisa ser no formato [:attribute]', ['attribute' => 'XML']));
    }
}
