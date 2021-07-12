<?php

namespace HelpDesk\Entities\Inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoAsignado extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipo_asignado';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'fecha_entrega','fecha_mantenimiento'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_personal',
        'id_equipo',
        'fecha_entrega',
        'fecha_mantenimiento',
        'carta_responsiva',
        'observaciones',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class,'id_personal')->withDefault();
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class,'id_equipo')->withDefault();
    }
}
