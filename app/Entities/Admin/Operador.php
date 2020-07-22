<?php

namespace HelpDesk\Entities\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operador extends Model
{
    use SoftDeletes;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operadores';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'usuario_id',
        'notificar_solicitud',
        'notificar_asignacion',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id','id');
    }
}
