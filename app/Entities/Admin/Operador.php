<?php

namespace HelpDesk\Entities\Admin;

use HelpDesk\Traits\IconStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operador extends Model
{
    use SoftDeletes,IconStatus;

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
        return $this->belongsTo(User::class,'usuario_id','id')
            ->withDefault();
    }

    /**
     * Es un mutador que entrega un label dependiendo el estado del campo `notificar_solicitud`
     *
     * @return string
     */
    public function getNotificarSolicitudIconAttribute()
    {
        return $this->flagIcon((bool)$this->notificar_solicitud);
    }

    /**
     * Es un mutador que entrega un label dependiendo el estado del campo `notificar_asignacion`
     *
     * @return string
     */
    public function getNotificarAsignacionIconAttribute()
    {
        return $this->flagIcon((bool)$this->notificar_asignacion);
    }
}
