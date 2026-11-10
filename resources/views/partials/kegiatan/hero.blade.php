<section id="hero-kegiatan"
    class="relative overflow-hidden text-white flex flex-col justify-between bg-forest-dark min-h-[calc(88dvh-80px)] px-6 lg:px-30 pt-10 pb-10 lg:pt-16 lg:pb-12 border-b border-white/10">
    {{-- Atmospheric Expedition Backdrop --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden select-none z-0">
        <img src="{{ asset('images/gambar1.webp') }}"
            alt=""
            aria-hidden="true"
            role="presentation"
            width="1920"
            height="1280"
            class="size-full object-cover object-center opacity-30 scale-105"
            loading="eager"
            fetchpriority="high" />
        <div class="absolute inset-0 bg-linear-to-t from-forest-dark via-forest-dark/75 to-forest-dark/45"></div>
        <div class="absolute inset-0 bg-linear-to-r from-forest-dark via-forest-dark/65 to-transparent"></div>
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
                    <span class="text-gold font-semibold" aria-current="page">Kegiatan &amp; Agenda</span>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Main Editorial Headline & Section Jump Pills --}}
    <div class="relative z-10 my-auto py-10 lg:py-14 grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-10 lg:gap-12 items-end">
        <div class="md:col-span-7 lg:col-span-8 space-y-5">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-[1.08] text-balance">
                Katalog Kegiatan, Ekspedisi Medan, dan Pengabdian Ekologi
            </h1>

            <p class="text-base sm:text-lg text-stone-200 leading-relaxed text-pretty max-w-2xl">
                Dokumentasi resmi aktivitas operasional SEMAR RIMBA Politeknik STIA LAN Bandung yang mencakup pembinaan berjenjang kader rimbawan, penjelajahan teknis empat matra alam bebas, serta aksi konservasi lingkungan dan kemanusiaan.
            </p>

            {{-- Section Anchor Jump Pills --}}
            <div class="pt-3 flex flex-wrap items-center gap-3">
                <a href="#sorotan"
                    class="min-h-[44px] px-5 py-2.5 rounded-full bg-gold hover:bg-gold-hover text-stone-950 font-bold text-xs sm:text-sm tracking-wide transition shadow-lg inline-flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold active:scale-[0.98]">
                    <span>Sorotan Utama</span>
                    <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <a href="#kaderisasi"
                    class="min-h-[44px] px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/15 text-white border border-white/20 font-semibold text-xs sm:text-sm tracking-wide transition inline-flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold active:scale-[0.98]">
                    <span>Kaderisasi &amp; DIKLAT</span>
                </a>
                <a href="#ekspedisi"
                    class="min-h-[44px] px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/15 text-white border border-white/20 font-semibold text-xs sm:text-sm tracking-wide transition inline-flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold active:scale-[0.98]">
                    <span>Ekspedisi 4 Matra</span>
                </a>
                <a href="#konservasi"
                    class="min-h-[44px] px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/15 text-gold border border-gold/30 font-semibold text-xs sm:text-sm tracking-wide transition inline-flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold active:scale-[0.98]">
                    <span>Konservasi &amp; SAR</span>
                </a>
                <a href="#arsip"
                    class="min-h-[44px] px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/15 text-stone-200 border border-white/15 font-semibold text-xs sm:text-sm tracking-wide transition inline-flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold active:scale-[0.98]">
                    <span>Arsip Rekam Jejak</span>
                </a>
            </div>
        </div>

        {{-- Right Institutional Operational Cycle Summary Box --}}
        <div class="md:col-span-5 lg:col-span-4">
            <div class="p-6 sm:p-7 rounded-2xl bg-charcoal-surface/95 border border-white/15 shadow-xl space-y-4">
                <div class="flex items-center justify-between gap-4 border-b border-white/10 pb-4">
                    <div class="flex items-center gap-3.5">
                        <img src="{{ asset('images/logo.png') }}"
                            alt="Lambang SEMAR RIMBA"
                            width="48"
                            height="48"
                            class="size-12 object-contain shrink-0" />
                        <div>
                            <div class="text-base font-black text-white tracking-wide">SIKLUS KEGIATAN</div>
                            <p class="text-xs text-gold font-semibold">Kalender Operasional Tahunan</p>
                        </div>
                    </div>
                </div>
                <p class="text-sm text-stone-200 leading-relaxed">
                    Seluruh kegiatan lapangan direncanakan melalui Rapat Kerja kepengurusan, diawali dengan pembekalan teknis, manajemen risiko dan keselamatan (SOP), hingga evaluasi laporan perjalanan resmi.
                </p>
            </div>
        </div>
    </div>

    {{-- Bottom Operational Ledger Strip --}}
    <div class="relative z-10 pt-6 sm:pt-8 border-t border-white/15">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 md:gap-0 md:divide-x md:divide-white/20">
            <div class="md:pr-6">
                <p class="text-xs font-medium text-stone-300">Pilar Program Kerja</p>
                <p class="text-base sm:text-lg lg:text-xl font-black text-white mt-1">3 Rumpun Utama</p>
            </div>
            <div class="md:px-6">
                <p class="text-xs font-medium text-stone-300">Cakupan Spesialisasi</p>
                <p class="text-base sm:text-lg lg:text-xl font-black text-gold mt-1">4 Matra &amp; 2 Biro</p>
            </div>
            <div class="md:px-6">
                <p class="text-xs font-medium text-stone-300">Wilayah Eksplorasi</p>
                <p class="text-base sm:text-lg lg:text-xl font-black text-white mt-1">Jawa Barat &amp; Nusantara</p>
            </div>
            <div class="col-span-2 sm:col-span-1 md:pl-6">
                <p class="text-xs font-medium text-stone-300">Standar Pelaksanaan</p>
                <p class="text-base sm:text-lg lg:text-xl font-black text-white mt-1 leading-snug">Zero Accident &amp; Nir-Sampah</p>
            </div>
        </div>
    </div>
</section>

