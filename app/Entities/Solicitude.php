<?php

namespace HelpDesk\Entities;

use HelpDesk\Builder\SolicitudeQuery;
use HelpDesk\Entities\Admin\Departamento;
use HelpDesk\Entities\Admin\User;
use HelpDesk\Entities\Config\Status;
use HelpDesk\Observers\SolicitudeActionObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitude extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'solicitudes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha', 'titulo', 'nombre_adjunto', 'empleado_id', 'incidente', 'adjunto', 'tipo_adjunto', 'revisado_por', 'estatus_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_At'
    ];

    protected $dates = ['fecha'];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;


    public static function boot()
    {
        parent::boot();

        Solicitude::observe(new SolicitudeActionObserver);
    }

    /**
     *
     * Crea una nueva instancia de el constructor de consultas Eloquent
     * para el modelo.
     *
     * Este método separa los filtros a un nueva clase.
     *
     * @param  $query
     * @return SolicitudeQuery|static
     */
    public function newEloquentBuilder($query)
    {
        return new SolicitudeQuery($query);
    }


    public function status()
    {
        return $this->belongsTo(Status::class, 'estatus_id')->withDefault([
            'name'          => 'SE',
            'display_name'  => 'Sin Estatus'
        ]);
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id')->withDefault([
            'name'          => 'SE',
            'display_name'  => 'Sin Estatus'
        ]);
    }

    public function revisadoPor()
    {
        return $this->belongsTo(User::class, 'revisado_por')->withDefault();
    }
}
