<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class LoggerService implements LoggerInterface
{
    public function logRequest($request)
    {
        Log::info('Request logged: ' . $request->method() . ' ' . $request->fullUrl());
    }

    public function logResponse($response)
    {
        Log::info('Response logged: ' . $response->getStatusCode() . ' ' . $response->getContent());
    }
}
