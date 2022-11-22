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
        'matricula' => ['bail', 'required', 'string', 'max:20'],
        'username' => ['bail', 'required', 'string', 'max:20'],
        'email' => ['bail', 'required', 'string', 'email:strict'],
        'nome' => ['bail', 'required', 'string', 'max:255'],
        'lotacao_id' => ['bail', 'required', 'integer', 'exists:lotacoes,id'],
        'cargo_id' => ['bail', 'required', 'integer', 'exists:cargos,id'],
        'funcao_confianca_id' => ['bail', 'nullable', 'integer', 'exists:funcoes_confianca,id'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $nome_no = 'pessoa';

    /**
     * {@inheritdoc}
     */
    protected $unique = ['matricula'];

    /**
     * {@inheritdoc}
     */
    protected $atualizar_campos = ['username', 'email', 'nome', 'lotacao_id', 'cargo_id', 'funcao_confianca_id'];

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
            'matricula' => $no->getAttribute('matricula') ?: null,
            'username' => $no->getAttribute('sigla') ?: null,
            'email' => $no->getAttribute('email') ?: null,
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
