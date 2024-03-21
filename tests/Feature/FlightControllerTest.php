<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class FlightControllerTest extends TestCase
{
    private function uploadFile()
    {
        // Create a fake file
        $file = UploadedFile::fake()->create('schedule.html', file_get_contents(__DIR__ . '/schedule.html'));

        // Send a POST request with the file
        $response = $this->postJson('/api/upload', [
            'file' => $file,
        ]);
        return json_decode($response->getContent(), true)['data'];
    }

    public function testGetAllFlightsForNextWeek()
    {
        $fileUpload = $this->uploadFile();
        $userId = $fileUpload['user_id'] ?? '';
        // Send a POST request with the file
        $response = $this->getJson("/api/flights-next-week/{$userId}");
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true)['data'];
        $this->assertNotEmpty($data);
    }

    public function testGetAllEventsBetweenDatePeriodsReturn404()
    {
        $response = $this->getJson("/api/flights-next-week/0/");
        $response->assertStatus(404);
    }

    public function testGetAllFlightsFromLocation()
    {
        $fileUpload = $this->uploadFile();
        $userId = $fileUpload['user_id'] ?? '';
        // Send a POST request with the file
        $response = $this->getJson("/api/flights-from/{$userId}/KRP");
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true)['data'];
        $this->assertNotEmpty($data);
    }

    public function testGetAllFlightsFromLocationReturn404()
    {
        $response = $this->getJson("/api/flights-from/0/KRP");
        $response->assertStatus(404);
    }
}
