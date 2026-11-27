<?php

use App\Models\Activity;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'admin',
    ]);
});

test('guests are redirected to login when accessing activities management', function () {
    $response = $this->get(route('admin.activities.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated verified users can view the activities list', function () {
    Activity::create([
        'title' => 'Ekspedisi Gunung Ciremai 2026',
        'slug' => 'ekspedisi-gunung-ciremai-2026',
        'category' => 'Ekspedisi',
        'location' => 'Kuningan, Jawa Barat',
        'event_date' => '2026-11-10',
        'description' => 'Pendakian dan pemetaan jalur selatan.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
        'image_public_id' => 'activities/sample1',
        'status' => 'review',
        'is_active' => false,
        'order' => 1,
    ]);

    $response = $this->actingAs($this->user)->get(route('admin.activities.index'));

    $response->assertOk();
    $response->assertSee('Manajemen Kegiatan');
    $response->assertSee('Ekspedisi Gunung Ciremai 2026');
    $response->assertSee('Ekspedisi');
});

test('penulis can view create activity page and admin cannot', function () {
    $penulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);

    $response = $this->actingAs($penulis)->get(route('penulis.activities.create'));

    $response->assertOk();
    $response->assertSee('Tambah Kegiatan Baru');
    $response->assertSee('Judul Kegiatan');
    expect(Route::has('admin.activities.create'))->toBeFalse();
    expect(Route::has('staff.activities.create'))->toBeFalse();
});

test('penulis can store a new activity with image upload to cloudinary', function () {
    $penulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'activities/unique_id_123',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/v1/activities/unique_id_123.jpg',
            ]);
    });

    $file = UploadedFile::fake()->image('kegiatan.jpg', 1200, 800);

    $response = $this->actingAs($penulis)->post(route('penulis.activities.store'), [
        'title' => 'Operasi SAR Banjir Bandang',
        'category' => 'SAR & Kemanusiaan',
        'location' => 'Garut, Jawa Barat',
        'event_date' => '2026-11-12',
        'description' => 'Bantuan evakuasi dan logistik warga terdampak.',
        'image' => $file,
        'status' => 'draft',
        'order' => 2,
    ]);

    $response->assertRedirect(route('penulis.activities.index'));
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('activities', [
        'user_id' => $penulis->id,
        'title' => 'Operasi SAR Banjir Bandang',
        'category' => 'SAR & Kemanusiaan',
        'location' => 'Garut, Jawa Barat',
        'image_public_id' => 'activities/unique_id_123',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/v1/activities/unique_id_123.jpg',
        'status' => 'draft',
        'is_active' => 0,
        'order' => 2,
    ]);
});

test('validation prevents storing activity without required fields', function () {
    $penulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);

    $response = $this->actingAs($penulis)->post(route('penulis.activities.store'), [
        'title' => '',
        'category' => '',
        'description' => '',
        'image' => null,
    ]);

    $response->assertSessionHasErrors(['title', 'category', 'description', 'image']);
});

test('penulis can view edit activity page for own activity', function () {
    $penulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);

    $activity = Activity::create([
        'user_id' => $penulis->id,
        'title' => 'Diklat Ruang Angkatan VII',
        'slug' => 'diklat-ruang-angkatan-vii',
        'category' => 'Diklat',
        'description' => 'Pembekalan materi navigasi darat.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
        'image_public_id' => 'activities/diklat1',
        'status' => 'draft',
        'is_active' => false,
        'order' => 0,
    ]);

    $response = $this->actingAs($penulis)->get(route('penulis.activities.edit', $activity));

    $response->assertOk();
    $response->assertSee('Edit Kegiatan');
    $response->assertSee('Diklat Ruang Angkatan VII');
});

test('penulis can update activity details without changing image', function () {
    $penulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);

    $activity = Activity::create([
        'user_id' => $penulis->id,
        'title' => 'Judul Lama',
        'slug' => 'judul-lama',
        'category' => 'Umum',
        'description' => 'Deskripsi awal.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/old.jpg',
        'image_public_id' => 'activities/old_id',
        'status' => 'draft',
        'is_active' => false,
        'order' => 0,
    ]);

    $response = $this->actingAs($penulis)->put(route('penulis.activities.update', $activity), [
        'title' => 'Penanaman 1000 Pohon',
        'category' => 'Konservasi',
        'location' => 'Lembang, Bandung',
        'event_date' => '2026-12-01',
        'description' => 'Aksi penghijauan kawasan hulu.',
        'status' => 'review',
        'order' => 5,
    ]);

    $response->assertRedirect(route('penulis.activities.index'));

    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'title' => 'Penanaman 1000 Pohon',
        'category' => 'Konservasi',
        'location' => 'Lembang, Bandung',
        'image_public_id' => 'activities/old_id',
        'status' => 'review',
        'order' => 5,
    ]);
});

