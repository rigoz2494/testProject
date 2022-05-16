<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successResponse(mixed $data = [], string $message = '', int $code = 200): JsonResponse
    {
        $response = [
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, $code);
    }

    public function errorResponse(array $errors = [], string|array $message = null, int $code = 404): JsonResponse
    {
        $response = [
            'errors' => $errors,
            'message' => $message
        ];

        return response()->json($response, $code);
    }
}
