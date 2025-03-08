<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait JsonResponseTrait
{
    public function successResponse($message, $data = ""): JsonResponse
    {
        $response = [
            'message'   => $message,
            'data'      => $data,
        ];
        return response()->json($response, 200);
    }

    public function errorResponse($message, $statusCode): JsonResponse
    {
        $response = [
            'message'       => $message,
            'statusCode'    => $statusCode,
        ];
        return response()->json($response, $statusCode);
    }
    public function errorResponseWithData($message, $statusCode, $data = ""): JsonResponse
    {
        $response = [
            'message'       => $message,
            'statusCode'    => $statusCode,
            'data'          => $data
        ];
        return response()->json($response, $statusCode);
    }

    public function createResponse($message, $data = ""): JsonResponse
    {
        $response = [
            'message'       => $message,
            'data'          => $data,
            'statusCode'    => 201
        ];

        return response()->json($response, 201);
    }
}
