<?php

use App\Models\Activity;
use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Gallery;
use App\Models\HeroBanner;
use App\Models\Pengurus;
use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    $this->get(route('staff.dashboard'))->assertRedirect(route('login'));
    $this->get(route('penulis.dashboard'))->assertRedirect(route('login'));
});

test('authenticated users are redirected to their role dashboard and blocked from other roles', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $staff = User::factory()->create(['role' => 'staff']);
    $penulis = User::factory()->create(['role' => 'penulis']);

    $this->actingAs($admin)->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));
    $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    $this->actingAs($admin)->get(route('staff.dashboard'))->assertForbidden();
    $this->actingAs($admin)->get(route('penulis.dashboard'))->assertForbidden();

    $this->actingAs($staff)->get(route('dashboard'))->assertRedirect(route('staff.dashboard'));
    $this->actingAs($staff)->get(route('staff.dashboard'))->assertOk();
    $this->actingAs($staff)->get(route('admin.dashboard'))->assertForbidden();
    $this->actingAs($staff)->get(route('penulis.dashboard'))->assertForbidden();

    $this->actingAs($penulis)->get(route('dashboard'))->assertRedirect(route('penulis.dashboard'));
    $this->actingAs($penulis)->get(route('penulis.dashboard'))->assertOk();
    $this->actingAs($penulis)->get(route('admin.dashboard'))->assertForbidden();
    $this->actingAs($penulis)->get(route('staff.dashboard'))->assertForbidden();
});

test('admin dashboard displays actual database statistics for users, editorial review, and organization', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => true]);
    User::factory()->create(['role' => 'staff', 'status' => true]);
    $penulis = User::factory()->create(['role' => 'penulis', 'status' => true]);
    User::factory()->create(['role' => 'penulis', 'status' => false]);

    $divisiAktif = Divisi::create(['nama' => 'Gunung Hutan', 'deskripsi' => 'Divisi gunung hutan', 'is_active' => true]);
    Divisi::create(['nama' => 'Konservasi Nonaktif', 'deskripsi' => 'Arsip divisi', 'is_active' => false]);

    Pengurus::create([
        'nama' => 'Raka Rimba',
        'nim' => '2024001',
        'jabatan' => 'Ketua Umum',
        'divisi_id' => $divisiAktif->id,
        'angkatan' => '2024',
        'is_active' => true,
    ]);
    Pengurus::create([
        'nama' => 'Alumni Nonaktif',
        'nim' => '2022001',
        'jabatan' => 'Anggota',
        'divisi_id' => $divisiAktif->id,
        'angkatan' => '2022',
        'is_active' => false,
    ]);

    Gallery::factory()->count(2)->create(['is_active' => true]);
    Gallery::factory()->inactive()->create();

    HeroBanner::factory()->create(['is_active' => true]);
    HeroBanner::factory()->inactive()->create();

    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Review Admin',
        'status' => 'review',
        'is_active' => false,
    ]);
    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Published Admin',
        'status' => 'published',
        'is_active' => true,
    ]);
    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Draft Rahasia',
        'status' => 'draft',
        'is_active' => false,
    ]);

    Berita::factory()->count(2)->create([
        'user_id' => $penulis->id,
        'status' => 'review',
        'is_published' => false,
    ]);
    Berita::factory()->create([
        'user_id' => $penulis->id,
        'judul' => 'Berita Archived Admin',
        'status' => 'archived',
        'is_published' => false,
    ]);
    Berita::factory()->draft()->create([
        'user_id' => $penulis->id,
        'judul' => 'Berita Draft Rahasia',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertViewIs('dashboard.admin')
        ->assertViewHas('userStats', [
            'total' => 4,
            'active' => 3,
            'inactive' => 1,
            'by_role' => [
                'admin' => 1,
                'staff' => 1,
                'penulis' => 2,
            ],
        ])
        ->assertViewHas('reviewQueue', [
            'total' => 3,
            'activities' => 1,
            'beritas' => 2,
        ])
        ->assertViewHas('organizationStats', [
            'divisi_total' => 2,
            'divisi_active' => 1,
            'pengurus_total' => 2,
            'pengurus_active' => 1,
            'gallery_total' => 3,
            'gallery_active' => 2,
            'banner_total' => 2,
            'banner_active' => 1,
        ])
        ->assertSee('Dashboard Admin')
        ->assertSee('Kegiatan Review Admin')
        ->assertSee('Berita Archived Admin')
        ->assertDontSee('Kegiatan Draft Rahasia')
        ->assertDontSee('Berita Draft Rahasia');
});

