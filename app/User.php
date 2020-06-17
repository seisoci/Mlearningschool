<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

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
        'password', 'remember_token', 'api_token', 'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime:Y-m-d h:i:s',
        'updated_at'        => 'datetime:Y-m-d'
    ];

    public function mlearningkelas(){
        return $this->hasMany(Mlearningkelas::class)->orderBy('created_at', 'desc');
    }

    public function mlearningsiswa(){
        return $this->hasMany(Mlearningsiswa::class, 'siswa_id')->orderBy('created_at', 'desc');
    }

    public function mlearningmateri(){
        return $this->hasMany(Mlearningkomentar::class);
    }

    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }
}