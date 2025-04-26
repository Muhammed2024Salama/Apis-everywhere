<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $status string
     * @param $message string
     * @param $data array
     * @param $statusCode integer
     * @return JsonResponse
     */
    public static function success($message = null, $status = 'success', $data = [], $statusCode = 200): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ],
            $statusCode
        );
    }

    /**
     * @param $status
     * @param $message
     * @param $data
     * @param $statusCode
     * @return JsonResponse
     */
    public static function sendResponse($status = 'success', $message, $data = [], $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * @param $status string
     * @param $message string
     * @param $statusCode integer
     * @return JsonResponse
     * Function : Common function to display error - Json Response
     */
    public static function error($status = 'error', $message = null, $statusCode = 400): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => $status,
                'message' => $message,
            ],
            $statusCode
        );
    }
}
