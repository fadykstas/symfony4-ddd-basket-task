<?php

namespace App\Project\Http\Controller\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait JsonResponseTrait
{
    protected function successResponse(array $data, int $statusCode = JsonResponse::HTTP_OK): JsonResponse
    {
        return new JsonResponse(['data' => $data], $statusCode);
    }

    protected function successResponseWithMeta(array $data, array $meta = [], int $statusCode = JsonResponse::HTTP_OK) : JsonResponse
    {
        return new JsonResponse(
            [
                'data' => $data,
                'meta' => $meta
            ],
            $statusCode
        );
    }

    protected function errorResponse(string $data, int $statusCode = JsonResponse::HTTP_BAD_REQUEST): JsonResponse
    {
        if($statusCode === 0) {
            $statusCode = JsonResponse::HTTP_BAD_REQUEST;
        }

        $errorData = [
            'error' => [
                'httpStatus' => $statusCode,
                'message' => $data
            ]
        ];
        return new JsonResponse($errorData, $statusCode);
    }

    protected function emptyResponse(int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(null, $statusCode);
    }
}
