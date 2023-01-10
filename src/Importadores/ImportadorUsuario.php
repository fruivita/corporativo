<?php

namespace FruiVita\Corporativo\Importadores;

use FruiVita\Corporativo\Events\CargoUsuarioAlterado;
use FruiVita\Corporativo\Events\FuncaoConfiancaUsuarioAlterada;
use FruiVita\Corporativo\Events\LotacaoUsuarioAlterada;
use FruiVita\Corporativo\Models\Usuario;
use FruiVita\Corporativo\Trait\Eventos;
use Illuminate\Support\Collection;

final class ImportadorUsuario extends ImportadorBase
{
    use Eventos;

    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'matricula' => ['bail', 'required', 'string', 'max:20'],
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
    protected $atualizar_campos = ['email', 'nome', 'lotacao_id', 'cargo_id', 'funcao_confianca_id'];

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
            'email' => $no->getAttribute('email') ?: null,
            'nome' => $no->getAttribute('nome') ?: null,
            'lotacao_id' => $no->getAttribute('lotacao') ?: null,
            'cargo_id' => $no->getAttribute('cargo') ?: null,
            'funcao_confianca_id' => $no->getAttribute('funcaoConfianca') ?: null,
        ];
    }

    /**
     * {@inheritdoc}
     *
     * Emite os eventos:
     * - CargoUsuarioAlterado se houver mudança no cargo;
     * - FuncaoConfiancaUsuarioAlterada se houver mudança na função;
     * - LotacaoUsuarioAlterada se houver mudança na lotação.
     */
    protected function salvar(Collection $validados)
    {
        if ($this->emitirEventos()) {
            Usuario::query()
                ->whereIn('matricula', $validados->pluck('matricula'))
                ->lazy()
                ->each(function (Usuario $usuario) use ($validados) {
                    $novo = $validados->firstWhere('matricula', $usuario->matricula);

                    $this->mudancaCargo($usuario, data_get($novo, 'cargo_id'));
                    $this->mudancaFuncao($usuario, data_get($novo, 'funcao_confianca_id'));
                    $this->mudancaLotacao($usuario, data_get($novo, 'lotacao_id'));
                });
        }

        Usuario::upsert(
            $validados->toArray(),
            $this->unique,
            $this->atualizar_campos
        );
    }

    /**
     * Emite evento se houver mudança no cargo do usuário.
     *
     * @param \FruiVita\Corporativo\Models\Usuario
     * @param int|null $cargo_novo id do cargo novo
     */
    private function mudancaCargo(Usuario $usuario, int $cargo_novo = null)
    {
        CargoUsuarioAlterado::dispatchIf(
            $usuario->cargo_id !== $cargo_novo,
            $usuario->id,
            $usuario->cargo_id,
            $cargo_novo
        );
    }

    /**
     * Emite evento se houver mudança na função de confiança do usuário.
     *
     * @param \FruiVita\Corporativo\Models\Usuario
     * @param int|null $funcao_nova id do funcao nova
     */
    private function mudancaFuncao(Usuario $usuario, int $funcao_nova = null)
    {
        FuncaoConfiancaUsuarioAlterada::dispatchIf(
            $usuario->funcao_confianca_id !== $funcao_nova,
            $usuario->id,
            $usuario->funcao_confianca_id,
            $funcao_nova
        );
    }

    /**
     * Emite evento se houver mudança na lotação do usuário.
     *
     * @param \FruiVita\Corporativo\Models\Usuario
     * @param int|null $lotacao_nova id do lotacao nova
     */
    private function mudancaLotacao(Usuario $usuario, int $lotacao_nova = null)
    {
        LotacaoUsuarioAlterada::dispatchIf(
            $usuario->lotacao_id !== $lotacao_nova,
            $usuario->id,
            $usuario->lotacao_id,
            $lotacao_nova
        );
    }
}
