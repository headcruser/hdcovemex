<?php

namespace HelpDesk\Entities;

use HelpDesk\Entities\Admin\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

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
        'adjunto',
        'tipo_adjunto',
        'nombre_adjunto'
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

    public static function boot()
    {
        parent::boot();
    }

    public function sigoTicket()
    {
        return $this->hasMany(SigoTicket::class, 'ticket_id','id');
    }

    public function usuario()
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
