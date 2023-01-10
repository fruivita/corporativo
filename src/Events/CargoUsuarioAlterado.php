<?php

namespace FruiVita\Corporativo\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * @see https://laravel.com/docs/9.x/events
 */
class CargoUsuarioAlterado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Id do usuário que teve o cargo alterado.
     *
     * @var int
     */
    public $usuario;

    /**
     * Id do cargo anterior do usuário.
     *
     * @var int|null
     */
    public $cargo_anterior;

    /**
     * Id do cargo atual do usuário.
     *
     * @var int|null
     */
    public $cargo_atual;

    /**
     * Create a new event instance.
     *
     * @param  int  $usuario id do usuário
     * @param  int|null  $cargo_anterior id do cargo anterior
     * @param  int|null  $cargo_atual id do cargo anterior
     * @return void
     */
    public function __construct(int $usuario, int $cargo_anterior = null, int $cargo_atual = null)
    {
        $this->usuario = $usuario;
        $this->cargo_anterior = $cargo_anterior;
        $this->cargo_atual = $cargo_atual;
    }
}
