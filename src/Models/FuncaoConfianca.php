<?php

namespace FruiVita\Corporativo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Função de confiança de determinado usuário.
 *
 * @see https://laravel.com/docs/9.x/eloquent
 */
class FuncaoConfianca extends Model
{
    use HasFactory;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'funcoes_confianca';

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var string[]
     */
    protected $fillable = ['id', 'nome'];

    /**
     * Indica se os IDs são auto incrementáveis.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Relacionamento função de confiança (1:N) usuário.
     *
     * Usuários com determinada função de confiança.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'funcao_confianca_id', 'id');
    }
}
