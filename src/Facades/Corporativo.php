<?php

namespace FruiVita\Corporativo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void importar(string $arquivo)
 *
 * @see \FruiVita\Corporativo\Corporativo
 * @see https://laravel.com/docs/9.x/facades
 */
class Corporativo extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'corporativo';
    }
}
