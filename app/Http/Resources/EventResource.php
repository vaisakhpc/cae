<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class EventResource extends JsonResource
{

    const FIELDS_TO_OMIT = ['id', 'user_id', 'updated_at'];

    public function toArray($request)
    {
        $data = $this->resource->toArray();
        foreach (self::FIELDS_TO_OMIT as $key) {
            unset($data[$key]);
        } 
        $date = new DateTime($data['date']);
        $data['date'] = $date->format('D d');
        $createdDate = new DateTime($data['created_at']);
        $data['created_at'] =  $createdDate->format('Y-m-d');
        return $data;
    }
}