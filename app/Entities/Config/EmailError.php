<?php

namespace HelpDesk\Entities\Config;

use HelpDesk\Entities\Admin\User;
use Illuminate\Database\Eloquent\Model;

class EmailError extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'email_error';

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'subject_id', 'subject_type','description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     *
     * Obtiene al operador que atendio la solicitud
     */
    public function operador() {
        return $this->belongsTo(User::class,'user_id')->withDefault([
        ]);
    }

    /**
     * Get the owning mediable model.
     */
    public function subject()
    {
        return $this->morphTo();
    }
}
