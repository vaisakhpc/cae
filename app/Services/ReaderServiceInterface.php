<?php

namespace App\Services;

use App\Http\Resources\EventCollection;

interface ReaderServiceInterface
{
    public function getEventsBetweenDates(int $userId, string $from, string $to): EventCollection;

    public function getFlightsForNextWeek(int $userId): EventCollection;

    public function getStandBysForNextWeek(int $userId): EventCollection;

    public function getFlightsFromLocation(int $userId, string $location): EventCollection;
}