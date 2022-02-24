<?php

namespace HelpDesk\Entities\Inventario;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipo extends Model
{
    use HasFactory, FormAccessible;

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

    #NOTE: Form Model Accessors (Laravel Collective) https://laravelcollective.com/docs/5.4/html

    public function formFechaEquipoAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    public function scopeWithLastEquipo($query)
    {
        $subselect = EquipoAsignado::select([
            'personal' => Personal::select('nombre')
                ->whereColumn('id', 'equipo_asignado.id_personal')
                ->orderBy('created_at', 'desc')
                ->limit(1)
        ])->whereColumn('equipo_asignado.id_equipo', 'equipos.id')
            ->latest()
            ->limit(1);

        $query->addSelect(['personal_equipo_asignado' => $subselect]);

        return $query;
    }
}
