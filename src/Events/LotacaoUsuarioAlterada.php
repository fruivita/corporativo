<?php

namespace FruiVita\Corporativo\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * @see https://laravel.com/docs/9.x/events
 */
class LotacaoUsuarioAlterada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Id do usuário que teve a lotação alterada.
     *
     * @var int
     */
    public $usuario;

    /**
     * Id da lotação anterior do usuário.
     *
     * @var int|null
     */
    public $lotacao_anterior;

    /**
     * Id da lotação atual do usuário.
     *
     * @var int|null
     */
    public $lotacao_atual;

    /**
     * Create a new event instance.
     *
     * @param  int  $usuario id do usuário
     * @param  int|null  $lotacao_anterior id da lotação anterior
     * @param  int|null  $lotacao_atual id da lotação anterior
     * @return void
     */
    public function __construct(int $usuario, int $lotacao_anterior = null, int $lotacao_atual = null)
    {
        $this->usuario = $usuario;
        $this->lotacao_anterior = $lotacao_anterior;
        $this->lotacao_atual = $lotacao_atual;
    }
}
