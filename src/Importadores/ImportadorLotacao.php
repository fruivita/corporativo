<?php

namespace FruiVita\Corporativo\Importadores;

use FruiVita\Corporativo\Models\Lotacao;
use Illuminate\Support\Collection;

final class ImportadorLotacao extends ImportadorBase
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'id' => ['required', 'integer', 'gte:1'],
        'nome' => ['required', 'string',  'max:255'],
        'sigla' => ['required', 'string',  'max:50'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $nome_no = 'lotacao';

    /**
     * {@inheritdoc}
     */
    protected $unique = ['id'];

    /**
     * {@inheritdoc}
     */
    protected $atualizar_campos = ['nome', 'sigla'];

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
            'sigla' => $no->getAttribute('sigla') ?: null,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function salvar(Collection $validados)
    {
        Lotacao::upsert(
            $validados->toArray(),
            $this->unique,
            $this->atualizar_campos
        );

        ImportadorRelacionamentoLotacaoPai::make()->importar($this->arquivo);
    }
}
