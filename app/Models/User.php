<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use HasRoles;

    /**
    * The attribute that are table name.
    *
    * @var string
    */
    protected $table = 'users';
    protected $guard_name = 'api';
    /**
    * The attribute that are guarded from mass assignable.
    *
    * @var array
    */
    protected $guarded = [];

    /**
    * The attribute that are protecting datetime assigned by default.
    *
    * @var bool
    */
    public $timestamps = false;

    /**
    * The attribute that are extending carbon class.
    *
    * @var array
    */
    protected $dates = [ 'deleted_at' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
