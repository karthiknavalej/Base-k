<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests\Admin\Action\ListRequest;
use App\Http\Requests\Admin\Action\StoreRequest;
use App\Http\Requests\Admin\Action\UpdateRequest;
use App\Http\Requests\Admin\Action\ShowRequest;
use App\Http\Requests\Admin\Action\DestroyRequest;

// Repositories
use App\Repositories\Admin\Action\ActionRepositoryInterface;

// Response
use Illuminate\Http\JsonResponse;

// Exception
use App\Exceptions\ModelNotFoundException;

class ActionController extends Controller
{
    protected $repository;

    public function __construct(ActionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
    * @OA\GET(
    *   path="/admin/actions",
    *   tags={"Admin - Actions"},
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
    * @param  ListRequest $request
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function index(ListRequest $request): ?object
    {
        // Declare variables
        $msg = 'RECORD_EMPTY';
        $response = array();

        // Get all records
        $model = $this->repository->all();

        // Check record's available
        if ($model->count() > 0) {
            // Process records
            $response = $this->repository->process($model, true);
            $msg = 'RECORD_LISTED';
        }

        // Send Response
        $data = ['model' => $response];
        return $this->response(__('messages.'.$msg), compact('data'));
    }

    /**
    * @OA\POST(
    *   path="/admin/actions",
    *   tags={"Admin - Actions"},
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
    *   @OA\Parameter(
    *      name="module",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *           type="string",
    *      )
    *   ),
    *
    *   @OA\Parameter(
    *      name="action",
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
    *    description="Record create.",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="true"),
    *	     @OA\Property(property="code", type="integer", example=200),
    *       @OA\Property(property="locale", type="string", example="en"),
    *       @OA\Property(property="message", type="string", example="Record created successfully."),
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
    public function store(StoreRequest $request): JsonResponse
    {
        // Store new record
        $model = $this->repository->store($request->all());
        // Process record
        $response = $this->repository->process($model);

        // Send Response
        $data = [ "model" => $response ];
        return $this->response(__('messages.RECORD_STORED'), compact('data'));
    }
    
    /**
    * @OA\GET(
    *   path="/admin/actions/{id}",
    *   tags={"Admin - Actions"},
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
    *   path="/admin/actions/{id}",
    *   tags={"Admin - Actions"},
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
    *      required=true,
    *      @OA\Schema(
    *           type="string",
    *      )
    *   ),
    *
    *   @OA\Parameter(
    *      name="module",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *           type="string",
    *      )
    *   ),
    *
    *   @OA\Parameter(
    *      name="action",
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
            $this->authorize('update', $model);
            // Update record
            $this->repository->update($model, $request->all());
            // process record
            $response = $this->repository->process($model);
        } catch (ModelNotFoundException $exception) {
            return $exception->render();
        }

        // Send Response
        $data = ['model' => $response];
        return $this->response(__('messages.RECORD_UPDATED'), compact('data'));
    }

    /**
    * @OA\DELETE(
    *   path="/admin/actions/{id}",
    *   tags={"Admin - Actions"},
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
}
