<?php

namespace App\Services;

use App\Models\User;
use App\Models\Events;
use App\Services\PersisterServiceInterface;
use App\Services\Helpers\Common;

class PersisterService implements PersisterServiceInterface
{
    private $userId;
    private const MAPPING_EVENT = [
        // 'Date' => 'date',
        // 'C/I(Z)' => 'checkin',
        // 'C/O(Z)' => 'checkout',
        'Activity' => 'activity',
        'Remark' => 'remark',
        'From' => 'from',
        'STD(Z)' => 'std',
        'To' => 'to',
        'STA(Z)' => 'sta',
        'AC/Hotel' => 'hotel',
        'BLH' => 'blh',
        'Flight Time' => 'flight_time',
        'Dur' => 'duration',
    ];

    private $count = 0;

    public function __construct(private Common $helper)
    {
    }

    public function saveEntries(array $entries): array
    {
        extract($entries);
        $user = new User;
        $userData = $user->where('name', $name)->first();
        if (!$userData) {
            $user->name = $name;
            $user->save();
            $this->userId = $user->id;
        } else {
            $this->userId = $userData->id;
        }

        $this->deleteExistingRecords(array_column($events, 'Date'));
        foreach (($events ?? []) as $entry) {
            // $recordToDataBase 
            $this->prepareEvent($entry);
        }
        return [
            'user_id' => $this->userId,
            'count_of_events' => $this->count
        ];
    }

    private function deleteExistingRecords($dates)
    {
        foreach ($dates as $date) {
            $eventDate = date('Y-m-d', strtotime($this->helper->getAssumedDate($date)));
            Events::where(['date' => $eventDate, 'user_id' => $this->userId])->delete();
        }
    }

    private function prepareEvent($entry)
    {
        foreach ($entry['data'] as $eventData) {
            $event = new Events();
            $eventDate = date('Y-m-d', strtotime($this->helper->getAssumedDate($eventData['Date'])));
            $event->code = $this->deriveCode($eventData['Activity']);
            $event->user_id = $this->userId;
            $event->date = $eventDate;

            // Check if C/I(Z) is not empty
            if (!empty($eventData['C/I(Z)'])) {
                $this->includeCheckDates($eventData, $eventDate, 'CI');
            }

            // Fill model attributes using the mapping
            foreach (static::MAPPING_EVENT as $arrayKey => $modelAttribute) {
                if (isset($eventData[$arrayKey])) {
                    $event->$modelAttribute = $eventData[$arrayKey];
                }
            }

            $event->save();
            $this->count++;
    
            // Check if C/O(Z) is not empty
            if (!empty($eventData['C/O(Z)'])) {
                $this->includeCheckDates($eventData, $eventDate, 'CO');
            }
        }
    }

    private function includeCheckDates(array $eventData, $eventDate, string $type)
    {
        $ciEvent = new Events();
        $ciEvent->date = $eventDate; // Assign the date
        $ciEvent->code = $type;
        $ciEvent->user_id = $this->userId;
        if ($type == 'CI') {
            $ciEvent->checkin = $eventData['C/I(Z)'];
        } else {
            $ciEvent->checkout = $eventData['C/O(Z)'];
        }
        $ciEvent->save();
        $this->count++;
    }

    private function deriveCode($activity)
    {
        if ($activity == 'OFF') {
            return 'DO';
        } elseif (in_array($activity, ['SBY'])) {
            return $activity;
        } elseif (preg_match('/^[A-Za-z]{2}\d+$/', $activity)) {
            return 'FLT';
        } else {
            return 'UNK';
        }
    }
}
