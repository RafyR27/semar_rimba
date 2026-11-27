<?php

use App\Models\Berita;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Mockery\MockInterface;
use RuntimeException;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'admin',
    ]);

    $this->penulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
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
        'status' => 'review',
        'is_published' => false,
    ], $attributes));
}

// ---------------------------------------------------------------------------
// Authentication & Authorization
// ---------------------------------------------------------------------------

test('guests are redirected to login when accessing berita management', function () {
    $this->get(route('admin.beritas.index'))->assertRedirect(route('login'));
    $this->get(route('penulis.beritas.create'))->assertRedirect(route('login'));
});

test('authenticated verified admin can view non-draft berita list', function () {
    makeBerita(['status' => 'review']);
    makeBerita([
        'judul' => 'Berita Draft Rahasia',
        'slug' => 'berita-draft-rahasia',
        'status' => 'draft',
    ]);

    $response = $this->actingAs($this->user)->get(route('admin.beritas.index'));

    $response->assertOk();
    $response->assertSee('Manajemen Berita');
    $response->assertSee('Ekspedisi Argopuro 2026');
    $response->assertSee('Laporan ekspedisi pendakian Argopuro');
    $response->assertDontSee('Berita Draft Rahasia');
});

// ---------------------------------------------------------------------------
// Create
// ---------------------------------------------------------------------------

test('penulis can view create berita page and admin or staff cannot', function () {
    $response = $this->actingAs($this->penulis)->get(route('penulis.beritas.create'));

    $response->assertOk();
    $response->assertSee('Tambah Berita Baru');
    $response->assertSee('Judul Berita');
    $response->assertSee('Isi Berita');
    expect(Route::has('admin.beritas.create'))->toBeFalse();
    expect(Route::has('staff.beritas.create'))->toBeFalse();
});

test('penulis can store a new berita with thumbnail upload to cloudinary', function () {
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')
            ->once()
            ->andReturn([
                'public_id' => 'beritas/unique_id_123',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/v1/beritas/unique_id_123.jpg',
            ]);
    });

    $file = UploadedFile::fake()->image('berita.jpg', 1600, 900);

    $response = $this->actingAs($this->penulis)->post(route('penulis.beritas.store'), [
        'judul' => 'Ekspedisi Puncak Semeru',
        'konten' => 'Rangkaian kegiatan ekspedisi dan pendidikan dasar lapangan.',
        'thumbnail' => $file,
        'tanggal_terbit' => '2026-11-10',
        'status' => 'draft',
    ]);

    $response->assertRedirect(route('penulis.beritas.index'));
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('beritas', [
        'user_id' => $this->penulis->id,
        'judul' => 'Ekspedisi Puncak Semeru',
        'slug' => 'ekspedisi-puncak-semeru',
        'thumbnail_public_id' => 'beritas/unique_id_123',
        'thumbnail_url' => 'https://res.cloudinary.com/demo/image/upload/v1/beritas/unique_id_123.jpg',
        'tanggal_terbit' => '2026-11-10 00:00:00',
        'status' => 'draft',
        'is_published' => 0,
    ]);
});

test('slug is generated from judul when left empty', function () {
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->once()->andReturn([
            'public_id' => 'beritas/slug_auto',
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/slug_auto.jpg',
        ]);
    });

    $this->actingAs($this->penulis)->post(route('penulis.beritas.store'), [
        'judul' => 'Konservasi Hutan Lindung Bandung',
        'konten' => 'Kegiatan konservasi bersama warga sekitar.',
        'thumbnail' => UploadedFile::fake()->image('konservasi.jpg'),
        'status' => 'review',
    ])->assertRedirect(route('penulis.beritas.index'));

    $this->assertDatabaseHas('beritas', [
        'judul' => 'Konservasi Hutan Lindung Bandung',
        'slug' => 'konservasi-hutan-lindung-bandung',
        'status' => 'review',
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

    $this->actingAs($this->penulis)->post(route('penulis.beritas.store'), [
        'judul' => 'Ekspedisi Argopuro 2026',
        'konten' => 'Duplikat judul untuk menguji slug unik.',
        'thumbnail' => UploadedFile::fake()->image('dup.jpg'),
        'status' => 'draft',
    ])->assertRedirect(route('penulis.beritas.index'));

    $this->assertDatabaseHas('beritas', ['slug' => 'ekspedisi-argopuro-2026-1']);
});

