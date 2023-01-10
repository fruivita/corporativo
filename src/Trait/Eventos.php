<?php

namespace FruiVita\Corporativo\Trait;

trait Eventos
{
    /**
     * Deve-se emitir eventos?
     *
     * @return bool
     */
    public function emitirEventos()
    {
        return config('corporativo.eventos', false);
    }
}
