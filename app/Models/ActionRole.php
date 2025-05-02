<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionRole extends Model
{
    use HasFactory;

    /**
    * The attribute that are table name.
    *
    * @var string
    */
    protected $table = 'action_role';

    public function scopeRoles($query, $roleIds)
    {
        return $query->whereIn('role_id', $roleIds)->get();
    }
}
