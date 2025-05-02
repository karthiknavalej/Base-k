<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Events\MessageDelivered;
use App\Events\MessageSent;
use App\Events\PrivateMessageSent;
use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Admin\Message\ListRequest;
use App\Http\Requests\Admin\Message\StoreRequest;
use App\Http\Requests\Admin\Message\ShowRequest;
use App\Http\Requests\Admin\Message\UpdateRequest;
use App\Http\Requests\Admin\Message\DestroyRequest;
use App\Http\Requests\Admin\Message\ListRequestPrivate;
use App\Http\Requests\Admin\Message\StoreRequestPrivate;
use App\Http\Requests\Admin\Message\DownloadRequest;


// Repositories
use App\Repositories\Admin\Message\MessageRepositoryInterface;

// Response
use Illuminate\Http\JsonResponse;

// Exception
use App\Exceptions\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;

class MessageController extends Controller
{
    protected $repository;

    public function __construct(MessageRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->pusher = new Pusher(env("PUSHER_APP_KEY"), env("PUSHER_APP_SECRET"), env("PUSHER_APP_ID"), array('cluster' => env("PUSHER_APP_CLUSTER")));
    }

    /**
    * @OA\GET(
    *   path="/admin/messages",
    *   tags={"Admin - Messages"},
    *   security={{"passport": {}},},
    *   summary="- List all",
    *   description="List all records",
    *   operationId="list",
    *
    *  @OA\Parameter(
    *      name="x-localization",
    *      in="header",
    *      @OA\Schema(
    *           type="string",
    *      )
    *   ),
    *
    *   @OA\Response(
    *    response=401,
    *    description="Unauthorized Error Message",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=401),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Unauthorized."),
    *    )
    *  ),
    *
    * @OA\Response(
    *    response=500,
    *    description="Something went wrong.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=500),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Error occured."),
    *    )
    *   ),
    *
    *  @OA\Response(
    *    response=200,
    *    description="Record's List.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="true"),
    *	     @OA\Property(property="code", type="integer", example=200),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Record listed successfully."),
    *       @OA\Property(property="data", type="array", example="[]", @OA\Items(type="array",@OA\Items())),
    *       )
    *   ),
    * )
    **/

    /**
    * List all records.
    *
    * @method index
    *
    * @param  StoreRequest $request
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(ListRequest $request): JsonResponse
    {
        // Declare variables
        $msg = 'RECORD_EMPTY';
        $response = array();

        // Get all records
        $model = $this->repository->all();

        // Check record's available
        if ($model->count() > 0) {
            // Process records
            $response = $model;
            $msg = 'RECORD_LISTED';
        }

        // Send Response
        $data = $response;
        return $this->response(__('messages.'.$msg), compact('data'));
    }

    /**
    * @OA\POST(
    *   path="/admin/messages",
    *   tags={"Admin - Messages"},
    *   security={{"passport": {}},},
    *   summary="- Store",
    *   description="Store new record",
    *   operationId="store",
    *
    *   @OA\Parameter(
    *      name="name",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *           type="string",
    *      )
    *   ),
    *
    *  @OA\Parameter(
    *      name="x-localization",
    *      in="header",
    *      @OA\Schema(
    *           type="string",
    *      )
    *   ),
    *
    *   @OA\Response(
    *    response=401,
    *    description="Unauthorized Error Message",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=401),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Unauthorized."),
    *    )
    *  ),
    *
    *  @OA\Response(
    *    response=422,
    *    description="Validation Error Messages",
    *    @OA\JsonContent(
    *       @OA\Property(property="name.required", type="string", example="name field is required"),
    *    )
    *  ),
    *
    *  @OA\Response(
    *    response=404,
    *    description="Record not found",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=404),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Record not found.")
    *        )
    *     ),
    *
    * @OA\Response(
    *    response=500,
    *    description="Something went wrong.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=500),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Error occured."),
    *    )
    *   ),
    *
    *  @OA\Response(
    *    response=200,
    *    description="Record store.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="true"),
    *	     @OA\Property(property="code", type="integer", example=200),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Record stored successfully."),
    *       @OA\Property(property="data", type="array", example="[]", @OA\Items(type="array",@OA\Items())),
    *       )
    *   ),
    * )
    **/