test('validation prevents storing berita without judul konten or thumbnail', function () {
    $response = $this->actingAs($this->penulis)->post(route('penulis.beritas.store'), [
        'judul' => '',
        'konten' => '',
    ]);

    $response->assertSessionHasErrors(['judul', 'konten', 'thumbnail']);
    $this->assertDatabaseCount('beritas', 0);
});

test('validation rejects non image thumbnail', function () {
    $response = $this->actingAs($this->penulis)->post(route('penulis.beritas.store'), [
        'judul' => 'Berita Dengan File Salah',
        'konten' => 'Isi berita.',
        'thumbnail' => UploadedFile::fake()->create('dokumen.pdf', 120, 'application/pdf'),
        'status' => 'draft',
    ]);

    $response->assertSessionHasErrors(['thumbnail']);
    $this->assertDatabaseCount('beritas', 0);
});

// ---------------------------------------------------------------------------
// Edit & Update
// ---------------------------------------------------------------------------

test('penulis can view edit berita page for own berita', function () {
    $berita = makeBerita([
        'user_id' => $this->penulis->id,
        'status' => 'draft',
    ]);

    $response = $this->actingAs($this->penulis)->get(route('penulis.beritas.edit', $berita));

    $response->assertOk();
    $response->assertSee('Edit Berita');
    $response->assertSee('Ekspedisi Argopuro 2026');
});

test('penulis can update own berita without changing the thumbnail', function () {
    $berita = makeBerita([
        'user_id' => $this->penulis->id,
        'status' => 'draft',
    ]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldNotReceive('upload');
        $mock->shouldNotReceive('destroy');
    });

    $response = $this->actingAs($this->penulis)->put(route('penulis.beritas.update', $berita), [
        'judul' => 'Ekspedisi Argopuro 2026 Diperbarui',
        'slug' => 'ekspedisi-argopuro-2026',
        'konten' => 'Isi berita yang sudah diperbarui.',
        'tanggal_terbit' => '2026-11-05',
        'status' => 'review',
    ]);

    $response->assertRedirect(route('penulis.beritas.index'));

    $this->assertDatabaseHas('beritas', [
        'id' => $berita->id,
        'judul' => 'Ekspedisi Argopuro 2026 Diperbarui',
        'konten' => 'Isi berita yang sudah diperbarui.',
        'thumbnail_public_id' => 'beritas/sample1',
        'status' => 'review',
        'is_published' => 0,
    ]);
});

test('penulis can replace berita thumbnail and old cloudinary asset is destroyed', function () {
    $berita = makeBerita([
        'user_id' => $this->penulis->id,
        'thumbnail_public_id' => 'beritas/old_asset_to_delete',
        'status' => 'draft',
    ]);

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

    $response = $this->actingAs($this->penulis)->put(route('penulis.beritas.update', $berita), [
        'judul' => 'Ekspedisi Argopuro 2026',
        'slug' => 'ekspedisi-argopuro-2026',
        'konten' => 'Isi berita dengan gambar baru.',
        'thumbnail' => UploadedFile::fake()->image('baru.webp', 1600, 900),
        'tanggal_terbit' => '2026-11-01',
        'status' => 'review',
    ]);

    $response->assertRedirect(route('penulis.beritas.index'));

    $this->assertDatabaseHas('beritas', [
        'id' => $berita->id,
        'thumbnail_public_id' => 'beritas/brand_new_id',
        'thumbnail_url' => 'https://res.cloudinary.com/demo/image/upload/brand_new_id.jpg',
    ]);
});

// ---------------------------------------------------------------------------
// Delete & Status Workflow
// ---------------------------------------------------------------------------

test('admin can delete review or archived berita and its cloudinary asset is destroyed', function () {
    $berita = makeBerita([
        'thumbnail_public_id' => 'beritas/asset_to_destroy',
        'status' => 'archived',
    ]);

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

test('admin and staff can publish review berita and archive published berita', function () {
    $staff = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'staff',
    ]);

    $berita = makeBerita(['status' => 'review', 'is_published' => false]);

    $this->actingAs($staff)
        ->patch(route('staff.beritas.status', $berita), ['status' => 'published'])
        ->assertRedirect();

    $this->assertDatabaseHas('beritas', [
        'id' => $berita->id,
        'status' => 'published',
        'is_published' => 1,
    ]);

    $this->actingAs($this->user)
        ->patch(route('admin.beritas.status', $berita), ['status' => 'archived'])
        ->assertRedirect();

    $this->assertDatabaseHas('beritas', [
        'id' => $berita->id,
        'status' => 'archived',
        'is_published' => 0,
    ]);
});

