<?php

namespace FruiVita\Corporativo\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * @see https://laravel.com/docs/9.x/events
 */
class FuncaoConfiancaUsuarioAlterada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Id do usuário que teve a função de confiançã alterada.
     *
     * @var int
     */
    public $usuario;

    /**
     * Id da função de confiança anterior do usuário.
     *
     * @var int|null
     */
    public $funcao_anterior;

    /**
     * Id da função de confiança atual do usuário.
     *
     * @var int|null
     */
    public $funcao_atual;

    /**
     * Create a new event instance.
     *
     * @param  int  $usuario id do usuário
     * @param  int|null  $funcao_anterior id da função de confiança anterior
     * @param  int|null  $funcao_atual id da função de confiança anterior
     * @return void
     */
    public function __construct(int $usuario, int $funcao_anterior = null, int $funcao_atual = null)
    {
        $this->usuario = $usuario;
        $this->funcao_anterior = $funcao_anterior;
        $this->funcao_atual = $funcao_atual;
    }
}
