<?php

namespace HelpDesk\Entities\Admin;

use HelpDesk\Entities\Media;
use HelpDesk\Entities\Ticket;
use HelpDesk\Entities\Solicitude;

use Illuminate\Support\Facades\Hash;
use HelpDesk\Builder\Admin\UserQuery;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuarios';

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
        'nombre', 'email', 'telefono', 'password', 'departamento_id', 'usuario'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *
     * Crea una nueva instancia de el constructor de consultas Eloquent
     * para el modelo.
     *
     * Este método separa los filtros a un nueva clase.
     *
     * @param  $query
     * @return UserQuery|static
     */
    public function newEloquentBuilder($query)
    {
        return new UserQuery($query);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\UserFactory::new();
    }

    ## RELACIONES

    /**
     * Obtiene el archivo asociado al modelo
     */
    public function media()
    {
        return $this->morphOne(Media::class, 'media');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id')
            ->withDefault([
                'nombre' => 'Sin Depto.'
            ]);
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitude::class, 'usuario_id', 'id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'usuario_id', 'id');
    }

    public function operador()
    {
        return $this->hasOne(Operador::class, 'usuario_id', 'id')->withDefault();
    }

    public function isOperador()
    {
        return $this->operador()->exists();
    }

    ## ACCESORES

    /**
     * Obtiene el nombre del rol del usuario
     *
     * @return string
     */
    public function getNameRoleUserAttribute()
    {
        $roles = $this->cachedRoles();

        if (is_null($roles) || $roles->isEmpty()) {
            return '(Sin Rol)';
        }

        return $roles->pluck('display_name')->implode(' ');
    }
    /**
     * Obtiene la imagen de perfil
     *
     * @return string
     */
    public function getAvatarAttribute()
    {
        if (empty($this->media)) {
            return asset('img/theme/avatar.png');
        }

        return $this->media->file;
    }

    ## MUTADORES

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    /**
     * Big block of caching functionality.
     *
     * @return mixed Roles
     */
    public function cachedRoles()
    {
        $userPrimaryKey = $this->primaryKey;
        $cacheKey = 'entrust_roles_for_user_' . $this->$userPrimaryKey;

        return Cache::remember($cacheKey, Config::get('cache.ttl'), function () {
            return $this->roles()->get();
        });
    }


    /**
     * {@inheritDoc}
     */
    public function save(array $options = [])
    {
        $userPrimaryKey = $this->primaryKey;
        $cacheKey = 'entrust_roles_for_user_' . $this->$userPrimaryKey;

        Cache::forget($cacheKey);

        return parent::save($options);
    }
}
