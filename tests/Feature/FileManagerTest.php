<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileManagerTest extends TestCase
{
    public function test_files_can_be_uploaded_listed_served_and_deleted(): void
    {
        Storage::fake('public');

        // Upload
        $upload = $this->postJson('/api/files', [
            'files' => [UploadedFile::fake()->image('Photo One.png')],
        ]);

        $upload->assertCreated();
        $upload->assertJsonStructure(['files' => [['name', 'path', 'url', 'type', 'size']]]);

        $path = $upload->json('files.0.path');
        $this->assertStringStartsWith('uploads/', $path);
        Storage::disk('public')->assertExists($path);

        // List (public)
        $list = $this->getJson('/api/files');
        $list->assertOk();
        $list->assertJsonPath('files.0.path', $path);

        // Serve inline
        $this->get('/media/'.$path)
            ->assertOk()
            ->assertHeader('Content-Disposition', 'inline; filename="'.basename($path).'"');

        // Serve as download
        $this->get('/media/'.$path.'?download')
            ->assertOk()
            ->assertHeader('Content-Disposition', 'attachment; filename="'.basename($path).'"');

        // Replace contents in place — path/URL stays the same.
        $update = $this->post('/api/files/'.$path, [
            'file' => UploadedFile::fake()->image('replacement.png', 64, 64),
        ]);
        $update->assertOk();
        $update->assertJsonPath('file.path', $path);
        Storage::disk('public')->assertExists($path);

        // Delete
        $this->deleteJson('/api/files/'.$path)->assertOk();
        Storage::disk('public')->assertMissing($path);
    }

    public function test_updating_a_missing_file_returns_404(): void
    {
        Storage::fake('public');

        $this->post('/api/files/uploads/nope.png', [
            'file' => UploadedFile::fake()->image('x.png'),
        ])->assertNotFound();
    }

    public function test_path_traversal_is_rejected(): void
    {
        Storage::fake('public');

        $this->get('/media/uploads/../../secret.txt')->assertNotFound();
        $this->getJson('/api/files')->assertOk();
    }

    public function test_upload_requires_files(): void
    {
        Storage::fake('public');

        $this->postJson('/api/files', [])->assertStatus(422);
    }
}
