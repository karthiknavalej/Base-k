<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException as AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Database\QueryException;
use Log;
use Bugsnag;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $exception) {
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Illuminate\Http\Request  $request
     *
     * @param  Throwable  $exception
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof QueryException) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_BAD_GATEWAY,
                'locale' => app()->getLocale(),
                'message' => __('messages.HTTP_BAD_GATEWAY'),
            ], Response::HTTP_BAD_GATEWAY);
        }

        if ($exception instanceof RelationNotFoundException) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'locale' => app()->getLocale(),
                'message' => __('messages.RELATIONSHIP_NOT_FOUND'),
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'locale' => app()->getLocale(),
                'message' => __('messages.HTTP_FORBIDDEN'),
            ], Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                    'success' => false,
                    'code' => Response::HTTP_NOT_FOUND,
                    'locale' => app()->getLocale(),
                    'message' => __('messages.HTTP_NOT_FOUND'),
                ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof RouteNotFoundException) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'locale' => app()->getLocale(),
                'message' => __('messages.HTTP_NOT_FOUND'),
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof \BadMethodCallException) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'locale' => app()->getLocale(),
                'message' => __('messages.HTTP_NOT_FOUND'),
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_UNAUTHORIZED,
                'locale' => app()->getLocale(),
                'message' => __('messages.HTTP_UNAUTHORIZED'),
            ], Response::HTTP_UNAUTHORIZED);
        }

        if($exception instanceof AuthenticationException) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_UNAUTHORIZED,
                'locale' => app()->getLocale(),
                'message' => __('messages.HTTP_UNAUTHENTICATED'),
            ], Response::HTTP_UNAUTHORIZED);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'locale' => app()->getLocale(),
                'message' => __('messages.HTTP_NOT_FOUND'),
            ], Response::HTTP_NOT_FOUND);
        }
        
        Log::error('exception', ['message' => $exception->getMessage()]);
        Bugsnag::notifyException($exception);

        return response()->json([
                'success' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'locale' => app()->getLocale(),
                'message' => __('messages.HTTP_INTERNAL_SERVER_ERROR'),
                'error' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        
        //return parent::render($request, $exception);
    }
}
