<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\LoggerInterface;

class ApiLoggerMiddleware
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Request $request, Closure $next)
    {
        // Log request
        $this->logger->logRequest($request);

        // Proceed with the request
        $response = $next($request);

        // Log response
        $this->logger->logResponse($response);

        return $response;
    }
}
