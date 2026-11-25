<?php

use App\Models\OrganizationProfile;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Mockery\MockInterface;
use RuntimeException;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
});

function makeOrganizationProfile(array $attributes = []): OrganizationProfile
{
    return OrganizationProfile::create(array_merge([
        'nama_organisasi' => 'SEMAR RIMBA',
        'deskripsi_singkat' => 'Deskripsi organisasi untuk pengujian.',
        'sejarah' => 'Sejarah organisasi untuk pengujian.',
        'visi' => 'Visi organisasi untuk pengujian.',
        'misi' => 'Misi A: Deskripsi misi A.',
        'alamat' => 'Alamat uji coba.',
        'email' => 'pengujian@example.com',
        'telepon' => '+62 812-0000-0000',
        'instagram_url' => 'https://instagram.com/contoh',
    ], $attributes));
}

// ---------------------------------------------------------------------------
// Authentication & Authorization
// ---------------------------------------------------------------------------

test('guests are redirected to login when accessing organization profile settings', function () {
    $this->get(route('admin.organization-profile.edit'))
        ->assertRedirect(route('login'));

    $this->put(route('admin.organization-profile.update'), [
        'nama_organisasi' => 'SEMAR RIMBA',
    ])->assertRedirect(route('login'));
});

test('authenticated users can open the organization profile settings page', function () {
    $response = $this->actingAs($this->user)
        ->get(route('admin.organization-profile.edit'));

    $response->assertOk();
    $response->assertSee('Kelola Profil dan Kontak');
    $response->assertSee('Profil Organisasi');
    $response->assertSee('Informasi Kontak');
});

// ---------------------------------------------------------------------------
// Update
// ---------------------------------------------------------------------------

test('admin can update organization profile information', function () {
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->never();
        $mock->shouldReceive('destroy')->never();
    });

    $response = $this->actingAs($this->user)
        ->put(route('admin.organization-profile.update'), [
            'nama_organisasi' => 'Organisasi Pengelola Test',
            'deskripsi_singkat' => 'Deskripsi singkat yang diperbarui.',
            'sejarah' => 'Sejarah organisasi yang diperbarui.',
            'visi' => 'Visi organisasi yang diperbarui.',
            'misi' => "Konservasi Nusantara: Mengelola lingkungan alam dengan bijak.",
            'alamat' => 'Alamat baru uji coba.',
            'email' => 'baru@example.com',
            'telepon' => '+62 812-1111-2222',
            'whatsapp' => '+62 812-3333-4444',
            'instagram_url' => 'https://instagram.com/baru',
            'tiktok_url' => 'https://tiktok.com/@baru',
            'google_maps_url' => 'https://maps.google.com/?q=baru',
        ]);

    $response->assertRedirect(route('admin.organization-profile.edit'));
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('organization_profiles', [
        'nama_organisasi' => 'Organisasi Pengelola Test',
        'deskripsi_singkat' => 'Deskripsi singkat yang diperbarui.',
        'email' => 'baru@example.com',
        'whatsapp' => '+62 812-3333-4444',
    ]);
});

test('admin can create the organization profile if none exists yet', function () {
    $this->assertDatabaseCount('organization_profiles', 0);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->never();
    });

    $response = $this->actingAs($this->user)
        ->put(route('admin.organization-profile.update'), [
            'nama_organisasi' => 'Organisasi Baru Pertama',
            'deskripsi_singkat' => 'Deskripsi awal.',
            'sejarah' => 'Sejarah awal.',
            'visi' => 'Visi awal.',
            'misi' => 'Misi awal: Deskripsi.',
            'alamat' => 'Alamat awal.',
        ]);

    $response->assertRedirect(route('admin.organization-profile.edit'));

    $this->assertDatabaseCount('organization_profiles', 1);
    $this->assertDatabaseHas('organization_profiles', [
        'nama_organisasi' => 'Organisasi Baru Pertama',
        'email' => null,
    ]);
});

test('updating twice does not create duplicate organization profile records', function () {
    makeOrganizationProfile();

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->never();
        $mock->shouldReceive('destroy')->never();
    });

    $this->actingAs($this->user)
        ->put(route('admin.organization-profile.update'), [
            'nama_organisasi' => 'Nama Organisasi Pertama',
            'deskripsi_singkat' => 'Deskripsi pertama.',
            'sejarah' => 'Sejarah pertama.',
            'visi' => 'Visi pertama.',
            'misi' => 'Misi pertama: Deskripsi.',
            'alamat' => 'Alamat pertama.',
        ]);

    $this->actingAs($this->user)
        ->put(route('admin.organization-profile.update'), [
            'nama_organisasi' => 'Nama Organisasi Kedua',
            'deskripsi_singkat' => 'Deskripsi kedua.',
            'sejarah' => 'Sejarah kedua.',
            'visi' => 'Visi kedua.',
            'misi' => 'Misi kedua: Deskripsi.',
            'alamat' => 'Alamat kedua.',
        ]);

    $this->assertDatabaseCount('organization_profiles', 1);
    $this->assertDatabaseHas('organization_profiles', [
        'nama_organisasi' => 'Nama Organisasi Kedua',
        'deskripsi_singkat' => 'Deskripsi kedua.',
    ]);
});

