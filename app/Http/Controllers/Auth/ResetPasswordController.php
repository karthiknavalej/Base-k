<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\Auth\ResetPasswordRequest;

// Repositories
use App\Repositories\Auth\AuthRepositoryInterface;

// Response
use Illuminate\Http\JsonResponse;

// Exception
use App\Exceptions\Auth\InvalidTokenException;
use App\Exceptions\Auth\TokenExpiredException;

class ResetPasswordController extends Controller
{
    /**
      * @var $authRepository
    */
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
        * @OA\Post(
        * path="/auth/reset",
        *   tags={"Authentication"},
        *   summary="- Reset password",
        *   operationId="Reset",
        *
        *   @OA\Parameter(
        *     name="new_password",
        *     in="query",
        *     required=true,
        *     @OA\Schema(type="string")
        *   ),
        *
        *   @OA\Parameter(
        *     name="confirm_password",
        *     in="query",
        *     required=true,
        *     @OA\Schema(type="string")
        *   ),
        *
        *   @OA\Parameter(
        *     name="token",
        *     in="query",
        *     required=true,
        *     @OA\Schema(type="string")
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
        *       @OA\Property(property="new_password.required", type="string", example="new_password field is required"),
        *       @OA\Property(property="new_password.string", type="string", example="new_password field should be string"),
        *       @OA\Property(property="confirm_password.required", type="string", example="confirm_password field is required"),
        *       @OA\Property(property="confirm_password.string", type="string", example="confirm_password field should be string"),
        *       @OA\Property(property="token.required", type="string", example="token field is required"),
        *       @OA\Property(property="token.string", type="string", example="token field should be string"),
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
        * Reset new password
        *
        * @method reset
        *
        * @param ResetPasswordRequest Request
        *
        * @return \Illuminate\Http\JsonResponse
    */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        try {
            // Find based on token
            $user = $this->authRepository->findByToken($request->token);

            // Validate token expiration
            $this->authRepository->isPasswordTokenExpired($user);

            // Update password
            $this->authRepository->updatePassword($user, $request->all());

            // Create auth token
            $token = $this->authRepository->createPasswordToken($user);
            
            // Process record
            $response = $this->authRepository->process($user);
        } catch (TokenExpiredException $exception) {
            return $exception->render();
        } catch (InvalidTokenException $exception) {
            return $exception->render();
        }

        $data = ['token' => $token, 'user' => $response];
        return $this->response(__('messages.RESET_SUCCESS'), compact('data'));
    }
}
