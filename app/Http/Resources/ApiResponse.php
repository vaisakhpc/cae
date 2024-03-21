<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
{
    public static function success($data, $message = null, $code = 200)
    {
        return [
            'status' => 'success',
            'code' => $code,
            'data' => $data,
            'message' => $message,
        ];
    }

    public static function error($message, $code = 500)
    {
        return [
            'status' => 'error',
            'code' => $code,
            'data' => null,
            'message' => $message,
        ];
    }
}
