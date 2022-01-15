<?php

namespace HelpDesk\Entities\Inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPersonal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cuentas_personal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_personal',
        'titulo',
        'descripcion',
        'usuario',
        'contrasenia'
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class,'id_personal')->withDefault();
    }
}
