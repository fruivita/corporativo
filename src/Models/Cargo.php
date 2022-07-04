<?php

namespace FruiVita\Corporativo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Cargo de determinado usuário.
 *
 * @see https://laravel.com/docs/9.x/eloquent
 */
class Cargo extends Model
{
    use HasFactory;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'cargos';

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
     * Relacionamento cargo (1:N) usuário.
     *
     * Usuários com determinado cargo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'cargo_id', 'id');
    }
}
