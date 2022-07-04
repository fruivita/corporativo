<?php

namespace FruiVita\Corporativo\Importadores;

use FruiVita\Corporativo\Models\Usuario;
use Illuminate\Support\Collection;

final class ImportadorUsuario extends ImportadorBase
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'username' => ['required', 'string', 'max:20'],
        'nome' => ['required', 'string', 'max:255'],
        'lotacao_id' => ['required', 'integer', 'exists:lotacoes,id'],
        'cargo_id' => ['required', 'integer', 'exists:cargos,id'],
        'funcao_confianca_id' => ['nullable', 'integer', 'exists:funcoes_confianca,id'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $nome_no = 'pessoa';

    /**
     * {@inheritdoc}
     */
    protected $unique = ['username'];

    /**
     * {@inheritdoc}
     */
    protected $atualizar_campos = ['nome', 'lotacao_id', 'cargo_id', 'funcao_confianca_id'];

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
            'username' => $no->getAttribute('sigla') ?: null,
            'nome' => $no->getAttribute('nome') ?: null,
            'lotacao_id' => $no->getAttribute('lotacao') ?: null,
            'cargo_id' => $no->getAttribute('cargo') ?: null,
            'funcao_confianca_id' => $no->getAttribute('funcaoConfianca') ?: null,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function salvar(Collection $validados)
    {
        Usuario::upsert(
            $validados->toArray(),
            $this->unique,
            $this->atualizar_campos
        );
    }
}
