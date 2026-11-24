<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMAR RIMBA — Basecamp Telemetry & Weather Station (v5)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --v5-bone: #F7F7F3;
            --v5-panel: #EFEFE9;
            --v5-ink: #14171A;
            --v5-muted: #5F666D;
            --v5-rule: #D2D5CE;
            --v5-flare: #E13C1B;
        }
        body {
            background-color: var(--v5-bone);
            color: var(--v5-ink);
            font-family: 'DM Sans', sans-serif;
        }
        .font-mono-tech { font-family: 'JetBrains Mono', monospace; font-variant-numeric: tabular-nums; }
        .baro-scale {
            background-image: repeating-linear-gradient(to right, var(--v5-ink) 0 1px, transparent 1px 10px);
            background-size: 100% 8px;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#E13C1B] selection:text-white">

    <!-- Swiss Meteorological Header -->
    <header class="border-b border-[#D2D5CE] bg-[#F7F7F3]/95 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <!-- Wayang Semar Swiss Geometric Emblem -->
                <svg class="w-8 h-8 text-[#14171A]" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-label="Swiss Emblem Wayang Semar">
                    <rect x="4" y="4" width="40" height="40"/>
                    <path d="M18 14c2-3 10-3 12 0 1 2 0 4-1 5 3 2 5 6 4 10-1 4-5 7-9 7s-8-3-9-7c-1-4 1-8 4-10-1-1-2-3-1-5Z"/>
                    <circle cx="24" cy="10" r="2" fill="#E13C1B" stroke="none"/>
                </svg>
                <div>
                    <span class="font-bold tracking-tight text-base block leading-none">SEMAR RIMBA</span>
                    <span class="font-mono-tech text-[10px] text-[#5F666D]">STASIUN TELEMETRI &amp; EKSPEDISI</span>
                </div>
            </div>

            <div class="hidden lg:flex items-center gap-6 font-mono-tech text-[11px] text-[#5F666D]">
                <span>LAT -6.8900°</span>
                <span>LON 107.6050°</span>
                <span>BARO 856 hPa</span>
                <span class="text-[#E13C1B] font-bold">● SUAR AKTIF</span>
            </div>

            <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs px-3 py-1.5 border border-[#14171A] hover:bg-[#14171A] hover:text-[#F7F7F3]">
                @semar_rimba
            </a>
        </div>
    </header>

    <!-- HERO: Meteorological Swiss Grid -->
    <section class="max-w-7xl mx-auto px-5 sm:px-8 pt-10 pb-14">
        <!-- Telemetry Strip -->
        <div class="grid grid-cols-2 sm:grid-cols-4 border border-[#D2D5CE] bg-[#EFEFE9] divide-x divide-y sm:divide-y-0 divide-[#D2D5CE] font-mono-tech mb-10">
            <div class="p-4">
                <span class="text-[10px] text-[#5F666D] block">ELEVASI MEDAN</span>
                <span class="text-xl font-bold">768–3.078 MDPL</span>
            </div>
            <div class="p-4">
                <span class="text-[10px] text-[#5F666D] block">SUHU PUNCAK RATA²</span>
                <span class="text-xl font-bold">11.4 °C</span>
            </div>
            <div class="p-4">
                <span class="text-[10px] text-[#5F666D] block">KOORDINAT POSKO</span>
                <span class="text-xl font-bold">06°53'S 107°36'E</span>
            </div>
            <div class="p-4">
                <span class="text-[10px] text-[#5F666D] block">KESIAPSIAGAAN</span>
                <span class="text-xl font-bold text-[#E13C1B]">4 MATRA + SAR</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end mb-10">
            <div class="lg:col-span-8">
                <h1 class="text-4xl sm:text-6xl font-bold tracking-tight leading-[1.02]">
                    Data Lapangan, Navigasi Presisi, dan Pengabdian Rimba.
                </h1>
            </div>
            <div class="lg:col-span-4 flex flex-col gap-4">
                <p class="text-sm text-[#5F666D] leading-relaxed">
                    UKM Pecinta Alam Politeknik STIA LAN Bandung. Mengukur setiap risiko medan dengan ilmu pengetahuan, instrumentasi navigasi, dan solidaritas tim.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#tentang" class="px-5 py-3 bg-[#E13C1B] text-white font-mono-tech text-xs font-bold uppercase hover:bg-[#C23013]">
                        Tentang Kami
                    </a>
                    <a href="#kolaborasi" class="px-5 py-3 border border-[#14171A] text-[#14171A] font-mono-tech text-xs font-bold uppercase hover:bg-[#14171A] hover:text-white">
                        Kolaborasi dengan Kami
                    </a>
                </div>
            </div>
        </div>

        <!-- Panoramic Hero Slot with Optical Crosshair -->
        <div class="border border-[#14171A] bg-[#14171A] text-[#F7F7F3] aspect-[16/9] sm:aspect-[21/9] relative p-6 flex flex-col justify-between">
            <!-- Optical Crosshair Overlay -->
            <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-40">
                <div class="w-40 h-40 border border-[#F7F7F3] relative flex items-center justify-center">
                    <div class="w-full h-px bg-[#F7F7F3]"></div>
                    <div class="h-full w-px bg-[#F7F7F3] absolute"></div>
                    <div class="w-3 h-3 border border-[#E13C1B] bg-[#E13C1B]/30 absolute"></div>
                </div>
            </div>

            <div class="flex justify-between font-mono-tech text-[11px] relative z-10">
                <span class="text-[#E13C1B]">OPTIC_PANORAMA // 21:9</span>
                <span>ALT_MARKER: 2.821 MDPL</span>
            </div>

            <div class="text-center relative z-10 my-auto">
                <p class="font-mono-tech text-xs uppercase tracking-widest">[Slot Visual Hero Panorama &amp; Crosshair]</p>
                <p class="text-xs text-[#A3AAB0] mt-1">Foto panorama punggungan gunung atau awan orografis dengan overlay garis bidik optik teropong.</p>
            </div>

            <div class="flex justify-between font-mono-tech text-[10px] text-[#A3AAB0] relative z-10 border-t border-white/15 pt-3">
                <span>VISIBILITY: 1.8 KM</span>
                <span>AZIMUTH: 042° NE</span>
                <span>@semar_rimba</span>
            </div>
        </div>
    </section>

    <!-- Barometric Scale Divider -->
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="h-4 border-t border-[#14171A] baro-scale"></div>
    </div>

    <!-- SECTION 1: Tentang & Filosofi Semar -->
    <section id="tentang" class="max-w-7xl mx-auto px-5 sm:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <span class="font-mono-tech text-xs text-[#E13C1B] font-bold">01 // PROFIL ORGANISASI</span>
                <h2 class="text-3xl font-bold tracking-tight mt-2">Akar Tradisi Semar &amp; Keilmuan Rimba</h2>
            </div>
            <div class="lg:col-span-8 text-base text-[#363B40] leading-relaxed space-y-4">
                <p>
                    Semar Rimba memadukan keteladanan tokoh wayang Semar—penjaga keseimbangan yang bersahaja dan tangguh—dengan pendekatan ekspedisi modern berbasis data medan, meteorologi gunung, dan keselamatan terukur.
                </p>
                <p>
                    Seluruh anggota menempuh pelatihan teknis lintas matra untuk mendukung misi penjelajahan, penelitian konservasi, dan operasi SAR kemanusiaan.
                </p>
            </div>
        </div>
    </section>

    <!-- SECTION 2: 4 Matra Swiss Modules -->
    <section class="border-y border-[#D2D5CE] bg-[#EFEFE9]">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-16">
            <span class="font-mono-tech text-xs text-[#E13C1B] font-bold">02 // MODUL DIVISI OPERASIONAL</span>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 border border-[#D2D5CE] bg-[#F7F7F3] divide-y md:divide-y-0 md:divide-x divide-[#D2D5CE]">
                <div class="p-6">
                    <span class="font-mono-tech text-[11px] text-[#5F666D]">MOD-01</span>
                    <h3 class="text-lg font-bold mt-1">Gunung Hutan</h3>
                    <p class="mt-2 text-xs text-[#5F666D] leading-relaxed">Navigasi darat, orientasi peta topografi, dan ekspedisi rimba.</p>
                </div>
                <div class="p-6">
                    <span class="font-mono-tech text-[11px] text-[#5F666D]">MOD-02</span>
                    <h3 class="text-lg font-bold mt-1">Panjat Tebing</h3>
                    <p class="mt-2 text-xs text-[#5F666D] leading-relaxed">Teknik pemanjatan vertikal, sistem anchor, dan evakuasi tebing.</p>
                </div>
                <div class="p-6">
                    <span class="font-mono-tech text-[11px] text-[#5F666D]">MOD-03</span>
                    <h3 class="text-lg font-bold mt-1">Susur Gua</h3>
                    <p class="mt-2 text-xs text-[#5F666D] leading-relaxed">Single Rope Technique (SRT) dan pemetaan kawasan karst.</p>
                </div>
                <div class="p-6">
                    <span class="font-mono-tech text-[11px] text-[#5F666D]">MOD-04</span>
                    <h3 class="text-lg font-bold mt-1">Konservasi &amp; SAR</h3>
                    <p class="mt-2 text-xs text-[#5F666D] leading-relaxed">Riset flora-fauna, rehabilitasi DAS, dan operasi SAR tanggap bencana.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Closing CTA Band + Footer -->
    <section id="kolaborasi" class="max-w-7xl mx-auto px-5 sm:px-8 py-16">
        <div class="border border-[#14171A] bg-[#14171A] text-[#F7F7F3] p-8 sm:p-12 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7">
                <span class="font-mono-tech text-xs text-[#E13C1B]">03 // KANAL KOLABORASI</span>
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight mt-2">Terhubung dengan Stasiun Basecamp Semar Rimba.</h2>
            </div>
            <div class="lg:col-span-5 flex flex-wrap gap-3 lg:justify-end">
                <a href="#tentang" class="px-6 py-3.5 bg-[#E13C1B] text-white font-mono-tech text-xs font-bold uppercase">
                    Tentang Kami
                </a>
                <a href="mailto:sekretariat@semarrimba-lan.org" class="px-6 py-3.5 border border-[#F7F7F3] text-[#F7F7F3] font-mono-tech text-xs font-bold uppercase hover:bg-[#F7F7F3] hover:text-[#14171A]">
                    Kolaborasi dengan Kami
                </a>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="w-full lg:text-right font-mono-tech text-xs text-[#A3AAB0] hover:text-[#E13C1B]">
                    Instagram @semar_rimba ↗
                </a>
            </div>
        </div>
        <div class="mt-6 flex justify-between font-mono-tech text-[10px] text-[#5F666D]">
            <span>SEMAR RIMBA · POLITEKNIK STIA LAN BANDUNG</span>
            <span>V5 // BASECAMP TELEMETRY &amp; WEATHER STATION</span>
        </div>
    </section>

</body>
</html>
