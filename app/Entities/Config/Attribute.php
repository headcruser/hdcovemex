<?php

namespace HelpDesk\Entities\Config;

use HelpDesk\Builder\Config\AttributeQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attributes';

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attribute', 'value'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];



    /**
     *
     * Crea una nueva instancia de el constructor de consultas Eloquent
     * para el modelo.
     *
     * Este método separa los filtros a un nueva clase.
     *
     * @param  $query
     * @return ChoferQuery|static
     */
    public function newEloquentBuilder($query)
    {
        return new AttributeQuery($query);
    }

    /**
     * Obtiene el listado de categorias en la tabla de atributos
     *
     * @return void
     */
    public static function categories()
    {
        return self::categoryAttribute()->pluck('attribute');
    }
}
