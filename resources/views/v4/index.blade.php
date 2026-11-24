<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMAR RIMBA — Brutalist Trailhead & Logbook (v4)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=IBM+Plex+Mono:wght@400;600;700&family=Inter:wght@500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --v4-stone: #CECCC4;
            --v4-stone-light: #DCDAD2;
            --v4-black: #0B0B0B;
            --v4-blaze: #FACC15;
        }
        body {
            background-color: var(--v4-stone);
            color: var(--v4-black);
            font-family: 'Inter', sans-serif;
        }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
        .font-mono-tech { font-family: 'IBM Plex Mono', monospace; }
        .halftone-slot {
            background-color: #161616;
            background-image: radial-gradient(rgba(250, 204, 21, 0.14) 1px, transparent 1px);
            background-size: 6px 6px;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#FACC15] selection:text-[#0B0B0B]">

    <!-- Brutalist Signage Header -->
    <header class="border-b-2 border-[#0B0B0B] bg-[#CECCC4] sticky top-0 z-40">
        <div class="max-w-7xl mx-auto grid grid-cols-12 items-stretch">
            <div class="col-span-7 md:col-span-4 px-4 sm:px-6 py-3 border-r-2 border-[#0B0B0B] flex items-center gap-3">
                <!-- Wayang Semar Brutalist Block Emblem -->
                <svg class="w-8 h-8 shrink-0" viewBox="0 0 48 48" fill="none" aria-label="Stempel Wayang Semar">
                    <rect x="2" y="2" width="44" height="44" fill="#0B0B0B"/>
                    <path d="M17 13c3-4 11-4 14 0 1 2 0 4-1 5 3 2 5 6 4 11-1 5-5 8-10 8s-9-3-10-8c-1-5 1-9 4-11-1-1-2-3-1-5Z" fill="#FACC15"/>
                    <path d="M20 23h3M25 23h3M19 30c3 2 7 2 10 0" stroke="#0B0B0B" stroke-width="2"/>
                </svg>
                <div>
                    <span class="font-display text-2xl font-extrabold uppercase tracking-tight leading-none block">SEMAR RIMBA</span>
                    <span class="font-mono-tech text-[10px] font-bold">POSKO: STIA LAN BANDUNG</span>
                </div>
            </div>

            <nav class="hidden md:flex col-span-5 items-center justify-around px-4 border-r-2 border-[#0B0B0B] font-mono-tech text-xs font-bold uppercase">
                <a href="#tentang" class="hover:bg-[#FACC15] px-2 py-1">Tentang</a>
                <a href="#logbook" class="hover:bg-[#FACC15] px-2 py-1">Logbook</a>
                <a href="#divisi" class="hover:bg-[#FACC15] px-2 py-1">Divisi</a>
                <a href="#kolaborasi" class="hover:bg-[#FACC15] px-2 py-1">Kolaborasi</a>
            </nav>

            <div class="col-span-5 md:col-span-3 px-4 py-3 flex items-center justify-end gap-2 bg-[#0B0B0B] text-[#FACC15]">
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs font-bold uppercase hover:underline">
                    IG @semar_rimba ↗
                </a>
            </div>
        </div>
    </header>

    <!-- HERO: Brutalist Trailhead Signage -->
    <section class="border-b-2 border-[#0B0B0B]">
        <div class="max-w-7xl mx-auto">
            <div class="px-4 sm:px-6 py-3 border-b-2 border-[#0B0B0B] bg-[#DCDAD2] flex flex-wrap justify-between gap-2 font-mono-tech text-xs font-bold">
                <span>BASECAMP // POSKO-BDG-01</span>
                <span>06°53'24"S 107°36'18"E</span>
                <span class="bg-[#FACC15] px-2">JALUR: EKSPEDISI · SAR · KONSERVASI</span>
            </div>

            <div class="p-4 sm:p-8 lg:p-10">
                <h1 class="font-display text-6xl sm:text-7xl lg:text-[6.5rem] font-extrabold uppercase leading-[0.88] tracking-tight">
                    GARDA ALAM BEBAS &amp; LOG EKSPEDISI MAHASISWA.
                </h1>

                <div class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                    <p class="lg:col-span-7 text-base sm:text-lg font-medium leading-snug">
                        Organisasi mahasiswa pecinta alam Politeknik STIA LAN Bandung. Berdiri di atas disiplin navigasi darat, ketangguhan tebing dan gua, serta aksi nyata pelestarian rimba.
                    </p>
                    <div class="lg:col-span-5 flex flex-wrap gap-3 lg:justify-end">
                        <a href="#tentang" class="px-5 py-3.5 bg-[#FACC15] border-2 border-[#0B0B0B] font-mono-tech text-xs font-bold uppercase hover:bg-[#0B0B0B] hover:text-[#FACC15] transition-colors">
                            Tentang Kami
                        </a>
                        <a href="#kolaborasi" class="px-5 py-3.5 bg-[#0B0B0B] text-[#CECCC4] border-2 border-[#0B0B0B] font-mono-tech text-xs font-bold uppercase hover:bg-[#FACC15] hover:text-[#0B0B0B] transition-colors">
                            Kolaborasi dengan Kami
                        </a>
                    </div>
                </div>

                <!-- Wide-angle Halftone Hero Slot -->
                <div class="mt-8 border-2 border-[#0B0B0B] p-2 bg-[#DCDAD2]">
                    <div class="aspect-[16/9] halftone-slot text-[#CECCC4] p-6 flex flex-col justify-between">
                        <div class="flex justify-between font-mono-tech text-xs">
                            <span class="bg-[#FACC15] text-[#0B0B0B] px-2 py-0.5 font-bold">POSKO // APEL KEBERANGKATAN</span>
                            <span>16:9 WIDE HALFTONE</span>
                        </div>
                        <div class="text-center max-w-lg mx-auto">
                            <p class="font-display text-2xl sm:text-3xl font-bold uppercase text-[#FACC15]">[Slot Visual Hero Wide-Angle]</p>
                            <p class="mt-2 font-mono-tech text-xs text-[#CECCC4]">
                                Foto sudut lebar dokumentasi apel keberangkatan tim atau basecamp tenda di tengah hutan dengan perlakuan halftone kontras tinggi.
                            </p>
                        </div>
                        <div class="flex justify-between font-mono-tech text-[11px] border-t border-white/20 pt-3">
                            <span>ELEVASI: 1.420 – 3.078 MDPL</span>
                            <span>@semar_rimba</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 1: Tentang & Stempel Posko -->
    <section id="tentang" class="border-b-2 border-[#0B0B0B]">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12">
            <div class="lg:col-span-4 p-6 sm:p-8 border-b-2 lg:border-b-0 lg:border-r-2 border-[#0B0B0B] bg-[#DCDAD2]">
                <div class="border-2 border-[#0B0B0B] p-4 bg-[#FACC15] inline-block font-mono-tech text-xs font-bold uppercase mb-4">
                    STEMPEL POSKO // SR-BDG
                </div>
                <h2 class="font-display text-4xl font-extrabold uppercase leading-none">FILOSOFI SEMAR &amp; DISIPLIN MEDAN</h2>
            </div>
            <div class="lg:col-span-8 p-6 sm:p-8 flex flex-col justify-between gap-6">
                <p class="text-base sm:text-lg font-medium leading-relaxed">
                    Nama <strong>Semar Rimba</strong> berakar pada figur wayang Semar: jujur, membumi, dan menjadi penuntun di tengah rimba. Kami menolak budaya mendaki tanpa ilmu; setiap anggota ditempa melalui pendidikan dasar, navigasi darat, dan tanggung jawab konservasi.
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-4 border-2 border-[#0B0B0B] divide-x-2 divide-y-2 sm:divide-y-0 divide-[#0B0B0B] font-mono-tech text-xs">
                    <div class="p-3 bg-[#DCDAD2]"><strong>GH</strong><br>Gunung Hutan</div>
                    <div class="p-3 bg-[#DCDAD2]"><strong>PT</strong><br>Panjat Tebing</div>
                    <div class="p-3 bg-[#DCDAD2]"><strong>SG</strong><br>Susur Gua</div>
                    <div class="p-3 bg-[#FACC15]"><strong>SAR</strong><br>Konservasi</div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: Dense Honest Expedition Logbook Table -->
    <section id="logbook" class="border-b-2 border-[#0B0B0B] bg-[#DCDAD2]">
        <div class="max-w-7xl mx-auto p-4 sm:p-8">
            <div class="flex flex-wrap justify-between items-end gap-4 mb-6">
                <div>
                    <span class="font-mono-tech text-xs font-bold uppercase bg-[#0B0B0B] text-[#FACC15] px-2 py-0.5">02 // FIELD LEDGER</span>
                    <h2 class="font-display text-4xl sm:text-5xl font-extrabold uppercase mt-2">Tabel Log Ekspedisi &amp; Rekam Jejak</h2>
                </div>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs font-bold underline">CATATAN @semar_rimba ↗</a>
            </div>

            <div class="overflow-x-auto border-2 border-[#0B0B0B] bg-[#CECCC4]">
                <table class="w-full text-left border-collapse font-mono-tech text-xs">
                    <thead>
                        <tr class="bg-[#0B0B0B] text-[#FACC15] uppercase">
                            <th class="p-3.5 border-r border-white/20">Kode Log</th>
                            <th class="p-3.5 border-r border-white/20">Lokasi / Medan</th>
                            <th class="p-3.5 border-r border-white/20">Elevasi</th>
                            <th class="p-3.5 border-r border-white/20">Matra</th>
                            <th class="p-3.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#0B0B0B]">
                        <tr>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B] font-bold">SR-LOG-01</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">Gn. Ciremai — Jalur Linggarjati</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">3.078 MDPL</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">Gunung Hutan</td>
                            <td class="p-3.5 font-bold">SELESAI // TERARSIP</td>
                        </tr>
                        <tr>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B] font-bold">SR-LOG-02</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">Tebing Citatah 125 — Bandung Barat</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">915 MDPL</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">Panjat Tebing</td>
                            <td class="p-3.5 font-bold">LATIHAN RUTIN</td>
                        </tr>
                        <tr>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B] font-bold">SR-LOG-03</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">Karst Sanghyang Poek — Rajamandala</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">380 MDPL</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">Susur Gua (SRT)</td>
                            <td class="p-3.5 font-bold">PEMETAAN</td>
                        </tr>
                        <tr>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B] font-bold">SR-LOG-04</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">Hulu DAS Citarum — Bandung Selatan</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">1.420 MDPL</td>
                            <td class="p-3.5 border-r-2 border-[#0B0B0B]">Konservasi &amp; SAR</td>
                            <td class="p-3.5 bg-[#FACC15] font-bold">PROGRAM AKTIF</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- SECTION 3: Divisi & Galeri Slot -->
    <section id="divisi" class="border-b-2 border-[#0B0B0B]">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 divide-y-2 md:divide-y-0 md:divide-x-2 divide-[#0B0B0B]">
            <div class="p-6 sm:p-8">
                <span class="font-mono-tech text-xs font-bold uppercase">[Slot Dokumentasi Lapangan 01]</span>
                <div class="mt-3 aspect-[4/3] border-2 border-[#0B0B0B] halftone-slot text-[#CECCC4] p-5 flex flex-col justify-between">
                    <span class="font-mono-tech text-[11px] text-[#FACC15]">TRAILHEAD // NAVDAR</span>
                    <span class="font-mono-tech text-xs text-center">[Foto Halftone Navigasi &amp; Peta Kontur]</span>
                    <span class="font-mono-tech text-[10px]">06°53'S 107°36'E</span>
                </div>
            </div>
            <div class="p-6 sm:p-8">
                <span class="font-mono-tech text-xs font-bold uppercase">[Slot Dokumentasi Lapangan 02]</span>
                <div class="mt-3 aspect-[4/3] border-2 border-[#0B0B0B] halftone-slot text-[#CECCC4] p-5 flex flex-col justify-between">
                    <span class="font-mono-tech text-[11px] text-[#FACC15]">VERTICAL // TEBING &amp; GUA</span>
                    <span class="font-mono-tech text-xs text-center">[Foto Halftone Rigging &amp; Vertical Rescue]</span>
                    <span class="font-mono-tech text-[10px]">SRT · ANCHOR · BELAY</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Closing CTA Band + Footer -->
    <section id="kolaborasi" class="bg-[#0B0B0B] text-[#CECCC4]">
        <div class="max-w-7xl mx-auto p-6 sm:p-10 lg:p-14 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7">
                <span class="font-mono-tech text-xs text-[#FACC15] uppercase">04 // PENUTUP &amp; KOLABORASI</span>
                <h2 class="font-display text-4xl sm:text-5xl font-extrabold uppercase mt-2 text-white">
                    GABUNG EKSPEDISI ATAU KEMITRAAN KONSERVASI.
                </h2>
            </div>
            <div class="lg:col-span-5 flex flex-wrap gap-3 lg:justify-end">
                <a href="#tentang" class="px-6 py-3.5 bg-[#FACC15] text-[#0B0B0B] font-mono-tech text-xs font-bold uppercase hover:bg-white">
                    Tentang Kami
                </a>
                <a href="mailto:sekretariat@semarrimba-lan.org" class="px-6 py-3.5 border-2 border-[#CECCC4] text-[#CECCC4] font-mono-tech text-xs font-bold uppercase hover:bg-[#CECCC4] hover:text-[#0B0B0B]">
                    Kolaborasi dengan Kami
                </a>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="w-full lg:text-right font-mono-tech text-xs text-[#FACC15] hover:underline">
                    Instagram @semar_rimba ↗
                </a>
            </div>
        </div>
        <div class="border-t border-white/20 px-6 py-4 max-w-7xl mx-auto flex justify-between font-mono-tech text-[10px]">
            <span>SEMAR RIMBA · POLITEKNIK STIA LAN BANDUNG</span>
            <span>V4 // BRUTALIST TRAILHEAD &amp; LOGBOOK</span>
        </div>
    </section>

</body>
</html>