test('database unique constraint prevents more than one organization profile row', function () {
    makeOrganizationProfile();

    $this->expectException(QueryException::class);

    // Masukkan baris kedua langsung ke tabel. Unique index pada singleton_flag
    // (default 1) harus menolaknya, sehingga tabel tidak pernah berisi lebih dari satu baris.
    DB::table('organization_profiles')->insert([
        'nama_organisasi' => 'Organisasi Duplikat',
        'deskripsi_singkat' => 'Deskripsi duplikat.',
        'sejarah' => 'Sejarah duplikat.',
        'visi' => 'Visi duplikat.',
        'misi' => 'Misi duplikat.',
        'alamat' => 'Alamat duplikat.',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
});

test('non-singleton QueryException is returned as error not treated as duplicate', function () {
    $this->assertDatabaseCount('organization_profiles', 0);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->never();
        $mock->shouldReceive('destroy')->never();
    });

    OrganizationProfile::creating(function () {
        throw new QueryException('Check constraint failed on email format', []);
    });

    $response = $this->actingAs($this->user)
        ->from(route('admin.organization-profile.edit'))
        ->put(route('admin.organization-profile.update'), [
            'nama_organisasi' => 'Test',
            'deskripsi_singkat' => 'D.',
            'sejarah' => 'S.',
            'visi' => 'V.',
            'misi' => 'M.',
            'alamat' => 'A.',
        ]);

    $response->assertRedirect(route('admin.organization-profile.edit'));
    $response->assertSessionHas('error');
    $this->assertDatabaseCount('organization_profiles', 0);

    OrganizationProfile::flushEventListeners();
});

test('duplicate entry on other unique constraint is not treated as singleton conflict', function () {
    $this->assertDatabaseCount('organization_profiles', 0);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->never();
        $mock->shouldReceive('destroy')->never();
    });

    // Simulasikan duplicate entry pada unique constraint berbeda (misal: email_unique)
    OrganizationProfile::creating(function () {
        throw new QueryException(
            "Duplicate entry 'test@example.com' for key 'organization_profiles.email_unique'",
            []
        );
    });

    $response = $this->actingAs($this->user)
        ->from(route('admin.organization-profile.edit'))
        ->put(route('admin.organization-profile.update'), [
            'nama_organisasi' => 'Test',
            'deskripsi_singkat' => 'D.',
            'sejarah' => 'S.',
            'visi' => 'V.',
            'misi' => 'M.',
            'alamat' => 'A.',
        ]);

    $response->assertRedirect(route('admin.organization-profile.edit'));
    $response->assertSessionHas('error');
    $this->assertDatabaseCount('organization_profiles', 0);

    OrganizationProfile::flushEventListeners();
});

test('validation rejects invalid organization profile input', function () {
    $response = $this->actingAs($this->user)
        ->put(route('admin.organization-profile.update'), [
            'nama_organisasi' => '',
            'deskripsi_singkat' => '',
            'sejarah' => '',
            'visi' => '',
            'misi' => '',
            'alamat' => '',
            'email' => 'bukan-email',
            'instagram_url' => 'bukan-url',
            'logo' => UploadedFile::fake()->create('dokumen.pdf', 100),
        ]);

    $response->assertSessionHasErrors([
        'nama_organisasi',
        'deskripsi_singkat',
        'sejarah',
        'visi',
        'misi',
        'alamat',
        'email',
        'instagram_url',
        'logo',
    ]);
});

test('non-string input for nullable fields is handled safely without warning', function () {
    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->never();
    });

    $response = $this->actingAs($this->user)
        ->put(route('admin.organization-profile.update'), array_merge([
            'nama_organisasi' => 'SEMAR RIMBA',
            'deskripsi_singkat' => 'Deskripsi.',
            'sejarah' => 'Sejarah.',
            'visi' => 'Visi.',
            'misi' => 'Misi: Deskripsi.',
            'alamat' => 'Alamat.',
            'email' => ['bukan', 'string'],
            'telepon' => [12345],
        ]));

    $response->assertRedirect(route('admin.organization-profile.edit'));
    $this->assertDatabaseHas('organization_profiles', [
        'email' => null,
        'telepon' => null,
    ]);
});

test('validation rejects logo that is too large', function () {
    $response = $this->actingAs($this->user)
        ->put(route('admin.organization-profile.update'), array_merge([
            'nama_organisasi' => 'SEMAR RIMBA',
            'deskripsi_singkat' => 'Deskripsi.',
            'sejarah' => 'Sejarah.',
            'visi' => 'Visi.',
            'misi' => 'Misi: Deskripsi.',
            'alamat' => 'Alamat.',
        ], ['logo' => UploadedFile::fake()->image('logo.png', 800, 600)->size(5000)]));

    $response->assertSessionHasErrors('logo');
});

// ---------------------------------------------------------------------------
// Cloudinary Asset Lifecycle
// ---------------------------------------------------------------------------

