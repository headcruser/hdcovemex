<?php

namespace HelpDesk\Entities\Admin;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EntrustRole
{
    use SoftDeletes;

    public $table = 'roles';

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