    /**
    * Store new record.
    *
    * @method store
    *
    * @param  StoreRequest $request
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function sendMessage(StoreRequest $request): JsonResponse
    {
           
        $message = $this->repository->store($request->all());

        broadcast(new MessageSent(auth()->user(),$message->load('user')))->toOthers();

        return $this->response(__('Message sent successfully'), compact('message'));
    }

    /**
    * @OA\GET(
    *   path="/admin/messages/{id}",
    *   tags={"Admin - Messages"},
    *   security={{"passport": {}},},
    *   summary="- Get by ID",
    *   description="Get by ID",
    *   operationId="show",
    *
    *   @OA\Parameter(
    *      name="id",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *           type="integer",
    *      )
    *   ),
    *
    *  @OA\Parameter(
    *      name="x-localization",
    *      in="header",
    *      @OA\Schema(
    *           type="string",
    *      )
    *   ),
    *
    *   @OA\Response(
    *    response=401,
    *    description="Unauthorized Error Message",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=401),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Unauthorized."),
    *    )
    *  ),
    *
    *  @OA\Response(
    *    response=422,
    *    description="Validation Error Messages",
    *    @OA\JsonContent(
    *       @OA\Property(property="id.required", type="integer", example="id field is required"),
    *       @OA\Property(property="id.integer", type="integer", example="id field should be integer"),
    *    )
    *  ),
    *
    *  @OA\Response(
    *    response=404,
    *    description="Record not found",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=404),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Record not found.")
    *        )
    *     ),
    *
    * @OA\Response(
    *    response=500,
    *    description="Something went wrong.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=500),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Error occured."),
    *    )
    *   ),
    *
    *  @OA\Response(
    *    response=200,
    *    description="Record fetch.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="true"),
    *	     @OA\Property(property="code", type="integer", example=200),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Record fetched successfully."),
    *       @OA\Property(property="data", type="array", example="[]", @OA\Items(type="array",@OA\Items())),
    *       )
    *   ),
    *)
    **/

    /**
    * Get record from table by Id.
    *
    * @method show
    *
    * @param  ShowRequest $request
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function show(ShowRequest $request): JsonResponse
    {
        try {
            // Get single record
            $model = $this->repository->find((int) $request['id']);
            $this->authorize('view', $model);
            // Process record
            $response = $this->repository->process($model);
        } catch (ModelNotFoundException $exception) {
            return $exception->render();
        }
        
        // Send Response
        $data = ['model' => $response];
        return $this->response(__('messages.RECORD_FETCHED'), compact('data'));
    }

    /**
    * @OA\PUT(
    *   path="/admin/messages/{id}",
    *   tags={"Admin - Messages"},
    *   security={{"passport": {}},},
    *   summary="- Update by ID",
    *   description="Update by ID",
    *   operationId="update",
    *
    *   @OA\Parameter(
    *      name="id",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *           type="integer",
    *      )
    *   ),
    *
    *   @OA\Parameter(
    *      name="name",
    *      in="query",
    *      @OA\Schema(
    *           type="string",
    *      )
    *   ),
    *
    *  @OA\Parameter(
    *      name="x-localization",
    *      in="header",
    *      @OA\Schema(
    *           type="string",
    *      )
    *   ),
    *
    *   @OA\Response(
    *    response=401,
    *    description="Unauthorized Error Message",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=401),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Unauthorized."),
    *    )
    *  ),
    *
    *  @OA\Response(
    *    response=422,
    *    description="Validation Error Messages",
    *    @OA\JsonContent(
    *       @OA\Property(property="id.required", type="integer", example="id field is required"),
    *       @OA\Property(property="id.integer", type="integer", example="id field should be integer"),
    *       @OA\Property(property="name", type="string", example="name field is required"),
    *    )
    *  ),
    *
    *  @OA\Response(
    *    response=404,
    *    description="Record not found",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=404),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Record not found.")
    *        )
    *     ),
    *
    * @OA\Response(
    *    response=500,
    *    description="Something went wrong.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=500),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Error occured."),
    *    )
    *   ),
    *
    *  @OA\Response(
    *    response=200,
    *    description="Record update.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="true"),
    *	     @OA\Property(property="code", type="integer", example=200),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Record updated successfully."),
    *       @OA\Property(property="data", type="array", example="[]", @OA\Items(type="array",@OA\Items())),
    *       )
    *   ),
    * )
    **/

