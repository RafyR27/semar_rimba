<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::get('/health', static function (): JsonResponse {
    return response()->json(['status' => 'ok']);
});

require __DIR__.'/settings.php';
