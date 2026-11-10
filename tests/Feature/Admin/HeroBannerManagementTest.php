<?php

use App\Models\HeroBanner;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
});

test('guests are redirected to login when accessing hero banners management', function () {
    $response = $this->get(route('admin.hero-banners.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated verified users can view the hero banners list', function () {
    HeroBanner::create([
        'title' => 'Ekspedisi Rimba 2026',
        'subtitle' => 'Penjelajahan Matra Hutan',
        'description' => 'Eksplorasi jalur belantara.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
        'image_public_id' => 'hero_banners/sample1',
        'is_active' => true,
        'order' => 1,
    ]);

    $response = $this->actingAs($this->user)->get(route('admin.hero-banners.index'));

    $response->assertOk();
    $response->assertSee('Manajemen Hero Banner');
    $response->assertSee('Ekspedisi Rimba 2026');
    $response->assertSee('Penjelajahan Matra Hutan');
});

test('admin can view create hero banner page', function () {
    $response = $this->actingAs($this->user)->get(route('admin.hero-banners.create'));

    $response->assertOk();
    $response->assertSee('Tambah Hero Banner Baru');
    $response->assertSee('Judul Utama Banner');
});

test('admin can store a new hero banner with image upload to cloudinary', function () {
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'hero_banners/unique_id_123',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/v1/hero_banners/unique_id_123.jpg',
            ]);
    });

    $file = UploadedFile::fake()->image('nature.jpg', 1920, 1080);

    $response = $this->actingAs($this->user)->post(route('admin.hero-banners.store'), [
        'title' => 'Puncak Argopuro',
        'subtitle' => 'Eksplorasi Rimba Timur',
        'description' => 'Menembus jalur terpanjang di pulau Jawa.',
        'image' => $file,
        'button_text' => 'Lihat Laporan',
        'button_url' => '#kegiatan',
        'is_active' => '1',
        'order' => 2,
    ]);

    $response->assertRedirect(route('admin.hero-banners.index'));
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('hero_banners', [
        'title' => 'Puncak Argopuro',
        'image_public_id' => 'hero_banners/unique_id_123',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/v1/hero_banners/unique_id_123.jpg',
        'button_text' => 'Lihat Laporan',
        'is_active' => 1,
        'order' => 2,
    ]);
});

test('validation prevents storing hero banner without title or image', function () {
    $response = $this->actingAs($this->user)->post(route('admin.hero-banners.store'), [
        'title' => '',
        'image' => null,
    ]);

    $response->assertSessionHasErrors(['title', 'image']);
});

test('admin can view edit hero banner page', function () {
    $banner = HeroBanner::create([
        'title' => 'Ekspedisi Arung Jeram',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
        'image_public_id' => 'hero_banners/rafting1',
        'is_active' => true,
        'order' => 0,
    ]);

    $response = $this->actingAs($this->user)->get(route('admin.hero-banners.edit', $banner));

    $response->assertOk();
    $response->assertSee('Edit Hero Banner');
    $response->assertSee('Ekspedisi Arung Jeram');
});

test('admin can update hero banner details without changing image', function () {
    $banner = HeroBanner::create([
        'title' => 'Nama Lama',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/old.jpg',
        'image_public_id' => 'hero_banners/old_id',
        'is_active' => true,
        'order' => 0,
    ]);

    $response = $this->actingAs($this->user)->put(route('admin.hero-banners.update', $banner), [
        'title' => 'Nama Baru Petualangan',
        'subtitle' => 'Subjudul Baru',
        'is_active' => '1',
        'order' => 5,
    ]);

    $response->assertRedirect(route('admin.hero-banners.index'));

    $this->assertDatabaseHas('hero_banners', [
        'id' => $banner->id,
        'title' => 'Nama Baru Petualangan',
        'subtitle' => 'Subjudul Baru',
        'image_public_id' => 'hero_banners/old_id',
        'order' => 5,
    ]);
});

