<?php

namespace HelpDesk\Entities\Faqs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQ extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faqs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pregunta',
        'slug',
        'respuesta',
        'total_lecturas',
        'ayuda_si',
        'ayuda_no',
        'id_categoria_faq',
        'orden',
        'visible'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'visible' => 'bool',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function categoria()
    {
        return $this->belongsTo(FaqCategoria::class, 'id_categoria_faq', 'id')
            ->withDefault();
    }

    public function getResumenRespuestaAttribute()
    {
        return substr(strip_tags($this->attributes['respuesta']), 0, 80) . '...';
    }
}
