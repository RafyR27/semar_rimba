<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMAR RIMBA — Cinematic Mist & Editorial Expedition (v6)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=IBM+Plex+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --v6-mist: #F4F5F3;
            --v6-mist-deep: #E8EBE7;
            --v6-charcoal: #222623;
            --v6-muted: #6C736D;
            --v6-orange: #D9531E;
        }
        body {
            background-color: var(--v6-mist);
            color: var(--v6-charcoal);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        .font-mono-tech { font-family: 'IBM Plex Mono', monospace; }
    </style>
</head>
<body class="antialiased selection:bg-[#D9531E] selection:text-white">

    <!-- Calm Cinematic Editorial Header -->
    <header class="border-b border-[#222623]/10 bg-[#F4F5F3]/90 backdrop-blur-xs sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <!-- Wayang Semar Subtle Silhouette Crest -->
                <svg class="w-8 h-8 text-[#222623]" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.2" aria-label="Siluet Wayang Semar">
                    <path d="M18 14c2-4 10-4 12 0 1 2 0 4-1 5 3 2 5 6 4 11-1 5-5 8-9 8s-8-3-9-8c-1-5 1-9 4-11-1-1-2-3-1-5Z"/>
                    <circle cx="24" cy="9" r="1.5" fill="#D9531E" stroke="none"/>
                </svg>
                <span class="font-display text-2xl font-semibold tracking-wide">SEMAR RIMBA</span>
            </div>

            <nav class="hidden md:flex items-center gap-10 text-xs uppercase tracking-[0.2em] text-[#6C736D]">
                <a href="#tentang" class="hover:text-[#222623] transition-colors">Tentang</a>
                <a href="#rute" class="hover:text-[#222623] transition-colors">Rute Medan</a>
                <a href="#kolaborasi" class="hover:text-[#222623] transition-colors">Kolaborasi</a>
            </nav>

            <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs text-[#222623] border-b border-[#D9531E] pb-0.5 hover:text-[#D9531E]">
                @semar_rimba
            </a>
        </div>
    </header>

    <!-- HERO: Serene Vast Scale (White Desert Inspiration) -->
    <section class="max-w-7xl mx-auto px-6 sm:px-10 pt-14 pb-20">
        <div class="max-w-4xl">
            <p class="font-mono-tech text-xs tracking-[0.2em] text-[#D9531E] uppercase mb-5">
                06°53'24"S 107°36'18"E · POLITEKNIK STIA LAN BANDUNG
            </p>
            <h1 class="font-display text-5xl sm:text-7xl lg:text-[5.5rem] font-medium leading-[0.98] tracking-tight text-[#222623]">
                Kesunyian Rimba, Keteguhan Langkah, dan Pengabdian Alam.
            </h1>
            <p class="mt-7 text-base sm:text-lg text-[#565D57] leading-relaxed max-w-2xl">
                Semar Rimba adalah organisasi mahasiswa pecinta alam yang menapaki jalur gunung hutan, tebing karst, dan gua dengan ketenangan ilmu navigasi serta kepedulian konservasi.
            </p>

            <div class="mt-10 flex flex-wrap items-center gap-5">
                <a href="#tentang" class="px-7 py-3.5 bg-[#222623] text-[#F4F5F3] text-xs uppercase tracking-[0.18em] font-medium hover:bg-[#D9531E] transition-colors">
                    Tentang Kami
                </a>
                <a href="#kolaborasi" class="px-7 py-3.5 border border-[#222623]/40 text-[#222623] text-xs uppercase tracking-[0.18em] font-medium hover:border-[#D9531E] hover:text-[#D9531E] transition-colors">
                    Kolaborasi dengan Kami
                </a>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs text-[#6C736D] hover:text-[#D9531E]">
                    IG @semar_rimba ↗
                </a>
            </div>
        </div>

        <!-- Monumental Landscape Mist Hero Slot -->
        <div class="mt-14 aspect-[16/9] w-full bg-[#2B312C] text-[#F4F5F3] p-8 sm:p-12 flex flex-col justify-between relative border border-[#222623]/15">
            <div class="flex justify-between font-mono-tech text-[11px] text-[#B8BFB8]">
                <span>EXPEDITION SCALE // 16:9 LANDSCAPE</span>
                <span>2.821 MDPL</span>
            </div>
            <div class="my-auto text-center max-w-lg mx-auto">
                <p class="font-display italic text-2xl sm:text-3xl text-[#F4F5F3]">[Slot Visual Hero Punggungan Berkabut]</p>
                <p class="mt-2 font-mono-tech text-xs text-[#B8BFB8]">
                    Foto lanskap layar penuh punggungan gunung berkabut dengan siluet tim ekspedisi berukuran kecil untuk menunjukkan skala alam yang megah.
                </p>
            </div>
            <div class="flex justify-between items-center font-mono-tech text-[11px] text-[#B8BFB8] border-t border-white/15 pt-4">
                <span>SEKRETARIAT BANDUNG</span>
                <span class="h-px flex-1 mx-4 bg-[#D9531E]/70"></span>
                <span>TITIK MEDAN EKSPEDISI</span>
            </div>
        </div>
    </section>

    <!-- SECTION 1: Tentang & Filosofi Wayang Semar -->
    <section id="tentang" class="border-t border-[#222623]/10 bg-[#E8EBE7]/60">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 py-20 lg:py-28 grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <div class="lg:col-span-5">
                <span class="font-mono-tech text-xs text-[#D9531E] tracking-widest uppercase">01 // Filosofi Organisasi</span>
                <h2 class="font-display text-4xl sm:text-5xl font-medium mt-3 leading-tight">
                    Akar Kebijaksanaan Semar di Tengah Alam Bebas.
                </h2>
            </div>
            <div class="lg:col-span-7 space-y-6 text-base text-[#49504A] leading-relaxed">
                <p>
                    Terinspirasi dari watak Semar dalam budaya Nusantara—pamong yang tenang, jujur, dan mengayomi—Semar Rimba membangun budaya kepencintaalaman yang jauh dari sikap ugal-ugalan. Kami melatih mahasiswa untuk membaca alam dengan rendah hati dan presisi teknis.
                </p>
                <p class="font-mono-tech text-xs text-[#222623] pt-4 border-t border-[#222623]/15">
                    MOTTO KORSA: TABAH · TERAMPIL · TANGGUH · LESTARI
                </p>
            </div>
        </div>
    </section>

    <!-- SECTION 2: Rute Perjalanan & Matra dengan GPS Coordinates di bawah setiap judul -->
    <section id="rute" class="max-w-7xl mx-auto px-6 sm:px-10 py-20 lg:py-28">
        <div class="mb-14">
            <span class="font-mono-tech text-xs text-[#D9531E] tracking-widest uppercase">02 // Rute &amp; Koordinat Divisi</span>
            <h2 class="font-display text-4xl sm:text-5xl font-medium mt-2">Dari Sekretariat Menuju Titik Medan</h2>
        </div>

        <div class="divide-y divide-[#222623]/15 border-y border-[#222623]/15">
            <div class="py-10 grid grid-cols-1 md:grid-cols-12 gap-6 items-baseline">
                <div class="md:col-span-5">
                    <h3 class="font-display text-3xl font-medium">Gunung Hutan</h3>
                    <span class="font-mono-tech text-xs text-[#D9531E] block mt-1">07°11'42"S 107°44'09"E · 2.665 MDPL</span>
                </div>
                <div class="md:col-span-7 text-sm text-[#565D57] leading-relaxed">
                    <span class="font-mono-tech text-[11px] text-[#222623] block mb-2">RUTE: Sekretariat STIA LAN Bandung ───▶ Punggungan Tropis Jawa Barat</span>
                    Navigasi darat, perintisan jalur rimba, dan manajemen ekspedisi pegunungan multi-hari.
                </div>
            </div>

            <div class="py-10 grid grid-cols-1 md:grid-cols-12 gap-6 items-baseline">
                <div class="md:col-span-5">
                    <h3 class="font-display text-3xl font-medium">Panjat Tebing</h3>
                    <span class="font-mono-tech text-xs text-[#D9531E] block mt-1">06°50'15"S 107°27'11"E · 915 MDPL</span>
                </div>
                <div class="md:col-span-7 text-sm text-[#565D57] leading-relaxed">
                    <span class="font-mono-tech text-[11px] text-[#222623] block mb-2">RUTE: Sekretariat STIA LAN Bandung ───▶ Kawasan Tebing Citatah</span>
                    Pemanjatan tebing alam, sistem penambatan ganda, dan teknik vertical rescue.
                </div>
            </div>

            <div class="py-10 grid grid-cols-1 md:grid-cols-12 gap-6 items-baseline">
                <div class="md:col-span-5">
                    <h3 class="font-display text-3xl font-medium">Susur Gua</h3>
                    <span class="font-mono-tech text-xs text-[#D9531E] block mt-1">06°51'02"S 107°22'40"E · 380 MDPL</span>
                </div>
                <div class="md:col-span-7 text-sm text-[#565D57] leading-relaxed">
                    <span class="font-mono-tech text-[11px] text-[#222623] block mb-2">RUTE: Sekretariat STIA LAN Bandung ───▶ Sistem Karst Rajamandala</span>
                    Single Rope Technique (SRT), pemetaan lorong bawah tanah, dan pelestarian ekosistem karst.
                </div>
            </div>

            <div class="py-10 grid grid-cols-1 md:grid-cols-12 gap-6 items-baseline">
                <div class="md:col-span-5">
                    <h3 class="font-display text-3xl font-medium">Konservasi &amp; SAR</h3>
                    <span class="font-mono-tech text-xs text-[#D9531E] block mt-1">07°08'18"S 107°39'55"E · 1.420 MDPL</span>
                </div>
                <div class="md:col-span-7 text-sm text-[#565D57] leading-relaxed">
                    <span class="font-mono-tech text-[11px] text-[#222623] block mb-2">RUTE: Sekretariat STIA LAN Bandung ───▶ Hulu Daerah Aliran Sungai</span>
                    Rehabilitasi hutan penyangga, riset flora endemik, dan kesiapsiagaan tim SAR kemanusiaan.
                </div>
            </div>
        </div>
    </section>

    <!-- Closing CTA Band + Footer -->
    <section id="kolaborasi" class="bg-[#222623] text-[#F4F5F3]">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 py-20 lg:py-24 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7">
                <span class="font-mono-tech text-xs text-[#D9531E] uppercase tracking-widest">03 // Kolaborasi Ekspedisi</span>
                <h2 class="font-display text-4xl sm:text-5xl font-medium mt-3 leading-tight">
                    Mari Melangkah Bersama Menjaga Kelestarian Rimba.
                </h2>
            </div>
            <div class="lg:col-span-5 flex flex-wrap gap-4 lg:justify-end">
                <a href="#tentang" class="px-7 py-3.5 bg-[#D9531E] text-white text-xs uppercase tracking-[0.18em] font-medium hover:bg-[#BF4414]">
                    Tentang Kami
                </a>
                <a href="mailto:sekretariat@semarrimba-lan.org" class="px-7 py-3.5 border border-[#F4F5F3]/50 text-[#F4F5F3] text-xs uppercase tracking-[0.18em] font-medium hover:bg-[#F4F5F3] hover:text-[#222623]">
                    Kolaborasi dengan Kami
                </a>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="w-full lg:text-right font-mono-tech text-xs text-[#B8BFB8] hover:text-[#D9531E]">
                    Instagram Resmi: @semar_rimba ↗
                </a>
            </div>
        </div>
        <div class="border-t border-white/10 px-6 sm:px-10 py-5 max-w-7xl mx-auto flex justify-between font-mono-tech text-[10px] text-[#B8BFB8]">
            <span>SEMAR RIMBA · POLITEKNIK STIA LAN BANDUNG</span>
            <span>V6 // CINEMATIC MIST &amp; EDITORIAL EXPEDITION</span>
        </div>
    </section>

</body>
</html>
