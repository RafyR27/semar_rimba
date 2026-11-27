<?php

namespace Database\Seeders;

use App\Models\OrganizationProfile;
use Illuminate\Database\Seeder;

class OrganizationProfileSeeder extends Seeder
{
    /**
     * Seed the single organization profile record with the content that was
     * previously hardcoded on the public pages.
     */
    public function run(): void
    {
        if (OrganizationProfile::query()->exists()) {
            return;
        }

        OrganizationProfile::create([
            'nama_organisasi' => 'SEMAR RIMBA',
            'deskripsi_singkat' => 'Semar Rimba menghimpun mahasiswa Politeknik STIA LAN Bandung dalam dedikasi penjelajahan alam terbuka, kesiapsiagaan kemanusiaan, dan pelestarian ekologi nusantara.',
            'sejarah' => 'Didirikan pada tanggal 17 Agustus 1998 di kampus Politeknik STIA LAN Bandung, Unit Kegiatan Mahasiswa Pecinta Alam SEMAR RIMBA hadir sebagai wahana pembentukan karakter mandiri dan kepemimpinan rimbawan muda. Organisasi ini memadukan kedisiplinan akademis dengan keahlian teknis eksplorasi rimba raya Indonesia, operasi kemanusiaan (SAR), dan advokasi kelestarian ekologi.',
            'visi' => '“Menjadikan SEMAR RIMBA sebagai wadah pembinaan mahasiswa Politeknik STIA LAN Bandung yang berkarakter tangguh, profesional dalam keahlian kealaman, serta terdepan dalam aksi kemanusiaan dan pelestarian lingkungan hidup.”',
            'misi' => implode("\n", [
                'Kaderisasi & Pembinaan Karakter Mandiri: Menyelenggarakan pendidikan dan latihan bertahap yang membentuk kedisiplinan, integritas korsa, serta kepemimpinan lapangan bagi mahasiswa Politeknik STIA LAN Bandung.',
                'Penguasaan Kompetensi Teknis Lintas Matra: Mengembangkan keahlian operasional dan standar keselamatan (SOP) pada matra Gunung Hutan, Panjat Tebing, Susur Gua, dan Arung Jeram melalui riset serta ekspedisi berkala.',
                'Kesiapsiagaan SAR & Pengabdian Kemanusiaan: Membangun kapasitas respons cepat dalam operasi pencarian dan pertolongan (Search and Rescue) serta bakti sosial bagi masyarakat di wilayah rawan bencana.',
                'Advokasi & Konservasi Ekologi Nusantara: Melakukan aksi nyata pelestarian hutan, rehabilitasi daerah aliran sungai, edukasi lingkungan, serta kampanye pendakian nir-sampah (zero waste expedition).',
            ]),
            'alamat' => "Gedung UKM Kampus Politeknik STIA LAN Bandung\nJl. Hayam Wuruk No. 34, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115",
            'email' => 'sekretariat@semarrimba-lan.org',
            'telepon' => '+62 (022) 423-7484',
            'whatsapp' => null,
            'instagram_url' => 'https://instagram.com/semarrimba_lan',
            'tiktok_url' => null,
            'google_maps_url' => null,
            'logo_url' => null,
            'logo_public_id' => null,
        ]);
    }
}