test('penulis can update activity with new image, removing old asset from cloudinary', function () {
    $penulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);

    $activity = Activity::create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Lama',
        'slug' => 'kegiatan-lama',
        'category' => 'Ekspedisi',
        'description' => 'Deskripsi lama.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/old.jpg',
        'image_public_id' => 'activities/old_asset_to_delete',
        'status' => 'draft',
        'is_active' => false,
        'order' => 0,
    ]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('destroy')
            ->once()
            ->with('activities/old_asset_to_delete')
            ->andReturn(true);

        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'activities/brand_new_id',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/brand_new_id.jpg',
            ]);
    });

    $newFile = UploadedFile::fake()->image('new_activity.webp', 1200, 800);

    $response = $this->actingAs($penulis)->put(route('penulis.activities.update', $activity), [
        'title' => 'Kegiatan Diperbarui',
        'category' => 'Ekspedisi',
        'description' => 'Deskripsi baru.',
        'image' => $newFile,
        'status' => 'review',
        'order' => 1,
    ]);

    $response->assertRedirect(route('penulis.activities.index'));

    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'title' => 'Kegiatan Diperbarui',
        'image_public_id' => 'activities/brand_new_id',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/brand_new_id.jpg',
        'status' => 'review',
    ]);
});

test('admin can delete activity and its asset in cloudinary is destroyed', function () {
    $activity = Activity::create([
        'title' => 'Kegiatan Akan Dihapus',
        'slug' => 'kegiatan-akan-dihapus',
        'category' => 'Umum',
        'description' => 'Akan dihapus.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/del.jpg',
        'image_public_id' => 'activities/asset_to_destroy',
        'status' => 'archived',
        'is_active' => false,
        'order' => 0,
    ]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('destroy')
            ->once()
            ->with('activities/asset_to_destroy')
            ->andReturn(true);
    });

    $response = $this->actingAs($this->user)->delete(route('admin.activities.destroy', $activity));

    $response->assertRedirect(route('admin.activities.index'));
    $this->assertDatabaseMissing('activities', [
        'id' => $activity->id,
    ]);
});

test('admin and staff only see non-draft activities and can publish review or archive published', function () {
    $staff = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'staff',
    ]);

    $draftActivity = Activity::factory()->create([
        'title' => 'Draft Rahasia Penulis',
        'status' => 'draft',
        'is_active' => false,
    ]);

    $reviewActivity = Activity::factory()->create([
        'title' => 'Menunggu Review Admin',
        'status' => 'review',
        'is_active' => false,
    ]);

    $response = $this->actingAs($staff)->get(route('staff.activities.index'));
    $response->assertOk();
    $response->assertDontSee('Draft Rahasia Penulis');
    $response->assertSee('Menunggu Review Admin');

    $this->actingAs($staff)
        ->patch(route('staff.activities.status', $reviewActivity), ['status' => 'published'])
        ->assertRedirect();

    $this->assertDatabaseHas('activities', [
        'id' => $reviewActivity->id,
        'status' => 'published',
        'is_active' => 1,
    ]);

    $this->actingAs($this->user)
        ->patch(route('admin.activities.status', $reviewActivity), ['status' => 'archived'])
        ->assertRedirect();

    $this->assertDatabaseHas('activities', [
        'id' => $reviewActivity->id,
        'status' => 'archived',
        'is_active' => 0,
    ]);

    expect($draftActivity->fresh()->status)->toBe('draft');
});

