<?php

namespace App\Services;

use App\Models\User;
use App\Models\Events;
use App\Services\ReaderServiceInterface;
use App\Services\Helpers\Common;
use App\Http\Resources\EventCollection;

class ReaderService implements ReaderServiceInterface
{

    const CURRENT_DATE = '14-01-2022';

    public function __construct(private Common $helper)
    {
    }

    public function getEventsBetweenDates(int $userId, string $from, string $to): EventCollection
    {
        $from = date('Y-m-d', strtotime($this->helper->getAssumedDate($from)));
        $to = date('Y-m-d', strtotime($this->helper->getAssumedDate($to)));
        $events = Events::where('user_id', $userId)->whereBetween('date', [$from, $to])->get();
        // Transform collection of events
        $eventCollection = new EventCollection($events);
        return $eventCollection;
    }

    public function getFlightsForNextWeek(int $userId): EventCollection
    {
        list ($from, $to) = $this->getNextWeekDates();
        $events = Events::where('user_id', $userId)->where('code', 'FLT')->whereBetween('date', [$from, $to])->get();
        $eventCollection = new EventCollection($events);
        return $eventCollection;
    }

    public function getStandBysForNextWeek(int $userId): EventCollection
    {
        list ($from, $to) = $this->getNextWeekDates();
        $events = Events::where('user_id', $userId)->where('code', 'SBY')->whereBetween('date', [$from, $to])->get();
        $eventCollection = new EventCollection($events);
        return $eventCollection;
    }

    public function getFlightsFromLocation(int $userId, string $location): EventCollection
    {
        $events = Events::where('user_id', $userId)->where('code', 'FLT')->where('from', $location)->get();
        $eventCollection = new EventCollection($events);
        return $eventCollection;
    }

    private function getNextWeekDates(): array
    {
        $from = date('Y-m-d', strtotime('next monday', strtotime(static::CURRENT_DATE)));
        $to = date('Y-m-d', strtotime('next monday', strtotime($from)));
        return [$from, $to];
    }
}