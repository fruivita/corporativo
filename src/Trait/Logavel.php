<?php

namespace FruiVita\Corporativo\Trait;

trait Logavel
{
    /**
     * Nível do log.
     *
     * @var string
     */
    public $level = 'info';

    /**
     * Deve-se registrar em log o início e o fim do processo de importação.
     *
     * @return bool
     */
    public function registrarLog()
    {
        return config('corporativo.log_completo', false);
    }
}
