<?php

use App\Models\Gallery;
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

test('guests are redirected to login when accessing galleries management', function () {
    $response = $this->get(route('admin.galleries.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated verified users can view the galleries list', function () {
    Gallery::create([
        'title' => 'Ekspedisi Gunung Hutan 2026',
        'category' => 'Gunung Hutan',
        'description' => 'Dokumentasi pendakian wajib anggota muda.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
        'image_public_id' => 'galleries/sample1',
        'is_active' => true,
        'order' => 1,
    ]);

    $response = $this->actingAs($this->user)->get(route('admin.galleries.index'));

    $response->assertOk();
    $response->assertSee('Manajemen Galeri');
    $response->assertSee('Ekspedisi Gunung Hutan 2026');
    $response->assertSee('Gunung Hutan');
});

test('admin can view create gallery page', function () {
    $response = $this->actingAs($this->user)->get(route('admin.galleries.create'));

    $response->assertOk();
    $response->assertSee('Tambah Foto Galeri Baru');
    $response->assertSee('Judul Dokumentasi');
});

test('admin can store a new gallery item with image upload to cloudinary', function () {
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'galleries/unique_id_123',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/v1/galleries/unique_id_123.jpg',
            ]);
    });

    $file = UploadedFile::fake()->image('gallery.jpg', 1200, 800);

    $response = $this->actingAs($this->user)->post(route('admin.galleries.store'), [
        'title' => 'Latihan Panjat Tebing',
        'category' => 'Panjat Tebing',
        'description' => 'Latihan rutin di tebing Citatah.',
        'image' => $file,
        'is_active' => '1',
        'order' => 2,
    ]);

    $response->assertRedirect(route('admin.galleries.index'));
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('galleries', [
        'title' => 'Latihan Panjat Tebing',
        'category' => 'Panjat Tebing',
        'image_public_id' => 'galleries/unique_id_123',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/v1/galleries/unique_id_123.jpg',
        'is_active' => 1,
        'order' => 2,
    ]);
});

test('validation prevents storing gallery item without title or image', function () {
    $response = $this->actingAs($this->user)->post(route('admin.galleries.store'), [
        'title' => '',
        'image' => null,
    ]);

    $response->assertSessionHasErrors(['title', 'image']);
});

test('admin can view edit gallery page', function () {
    $gallery = Gallery::create([
        'title' => 'Susur Gua Pawon',
        'category' => 'Susur Gua',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
        'image_public_id' => 'galleries/caving1',
        'is_active' => true,
        'order' => 0,
    ]);

    $response = $this->actingAs($this->user)->get(route('admin.galleries.edit', $gallery));

    $response->assertOk();
    $response->assertSee('Edit Foto Galeri');
    $response->assertSee('Susur Gua Pawon');
});

test('admin can update gallery details without changing image', function () {
    $gallery = Gallery::create([
        'title' => 'Judul Lama',
        'category' => 'Umum',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/old.jpg',
        'image_public_id' => 'galleries/old_id',
        'is_active' => true,
        'order' => 0,
    ]);

    $response = $this->actingAs($this->user)->put(route('admin.galleries.update', $gallery), [
        'title' => 'Judul Dokumentasi Baru',
        'category' => 'Arung Jeram',
        'is_active' => '1',
        'order' => 5,
    ]);

    $response->assertRedirect(route('admin.galleries.index'));

    $this->assertDatabaseHas('galleries', [
        'id' => $gallery->id,
        'title' => 'Judul Dokumentasi Baru',
        'category' => 'Arung Jeram',
        'image_public_id' => 'galleries/old_id',
        'order' => 5,
    ]);
});

test('admin can update gallery with new image, removing old asset from cloudinary', function () {
    $gallery = Gallery::create([
        'title' => 'Foto Lama',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/old.jpg',
        'image_public_id' => 'galleries/old_asset_to_delete',
        'is_active' => true,
        'order' => 0,
    ]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('destroy')
            ->once()
            ->with('galleries/old_asset_to_delete')
            ->andReturn(true);

        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'galleries/brand_new_id',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/brand_new_id.jpg',
            ]);
    });

    $newFile = UploadedFile::fake()->image('new_gallery.webp', 1200, 800);

    $response = $this->actingAs($this->user)->put(route('admin.galleries.update', $gallery), [
        'title' => 'Foto Diperbarui',
        'image' => $newFile,
        'is_active' => '1',
        'order' => 1,
    ]);

    $response->assertRedirect(route('admin.galleries.index'));

    $this->assertDatabaseHas('galleries', [
        'id' => $gallery->id,
        'title' => 'Foto Diperbarui',
        'image_public_id' => 'galleries/brand_new_id',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/brand_new_id.jpg',
    ]);
});

test('admin can delete gallery and its asset in cloudinary is destroyed', function () {
    $gallery = Gallery::create([
        'title' => 'Foto Akan Dihapus',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/del.jpg',
        'image_public_id' => 'galleries/asset_to_destroy',
        'is_active' => true,
        'order' => 0,
    ]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('destroy')
            ->once()
            ->with('galleries/asset_to_destroy')
            ->andReturn(true);
    });

    $response = $this->actingAs($this->user)->delete(route('admin.galleries.destroy', $gallery));

    $response->assertRedirect(route('admin.galleries.index'));
    $this->assertDatabaseMissing('galleries', [
        'id' => $gallery->id,
    ]);
});

test('admin can toggle active status of gallery', function () {
    $gallery = Gallery::create([
        'title' => 'Status Toggle Foto',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/toggle.jpg',
        'image_public_id' => 'galleries/toggle_id',
        'is_active' => true,
        'order' => 0,
    ]);

    $response = $this->actingAs($this->user)->patch(route('admin.galleries.toggle', $gallery));

    $response->assertRedirect();
    $this->assertDatabaseHas('galleries', [
        'id' => $gallery->id,
        'is_active' => 0,
    ]);

    $response2 = $this->actingAs($this->user)->patch(route('admin.galleries.toggle', $gallery));

    $response2->assertRedirect();
    $this->assertDatabaseHas('galleries', [
        'id' => $gallery->id,
        'is_active' => 1,
    ]);
});
