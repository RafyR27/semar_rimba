<?php

use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;

test('cloudinary service reports not configured when CLOUDINARY_URL is empty', function () {
    config([
        'cloudinary.url' => null,
    ]);

    $service = new CloudinaryService;

    expect($service->isConfigured())->toBeFalse();
});

test('cloudinary service reports configured when CLOUDINARY_URL is provided', function () {
    config([
        'cloudinary.url' => 'cloudinary://123456789:abcdef987654@demo_cloud',
    ]);

    $service = new CloudinaryService;

    expect($service->isConfigured())->toBeTrue();
});

test('cloudinary service reports not configured when CLOUDINARY_URL has invalid format', function () {
    config([
        'cloudinary.url' => 'invalid-url-format',
    ]);

    $service = new CloudinaryService;

    expect($service->isConfigured())->toBeFalse();
});

test('attempting upload without configuration throws runtime exception', function () {
    config([
        'cloudinary.url' => null,
    ]);

    $service = new CloudinaryService;
    $file = UploadedFile::fake()->image('test.jpg');

    expect(fn () => $service->upload($file))
        ->toThrow(RuntimeException::class, 'Cloudinary belum dikonfigurasi');
});

test('destroy returns false safely for null or empty public id', function () {
    $service = new CloudinaryService;

    expect($service->destroy(null))->toBeFalse();
    expect($service->destroy(''))->toBeFalse();
});
