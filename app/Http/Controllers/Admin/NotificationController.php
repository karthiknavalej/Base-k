<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

// Controller
use App\Http\Controllers\Controller;
// Request
use App\Http\Requests\Admin\Notification\StoreRequest;
use Illuminate\Http\Request;
// Repositories
use App\Repositories\Admin\Notification\NotificationRepositoryInterface;
// Response
use Illuminate\Http\JsonResponse;

//Traits
use App\Traits\Notifications;

class NotificationController extends Controller
{
    use Notifications;

    /**
     * @var $repository
    */
    protected $repository;

    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
    * Store new record.
    *
    * @method store
    *
    * @param  StoreRequest $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function store(StoreRequest $request): JsonResponse
    {
        // Store new record
        $model = $this->repository->store($request->all());

        //send push notifications
        $this->sendPushNotifications((object) $model);


        // Send Response
        $data = [ "model" => $model ];
        return $this->response(__('messages.RECORD_STORED'), compact('data'));
    }
}
