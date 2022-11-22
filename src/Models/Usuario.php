<?php

namespace FruiVita\Corporativo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Notar que o tratamento dada à pessoa do arquivo corporativo, visto que
 * acompanhado de seu usuário de rede, a presume usuária da aplicação. Portanto
 * o usuário aqui é a pessoa do arquivo corporativo, mas não somente, visto que
 * tambem contempla usuários existentes apenas no servidor LDAP.
 *
 * @see https://laravel.com/docs/9.x/eloquent
 */
class Usuario extends Authenticatable
{
    use HasFactory;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var string[]
     */
    protected $fillable = ['username', 'nome', 'email', 'matricula', 'lotacao_id', 'cargo_id', 'funcao_confianca_id'];

    /**
     * Relacionamento usuário (N:1) lotação.
     *
     * Lotação de determinado usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lotacao()
    {
        return $this->belongsTo(Lotacao::class, 'lotacao_id', 'id');
    }

    /**
     * Relacionamento usuário (N:1) cargo.
     *
     * Cargo de determinado usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id', 'id');
    }

    /**
     * Função de confiança de determinado usuário.
     *
     * Relacionamento usuário (N:1) função de confiança.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function funcaoConfianca()
    {
        return $this->belongsTo(FuncaoConfianca::class, 'funcao_confianca_id', 'id');
    }
}
