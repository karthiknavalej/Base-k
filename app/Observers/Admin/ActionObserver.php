<?php

declare(strict_types=1);

namespace App\Observers\Admin;

use App\Models\Action;

// Other
use Illuminate\Support\Str;

class ActionObserver
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

    public function creating(Action $model)
    {
        $model->name = Str::of($model->name)->lower();
        $model->slug = Str::slug($model->name, '-');
        $model->module = Str::of($model->module)->lower();
        $model->action = Str::of($model->action)->lower();
        $model->created_by = $this->userId;
        $model->created_at = $this->dateTime;
    }

    public function updating(Action $model)
    {
        $model->name = Str::of($model->name)->lower();
        $model->slug = Str::slug($model->name, '-');
        $model->module = Str::of($model->module)->lower();
        $model->action = Str::of($model->action)->lower();
        $model->updated_by = $this->userId;
        $model->updated_at = $this->dateTime;
    }
}
