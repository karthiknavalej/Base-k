<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Auth\ForgotPasswordRequest;

// Repositories
use App\Repositories\Auth\AuthRepositoryInterface;

// Response
use Illuminate\Http\JsonResponse;

// Exception
use App\Exceptions\Auth\InvalidEmailException;

// Others
use SendMail;
use App\Http\Traits\UseMailTrait;

class ForgotPasswordController extends Controller
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
        * path="/auth/forgot",
        *   tags={"Authentication"},
        *   summary="- Forgot password",
        *   operationId="Forgot",
        *
        *   @OA\Parameter(
        *      name="email",
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
        * @OA\Response(
        *    response=401,
        *    description="Unauthorized",
        *    @OA\JsonContent(
        *       @OA\Property(property="success", type="boolean", example="false"),
        *	     @OA\Property(property="code", type="integer", example=401),
        *       @OA\Property(property="locale", type="string", example="en"),
        *       @OA\Property(property="message", type="string",
        *          example="Unauthorized")
        *        )
        *     ),
        *   @OA\Response(
        *    response=422,
        *    description="Validation Error Messages",
        *    @OA\JsonContent(
        *       @OA\Property(property="email.required", type="string", example="email field is required"),
        *       @OA\Property(property="email.string", type="string", example="email field should be string"),
        *       @OA\Property(property="password.required", type="string", example="password field is required"),
        *    )
        *  ),
        * @OA\Response(
        *    response=404,
        *    description="Resource not found",
        *    @OA\JsonContent(
        *       @OA\Property(property="success", type="boolean", example="false"),
        *	     @OA\Property(property="code", type="integer", example=404),
        *       @OA\Property(property="locale", type="string", example="en"),
        *       @OA\Property(property="message", type="string",
        *          example="Resource not found")
        *        )
        *     ),
        * @OA\Response(
        *    response=500,
        *    description="Something went wrong",
        *    @OA\JsonContent(
        *       @OA\Property(property="success", type="boolean", example="false"),
        *	     @OA\Property(property="code", type="integer", example=500),
        *       @OA\Property(property="locale", type="string", example="en"),
        *       @OA\Property(property="message", type="string",
        *          example="Something went wrong")
        *        )
        *     ),
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
        * Create token for password reset
        *
        * @method forgot
        *
        * @param ForgotPasswordRequest Request
        *
        * @return \Illuminate\Http\JsonResponse
    */
    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            // Check user exist
            $user = $this->repository->findByEmail($request->email);
            
            // Create password token
            $token = $this->repository->createPasswordToken($user);
            
            // Send Gmail
            // $password = $this->repository->createTemporaryPassword($user->email);
            
            // $data = ['user' => $user];
            
            // $this->mailProcess($user->email,'forgot_password_mail',$data);

            //Send Grid
            $data = ['user' => $user];

            SendMail::forgotPassword($user);

        } catch (InvalidEmailException $exception) {
            return $exception->render();
        }
        $data = ['token' => $token];
        return $this->response(__('messages.FORGOT_SUCCESS'), compact('data'));
    }
}
