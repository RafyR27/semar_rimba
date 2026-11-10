<section id="sorotan" class="scroll-mt-20 py-20 lg:py-28 bg-offwhite text-stone-900 border-b border-stone-200">
    <div class="w-full px-6 lg:px-35 space-y-14">
        {{-- Section Header --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
            <div class="lg:col-span-8 space-y-4">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-stone-900 leading-tight text-balance">
                    Sorotan Kegiatan Utama Organisasi
                </h2>
                <p class="text-base sm:text-lg text-stone-700 leading-relaxed text-pretty max-w-2xl">
                    Tiga agenda inti tahunan yang menjadi tolok ukur keberhasilan pembinaan anggota, pencapaian eksplorasi medan, dan kontribusi nyata SEMAR RIMBA bagi lingkungan serta masyarakat.
                </p>
            </div>
            <div class="lg:col-span-4 lg:text-right">
                <a href="#kaderisasi"
                    class="inline-flex items-center gap-2 text-xs sm:text-sm font-black text-stone-900 hover:text-moss transition-colors">
                    <span>Telusuri Katalog Lengkap</span>
                    <svg class="size-4 text-stone-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Architectural Featured Showcase Container --}}
        <div class="rounded-2xl lg:rounded-3xl overflow-hidden bg-white border border-stone-200 shadow-xs">
            {{-- Lead Feature: DIKLAT & Pengembaraan Syal Kuning --}}
            <article class="grid grid-cols-1 lg:grid-cols-12 border-b border-stone-200">
                <div class="lg:col-span-7 relative min-h-[300px] sm:min-h-[380px] lg:min-h-[440px] bg-stone-900 overflow-hidden">
                    <img src="{{ asset('images/gambar1.webp') }}"
                        alt="Pendidikan dan Latihan Dasar DIKLAT Lapangan SEMAR RIMBA"
                        class="size-full object-cover"
                        loading="lazy" />
                    <div class="absolute inset-0 bg-linear-to-t from-[#080A08]/85 via-[#080A08]/20 to-transparent"></div>
                    <div class="absolute top-4 left-4 right-4 flex flex-wrap items-center justify-between gap-2">
                        <span class="px-3 py-1 rounded-md bg-[#080A08]/90 border border-white/20 text-gold font-bold text-xs">
                            Agenda Wajib Tahunan
                        </span>
                        <span class="px-3 py-1 rounded-md bg-stone-950/85 border border-white/15 text-white font-semibold text-xs">
                            Siklus Semester Ganjil &ndash; Genap
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6 sm:right-6 text-white">
                        <p class="text-xs sm:text-sm text-stone-200 font-medium">
                            Medan Operasi: Kawasan Pegunungan &amp; Hutan Tropis Jawa Barat
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-5 p-6 sm:p-10 lg:p-12 flex flex-col justify-between gap-8 bg-white">
                    <div class="space-y-4">
                        <h3 class="text-xl sm:text-2xl lg:text-3xl font-black text-stone-950 leading-tight tracking-tight">
                            Pendidikan &amp; Latihan Dasar (DIKLAT) serta Pengembaraan Syal Kuning
                        </h3>
                        <p class="text-sm sm:text-base text-stone-700 leading-relaxed">
                            Gerbang kaderisasi utama bagi calon rimbawan Politeknik STIA LAN Bandung. Seluruh peserta ditempa melalui kurikulum ruang dan simulasi lapangan yang menguji ketahanan fisik, manajemen logistik perjalanan, navigasi darat kompas-peta, pendirian bivak tropis, serta survival hutan.
                        </p>
                        <p class="text-sm text-stone-700 leading-relaxed">
                            Rangkaian ini berlanjut pada masa bimbingan anggota muda dan pengembaraan matra sebagai syarat mutlak sebelum penyematan Syal Kuning dan pemberian Nomor Registrasi Anggota.
                        </p>
                    </div>

                    <div class="pt-6 border-t border-stone-200 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-stone-600">Kompetensi Inti</p>
                            <p class="text-sm font-black text-stone-950 mt-0.5">Navigasi, Bivak &amp; PPGD</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-stone-600">Output Kaderisasi</p>
                            <p class="text-sm font-black text-stone-950 mt-0.5">Pelantikan Syal Kuning</p>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Bottom 2 Secondary Flagship Highlights --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-stone-200">
                {{-- Highlight 2: Ekspedisi Lintas Matra --}}
                <article class="p-6 sm:p-10 lg:p-12 flex flex-col justify-between gap-6">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="text-xl sm:text-2xl font-black text-stone-950 tracking-tight">
                                Ekspedisi &amp; Riset Lintas Matra
                            </h3>
                            <span class="px-2.5 py-1 rounded bg-[#080A08] text-gold font-bold text-xs shrink-0">
                                Penjelajahan Teknis
                            </span>
                        </div>
                        <p class="text-sm sm:text-base text-stone-700 leading-relaxed">
                            Operasi penjelajahan berkala yang memadukan perintisan jalur gunung hutan, pemetaan jalur panjat tebing alam, eksplorasi lorong gua karst (speleologi), dan pengarungan sungai berarus deras. Setiap ekspedisi menghasilkan laporan teknis, peta topografi jalur, dan dokumentasi keanekaragaman hayati.
                        </p>
                    </div>
                    <div class="pt-5 border-t border-stone-200 flex flex-wrap items-center justify-between gap-4 text-xs font-bold text-stone-800">
                        <span>Cakupan: Gunung Hutan, Tebing, Gua &amp; Arung Jeram</span>
                        <a href="#ekspedisi" class="text-moss hover:underline inline-flex items-center gap-1">
                            <span>Detail 4 Matra</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </article>

                {{-- Highlight 3: Bakti Lingkungan & Operasi SAR --}}
                <article class="p-6 sm:p-10 lg:p-12 flex flex-col justify-between gap-6">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="text-xl sm:text-2xl font-black text-stone-950 tracking-tight">
                                Bakti Lingkungan, Reboisasi &amp; Siaga SAR
                            </h3>
                            <span class="px-2.5 py-1 rounded bg-moss text-white font-bold text-xs shrink-0">
                                Pengabdian &amp; Kemanusiaan
                            </span>
                        </div>
                        <p class="text-sm sm:text-base text-stone-700 leading-relaxed">
                            Wujud pengabdian Tri Dharma Perguruan Tinggi melalui penanaman bibit pohon endemik di kawasan hulu DAS, operasi bersih jalur pendakian, edukasi mitigasi bencana bagi masyarakat desa penyangga hutan, serta pengiriman personel Satgas SAR dalam operasi kemanusiaan.
                        </p>
                    </div>
                    <div class="pt-5 border-t border-stone-200 flex flex-wrap items-center justify-between gap-4 text-xs font-bold text-stone-800">
                        <span>Pelaksana: Biro Konservasi, SAR &amp; Litbang</span>
                        <a href="#konservasi" class="text-moss hover:underline inline-flex items-center gap-1">
                            <span>Detail Program Aksi</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

