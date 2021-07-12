<?php

namespace HelpDesk\Entities\Inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipos';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'fecha_equipo'];

    protected $attributes = [
        'status' => 'Activo' # Activo | Inactivo| Mantenimiento
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'fecha_equipo',
        'descripcion',
        'status',
    ];

    public function historial_asignaciones()
    {
        return $this->hasMany(EquipoAsignado::class, 'id_equipo', 'id');
    }
}
