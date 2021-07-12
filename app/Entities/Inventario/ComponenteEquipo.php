<?php

namespace HelpDesk\Entities\Inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponenteEquipo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'componentes_equipo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_equipo',
        'id_hardware',
        'observacion',
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo')->withDefault();
    }

    public function hardware()
    {
        return $this->belongsTo(Hardware::class,'id_hardware')->withDefault();
    }
}
