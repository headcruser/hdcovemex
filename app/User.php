<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
        'name', 'email', 'password',
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

    /**
     * Obtiene la imagen de perfil
     *
     * @return void
     */
    public function getAvatarUrl()
    {
        $url = 'users'.DIRECTORY_SEPARATOR.$this->foto;

        if(!$this->foto){
            return asset('img/theme/avatar.png');
        }

        if (!Storage::disk('local')->exists('public'.DIRECTORY_SEPARATOR.$url) ) {
            return asset('img/theme/avatar.png');
        }

        return Storage::url($url);
    }
}
