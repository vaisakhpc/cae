<?php

namespace App\Services;

interface ParserServiceInterface
{
    public function parseDocument(string $content, string $ext): array;
}