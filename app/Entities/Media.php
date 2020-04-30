<?php

namespace HelpDesk\Entities;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'media';

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
        'media_type','media_id','name','file','mime_type','size'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * Get the owning mediable model.
     */
    public function modelo()
    {
        return $this->morphTo();
    }

     /**
     * Format Size file.
     *
     * @param  string  $value
     * @return string
     */
    public function getSizeAttribute($value)
    {
        return formatBytes($value);
    }
}
