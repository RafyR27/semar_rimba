<?php

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('tentang page returns a successful response', function () {
    $response = $this->get(route('tentang'));

    $response->assertOk();
});

test('kegiatan page returns a successful response', function () {
    $response = $this->get(route('kegiatan'));

    $response->assertOk()
        ->assertSee('Katalog Kegiatan, Ekspedisi Medan, dan Pengabdian Ekologi')
        ->assertSee('Sorotan Kegiatan Utama Organisasi')
        ->assertSee('Kaderisasi & Pembinaan Rutin Rimbawan')
        ->assertSee('Kegiatan Ekspedisi & Operasional Empat Matra')
        ->assertSee('Bakti Lingkungan, Konservasi Ekologi & Kesiapsiagaan SAR')
        ->assertSee('Arsip & Rekam Jejak Kegiatan Terdokumentasi');
});
