<?php

declare(strict_types=1);

namespace App\Repositories\Admin\Notification;

// Model
use App\Models\Notification;

class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * @var model
    */
    protected $model;

    /**
     *
     * @method __construct
     *
     * @param Notification $model
    */
    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    /**
     * Create new record
     *
     * @method store
     *
     * @param  array $request
     * @return App\Models\Notification
     *
    */
    public function store(array $request): ?Notification
    {
        return $this->model->create($request);
    }

}
