<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\Auth\UserDeviceTokensRequest;

//Model
use Spatie\Permission\Models\Role;

// Repositories
use App\Repositories\Auth\AuthRepositoryInterface;

// Response
use Illuminate\Http\JsonResponse;

// Exception
use App\Exceptions\Auth\UserNotFoundException;
use SendMail;
//Other
use App\Http\Traits\UseMailTrait;
class AuthController extends Controller
{
    use UseMailTrait;
    /**
      * @var $repository
    */
    protected $repository;

    public function __construct(AuthRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
        * @OA\Post(
        * path="/auth/login",
        *   tags={"Authentication"},
        *   summary="- Sign In",
        *   operationId="login",
        *
        *   @OA\Parameter(
        *      name="email",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string",
        *      )
        *   ),
        *   @OA\Parameter(
        *      name="password",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *          type="string"
        *      )
        *   ),
        *   @OA\Parameter(
        *      name="type",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *          type="string"
        *      )
        *   ),
        *  @OA\Parameter(
        *      name="x-localization",
        *      in="header",
        *      @OA\Schema(
        *           type="string",
        *      )
        *   ),
        *
        *   @OA\Response(
        *    response=422,
        *    description="Validation Error Messages",
        *    @OA\JsonContent(
        *       @OA\Property(property="email.required", type="string", example="email field is required"),
        *       @OA\Property(property="email.string", type="string", example="email field should be string"),
        *       @OA\Property(property="password.required", type="string", example="password field is required"),
        *    )
        *  ),
        *   @OA\Response(
        *      response=200,
        *      description="Login Success",
        *      @OA\JsonContent(
        *       @OA\Property(property="success", type="bool", example="true"),
        *       @OA\Property(property="code", type="int", example="200"),
        *       @OA\Property(property="locale", type="string", example="en"),
        *       @OA\Property(property="data", type="array", example="[]", @OA\Items(type="array",@OA\Items())),
        *    )
        *   ),
        *)
    **/
    /**
        * Attempt login with the credentials.
        *
        * @method login
        *
        * @param LoginRequest Request
        *
        * @return \Illuminate\Http\JsonResponse
    */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            // Authenticate with given credentials
            $this->repository->attempt($request->all());

            // Get access token
            $user = auth()->user();
            $token = $this->repository->createAccessToken($user);

            $this->repository->validateUser($user,$request->get('type'));

            // Process record
            $response = $this->repository->process($user);
        } catch (UserNotFoundException $exception) {
            return $exception->render();
        }
        $data = ['token' => $token, 'user' => $response];
        return $this->response(__('messages.LOGIN_SUCCESS'), compact('data'));
    }

    /**
        * @OA\Post(
        * path="/auth/register",
        *   tags={"Authentication"},
        *   summary="- Register",
        *   operationId="register",
        *
        *   @OA\Parameter(
        *      name="name",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string",
        *      )
        *   ),
        *   @OA\Parameter(
        *      name="email",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *           type="string",
        *      )
        *   ),
        *   @OA\Parameter(
        *      name="password",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *          type="string"
        *      )
        *   ),
        *   @OA\Parameter(
        *      name="role",
        *      in="query",
        *      required=true,
        *      @OA\Schema(
        *          type="integer"
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
        *    response=422,
        *    description="Validation Error Messages",
        *    @OA\JsonContent(
        *       @OA\Property(property="email.required", type="string", example="email field is required"),
        *       @OA\Property(property="email.string", type="string", example="email field should be string"),
        *       @OA\Property(property="password.required", type="string", example="password field is required"),
        *    )
        *  ),
        *   @OA\Response(
        *      response=200,
        *      description="Registration Success",
        *      @OA\JsonContent(
        *       @OA\Property(property="success", type="bool", example="true"),
        *       @OA\Property(property="code", type="int", example="200"),
        *       @OA\Property(property="locale", type="string", example="en"),
        *       @OA\Property(property="data", type="array", example="[]", @OA\Items(type="array",@OA\Items())),
        *    )
        *   ),
        *)
    **/
    
    /**
        * Create new user
        *
        * @method register
        *
        * @param RegistrationRequest Request
        *
        * @return \Illuminate\Http\JsonResponse
    */
    public function register(RegistrationRequest $request): JsonResponse
    {   
        // Create new user
        $user = $this->repository->store($request->all());

        // Generate token
        $token = $this->repository->createAccessToken($user);

        $role = Role::where('id', $request['role'])->first();
        $roles = Role::findOrFail($role->id);

        //Get all Permission gor given role id
        $groupsWithRoles = $role->getPermissionNames();

        // Attach Permissions to user
        $user->givePermissionTo($groupsWithRoles);

        // Attach role to user
        $user->assignRole($request['role']);

        // Process record
        $response = $this->repository->process($user);
        
        // send Gmail
        // $password = $this->repository->createTemporaryPassword($user->email);
            
        // $data = ['user' => $user];
        // $this->mailProcess($user->email,'registration_approval_mail',$data);
        
        // Send SendGrid

        $data = ['user' => $user];
        SendMail::sendUserRegistrationMail($data);
        $data = ['token' => $token, 'user' => $response];
        return $this->response(__('messages.REGISTRATION_SUCCESS'), compact('data'));
    }

        /**
     * save user device tokens
     *
     * @method saveUserDeviceTokens
     *
     * @param  UserDeviceTokensRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function saveUserDeviceTokens(UserDeviceTokensRequest $request): JsonResponse
    {
        $deviceDetails = $request->all();
        $deviceDetails['user_id'] = $request->user()->id;

        // register device token
        $tokenExists = $this->repository->checkUserDeviceTokenExists((array) $deviceDetails);

        if ($tokenExists) {
            $this->repository->destroyDeviceTokensByUserId(auth()->user()->id);
        }

        $this->repository->storeDeviceDetails($deviceDetails);

        return $this->response(__('messages.USER_DEVICE_TOKEN_SAVED'));
    }
}
