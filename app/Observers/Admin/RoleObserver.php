<?php

declare(strict_types=1);

namespace App\Observers\Admin;

use App\Models\Role;

class RoleObserver
{
    /**
    * The attribute contains user id.
    *
    * @var int
    */
    protected $userId = null;
    /**
    * The attribute contains date and time.
    *
    * @var DateTime
    */
    protected $dateTime = null;

    public function __construct()
    {
        $this->userId = auth()->user()->id;
        $this->dateTime = now(config('constants.TIME_ZONE'));
    }

    public function creating(Role $model)
    {
        $model->name = strtolower($model->name);
        $model->slug = strtolower($model->name);
        $model->created_by = $this->userId;
        $model->created_at = $this->dateTime;
    }

    public function updating(Role $model)
    {
        $model->name = strtolower($model->name);
        $model->slug = strtolower($model->name);
        $model->updated_by = $this->userId;
        $model->updated_at = $this->dateTime;
    }
}
