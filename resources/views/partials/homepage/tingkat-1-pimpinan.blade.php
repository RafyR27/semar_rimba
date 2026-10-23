{{-- ========================================================
     STRUKTUR TINGKAT I: PUCUK PIMPINAN & KOMANDO OPERASI
     (Matching Screenshot Section 4)
     ======================================================== --}}
<section id="pimpinan" class="py-14 lg:py-16 bg-offwhite border-b border-stone-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-3">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-stone-500 block">STRUKTUR TINGKAT I</span>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-stone-900 uppercase mt-0.5">
                    PUCUK PIMPINAN &amp; KOMANDO OPERASI
                </h2>
            </div>
            <p class="text-xs text-stone-500 font-medium">
                Pengambilan Keputusan Tertinggi &amp; Tanggung Jawab Operasional
            </p>
        </div>

        {{-- 2 Executive Horizontal Cards --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Card 1: Ketua Umum --}}
            <article class="bg-white rounded-2xl border border-stone-200 p-5 shadow-xs flex flex-col sm:flex-row gap-5 hover:border-gold/60 transition group">
                {{-- Member Photo Container --}}
                <div class="relative w-full sm:w-48 h-64 sm:h-auto rounded-xl overflow-hidden bg-stone-900 shrink-0">
                    <img
                        src="https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=800&auto=format&fit=crop"
                        alt="Foto Ketua Umum Fachri Ramadhan"
                        class="size-full object-cover object-center group-hover:scale-105 transition duration-500"
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <span class="absolute bottom-2.5 left-2.5 px-2 py-0.5 rounded bg-black/80 border border-white/20 text-white font-mono text-[10px] font-bold">
                        SR-XXVI-001
                    </span>
                </div>

                {{-- Member Profile Details --}}
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <span class="px-2.5 py-0.5 rounded-full bg-gold text-stone-950 font-bold text-[10px] tracking-wider uppercase">
                                KETUA UMUM
                            </span>
                        </div>

                        <h3 class="text-lg font-black text-stone-900 leading-snug">
                            Fachri "Kancil" Ramadhan
                        </h3>
                        <p class="text-xs text-stone-500 mt-0.5">
                            Angkatan XXVI / Rimba Peneliti &bull; Administrasi Pembangunan Negara
                        </p>

                        {{-- Quote Box --}}
                        <div class="mt-3.5 p-3 rounded-xl bg-stone-50 border border-stone-100 text-xs italic text-stone-600 leading-relaxed">
                            "Memimpin ekspedisi bukan sekadar mencapai puncak, melainkan memastikan setiap jiwa anggota pulang dengan selamat dan berkarakter baja."
                        </div>

                        {{-- Skill & Role Tags --}}
                        <div class="mt-3.5 flex flex-wrap gap-1.5">
                            <span class="px-2 py-0.5 rounded bg-stone-100 border border-stone-200 text-stone-700 text-[10px] font-medium">Navigasi Darat</span>
                            <span class="px-2 py-0.5 rounded bg-stone-100 border border-stone-200 text-stone-700 text-[10px] font-medium">Manajemen Ekspedisi</span>
                            <span class="px-2 py-0.5 rounded bg-stone-100 border border-stone-200 text-stone-700 text-[10px] font-medium">Jaga Toleransi</span>
                        </div>
                    </div>

                    {{-- Card Footer Contact / Action --}}
                    <div class="mt-4 pt-3 border-t border-stone-100 flex items-center justify-between text-xs text-stone-500">
                        <span class="font-mono text-[11px] text-stone-600 flex items-center gap-1.5">
                            <svg class="size-3.5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            KETUA@SEMARRIMBA-LAN.ORG
                        </span>
                        <div class="flex items-center gap-1.5 text-stone-400">
                            <svg class="size-4 hover:text-stone-700 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <svg class="size-4 hover:text-stone-700 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Card 2: Wakil Ketua Operasional --}}
            <article class="bg-white rounded-2xl border border-stone-200 p-5 shadow-xs flex flex-col sm:flex-row gap-5 hover:border-gold/60 transition group">
                {{-- Member Photo Container --}}
                <div class="relative w-full sm:w-48 h-64 sm:h-auto rounded-xl overflow-hidden bg-stone-900 shrink-0">
                    <img
                        src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?q=80&w=800&auto=format&fit=crop"
                        alt="Foto Wakil Ketua Operasional Dimas Pratama"
                        class="size-full object-cover object-center group-hover:scale-105 transition duration-500"
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <span class="absolute bottom-2.5 left-2.5 px-2 py-0.5 rounded bg-black/80 border border-white/20 text-white font-mono text-[10px] font-bold">
                        SR-XXVI-012
                    </span>
                </div>

                {{-- Member Profile Details --}}
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <span class="px-2.5 py-0.5 rounded-full bg-stone-100 border border-stone-300 text-stone-800 font-bold text-[10px] tracking-wider uppercase">
                                WAKIL KETUA OPERASIONAL
                            </span>
                        </div>

                        <h3 class="text-lg font-black text-stone-900 leading-snug">
                            Dimas "Cadas" Pratama
                        </h3>
                        <p class="text-xs text-stone-500 mt-0.5">
                            Angkatan XXVI / Sriti Prawira &bull; Manajemen Sumber Daya
                        </p>

                        {{-- Description Paragraph --}}
                        <p class="mt-3.5 text-xs text-stone-600 leading-relaxed">
                            Bertanggung jawab atas kesiapsiagaan operasional 4 matra, sinkronisasi jadwal latihan bina fisik, pengawalan disiplin korsa, dan mobilisasi armada lapangan.
                        </p>

                        {{-- Skill & Role Tags --}}
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            <span class="px-2 py-0.5 rounded bg-stone-100 border border-stone-200 text-stone-700 text-[10px] font-medium">Mountaineering</span>
                            <span class="px-2 py-0.5 rounded bg-stone-100 border border-stone-200 text-stone-700 text-[10px] font-medium">Logistik Taktis</span>
                        </div>
                    </div>

                    {{-- Card Footer Contact / Action --}}
                    <div class="mt-4 pt-3 border-t border-stone-100 flex items-center justify-between text-xs text-stone-500">
                        <span class="font-mono text-[11px] text-stone-600 flex items-center gap-1.5">
                            <svg class="size-3.5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            WAKETUA@SEMARRIMBA-LAN.ORG
                        </span>
                        <span class="text-[11px] font-semibold text-stone-600">
                            Latihan Taktis Matra
                        </span>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

