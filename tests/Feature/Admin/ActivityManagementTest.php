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
        'is_active' => true,
        'order' => 1,
    ]);

    $response = $this->actingAs($this->user)->get(route('admin.activities.index'));

    $response->assertOk();
    $response->assertSee('Manajemen Kegiatan');
    $response->assertSee('Ekspedisi Gunung Ciremai 2026');
    $response->assertSee('Ekspedisi');
});

test('admin can view create activity page', function () {
    $response = $this->actingAs($this->user)->get(route('admin.activities.create'));

    $response->assertOk();
    $response->assertSee('Tambah Kegiatan Baru');
    $response->assertSee('Judul Kegiatan');
});

test('admin can store a new activity with image upload to cloudinary', function () {
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'activities/unique_id_123',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/v1/activities/unique_id_123.jpg',
            ]);
    });

    $file = UploadedFile::fake()->image('kegiatan.jpg', 1200, 800);

    $response = $this->actingAs($this->user)->post(route('admin.activities.store'), [
        'title' => 'Operasi SAR Banjir Bandang',
        'category' => 'SAR & Kemanusiaan',
        'location' => 'Garut, Jawa Barat',
        'event_date' => '2026-11-12',
        'description' => 'Bantuan evakuasi dan logistik warga terdampak.',
        'image' => $file,
        'is_active' => '1',
        'order' => 2,
    ]);

    $response->assertRedirect(route('admin.activities.index'));
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('activities', [
        'title' => 'Operasi SAR Banjir Bandang',
        'category' => 'SAR & Kemanusiaan',
        'location' => 'Garut, Jawa Barat',
        'image_public_id' => 'activities/unique_id_123',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/v1/activities/unique_id_123.jpg',
        'is_active' => 1,
        'order' => 2,
    ]);
});

test('validation prevents storing activity without required fields', function () {
    $response = $this->actingAs($this->user)->post(route('admin.activities.store'), [
        'title' => '',
        'category' => '',
        'description' => '',
        'image' => null,
    ]);

    $response->assertSessionHasErrors(['title', 'category', 'description', 'image']);
});

test('admin can view edit activity page', function () {
    $activity = Activity::create([
        'title' => 'Diklat Ruang Angkatan VII',
        'slug' => 'diklat-ruang-angkatan-vii',
        'category' => 'Diklat',
        'description' => 'Pembekalan materi navigasi darat.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
        'image_public_id' => 'activities/diklat1',
        'is_active' => true,
        'order' => 0,
    ]);

    $response = $this->actingAs($this->user)->get(route('admin.activities.edit', $activity));

    $response->assertOk();
    $response->assertSee('Edit Kegiatan');
    $response->assertSee('Diklat Ruang Angkatan VII');
});

test('admin can update activity details without changing image', function () {
    $activity = Activity::create([
        'title' => 'Judul Lama',
        'slug' => 'judul-lama',
        'category' => 'Umum',
        'description' => 'Deskripsi awal.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/old.jpg',
        'image_public_id' => 'activities/old_id',
        'is_active' => true,
        'order' => 0,
    ]);

    $response = $this->actingAs($this->user)->put(route('admin.activities.update', $activity), [
        'title' => 'Penanaman 1000 Pohon',
        'category' => 'Konservasi',
        'location' => 'Lembang, Bandung',
        'event_date' => '2026-12-01',
        'description' => 'Aksi penghijauan kawasan hulu.',
        'is_active' => '1',
        'order' => 5,
    ]);

    $response->assertRedirect(route('admin.activities.index'));

    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'title' => 'Penanaman 1000 Pohon',
        'category' => 'Konservasi',
        'location' => 'Lembang, Bandung',
        'image_public_id' => 'activities/old_id',
        'order' => 5,
    ]);
});

test('admin can update activity with new image, removing old asset from cloudinary', function () {
    $activity = Activity::create([
        'title' => 'Kegiatan Lama',
        'slug' => 'kegiatan-lama',
        'category' => 'Ekspedisi',
        'description' => 'Deskripsi lama.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/old.jpg',
        'image_public_id' => 'activities/old_asset_to_delete',
        'is_active' => true,
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

    $response = $this->actingAs($this->user)->put(route('admin.activities.update', $activity), [
        'title' => 'Kegiatan Diperbarui',
        'category' => 'Ekspedisi',
        'description' => 'Deskripsi baru.',
        'image' => $newFile,
        'is_active' => '1',
        'order' => 1,
    ]);

    $response->assertRedirect(route('admin.activities.index'));

    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'title' => 'Kegiatan Diperbarui',
        'image_public_id' => 'activities/brand_new_id',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/brand_new_id.jpg',
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
        'is_active' => true,
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

test('admin can toggle active status of activity', function () {
    $activity = Activity::create([
        'title' => 'Status Toggle Kegiatan',
        'slug' => 'status-toggle-kegiatan',
        'category' => 'Ekspedisi',
        'description' => 'Tes toggle publish.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/toggle.jpg',
        'image_public_id' => 'activities/toggle_id',
        'is_active' => true,
        'order' => 0,
    ]);

    $response = $this->actingAs($this->user)->patch(route('admin.activities.toggle', $activity));

    $response->assertRedirect();
    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'is_active' => 0,
    ]);

    $response2 = $this->actingAs($this->user)->patch(route('admin.activities.toggle', $activity));

    $response2->assertRedirect();
    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'is_active' => 1,
    ]);
});
