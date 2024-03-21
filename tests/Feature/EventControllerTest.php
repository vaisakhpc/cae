<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class EventControllerTest extends TestCase
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

    public function testGetAllEventsBetweenDatePeriods()
    {
        $fileUpload = $this->uploadFile();
        $userId = $fileUpload['user_id'] ?? '';
        // Send a POST request with the file
        $response = $this->getJson("/api/events/{$userId}/?from='Mon 15'&to='Tue 16'");
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true)['data'];
        $this->assertNotEmpty($data);
    }

    public function testGetAllEventsBetweenDatePeriodsReturn404()
    {
        $response = $this->getJson("/api/events/0/?from='Mon 15'&to='Tue 16'");
        $response->assertStatus(404);
    }
}
