<?php

namespace HelpDesk\Entities;

use HelpDesk\Entities\Inventario\Personal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpresionDetalle extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'impresiones_detalles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_impresiones',
        'id_impresion',
        'id_impresora',
        'negro',
        'color',
        'total',
    ];

    public function impresion()
    {
        return $this->belongsTo(Impresion::class,'id_impresiones')
            ->withDefault();
    }

    public function impresora()
    {
        return $this->belongsTo(Impresora::class,'id_impresora')->withDefault();
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class,'id_impresion','id_impresion')->withDefault();
    }
}
