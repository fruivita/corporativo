<?php

namespace FruiVita\Corporativo\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

/**
 * @see https://laravel.com/docs/9.x/events
 */
class ImportacaoConcluida
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Nome do arquivo que foi importado.
     *
     * @var string
     */
    public $arquivo;

    /**
     * fim da importação.
     *
     * @var \Illuminate\Support\Carbon
     */
    public Carbon $concluido_em;

    /**
     * Create a new event instance.
     *
     * @param  string  $arquivo
     * @param  \Illuminate\Support\Carbon  $concluido_em
     * @return void
     */
    public function __construct(string $arquivo, Carbon $concluido_em)
    {
        $this->arquivo = $arquivo;
        $this->concluido_em = $concluido_em;
    }
}
