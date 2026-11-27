<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\OrganizationProfileController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ReportController;
use App\Models\HeroBanner;
use Illuminate\Support\Facades\Route;

Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/kegiatan', 'kegiatan')->name('kegiatan');
Route::get('/kegiatan/{activity:slug}', [KegiatanController::class, 'show'])->name('kegiatan.show');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita:slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/', function () {
    return view('welcome', [
        'heroBanners' => HeroBanner::active()->ordered()->get(),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $targetRoute = match (auth()->user()?->role) {
            'admin' => 'admin.dashboard',
            'penulis' => 'penulis.dashboard',
            default => 'staff.dashboard',
        };

        return redirect()->route($targetRoute);
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('users-management', [UserManagementController::class, 'index'])
            ->name('users-management.index');
        Route::post('users-management', [UserManagementController::class, 'add'])
            ->name('users-management.add');
        Route::put('users-management/{user}', [UserManagementController::class, 'edit'])
            ->name('users-management.edit');
        Route::patch('users-management/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])
            ->name('users-management.toggle-status');

        Route::patch('hero-banners/{heroBanner}/toggle', [HeroBannerController::class, 'toggleActive'])
            ->name('hero-banners.toggle');
        Route::resource('hero-banners', HeroBannerController::class)
            ->parameters(['hero-banners' => 'heroBanner'])
            ->except(['show']);

        Route::patch('activities/{activity}/status', [ActivityController::class, 'updateStatus'])
            ->whereNumber('activity')
            ->name('activities.status');
        Route::get('activities/{activity}/document', [ActivityController::class, 'downloadDocument'])
            ->whereNumber('activity')
            ->name('activities.document');
        Route::resource('activities', ActivityController::class)
            ->parameters(['activities' => 'activity'])
            ->whereNumber('activity')
            ->only(['index', 'destroy']);

        Route::patch('galleries/{gallery}/toggle', [GalleryController::class, 'toggleActive'])
            ->name('galleries.toggle');
        Route::resource('galleries', GalleryController::class)
            ->parameters(['galleries' => 'gallery'])
            ->except(['show']);

        Route::patch('beritas/{berita}/status', [AdminBeritaController::class, 'updateStatus'])
            ->whereNumber('berita')
            ->name('beritas.status');
        Route::resource('beritas', AdminBeritaController::class)
            ->parameters(['beritas' => 'berita'])
            ->whereNumber('berita')
            ->only(['index', 'destroy']);

        Route::patch('divisi/{divisi}/toggle', [DivisiController::class, 'toggleActive'])
            ->name('divisi.toggle');
        Route::resource('divisi', DivisiController::class)
            ->parameters(['divisi' => 'divisi'])
            ->except(['show']);

        Route::patch('pengurus/{pengurus}/toggle', [PengurusController::class, 'toggleActive'])
            ->name('pengurus.toggle');
        Route::resource('pengurus', PengurusController::class)
            ->parameters(['pengurus' => 'pengurus'])
            ->except(['show']);

        Route::get('laporan', [ReportController::class, 'index'])->name('reports.index');
        Route::get('laporan/export', [ReportController::class, 'export'])->name('reports.export');
    });

    Route::prefix('staff')->name('staff.')->middleware('role:staff')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'staff'])->name('dashboard');

        Route::patch('hero-banners/{heroBanner}/toggle', [HeroBannerController::class, 'toggleActive'])
            ->name('hero-banners.toggle');
        Route::resource('hero-banners', HeroBannerController::class)
            ->parameters(['hero-banners' => 'heroBanner'])
            ->except(['show']);

        Route::patch('activities/{activity}/status', [ActivityController::class, 'updateStatus'])
            ->whereNumber('activity')
            ->name('activities.status');
        Route::get('activities/{activity}/document', [ActivityController::class, 'downloadDocument'])
            ->whereNumber('activity')
            ->name('activities.document');
        Route::resource('activities', ActivityController::class)
            ->parameters(['activities' => 'activity'])
            ->whereNumber('activity')
            ->only(['index', 'destroy']);
        Route::patch('galleries/{gallery}/toggle', [GalleryController::class, 'toggleActive'])
            ->name('galleries.toggle');
        Route::resource('galleries', GalleryController::class)
            ->parameters(['galleries' => 'gallery'])
            ->except(['show']);
        Route::patch('beritas/{berita}/status', [AdminBeritaController::class, 'updateStatus'])
            ->whereNumber('berita')
            ->name('beritas.status');
        Route::resource('beritas', AdminBeritaController::class)
            ->parameters(['beritas' => 'berita'])
            ->whereNumber('berita')
            ->only(['index', 'destroy']);

        Route::get('organization-profile', [OrganizationProfileController::class, 'edit'])
            ->name('organization-profile.edit');
        Route::put('organization-profile', [OrganizationProfileController::class, 'update'])
            ->name('organization-profile.update');

        Route::patch('divisi/{divisi}/toggle', [DivisiController::class, 'toggleActive'])
            ->name('divisi.toggle');
        Route::resource('divisi', DivisiController::class)
            ->parameters(['divisi' => 'divisi'])
            ->except(['show']);

        Route::patch('pengurus/{pengurus}/toggle', [PengurusController::class, 'toggleActive'])
            ->name('pengurus.toggle');
        Route::resource('pengurus', PengurusController::class)
            ->parameters(['pengurus' => 'pengurus'])
            ->except(['show']);

        Route::get('laporan', [ReportController::class, 'index'])->name('reports.index');
        Route::get('laporan/export', [ReportController::class, 'export'])->name('reports.export');
    });

    Route::prefix('penulis')->name('penulis.')->middleware('role:penulis')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'penulis'])->name('dashboard');

        Route::patch('activities/{activity}/status', [ActivityController::class, 'updateStatus'])
            ->name('activities.status');
        Route::get('activities/{activity}/document', [ActivityController::class, 'downloadDocument'])
            ->whereNumber('activity')
            ->name('activities.document');
        Route::resource('activities', ActivityController::class)
            ->parameters(['activities' => 'activity'])
            ->except(['show']);

        Route::patch('beritas/{berita}/status', [AdminBeritaController::class, 'updateStatus'])
            ->name('beritas.status');
        Route::resource('beritas', AdminBeritaController::class)
            ->parameters(['beritas' => 'berita'])
            ->except(['show']);

        Route::get('laporan', [ReportController::class, 'index'])->name('reports.index');
        Route::get('laporan/export', [ReportController::class, 'export'])->name('reports.export');
    });
});

require __DIR__.'/settings.php';
