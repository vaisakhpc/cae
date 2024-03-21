<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class FileUploadControllerTest extends TestCase
{
    /**
     * Test file upload with valid file.
     *
     * @return void
     */
    public function testFileUploadWithValidFile()
    {

        // Create a fake file
        $file = UploadedFile::fake()->create('schedule.html', file_get_contents(__DIR__ . '/schedule.html'));

        // Send a POST request with the file
        $response = $this->postJson('/api/upload', [
            'file' => $file,
        ]);
        // Assert response
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true)['data'];
        $this->assertNotEmpty($data);
    }


    /**
     * Test file upload with valid file and new customer.
     *
     * @return void
     */
    public function testFileUploadWithValidFileWithNewName()
    {
        // removing all existing users from the test database
        DB::connection()->getSchemaBuilder()->disableForeignKeyConstraints();
        DB::table('user')->truncate();
        // Create a fake file
        $file = UploadedFile::fake()->create('schedule.html', file_get_contents(__DIR__ . '/schedule-with-new-name.html'));

        // Send a POST request with the file
        $response = $this->postJson('/api/upload', [
            'file' => $file,
        ]);
        // Assert response
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true)['data'];
        $this->assertEquals(1, $data['user_id']);
    }

     /**
     * Test file upload with invalid file contents.
     *
     * @return void
     */
    public function testFileUploadWithValidFileAndInvalidContents()
    {

        // Create a fake file
        $file = UploadedFile::fake()->create('schedule.html', file_get_contents(__DIR__ . '/schedule-table-not-found.html'));

        // Send a POST request with the file
        $response = $this->postJson('/api/upload', [
            'file' => $file,
        ]);
        // Assert response
        $response->assertStatus(400);
    }

    /**
     * Test file upload with invalid file type.
     *
     * @return void
     */
    public function testFileUploadWithInvalidFile()
    {
        $file = UploadedFile::fake()->create('schedule.log');
        // Send a POST request without a file
        $response = $this->postJson('/api/upload',[
            'file' => $file,
        ]);

        // Assert response
        $response->assertStatus(400);
    }

    /**
     * Test file upload with no file.
     *
     * @return void
     */
    public function testFileUploadWithNoFile()
    {
        // Send a POST request without a file
        $response = $this->postJson('/api/upload');

        // Assert response
        $response->assertStatus(400);
    }
}
