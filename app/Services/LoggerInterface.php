<?php

// LoggerInterface.php

namespace App\Services;

interface LoggerInterface
{
    public function logRequest($request);
    public function logResponse($response);
}
