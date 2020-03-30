<?php

namespace HelpDesk\Entities\Admin;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EntrustRole
{
    use SoftDeletes;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';


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
        'name',
        'display_name',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
