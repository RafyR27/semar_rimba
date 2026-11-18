<?php

use App\Models\Berita;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Mockery\MockInterface;
use RuntimeException;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
});

function makeBerita(array $attributes = []): Berita
{
    return Berita::create(array_merge([
        'judul' => 'Ekspedisi Argopuro 2026',
        'slug' => 'ekspedisi-argopuro-2026',
        'konten' => 'Laporan ekspedisi pendakian Argopuro oleh anggota SEMAR RIMBA.',
        'thumbnail_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
        'thumbnail_public_id' => 'beritas/sample1',
        'tanggal_terbit' => '2026-11-01',
        'is_published' => true,
    ], $attributes));
}

// ---------------------------------------------------------------------------
// Authentication & Authorization
// ---------------------------------------------------------------------------

test('guests are redirected to login when accessing berita management', function () {
    $this->get(route('admin.beritas.index'))->assertRedirect(route('login'));
    $this->get(route('admin.beritas.create'))->assertRedirect(route('login'));
});

test('authenticated verified users can view the berita list', function () {
    makeBerita();

    $response = $this->actingAs($this->user)->get(route('admin.beritas.index'));

    $response->assertOk();
    $response->assertSee('Manajemen Berita');
    $response->assertSee('Ekspedisi Argopuro 2026');
    $response->assertSee('ekspedisi-argopuro-2026');
});

// ---------------------------------------------------------------------------
// Create
// ---------------------------------------------------------------------------

test('admin can view create berita page', function () {
    $response = $this->actingAs($this->user)->get(route('admin.beritas.create'));

    $response->assertOk();
    $response->assertSee('Tambah Berita Baru');
    $response->assertSee('Judul Berita');
    $response->assertSee('Isi Berita');
});

test('admin can store a new berita with thumbnail upload to cloudinary', function () {
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'beritas/unique_id_123',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/v1/beritas/unique_id_123.jpg',
            ]);
    });

    $file = UploadedFile::fake()->image('berita.jpg', 1600, 900);

    $response = $this->actingAs($this->user)->post(route('admin.beritas.store'), [
        'judul' => 'Ekspedisi Puncak Semeru',
        'konten' => 'Rangkaian kegiatan ekspedisi dan pendidikan dasar lapangan.',
        'thumbnail' => $file,
        'tanggal_terbit' => '2026-11-10',
        'is_published' => '1',
    ]);

    $response->assertRedirect(route('admin.beritas.index'));
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('beritas', [
        'judul' => 'Ekspedisi Puncak Semeru',
        'slug' => 'ekspedisi-puncak-semeru',
        'thumbnail_public_id' => 'beritas/unique_id_123',
        'thumbnail_url' => 'https://res.cloudinary.com/demo/image/upload/v1/beritas/unique_id_123.jpg',
        'tanggal_terbit' => '2026-11-10 00:00:00',
        'is_published' => 1,
    ]);
});

test('slug is generated from judul when left empty', function () {
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->once()->andReturn([
            'public_id' => 'beritas/slug_auto',
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/slug_auto.jpg',
        ]);
    });

    $this->actingAs($this->user)->post(route('admin.beritas.store'), [
        'judul' => 'Konservasi Hutan Lindung Bandung',
        'konten' => 'Kegiatan konservasi bersama warga sekitar.',
        'thumbnail' => UploadedFile::fake()->image('konservasi.jpg'),
        'is_published' => '1',
    ])->assertRedirect(route('admin.beritas.index'));

    $this->assertDatabaseHas('beritas', [
        'judul' => 'Konservasi Hutan Lindung Bandung',
        'slug' => 'konservasi-hutan-lindung-bandung',
    ]);
});

test('duplicate slug is made unique automatically', function () {
    makeBerita(['judul' => 'Ekspedisi Argopuro 2026', 'slug' => 'ekspedisi-argopuro-2026']);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->once()->andReturn([
            'public_id' => 'beritas/dup',
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/dup.jpg',
        ]);
    });

    $this->actingAs($this->user)->post(route('admin.beritas.store'), [
        'judul' => 'Ekspedisi Argopuro 2026',
        'konten' => 'Duplikat judul untuk menguji slug unik.',
        'thumbnail' => UploadedFile::fake()->image('dup.jpg'),
        'is_published' => '0',
    ])->assertRedirect(route('admin.beritas.index'));

    $this->assertDatabaseHas('beritas', ['slug' => 'ekspedisi-argopuro-2026-1']);
});

test('validation prevents storing berita without judul konten or thumbnail', function () {
    $response = $this->actingAs($this->user)->post(route('admin.beritas.store'), [
        'judul' => '',
        'konten' => '',
    ]);

    $response->assertSessionHasErrors(['judul', 'konten', 'thumbnail']);
    $this->assertDatabaseCount('beritas', 0);
});

