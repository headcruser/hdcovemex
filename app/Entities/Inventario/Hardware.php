<?php

namespace HelpDesk\Entities\Inventario;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Collective\Html\Eloquent\FormAccessible;

class Hardware extends Model
{
    use HasFactory,FormAccessible;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hardware';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'fecha_compra'];

    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'Activo'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_compra',
        'descripcion',
        'no_serie',
        'marca',
        'proveedor',
        'id_tipo_hardware',
        'status',
        'asignado'
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoHardware::class,'id_tipo_hardware')
            ->withDefault();
    }


    #NOTE: Form Model Accessors (Laravel Collective) https://laravelcollective.com/docs/5.4/html

    public function formFechaCompraAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return Carbon::parse($value)->format('Y-m-d');
    }
}
