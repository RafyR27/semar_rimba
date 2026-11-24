<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMAR RIMBA — Technical Expedition Gear & SAR (v2)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --v2-bg: #0D110E;
            --v2-surface: #141A15;
            --v2-grid: #27322A;
            --v2-ink: #ECEAE2;
            --v2-muted: #8C978E;
            --v2-amber: #F59E0B;
        }
        body {
            background-color: var(--v2-bg);
            color: var(--v2-ink);
            font-family: 'IBM Plex Sans', sans-serif;
        }
        .font-display { font-family: 'Syne', sans-serif; }
        .font-mono-tech { font-family: 'JetBrains Mono', monospace; }
        .ruler-ticks-top {
            background-image: repeating-linear-gradient(to right, rgba(236,234,226,0.35) 0 1px, transparent 1px 12px);
            background-size: 100% 10px;
            background-repeat: no-repeat;
            background-position: top left;
        }
        .ruler-ticks-left {
            background-image: repeating-linear-gradient(to bottom, rgba(245,158,11,0.45) 0 1px, transparent 1px 16px);
            background-size: 8px 100%;
            background-repeat: no-repeat;
            background-position: top left;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#F59E0B] selection:text-[#0D110E]">

    <!-- Tactical Instrument Header -->
    <header class="border-b border-[#27322A] bg-[#0D110E]/95 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto grid grid-cols-12 items-center border-x border-[#27322A]">
            <div class="col-span-6 md:col-span-4 px-5 py-3.5 flex items-center gap-3 border-r border-[#27322A]">
                <!-- Wayang Semar Tactical Stencil SVG -->
                <svg class="w-8 h-8 text-[#F59E0B] shrink-0" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" aria-label="Insignia Wayang Semar">
                    <polygon points="24,2 44,13 44,35 24,46 4,35 4,13" stroke="#27322A" fill="#141A15"/>
                    <path d="M18 15c2-3 10-3 12 0 1 2 0 4-1 5 3 2 5 6 4 10-1 4-5 7-9 7s-8-3-9-7c-1-4 1-8 4-10-1-1-2-3-1-5Z"/>
                    <path d="M20 24h3M25 24h3M20 30c2.5 1.8 5.5 1.8 8 0"/>
                </svg>
                <div>
                    <span class="font-display font-bold tracking-tight text-base block leading-none">SEMAR RIMBA</span>
                    <span class="font-mono-tech text-[10px] text-[#8C978E]">UNIT SAR &amp; ALAM BEBAS</span>
                </div>
            </div>

            <nav class="hidden md:flex col-span-5 px-6 gap-6 font-mono-tech text-xs text-[#8C978E]">
                <a href="#tentang" class="hover:text-[#F59E0B]">[01] PROFIL</a>
                <a href="#divisi" class="hover:text-[#F59E0B]">[02] MATRA</a>
                <a href="#gear" class="hover:text-[#F59E0B]">[03] SOP &amp; GEAR</a>
                <a href="#kolaborasi" class="hover:text-[#F59E0B]">[04] KOLABORASI</a>
            </nav>

            <div class="col-span-6 md:col-span-3 px-5 py-3.5 flex items-center justify-end gap-3 border-l border-[#27322A]">
                <span class="inline-flex items-center gap-1.5 font-mono-tech text-[10px] px-2 py-1 bg-[#F59E0B]/15 text-[#F59E0B] border border-[#F59E0B]/40">
                    <span class="w-1.5 h-1.5 bg-[#F59E0B]"></span> REKRUTMEN TERBUKA
                </span>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs text-[#ECEAE2] hover:text-[#F59E0B]">@semar_rimba</a>
            </div>
        </div>
    </header>

    <!-- HERO: Alpine Tactical Grid -->
    <section class="max-w-7xl mx-auto border-x border-b border-[#27322A]">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            <!-- Left Telemetry & Display -->
            <div class="lg:col-span-7 p-6 sm:p-10 lg:p-14 border-b lg:border-b-0 lg:border-r border-[#27322A] flex flex-col justify-between">
                <div>
                    <div class="flex flex-wrap gap-4 font-mono-tech text-[11px] text-[#8C978E] pb-6 border-b border-[#27322A]">
                        <span>LAT 06°53'24"S</span>
                        <span>LON 107°36'18"E</span>
                        <span>ALT 768–3.078 MDPL</span>
                        <span class="text-[#F59E0B]">STATUS: SIAGA SAR</span>
                    </div>

                    <h1 class="mt-8 font-display text-4xl sm:text-6xl lg:text-[4.25rem] font-extrabold uppercase leading-[0.95] tracking-tight">
                        Presisi Medan. Disiplin Rigging. Garda Terdepan Rimba.
                    </h1>

                    <p class="mt-6 text-base text-[#B6BFB7] leading-relaxed max-w-xl">
                        UKM Pecinta Alam Politeknik STIA LAN Bandung. Menggabungkan teknik pemanjatan vertikal, navigasi darat taktis, penelusuran karst, dan kesiapsiagaan SAR kemanusiaan.
                    </p>
                </div>

                <div class="mt-10 pt-8 border-t border-[#27322A]">
                    <div class="flex flex-wrap gap-3">
                        <a href="#tentang" class="px-6 py-3.5 bg-[#F59E0B] text-[#0D110E] font-mono-tech text-xs font-bold uppercase tracking-wider hover:bg-[#D97706] transition-colors">
                            Tentang Kami
                        </a>
                        <a href="#kolaborasi" class="px-6 py-3.5 border border-[#ECEAE2] text-[#ECEAE2] font-mono-tech text-xs font-bold uppercase tracking-wider hover:bg-[#ECEAE2] hover:text-[#0D110E] transition-colors">
                            Kolaborasi dengan Kami
                        </a>
                        <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="px-4 py-3.5 font-mono-tech text-xs text-[#F59E0B] border border-[#27322A] hover:border-[#F59E0B]">
                            IG @semar_rimba ↗
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Hero Slot: High-Contrast B&W with Ruler Ticks -->
            <div class="lg:col-span-5 p-6 sm:p-8 bg-[#141A15] flex flex-col justify-between">
                <div class="flex justify-between font-mono-tech text-[10px] text-[#8C978E] mb-3">
                    <span>OPTIC_FRAME // 01</span>
                    <span>ASPECT 4:5 · B&amp;W HIGH-CONTRAST</span>
                </div>

                <div class="aspect-[4/5] w-full border border-[#ECEAE2]/30 bg-[#090B09] ruler-ticks-top ruler-ticks-left p-6 flex flex-col justify-between relative">
                    <div class="flex justify-end font-mono-tech text-[10px] text-[#F59E0B]">
                        <span>[000 — 100 MM]</span>
                    </div>

                    <div class="my-auto text-center px-3">
                        <div class="w-16 h-16 mx-auto mb-4 border border-[#F59E0B]/50 flex items-center justify-center">
                            <span class="font-mono-tech text-xs text-[#F59E0B]">+</span>
                        </div>
                        <p class="font-mono-tech text-xs uppercase tracking-widest text-[#ECEAE2]">[Slot Visual Hero Teknis]</p>
                        <p class="mt-2 text-xs text-[#8C978E] leading-relaxed">
                            Foto hitam-putih kontras tinggi aktivitas pemanjatan tebing atau navigasi kompas dengan bingkai skala penggaris (ruler ticks) teknis.
                        </p>
                    </div>

                    <div class="border-t border-[#27322A] pt-3 flex justify-between font-mono-tech text-[10px] text-[#8C978E]">
                        <span>MATRA: TEBING &amp; NAVDAR</span>
                        <span>3.078 MDPL</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 1: Tentang & Wayang Semar -->
    <section id="tentang" class="max-w-7xl mx-auto border-x border-b border-[#27322A]">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            <div class="lg:col-span-4 p-8 border-b lg:border-b-0 lg:border-r border-[#27322A] bg-[#141A15]">
                <span class="font-mono-tech text-xs text-[#F59E0B]">01 // IDENTITAS KORSA</span>
                <h2 class="font-display text-2xl sm:text-3xl font-bold mt-3">Tabah, Terampil, Tangguh, Lestari.</h2>
                <div class="mt-6 pt-6 border-t border-[#27322A] flex items-start gap-4">
                    <svg class="w-11 h-11 text-[#F59E0B] shrink-0" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.4">
                        <path d="M18 13c2-4 10-4 12 0 1 2 0 4-1 5 3 2 5 6 4 11-1 5-5 8-9 8s-8-3-9-8c-1-5 1-9 4-11-1-1-2-3-1-5Z"/>
                        <path d="M20 23h3M25 23h3M19 30c3 2 7 2 10 0"/>
                    </svg>
                    <p class="font-mono-tech text-[11px] leading-relaxed text-[#8C978E]">
                        WAYANG SEMAR: Simbol kebijaksanaan, keteguhan batin, dan pengayoman terhadap sesama tim maupun kelestarian ekosistem hutan.
                    </p>
                </div>
            </div>
            <div class="lg:col-span-8 p-8 sm:p-10 flex flex-col justify-center">
                <p class="text-lg sm:text-xl text-[#ECEAE2] leading-relaxed">
                    Setiap operasi lapangan Semar Rimba bertumpu pada standar keselamatan terukur, kepemimpinan kolektif, dan keilmuan alam bebas yang dapat dipertanggungjawabkan secara teknis.
                </p>
                <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 border-t border-[#27322A] font-mono-tech">
                    <div>
                        <span class="text-2xl font-bold text-[#F59E0B] block">04</span>
                        <span class="text-[11px] text-[#8C978E]">DIVISI KEAHLIAN</span>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-[#ECEAE2] block">SRT</span>
                        <span class="text-[11px] text-[#8C978E]">VERTICAL &amp; KARST</span>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-[#ECEAE2] block">SAR</span>
                        <span class="text-[11px] text-[#8C978E]">UNIT KEMANUSIAAN</span>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-[#ECEAE2] block">DAS</span>
                        <span class="text-[11px] text-[#8C978E]">KONSERVASI</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: Penomoran Divisi Keahlian Berukuran Besar -->
    <section id="divisi" class="max-w-7xl mx-auto border-x border-b border-[#27322A]">
        <div class="px-6 sm:px-8 py-5 border-b border-[#27322A] bg-[#141A15] flex justify-between items-center font-mono-tech text-xs">
            <span class="text-[#F59E0B]">02 // SPESIFIKASI DIVISI OPERASIONAL</span>
            <span class="text-[#8C978E]">GUNUNG HUTAN · TEBING · GUA · KONSERVASI</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-8 border-b md:border-r border-[#27322A] flex gap-6 items-start">
                <span class="font-display text-5xl font-extrabold text-[#F59E0B] leading-none">01</span>
                <div>
                    <span class="font-mono-tech text-[11px] text-[#8C978E]">KODE: DIV-GH</span>
                    <h3 class="font-display text-2xl font-bold mt-1">Gunung Hutan</h3>
                    <p class="mt-2 text-sm text-[#B6BFB7] leading-relaxed">Navigasi darat, orientasi medan, manajemen logistik ekspedisi rimba, dan teknik survival.</p>
                </div>
            </div>
            <div class="p-8 border-b border-[#27322A] flex gap-6 items-start">
                <span class="font-display text-5xl font-extrabold text-[#F59E0B] leading-none">02</span>
                <div>
                    <span class="font-mono-tech text-[11px] text-[#8C978E]">KODE: DIV-PT</span>
                    <h3 class="font-display text-2xl font-bold mt-1">Panjat Tebing</h3>
                    <p class="mt-2 text-sm text-[#B6BFB7] leading-relaxed">Sistem anchor, artificial climbing, belaying teknis, dan vertical rescue di tebing andesit/kapur.</p>
                </div>
            </div>
            <div class="p-8 border-b md:border-b-0 md:border-r border-[#27322A] flex gap-6 items-start">
                <span class="font-display text-5xl font-extrabold text-[#F59E0B] leading-none">03</span>
                <div>
                    <span class="font-mono-tech text-[11px] text-[#8C978E]">KODE: DIV-SG</span>
                    <h3 class="font-display text-2xl font-bold mt-1">Susur Gua</h3>
                    <p class="mt-2 text-sm text-[#B6BFB7] leading-relaxed">Single Rope Technique (SRT), rigging lorong vertikal, serta pemetaan topografi gua karst.</p>
                </div>
            </div>
            <div class="p-8 flex gap-6 items-start">
                <span class="font-display text-5xl font-extrabold text-[#F59E0B] leading-none">04</span>
                <div>
                    <span class="font-mono-tech text-[11px] text-[#8C978E]">KODE: DIV-KONSERVASI</span>
                    <h3 class="font-display text-2xl font-bold mt-1">Konservasi &amp; SAR</h3>
                    <p class="mt-2 text-sm text-[#B6BFB7] leading-relaxed">Pemulihan ekosistem hutan, edukasi lingkungan, serta respon cepat tanggap darurat bencana.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: Blok Spesifikasi Perlengkapan & Catatan Keselamatan + Slot Log -->
    <section id="gear" class="max-w-7xl mx-auto border-x border-b border-[#27322A]">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            <div class="lg:col-span-6 p-8 border-b lg:border-b-0 lg:border-r border-[#27322A]">
                <span class="font-mono-tech text-xs text-[#F59E0B]">03 // SPESIFIKASI STANDAR KESELAMATAN</span>
                <h3 class="font-display text-2xl font-bold mt-2 mb-6">Protokol Perlengkapan &amp; Zero-Accident</h3>
                <div class="space-y-3 font-mono-tech text-xs">
                    <div class="p-3.5 border border-[#27322A] bg-[#141A15] flex justify-between">
                        <span>SISTEM RIGGING &amp; ANCHOR</span>
                        <span class="text-[#F59E0B]">REDUNDANSI GANDA (UIAA/CE)</span>
                    </div>
                    <div class="p-3.5 border border-[#27322A] bg-[#141A15] flex justify-between">
                        <span>NAVIGASI &amp; KOMUNIKASI</span>
                        <span class="text-[#ECEAE2]">PETA TOPOGRAFI + KOMPAS + HT VHF</span>
                    </div>
                    <div class="p-3.5 border border-[#27322A] bg-[#141A15] flex justify-between">
                        <span>MANAJEMEN MEDIS LAPANGAN</span>
                        <span class="text-[#ECEAE2]">PPGD + EVAKUASI TANDU DARURAT</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 p-8 bg-[#141A15]">
                <div class="aspect-[16/9] border border-[#27322A] bg-[#090B09] p-5 flex flex-col justify-between">
                    <div class="flex justify-between font-mono-tech text-[10px] text-[#8C978E]">
                        <span>LOG_DOKUMENTASI // @semar_rimba</span>
                        <span>16:9 WIDE</span>
                    </div>
                    <div class="text-center">
                        <p class="font-mono-tech text-xs text-[#F59E0B]">[Slot Galeri Log Ekspedisi]</p>
                        <p class="text-xs text-[#8C978E] mt-1">Dokumentasi latihan rigging tebing &amp; apel kesiapan tim SAR.</p>
                    </div>
                    <div class="font-mono-tech text-[10px] text-[#8C978E] flex justify-between">
                        <span>POSKO: STIA LAN BANDUNG</span>
                        <span>06°53'24"S 107°36'18"E</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Closing CTA Band & Footer -->
    <section id="kolaborasi" class="max-w-7xl mx-auto border-x border-b border-[#27322A] bg-[#141A15]">
        <div class="p-8 sm:p-12 lg:p-16 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7">
                <span class="font-mono-tech text-xs text-[#F59E0B]">04 // KANAL KOORDINASI</span>
                <h2 class="font-display text-3xl sm:text-4xl font-extrabold uppercase mt-2">
                    Kolaborasi Ekspedisi, Pelatihan SAR &amp; Konservasi.
                </h2>
            </div>
            <div class="lg:col-span-5 flex flex-wrap gap-3 lg:justify-end">
                <a href="#tentang" class="px-6 py-3.5 bg-[#F59E0B] text-[#0D110E] font-mono-tech text-xs font-bold uppercase tracking-wider hover:bg-[#D97706]">
                    Tentang Kami
                </a>
                <a href="mailto:sekretariat@semarrimba-lan.org" class="px-6 py-3.5 border border-[#ECEAE2] text-[#ECEAE2] font-mono-tech text-xs font-bold uppercase tracking-wider hover:bg-[#ECEAE2] hover:text-[#0D110E]">
                    Kolaborasi dengan Kami
                </a>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="w-full lg:text-right font-mono-tech text-xs text-[#8C978E] hover:text-[#F59E0B] mt-1">
                    Instagram: https://www.instagram.com/semar_rimba/ ↗
                </a>
            </div>
        </div>
        <div class="px-8 py-4 border-t border-[#27322A] flex flex-col sm:flex-row justify-between font-mono-tech text-[10px] text-[#8C978E]">
            <span>SEMAR RIMBA // POLITEKNIK STIA LAN BANDUNG</span>
            <span>V2 // TECHNICAL EXPEDITION GEAR &amp; SAR</span>
        </div>
    </section>

</body>
</html>
