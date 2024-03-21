<?php

namespace App\Services;

use App\Services\ParserServiceInterface;
use App\Services\Parsers\ParserInterface;
use App\Services\Parsers\HtmlParser;

class ParserService implements ParserServiceInterface
{
    public function __construct() {}

    public function getHtmlParser(): ParserInterface
    {
        return new HtmlParser();
    }

    public function parseDocument(string $content, string $ext): array
    {
        $result = [];
        switch ($ext) {
            case 'html':
                $result = $this->getHtmlParser()->parse($content);
                break;
            default:
                $result = ['message' => sprintf('Parser for %s yet to be developed', $ext), 'error' => true];
        }
        return $result;
    }
}