test('penulis only sees own berita and can only delete draft', function () {
    $otherPenulis = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'penulis',
    ]);

    $ownDraft = makeBerita([
        'user_id' => $this->penulis->id,
        'judul' => 'Draft Penulis Ini',
        'slug' => 'draft-penulis-ini',
        'status' => 'draft',
    ]);

    $ownReview = makeBerita([
        'user_id' => $this->penulis->id,
        'judul' => 'Review Penulis Ini',
        'slug' => 'review-penulis-ini',
        'status' => 'review',
    ]);

    makeBerita([
        'user_id' => $otherPenulis->id,
        'judul' => 'Berita Penulis Lain',
        'slug' => 'berita-penulis-lain',
        'status' => 'draft',
    ]);

    $this->actingAs($this->penulis)
        ->get(route('penulis.beritas.index'))
        ->assertOk()
        ->assertSee('Draft Penulis Ini')
        ->assertDontSee('Berita Penulis Lain');

    $this->actingAs($this->penulis)
        ->delete(route('penulis.beritas.destroy', $ownReview))
        ->assertSessionHas('error');
    $this->assertDatabaseHas('beritas', ['id' => $ownReview->id]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) use ($ownDraft) {
        $mock->shouldReceive('destroy')->once()->with($ownDraft->thumbnail_public_id)->andReturn(true);
    });

    $this->actingAs($this->penulis)
        ->delete(route('penulis.beritas.destroy', $ownDraft))
        ->assertRedirect(route('penulis.beritas.index'));
    $this->assertDatabaseMissing('beritas', ['id' => $ownDraft->id]);
});

// ---------------------------------------------------------------------------
// Search & Filter
// ---------------------------------------------------------------------------

test('admin list supports search and status filter', function () {
    makeBerita(['judul' => 'Ekspedisi Argopuro 2026', 'slug' => 'argopuro', 'status' => 'published', 'is_published' => true]);
    makeBerita([
        'judul' => 'Konservasi Mangrove',
        'slug' => 'konservasi-mangrove',
        'konten' => 'Cerita penanaman mangrove di pesisir Bandung.',
        'status' => 'review',
        'is_published' => false,
    ]);

    $this->actingAs($this->user)
        ->get(route('admin.beritas.index', ['search' => 'Argopuro']))
        ->assertOk()
        ->assertSee('Ekspedisi Argopuro 2026')
        ->assertDontSee('Konservasi Mangrove');

    $this->actingAs($this->user)
        ->get(route('admin.beritas.index', ['status' => 'review']))
        ->assertOk()
        ->assertSee('Konservasi Mangrove')
        ->assertDontSee('Ekspedisi Argopuro 2026');
});

// ---------------------------------------------------------------------------
// Public Pages
// ---------------------------------------------------------------------------

test('public berita page only lists published news', function () {
    makeBerita(['judul' => 'Berita Terbit', 'slug' => 'berita-terbit', 'status' => 'published', 'is_published' => true]);
    makeBerita(['judul' => 'Berita Draf', 'slug' => 'berita-draf', 'status' => 'draft', 'is_published' => false]);

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
        'status' => 'published',
        'is_published' => true,
    ]);
    makeBerita([
        'judul' => 'Bakti Konservasi Lereng Semeru',
        'slug' => 'bakti-konservasi-lereng-semeru',
        'konten' => 'Aksi penanaman bibit di lereng Semeru.',
        'status' => 'published',
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
        'status' => 'draft',
        'is_published' => false,
    ]);

    $this->get(route('berita.show', 'berita-draf-rahasia'))->assertNotFound();
});

