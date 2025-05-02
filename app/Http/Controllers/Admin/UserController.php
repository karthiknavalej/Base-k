<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Admin\User\ListRequest;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\ShowRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Http\Requests\Admin\User\DestroyRequest;

// Repositories
use App\Repositories\Admin\User\UserRepositoryInterface;

// Response
use Illuminate\Http\JsonResponse;

// Exception
use App\Exceptions\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
    * @OA\GET(
    *   path="/admin/users",
    *   tags={"Admin - Users"},
    *   security={{"bearer": {}},},
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
            $response = $this->repository->process($model, true);
            $msg = 'RECORD_LISTED';
        }

        // Send Response
        $data = ['model' => $response];
        return $this->response(__('messages.'.$msg), compact('data'));
    }

    
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
    *   path="/admin/users/{id}",
    *   tags={"Admin - Users"},
    *   security={{"bearer": {}},},
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
            // $this->authorize('view', $model);
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
    *   path="/admin/users/update/{id}",
    *   tags={"Admin - Users"},
    *   security={{"bearer": {}},},
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
            // $this->authorize('update', $model);
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
    *   path="/admin/users/delete/{id}",
    *   tags={"Admin - Users"},
    *   security={{"bearer": {}},},
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
            // $this->authorize('delete', $model);
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

    public function handleLineLogin(Request $request)
    {
        try {
            $code = $request->input('code');
            // Step 1: Exchange authorization code for tokens
            $tokenResponse = Http::asForm()->post('https://api.line.me/oauth2/v2.1/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => env('NEXT_PUBLIC_LINE_CALLBACK_URL'),
                'client_id' => env('NEXT_PUBLIC_LINE_CHANNEL_ID'),
                'client_secret' => env('NEXT_PUBLIC_LINE_CHANNEL_SECRET'),
            ]);

            if (!$tokenResponse->successful()) {
                return response()->json(['error' => 'Failed to get access token', 'details' => $tokenResponse->json()], 500);
            }

            $tokenData = $tokenResponse->json();

            // Step 2: Get user profile
            $profileResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $tokenData['access_token'],
            ])->get('https://api.line.me/v2/profile');

            if (!$profileResponse->successful()) {
                return response()->json(['error' => 'Failed to get user profile', 'details' => $profileResponse->json()], 500);
            }

            $profile = $profileResponse->json();

            // Step 3: Send push message
            $pushResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('LINE_CHANNEL_ACCESS_TOKEN'),
                'Content-Type' => 'application/json',
            ])->post('https://api.line.me/v2/bot/message/push', [
                'to' => $profile['userId'],
                'messages' => [
                    [
                        'type' => 'text',
                        'text' => 'Hello, welcome to our service!',
                    ],
                ],
            ]);

            if (!$pushResponse->successful()) {
                return response()->json(['error' => 'Failed to send message', 'details' => $pushResponse->json()], 500);
            }

            // Step 4: Return response
            return response()->json([
                'tokenData' => $tokenData,
                'profile' => $profile,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Internal Server Error',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
