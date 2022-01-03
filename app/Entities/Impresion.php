<?php

namespace HelpDesk\Entities;

use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use HelpDesk\Enums\Meses;
use HelpDesk\Entities\Admin\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Impresion extends Model
{
    use HasFactory,FormAccessible;

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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'creado_por', 'id')
            ->withDefault([
                'nombre' => '',
            ]);
    }

    public function getNombreMesAttribute()
    {
        if (empty($this->mes)) {
            return '';
        }

        return Str::ucfirst(Meses::getKey((int)$this->mes));
    }

     #NOTE: Form Model Accessors (Laravel Collective) https://laravelcollective.com/docs/5.4/html

     public function formFechaAttribute($value)
     {
         if (empty($value)) {
             return null;
         }

         return Carbon::parse($value)->format('Y-m-d');
     }
}