test('penulis only sees own activities, can only choose draft or review, and can only delete draft', function () {
    $penulisA = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);
    $penulisB = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);

    $ownDraft = Activity::factory()->create([
        'user_id' => $penulisA->id,
        'title' => 'Draft Milik Penulis A',
        'status' => 'draft',
        'is_active' => false,
    ]);

    $ownReview = Activity::factory()->create([
        'user_id' => $penulisA->id,
        'title' => 'Review Milik Penulis A',
        'status' => 'review',
        'is_active' => false,
    ]);

    Activity::factory()->create([
        'user_id' => $penulisB->id,
        'title' => 'Kegiatan Milik Penulis B',
        'status' => 'draft',
        'is_active' => false,
    ]);

    $indexResponse = $this->actingAs($penulisA)->get(route('penulis.activities.index'));
    $indexResponse->assertOk();
    $indexResponse->assertSee('Draft Milik Penulis A');
    $indexResponse->assertDontSee('Kegiatan Milik Penulis B');

    $this->actingAs($penulisA)
        ->delete(route('penulis.activities.destroy', $ownReview))
        ->assertSessionHas('error');
    $this->assertDatabaseHas('activities', ['id' => $ownReview->id]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) use ($ownDraft) {
        $mock->shouldReceive('destroy')
            ->once()
            ->with($ownDraft->image_public_id)
            ->andReturn(true);
    });

    $this->actingAs($penulisA)
        ->delete(route('penulis.activities.destroy', $ownDraft))
        ->assertRedirect(route('penulis.activities.index'));
    $this->assertDatabaseMissing('activities', ['id' => $ownDraft->id]);
});

test('activities list supports search by title and location and filter by category and status', function () {
    Activity::factory()->create([
        'title' => 'Ekspedisi Gunung Ciremai',
        'location' => 'Kuningan, Jawa Barat',
        'category' => 'Ekspedisi',
        'status' => 'review',
        'is_active' => false,
    ]);

    Activity::factory()->create([
        'title' => 'Diklat Navigasi Darat',
        'location' => 'Lembang, Bandung',
        'category' => 'Diklat',
        'status' => 'published',
        'is_active' => true,
    ]);

    // Search by title
    $this->actingAs($this->user)
        ->get(route('admin.activities.index', ['search' => 'ciremai']))
        ->assertOk()
        ->assertSee('Ekspedisi Gunung Ciremai')
        ->assertDontSee('Diklat Navigasi Darat');

    // Search by location
    $this->actingAs($this->user)
        ->get(route('admin.activities.index', ['search' => 'lembang']))
        ->assertOk()
        ->assertSee('Diklat Navigasi Darat')
        ->assertDontSee('Ekspedisi Gunung Ciremai');

    // Filter by category
    $this->actingAs($this->user)
        ->get(route('admin.activities.index', ['category' => 'Ekspedisi']))
        ->assertOk()
        ->assertSee('Ekspedisi Gunung Ciremai')
        ->assertDontSee('Diklat Navigasi Darat');

    // Filter by status
    $this->actingAs($this->user)
        ->get(route('admin.activities.index', ['status' => 'published']))
        ->assertOk()
        ->assertSee('Diklat Navigasi Darat')
        ->assertDontSee('Ekspedisi Gunung Ciremai');
});

test('admin, staff, and penulis can preview non-published activities according to role while guests cannot', function () {
    $staff = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'staff',
    ]);
    $penulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);
    $otherPenulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);

    $draft = Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Draft Preview',
        'slug' => 'kegiatan-draft-preview',
        'status' => 'draft',
        'is_active' => false,
    ]);

    $review = Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Review Preview',
        'slug' => 'kegiatan-review-preview',
        'status' => 'review',
        'is_active' => false,
    ]);

    $archived = Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Archived Preview',
        'slug' => 'kegiatan-archived-preview',
        'status' => 'archived',
        'is_active' => false,
    ]);

    // Guests get 404
    $this->get(route('kegiatan.show', $draft->slug))->assertNotFound();
    $this->get(route('kegiatan.show', $review->slug))->assertNotFound();
    $this->get(route('kegiatan.show', $archived->slug))->assertNotFound();

    // Admin & staff can preview review & archived, not draft
    $this->actingAs($this->user)->get(route('kegiatan.show', $review->slug))->assertOk()->assertSee('Kegiatan Review Preview');
    $this->actingAs($staff)->get(route('kegiatan.show', $archived->slug))->assertOk()->assertSee('Kegiatan Archived Preview');
    $this->actingAs($this->user)->get(route('kegiatan.show', $draft->slug))->assertNotFound();

    // Penulis owner can preview draft, review, and archived; other penulis cannot
    $this->actingAs($penulis)->get(route('kegiatan.show', $draft->slug))->assertOk()->assertSee('Kegiatan Draft Preview');
    $this->actingAs($penulis)->get(route('kegiatan.show', $review->slug))->assertOk();
    $this->actingAs($penulis)->get(route('kegiatan.show', $archived->slug))->assertOk();
    $this->actingAs($otherPenulis)->get(route('kegiatan.show', $draft->slug))->assertNotFound();
});
