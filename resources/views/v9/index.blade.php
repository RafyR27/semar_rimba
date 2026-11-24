<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMAR RIMBA — Brutalist Trailhead & Elevation Log (v9)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=IBM+Plex+Mono:wght@400;600;700&family=Inter:wght@500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --v9-stone: #CFCBC2; --v9-black: #0B0B0B; --v9-blaze: #FDE047; }
        body { background-color: var(--v9-stone); color: var(--v9-black); font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
        .font-mono-tech { font-family: 'IBM Plex Mono', monospace; }
        .halftone-v9 {
            background-color: #141414;
            background-image: radial-gradient(rgba(253, 224, 71, 0.16) 1px, transparent 1px);
            background-size: 5px 5px;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#FDE047] selection:text-[#0B0B0B]">

    <header class="border-b-2 border-[#0B0B0B] bg-[#CFCBC2] sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-5 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" aria-label="Wayang Semar Signage">
                    <rect x="2" y="2" width="44" height="44" fill="#0B0B0B"/>
                    <path d="M17 13c3-4 11-4 14 0 1 2 0 4-1 5 3 2 5 6 4 11-1 5-5 8-10 8s-9-3-10-8c-1-5 1-9 4-11-1-1-2-3-1-5Z" fill="#FDE047"/>
                </svg>
                <div>
                    <span class="font-display text-2xl font-extrabold uppercase leading-none block">SEMAR RIMBA</span>
                    <span class="font-mono-tech text-[10px] font-bold">POSKO // 06°53'24"S · 768 MDPL</span>
                </div>
            </div>
            <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="bg-[#0B0B0B] text-[#FDE047] px-3.5 py-2 font-mono-tech text-xs font-bold uppercase">@semar_rimba ↗</a>
        </div>
    </header>

    <section class="border-b-2 border-[#0B0B0B] max-w-7xl mx-auto p-5 sm:p-10">
        <div class="flex flex-wrap gap-2 mb-6 font-mono-tech text-xs font-bold">
            <span class="bg-[#FDE047] border-2 border-[#0B0B0B] px-2.5 py-1">STEMPEL POSKO: SR-BDG-01</span>
            <span class="border-2 border-[#0B0B0B] px-2.5 py-1">ELEVASI: 768–3.078 MDPL</span>
        </div>
        <h1 class="font-display text-6xl sm:text-8xl font-extrabold uppercase leading-[0.88] tracking-tight">
            EKSPEDISI, SAR &amp; CATATAN MEDAN SEMAR RIMBA.
        </h1>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="#tentang" class="px-6 py-3.5 bg-[#FDE047] border-2 border-[#0B0B0B] font-mono-tech text-xs font-bold uppercase">Tentang Kami</a>
            <a href="#kolaborasi" class="px-6 py-3.5 bg-[#0B0B0B] text-[#CFCBC2] border-2 border-[#0B0B0B] font-mono-tech text-xs font-bold uppercase">Kolaborasi dengan Kami</a>
        </div>

        <div class="mt-8 border-2 border-[#0B0B0B] p-2 bg-[#DCD8CF]">
            <div class="aspect-[16/9] halftone-v9 text-[#CFCBC2] p-6 flex flex-col justify-between">
                <div class="flex justify-between font-mono-tech text-xs text-[#FDE047]">
                    <span>TRAILHEAD // APEL KEBERANGKATAN</span>
                    <span>16:9 HALFTONE</span>
                </div>
                <div class="text-center my-auto max-w-lg mx-auto">
                    <p class="font-display text-3xl font-bold uppercase text-[#FDE047]">[Slot Visual Hero Basecamp &amp; Tim]</p>
                    <p class="font-mono-tech text-xs mt-2">Foto sudut lebar dokumentasi apel keberangkatan tim atau basecamp tenda di tengah hutan dengan perlakuan halftone kontras tinggi.</p>
                </div>
                <div class="font-mono-tech text-[11px] flex justify-between border-t border-white/20 pt-3">
                    <span>06°53'24"S 107°36'18"E</span>
                    <span>@semar_rimba</span>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="border-b-2 border-[#0B0B0B] max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5 p-6 sm:p-10 border-b-2 lg:border-b-0 lg:border-r-2 border-[#0B0B0B]">
            <span class="font-mono-tech text-xs font-bold bg-[#0B0B0B] text-[#FDE047] px-2 py-0.5">01 // PROFIL</span>
            <h2 class="font-display text-4xl font-extrabold uppercase mt-3">Wadah Kepencintaalaman STIA LAN Bandung</h2>
            <p class="mt-4 text-sm leading-relaxed">
                Mengemban filosofi wayang Semar yang jujur dan membumi dalam empat matra: Gunung Hutan, Panjat Tebing, Susur Gua, serta Konservasi &amp; SAR.
            </p>
        </div>
        <div class="lg:col-span-7 p-6 sm:p-10 overflow-x-auto">
            <span class="font-mono-tech text-xs font-bold uppercase block mb-3">02 // TABEL LOG EKSPEDISI</span>
            <table class="w-full text-left border-2 border-[#0B0B0B] font-mono-tech text-xs">
                <thead class="bg-[#0B0B0B] text-[#FDE047]">
                    <tr>
                        <th class="p-3">KODE</th>
                        <th class="p-3">MEDAN</th>
                        <th class="p-3">KOORDINAT &amp; ELEVASI</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-[#0B0B0B]">
                    <tr><td class="p-3 font-bold">LOG-01</td><td class="p-3">Gn. Ciremai (GH)</td><td class="p-3">06°53'S 108°24'E · 3.078 MDPL</td></tr>
                    <tr><td class="p-3 font-bold">LOG-02</td><td class="p-3">Citatah 125 (PT)</td><td class="p-3">06°50'S 107°27'E · 915 MDPL</td></tr>
                    <tr><td class="p-3 font-bold">LOG-03</td><td class="p-3">Sanghyang Poek (SG)</td><td class="p-3">06°51'S 107°22'E · 380 MDPL</td></tr>
                    <tr><td class="p-3 font-bold bg-[#FDE047]">LOG-04</td><td class="p-3">Hulu Citarum (Konservasi)</td><td class="p-3">07°08'S 107°39'E · 1.420 MDPL</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section id="kolaborasi" class="bg-[#0B0B0B] text-[#CFCBC2]">
        <div class="max-w-7xl mx-auto p-6 sm:p-12 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            <div class="lg:col-span-7">
                <h2 class="font-display text-4xl sm:text-5xl font-extrabold uppercase text-white">KOLABORASI EKSPEDISI &amp; KONSERVASI</h2>
            </div>
            <div class="lg:col-span-5 flex flex-wrap gap-3 lg:justify-end">
                <a href="#tentang" class="px-6 py-3.5 bg-[#FDE047] text-[#0B0B0B] font-mono-tech text-xs font-bold uppercase">Tentang Kami</a>
                <a href="mailto:sekretariat@semarrimba-lan.org" class="px-6 py-3.5 border-2 border-[#CFCBC2] font-mono-tech text-xs font-bold uppercase">Kolaborasi dengan Kami</a>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="w-full lg:text-right font-mono-tech text-xs text-[#FDE047]">Instagram @semar_rimba ↗</a>
            </div>
        </div>
    </section>

</body>
</html>
