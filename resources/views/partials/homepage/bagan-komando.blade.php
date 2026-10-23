{{-- ========================================================
     BAGAN STRUKTUR KOMANDO SEMAR RIMBA 2024/2025
     (Matching Screenshot Section 8)
     ======================================================== --}}
<section id="bagan-komando" class="py-14 lg:py-16 bg-offwhite border-b border-stone-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-3">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-stone-500 block">ALUR KOMANDO &amp; KOORDINASI</span>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-stone-900 uppercase mt-0.5">
                    BAGAN STRUKTUR KOMANDO SEMAR RIMBA 2024/2025
                </h2>
            </div>
            <p class="text-xs text-stone-500 font-medium">
                Garis Komando Tegas, Sinergis &amp; Terdesentralisasi Lapangan
            </p>
        </div>

        {{-- Organogram Tree Visual Container --}}
        <div class="bg-white rounded-3xl border border-stone-200 p-5 sm:p-8 lg:p-10 shadow-xs overflow-hidden">
            {{-- Scrollable Container for Mobile Viewports to Prevent Global Page Overflow --}}
            <div class="overflow-x-auto pb-2 scrollbar-thin">
                <div class="min-w-[560px] max-w-4xl mx-auto flex flex-col items-center py-2">
                {{-- Level 1: Musyawarah Anggota & Dewan Penasihat --}}
                <div class="w-full flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-6">
                    <div class="px-6 py-3 rounded-full bg-white border border-stone-300 text-stone-900 font-extrabold text-xs tracking-wider shadow-xs uppercase">
                        MUSYAWARAH ANGGOTA (MUBES)
                    </div>
                    <div class="text-stone-400 font-bold text-lg hidden sm:block">⇄</div>
                    <div class="px-6 py-3 rounded-full bg-stone-100 border border-stone-300 text-stone-700 font-extrabold text-xs tracking-wider shadow-xs uppercase">
                        DEWAN PENASIHAT &amp; PEMBINA KAMPUS
                    </div>
                </div>

                {{-- Vertical Connector --}}
                <div class="w-px h-8 bg-stone-300 my-1"></div>

                {{-- Level 2: Presidium (Ketua Umum & Wakil Ketua) --}}
                <div class="w-full max-w-lg">
                    <div class="w-full py-3.5 px-8 rounded-full bg-stone-950 text-gold flex items-center justify-center gap-2.5 shadow-md border border-gold/30">
                        <svg class="size-4 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="font-black text-xs sm:text-sm tracking-widest uppercase">
                            KETUA UMUM &amp; WAKIL KETUA (PRESIDIUM)
                        </span>
                    </div>
                </div>

                {{-- Vertical Connector & Horizontal Bridge --}}
                <div class="w-px h-8 bg-stone-300 mt-1"></div>
                <div class="w-full max-w-md h-px bg-stone-300"></div>

                {{-- Level 3: Sekretariat Jenderal & Keuangan --}}
                <div class="w-full max-w-2xl grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200 text-center font-bold text-xs text-stone-800 shadow-xs">
                        Sekretariat Jenderal &amp; Basis Data
                    </div>
                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200 text-center font-bold text-xs text-stone-800 shadow-xs">
                        Perbendaharaan Korsa &amp; Penganggaran
                    </div>
                </div>

                {{-- Vertical Connector & Horizontal Bridge to 4 Matra --}}
                <div class="w-px h-8 bg-stone-300 my-1"></div>
                <div class="w-full max-w-3xl h-px bg-stone-300"></div>

                {{-- Level 4: 4 Matra Lapangan --}}
                <div class="w-full grid grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                    {{-- Matra 1 --}}
                    <div class="p-4 rounded-xl bg-stone-50 border border-stone-200 flex flex-col items-center text-center gap-2 hover:border-gold/50 transition">
                        <div class="size-9 rounded-lg bg-stone-900 text-gold flex items-center justify-center">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4" />
                            </svg>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wide text-stone-800">
                            DIV. GUNUNG HUTAN
                        </span>
                    </div>

                    {{-- Matra 2 --}}
                    <div class="p-4 rounded-xl bg-stone-50 border border-stone-200 flex flex-col items-center text-center gap-2 hover:border-gold/50 transition">
                        <div class="size-9 rounded-lg bg-stone-900 text-gold flex items-center justify-center">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wide text-stone-800">
                            DIV. PANJAT TEBING
                        </span>
                    </div>

                    {{-- Matra 3 --}}
                    <div class="p-4 rounded-xl bg-stone-50 border border-stone-200 flex flex-col items-center text-center gap-2 hover:border-gold/50 transition">
                        <div class="size-9 rounded-lg bg-stone-900 text-gold flex items-center justify-center">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                            </svg>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wide text-stone-800">
                            DIV. SUSUR GUA
                        </span>
                    </div>

                    {{-- Matra 4 --}}
                    <div class="p-4 rounded-xl bg-stone-50 border border-stone-200 flex flex-col items-center text-center gap-2 hover:border-gold/50 transition">
                        <div class="size-9 rounded-lg bg-stone-900 text-gold flex items-center justify-center">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                            </svg>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wide text-stone-800">
                            DIV. ARUNG JERAM
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

