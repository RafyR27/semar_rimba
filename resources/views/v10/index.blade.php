<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMAR RIMBA — Alpine Telemetry & Weather Station (v10)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --v10-bone: #F6F6F2; --v10-ink: #121417; --v10-rule: #D0D4CD; --v10-flare: #E03E1A; }
        body { background-color: var(--v10-bone); color: var(--v10-ink); font-family: 'Space Grotesk', sans-serif; }
        .font-mono-tech { font-family: 'JetBrains Mono', monospace; font-variant-numeric: tabular-nums; }
        .baro-ticks {
            background-image: repeating-linear-gradient(to right, #121417 0 1px, transparent 1px 12px);
            background-size: 100% 10px;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#E03E1A] selection:text-white">

    <header class="border-b border-[#D0D4CD] bg-[#F6F6F2]/95 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-label="Wayang Semar Swiss">
                    <rect x="4" y="4" width="40" height="40"/>
                    <path d="M18 14c2-3 10-3 12 0 1 2 0 4-1 5 3 2 5 6 4 10-1 4-5 7-9 7s-8-3-9-7c-1-4 1-8 4-10-1-1-2-3-1-5Z"/>
                    <circle cx="24" cy="10" r="2" fill="#E03E1A" stroke="none"/>
                </svg>
                <span class="font-bold tracking-tight">SEMAR RIMBA // TELEMETRI</span>
            </div>
            <div class="hidden md:flex gap-6 font-mono-tech text-[11px] text-[#585E65]">
                <span>ELEV: 3.078 MDPL</span>
                <span>JARAK TEMPUH: 18.4 KM</span>
                <span>SUHU RATA²: 12.6 °C</span>
            </div>
            <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs border border-[#121417] px-3 py-1.5 hover:bg-[#121417] hover:text-white">@semar_rimba</a>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-6 pt-10 pb-14">
        <!-- Swiss Telemetry Modules -->
        <div class="grid grid-cols-2 lg:grid-cols-4 border border-[#121417] divide-x divide-y lg:divide-y-0 divide-[#121417] font-mono-tech mb-10">
            <div class="p-4"><span class="text-[10px] text-[#585E65] block">ELEVASI PUNCAK</span><span class="text-xl font-bold">3.078 MDPL</span></div>
            <div class="p-4"><span class="text-[10px] text-[#585E65] block">JARAK TEMPUH RUTE</span><span class="text-xl font-bold">18.4 KM</span></div>
            <div class="p-4"><span class="text-[10px] text-[#585E65] block">SUHU RATA² MEDAN</span><span class="text-xl font-bold">12.6 °C</span></div>
            <div class="p-4 bg-[#121417] text-white"><span class="text-[10px] text-[#E03E1A] block">KOORDINAT BASECAMP</span><span class="text-xl font-bold">06°53'S 107°36'E</span></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end mb-10">
            <div class="lg:col-span-7">
                <h1 class="text-4xl sm:text-6xl font-bold tracking-tight leading-[0.98]">
                    Stasiun Medan, Navigasi Rimba &amp; Operasi SAR Mahasiswa.
                </h1>
            </div>
            <div class="lg:col-span-5 flex flex-wrap gap-3 lg:justify-end">
                <a href="#tentang" class="px-6 py-3.5 bg-[#E03E1A] text-white font-mono-tech text-xs font-bold uppercase">Tentang Kami</a>
                <a href="#kolaborasi" class="px-6 py-3.5 border border-[#121417] text-[#121417] font-mono-tech text-xs font-bold uppercase hover:bg-[#121417] hover:text-white">Kolaborasi dengan Kami</a>
            </div>
        </div>

        <!-- Panoramic Sea-of-Clouds Hero Slot with Optical Crosshair -->
        <div class="border border-[#121417] bg-[#14181D] text-[#F6F6F2] aspect-[16/9] sm:aspect-[21/9] relative p-6 flex flex-col justify-between">
            <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-45">
                <div class="w-44 h-44 border border-white/60 relative flex items-center justify-center">
                    <div class="w-full h-px bg-white/60"></div>
                    <div class="h-full w-px bg-white/60 absolute"></div>
                    <div class="w-3 h-3 bg-[#E03E1A] absolute"></div>
                </div>
            </div>
            <div class="flex justify-between font-mono-tech text-[11px] relative z-10">
                <span class="text-[#E03E1A]">OROGRAPHIC_CLOUD_SEA // 21:9</span>
                <span>3.078 MDPL</span>
            </div>
            <div class="text-center relative z-10 my-auto">
                <p class="font-mono-tech text-xs uppercase tracking-widest">[Slot Visual Hero Lautan Awan Orografis]</p>
                <p class="text-xs text-[#9BA3AC] mt-1">Foto panorama lautan awan orografis dari puncak gunung dengan overlay garis bidik (crosshair) optik dan penanda ketinggian mdpl.</p>
            </div>
            <div class="flex justify-between font-mono-tech text-[10px] text-[#9BA3AC] relative z-10 border-t border-white/15 pt-3">
                <span>BARO: 710 hPa</span>
                <span>@semar_rimba</span>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6"><div class="h-3 border-t border-[#121417] baro-ticks"></div></div>

    <section id="tentang" class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-5">
            <span class="font-mono-tech text-xs text-[#E03E1A] font-bold">01 // IDENTITAS &amp; MATRA</span>
            <h2 class="text-3xl font-bold mt-2">Politeknik STIA LAN Bandung — Semar Rimba</h2>
            <p class="mt-3 text-sm text-[#585E65] leading-relaxed">Berlandaskan filosofi wayang Semar, organisasi ini membina kemampuan Gunung Hutan, Panjat Tebing, Susur Gua, serta Konservasi &amp; SAR berbasis data dan keselamatan.</p>
        </div>
        <div class="lg:col-span-7 grid grid-cols-2 gap-4 font-mono-tech text-xs">
            <div class="border border-[#121417] p-5"><strong>01 // GUNUNG HUTAN</strong><p class="mt-1 text-[#585E65]">Navigasi darat &amp; ekspedisi</p></div>
            <div class="border border-[#121417] p-5"><strong>02 // PANJAT TEBING</strong><p class="mt-1 text-[#585E65]">Rigging &amp; vertical rescue</p></div>
            <div class="border border-[#121417] p-5"><strong>03 // SUSUR GUA</strong><p class="mt-1 text-[#585E65]">SRT &amp; pemetaan karst</p></div>
            <div class="border border-[#121417] p-5"><strong>04 // KONSERVASI &amp; SAR</strong><p class="mt-1 text-[#585E65]">Riset flora &amp; tanggap bencana</p></div>
        </div>
    </section>

    <section id="kolaborasi" class="max-w-7xl mx-auto px-6 pb-16">
        <div class="border border-[#121417] bg-[#121417] text-[#F6F6F2] p-8 sm:p-12 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7">
                <span class="font-mono-tech text-xs text-[#E03E1A]">02 // KANAL RESMI</span>
                <h2 class="text-3xl sm:text-4xl font-bold mt-2">Kolaborasi Ekspedisi &amp; Konservasi Semar Rimba.</h2>
            </div>
            <div class="lg:col-span-5 flex flex-wrap gap-3 lg:justify-end">
                <a href="#tentang" class="px-6 py-3.5 bg-[#E03E1A] text-white font-mono-tech text-xs font-bold uppercase">Tentang Kami</a>
                <a href="mailto:sekretariat@semarrimba-lan.org" class="px-6 py-3.5 border border-[#F6F6F2] font-mono-tech text-xs font-bold uppercase hover:bg-[#F6F6F2] hover:text-[#121417]">Kolaborasi dengan Kami</a>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="w-full lg:text-right font-mono-tech text-xs text-[#9BA3AC] hover:text-[#E03E1A]">Instagram @semar_rimba ↗</a>
            </div>
        </div>
    </section>

</body>
</html>