test('uploaded logo is stored with the profile and previous asset is removed on replacement', function () {
    makeOrganizationProfile([
        'logo_url' => 'https://res.cloudinary.com/demo/image/upload/organization/old.jpg',
        'logo_public_id' => 'organization/old',
    ]);

    $this->mock(CloudinaryService::class, function (MockInterface $mock) {
        $mock->shouldReceive('upload')->once()->andReturn([
            'public_id' => 'organization/new-logo',
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/organization/new-logo.jpg',
        ]);
        $mock->shouldReceive('destroy')->once()->with('organization/old')->andReturn(true);
    });

    $file = UploadedFile::fake()->image('logo.png', 800, 600);

    $response = $this->actingAs($this->user)
        ->put(route('admin.organization-profile.update'), [
            'nama_organisasi' => 'SEMAR RIMBA',
            'deskripsi_singkat' => 'Deskripsi.',
            'sejarah' => 'Sejarah.',
            'visi' => 'Visi.',
            'misi' => 'Misi: Deskripsi.',
            'alamat' => 'Alamat.',
            'logo' => $file,
        ]);

    $response->assertRedirect(route('admin.organization-profile.edit'));

    $this->assertDatabaseHas('organization_profiles', [
        'logo_url' => 'https://res.cloudinary.com/demo/image/upload/organization/new-logo.jpg',
        'logo_public_id' => 'organization/new-logo',
    ]);
});

test('newly uploaded logo is discarded when database update fails', function () {
    makeOrganizationProfile();

    OrganizationProfile::saving(function () {
        throw new RuntimeException('simulasi kegagalan database');
    });

    try {
        $this->mock(CloudinaryService::class, function (MockInterface $mock) {
            $mock->shouldReceive('upload')->once()->andReturn([
                'public_id' => 'organization/rejected-logo',
                'secure_url' => 'https://res.cloudinary.com/demo/image/upload/organization/rejected-logo.jpg',
            ]);
            $mock->shouldReceive('destroy')->once()->with('organization/rejected-logo')->andReturn(true);
        });

        $response = $this->actingAs($this->user)
            ->put(route('admin.organization-profile.update'), array_merge([
                'nama_organisasi' => 'SEMAR RIMBA',
                'deskripsi_singkat' => 'Deskripsi.',
                'sejarah' => 'Sejarah.',
                'visi' => 'Visi.',
                'misi' => 'Misi: Deskripsi.',
                'alamat' => 'Alamat.',
            ], ['logo' => UploadedFile::fake()->image('logo.png', 800, 600)]));

        $response->assertSessionHas('error');
    } finally {
        OrganizationProfile::flushEventListeners();
    }

    $this->assertDatabaseMissing('organization_profiles', [
        'logo_public_id' => 'organization/rejected-logo',
    ]);
});

// ---------------------------------------------------------------------------
// Public Page Integration
// ---------------------------------------------------------------------------

test('public pages display organization profile data from the database', function () {
    makeOrganizationProfile([
        'nama_organisasi' => 'Organisasi Pengelola Test',
        'deskripsi_singkat' => 'Deskripsi uji coba organisasi.',
        'sejarah' => 'Sejarah uji coba organisasi.',
        'visi' => 'Visi uji coba organisasi.',
        'misi' => 'Konservasi Nusantara: Line pengujian misi.',
        'alamat' => 'Alamat uji coba.',
        'email' => 'publik@example.com',
        'telepon' => '+62 812-9999-0000',
        'instagram_url' => 'https://instagram.com/uji_contoh',
        'tiktok_url' => 'https://tiktok.com/@uji_contoh',
        'google_maps_url' => 'https://maps.google.com/?q=uji_contoh',
    ]);

    $home = $this->get('/');
    $home->assertOk();
    $home->assertSee('Organisasi Pengelola Test');
    $home->assertSee('Deskripsi uji coba organisasi.');
    $home->assertSee('Sejarah uji coba organisasi.');

    $tentang = $this->get(route('tentang'));
    $tentang->assertOk();
    $tentang->assertSee('Organisasi Pengelola Test');
    $tentang->assertSee('Visi uji coba organisasi.');
    $tentang->assertSee('Konservasi Nusantara');
    $tentang->assertSee('Line pengujian misi.');

    $medsos = $this->get(route('home'));
    $medsos->assertOk();
    $medsos->assertSee('https://instagram.com/uji_contoh');
});

test('public pages remain available when no organization profile data exists yet', function () {
    $this->assertDatabaseCount('organization_profiles', 0);

    $home = $this->get('/');
    $home->assertOk();
    $home->assertSee('TENTANG KAMI');
    $home->assertSee('Didirikan pada tanggal');

    $tentang = $this->get(route('tentang'));
    $tentang->assertOk();
    $tentang->assertSee('SEMAR RIMBA');
    $tentang->assertSee('Menjadikan SEMAR RIMBA');
    $tentang->assertSee('Empat Pilar Misi SEMAR RIMBA');

    $medsos = $this->get(route('home'));
    $medsos->assertOk();
});
