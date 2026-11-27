<?php

use App\Models\Activity;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;

beforeEach(function () {
    Storage::fake('local');
});

function mockCloudinaryUploadForActivity(string $suffix = '1'): void
{
    test()->mock(CloudinaryService::class, function (MockInterface $mock) use ($suffix) {
        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'activities/sample_'.$suffix,
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/v1/activities/sample_'.$suffix.'.jpg',
            ]);
        $mock->shouldReceive('destroy')->zeroOrMoreTimes()->andReturn(true);
    });
}

test('penulis can upload a valid supporting document when creating an activity', function () {
    $penulis = User::factory()->create(['role' => 'penulis']);
    mockCloudinaryUploadForActivity('doc_create');

    $image = UploadedFile::fake()->image('kegiatan.jpg', 1200, 800);
    $document = UploadedFile::fake()->create('proposal-ekspedisi.pdf', 512, 'application/pdf');

    $response = $this->actingAs($penulis)->post(route('penulis.activities.store'), [
        'title' => 'Ekspedisi Dengan Proposal PDF',
        'category' => 'Ekspedisi',
        'location' => 'Gunung Papandayan',
        'event_date' => '2026-11-20',
        'description' => 'Laporan kegiatan dengan lampiran proposal resmi.',
        'image' => $image,
        'document' => $document,
        'status' => 'draft',
        'order' => 1,
    ]);

    $response->assertRedirect(route('penulis.activities.index'));

    $activity = Activity::query()->where('title', 'Ekspedisi Dengan Proposal PDF')->firstOrFail();

    expect($activity->document_path)->not->toBeNull();
    expect($activity->document_original_name)->toBe('proposal-ekspedisi.pdf');
    expect($activity->document_mime_type)->toBe('application/pdf');
    Storage::disk('local')->assertExists((string) $activity->document_path);
});

test('document upload rejects invalid file types and files larger than 5MB', function () {
    $penulis = User::factory()->create(['role' => 'penulis']);
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldNotReceive('upload');
    });

    $image = UploadedFile::fake()->image('kegiatan.jpg');

    // Invalid executable/script file
    $invalidDoc = UploadedFile::fake()->create('malware.exe', 100, 'application/x-msdownload');
    $this->actingAs($penulis)
        ->from(route('penulis.activities.create'))
        ->post(route('penulis.activities.store'), [
            'title' => 'Kegiatan File Invalid',
            'category' => 'Ekspedisi',
            'description' => 'Deskripsi valid.',
            'image' => $image,
            'document' => $invalidDoc,
            'status' => 'draft',
        ])
        ->assertRedirect(route('penulis.activities.create'))
        ->assertSessionHasErrors(['document']);

    // Oversized PDF (> 5120 KB)
    $tooLargeDoc = UploadedFile::fake()->create('lpj-besar.pdf', 6000, 'application/pdf');
    $this->actingAs($penulis)
        ->from(route('penulis.activities.create'))
        ->post(route('penulis.activities.store'), [
            'title' => 'Kegiatan File Terlalu Besar',
            'category' => 'Ekspedisi',
            'description' => 'Deskripsi valid.',
            'image' => UploadedFile::fake()->image('kegiatan2.jpg'),
            'document' => $tooLargeDoc,
            'status' => 'draft',
        ])
        ->assertRedirect(route('penulis.activities.create'))
        ->assertSessionHasErrors(['document']);

    expect(Storage::disk('local')->allFiles('activity-documents'))->toBeEmpty();
});

test('replacing or removing an activity document deletes the old file so no orphan remains', function () {
    $penulis = User::factory()->create(['role' => 'penulis']);
    $oldPath = UploadedFile::fake()->create('dokumen-lama.pdf', 200, 'application/pdf')
        ->store('activity-documents', 'local');

    $activity = Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Update Dokumen',
        'status' => 'draft',
        'is_active' => false,
        'document_path' => $oldPath,
        'document_original_name' => 'dokumen-lama.pdf',
        'document_mime_type' => 'application/pdf',
        'document_size' => 204800,
    ]);

    Storage::disk('local')->assertExists($oldPath);

    // Replace document
    $newDoc = UploadedFile::fake()->create('dokumen-baru.docx', 300, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    $this->actingAs($penulis)
        ->put(route('penulis.activities.update', $activity), [
            'title' => 'Kegiatan Update Dokumen',
            'category' => $activity->category,
            'description' => $activity->description,
            'document' => $newDoc,
            'status' => 'draft',
            'order' => $activity->order,
        ])
        ->assertRedirect(route('penulis.activities.index'));

    $activity->refresh();
    expect($activity->document_original_name)->toBe('dokumen-baru.docx');
    expect($activity->document_path)->not->toBe($oldPath);
    Storage::disk('local')->assertMissing($oldPath);
    Storage::disk('local')->assertExists((string) $activity->document_path);

    $replacedPath = (string) $activity->document_path;

    // Explicitly remove document via remove_document checkbox
    $this->actingAs($penulis)
        ->put(route('penulis.activities.update', $activity), [
            'title' => 'Kegiatan Update Dokumen',
            'category' => $activity->category,
            'description' => $activity->description,
            'remove_document' => '1',
            'status' => 'draft',
            'order' => $activity->order,
        ])
        ->assertRedirect(route('penulis.activities.index'));

    $activity->refresh();
    expect($activity->document_path)->toBeNull();
    expect($activity->document_original_name)->toBeNull();
    Storage::disk('local')->assertMissing($replacedPath);
});

