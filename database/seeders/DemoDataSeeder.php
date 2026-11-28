<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Gallery;
use App\Models\HeroBanner;
use App\Models\Pengurus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed idempotent demo accounts and varied SEMAR RIMBA simulation data.
     */
    public function run(): void
    {
        $users = $this->seedDemoUsers();
        $divisis = $this->seedDivisis();
        $this->seedPengurus($divisis);
        $this->seedHeroBanners();
        $this->seedGalleries();
        $this->seedActivities($users['penulis']);
        $this->seedBeritas($users['penulis']);
    }

    /**
     * @return array{admin: User, staff: User, penulis: User}
     */
    protected function seedDemoUsers(): array
    {
        User::query()
            ->whereIn('email', ['penulis2@semarrimba.test', 'alumni.staff@semarrimba.test'])
            ->delete();

        $demoAccounts = [
            'admin' => [
                'name' => 'Admin Semar Rimba',
                'email' => 'admin@semarrimba.test',
                'role' => 'admin',
                'status' => true,
            ],
            'staff' => [
                'name' => 'Staff Editorial',
                'email' => 'staff@semarrimba.test',
                'role' => 'staff',
                'status' => true,
            ],
            'penulis' => [
                'name' => 'Penulis Rimba',
                'email' => 'penulis@semarrimba.test',
                'role' => 'penulis',
                'status' => true,
            ],
        ];

        $seeded = [];
        $hashedPassword = Hash::make('password123');

        foreach ($demoAccounts as $key => $account) {
            $seeded[$key] = User::query()->updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'role' => $account['role'],
                    'status' => $account['status'],
                    'email_verified_at' => now(),
                    'password' => $hashedPassword,
                ]
            );
        }

        return $seeded;
    }

    /**
     * @return array<string, Divisi>
     */
    protected function seedDivisis(): array
    {
        $definitions = [
            [
                'nama' => 'Gunung Hutan',
                'deskripsi' => 'Matra penjelajahan rimba, navigasi darat, dan manajemen ekspedisi pegunungan tropis.',
                'is_active' => true,
            ],
            [
                'nama' => 'Panjat Tebing',
                'deskripsi' => 'Matra teknik pemanjatan tebing alam, pengamanan tali ganda, dan pemetaan jalur panjat.',
                'is_active' => true,
            ],
            [
                'nama' => 'Susur Gua',
                'deskripsi' => 'Matra speleologi, pemetaan lorong karst, dan penerapan single rope technique (SRT).',
                'is_active' => true,
            ],
            [
                'nama' => 'Arung Jeram',
                'deskripsi' => 'Matra pengarungan sungai arus deras, river rescue, serta pembacaan karakteristik jeram.',
                'is_active' => true,
            ],
            [
                'nama' => 'SAR & Kemanusiaan',
                'deskripsi' => 'Biro kesiapsiagaan operasi pencarian, evakuasi medan terjal, dan tanggap darurat bencana.',
                'is_active' => true,
            ],
            [
                'nama' => 'Konservasi & Litbang',
                'deskripsi' => 'Biro observasi ekologi, penghijauan daerah tangkapan air, dan kampanye pendakian nir-sampah.',
                'is_active' => true,
            ],
            [
                'nama' => 'Dokumentasi Lapangan (Arsip)',
                'deskripsi' => 'Arsip unit dokumentasi teknis sebelum dilebur ke dalam biro penelitian dan pengembangan.',
                'is_active' => false,
            ],
        ];

        $result = [];
        foreach ($definitions as $item) {
            $attributes = Divisi::factory()->make($item)->toArray();

            $result[$item['nama']] = Divisi::query()->updateOrCreate(
                ['nama' => $item['nama']],
                $attributes
            );
        }

        return $result;
    }

    /**
     * @param  array<string, Divisi>  $divisis
     */
    protected function seedPengurus(array $divisis): void
    {
        $records = [
            ['nama' => 'Raka Pratama', 'nim' => 'SR-2023001', 'jabatan' => 'Ketua Umum', 'divisi' => 'Gunung Hutan', 'angkatan' => '2023', 'is_active' => true],
            ['nama' => 'Dimas Nugraha', 'nim' => 'SR-2023002', 'jabatan' => 'Wakil Ketua Operasional', 'divisi' => 'SAR & Kemanusiaan', 'angkatan' => '2023', 'is_active' => true],
            ['nama' => 'Nadya Larasati', 'nim' => 'SR-2023003', 'jabatan' => 'Sekretaris Jenderal', 'divisi' => 'Konservasi & Litbang', 'angkatan' => '2023', 'is_active' => true],
            ['nama' => 'Salsa Nabila', 'nim' => 'SR-2024001', 'jabatan' => 'Bendahara Umum', 'divisi' => 'Konservasi & Litbang', 'angkatan' => '2024', 'is_active' => true],
            ['nama' => 'Aris Gunawan', 'nim' => 'SR-2024002', 'jabatan' => 'Koordinator Gunung Hutan', 'divisi' => 'Gunung Hutan', 'angkatan' => '2024', 'is_active' => true],
            ['nama' => 'Gilang Mahesa', 'nim' => 'SR-2024003', 'jabatan' => 'Koordinator Panjat Tebing', 'divisi' => 'Panjat Tebing', 'angkatan' => '2024', 'is_active' => true],
            ['nama' => 'Fajar Hidayat', 'nim' => 'SR-2024004', 'jabatan' => 'Koordinator Susur Gua', 'divisi' => 'Susur Gua', 'angkatan' => '2024', 'is_active' => true],
            ['nama' => 'Reza Perkasa', 'nim' => 'SR-2024005', 'jabatan' => 'Koordinator Arung Jeram', 'divisi' => 'Arung Jeram', 'angkatan' => '2024', 'is_active' => true],
            ['nama' => 'Bima Santoso', 'nim' => 'SR-2025001', 'jabatan' => 'Staf Logistik & Peralatan', 'divisi' => 'SAR & Kemanusiaan', 'angkatan' => '2025', 'is_active' => true],
            ['nama' => 'Tiara Kusuma', 'nim' => 'SR-2025002', 'jabatan' => 'Staf Edukasi Konservasi', 'divisi' => 'Konservasi & Litbang', 'angkatan' => '2025', 'is_active' => true],
            ['nama' => 'Bagas Wibowo', 'nim' => 'SR-2022001', 'jabatan' => 'Dewan Penasihat Teknis', 'divisi' => 'Gunung Hutan', 'angkatan' => '2022', 'is_active' => false],
            ['nama' => 'Laras Puspita', 'nim' => 'SR-2022002', 'jabatan' => 'Alumni Koordinator Gua', 'divisi' => 'Dokumentasi Lapangan (Arsip)', 'angkatan' => '2022', 'is_active' => false],
        ];

        foreach ($records as $record) {
            $divisiId = $divisis[$record['divisi']]->id ?? null;

            $attributes = Pengurus::factory()->make([
                'nama' => $record['nama'],
                'nim' => $record['nim'],
                'jabatan' => $record['jabatan'],
                'divisi_id' => $divisiId,
                'angkatan' => $record['angkatan'],
                'is_active' => $record['is_active'],
            ])->toArray();

            Pengurus::query()->updateOrCreate(
                ['nim' => $record['nim']],
                $attributes
            );
        }
    }

    protected function seedHeroBanners(): void
    {
        $banners = [
            [
                'title' => 'Ekspedisi Rimba Nusantara',
                'subtitle' => 'UKM Pecinta Alam Politeknik STIA LAN Bandung',
                'description' => 'Menjelajahi alam terbuka dengan disiplin keselamatan, observasi ekologi, dan pengabdian kemanusiaan.',
                'button_text' => 'Pelajari Profil Kami',
                'button_url' => '#tentang',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Pendidikan & Latihan Dasar Rimbawan',
                'subtitle' => 'Pembentukan Karakter Tangguh & Terampil',
                'description' => 'Pembinaan bertahap di empat matra lapangan: Gunung Hutan, Panjat Tebing, Susur Gua, dan Arung Jeram.',
                'button_text' => 'Lihat Kegiatan',
                'button_url' => '#kegiatan',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Aksi Tanggap Darurat & Konservasi',
                'subtitle' => 'Tabah, Terampil, Tangguh, Lestari',
                'description' => 'Berpartisipasi aktif dalam simulasi SAR, aksi bersih lingkungan, dan rehabilitasi daerah aliran sungai.',
                'button_text' => 'Jelajahi Divisi',
                'button_url' => '#divisi',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'Arsip Kampanye Rekrutmen Terdahulu',
                'subtitle' => 'Banner Musiman (Nonaktif)',
                'description' => 'Contoh banner nonaktif untuk pengujian status tayang pada halaman pengelolaan Hero Banner.',
                'button_text' => null,
                'button_url' => null,
                'is_active' => false,
                'order' => 4,
            ],
        ];

        foreach ($banners as $banner) {
            $attributes = HeroBanner::factory()->make($banner)->toArray();

            HeroBanner::query()->firstOrCreate(
                ['title' => $banner['title']],
                $attributes
            );
        }
    }

    protected function seedGalleries(): void
    {
        $galleries = [
            ['title' => 'Navigasi Kompas & Peta Jalur Gunung Ciremai', 'category' => 'Gunung Hutan', 'description' => 'Dokumentasi latihan penentuan azimuth dan pembacaan kontur jalur pendakian.', 'is_active' => true, 'order' => 1],
            ['title' => 'Latihan Multi-Pitch Tebing Citatah', 'category' => 'Panjat Tebing', 'description' => 'Simulasi pemasangan pengaman sisipan dan sistem penambatan tali di tebing kapur.', 'is_active' => true, 'order' => 2],
            ['title' => 'Eksplorasi Gua Pawon Kawasan Karst', 'category' => 'Susur Gua', 'description' => 'Dokumentasi teknik lintasan vertikal menggunakan peralatan SRT standar.', 'is_active' => true, 'order' => 3],
            ['title' => 'Pengarungan Sungai Citarik Sukabumi', 'category' => 'Arung Jeram', 'description' => 'Latihan koordinasi dayung tim dan penyelamatan arus deras.', 'is_active' => true, 'order' => 4],
            ['title' => 'Penghijauan 1000 Bibit Pohon Hulu Citarum', 'category' => 'Konservasi', 'description' => 'Aksi penanaman pohon endemik bersama komunitas pelestari daerah aliran sungai.', 'is_active' => true, 'order' => 5],
            ['title' => 'Simulasi Evakuasi Medan Terjal SAR', 'category' => 'Gunung Hutan', 'description' => 'Latihan tandu darurat dan sistem angkut beban pada lereng curam.', 'is_active' => true, 'order' => 6],
            ['title' => 'Bivak Alam & Manajemen Survival Hutan Rahong', 'category' => 'Gunung Hutan', 'description' => 'Praktik pendirian tempat berlindung darurat dengan perlengkapan minimal.', 'is_active' => true, 'order' => 7],
            ['title' => 'Pemetaan Lorong Gua Kapur Padalarang', 'category' => 'Susur Gua', 'description' => 'Pengukuran jarak, kemiringan, dan sketsa penampang lorong bawah tanah.', 'is_active' => true, 'order' => 8],
            ['title' => 'Aksi Bersih Sampah Jalur Pendakian Papandayan', 'category' => 'Konservasi', 'description' => 'Kegiatan turun gunung membawa kembali sampah anorganik dari pos perkemahan.', 'is_active' => true, 'order' => 9],
            ['title' => 'Arsip Latihan Fisik Pra-Ekspedisi (Nonaktif)', 'category' => 'Gunung Hutan', 'description' => 'Contoh foto galeri berstatus nonaktif untuk verifikasi filter tampilan publik.', 'is_active' => false, 'order' => 10],
        ];

        foreach ($galleries as $item) {
            $attributes = Gallery::factory()->make($item)->toArray();

            Gallery::query()->firstOrCreate(
                ['title' => $item['title']],
                $attributes
            );
        }
    }

    protected function seedActivities(User $penulis): void
    {
        $today = now();
        $thisMonthEarly = now()->startOfMonth()->addDays(min(2, max(0, now()->day - 1)));
        $thisMonthMid = now()->startOfMonth()->addDays(min(10, max(0, now()->day - 1)));

        $items = [
            // 2025 Historical / Archived data (uji filter tahunan)
            [
                'slug' => 'sim-ekspedisi-gede-pangrango-2025',
                'title' => 'Ekspedisi Lintas Puncak Gede Pangrango',
                'category' => 'Ekspedisi',
                'location' => 'Cianjur, Jawa Barat',
                'event_date' => '2025-08-19',
                'created_at' => Carbon::parse('2025-08-20 10:00:00'),
                'status' => 'archived',
                'owner' => $penulis,
                'summary' => 'Simulasi perjalanan lintas jalur untuk mencatat kondisi pos perkemahan, sumber air, serta waktu tempuh antar sektor.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-evaluasi-sop-pendakian-2025',
                'title' => 'Evaluasi Standar Operasional Keselamatan Lapangan',
                'category' => 'Umum',
                'location' => 'Kampus Politeknik STIA LAN Bandung',
                'event_date' => '2025-11-12',
                'created_at' => Carbon::parse('2025-11-13 14:30:00'),
                'status' => 'archived',
                'owner' => $penulis,
                'summary' => 'Peninjauan daftar periksa peralatan individu, prosedur komunikasi radio lapangan, dan alur evakuasi darurat.',
                'has_document' => false,
            ],

            // 2026 Multi-month varied themes
            [
                'slug' => 'sim-latihan-fisik-dago-maribaya',
                'title' => 'Latihan Fisik & Lintas Alam Dago Pakar - Maribaya',
                'category' => 'Diklat',
                'location' => 'Tahura Ir. H. Djuanda, Bandung',
                'event_date' => '2026-01-24',
                'created_at' => Carbon::parse('2026-01-25 09:00:00'),
                'status' => 'published',
                'owner' => $penulis,
                'summary' => 'Program penguatan daya tahan kardiovaskular dan pengenalan manajemen beban ransel bagi calon anggota ekspedisi.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-ekspedisi-ciremai-selatan',
                'title' => 'Pendakian & Pemetaan Jalur Selatan Gunung Ciremai',
                'category' => 'Ekspedisi',
                'location' => 'Kuningan, Jawa Barat',
                'event_date' => '2026-02-14',
                'created_at' => Carbon::parse('2026-02-16 11:20:00'),
                'status' => 'published',
                'owner' => $penulis,
                'summary' => 'Simulasi pendakian jarak menengah dengan fokus pencatatan koordinat titik rawan kabut dan pembaruan peta jalur.',
                'has_document' => 'proposal-ekspedisi-ciremai.pdf',
            ],
            [
                'slug' => 'sim-diklatsar-rimbawan-xxviii',
                'title' => 'Pendidikan & Latihan Dasar Kepecintaalaman Angkatan XXVIII',
                'category' => 'Diklat',
                'location' => 'Gunung Manglayang, Kab. Bandung',
                'event_date' => '2026-03-21',
                'created_at' => Carbon::parse('2026-03-24 16:00:00'),
                'status' => 'published',
                'owner' => $penulis,
                'summary' => 'Tahapan pembinaan lapangan untuk melatih kerja sama regu, manajemen perlengkapan, serta etika berinteraksi dengan alam.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-pelatihan-navigasi-burangrang',
                'title' => 'Pelatihan Navigasi Darat, Peta Topografi & Kompas',
                'category' => 'Diklat',
                'location' => 'Gunung Burangrang, Purwakarta',
                'event_date' => '2026-04-11',
                'created_at' => Carbon::parse('2026-04-12 13:15:00'),
                'status' => 'published',
                'owner' => $penulis,
                'summary' => 'Praktik teknik resection, intersection, serta pembacaan kontur bukit dan lembah menggunakan peta rupa bumi dan kompas bidik.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-konservasi-hulu-citarum',
                'title' => 'Konservasi & Penghijauan Kawasan Hulu Sungai',
                'category' => 'Konservasi',
                'location' => 'Situ Cisanti, Kertasari, Bandung',
                'event_date' => '2026-05-09',
                'created_at' => Carbon::parse('2026-05-10 15:40:00'),
                'status' => 'published',
                'owner' => $penulis,
                'summary' => 'Kegiatan penanaman bibit pohon keras lokal serta pemantauan pertumbuhan tegakan muda bersama relawan setempat.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-survival-edukasi-outdoor-rahong',
                'title' => 'Pelatihan Survival Dasar & Edukasi Outdoor',
                'category' => 'Diklat',
                'location' => 'Hutan Pinus Rahong, Pangalengan',
                'event_date' => '2026-06-13',
                'created_at' => Carbon::parse('2026-06-15 10:10:00'),
                'status' => 'published',
                'owner' => $penulis,
                'summary' => 'Materi pembuatan bivak darurat, teknik penyaringan air sederhana, pengendalian hipotermia, dan pengenalan jejak medan.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-aksi-bersih-cikapundung',
                'title' => 'Aksi Bersih Lingkungan & Audit Sampah Bantaran Sungai',
                'category' => 'Konservasi',
                'location' => 'Bantaran Sungai Cikapundung, Bandung',
                'event_date' => '2026-07-18',
                'created_at' => Carbon::parse('2026-07-19 17:00:00'),
                'status' => 'published',
                'owner' => $penulis,
                'summary' => 'Aksi pembersihan sampah plastik, pemilahan limbah terukur, dan sosialisasi pengurangan plastik sekali pakai.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-observasi-lingkungan-patengan',
                'title' => 'Observasi Lingkungan & Keanekaragaman Flora Hutan Pegunungan',
                'category' => 'Konservasi',
                'location' => 'Cagar Alam Patengan, Ciwidey',
                'event_date' => '2026-08-22',
                'created_at' => Carbon::parse('2026-08-24 08:45:00'),
                'status' => 'published',
                'owner' => $penulis,
                'summary' => 'Pengamatan kondisi tutupan kanopi, kualitas mata air pegunungan, dan pencatatan visual jenis tumbuhan bawah.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-bakti-sosial-desa-binaan',
                'title' => 'Bakti Sosial & Edukasi Kesiapsiagaan Bencana Desa Binaan',
                'category' => 'SAR & Kemanusiaan',
                'location' => 'Kec. Pasirjambu, Kab. Bandung',
                'event_date' => '2026-09-12',
                'created_at' => Carbon::parse('2026-09-14 12:00:00'),
                'status' => 'archived',
                'owner' => $penulis,
                'summary' => 'Penyaluran paket kebutuhan sekolah dan simulasi jalur evakuasi mandiri bersama perangkat desa dan karang taruna.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-vertical-rescue-citatah',
                'title' => 'Latihan Gabungan Vertical Rescue & Penanganan Medis',
                'category' => 'SAR & Kemanusiaan',
                'location' => 'Tebing Citatah 125, Padalarang',
                'event_date' => '2026-10-17',
                'created_at' => Carbon::parse('2026-10-18 16:30:00'),
                'status' => 'review',
                'owner' => $penulis,
                'summary' => 'Simulasi penurunan korban menggunakan sistem katrol dan pengamanan tali ganda pada dinding tebing.',
                'has_document' => false,
            ],

            // Current month & today records (for W8 today/month cards and W9 current month filters)
            [
                'slug' => 'sim-susur-gua-rajamandala',
                'title' => 'Eksplorasi & Pemetaan Gua Karst Rajamandala',
                'category' => 'Ekspedisi',
                'location' => 'Cipatat, Bandung Barat',
                'event_date' => $thisMonthEarly->toDateString(),
                'created_at' => $thisMonthEarly->copy()->setTime(10, 0),
                'status' => 'review',
                'owner' => $penulis,
                'summary' => 'Latihan pemetaan poligon lorong gua dan pengecekan kadar udara pada jalur pengamatan speleologi.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-arung-jeram-cimanuk-rescue',
                'title' => 'Simulasi River Rescue & Pengarungan Arus Deras',
                'category' => 'SAR & Kemanusiaan',
                'location' => 'Sungai Cimanuk, Garut',
                'event_date' => $thisMonthMid->toDateString(),
                'created_at' => $thisMonthMid->copy()->setTime(13, 45),
                'status' => 'review',
                'owner' => $penulis,
                'summary' => 'Pelatihan teknik lempar tali penyelamat (throw bag), pembalikan perahu karet, dan pengamanan awak perahu.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-zero-waste-papandayan',
                'title' => 'Kampanye Pendakian Nir-Sampah Gunung Papandayan',
                'category' => 'Konservasi',
                'location' => 'Cisurupan, Garut',
                'event_date' => $thisMonthMid->toDateString(),
                'created_at' => $thisMonthMid->copy()->setTime(15, 20),
                'status' => 'review',
                'owner' => $penulis,
                'summary' => 'Simulasi pencatatan logistik bebas kemasan sekali pakai sebelum keberangkatan dan penimbangan sampah turun.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-rancangan-ekspedisi-argopuro',
                'title' => 'Draf Rencana Ekspedisi Lintas Pegunungan Argopuro',
                'category' => 'Ekspedisi',
                'location' => 'Probolinggo - Situbondo, Jawa Timur',
                'event_date' => $today->toDateString(),
                'created_at' => $today->copy()->subHours(2),
                'status' => 'draft',
                'owner' => $penulis,
                'summary' => 'Penyusunan rencana rute harian, kebutuhan logistik tim inti, serta surat izin koordinasi jalur konservasi.',
                'has_document' => 'draf-rencana-argopuro.pdf',
            ],
            [
                'slug' => 'sim-draf-diklat-ruang-orientasi',
                'title' => 'Draf Silabus Diklat Ruang Orientasi Medan Terbuka',
                'category' => 'Diklat',
                'location' => 'Ruang Sekretariat SEMAR RIMBA',
                'event_date' => $today->toDateString(),
                'created_at' => $today->copy()->subHour(),
                'status' => 'draft',
                'owner' => $penulis,
                'summary' => 'Penyusunan materi pembekalan ruang mencakup meteorologi praktis, etika rimbawan, dan pertolongan pertama.',
                'has_document' => false,
            ],
            [
                'slug' => 'sim-draf-musyawarah-program-kerja',
                'title' => 'Draf Agenda Musyawarah Kerja Semester Genap',
                'category' => 'Umum',
                'location' => 'Aula Kampus STIA LAN Bandung',
                'event_date' => $thisMonthEarly->toDateString(),
                'created_at' => $thisMonthEarly->copy()->setTime(16, 0),
                'status' => 'draft',
                'owner' => $penulis,
                'summary' => 'Rancangan jadwal program kerja lintas empat matra, pembagian penanggung jawab, dan evaluasi inventaris alat.',
                'has_document' => false,
            ],
        ];

        foreach ($items as $index => $item) {
            $documentAttributes = [
                'document_path' => null,
                'document_original_name' => null,
                'document_mime_type' => null,
                'document_size' => null,
            ];

            if (is_string($item['has_document'])) {
                $documentAttributes = $this->ensureDemoPdfDocument($item['has_document'], $item['title']);
            }

            $attributes = Activity::factory()->make([
                'user_id' => $penulis->id,
                'title' => $item['title'],
                'slug' => $item['slug'],
                'category' => $item['category'],
                'location' => $item['location'],
                'event_date' => $item['event_date'],
                'description' => '<p>'.$item['summary'].'</p><ul><li>Lokasi simulasi: '.$item['location'].'</li><li>Kategori: '.$item['category'].'</li><li>Penanggung jawab pencatatan: '.$penulis->name.'</li></ul>',
                ...$documentAttributes,
                'status' => $item['status'],
                'is_active' => $item['status'] === 'published',
                'order' => $index + 1,
            ])->toArray();

            $activity = Activity::query()->firstOrCreate(
                ['slug' => $item['slug']],
                $attributes
            );

            if ($activity->wasRecentlyCreated) {
                $activity->timestamps = false;
                $activity->forceFill([
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['created_at'],
                ])->save();
            } elseif ($activity->user_id !== $penulis->id) {
                $activity->update(['user_id' => $penulis->id]);
            }
        }
    }

    protected function seedBeritas(User $penulis): void
    {
        $today = now();
        $thisMonthEarly = now()->startOfMonth()->addDays(min(3, max(0, now()->day - 1)));
        $thisMonthMid = now()->startOfMonth()->addDays(min(12, max(0, now()->day - 1)));

        $items = [
            // 2025 Historical / Archived
            [
                'slug' => 'sim-berita-rekap-ekspedisi-2025',
                'judul' => 'Rekap Kegiatan Lintas Jalur Gunung Gede Tahun 2025',
                'date' => '2025-08-25',
                'created_at' => Carbon::parse('2025-08-25 11:00:00'),
                'status' => 'archived',
                'owner' => $penulis,
                'konten' => '<p>Ringkasan perjalanan simulasi tahun 2025 yang mendokumentasikan kesiapan logistik, pemetaan jalur, dan evaluasi keselamatan tim lapangan.</p>',
            ],
            [
                'slug' => 'sim-berita-arsip-sop-keanggotaan-2025',
                'judul' => 'Pembaruan Tata Tertib & Pedoman Lapangan Internal',
                'date' => '2025-11-20',
                'created_at' => Carbon::parse('2025-11-20 15:00:00'),
                'status' => 'archived',
                'owner' => $penulis,
                'konten' => '<p>Dokumen pedoman internal organisasi mengenai tata kelola perlengkapan sekretariat, standar keselamatan latihan, serta mekanisme pelaporan pasca kegiatan.</p>',
            ],

            // 2026 Varied Themes
            [
                'slug' => 'sim-berita-pelantikan-pengurus-2026',
                'judul' => 'Pengumuman Pelantikan Dewan Pengurus SEMAR RIMBA Periode 2026',
                'date' => '2026-01-18',
                'created_at' => Carbon::parse('2026-01-18 10:30:00'),
                'status' => 'published',
                'owner' => $penulis,
                'konten' => '<p>Pengumuman resmi serah terima amanah kepengurusan baru untuk mengawal agenda pembinaan empat matra dan program konservasi sepanjang tahun 2026.</p>',
            ],
            [
                'slug' => 'sim-berita-edukasi-leave-no-trace',
                'judul' => 'Artikel Edukasi Lingkungan: Prinsip Leave No Trace di Gunung',
                'date' => '2026-02-22',
                'created_at' => Carbon::parse('2026-02-22 14:00:00'),
                'status' => 'published',
                'owner' => $penulis,
                'konten' => '<p>Artikel edukasi lingkungan mengenai tujuh prinsip dasar menjaga kelestarian jalur pendakian, mulai dari manajemen sampah hingga menjaga keasrian flora dan sumber air.</p>',
            ],
            [
                'slug' => 'sim-berita-pengukuhan-npa-diklatsar',
                'judul' => 'Informasi Keanggotaan: Pengukuhan Anggota Muda Diklatsar XXVIII',
                'date' => '2026-03-28',
                'created_at' => Carbon::parse('2026-03-28 09:45:00'),
                'status' => 'published',
                'owner' => $penulis,
                'konten' => '<p>Informasi keanggotaan terkait selesainya rangkaian Diklatsar XXVIII dan pemberian nomor pokok anggota sebagai bagian dari keluarga besar SEMAR RIMBA.</p>',
            ],
            [
                'slug' => 'sim-berita-info-pelatihan-navigasi',
                'judul' => 'Informasi Kegiatan Pelatihan Navigasi Darat di Gunung Burangrang',
                'date' => '2026-04-14',
                'created_at' => Carbon::parse('2026-04-14 13:20:00'),
                'status' => 'published',
                'owner' => $penulis,
                'konten' => '<p>Catatan pelaksanaan praktik orientasi medan, pembacaan koordinat peta topografi, serta evaluasi ketepatan penentuan titik posisi oleh peserta.</p>',
            ],
            [
                'slug' => 'sim-berita-rekap-penghijauan-citarum',
                'judul' => 'Rekap Kegiatan Penghijauan & Perawatan Bibit Hulu Citarum',
                'date' => '2026-05-15',
                'created_at' => Carbon::parse('2026-05-15 16:10:00'),
                'status' => 'published',
                'owner' => $penulis,
                'konten' => '<p>Rekap jumlah bibit pohon keras yang ditanam serta pemetaan area serapan air yang menjadi lokasi pemantauan berkala biro konservasi.</p>',
            ],
            [
                'slug' => 'sim-berita-edukasi-ekosistem-karst',
                'judul' => 'Edukasi Lingkungan: Peran Kawasan Karst dalam Cadangan Air Tanah',
                'date' => '2026-06-21',
                'created_at' => Carbon::parse('2026-06-21 11:15:00'),
                'status' => 'published',
                'owner' => $penulis,
                'konten' => '<p>Ulasan ilmiah ringan mengenai kerentanan gua kapur terhadap pencemaran permukaan dan pentingnya praktik susur gua yang bertanggung jawab.</p>',
            ],
            [
                'slug' => 'sim-berita-prestasi-simulasi-arung-jeram',
                'judul' => 'Prestasi Simulasi: Tim Arung Jeram Raih Peringkat Terbaik Regional',
                'date' => '2026-07-26',
                'created_at' => Carbon::parse('2026-07-26 18:00:00'),
                'status' => 'published',
                'owner' => $penulis,
                'konten' => '<p>Simulasi capaian tim matra Arung Jeram pada kejuaraan persahabatan mahasiswa tingkat regional untuk kategori ketangkasan slalom dan sprint.</p>',
            ],
            [
                'slug' => 'sim-berita-agenda-hari-jadi-ukm',
                'judul' => 'Informasi Agenda Peringatan Hari Jadi & Diskusi Konservasi',
                'date' => '2026-08-17',
                'created_at' => Carbon::parse('2026-08-17 08:00:00'),
                'status' => 'published',
                'owner' => $penulis,
                'konten' => '<p>Rangkaian agenda peringatan hari jadi organisasi meliputi diskusi pelestarian lingkungan kampus, pameran foto ekspedisi, dan temu alumni.</p>',
            ],
            [
                'slug' => 'sim-berita-rekap-bakti-sosial-desa',
                'judul' => 'Rekap Bakti Sosial & Simulasi Siaga Bencana di Pasirjambu',
                'date' => '2026-09-18',
                'created_at' => Carbon::parse('2026-09-18 14:50:00'),
                'status' => 'archived',
                'owner' => $penulis,
                'konten' => '<p>Laporan ringkas penyaluran bantuan perlengkapan belajar dan pelaksanaan sosialisasi jalur evakuasi warga bersama relawan lokal.</p>',
            ],
            [
                'slug' => 'sim-berita-internal-inventaris-alat',
                'judul' => 'Informasi Internal: Jadwal Pengecekan & Kalibrasi Alat Panjat',
                'date' => '2026-10-20',
                'created_at' => Carbon::parse('2026-10-20 10:00:00'),
                'status' => 'review',
                'owner' => $penulis,
                'konten' => '<p>Pemberitahuan internal mengenai pemeriksaan kelayakan tali karmantel, carabiner, harness, dan alat bantu SRT di gudang logistik.</p>',
            ],

            // Current month & today records
            [
                'slug' => 'sim-berita-persiapan-vertical-rescue',
                'judul' => 'Informasi Kegiatan Latihan Gabungan Vertical Rescue Padalarang',
                'date' => $thisMonthEarly->toDateString(),
                'created_at' => $thisMonthEarly->copy()->setTime(11, 30),
                'status' => 'review',
                'owner' => $penulis,
                'konten' => '<p>Berita pratinjau pelaksanaan simulasi penyelamatan vertikal lintas tim yang berfokus pada keselamatan penambatan dan komunikasi tandu.</p>',
            ],
            [
                'slug' => 'sim-berita-agenda-pendaftaran-diklat',
                'judul' => 'Agenda Mendatang: Sosialisasi Penerimaan Anggota Baru',
                'date' => $thisMonthMid->toDateString(),
                'created_at' => $thisMonthMid->copy()->setTime(14, 15),
                'status' => 'review',
                'owner' => $penulis,
                'konten' => '<p>Informasi jadwal pertemuan pengenalan UKM SEMAR RIMBA, persyaratan administrasi calon peserta, serta sesi tanya jawab pembekalan fisik.</p>',
            ],
            [
                'slug' => 'sim-berita-evaluasi-zero-waste',
                'judul' => 'Rekap Kampanye Pendakian Nir-Sampah & Pengelolaan Logistik',
                'date' => $thisMonthMid->toDateString(),
                'created_at' => $thisMonthMid->copy()->setTime(16, 40),
                'status' => 'review',
                'owner' => $penulis,
                'konten' => '<p>Catatan evaluasi penggunaan wadah makan ulang pakai selama simulasi pendakian untuk menekan timbulan sampah plastik di gunung.</p>',
            ],
            [
                'slug' => 'sim-berita-draf-artikel-p3k-gunung',
                'judul' => 'Draf Edukasi Outdoor: Penanganan Awal Hipotermia di Lapangan',
                'date' => $today->toDateString(),
                'created_at' => $today->copy()->subHours(3),
                'status' => 'draft',
                'owner' => $penulis,
                'konten' => '<p>Draf artikel edukatif tentang mengenali gejala awal penurunan suhu tubuh, teknik isolasi panas, dan koordinasi turun gunung secara aman.</p>',
            ],
            [
                'slug' => 'sim-berita-draf-agenda-latihan-gabungan',
                'judul' => 'Draf Pengumuman Agenda Latihan Gabungan Empat Matra',
                'date' => $today->toDateString(),
                'created_at' => $today->copy()->subMinutes(45),
                'status' => 'draft',
                'owner' => $penulis,
                'konten' => '<p>Draf pengumuman agenda latihan terpadu untuk anggota aktif yang mencakup sesi navigasi, simpul tali dasar, dan pengenalan alat SAR.</p>',
            ],
            [
                'slug' => 'sim-berita-draf-internal-jadwal-piket',
                'judul' => 'Draf Informasi Internal Jadwal Piket & Kebersihan Sekretariat',
                'date' => $thisMonthEarly->toDateString(),
                'created_at' => $thisMonthEarly->copy()->setTime(17, 10),
                'status' => 'draft',
                'owner' => $penulis,
                'konten' => '<p>Draf pembagian jadwal piket harian pengurus untuk menjaga kerapian ruang arsip, perpustakaan peta, dan gudang peralatan.</p>',
            ],
        ];

        foreach ($items as $item) {
            $attributes = Berita::factory()->make([
                'user_id' => $penulis->id,
                'judul' => $item['judul'],
                'slug' => $item['slug'],
                'konten' => $item['konten'],
                'tanggal_terbit' => $item['date'],
                'status' => $item['status'],
                'is_published' => $item['status'] === 'published',
            ])->toArray();

            $berita = Berita::query()->firstOrCreate(
                ['slug' => $item['slug']],
                $attributes
            );

            if ($berita->wasRecentlyCreated) {
                $berita->timestamps = false;
                $berita->forceFill([
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['created_at'],
                ])->save();
            } elseif ($berita->user_id !== $penulis->id) {
                $berita->update(['user_id' => $penulis->id]);
            }
        }
    }

    /**
     * Create a tiny valid dummy PDF in private storage if it does not already exist.
     *
     * @return array{
     *     document_path: string,
     *     document_original_name: string,
     *     document_mime_type: string,
     *     document_size: int
     * }
     */
    protected function ensureDemoPdfDocument(string $fileName, string $title): array
    {
        $path = 'activity-documents/'.$fileName;
        $safeTitle = str_replace(['(', ')', '\\'], '', $title);
        $content = "%PDF-1.4\n1 0 obj<<>>endobj\n2 0 obj<< /Length 44 >>stream\nBT /F1 12 Tf 72 720 Td ({$safeTitle}) Tj ET\nendstream\nendobj\ntrailer<<>>\n%%EOF\n";

        if (! Storage::disk('local')->exists($path)) {
            Storage::disk('local')->put($path, $content);
        }

        $size = Storage::disk('local')->size($path);

        return [
            'document_path' => $path,
            'document_original_name' => $fileName,
            'document_mime_type' => 'application/pdf',
            'document_size' => $size,
        ];
    }
}
