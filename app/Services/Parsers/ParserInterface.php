<?

namespace App\Services\Parsers;

interface ParserInterface
{
    public function parse(string $contents): array;
}