test('admin and staff can preview review and archived berita while guests cannot', function () {
    $staff = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'staff',
    ]);

    makeBerita([
        'user_id' => $this->penulis->id,
        'judul' => 'Berita Review Preview',
        'slug' => 'berita-review-preview',
        'status' => 'review',
        'is_published' => false,
    ]);

    makeBerita([
        'user_id' => $this->penulis->id,
        'judul' => 'Berita Archived Preview',
        'slug' => 'berita-archived-preview',
        'status' => 'archived',
        'is_published' => false,
    ]);

    makeBerita([
        'user_id' => $this->penulis->id,
        'judul' => 'Berita Draft Penulis',
        'slug' => 'berita-draft-penulis',
        'status' => 'draft',
        'is_published' => false,
    ]);

    // Guests get 404 for review & archived
    $this->get(route('berita.show', 'berita-review-preview'))->assertNotFound();
    $this->get(route('berita.show', 'berita-archived-preview'))->assertNotFound();

    // Admin & staff can preview review & archived, but not draft
    $this->actingAs($this->user)->get(route('berita.show', 'berita-review-preview'))->assertOk()->assertSee('Berita Review Preview');
    $this->actingAs($staff)->get(route('berita.show', 'berita-archived-preview'))->assertOk()->assertSee('Berita Archived Preview');
    $this->actingAs($this->user)->get(route('berita.show', 'berita-draft-penulis'))->assertNotFound();

    // Penulis owner can preview draft, review, and archived
    $this->actingAs($this->penulis)->get(route('berita.show', 'berita-draft-penulis'))->assertOk()->assertSee('Berita Draft Penulis');
    $this->actingAs($this->penulis)->get(route('berita.show', 'berita-review-preview'))->assertOk();
    $this->actingAs($this->penulis)->get(route('berita.show', 'berita-archived-preview'))->assertOk();
});

test('public berita page shows empty state when nothing published', function () {
    makeBerita(['status' => 'draft', 'is_published' => false]);

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

    $this->actingAs($this->penulis)->post(route('penulis.beritas.store'), [
        'judul' => 'Berita Yang Gagal Disimpan',
        'slug' => 'berita-yang-gagal-disimpan',
        'konten' => 'Konten contoh.',
        'thumbnail' => UploadedFile::fake()->image('gagal.jpg', 1600, 900),
        'tanggal_terbit' => '2026-11-10',
        'status' => 'draft',
    ])->assertSessionHas('error');

    $fail = false;

    $this->assertDatabaseCount('beritas', 0);
});

test('previous thumbnail is preserved and new upload is discarded when updating berita fails', function () {
    $berita = makeBerita([
        'user_id' => $this->penulis->id,
        'thumbnail_public_id' => 'beritas/old_keep',
        'status' => 'draft',
    ]);

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

    $this->actingAs($this->penulis)->put(route('penulis.beritas.update', $berita), [
        'judul' => 'Ekspedisi Argopuro 2026 Diperbarui',
        'slug' => 'ekspedisi-argopuro-2026',
        'konten' => 'Isi berita yang sudah diperbarui.',
        'thumbnail' => UploadedFile::fake()->image('baru.jpg'),
        'tanggal_terbit' => '2026-11-05',
        'status' => 'review',
    ])->assertSessionHas('error');

    $fail = false;

    $fresh = $berita->fresh();
    expect($fresh->judul)->toBe('Ekspedisi Argopuro 2026');
    expect($fresh->thumbnail_public_id)->toBe('beritas/old_keep');
});

test('berita record and its existing thumbnail stay intact when database delete fails', function () {
    $berita = makeBerita(['thumbnail_public_id' => 'beritas/keep_asset', 'status' => 'review']);

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
    $berita = makeBerita(['thumbnail_public_id' => 'beritas/asset_with_broken_destroy', 'status' => 'archived']);

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
    $berita = makeBerita([
        'user_id' => $this->penulis->id,
        'thumbnail_public_id' => 'beritas/old_unremovable',
        'status' => 'draft',
    ]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->once()->andReturn([
            'public_id' => 'beritas/new_after_old_unremovable',
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/new_after_old_unremovable.jpg',
        ]);
        $mock->shouldReceive('destroy')->once()->with('beritas/old_unremovable')->andReturn(false);
    });

    Log::spy();

    $this->actingAs($this->penulis)->put(route('penulis.beritas.update', $berita), [
        'judul' => 'Ekspedisi Argopuro 2026 Diperbarui',
        'slug' => 'ekspedisi-argopuro-2026',
        'konten' => 'Isi berita dengan thumbnail baru.',
        'thumbnail' => UploadedFile::fake()->image('baru.jpg'),
        'tanggal_terbit' => '2026-11-01',
        'status' => 'review',
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

test('guests cannot create, update, delete, or change status of berita', function () {
    $berita = makeBerita();

    $this->post(route('penulis.beritas.store'))->assertRedirect(route('login'));
    $this->put(route('penulis.beritas.update', $berita))->assertRedirect(route('login'));
    $this->delete(route('admin.beritas.destroy', $berita))->assertRedirect(route('login'));
    $this->patch(route('admin.beritas.status', $berita))->assertRedirect(route('login'));

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
        'status' => 'published',
        'is_published' => true,
    ]);

    $this->get(route('berita.show', 'ekspedisi-masa-depan'))->assertOk()->assertSee('Ekspedisi Masa Depan');
});
