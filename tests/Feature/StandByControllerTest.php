<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class StandByControllerTest extends TestCase
{

    private function uploadFile()
    {
        // Create a fake file
        $file = UploadedFile::fake()->create('schedule.html', file_get_contents(__DIR__ . '/schedule_with_standby.html'));

        // Send a POST request with the file
        $response = $this->postJson('/api/upload', [
            'file' => $file,
        ]);
        return json_decode($response->getContent(), true)['data'];
    }

    public function testGetAllStandByEventsForNextWeek()
    {
        $fileUpload = $this->uploadFile();
        $userId = $fileUpload['user_id'] ?? '';
        // Send a POST request with the file
        $response = $this->getJson("/api/standbys/{$userId}");
        $response->assertStatus(200);
    }

    public function testGetAllStandByEventsForNextWeekReturn404()
    {
        $response = $this->getJson("/api/standbys/0");
        $response->assertStatus(404);
    }
}
