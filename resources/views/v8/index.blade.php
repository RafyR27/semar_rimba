<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMAR RIMBA — Heritage & Conservation Manifesto (v8)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,700;0,9..144,800;1,9..144,500&family=Space+Mono:wght@400;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --v8-sage: #D8E0CE;
            --v8-cream: #F3EDE0;
            --v8-ink: #17261B;
            --v8-terracotta: #B84A32;
        }
        body { background-color: var(--v8-cream); color: var(--v8-ink); font-family: 'Work Sans', sans-serif; }
        .font-display { font-family: 'Fraunces', serif; }
        .font-mono-tech { font-family: 'Space Mono', monospace; }
    </style>
</head>
<body class="antialiased selection:bg-[#B84A32] selection:text-[#F3EDE0]">

    <header class="border-b border-[#17261B]/15 bg-[#F3EDE0]/95 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 h-18 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8 text-[#17261B]" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-label="Wayang Semar">
                    <path d="M17 13c3-5 11-5 14 0 1 2 0 4-1 5 4 2 6 7 5 12-1 6-6 9-11 9s-10-3-11-9c-1-5 1-10 5-12-1-1-2-3-1-5Z" fill="#D8E0CE"/>
                    <circle cx="24" cy="8" r="2" fill="#B84A32" stroke="none"/>
                </svg>
                <span class="font-display text-xl font-bold">Semar Rimba</span>
            </div>
            <nav class="hidden md:flex gap-8 font-mono-tech text-xs">
                <a href="#tentang" class="hover:text-[#B84A32]">Tentang</a>
                <a href="#manifesto" class="hover:text-[#B84A32]">Manifesto</a>
                <a href="#divisi" class="hover:text-[#B84A32]">Matra</a>
                <a href="#kolaborasi" class="hover:text-[#B84A32]">Kolaborasi</a>
            </nav>
            <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs border border-[#17261B] px-3 py-1.5 hover:bg-[#17261B] hover:text-[#F3EDE0]">@semar_rimba</a>
        </div>
    </header>

    <!-- HERO: Asymmetric Editorial -->
    <section class="bg-[#D8E0CE] border-b border-[#17261B]/20">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 py-14 lg:py-24 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7">
                <span class="inline-block border-2 border-[#B84A32] text-[#B84A32] px-3 py-1 font-mono-tech text-[11px] font-bold uppercase mb-6">
                    STEMPEL EKSPEDISI · 06°53'S 107°36'E
                </span>
                <h1 class="font-display text-5xl sm:text-6xl lg:text-[4.8rem] font-extrabold leading-[0.95] tracking-tight">
                    Akar Tradisi Nusantara, Napas Konservasi Rimba.
                </h1>
                <p class="mt-6 text-base sm:text-lg text-[#2D3E32] max-w-xl leading-relaxed">
                    Organisasi mahasiswa pecinta alam Politeknik STIA LAN Bandung. Menjaga keselarasan antara keilmuan alam bebas, tradisi Semar, dan pelestarian hutan tropis.
                </p>
                <div class="mt-9 flex flex-wrap gap-4 items-center">
                    <a href="#tentang" class="px-6 py-3.5 bg-[#B84A32] text-[#F3EDE0] font-mono-tech text-xs font-bold uppercase">Tentang Kami</a>
                    <a href="#kolaborasi" class="px-6 py-3.5 border-2 border-[#17261B] text-[#17261B] font-mono-tech text-xs font-bold uppercase hover:bg-[#17261B] hover:text-[#F3EDE0]">Kolaborasi dengan Kami</a>
                    <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs underline underline-offset-4">IG @semar_rimba ↗</a>
                </div>
            </div>
            <div class="lg:col-span-5">
                <div class="bg-[#F3EDE0] border-2 border-[#17261B] p-4">
                    <div class="aspect-[4/5] bg-[#EAE2D0] border border-[#17261B]/30 p-6 flex flex-col justify-between">
                        <span class="font-mono-tech text-[10px]">PLAT CUKIL // FLORA &amp; KOMPAS</span>
                        <div class="text-center my-auto">
                            <p class="font-mono-tech text-xs font-bold uppercase">[Slot Ilustrasi Hero Cukil Kayu]</p>
                            <p class="text-xs text-[#4A5B4E] mt-2">Ilustrasi cetak cukil kayu flora endemik hutan Jawa dan simbol kompas dengan tinta hijau tua di atas latar krem.</p>
                        </div>
                        <span class="font-mono-tech text-[10px] text-[#B84A32]">1.420 – 3.078 MDPL · @semar_rimba</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FULLSCREEN CONSERVATION MANIFESTO QUOTE BLOCK -->
    <section id="manifesto" class="min-h-[75vh] bg-[#17261B] text-[#F3EDE0] flex items-center py-20 px-6 sm:px-10 border-b border-[#B84A32]">
        <div class="max-w-5xl mx-auto text-center">
            <svg class="w-16 h-16 mx-auto mb-8 text-[#D8E0CE]" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.3">
                <path d="M22 16c3-7 17-7 20 0 2 4 0 8-2 10 5 3 8 10 6 18-2 8-8 13-14 13s-12-5-14-13c-2-8 1-15 6-18-2-2-4-6-2-10Z"/>
                <path d="M26 25c2-1.5 10-1.5 12 0M25 33c2 1.2 4 1.2 5.5 0M33.5 33c1.5 1.2 3.5 1.2 5.5 0M23 42c5 3.5 13 3.5 18 0"/>
            </svg>
            <span class="font-mono-tech text-xs text-[#B84A32] tracking-[0.25em] uppercase">MANIFESTO KONSERVASI SEMAR RIMBA</span>
            <blockquote class="font-display italic text-3xl sm:text-5xl lg:text-6xl leading-[1.15] mt-6">
                “Kami masuk ke rimba bukan untuk menaklukkan puncak, melainkan belajar membaca tanda alam, menolong sesama, dan memastikan hutan tetap bernapas bagi generasi mendatang.”
            </blockquote>
            <p class="mt-8 font-mono-tech text-xs text-[#D8E0CE]/80">TABAH · TERAMPIL · TANGGUH · LESTARI</p>
        </div>
    </section>

    <!-- SECTION 2: Matra -->
    <section id="tentang" class="max-w-7xl mx-auto px-6 sm:px-10 py-20">
        <div id="divisi" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="border border-[#17261B]/25 p-6 bg-[#D8E0CE]/40">
                <span class="font-mono-tech text-xs text-[#B84A32] font-bold">01 // GH</span>
                <h3 class="font-display text-2xl font-bold mt-2">Gunung Hutan</h3>
                <p class="mt-2 text-xs text-[#4A5B4E]">Navigasi darat &amp; ekspedisi rimba.</p>
            </div>
            <div class="border border-[#17261B]/25 p-6 bg-[#D8E0CE]/40">
                <span class="font-mono-tech text-xs text-[#B84A32] font-bold">02 // PT</span>
                <h3 class="font-display text-2xl font-bold mt-2">Panjat Tebing</h3>
                <p class="mt-2 text-xs text-[#4A5B4E]">Teknik vertikal &amp; vertical rescue.</p>
            </div>
            <div class="border border-[#17261B]/25 p-6 bg-[#D8E0CE]/40">
                <span class="font-mono-tech text-xs text-[#B84A32] font-bold">03 // SG</span>
                <h3 class="font-display text-2xl font-bold mt-2">Susur Gua</h3>
                <p class="mt-2 text-xs text-[#4A5B4E]">SRT &amp; konservasi kawasan karst.</p>
            </div>
            <div class="border border-[#17261B]/25 p-6 bg-[#D8E0CE]/40">
                <span class="font-mono-tech text-xs text-[#B84A32] font-bold">04 // SAR</span>
                <h3 class="font-display text-2xl font-bold mt-2">Konservasi</h3>
                <p class="mt-2 text-xs text-[#4A5B4E]">Riset flora &amp; respon bencana.</p>
            </div>
        </div>
    </section>

    <!-- Closing CTA Band -->
    <section id="kolaborasi" class="bg-[#17261B] text-[#F3EDE0] border-t-2 border-[#B84A32]">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 py-16 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7">
                <span class="font-mono-tech text-xs text-[#D8E0CE]">KOLABORASI &amp; KONTAK</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold mt-2">Bersama Merawat Warisan Rimba.</h2>
            </div>
            <div class="lg:col-span-5 flex flex-wrap gap-3 lg:justify-end">
                <a href="#tentang" class="px-6 py-3.5 bg-[#B84A32] text-[#F3EDE0] font-mono-tech text-xs font-bold uppercase">Tentang Kami</a>
                <a href="mailto:sekretariat@semarrimba-lan.org" class="px-6 py-3.5 border border-[#F3EDE0] text-[#F3EDE0] font-mono-tech text-xs font-bold uppercase hover:bg-[#F3EDE0] hover:text-[#17261B]">Kolaborasi dengan Kami</a>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="w-full lg:text-right font-mono-tech text-xs text-[#D8E0CE]">Instagram @semar_rimba ↗</a>
            </div>
        </div>
    </section>

</body>
</html>