    /**
    * Update record in table.
    *
    * @method update
    *
    * @param  UpdateRequest $request
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function update(UpdateRequest $request): JsonResponse
    {
        try {
            // Get single record
            $model = $this->repository->find((int) $request['id']);
            // Update record
            $model->update(['status' => 'Delivered']);
            broadcast(new MessageDelivered(auth()->user(),$model->load('user')));
            // process record
        } catch (ModelNotFoundException $exception) {
            return $exception->render();
        }

        // Send Response
        $data = $model;
        return $this->response(__('messages.RECORD_UPDATED'), compact('data'));
    }

    /**
    * @OA\DELETE(
    *   path="/admin/messages/{id}",
    *   tags={"Admin - Messages"},
    *   security={{"passport": {}},},
    *   summary="- Delete by ID",
    *   description="Delete by ID",
    *   operationId="delete",
    *
    *   @OA\Parameter(
    *      name="id",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
                type = "integer",
    *      )
    *   ),
    *
    *  @OA\Parameter(
    *      name="x-localization",
    *      in="header",
    *      @OA\Schema(
    *           type="string",
    *      )
    *   ),
    *
    *   @OA\Response(
    *    response=401,
    *    description="Unauthorized Error Message",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=401),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Unauthorized."),
    *    )
    *  ),
    *
    *  @OA\Response(
    *    response=422,
    *    description="Validation Error Messages",
    *    @OA\JsonContent(
    *       @OA\Property(property="id.required", type="integer", example="id field is required"),
    *       @OA\Property(property="id.integer", type="integer", example="id field should be integer"),
    *    )
    *  ),
    *
    *  @OA\Response(
    *    response=404,
    *    description="Record not found",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=404),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Record not found.")
    *        )
    *     ),
    *
    * @OA\Response(
    *    response=500,
    *    description="Something went wrong.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *	    @OA\Property(property="code", type="integer", example=500),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Error occured."),
    *    )
    *   ),
    *
    *  @OA\Response(
    *    response=200,
    *    description="Record delete.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="true"),
    *	    @OA\Property(property="code", type="integer", example=200),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Record deleted successfully."),
    *       )
    *   ),
    * )
    **/

    /**
      * Destroy record from table by id.
      *
      * @method destroy
      *
      * @param  DestroyRequest $request
      *
      * @return \Illuminate\Http\JsonResponse
    */
    public function destroy(DestroyRequest $request): JsonResponse
    {
        try {
            // Get single record
            $model = $this->repository->find((int) $request['id']);
            $this->authorize('delete', $model);
            // Destroy record
            $this->repository->destroy($model);
            // Process record
            $response = $this->repository->process($model);
        } catch (ModelNotFoundException $exception) {
            return $exception->render();
        }

        // Send Response
        $data = ['model' => $response];
        return $this->response(__('messages.RECORD_DELETED'), compact('data'));
    }

    /**
    * List all records.
    *
    * @method index
    *
    * @param  ListRequestPrivate $request
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function privateMessages(ListRequestPrivate $request): JsonResponse
    {
        // Declare variables
        $msg = 'RECORD_EMPTY';
        $response = array();

        // Get all records
        $model = $this->repository->privateCommunication($request);
        // Check record's available
        if ($model->count() > 0) {
            // Process records
            $response = $model;
            $msg = 'RECORD_LISTED';
        }

        $data = $model;
        return $this->response(__('messages.'.$msg), compact('data'));
    }

    /**
    * sendPrivateMessage new record.
    *
    * @method sendPrivateMessage
    *
    * @param  StoreRequestPrivate $request
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function sendPrivateMessage(StoreRequestPrivate $request): JsonResponse
    {
           
        $message = $this->repository->storePrivateMessage($request->all());

        broadcast(new PrivateMessageSent($message->load('user')))->toOthers();

        return $this->response(__('Message sent successfully'), compact('message'));
    }

    
    /**
     * Download uploaded file by id.
     *
     * @method download
     *
     * @param  DownloadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function download(DownloadRequest $request): JsonResponse
    {
        
        try {
            $model = $this->repository->find((int) $request->id);
            if ($model->image) {
                // Get file url
                $filepath = Storage::disk()->url($model->image);
                // Send response
                $data = [
                    'filepath' => $filepath
                ];
                return $this->response(__('messages.DOWNLOAD_SUCCESS'), compact('data'));
            } else {
                return $this->response(__('messages.DOWNLOAD_FAIL'));
            }
            
        } catch (ModelNotFoundException $exception) {
            return $exception->render();
        }
    }

    /**
     * Channels list uploaded file by id.
     *
     * @method channelList
     *
     */
    public function channelList()
    {
        $this->pusher->getChannelInfo('private-lchat');

        $response = $this->pusher->get('/channels'); 
        return $this->response(__('messages.SUCCESS'), compact('response'));
    }

    /**
     * Channels Info uploaded file by id.
     *
     * @method channelInfo
     *
     */
    public function channelInfo()
    {   
        $response = $this->pusher->get('/channels/private-lchat'); 
        return $this->response(__('messages.SUCCESS'), compact('response'));
    }

    /**
     * Terminate user connection from pusher.
     *
     * @method terminateUserConnections
     *
     */
    public function terminateUserConnections()
    {   
        $response = $this->pusher->terminateUserConnections('user-id');
        return $this->response(__('messages.SUCCESS'), compact('response'));
    }
    
}
