<?php

namespace HelpDesk\Entities\Inventario;

use HelpDesk\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Credencial extends Model
{
    use HasFactory,Encryptable;

    protected $encryptable = [
        'contrasenia',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'credenciales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'usuario',
        'contrasenia',
        'nota',
        'url',
        'caducidad',
    ];

}
