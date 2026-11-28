<?php

use App\Models\Activity;
use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Gallery;
use App\Models\HeroBanner;
use App\Models\OrganizationProfile;
use App\Models\Pengurus;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('database seeder creates exactly 3 role accounts, varied dummy data, and remains idempotent', function () {
    Storage::fake('local');

    $this->seed();

    expect(OrganizationProfile::query()->count())->toBe(1);
    expect(User::query()->count())->toBe(3);
    expect(User::query()->where('role', 'admin')->where('status', true)->count())->toBe(1);
    expect(User::query()->where('role', 'staff')->where('status', true)->count())->toBe(1);
    expect(User::query()->where('role', 'penulis')->where('status', true)->count())->toBe(1);

    $domainTotal = Divisi::query()->count()
        + Pengurus::query()->count()
        + HeroBanner::query()->count()
        + Gallery::query()->count()
        + Activity::query()->count()
        + Berita::query()->count();

    expect($domainTotal)->toBeGreaterThanOrEqual(30);

    // Status variety across Activities & Berita
    foreach (['draft', 'review', 'published', 'archived'] as $status) {
        expect(Activity::query()->where('status', $status)->count())->toBeGreaterThanOrEqual(1);
        expect(Berita::query()->where('status', $status)->count())->toBeGreaterThanOrEqual(1);
    }

    // Period variety (2025 historical + current month + today)
    expect(Activity::query()->whereYear('event_date', 2025)->count())->toBeGreaterThanOrEqual(1);
    expect(Berita::query()->whereYear('tanggal_terbit', 2025)->count())->toBeGreaterThanOrEqual(1);
    expect(Activity::query()->whereDate('created_at', today())->count())->toBeGreaterThanOrEqual(1);
    expect(Berita::query()->whereDate('created_at', today())->count())->toBeGreaterThanOrEqual(1);

    // Supporting document testability: both with document and without document
    $withDoc = Activity::query()->whereNotNull('document_path')->get();
    $withoutDocCount = Activity::query()->whereNull('document_path')->count();
    expect($withDoc->count())->toBeGreaterThanOrEqual(1);
    expect($withoutDocCount)->toBeGreaterThanOrEqual(1);
    foreach ($withDoc as $activity) {
        Storage::disk('local')->assertExists((string) $activity->document_path);
    }

    // Foreign key relations are valid
    $penulisId = User::query()->where('role', 'penulis')->value('id');
    expect(Pengurus::query()->whereNotNull('divisi_id')->count())->toBeGreaterThan(0);
    expect(Pengurus::query()->with('divisi')->first()?->divisi)->not->toBeNull();
    expect(Activity::query()->where('user_id', $penulisId)->count())->toBe(Activity::query()->count());
    expect(Berita::query()->where('user_id', $penulisId)->count())->toBe(Berita::query()->count());

    $initialCounts = [
        'users' => User::query()->count(),
        'divisi' => Divisi::query()->count(),
        'pengurus' => Pengurus::query()->count(),
        'banners' => HeroBanner::query()->count(),
        'galleries' => Gallery::query()->count(),
        'activities' => Activity::query()->count(),
        'beritas' => Berita::query()->count(),
    ];

    // Re-running seeder must not fail or create duplicate data
    $this->seed();

    expect([
        'users' => User::query()->count(),
        'divisi' => Divisi::query()->count(),
        'pengurus' => Pengurus::query()->count(),
        'banners' => HeroBanner::query()->count(),
        'galleries' => Gallery::query()->count(),
        'activities' => Activity::query()->count(),
        'beritas' => Berita::query()->count(),
    ])->toBe($initialCounts);
});

test('all 3 seeded demo accounts can authenticate and access their role dashboards', function (string $email, string $expectedDashboardRoute) {
    Storage::fake('local');
    $this->seed();

    $this->post(route('login.store'), [
        'email' => $email,
        'password' => 'password123',
    ])->assertRedirect(route('dashboard'));

    $this->get(route('dashboard'))->assertRedirect(route($expectedDashboardRoute));
    $this->get(route($expectedDashboardRoute))->assertOk();
})->with([
    'admin demo account' => ['admin@semarrimba.test', 'admin.dashboard'],
    'staff demo account' => ['staff@semarrimba.test', 'staff.dashboard'],
    'penulis demo account' => ['penulis@semarrimba.test', 'penulis.dashboard'],
]);
