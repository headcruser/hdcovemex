<?php

namespace HelpDesk\Entities\Inventario;

use HelpDesk\Entities\Admin\Departamento;
use HelpDesk\Entities\Admin\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'id_sucursal',
        'id_usuario',
        'id_departamento',
        'id_impresion'
    ];


    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal')->withDefault();
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario')->withDefault();
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento')->withDefault();
    }

    public function cuentas()
    {
        return $this->hasMany(CuentaPersonal::class,'id_personal','id');
    }

    public function equipos_asignados()
    {
        return $this->hasMany(EquipoAsignado::class,'id_personal','id');
    }
}