test('validation rejects non image thumbnail', function () {
    $response = $this->actingAs($this->user)->post(route('admin.beritas.store'), [
        'judul' => 'Berita Dengan File Salah',
        'konten' => 'Isi berita.',
        'thumbnail' => UploadedFile::fake()->create('dokumen.pdf', 120, 'application/pdf'),
        'is_published' => '1',
    ]);

    $response->assertSessionHasErrors(['thumbnail']);
    $this->assertDatabaseCount('beritas', 0);
});

// ---------------------------------------------------------------------------
// Edit & Update
// ---------------------------------------------------------------------------

test('admin can view edit berita page', function () {
    $berita = makeBerita();

    $response = $this->actingAs($this->user)->get(route('admin.beritas.edit', $berita));

    $response->assertOk();
    $response->assertSee('Edit Berita');
    $response->assertSee('Ekspedisi Argopuro 2026');
});

test('admin can update berita without changing the thumbnail', function () {
    $berita = makeBerita();

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldNotReceive('upload');
        $mock->shouldNotReceive('destroy');
    });

    $response = $this->actingAs($this->user)->put(route('admin.beritas.update', $berita), [
        'judul' => 'Ekspedisi Argopuro 2026 Diperbarui',
        'slug' => 'ekspedisi-argopuro-2026',
        'konten' => 'Isi berita yang sudah diperbarui.',
        'tanggal_terbit' => '2026-11-05',
        'is_published' => '0',
    ]);

    $response->assertRedirect(route('admin.beritas.index'));

    $this->assertDatabaseHas('beritas', [
        'id' => $berita->id,
        'judul' => 'Ekspedisi Argopuro 2026 Diperbarui',
        'konten' => 'Isi berita yang sudah diperbarui.',
        'thumbnail_public_id' => 'beritas/sample1',
        'is_published' => 0,
    ]);
});

test('admin can replace berita thumbnail and old cloudinary asset is destroyed', function () {
    $berita = makeBerita(['thumbnail_public_id' => 'beritas/old_asset_to_delete']);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('destroy')
            ->once()
            ->with('beritas/old_asset_to_delete')
            ->andReturn(true);

        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'beritas/brand_new_id',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/brand_new_id.jpg',
            ]);
    });

    $response = $this->actingAs($this->user)->put(route('admin.beritas.update', $berita), [
        'judul' => 'Ekspedisi Argopuro 2026',
        'slug' => 'ekspedisi-argopuro-2026',
        'konten' => 'Isi berita dengan gambar baru.',
        'thumbnail' => UploadedFile::fake()->image('baru.webp', 1600, 900),
        'tanggal_terbit' => '2026-11-01',
        'is_published' => '1',
    ]);

    $response->assertRedirect(route('admin.beritas.index'));

    $this->assertDatabaseHas('beritas', [
        'id' => $berita->id,
        'thumbnail_public_id' => 'beritas/brand_new_id',
        'thumbnail_url' => 'https://res.cloudinary.com/demo/image/upload/brand_new_id.jpg',
    ]);
});

// ---------------------------------------------------------------------------
// Delete & Publish Toggle
// ---------------------------------------------------------------------------

test('admin can delete berita and its cloudinary asset is destroyed', function () {
    $berita = makeBerita(['thumbnail_public_id' => 'beritas/asset_to_destroy']);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('destroy')
            ->once()
            ->with('beritas/asset_to_destroy')
            ->andReturn(true);
    });

    $response = $this->actingAs($this->user)->delete(route('admin.beritas.destroy', $berita));

    $response->assertRedirect(route('admin.beritas.index'));
    $this->assertDatabaseMissing('beritas', ['id' => $berita->id]);
});

test('admin can toggle publication status of berita', function () {
    $berita = makeBerita(['is_published' => true]);

    $this->actingAs($this->user)
        ->patch(route('admin.beritas.toggle', $berita))
        ->assertRedirect();

    $this->assertDatabaseHas('beritas', ['id' => $berita->id, 'is_published' => 0]);

    $this->actingAs($this->user)
        ->patch(route('admin.beritas.toggle', $berita))
        ->assertRedirect();

    $this->assertDatabaseHas('beritas', ['id' => $berita->id, 'is_published' => 1]);
});

// ---------------------------------------------------------------------------
// Search & Filter
// ---------------------------------------------------------------------------

