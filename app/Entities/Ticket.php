<?php

namespace HelpDesk\Entities;

use HelpDesk\Builder\TicketQuery;
use HelpDesk\Entities\Admin\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'tickets';

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
        'fecha',
        'privado',
        'operador_id',
        'usuario_id',
        'contacto',
        'prioridad',
        'titulo',
        'incidente',
        'proceso',
        'tipo',
        'sub_tipo',
        'estado',
        'asignado_a'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_At'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fecha'];

    public static function boot()
    {
        parent::boot();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\TicketFactory::new();
    }

    /**
     *
     * Crea una nueva instancia de el constructor de consultas Eloquent
     * para el modelo.
     *
     * Este método separa los filtros a un nueva clase.
     *
     * @param  $query
     * @return TicketQuery|static
     */
    public function newEloquentBuilder($query)
    {
        return new TicketQuery($query);
    }

    ## RELATIONS

    /**
     * Obtiene el archivo asociado al modelo
     */
    public function media()
    {
        return $this->morphOne(Media::class, 'media');
    }

    public function sigoTicket()
    {
        return $this->hasMany(SigoTicket::class, 'ticket_id', 'id');
    }

    public function solicitud()
    {
        return $this->hasOne(Solicitude::class, 'ticket_id');
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'usuario_id')
            ->withDefault(function ($user) {
                $user->name = 'S/Empleado';
            });
    }

    public function operador()
    {
        return $this->belongsTo(User::class, 'operador_id')
            ->withDefault(function ($user) {
                $user->name = 'S/Empleado';
            });
    }

    ## ACCESORS
    public function getNombrePrioridadAttribute()
    {
        $prioridades = Config::get('helpdesk.tickets.prioridad.values', []);

        if (empty($this->prioridad) || empty($prioridades)) {
            return 'Baja';
        }

        if (!array_key_exists($this->prioridad, $prioridades)) {
            return 'Baja';
        }

        return $prioridades[$this->prioridad];
    }

    public function getColorPrioridadAttribute()
    {
        $prioridades = Config::get('helpdesk.tickets.prioridad.colors', []);

        if (empty($this->prioridad) || empty($prioridades)) {
            return '#FFFFFF';
        }

        if (!array_key_exists($this->prioridad, $prioridades)) {
            return '#FFFFFF';
        }

        return $prioridades[$this->prioridad];
    }
}
