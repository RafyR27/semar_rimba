<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMAR RIMBA — Jurnal Ekspedisi & Kepencintaalaman (v1)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,600;0,6..72,700;1,6..72,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --v1-paper: #F4EFE4;
            --v1-paper-deep: #EAE3D2;
            --v1-ink: #1C211B;
            --v1-muted: #586053;
            --v1-rule: #CFC6B4;
            --v1-orange: #E05319;
        }
        body {
            background-color: var(--v1-paper);
            color: var(--v1-ink);
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: radial-gradient(rgba(28, 33, 27, 0.045) 1px, transparent 0);
            background-size: 20px 20px;
        }
        .font-display { font-family: 'Newsreader', serif; }
        .font-mono-tech { font-family: 'IBM Plex Mono', monospace; }
        .contour-divider {
            height: 36px;
            width: 100%;
            overflow: hidden;
            border-top: 1px solid var(--v1-rule);
            border-bottom: 1px solid var(--v1-rule);
        }
        .latlon-frame {
            background-image:
                repeating-linear-gradient(to right, rgba(28,33,27,0.35) 0 1px, transparent 1px 24px),
                repeating-linear-gradient(to bottom, rgba(28,33,27,0.35) 0 1px, transparent 1px 24px);
            background-size: 100% 8px, 8px 100%;
            background-position: top left, top left;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#E05319] selection:text-white">

    <!-- Topographic Marginalia Header -->
    <header class="border-b border-[#CFC6B4] bg-[#F4EFE4]/95 sticky top-0 z-40 backdrop-blur-xs">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <!-- Wayang Semar Cartographic Linework Emblem -->
                <svg class="w-8 h-8 text-[#1C211B] shrink-0" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.4" aria-label="Emblem Wayang Semar Rimba">
                    <circle cx="24" cy="24" r="21" stroke-dasharray="3 2"/>
                    <path d="M18 14c2-4 10-4 12 0 1 2 0 4-1 5 3 2 5 6 4 11-1 5-5 8-9 8s-8-3-9-8c-1-5 1-9 4-11-1-1-2-3-1-5Z"/>
                    <path d="M21 19c1.5-1 4.5-1 6 0M20 24c1.2.8 2.4.8 3.2 0M24.8 24c.8.8 2 0.8 3.2 0M19 30c3 2.2 7 2.2 10 0"/>
                    <path d="M24 3v5M24 40v5M3 24h5M40 24h5" stroke="#E05319"/>
                </svg>
                <div>
                    <span class="font-display text-lg font-bold tracking-tight block leading-none">SEMAR RIMBA</span>
                    <span class="font-mono-tech text-[10px] tracking-widest text-[#586053]">UKM-PA POLITEKNIK STIA LAN BANDUNG</span>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-7 text-xs font-mono-tech uppercase tracking-wider text-[#586053]">
                <a href="#tentang" class="hover:text-[#E05319] transition-colors">01. Tentang</a>
                <a href="#divisi" class="hover:text-[#E05319] transition-colors">02. Divisi Medan</a>
                <a href="#log" class="hover:text-[#E05319] transition-colors">03. Log Ekspedisi</a>
                <a href="#kolaborasi" class="hover:text-[#E05319] transition-colors">04. Kolaborasi</a>
            </nav>

            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-block font-mono-tech text-[11px] text-[#586053] border border-[#CFC6B4] px-2.5 py-1">06°53'24"S 107°36'18"E</span>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs px-3 py-1.5 border border-[#1C211B] hover:bg-[#1C211B] hover:text-[#F4EFE4] transition-colors">
                    @semar_rimba
                </a>
            </div>
        </div>
    </header>

    <!-- HERO: Monumental Field Journal -->
    <section class="max-w-7xl mx-auto px-5 sm:px-8 pt-10 pb-16 lg:pt-14 lg:pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <!-- Left Column: Editorial Display & Metadata -->
            <div class="lg:col-span-7 flex flex-col justify-between">
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 pb-6 mb-8 border-b border-[#CFC6B4] font-mono-tech text-xs text-[#586053]">
                    <span class="text-[#E05319] font-semibold">● ARSIP LAPANGAN AKTIF</span>
                    <span>ELEV: 768 – 3.078 MDPL</span>
                    <span>DIV: GH · PT · SG · KONSERVASI</span>
                </div>

                <h1 class="font-display text-5xl sm:text-6xl lg:text-[4.5rem] leading-[0.98] tracking-tight font-semibold text-[#1C211B]">
                    Menapak Rimba dengan Ilmu, Tradisi, dan Ketangguhan Medan.
                </h1>

                <p class="mt-6 text-base sm:text-lg leading-relaxed text-[#434B3F] max-w-2xl">
                    Semar Rimba adalah organisasi mahasiswa pecinta alam Politeknik STIA LAN Bandung yang menempa keahlian navigasi darat, ekspedisi alam bebas, operasi SAR kemanusiaan, dan riset konservasi hutan tropis Nusantara.
                </p>

                <!-- Primary CTAs -->
                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <a href="#tentang" class="px-6 py-3.5 bg-[#E05319] text-white font-mono-tech text-xs uppercase tracking-widest font-semibold hover:bg-[#C64512] transition-colors">
                        Tentang Kami
                    </a>
                    <a href="#kolaborasi" class="px-6 py-3.5 border border-[#1C211B] text-[#1C211B] font-mono-tech text-xs uppercase tracking-widest font-semibold hover:bg-[#1C211B] hover:text-[#F4EFE4] transition-colors">
                        Kolaborasi dengan Kami
                    </a>
                    <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="px-4 py-3.5 font-mono-tech text-xs text-[#586053] underline underline-offset-4 hover:text-[#E05319]">
                        IG @semar_rimba ↗
                    </a>
                </div>

                <!-- Field Journal Marginalia Strip -->
                <div class="mt-12 pt-6 border-t border-[#CFC6B4] grid grid-cols-2 sm:grid-cols-4 gap-6 font-mono-tech">
                    <div>
                        <span class="block text-[10px] text-[#586053] uppercase">Filosofi Nama</span>
                        <span class="text-sm font-semibold">Laku Semar</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-[#586053] uppercase">Motto Korsa</span>
                        <span class="text-sm font-semibold">Tabah · Lestari</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-[#586053] uppercase">Matra Operasional</span>
                        <span class="text-sm font-semibold">4 Divisi Aktif</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-[#586053] uppercase">Basecamp</span>
                        <span class="text-sm font-semibold">Bandung, Jabar</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Vertical Monumental Hero Image Stand-in -->
            <div class="lg:col-span-5">
                <div class="border border-[#1C211B] p-2.5 bg-[#EAE3D2] latlon-frame">
                    <div class="aspect-[3/4] w-full bg-[#242B22] relative flex flex-col justify-between p-6 text-[#F4EFE4] border border-[#1C211B]">
                        <div class="flex justify-between items-start font-mono-tech text-[11px] text-[#CFC6B4]">
                            <span>FIG. 01 // HERO EKSPEDISI</span>
                            <span class="text-[#E05319]">● 3:4 VERTIKAL</span>
                        </div>

                        <div class="my-auto text-center px-4">
                            <svg class="w-12 h-12 mx-auto mb-4 text-[#E05319] opacity-90" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.2">
                                <path d="M4 36L16 16l8 12 6-8 14 16H4Z"/>
                                <circle cx="34" cy="12" r="3"/>
                            </svg>
                            <p class="font-mono-tech text-xs uppercase tracking-widest text-[#EAE3D2]">[Slot Visual Hero Dokumenter]</p>
                            <p class="mt-2 text-xs text-[#A5AE9E] leading-relaxed">
                                Foto vertikal penuh atmosfer: kabut hutan lebat atau siluet tim di punggungan gunung dengan efek grain halus &amp; garis lintang-bujur di tepi.
                            </p>
                        </div>

                        <div class="flex justify-between items-end font-mono-tech text-[10px] text-[#A5AE9E] border-t border-white/15 pt-3">
                            <span>LAT 06°53'24"S</span>
                            <span>1.940 MDPL</span>
                            <span>LON 107°36'18"E</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Topographic Contour SVG Divider -->
    <div class="contour-divider bg-[#EAE3D2]/50" aria-hidden="true">
        <svg viewBox="0 0 1440 40" preserveAspectRatio="none" class="w-full h-full stroke-[#8C8474]/45 fill-none">
            <path d="M0,22 C180,8 320,34 520,18 C720,2 900,34 1120,16 C1260,5 1360,26 1440,18" stroke-width="1"/>
            <path d="M0,30 C210,14 360,38 560,24 C760,10 930,38 1150,22 C1280,12 1380,32 1440,26" stroke-width="0.8"/>
            <path d="M0,12 C160,26 310,4 500,14 C700,24 880,6 1090,14 C1240,20 1350,8 1440,12" stroke-width="0.6" stroke-dasharray="4 4"/>
        </svg>
    </div>

    <!-- SECTION 1: Tentang & Filosofi Wayang Semar -->
    <section id="tentang" class="max-w-7xl mx-auto px-5 sm:px-8 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <div class="lg:col-span-4 border-t-2 border-[#1C211B] pt-4">
                <span class="font-mono-tech text-xs text-[#E05319] uppercase tracking-widest">01 // Identitas &amp; Akar</span>
                <h2 class="font-display text-3xl sm:text-4xl font-semibold mt-2">Kebijaksanaan Semar di Garis Depan Rimba</h2>
                <!-- Wayang Semar Marginalia Card -->
                <div class="mt-6 p-5 border border-[#CFC6B4] bg-[#EAE3D2]/60 flex items-start gap-4">
                    <svg class="w-12 h-12 text-[#1C211B] shrink-0" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 16c3-7 17-7 20 0 2 4 0 8-2 10 5 3 8 10 6 18-2 8-8 13-14 13s-12-5-14-13c-2-8 1-15 6-18-2-2-4-6-2-10Z"/>
                        <path d="M26 25c2-1.5 10-1.5 12 0M25 33c2 1.2 4 1.2 5.5 0M33.5 33c1.5 1.2 3.5 1.2 5.5 0M23 42c5 3.5 13 3.5 18 0"/>
                        <circle cx="32" cy="11" r="2.5" fill="#E05319" stroke="none"/>
                    </svg>
                    <p class="text-xs leading-relaxed text-[#434B3F]">
                        <strong class="font-mono-tech text-[#1C211B] block mb-1">FILOSOFI SEMAR:</strong>
                        Pamong yang bersahaja namun teguh menjaga keseimbangan alam dan manusia. Setiap anggota mengemban tanggung jawab menjaga kelestarian rimba tanpa kesombongan.
                    </p>
                </div>
            </div>

            <div class="lg:col-span-8 lg:pl-8 border-l-0 lg:border-l border-[#CFC6B4]">
                <p class="font-display text-2xl sm:text-3xl leading-snug text-[#1C211B]">
                    Kami memandang alam bebas bukan sebagai panggung wisata, melainkan laboratorium hidup untuk mengasah ketahanan diri, presisi navigasi, dan pengabdian kemanusiaan.
                </p>
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-8 text-sm leading-relaxed text-[#434B3F]">
                    <p>
                        Berbasis di Politeknik STIA LAN Bandung, Semar Rimba membekali mahasiswa dengan kurikulum Pendidikan Dasar (Diksar) terstruktur: mulai dari manajemen perbekalan, orientasi peta-kompas-GPS, teknik pertolongan pertama gawat darurat (PPGD), hingga operasi Search and Rescue.
                    </p>
                    <p>
                        Di luar misi lapangan, kami aktif menjalin kolaborasi riset biodiversitas, rehabilitasi daerah aliran sungai, serta edukasi tanggap bencana bersama instansi pemerintah, komunitas lokal, dan sesama organisasi pecinta alam.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: 4 Matra Divisi (Field Journal Index, NOT 3-column generic cards) -->
    <section id="divisi" class="border-t border-[#CFC6B4] bg-[#EAE3D2]/45">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-16 lg:py-24">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-8 border-b border-[#1C211B]">
                <div>
                    <span class="font-mono-tech text-xs text-[#E05319] uppercase tracking-widest">02 // Spesialisasi Matra</span>
                    <h2 class="font-display text-3xl sm:text-4xl font-semibold mt-1">Empat Pilar Keahlian Lapangan</h2>
                </div>
                <span class="font-mono-tech text-xs text-[#586053]">KODE OPERASIONAL: SR-DIV-01/04</span>
            </div>

            <div class="divide-y divide-[#CFC6B4]">
                <div class="py-7 grid grid-cols-1 md:grid-cols-12 gap-4 items-baseline">
                    <span class="md:col-span-2 font-mono-tech text-xs font-semibold text-[#E05319]">DIV-01 // GH</span>
                    <h3 class="md:col-span-4 font-display text-2xl font-semibold">Gunung Hutan</h3>
                    <p class="md:col-span-6 text-sm text-[#434B3F] leading-relaxed">Navigasi darat, perintisan jalur rimba, manajemen ekspedisi multi-hari, survival botani, serta operasi pencarian dan pertolongan di medan pegunungan tropis.</p>
                </div>
                <div class="py-7 grid grid-cols-1 md:grid-cols-12 gap-4 items-baseline">
                    <span class="md:col-span-2 font-mono-tech text-xs font-semibold text-[#E05319]">DIV-02 // PT</span>
                    <h3 class="md:col-span-4 font-display text-2xl font-semibold">Panjat Tebing</h3>
                    <p class="md:col-span-6 text-sm text-[#434B3F] leading-relaxed">Pemanjatan tebing alam (artificial &amp; sport climbing), sistem penambatan ganda, manajemen tali vertikal, serta teknik evakuasi medan terjal (vertical rescue).</p>
                </div>
                <div class="py-7 grid grid-cols-1 md:grid-cols-12 gap-4 items-baseline">
                    <span class="md:col-span-2 font-mono-tech text-xs font-semibold text-[#E05319]">DIV-03 // SG</span>
                    <h3 class="md:col-span-4 font-display text-2xl font-semibold">Susur Gua</h3>
                    <p class="md:col-span-6 text-sm text-[#434B3F] leading-relaxed">Single Rope Technique (SRT), pemetaan lorong karst (cave mapping), analisis hidrologi bawah tanah, dan konservasi ekosistem gua.</p>
                </div>
                <div class="py-7 grid grid-cols-1 md:grid-cols-12 gap-4 items-baseline">
                    <span class="md:col-span-2 font-mono-tech text-xs font-semibold text-[#E05319]">DIV-04 // KONSERVASI</span>
                    <h3 class="md:col-span-4 font-display text-2xl font-semibold">Konservasi &amp; SAR</h3>
                    <p class="md:col-span-6 text-sm text-[#434B3F] leading-relaxed">Pendataan flora-fauna endemik, penanaman vegetasi penyangga DAS, mitigasi bencana, serta kesiapsiagaan tim SAR kemanusiaan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: Galeri Log Ekspedisi (Flat CSS Stand-ins) -->
    <section id="log" class="max-w-7xl mx-auto px-5 sm:px-8 py-16 lg:py-24">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="font-mono-tech text-xs text-[#E05319] uppercase tracking-widest">03 // Dokumentasi Lapangan</span>
                <h2 class="font-display text-3xl sm:text-4xl font-semibold mt-1">Catatan &amp; Arsip Visual Ekspedisi</h2>
            </div>
            <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs underline underline-offset-4 text-[#1C211B] hover:text-[#E05319]">
                Arsip Lengkap @semar_rimba ↗
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Slot 1 -->
            <div class="md:col-span-7 border border-[#1C211B] p-2 bg-[#EAE3D2]">
                <div class="aspect-[16/10] bg-[#2D362B] text-[#EAE3D2] p-6 flex flex-col justify-between">
                    <div class="flex justify-between font-mono-tech text-[11px] text-[#A5AE9E]">
                        <span>LOG-2025-A // GUNUNG HUTAN</span>
                        <span>16:10</span>
                    </div>
                    <div class="text-center">
                        <p class="font-mono-tech text-xs uppercase tracking-widest">[Slot Foto Ekspedisi 01]</p>
                        <p class="text-xs text-[#A5AE9E] mt-1">Tim Navigasi Darat &amp; Orientasi Peta Kontur</p>
                    </div>
                    <div class="font-mono-tech text-[10px] text-[#E05319]">07°11'42"S 107°44'09"E · 2.240 MDPL</div>
                </div>
            </div>
            <!-- Slot 2 -->
            <div class="md:col-span-5 border border-[#1C211B] p-2 bg-[#EAE3D2]">
                <div class="aspect-[4/3] md:aspect-[4/3.65] bg-[#3A352D] text-[#EAE3D2] p-6 flex flex-col justify-between">
                    <div class="flex justify-between font-mono-tech text-[11px] text-[#CFC6B4]">
                        <span>LOG-2025-B // TEBING &amp; KARST</span>
                        <span>4:3</span>
                    </div>
                    <div class="text-center">
                        <p class="font-mono-tech text-xs uppercase tracking-widest">[Slot Foto Ekspedisi 02]</p>
                        <p class="text-xs text-[#CFC6B4] mt-1">Latihan Vertical Rescue &amp; Pemetaan Gua</p>
                    </div>
                    <div class="font-mono-tech text-[10px] text-[#E05319]">06°50'15"S 107°27'11"E · CITATAH</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Closing CTA Band + Footer -->
    <section id="kolaborasi" class="border-t-2 border-[#1C211B] bg-[#1C211B] text-[#F4EFE4]">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-8">
                    <span class="font-mono-tech text-xs text-[#E05319] uppercase tracking-widest">04 // Kanal Resmi &amp; Kolaborasi</span>
                    <h2 class="font-display text-3xl sm:text-5xl font-semibold mt-3 leading-tight">
                        Siap Berkolaborasi dalam Ekspedisi, Pelatihan SAR, atau Aksi Konservasi?
                    </h2>
                    <p class="mt-4 text-sm sm:text-base text-[#CFC6B4] max-w-2xl">
                        Terbuka untuk kemitraan riset lapangan, audiensi antar-organisasi pecinta alam, program penghijauan, serta dukungan logistik ekspedisi.
                    </p>
                </div>
                <div class="lg:col-span-4 flex flex-col gap-3">
                    <a href="#tentang" class="w-full text-center px-6 py-3.5 bg-[#E05319] text-white font-mono-tech text-xs uppercase tracking-widest font-semibold hover:bg-[#C64512] transition-colors">
                        Tentang Kami
                    </a>
                    <a href="mailto:sekretariat@semarrimba-lan.org" class="w-full text-center px-6 py-3.5 border border-[#F4EFE4] text-[#F4EFE4] font-mono-tech text-xs uppercase tracking-widest font-semibold hover:bg-[#F4EFE4] hover:text-[#1C211B] transition-colors">
                        Kolaborasi dengan Kami
                    </a>
                    <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="w-full text-center py-2 font-mono-tech text-xs text-[#CFC6B4] hover:text-[#E05319]">
                        Instagram Resmi: @semar_rimba ↗
                    </a>
                </div>
            </div>

            <div class="mt-14 pt-6 border-t border-white/15 flex flex-col sm:flex-row justify-between items-center gap-4 font-mono-tech text-[11px] text-[#A5AE9E]">
                <span>SEMAR RIMBA · POLITEKNIK STIA LAN BANDUNG</span>
                <span>V1 // TOPOGRAPHIC FIELD JOURNAL</span>
            </div>
        </div>
    </section>

</body>
</html>
