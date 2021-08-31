<?php

namespace HelpDesk\Entities;

use HelpDesk\Enums\Meses;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Impresion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'impresiones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha',
        'mes',
        'anio',
        'negro',
        'color',
        'total',
        'creado_por',
    ];

    protected $dates = ['created_at', 'updated_at', 'fecha'];

    public function detalles()
    {
        return $this->hasMany(ImpresionDetalle::class, 'id_impresiones', 'id');
    }

    public function getNombreMesAttribute()
    {
        if (empty($this->mes)) {
            return '';
        }

        return Str::ucfirst(Meses::getKey((int)$this->mes));
    }
}
