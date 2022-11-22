<?php

namespace FruiVita\Corporativo\Importadores;

use FruiVita\Corporativo\Models\Lotacao;
use Illuminate\Support\Collection;

/**
 * Cria o relacionamento com as lotações pai.
 *
 * Primeiro deve-se criar a lotação para então acionar essa classe para criar
 * o relacionamento.
 * O relacionamento é criado após a lotação pai para evitar falhas ao tentar
 * criá-lo junto.
 * Exemplos de falhas que são evitadas por meio dessa abordagem:
 * - lotação pai inexistente, visto que o id informado para o pai ainda não
 * existe e nunca existirá (talvez a lotação foi desativada, mas ainda está
 * sendo gerada no arquivo corporativo);
 * - lotação pai inexistente devido a ordem de leitura do arquivo XML. Nesse
 * caso, a lotação pai está sequencialmente depois da lotação filha;
 * - lotação pai inexistente devido a falha em algum atributo que a impede de
 * ser persistida no banco de dados.
 */
final class ImportadorRelacionamentoLotacaoPai extends ImportadorBase
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'id' => ['bail', 'required', 'integer', 'gte:1'],
        'nome' => ['bail', 'required', 'string',  'max:255'],
        'sigla' => ['bail', 'required', 'string',  'max:50'],
        'lotacao_pai' => ['bail', 'nullable', 'integer', 'exists:lotacoes,id'],
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
    protected $atualizar_campos = ['lotacao_pai'];

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
            'lotacao_pai' => $no->getAttribute('idPai') ?: null,
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
    }
}
