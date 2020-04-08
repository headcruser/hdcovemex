<?php

namespace HelpDesk\Entities\Admin;



use HelpDesk\Builder\Admin\UserQuery;
use HelpDesk\Entities\Solicitude;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

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
        'nombre', 'email', 'telefono', 'password', 'departamento_id', 'usuario', 'foto', 'tipo_foto', 'nombre_foto',
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

    /*///////////////////////////////////////////////////////////////////////////
                        RELACIONES
    /////////////////////////////////////////////////////////////////////////// */

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

    /*///////////////////////////////////////////////////////////////////////////
                        MUTADORES
    /////////////////////////////////////////////////////////////////////////// */

    /**
     * Obtiene la imagen de perfil
     *
     * @return void
     */
    public function getAvatarAttribute()
    {
        if (!$this->foto) {
            return asset('img/theme/avatar.png');
        }

        return "data:image;base64,{$this->foto}";
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }
}
