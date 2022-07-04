<?php

namespace FruiVita\Corporativo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Lotação de determinado usuário.
 *
 * @see https://laravel.com/docs/9.x/eloquent
 */
class Lotacao extends Model
{
    use HasFactory;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'lotacoes';

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var string[]
     */
    protected $fillable = ['id', 'lotacao_pai', 'nome', 'sigla'];

    /**
     * Indica se os IDs são auto incrementáveis.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Relacionamento lotação filha (N:1) lotação pai.
     *
     * Lotação pai de uma determinada lotação.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lotacaoPai()
    {
        return $this->belongsTo(Lotacao::class, 'lotacao_pai', 'id');
    }

    /**
     * Relacionamento lotação pai (1:N) lotações filhas.
     *
     * Lotações filhas de uma determinada lotação.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lotacoesFilhas()
    {
        return $this->hasMany(Lotacao::class, 'lotacao_pai', 'id');
    }

    /**
     * Relacionamento lotação (1:N) usuario.
     *
     * Usuários lotados em uma determinada lotação.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'lotacao_id', 'id');
    }
}
