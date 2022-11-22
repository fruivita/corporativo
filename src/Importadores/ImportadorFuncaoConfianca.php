<?php

namespace FruiVita\Corporativo\Importadores;

use FruiVita\Corporativo\Models\FuncaoConfianca;
use Illuminate\Support\Collection;

final class ImportadorFuncaoConfianca extends ImportadorBase
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
    protected $nome_no = 'funcao';

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
        FuncaoConfianca::upsert(
            $validados->toArray(),
            $this->unique,
            $this->atualizar_campos
        );
    }
}
