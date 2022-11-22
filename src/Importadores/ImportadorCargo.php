<?php

namespace FruiVita\Corporativo\Importadores;

use FruiVita\Corporativo\Models\Cargo;
use Illuminate\Support\Collection;

final class ImportadorCargo extends ImportadorBase
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'id' => ['bail', 'required', 'integer', 'gte:1'],
        'nome' => ['bail', 'required', 'string',  'max:255'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $nome_no = 'cargo';

    /**
     * {@inheritdoc}
     */
    protected $unique = ['id'];

    /**
     * {@inheritdoc}
     */
    protected $atualizar_campos = ['nome'];

    /**
     * Create new class instance.
     */
    public static function make()
    {
        return new static();
    }

    /**
     * {@inheritdoc}
     */
    protected function extrairDadosDoNo(\XMLReader $no)
    {
        return [
            'id' => $no->getAttribute('id') ?: null,
            'nome' => $no->getAttribute('nome') ?: null,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function salvar(Collection $validados)
    {
        Cargo::upsert(
            $validados->toArray(),
            $this->unique,
            $this->atualizar_campos
        );
    }
}
