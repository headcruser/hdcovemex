<?php

namespace HelpDesk\Entities\Admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable , EntrustUserTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'telefono', 'password', 'departamento_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
        $url = 'users' . DIRECTORY_SEPARATOR . $this->foto;

        if (!$this->foto) {
            return asset('img/theme/avatar.png');
        }

        if (!Storage::disk('local')->exists('public' . DIRECTORY_SEPARATOR . $url)) {
            return asset('img/theme/avatar.png');
        }

        return Storage::url($url);
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }
}
