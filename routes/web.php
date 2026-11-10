<?php

use App\Http\Controllers\Admin\HeroBannerController;
use App\Models\HeroBanner;
use Illuminate\Support\Facades\Route;

Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/kegiatan', 'kegiatan')->name('kegiatan');
Route::get('/', function () {
    $heroBanners = HeroBanner::active()->ordered()->get();

    return view('welcome', [
        'heroBanners' => $heroBanners,
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::patch('hero-banners/{heroBanner}/toggle', [HeroBannerController::class, 'toggleActive'])
            ->name('hero-banners.toggle');
        Route::resource('hero-banners', HeroBannerController::class)
            ->parameters(['hero-banners' => 'heroBanner'])
            ->except(['show']);
    });
});

require __DIR__.'/settings.php';
