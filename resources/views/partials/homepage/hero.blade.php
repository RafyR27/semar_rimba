<section id="hero"
    class="relative overflow-hidden text-white flex flex-col justify-end bg-[#080A08] min-h-[calc(100dvh-80px)] px-6 lg:px-35">
    {{-- Atmospheric Expedition Nature Backdrop Slider (Swiper) --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden select-none z-0">
        <div class="swiper hero-swiper size-full">
            <div class="swiper-wrapper size-full">
                <div class="swiper-slide size-full">
                    <img src="{{ asset('images/gambar2.webp') }}"
                        alt="SEMAR RIMBA - Ekspedisi Rimba"
                        class="size-full object-cover object-center opacity-35" loading="eager" />
                </div>
                <div class="swiper-slide size-full">
                    <img src="{{ asset('images/gambar1.webp') }}"
                        alt="SEMAR RIMBA - Penjelajahan Alam"
                        class="size-full object-cover object-center opacity-35" loading="lazy" />
                </div>
            </div>
        </div>
        <div class="absolute inset-0 bg-linear-to-t from-[#080A08] via-[#080A08]/40 to-transparent"></div>
    </div>

    {{-- Main Headline & CTA (Vertically Centered) --}}
    <div class="relative z-10 w-full flex flex-col justify-center">
        <div class="flex flex-col items-start">
            <div class="space-y-4 sm:space-y-5">
                <div>
                    <h1
                        class="text-5xl lg:text-6xl font-black tracking-wider text-white leading-[1.12] text-balance font-yellow drop-shadow-sm">
                        SEMAR RIMBA
                    </h1>
                    <p class="block text-sm lg:text-lg font-bold text-gold tracking-wide mt-2 leading-snug drop-shadow-sm">
                        UKM Pecinta Alam Politeknik STIA LAN Bandung
                    </p>
                </div>

                <p class="text-sm sm:text-base text-stone-200 leading-relaxed text-pretty max-w-2xl drop-shadow-xs">
                    Berdiri sejak tahun 1998 di lingkungan Politeknik STIA LAN Bandung, SEMAR RIMBA merupakan wadah
                    pembinaan karakter, penjelajahan alam bebas nusantara, serta pengabdian, dan kemanusiaan.
                </p>

                {{-- Primary and Secondary CTAs --}}
                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <a href="#tentang"
                        class="px-6 py-2.5 rounded-full bg-gold hover:bg-gold-hover text-stone-950 font-semibold text-sm tracking-wide transition shadow-lg inline-flex items-center gap-2 group focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2 focus-visible:ring-offset-[#080A08]">
                        <span>Mengenal Profil Kami</span>
                        <svg class="size-4 group-hover:translate-x-0.5 transition" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="relative w-full pb-6 sm:pb-8 mt-20 lg:mt-30">
                <div class="max-w-4xl mx-auto">
                    <div class="grid grid-cols-4 divide-x divide-white/30 text-center items-center">
                        {{-- Item 1 --}}
                        <div class="px-1.5 sm:px-4">
                            <p
                                class="italic font-bold text-white text-base sm:text-xl lg:text-2xl tracking-tight leading-tight">
                                Berdiri
                            </p>
                            <p class="text-[10px] sm:text-xs text-stone-300 font-sans tracking-wide mt-1">
                                Sejak 1998
                            </p>
                        </div>

                        {{-- Item 2 --}}
                        <div class="px-1.5 sm:px-4">
                            <p
                                class="italic font-bold text-white text-base sm:text-xl lg:text-2xl tracking-tight leading-tight">
                                4
                            </p>
                            <p class="text-[10px] sm:text-xs text-stone-300 font-sans tracking-wide mt-1">
                                Divisi
                            </p>
                        </div>

                        {{-- Item 3 --}}
                        <div class="px-1.5 sm:px-4">
                            <p
                                class="italic font-bold text-white text-base sm:text-xl lg:text-2xl tracking-tight leading-tight">
                                30
                            </p>
                            <p class="text-[10px] sm:text-xs text-stone-300 font-sans tracking-wide mt-1">
                                Anggota
                            </p>
                        </div>

                        {{-- Item 4 --}}
                        <div class="px-1.5 sm:px-4">
                            <p
                                class="italic font-bold text-white text-base sm:text-xl lg:text-2xl tracking-tight leading-tight">
                                Konservasi
                            </p>
                            <p class="text-[10px] sm:text-xs text-stone-300 font-sans tracking-wide mt-1">
                                Ekologi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Stats Bar (Matching Reference Image) --}}

</section>
