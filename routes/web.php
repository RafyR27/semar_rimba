<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\BeritaController;
use App\Models\Divisi;
use App\Models\HeroBanner;
use Illuminate\Support\Facades\Route;

Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/kegiatan', 'kegiatan')->name('kegiatan');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita:slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/', function () {
    return view('welcome', [
        'heroBanners' => HeroBanner::active()->ordered()->get(),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::patch('hero-banners/{heroBanner}/toggle', [HeroBannerController::class, 'toggleActive'])->name('hero-banners.toggle');
        Route::resource('hero-banners', HeroBannerController::class)->parameters(['hero-banners' => 'heroBanner'])->except(['show']);

        Route::patch('activities/{activity}/toggle', [ActivityController::class, 'toggleActive'])->name('activities.toggle');
        Route::resource('activities', ActivityController::class)->parameters(['activities' => 'activity'])->except(['show']);

        Route::patch('galleries/{gallery}/toggle', [GalleryController::class, 'toggleActive'])->name('galleries.toggle');
        Route::resource('galleries', GalleryController::class)->parameters(['galleries' => 'gallery'])->except(['show']);

        Route::patch('beritas/{berita}/toggle', [AdminBeritaController::class, 'togglePublish'])->name('beritas.toggle');
        Route::resource('beritas', AdminBeritaController::class)->parameters(['beritas' => 'berita'])->except(['show']);

        Route::patch('divisi/{divisi}/toggle', [DivisiController::class, 'toggleActive'])->name('divisi.toggle');
        Route::resource('divisi', DivisiController::class)->except(['show']);

        Route::patch('pengurus/{pengurus}/toggle', [PengurusController::class, 'toggleActive'])->name('pengurus.toggle');
        Route::resource('pengurus', PengurusController::class)->except(['show']);
    });
});

require __DIR__.'/settings.php';
