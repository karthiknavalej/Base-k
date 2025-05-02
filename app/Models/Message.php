<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
    * The attribute that are table name.
    *
    * @var string
    */
    protected $table = 'messages';

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
     * The "user" method of the Relationship User.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
