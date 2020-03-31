<?php

namespace HelpDesk\Entities;

use HelpDesk\Entities\Admin\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comentarios';

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'usuario_id',
        'solicitud_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'autor_nombre',
        'autor_email',
        'comentario_texto',
    ];


    public function solicitud()
    {
        return $this->belongsTo(Solicitude::class, 'solicitud_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
