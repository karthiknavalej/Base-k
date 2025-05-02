<?php

declare(strict_types=1);

namespace App\Observers\Admin;

use App\Models\User;

class UserObserver
{
    /**
    * The attribute contains date and time.
    *
    * @var DateTime
    */
    protected $dateTime = null;

    public function __construct()
    {
        $this->dateTime = now(config('constants.TIME_ZONE'));
    }

    public function creating(User $user)
    {
        $user->created_at = $this->dateTime;
    }

    public function updating(User $user)
    {
        $user->updated_at = $this->dateTime;
    }
}
