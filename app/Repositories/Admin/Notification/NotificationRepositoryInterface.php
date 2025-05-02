<?php

namespace App\Repositories\Admin\Notification;

interface NotificationRepositoryInterface
{
    public function store(array $request); // Create new record
}
