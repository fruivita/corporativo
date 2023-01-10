<?php

namespace FruiVita\Corporativo\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

/**
 * @see https://laravel.com/docs/9.x/events
 */
class ImportacaoIniciada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Nome do arquivo que será importado.
     *
     * @var string
     */
    public $arquivo;

    /**
     * Início da importação.
     *
     * @var \Illuminate\Support\Carbon
     */
    public Carbon $iniciado_em;

    /**
     * Create a new event instance.
     *
     * @param  string  $arquivo
     * @param  \Illuminate\Support\Carbon  $iniciado_em
     * @return void
     */
    public function __construct(string $arquivo, Carbon $iniciado_em)
    {
        $this->arquivo = $arquivo;
        $this->iniciado_em = $iniciado_em;
    }
}
