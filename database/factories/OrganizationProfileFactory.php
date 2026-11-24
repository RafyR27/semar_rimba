<?php

namespace Database\Factories;

use App\Models\OrganizationProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrganizationProfile>
 */
class OrganizationProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_organisasi' => 'SEMAR RIMBA',
            'deskripsi_singkat' => 'Semar Rimba menghimpun mahasiswa Politeknik STIA LAN Bandung dalam dedikasi penjelajahan alam terbuka, kesiapsiagaan kemanusiaan, dan pelestarian ekologi nusantara.',
            'sejarah' => 'Didirikan pada tanggal 17 Agustus 1998 di kampus Politeknik STIA LAN Bandung, Unit Kegiatan Mahasiswa Pecinta Alam SEMAR RIMBA hadir sebagai wahana pembentukan karakter mandiri dan kepemimpinan rimbawan muda.',
            'visi' => 'Menjadikan SEMAR RIMBA sebagai wadah pembinaan mahasiswa Politeknik STIA LAN Bandung yang berkarakter tangguh, profesional dalam keahlian kealaman, serta terdepan dalam aksi kemanusiaan dan pelestarian lingkungan hidup.',
            'misi' => "Kaderisasi & Pembinaan Karakter Mandiri\nPenguasaan Kompetensi Teknis Lintas Matra\nKesiapsiagaan SAR & Pengabdian Kemanusiaan\nAdvokasi & Konservasi Ekologi Nusantara",
            'alamat' => 'Gedung UKM Kampus Politeknik STIA LAN Bandung, Jl. Hayam Wuruk No. 34, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115',
            'email' => 'sekretariat@semarrimba-lan.org',
            'telepon' => '+62 (022) 423-7484',
            'whatsapp' => '+62 812-0000-0000',
            'instagram_url' => 'https://instagram.com/semarrimba_lan',
            'tiktok_url' => 'https://tiktok.com/@semarrimba_lan',
            'google_maps_url' => 'https://maps.google.com/?q=Politeknik+STIA+LAN+Bandung',
            'logo_url' => 'https://res.cloudinary.com/demo/image/upload/semar-rimba-logo.png',
            'logo_public_id' => 'organization/semar-rimba-logo',
        ];
    }
}
