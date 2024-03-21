<?php

namespace App\Services\Parsers;

use simplehtmldom\HtmlDocument;

use function Laravel\Prompts\text;

class HtmlParser implements ParserInterface
{
    protected const ALLOWED_HEADERS = ['Date', 'C/I(Z)', 'C/O(Z)', 'Activity', 'Remark', 'From', 'To', 'STD(Z)', 'STA(Z)', 'AC/Hotel', 'BLH', 'Flight Time', 'Night Time', 'Dur', 'ACReg'];

    private $parser;

    public function __construct()
    {
        $this->parser = new HtmlDocument('');
    }

    public function parse(string $content): array
    {
        // Parse the HTML content
        $dom = $this->parser->load($content);
        $name = $dom->find('.printOnly b')[0];
        $name = explode(')</b>', explode(' - ', $name)[1] ?? '')[0] ?? '';
        // Find the table element by its class
        $table = $dom->find('table.activityTableStyle', 0);

        // Check if the table was found
        if ($table) {
            // Initialize an array to store the table data
            $tableData = [];

            // Iterate over each row of the table
            foreach ($table->find('tr') as $row) {
                // Initialize an array to store the row data
                $rowData = [];

                // Iterate over each cell of the row
                foreach ($row->find('td') as $cell) {
                    // Add the cell content to the row data array
                    $rowData[] = $cell->plaintext;
                }

                // Add the row data to the table data array
                $tableData[] = $rowData;
            }
            
            $headers = $tableData[0];

            // Initialize an array to store the final result
            $processedTableData = [];
            $currentDateGroupIndex = null;
            
            // Iterate over each row of the table data (starting from index 1 to skip headers)
            for ($i = 1; $i < count($tableData); $i++) {
                // Initialize an associative array to store the row data
                $rowData = [];
            
                // Iterate over each cell of the row
                foreach ($tableData[$i] as $index => $cellData) {
                    // Use the corresponding header as the key and cell data as the value
                    $header = $headers[$index];
                    if (in_array($header, static::ALLOWED_HEADERS)) {
                        $rowData[$header] = $cellData;
                    }
                }
            
                // Check if the current row has a valid non-empty "Date" field
                if (!empty($rowData['Date'])) {
                    // If yes, create a new date group with the current row as its first element
                    $processedTableData[] = [
                        "Date" => $rowData['Date'],
                        "data" => [$rowData] // Initialize the "data" array with the current row
                    ];
                    $currentDateGroupIndex = count($processedTableData) - 1; // Update the index of the current date group
                } else {
                    // If the current row has an empty "Date" field,
                    // and there is a previous non-empty "Date" row
                    if ($currentDateGroupIndex !== null) {
                        // Add the current row to the "data" array of the previous date group
                        $rowData['Date'] = $processedTableData[$currentDateGroupIndex]['Date'];
                        $processedTableData[$currentDateGroupIndex]['data'][] = $rowData;
                    }
                }
            }
            // Return the table data
            return [
                'name' => $name,
                'events' => $processedTableData,
            ];
        } else {
            return ['message' => 'Table not found.', 'error' => true];
        }
    }
}