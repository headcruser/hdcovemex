<?php

namespace HelpDesk\Entities\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends EntrustPermission
{
    use SoftDeletes,HasFactory;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permisos';

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


      /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\PermissionFactory::new();
    }
}
