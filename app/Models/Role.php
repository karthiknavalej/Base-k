<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
    * The attribute that are table name.
    *
    * @var string
    */
    protected $table = 'roles';

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


    public function actions()
    {
        return $this->belongsToMany(Action::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
