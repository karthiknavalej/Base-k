<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
    * @OA\Info(
    *      version="1.0.0",
    *      title="Integration Swagger in Base Project with Passport Auth Documentation",
    *      description="Implementation of Swagger with in Laravel",
    *      @OA\Contact(
    *          email="admin@admin.com"
    *      ),
    *      @OA\License(
    *          name="Apache 2.0",
    *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
    *      )
    * )
    *
    * @OA\Server(
    *      url=L5_SWAGGER_CONST_HOST,
    *      description="Test API Server"
    * )
    */

    /**
    * Send Success Response
    *
    * @method response
    *
    * @param string $msg
    *
    * @param array $data
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function response(string $msg, array $data = []): JsonResponse
    {
        $output = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "locale" => app()->getLocale(),
            "message" => $msg,
        ];

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $output[$key] = $value;
            }
        }
        return response()->json($output, Response::HTTP_OK);
    }
}