test('admin list supports search and status filter', function () {
    makeBerita(['judul' => 'Ekspedisi Argopuro 2026', 'slug' => 'argopuro']);
    makeBerita([
        'judul' => 'Konservasi Mangrove',
        'slug' => 'konservasi-mangrove',
        'konten' => 'Cerita penanaman mangrove di pesisir Bandung.',
        'is_published' => false,
    ]);

    $this->actingAs($this->user)
        ->get(route('admin.beritas.index', ['search' => 'Argopuro']))
        ->assertOk()
        ->assertSee('Ekspedisi Argopuro 2026')
        ->assertDontSee('Konservasi Mangrove');

    $this->actingAs($this->user)
        ->get(route('admin.beritas.index', ['status' => 'draft']))
        ->assertOk()
        ->assertSee('Konservasi Mangrove')
        ->assertDontSee('Ekspedisi Argopuro 2026');
});

// ---------------------------------------------------------------------------
// Public Pages
// ---------------------------------------------------------------------------

test('public berita page only lists published news', function () {
    makeBerita(['judul' => 'Berita Terbit', 'slug' => 'berita-terbit', 'is_published' => true]);
    makeBerita(['judul' => 'Berita Draf', 'slug' => 'berita-draf', 'is_published' => false]);

    $response = $this->get(route('berita.index'));

    $response->assertOk();
    $response->assertSee('Berita Terbit');
    $response->assertDontSee('Berita Draf');
});

test('public can read published berita detail', function () {
    makeBerita([
        'judul' => 'Ekspedisi Argopuro 2026',
        'slug' => 'ekspedisi-argopuro-2026',
        'konten' => 'Detail laporan ekspedisi Argopuro.',
        'is_published' => true,
    ]);
    makeBerita([
        'judul' => 'Bakti Konservasi Lereng Semeru',
        'slug' => 'bakti-konservasi-lereng-semeru',
        'konten' => 'Aksi penanaman bibit di lereng Semeru.',
        'is_published' => true,
    ]);

    $response = $this->get(route('berita.show', 'ekspedisi-argopuro-2026'));

    $response->assertOk();
    $response->assertSee('Ekspedisi Argopuro 2026');
    $response->assertSee('Detail laporan ekspedisi Argopuro.');
    $response->assertSee('https://res.cloudinary.com/demo/image/upload/sample.jpg');
    $response->assertSee('Berita Lainnya');
});

test('public cannot access draft berita detail', function () {
    makeBerita([
        'judul' => 'Berita Draf Rahasia',
        'slug' => 'berita-draf-rahasia',
        'is_published' => false,
    ]);

    $this->get(route('berita.show', 'berita-draf-rahasia'))->assertNotFound();
});

test('public berita page shows empty state when nothing published', function () {
    makeBerita(['is_published' => false]);

    $this->get(route('berita.index'))
        ->assertOk()
        ->assertSee('Belum Ada Berita');
});

// ---------------------------------------------------------------------------
// Cloudinary lifecycle compensation & write failures
// ---------------------------------------------------------------------------

test('newly uploaded thumbnail is discarded when storing berita fails in database', function () {
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->once()->andReturn([
            'public_id' => 'beritas/orphan_after_failure',
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/orphan_after_failure.jpg',
        ]);
        $mock->shouldReceive('destroy')->once()->with('beritas/orphan_after_failure')->andReturn(true);
    });

    $fail = true;
    Berita::creating(function () use (&$fail): void {
        if ($fail) {
            throw new RuntimeException('Simulasi gagal menyimpan database.');
        }
    });

    $this->actingAs($this->user)->post(route('admin.beritas.store'), [
        'judul' => 'Berita Yang Gagal Disimpan',
        'slug' => 'berita-yang-gagal-disimpan',
        'konten' => 'Konten contoh.',
        'thumbnail' => UploadedFile::fake()->image('gagal.jpg', 1600, 900),
        'tanggal_terbit' => '2026-11-10',
        'is_published' => '1',
    ])->assertSessionHas('error');

    $fail = false;

    $this->assertDatabaseCount('beritas', 0);
});

test('previous thumbnail is preserved and new upload is discarded when updating berita fails', function () {
    $berita = makeBerita(['thumbnail_public_id' => 'beritas/old_keep']);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->once()->andReturn([
            'public_id' => 'beritas/new_discard',
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/new_discard.jpg',
        ]);
        $mock->shouldReceive('destroy')->once()->with('beritas/new_discard')->andReturn(true);
        $mock->shouldNotReceive('destroy')->with('beritas/old_keep');
    });

    $fail = true;
    Berita::updating(function () use (&$fail): void {
        if ($fail) {
            throw new RuntimeException('Simulasi gagal memperbarui database.');
        }
    });

    $this->actingAs($this->user)->put(route('admin.beritas.update', $berita), [
        'judul' => 'Ekspedisi Argopuro 2026 Diperbarui',
        'slug' => 'ekspedisi-argopuro-2026',
        'konten' => 'Isi berita yang sudah diperbarui.',
        'thumbnail' => UploadedFile::fake()->image('baru.jpg'),
        'tanggal_terbit' => '2026-11-05',
        'is_published' => '0',
    ])->assertSessionHas('error');

    $fail = false;

    $fresh = $berita->fresh();
    expect($fresh->judul)->toBe('Ekspedisi Argopuro 2026');
    expect($fresh->thumbnail_public_id)->toBe('beritas/old_keep');
});