test('admin can update hero banner with new image, removing old asset from cloudinary', function () {
    $banner = HeroBanner::create([
        'title' => 'Banner Tebing',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/old.jpg',
        'image_public_id' => 'hero_banners/old_asset_to_delete',
        'is_active' => true,
        'order' => 0,
    ]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('destroy')
            ->once()
            ->with('hero_banners/old_asset_to_delete')
            ->andReturn(true);

        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'hero_banners/brand_new_id',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/brand_new_id.jpg',
            ]);
    });

    $newFile = UploadedFile::fake()->image('new_tebing.webp', 1920, 1080);

    $response = $this->actingAs($this->user)->put(route('admin.hero-banners.update', $banner), [
        'title' => 'Banner Tebing Diperbarui',
        'image' => $newFile,
        'is_active' => '1',
        'order' => 1,
    ]);

    $response->assertRedirect(route('admin.hero-banners.index'));

    $this->assertDatabaseHas('hero_banners', [
        'id' => $banner->id,
        'title' => 'Banner Tebing Diperbarui',
        'image_public_id' => 'hero_banners/brand_new_id',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/brand_new_id.jpg',
    ]);
});

test('admin can delete hero banner and its asset in cloudinary is destroyed', function () {
    $banner = HeroBanner::create([
        'title' => 'Banner Yang Akan Dihapus',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/del.jpg',
        'image_public_id' => 'hero_banners/asset_to_destroy',
        'is_active' => true,
        'order' => 0,
    ]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('destroy')
            ->once()
            ->with('hero_banners/asset_to_destroy')
            ->andReturn(true);
    });

    $response = $this->actingAs($this->user)->delete(route('admin.hero-banners.destroy', $banner));

    $response->assertRedirect(route('admin.hero-banners.index'));
    $this->assertDatabaseMissing('hero_banners', [
        'id' => $banner->id,
    ]);
});

test('admin can toggle active status of hero banner', function () {
    $banner = HeroBanner::create([
        'title' => 'Status Toggle Banner',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/toggle.jpg',
        'image_public_id' => 'hero_banners/toggle_id',
        'is_active' => true,
        'order' => 0,
    ]);

    $response = $this->actingAs($this->user)->patch(route('admin.hero-banners.toggle', $banner));

    $response->assertRedirect();
    $this->assertDatabaseHas('hero_banners', [
        'id' => $banner->id,
        'is_active' => 0,
    ]);

    $response2 = $this->actingAs($this->user)->patch(route('admin.hero-banners.toggle', $banner));

    $response2->assertRedirect();
    $this->assertDatabaseHas('hero_banners', [
        'id' => $banner->id,
        'is_active' => 1,
    ]);
});

test('homepage renders active hero banner with cloudinary image', function () {
    HeroBanner::create([
        'title' => 'SEMAR RIMBA 2026',
        'subtitle' => 'Penjelajahan Nusantara',
        'description' => 'Motto dan narasi korsa Mapala.',
        'image_url' => 'https://res.cloudinary.com/demo/image/upload/hero_banner_live.webp',
        'image_public_id' => 'hero_banners/live_1',
        'button_text' => 'Pelajari Ekspedisi',
        'button_url' => '#divisi',
        'is_active' => true,
        'order' => 0,
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('SEMAR RIMBA 2026');
    $response->assertSee('Penjelajahan Nusantara');
    $response->assertSee('Pelajari Ekspedisi');
    $response->assertSee('https://res.cloudinary.com/demo/image/upload/hero_banner_live.webp');
});

test('homepage falls back gracefully to default assets when no active banner exists', function () {
    HeroBanner::query()->delete();

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('SEMAR RIMBA');
    $response->assertSee('UKM Pecinta Alam Politeknik STIA LAN Bandung');
    $response->assertSee('images/gambar2.webp');
    $response->assertSee('images/gambar1.webp');
});
