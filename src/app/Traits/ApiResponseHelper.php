<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

use function response;

trait ApiResponseHelper
{
    public function okResponse(
        mixed $data = null,
        ?string $message = null,
        array $headers = []
    ): JsonResponse {
        return $this->apiResponse(
            ['message' => $message ?? 'Operation succeeded.', 'data' => $this->morphToArray($data)],
            Response::HTTP_OK,
            $headers
        );
    }

    public function failedResponse(
        ?string $message = null,
        array $headers = []
    ): JsonResponse {
        return $this->apiResponse(
            ['message' => $message ?? 'Operation failed.'],
            Response::HTTP_BAD_REQUEST,
            $headers
        );
    }

    public function unprocessableResponse(
        array|Arrayable|string|Throwable|null $errors = null,
        ?string $message = null,
        array $headers = []
    ): JsonResponse {
        return $this->apiResponse(
            ['message' => $message ?? 'Validation failed.', 'errors' => $this->morphValidationErrors($errors)],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $headers
        );
    }


    public function notFoundResponse(
        ?string $message = null,
        array $headers = []
    ): JsonResponse {
        return $this->apiResponse(
            ['message' => $message ?? 'Not Found.'],
            Response::HTTP_NOT_FOUND,
            $headers
        );
    }

    public function unauthorizedResponse(
        ?string $message = null,
        array $headers = []
    ): JsonResponse {
        return $this->apiResponse(
            ['message' => $message ?? 'Unauthorized.'],
            Response::HTTP_UNAUTHORIZED,
            $headers
        );
    }

    public function forbiddenResponse(
        ?string $message = null,
        array $headers = []
    ): JsonResponse {
        return $this->apiResponse(
            ['message' => $message ?? 'Forbidden.'],
            Response::HTTP_FORBIDDEN,
            $headers
        );
    }

    public function serverErrorResponse(
        ?string $message = null,
        array $headers = []
    ): JsonResponse {
        return $this->apiResponse(
            ['message' => $message ?? 'Internal Server Error.'],
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $headers
        );
    }


    private function apiResponse(array $data, int $code = Response::HTTP_OK, $headers = []): JsonResponse
    {
        return response()->json($data, $code, $headers);
    }

    private function morphToArray(array|Arrayable|JsonSerializable|null|string $data): array
    {
        if ($data instanceof Arrayable) {
            return $data->toArray();
        }

        if ($data instanceof JsonSerializable) {
            return $data->jsonSerialize();
        }

        if (is_string($data)) {
            return [$data];
        }

        return $data ?? [];
    }

    private function morphValidationErrors(array|Arrayable|string|Throwable|null $errors): array
    {
        if (is_array($errors)) {
            return $errors;
        }
        if ($errors instanceof Throwable) {
            return [$errors->getMessage()];
        }
        if (is_string($errors)) {
            return [$errors];
        }
        if ($errors instanceof Arrayable) {
            return $errors->toArray();
        }

        return [];
    }
}