test('berita record and its existing thumbnail stay intact when database delete fails', function () {
    $berita = makeBerita(['thumbnail_public_id' => 'beritas/keep_asset']);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldNotReceive('destroy');
    });

    $fail = true;
    Berita::deleting(function () use (&$fail): void {
        if ($fail) {
            throw new RuntimeException('Simulasi gagal menghapus database.');
        }
    });

    $this->actingAs($this->user)->delete(route('admin.beritas.destroy', $berita))->assertSessionHas('error');

    $fail = false;

    $this->assertDatabaseHas('beritas', [
        'id' => $berita->id,
        'thumbnail_public_id' => 'beritas/keep_asset',
    ]);
});

test('berita is still deleted when Cloudinary asset removal fails and the failure is logged', function () {
    $berita = makeBerita(['thumbnail_public_id' => 'beritas/asset_with_broken_destroy']);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('destroy')->once()->with('beritas/asset_with_broken_destroy')->andReturn(false);
    });

    Log::spy();

    $this->actingAs($this->user)->delete(route('admin.beritas.destroy', $berita))->assertSessionHas('status');

    $this->assertDatabaseMissing('beritas', ['id' => $berita->id]);
    Log::shouldHaveReceived('warning')->once()->withArgs(function (string $message, array $context = []): bool {
        return str_contains($message, 'Cloudinary')
            && ($context['public_id'] ?? null) === 'beritas/asset_with_broken_destroy';
    });
});

test('berita update succeeds and logs a warning when the previous Cloudinary asset cannot be removed', function () {
    $berita = makeBerita(['thumbnail_public_id' => 'beritas/old_unremovable']);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->once()->andReturn([
            'public_id' => 'beritas/new_after_old_unremovable',
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/new_after_old_unremovable.jpg',
        ]);
        $mock->shouldReceive('destroy')->once()->with('beritas/old_unremovable')->andReturn(false);
    });

    Log::spy();

    $this->actingAs($this->user)->put(route('admin.beritas.update', $berita), [
        'judul' => 'Ekspedisi Argopuro 2026 Diperbarui',
        'slug' => 'ekspedisi-argopuro-2026',
        'konten' => 'Isi berita dengan thumbnail baru.',
        'thumbnail' => UploadedFile::fake()->image('baru.jpg'),
        'tanggal_terbit' => '2026-11-01',
        'is_published' => '1',
    ])->assertSessionHas('status');

    $this->assertDatabaseHas('beritas', [
        'id' => $berita->id,
        'thumbnail_public_id' => 'beritas/new_after_old_unremovable',
    ]);
    Log::shouldHaveReceived('warning')->once()->withArgs(function (string $message): bool {
        return str_contains($message, 'lama gagal dihapus');
    });
});

// ---------------------------------------------------------------------------
// Authorization
// ---------------------------------------------------------------------------

test('guests cannot create, update, delete, or toggle publication of berita through admin routes', function () {
    $berita = makeBerita();

    $this->post(route('admin.beritas.store'))->assertRedirect(route('login'));
    $this->put(route('admin.beritas.update', $berita))->assertRedirect(route('login'));
    $this->delete(route('admin.beritas.destroy', $berita))->assertRedirect(route('login'));
    $this->patch(route('admin.beritas.toggle', $berita))->assertRedirect(route('login'));

    $this->assertDatabaseHas('beritas', ['id' => $berita->id, 'judul' => $berita->judul]);
});

// ---------------------------------------------------------------------------
// Tanggal publikasi
// ---------------------------------------------------------------------------

test('published berita with a future tanggal_terbit is visible immediately (no scheduling)', function () {
    makeBerita([
        'judul' => 'Ekspedisi Masa Depan',
        'slug' => 'ekspedisi-masa-depan',
        'tanggal_terbit' => now()->addMonth()->toDateString(),
        'is_published' => true,
    ]);

    $this->get(route('berita.show', 'ekspedisi-masa-depan'))->assertOk()->assertSee('Ekspedisi Masa Depan');
});
