<?php

namespace Tests\Unit\Services\Parsers;

use PHPUnit\Framework\TestCase;
use App\Services\Parsers\HtmlParser;

class HtmlParserTest extends TestCase
{
    public function test_Parse_Method_With_Valid_Content()
    {
        $parser = new HtmlParser();
        $content = file_get_contents(__DIR__ . '/../../../Feature/schedule.html');
        $result = $parser->parse($content);
        $this->assertEquals('Jan de Bosman', $result['name']);
        $this->assertIsArray($result['events']);
    }
}