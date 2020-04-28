<?php

namespace HelpDesk\Entities\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

use Zizaco\Entrust\EntrustRole;

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

    //Big block of caching functionality.
    public function cachedPermissions()
    {
        $rolePrimaryKey = $this->primaryKey;
        $cacheKey = 'entrust_permissions_for_role_' . $this->$rolePrimaryKey;

        return Cache::remember($cacheKey, Config::get('cache.ttl'), function () {
            return $this->perms()->get();
        });
    }

    public function save(array $options = [])
    {
        if (!parent::save($options)) {
            return false;
        }

        $rolePrimaryKey = $this->primaryKey;
        $cacheKey = 'entrust_permissions_for_role_' . $this->$rolePrimaryKey;

        Cache::forget($cacheKey);

        return true;
    }
}
