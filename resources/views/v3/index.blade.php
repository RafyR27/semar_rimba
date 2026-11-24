<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMAR RIMBA — Heritage & Conservation Manifesto (v3)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,700;0,9..144,800;1,9..144,500&family=Space+Mono:wght@400;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --v3-sage: #D8E1CE;
            --v3-cream: #F3EDE0;
            --v3-ink: #17271C;
            --v3-muted: #4A5B4E;
            --v3-terracotta: #B84A32;
        }
        body {
            background-color: var(--v3-cream);
            color: var(--v3-ink);
            font-family: 'Work Sans', sans-serif;
        }
        .font-display { font-family: 'Fraunces', serif; }
        .font-mono-tech { font-family: 'Space Mono', monospace; }
        .stamp-box {
            border: 2px solid var(--v3-terracotta);
            color: var(--v3-terracotta);
            transform: rotate(-3deg);
        }
    </style>
</head>
<body class="antialiased selection:bg-[#B84A32] selection:text-[#F3EDE0]">

    <!-- Editorial Heritage Header -->
    <header class="border-b border-[#17271C]/20 bg-[#F3EDE0]/95 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 h-18 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <!-- Wayang Semar Woodcut Crest -->
                <svg class="w-9 h-9 text-[#17271C]" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" aria-label="Cukil Wayang Semar">
                    <path d="M17 13c3-5 11-5 14 0 1 2 0 4-1 5 4 2 6 7 5 12-1 6-6 9-11 9s-10-3-11-9c-1-5 1-10 5-12-1-1-2-3-1-5Z" fill="#D8E1CE"/>
                    <path d="M20 20c2-1 6-1 8 0M19 25c1.5 1 3 1 4 0M25 25c1 1 2.5 1 4 0M18 31c3.5 2.5 8.5 2.5 12 0"/>
                    <circle cx="24" cy="8" r="2" fill="#B84A32" stroke="none"/>
                </svg>
                <div>
                    <span class="font-display text-xl font-bold tracking-tight block leading-none">Semar Rimba</span>
                    <span class="font-mono-tech text-[10px] text-[#4A5B4E]">ARSIP BOTANI &amp; KEPENCINTAALAMAN</span>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-8 text-xs font-mono-tech text-[#4A5B4E]">
                <a href="#tentang" class="hover:text-[#B84A32]">Manifesto</a>
                <a href="#divisi" class="hover:text-[#B84A32]">Matra</a>
                <a href="#arsip" class="hover:text-[#B84A32]">Arsip</a>
                <a href="#kolaborasi" class="hover:text-[#B84A32]">Kolaborasi</a>
            </nav>

            <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs px-3.5 py-1.5 border border-[#17271C] hover:bg-[#17271C] hover:text-[#F3EDE0] transition-colors">
                @semar_rimba
            </a>
        </div>
    </header>

    <!-- HERO: Asymmetric Editorial + Woodcut Stand-in -->
    <section class="bg-[#D8E1CE] border-b border-[#17271C]/20">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-12 lg:py-20 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7">
                <div class="inline-block stamp-box px-3 py-1 font-mono-tech text-[11px] font-bold uppercase tracking-widest mb-6">
                    CAP EKSPEDISI · 06°53'S 107°36'E
                </div>

                <h1 class="font-display text-5xl sm:text-6xl lg:text-[4.6rem] font-extrabold leading-[0.96] tracking-tight text-[#17271C]">
                    Merawat Tradisi Semar, Menjaga Napas Rimba Jawa.
                </h1>

                <p class="mt-6 text-base sm:text-lg text-[#2E3F32] leading-relaxed max-w-xl">
                    Wadah kepencintaalaman Politeknik STIA LAN Bandung yang memadukan kearifan tradisi Nusantara dengan ilmu ekspedisi alam bebas, pelatihan SAR, dan konservasi flora endemik.
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <a href="#tentang" class="px-6 py-3.5 bg-[#B84A32] text-[#F3EDE0] font-mono-tech text-xs font-bold uppercase tracking-wider hover:bg-[#9C3B26] transition-colors">
                        Tentang Kami
                    </a>
                    <a href="#kolaborasi" class="px-6 py-3.5 border-2 border-[#17271C] text-[#17271C] font-mono-tech text-xs font-bold uppercase tracking-wider hover:bg-[#17271C] hover:text-[#F3EDE0] transition-colors">
                        Kolaborasi dengan Kami
                    </a>
                    <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="font-mono-tech text-xs underline underline-offset-4 text-[#17271C] hover:text-[#B84A32]">
                        IG @semar_rimba ↗
                    </a>
                </div>
            </div>

            <!-- Right: Woodcut Illustration Stand-in -->
            <div class="lg:col-span-5">
                <div class="bg-[#F3EDE0] border-2 border-[#17271C] p-4">
                    <div class="aspect-[4/5] border border-[#17271C]/40 bg-[#EAE2D0] p-6 flex flex-col justify-between text-[#17271C]">
                        <div class="flex justify-between font-mono-tech text-[10px] text-[#4A5B4E]">
                            <span>PLAT CUKIL // 01</span>
                            <span>1.420 – 3.078 MDPL</span>
                        </div>
                        <div class="my-auto text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 text-[#17271C]" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.4">
                                <circle cx="32" cy="32" r="24" stroke-dasharray="2 2"/>
                                <path d="M32 10v44M10 32h44M22 22l20 20M42 22L22 42"/>
                                <circle cx="32" cy="32" r="6" fill="#B84A32" stroke="none"/>
                            </svg>
                            <p class="font-mono-tech text-xs uppercase font-bold">[Slot Ilustrasi Hero Cukil Kayu]</p>
                            <p class="mt-2 text-xs text-[#4A5B4E] leading-relaxed">
                                Ilustrasi cetak cukil kayu (woodcut/linework) flora endemik hutan Jawa dan simbol kompas dengan tinta hijau tua di atas latar krem.
                            </p>
                        </div>
                        <div class="border-t border-[#17271C]/25 pt-3 flex justify-between font-mono-tech text-[10px]">
                            <span>HERBARIUM &amp; KOMPAS</span>
                            <span class="text-[#B84A32]">@semar_rimba</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 1: Manifesto & Tradisi -->
    <section id="tentang" class="max-w-7xl mx-auto px-5 sm:px-8 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <div class="lg:col-span-5">
                <span class="font-mono-tech text-xs text-[#B84A32] uppercase tracking-widest">01 // Manifesto Konservasi</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold mt-2 leading-tight">
                    Alam bukan warisan nenek moyang, melainkan titipan yang harus dijaga dengan ilmu.
                </h2>
            </div>
            <div class="lg:col-span-7 space-y-5 text-base text-[#2E3F32] leading-relaxed">
                <p>
                    Terinspirasi dari sosok <strong>Semar</strong> dalam khazanah pewayangan Nusantara—pamong yang tenang, jujur, dan berdiri bersama rakyat serta alam—Semar Rimba menanamkan etika rimba bahwa setiap langkah di gunung, tebing, maupun gua wajib meninggalkan jejak kebaikan ekologis.
                </p>
                <div class="pt-4 border-t border-[#17271C]/20 grid grid-cols-2 sm:grid-cols-3 gap-4 font-mono-tech text-xs">
                    <div>
                        <span class="text-[#B84A32] block font-bold">TABAH &amp; LESTARI</span>
                        <span class="text-[#4A5B4E]">Motto Korsa</span>
                    </div>
                    <div>
                        <span class="text-[#17271C] block font-bold">STIA LAN BANDUNG</span>
                        <span class="text-[#4A5B4E]">Basis Kampus</span>
                    </div>
                    <div>
                        <span class="text-[#17271C] block font-bold">4 MATRA + SAR</span>
                        <span class="text-[#4A5B4E]">Bidang Gerak</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: Matra Operasional -->
    <section id="divisi" class="bg-[#D8E1CE]/55 border-y border-[#17271C]/20">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-16">
            <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <span class="font-mono-tech text-xs text-[#B84A32] uppercase tracking-widest">02 // Matra Keahlian</span>
                    <h2 class="font-display text-3xl sm:text-4xl font-bold mt-1">Empat Lini Pengabdian Alam</h2>
                </div>
                <span class="font-mono-tech text-xs text-[#4A5B4E]">GUNUNG HUTAN · PANJAT TEBING · SUSUR GUA · KONSERVASI</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-[#F3EDE0] border border-[#17271C]/30 p-7">
                    <span class="font-mono-tech text-xs text-[#B84A32] font-bold">DIV-01 // GUNUNG HUTAN</span>
                    <h3 class="font-display text-2xl font-bold mt-2">Navigasi Rimba &amp; Ekspedisi</h3>
                    <p class="mt-2 text-sm text-[#4A5B4E] leading-relaxed">Perintisan jalur pegunungan, orientasi peta kontur, botani praktis, dan ekspedisi lintas punggungan.</p>
                </div>
                <div class="bg-[#F3EDE0] border border-[#17271C]/30 p-7">
                    <span class="font-mono-tech text-xs text-[#B84A32] font-bold">DIV-02 // PANJAT TEBING</span>
                    <h3 class="font-display text-2xl font-bold mt-2">Teknik Vertikal &amp; Rescue</h3>
                    <p class="mt-2 text-sm text-[#4A5B4E] leading-relaxed">Pemanjatan tebing alam, manajemen tali, sistem anchor, serta pertolongan medan terjal.</p>
                </div>
                <div class="bg-[#F3EDE0] border border-[#17271C]/30 p-7">
                    <span class="font-mono-tech text-xs text-[#B84A32] font-bold">DIV-03 // SUSUR GUA</span>
                    <h3 class="font-display text-2xl font-bold mt-2">Eksplorasi &amp; Konservasi Karst</h3>
                    <p class="mt-2 text-sm text-[#4A5B4E] leading-relaxed">Teknik SRT, pemetaan lorong gua, dan pendataan ekosistem bawah tanah kawasan karst.</p>
                </div>
                <div class="bg-[#F3EDE0] border border-[#17271C]/30 p-7">
                    <span class="font-mono-tech text-xs text-[#B84A32] font-bold">DIV-04 // KONSERVASI &amp; SAR</span>
                    <h3 class="font-display text-2xl font-bold mt-2">Rehabilitasi &amp; Kemanusiaan</h3>
                    <p class="mt-2 text-sm text-[#4A5B4E] leading-relaxed">Penanaman pohon endemik, pemantauan keanekaragaman hayati, dan respon cepat SAR bencana.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: Arsip Ekspedisi Stand-in -->
    <section id="arsip" class="max-w-7xl mx-auto px-5 sm:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">
            <div class="md:col-span-5 bg-[#17271C] text-[#F3EDE0] p-8 flex flex-col justify-between">
                <div>
                    <span class="font-mono-tech text-xs text-[#D8E1CE]">03 // ARSIP KEGIATAN</span>
                    <h3 class="font-display text-3xl font-bold mt-3">Jejak Langkah di @semar_rimba</h3>
                    <p class="mt-4 text-sm text-[#D8E1CE]/85 leading-relaxed">
                        Setiap ekspedisi dicatat dalam log lapangan, dokumentasi foto, dan laporan konservasi untuk dibagikan kepada publik dan mitra kampus.
                    </p>
                </div>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="mt-8 inline-block font-mono-tech text-xs text-[#F3EDE0] underline underline-offset-4 hover:text-[#D8E1CE]">
                    Lihat Galeri @semar_rimba ↗
                </a>
            </div>
            <div class="md:col-span-7 border-2 border-[#17271C] bg-[#EAE2D0] p-6 flex flex-col justify-between min-h-[260px]">
                <div class="flex justify-between font-mono-tech text-[11px] text-[#4A5B4E]">
                    <span>ARSIP_VISUAL // 16:9</span>
                    <span>EXP-KONSERVASI-2025</span>
                </div>
                <div class="text-center my-auto">
                    <p class="font-mono-tech text-xs font-bold uppercase">[Slot Galeri Konservasi &amp; Ekspedisi]</p>
                    <p class="text-xs text-[#4A5B4E] mt-1">Dokumentasi penanaman bibit hutan &amp; observasi flora pegunungan.</p>
                </div>
                <div class="font-mono-tech text-[10px] text-[#B84A32] flex justify-between">
                    <span>07°11'S 107°44'E</span>
                    <span>JAWA BARAT</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Closing CTA Band + Footer -->
    <section id="kolaborasi" class="bg-[#17271C] text-[#F3EDE0] border-t-2 border-[#B84A32]">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-16 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7">
                <span class="font-mono-tech text-xs text-[#D8E1CE] uppercase tracking-widest">04 // Kolaborasi &amp; Kemitraan</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold mt-2">Mari Bergandengan Menjaga Rimba Nusantara.</h2>
            </div>
            <div class="lg:col-span-5 flex flex-wrap gap-3 lg:justify-end">
                <a href="#tentang" class="px-6 py-3.5 bg-[#B84A32] text-[#F3EDE0] font-mono-tech text-xs font-bold uppercase tracking-wider hover:bg-[#9C3B26]">
                    Tentang Kami
                </a>
                <a href="mailto:sekretariat@semarrimba-lan.org" class="px-6 py-3.5 border border-[#F3EDE0] text-[#F3EDE0] font-mono-tech text-xs font-bold uppercase tracking-wider hover:bg-[#F3EDE0] hover:text-[#17271C]">
                    Kolaborasi dengan Kami
                </a>
                <a href="https://www.instagram.com/semar_rimba/" target="_blank" rel="noopener" class="w-full lg:text-right font-mono-tech text-xs text-[#D8E1CE] hover:text-[#B84A32]">
                    Instagram @semar_rimba ↗
                </a>
            </div>
        </div>
        <div class="border-t border-white/15 px-5 sm:px-8 py-4 max-w-7xl mx-auto flex justify-between font-mono-tech text-[10px] text-[#D8E1CE]/70">
            <span>SEMAR RIMBA · POLITEKNIK STIA LAN BANDUNG</span>
            <span>V3 // HERITAGE &amp; CONSERVATION</span>
        </div>
    </section>

</body>
</html>
