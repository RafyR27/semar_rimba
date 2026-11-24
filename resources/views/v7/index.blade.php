<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMAR RIMBA — Technical Expedition Gear & Diksar Flow (v7)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&family=JetBrains+Mono:wght@400;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --v7-bg: #0C110D;
            --v7-surface: #131A15;
            --v7-grid: #253128;
            --v7-ink: #EAECE7;
            --v7-muted: #8B968D;
            --v7-amber: #FBBF24;
        }
        body { background-color: var(--v7-bg); color: var(--v7-ink); font-family: 'IBM Plex Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }
        .font-mono-tech { font-family: 'JetBrains Mono', monospace; }
        .ruler-frame {
            background-image:
                repeating-linear-gradient(to right, rgba(251,191,36,0.4) 0 1px, transparent 1px 14px),
                repeating-linear-gradient(to bottom, rgba(251,191,36,0.4) 0 1px, transparent 1px 14px);
            background-size: 100% 8px, 8px 100%;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#FBBF24] selection:text-[#0C110D]">

    <header class="border-b border-[#253128] bg-[#0C110D]/95 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between border-x border-[#253128]">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8 text-[#FBBF24]" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-label="Crest Wayang Semar">
                    <rect x="4" y="4" width="40" height="40" stroke="#253128" fill="#131A15"/>
                    <path d="M18 14c2-3 10-3 12 0 1 2 0 4-1 5 3 2 5 6 4 10-1 4-5 7-9 7s-8-3-9-7c-1-4 1-8 4-10-1-1-2-3-1-5Z"/>
                    <path d="M20 24h3M25 24h3M20 30c2.5 1.8 5.5 1.8 8 0"/>
                </svg>
                <span class="font-display font-bold tracking-tight">SEMAR RIMBA</span>
            </div>
            <nav class="hidden md:flex gap-8 font-mono-tech text-xs text-[#8B968D]">
                <a href="#tentang" class="hover:text-[#FBBF24]">01. PROFIL</a>
                <a href="#divisi" class="hover:text-[#FBBF24]">02. MATRA</a>
                <a href="#diksar" class="hover:text-[#FBBF24]">03. ALUR DIKSAR</a>
                <a href="#kolaborasi" class="hover:text-[#FBBF24]">04. KOLABORASI</a>
            </nav>
            <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs text-[#FBBF24] hover:underline">@semar_rimba</a>
        </div>
    </header>

    <!-- HERO: Quiet Scale + Technical Frame -->
    <section class="max-w-7xl mx-auto border-x border-b border-[#253128] p-6 sm:p-12 lg:p-16">
        <div class="max-w-4xl">
            <span class="font-mono-tech text-xs text-[#FBBF24] tracking-widest uppercase">06°53'24"S 107°36'18"E · OPERASI MEDAN &amp; SAR</span>
            <h1 class="font-display text-4xl sm:text-6xl lg:text-[4.5rem] font-extrabold uppercase leading-[0.95] mt-4">
                Ketangguhan Teknis di Tengah Kabut Rimba.
            </h1>
            <p class="mt-6 text-base sm:text-lg text-[#B5BEB6] max-w-2xl leading-relaxed">
                Organisasi mahasiswa pecinta alam Politeknik STIA LAN Bandung. Mengintegrasikan pelatihan navigasi darat, pemanjatan vertikal, susur gua, dan kesiapsiagaan SAR secara terukur.
            </p>
            <div class="mt-9 flex flex-wrap gap-3">
                <a href="#tentang" class="px-6 py-3.5 bg-[#FBBF24] text-[#0C110D] font-mono-tech text-xs font-bold uppercase tracking-wider hover:bg-[#F59E0B]">
                    Tentang Kami
                </a>
                <a href="#kolaborasi" class="px-6 py-3.5 border border-[#EAECE7] text-[#EAECE7] font-mono-tech text-xs font-bold uppercase tracking-wider hover:bg-[#EAECE7] hover:text-[#0C110D]">
                    Kolaborasi dengan Kami
                </a>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="px-4 py-3.5 font-mono-tech text-xs text-[#8B968D] hover:text-[#FBBF24]">
                    IG @semar_rimba ↗
                </a>
            </div>
        </div>

        <!-- Hero Stand-in with Coordinate Frame & Ruler Ticks -->
        <div class="mt-12 border border-[#253128] p-2 bg-[#131A15]">
            <div class="aspect-[16/9] bg-[#070A08] ruler-frame p-6 sm:p-8 flex flex-col justify-between">
                <div class="flex justify-between font-mono-tech text-[11px] text-[#FBBF24]">
                    <span>FRAME_01 // B&amp;W HIGH CONTRAST</span>
                    <span>2.665 MDPL</span>
                </div>
                <div class="text-center my-auto max-w-md mx-auto">
                    <p class="font-mono-tech text-xs uppercase tracking-widest text-[#EAECE7]">[Slot Visual Hero Kabut &amp; Kompas]</p>
                    <p class="text-xs text-[#8B968D] mt-2">Foto hitam-putih kontras tinggi pemanjatan tebing atau navigasi kompas di tengah kabut dengan bingkai koordinat dan skala penggaris teknis.</p>
                </div>
                <div class="flex justify-between font-mono-tech text-[10px] text-[#8B968D] border-t border-[#253128] pt-3">
                    <span>LAT 06°53'24"S</span>
                    <span>RULER SCALE 1:25.000</span>
                    <span>LON 107°36'18"E</span>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 1: Tentang & Divisi -->
    <section id="tentang" class="max-w-7xl mx-auto border-x border-b border-[#253128] grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5 p-8 sm:p-10 border-b lg:border-b-0 lg:border-r border-[#253128] bg-[#131A15]">
            <span class="font-mono-tech text-xs text-[#FBBF24]">01 // FILOSOFI SEMAR RIMBA</span>
            <h2 class="font-display text-3xl font-bold mt-3">Tabah, Terampil, Tangguh, Lestari.</h2>
            <p class="mt-4 text-sm text-[#B5BEB6] leading-relaxed">
                Berakar dari tokoh pewayangan Semar—penjaga keseimbangan yang rendah hati namun kokoh—setiap anggota ditempa untuk menguasai teknik alam bebas dan misi kemanusiaan SAR.
            </p>
        </div>
        <div id="divisi" class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-[#253128]">
            <div class="p-8 border-b border-[#253128]">
                <span class="font-display text-4xl font-extrabold text-[#FBBF24]">01</span>
                <h3 class="font-display text-xl font-bold mt-2">Gunung Hutan</h3>
                <p class="mt-2 text-xs text-[#8B968D] leading-relaxed">Navigasi darat, orientasi medan, dan ekspedisi rimba multi-hari.</p>
            </div>
            <div class="p-8 border-b border-[#253128]">
                <span class="font-display text-4xl font-extrabold text-[#FBBF24]">02</span>
                <h3 class="font-display text-xl font-bold mt-2">Panjat Tebing</h3>
                <p class="mt-2 text-xs text-[#8B968D] leading-relaxed">Pemanjatan vertikal, sistem anchor ganda, dan vertical rescue.</p>
            </div>
            <div class="p-8">
                <span class="font-display text-4xl font-extrabold text-[#FBBF24]">03</span>
                <h3 class="font-display text-xl font-bold mt-2">Susur Gua</h3>
                <p class="mt-2 text-xs text-[#8B968D] leading-relaxed">Single Rope Technique (SRT) dan pemetaan kawasan karst.</p>
            </div>
            <div class="p-8">
                <span class="font-display text-4xl font-extrabold text-[#FBBF24]">04</span>
                <h3 class="font-display text-xl font-bold mt-2">Konservasi &amp; SAR</h3>
                <p class="mt-2 text-xs text-[#8B968D] leading-relaxed">Rehabilitasi hutan, riset flora, dan respon cepat SAR bencana.</p>
            </div>
        </div>
    </section>

    <!-- SECTION 2: Alur Tahapan Diksar Bernomor 1 sampai 6 -->
    <section id="diksar" class="max-w-7xl mx-auto border-x border-b border-[#253128] p-8 sm:p-12">
        <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="font-mono-tech text-xs text-[#FBBF24]">03 // PROTOKOL KEBERANGKATAN &amp; KADERISASI</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold mt-2">Alur Tahapan Pendidikan Dasar (Diksar)</h2>
            </div>
            <span class="font-mono-tech text-xs text-[#8B968D]">TAHAP 01 — 06</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 border border-[#253128] divide-y md:divide-y-0 md:divide-x divide-[#253128]">
            <div class="p-6 border-b border-[#253128]">
                <span class="font-mono-tech text-xs text-[#FBBF24] font-bold">TAHAP 01</span>
                <h3 class="font-display text-xl font-bold mt-2">Pendaftaran &amp; Seleksi Fisik</h3>
                <p class="mt-2 text-xs text-[#8B968D] leading-relaxed">Pemeriksaan kesiapan fisik dasar, komitmen organisasi, dan pembekalan etika rimba.</p>
            </div>
            <div class="p-6 border-b border-[#253128]">
                <span class="font-mono-tech text-xs text-[#FBBF24] font-bold">TAHAP 02</span>
                <h3 class="font-display text-xl font-bold mt-2">Materi Ruang &amp; Navigasi</h3>
                <p class="mt-2 text-xs text-[#8B968D] leading-relaxed">Kelas ilmu medan, peta-kompas, manajemen perjalanan, PPGD, dan tali-temali.</p>
            </div>
            <div class="p-6 border-b border-[#253128]">
                <span class="font-mono-tech text-xs text-[#FBBF24] font-bold">TAHAP 03</span>
                <h3 class="font-display text-xl font-bold mt-2">Pra-Lapangan &amp; Packing</h3>
                <p class="mt-2 text-xs text-[#8B968D] leading-relaxed">Simulasi teknis, inspeksi perlengkapan individu-tim, dan briefing keselamatan.</p>
            </div>
            <div class="p-6">
                <span class="font-mono-tech text-xs text-[#FBBF24] font-bold">TAHAP 04</span>
                <h3 class="font-display text-xl font-bold mt-2">Operasi Diksar Lapangan</h3>
                <p class="mt-2 text-xs text-[#8B968D] leading-relaxed">Aplikasi navigasi darat, bivak, survival, dan simulasi pertolongan di medan sebenarnya.</p>
            </div>
            <div class="p-6">
                <span class="font-mono-tech text-xs text-[#FBBF24] font-bold">TAHAP 05</span>
                <h3 class="font-display text-xl font-bold mt-2">Pengembaraan Matra</h3>
                <p class="mt-2 text-xs text-[#8B968D] leading-relaxed">Pendalaman spesialisasi Gunung Hutan, Panjat Tebing, Susur Gua, atau Konservasi.</p>
            </div>
            <div class="p-6 bg-[#131A15]">
                <span class="font-mono-tech text-xs text-[#FBBF24] font-bold">TAHAP 06</span>
                <h3 class="font-display text-xl font-bold mt-2">Pengukuhan Nomor Anggota</h3>
                <p class="mt-2 text-xs text-[#8B968D] leading-relaxed">Penyematan syal dan kesiapan penuh dalam misi ekspedisi serta operasi SAR.</p>
            </div>
        </div>
    </section>

    <!-- Closing CTA Band -->
    <section id="kolaborasi" class="max-w-7xl mx-auto border-x border-b border-[#253128] bg-[#131A15] p-8 sm:p-14 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-7">
            <span class="font-mono-tech text-xs text-[#FBBF24]">04 // KANAL RESMI</span>
            <h2 class="font-display text-3xl sm:text-4xl font-bold mt-2">Kolaborasi Ekspedisi, Pelatihan SAR &amp; Konservasi.</h2>
        </div>
        <div class="lg:col-span-5 flex flex-wrap gap-3 lg:justify-end">
            <a href="#tentang" class="px-6 py-3.5 bg-[#FBBF24] text-[#0C110D] font-mono-tech text-xs font-bold uppercase">Tentang Kami</a>
            <a href="mailto:sekretariat@semarrimba-lan.org" class="px-6 py-3.5 border border-[#EAECE7] text-[#EAECE7] font-mono-tech text-xs font-bold uppercase hover:bg-[#EAECE7] hover:text-[#0C110D]">Kolaborasi dengan Kami</a>
            <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="w-full lg:text-right font-mono-tech text-xs text-[#8B968D] hover:text-[#FBBF24]">Instagram @semar_rimba ↗</a>
        </div>
    </section>

</body>
</html>
