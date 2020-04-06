<?php

namespace HelpDesk\Entities;

use HelpDesk\Entities\Admin\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SigoTicket extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'sigo_ticket';

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
        'ticket_id',
        'operador_id',
        'usuario_id',
        'campo_cambiado',
        'valor_anterior',
        'valor_actual',
        'comentario',
        'privado',
        'adjunto',
        'tipo_adjunto',
        'nombre_adjunto',
    ];

    protected $dates = ['fecha'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_At'
    ];

    public static function boot()
    {
        parent::boot();
    }

    function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }

    function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id')
            ->withDefault();
    }

    function operador()
    {
        return $this->belongsTo(User::class, 'operador_id', 'id')
            ->withDefault();
    }

    public function getAutorAttribute($key)
    {
        if (!empty($this->usuario_id)) {
            return $this->usuario->nombre;
        }

        if (!empty($this->operador_id)) {
            return $this->operador->nombre;
        }

        return '';
    }
}