test('staff dashboard displays operational metrics without administrative user management data', function () {
    $staff = User::factory()->create(['role' => 'staff', 'status' => true]);
    $penulis = User::factory()->create(['role' => 'penulis', 'status' => true]);

    Divisi::create(['nama' => 'Panjat Tebing', 'deskripsi' => 'Divisi panjat', 'is_active' => true]);
    Pengurus::create([
        'nama' => 'Nadia Tebing',
        'nim' => '2024002',
        'jabatan' => 'Koordinator',
        'angkatan' => '2024',
        'is_active' => true,
    ]);
    Gallery::factory()->create(['is_active' => true]);
    HeroBanner::factory()->create(['is_active' => true]);

    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Ekspedisi Menunggu Review Staff',
        'status' => 'review',
        'is_active' => false,
    ]);
    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Draft Tersembunyi Dari Staff',
        'status' => 'draft',
        'is_active' => false,
    ]);
    Berita::factory()->create([
        'user_id' => $penulis->id,
        'judul' => 'Berita Review Staff',
        'status' => 'review',
        'is_published' => false,
    ]);

    $response = $this->actingAs($staff)->get(route('staff.dashboard'));

    $response->assertOk()
        ->assertViewIs('dashboard.staff')
        ->assertViewMissing('userStats')
        ->assertViewHas('reviewQueue', [
            'total' => 2,
            'activities' => 1,
            'beritas' => 1,
        ])
        ->assertSee('Dashboard Staff')
        ->assertSee('Ekspedisi Menunggu Review Staff')
        ->assertSee('Berita Review Staff')
        ->assertDontSee('Draft Tersembunyi Dari Staff')
        ->assertDontSee('Total Pengguna')
        ->assertDontSee('Pengguna per Role');
});

test('penulis dashboard only counts and lists content owned by the authenticated penulis', function () {
    $penulis = User::factory()->create(['role' => 'penulis', 'status' => true]);
    $otherPenulis = User::factory()->create(['role' => 'penulis', 'status' => true]);

    // Konten milik penulis yang login (dibuat hari ini & bulan lalu)
    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Draft Milik Saya',
        'status' => 'draft',
        'is_active' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Review Bulan Ini',
        'status' => 'review',
        'is_active' => false,
        'created_at' => now()->startOfMonth(),
        'updated_at' => now()->startOfMonth(),
    ]);
    Activity::factory()->create([
        'user_id' => $penulis->id,
        'title' => 'Kegiatan Published Bulan Lalu',
        'status' => 'published',
        'is_active' => true,
        'created_at' => now()->subMonthNoOverflow(),
        'updated_at' => now()->subMonthNoOverflow(),
    ]);

    Berita::factory()->create([
        'user_id' => $penulis->id,
        'judul' => 'Berita Draft Hari Ini',
        'status' => 'draft',
        'is_published' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    Berita::factory()->create([
        'user_id' => $penulis->id,
        'judul' => 'Berita Archived Bulan Lalu',
        'status' => 'archived',
        'is_published' => false,
        'created_at' => now()->subMonthNoOverflow(),
        'updated_at' => now()->subMonthNoOverflow(),
    ]);

    // Konten milik penulis lain (tidak boleh masuk statistik maupun daftar terbaru)
    Activity::factory()->count(4)->create([
        'user_id' => $otherPenulis->id,
        'title' => 'Kegiatan Milik Penulis Lain',
        'status' => 'published',
        'is_active' => true,
        'created_at' => now(),
    ]);
    Berita::factory()->count(3)->create([
        'user_id' => $otherPenulis->id,
        'judul' => 'Berita Milik Penulis Lain',
        'status' => 'review',
        'is_published' => false,
        'created_at' => now(),
    ]);

    $response = $this->actingAs($penulis)->get(route('penulis.dashboard'));

    $response->assertOk()
        ->assertViewIs('dashboard.penulis')
        ->assertViewHas('activityStats', [
            'draft' => 1,
            'review' => 1,
            'published' => 1,
            'archived' => 0,
            'total' => 3,
        ])
        ->assertViewHas('beritaStats', [
            'draft' => 1,
            'review' => 0,
            'published' => 0,
            'archived' => 1,
            'total' => 2,
        ])
        ->assertViewHas('combinedStats', [
            'draft' => 2,
            'review' => 1,
            'published' => 1,
            'archived' => 1,
            'total' => 5,
        ])
        ->assertViewHas('periodStats', [
            'today_total' => 2,
            'today_activities' => 1,
            'today_beritas' => 1,
            'month_total' => 3,
            'month_activities' => 2,
            'month_beritas' => 1,
        ])
        ->assertSee('Dashboard Penulis')
        ->assertSee('Kegiatan Draft Milik Saya')
        ->assertSee('Berita Draft Hari Ini')
        ->assertDontSee('Kegiatan Milik Penulis Lain')
        ->assertDontSee('Berita Milik Penulis Lain')
        ->assertDontSee('Kelola Pengguna');
});