test('deleting an activity also deletes its attached document from storage', function () {
    $penulis = User::factory()->create(['role' => 'penulis']);
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('destroy')->once()->andReturn(true);
    });

    $docPath = UploadedFile::fake()->create('surat-tugas.pdf', 150, 'application/pdf')
        ->store('activity-documents', 'local');

    $activity = Activity::factory()->create([
        'user_id' => $penulis->id,
        'status' => 'draft',
        'is_active' => false,
        'document_path' => $docPath,
        'document_original_name' => 'surat-tugas.pdf',
    ]);

    $this->actingAs($penulis)
        ->delete(route('penulis.activities.destroy', $activity))
        ->assertRedirect(route('penulis.activities.index'));

    $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
    Storage::disk('local')->assertMissing($docPath);
});

test('document download enforces role, draft privacy, ownership authorization, and missing file 404', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $staff = User::factory()->create(['role' => 'staff']);
    $ownerPenulis = User::factory()->create(['role' => 'penulis']);
    $otherPenulis = User::factory()->create(['role' => 'penulis']);

    $draftPath = UploadedFile::fake()->create('draft-doc.pdf', 120, 'application/pdf')
        ->store('activity-documents', 'local');
    $reviewPath = UploadedFile::fake()->create('review-doc.pdf', 120, 'application/pdf')
        ->store('activity-documents', 'local');

    $draftActivity = Activity::factory()->create([
        'user_id' => $ownerPenulis->id,
        'status' => 'draft',
        'is_active' => false,
        'document_path' => $draftPath,
        'document_original_name' => 'draft-doc.pdf',
    ]);

    $reviewActivity = Activity::factory()->create([
        'user_id' => $ownerPenulis->id,
        'status' => 'review',
        'is_active' => false,
        'document_path' => $reviewPath,
        'document_original_name' => 'review-doc.pdf',
    ]);

    $missingFileActivity = Activity::factory()->create([
        'user_id' => $ownerPenulis->id,
        'status' => 'review',
        'is_active' => false,
        'document_path' => 'activity-documents/non-existent.pdf',
        'document_original_name' => 'non-existent.pdf',
    ]);

    // Guest cannot download
    $this->get(route('admin.activities.document', $reviewActivity))->assertRedirect(route('login'));

    // Owner penulis can download own draft & review docs
    $this->actingAs($ownerPenulis)
        ->get(route('penulis.activities.document', $draftActivity))
        ->assertOk()
        ->assertDownload('draft-doc.pdf');

    // Other penulis is forbidden
    $this->actingAs($otherPenulis)
        ->get(route('penulis.activities.document', $draftActivity))
        ->assertForbidden();
    $this->actingAs($otherPenulis)
        ->get(route('penulis.activities.document', $reviewActivity))
        ->assertForbidden();

    // Admin and Staff cannot download draft documents, but can download review/published/archived documents
    $this->actingAs($admin)->get(route('admin.activities.document', $draftActivity))->assertForbidden();
    $this->actingAs($staff)->get(route('staff.activities.document', $draftActivity))->assertForbidden();

    $this->actingAs($admin)
        ->get(route('admin.activities.document', $reviewActivity))
        ->assertOk()
        ->assertDownload('review-doc.pdf');
    $this->actingAs($staff)
        ->get(route('staff.activities.document', $reviewActivity))
        ->assertOk()
        ->assertDownload('review-doc.pdf');

    // Missing physical file or unattached document returns 404
    $this->actingAs($admin)
        ->get(route('admin.activities.document', $missingFileActivity))
        ->assertNotFound();
});
