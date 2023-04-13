<?php

namespace App\Helpers;

trait APIResponseHelper
{
    public function sendFailedResponse(array $error)
    {
        return response()->json($error, self::HTTP_CODE_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return JsonResponse with data
     */
    public function sendSuccessResponseData($data)
    {
        return response()->json([
            'data' => $data
        ], self::HTTP_CODE_OK);
    }

    /**
     * @return JsonResponse
     */
    public function sendSuccessResponse()
    {
        return response(['message' => 'Success'], self::HTTP_CODE_OK);
    }
}