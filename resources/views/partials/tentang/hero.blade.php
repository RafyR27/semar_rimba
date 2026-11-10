<section id="hero-tentang"
    class="relative overflow-hidden text-white flex flex-col justify-between bg-forest-dark min-h-[calc(88dvh-80px)] px-6 lg:px-30 pt-10 pb-10 lg:pt-16 lg:pb-12 border-b border-white/10">
    {{-- Atmospheric Expedition Backdrop --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden select-none z-0">
        <img src="{{ asset('images/gambar2.webp') }}"
            alt=""
            aria-hidden="true"
            role="presentation"
            width="1920"
            height="1283"
            class="size-full object-cover object-center opacity-30 scale-105"
            loading="eager"
            fetchpriority="high" />
        <div class="absolute inset-0 bg-linear-to-t from-forest-dark via-forest-dark/70 to-forest-dark/40"></div>
        <div class="absolute inset-0 bg-linear-to-r from-forest-dark via-forest-dark/60 to-transparent"></div>
    </div>

    {{-- Top Breadcrumb Navigation --}}
    <div class="relative z-10">
        <nav aria-label="Breadcrumb" class="text-xs font-medium text-stone-300">
            <ol class="inline-flex items-center gap-2 list-none p-0 m-0">
                <li>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center py-1 px-1.5 -my-1 -mx-1.5 rounded-xs hover:text-gold transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                        Beranda
                    </a>
                </li>
                <li aria-hidden="true" class="text-stone-500 select-none">/</li>
                <li>
                    <span class="text-gold font-semibold" aria-current="page">Tentang Kami</span>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Main Editorial Headline & Narrative --}}
    <div class="relative z-10 my-auto py-10 lg:py-14 grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-10 lg:gap-12 items-end">
        <div class="md:col-span-7 lg:col-span-8 space-y-5">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-[1.08] text-balance">
                Menempa Karakter di Hutan Tropis, Mengabdi bagi Kemanusiaan
            </h1>

            <p class="text-base sm:text-lg text-stone-200 leading-relaxed text-pretty max-w-2xl">
                Sejak 17 Agustus 1998, Unit Kegiatan Mahasiswa Pecinta Alam SEMAR RIMBA Politeknik STIA LAN Bandung menjadi rumah pembinaan fisik, ketangguhan mental, keahlian penjelajahan lintas matra, dan pelestarian ekologi nusantara.
            </p>

            {{-- Section Anchor Jump Pills --}}
            <div class="pt-3 flex flex-wrap items-center gap-3">
                <a href="#sejarah"
                    class="min-h-[44px] px-5 py-2.5 rounded-full bg-gold hover:bg-gold-hover text-stone-950 font-bold text-xs sm:text-sm tracking-wide transition shadow-lg inline-flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold active:scale-[0.98]">
                    <span>Jejak Sejarah 1998</span>
                    <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <a href="#visi-misi"
                    class="min-h-[44px] px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/15 text-white border border-white/20 font-semibold text-xs sm:text-sm tracking-wide transition inline-flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold active:scale-[0.98]">
                    <span>Visi, Misi &amp; Nilai Korsa</span>
                </a>
                <a href="#syal-kuning"
                    class="min-h-[44px] px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/15 text-gold border border-gold/30 font-semibold text-xs sm:text-sm tracking-wide transition inline-flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold active:scale-[0.98]">
                    <span>Filosofi Syal Kuning</span>
                </a>
            </div>
        </div>

        {{-- Right Institutional Emblem & Motto Box --}}
        <div class="md:col-span-5 lg:col-span-4">
            <div class="p-6 sm:p-7 rounded-2xl bg-charcoal-surface/95 border border-white/15 shadow-xl space-y-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.png') }}"
                        alt="Lambang SEMAR RIMBA"
                        width="56"
                        height="56"
                        class="size-14 object-contain shrink-0" />
                    <div>
                        <div class="text-lg font-black text-white tracking-wide">SEMAR RIMBA</div>
                        <p class="text-xs text-gold font-semibold">Politeknik STIA LAN Bandung</p>
                    </div>
                </div>
                <blockquote class="text-sm text-stone-200 italic leading-relaxed border-t border-white/10 pt-4">
                    &ldquo;Tabah dalam tempaan medan, terampil menguasai teknik lapangan, tangguh menghadapi rintangan, dan lestari menjaga alam raya.&rdquo;
                </blockquote>
            </div>
        </div>
    </div>

    {{-- Bottom Identity Ledger Strip --}}
    <div class="relative z-10 pt-6 sm:pt-8 border-t border-white/15">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 md:gap-0 md:divide-x md:divide-white/20">
            <div class="md:pr-6">
                <p class="text-xs font-medium text-stone-300">Tanggal Berdiri</p>
                <p class="text-base sm:text-lg lg:text-xl font-black text-white mt-1">17 Agustus 1998</p>
            </div>
            <div class="md:px-6">
                <p class="text-xs font-medium text-stone-300">Pangkalan Induk</p>
                <p class="text-base sm:text-lg lg:text-xl font-black text-white mt-1">Kampus Hayam Wuruk</p>
            </div>
            <div class="md:px-6">
                <p class="text-xs font-medium text-stone-300">Kaderisasi Rimbawan</p>
                <p class="text-base sm:text-lg lg:text-xl font-black text-gold mt-1">32 Angkatan</p>
            </div>
            <div class="col-span-2 sm:col-span-1 md:pl-6">
                <p class="text-xs font-medium text-stone-300">Matra Operasional</p>
                <p class="text-base sm:text-lg lg:text-xl font-black text-white mt-1 leading-snug">Gunung, Tebing, Gua, Arung &amp; SAR</p>
            </div>
        </div>
    </div>
</section>

