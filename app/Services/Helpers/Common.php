<?php

namespace App\Services\Helpers;

class Common
{
    const ASSUMED_YEAR = 2022;
    const ASSUMED_MONTH = 1;

    public function getAssumedDate(string $day): string
    {
        $day = preg_replace('/[^\d]/', '', $day);

        // Create the date string in the format 'YYYY-MM-DD'
        $dateString = sprintf('%04d-%02d-%02d', static::ASSUMED_YEAR, static::ASSUMED_MONTH, $day);

        return $dateString;
    }
}