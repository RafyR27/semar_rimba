<section id="syal-kuning" class="scroll-mt-20 py-20 lg:py-28 bg-gold text-stone-950 relative overflow-hidden">
    <div class="relative w-full px-6 lg:px-35 space-y-14">
        {{-- Section Header & Story Lead --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-end">
            <div class="lg:col-span-7 space-y-4">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-black leading-tight text-balance">
                    Filosofi Syal Kuning: Setiap Helai Punya Cerita Tempaannya
                </h2>
                <p class="text-base sm:text-lg text-stone-900 leading-relaxed text-pretty">
                    Bagi keluarga besar SEMAR RIMBA, Syal Kuning bukan sekadar atribut kain di leher. Ia adalah kehormatan yang ditempuh melalui keringat, dinginnya kabut malam pegunungan, dan solidaritas korsa selama rangkaian Pendidikan &amp; Latihan Dasar.
                </p>
            </div>
            <div class="lg:col-span-5 lg:text-right">
                <a href="{{ route('home') }}#rangkaian"
                    class="px-6 py-3 rounded-full bg-[#080A08] hover:bg-stone-900 text-white font-bold text-xs sm:text-sm tracking-wide transition shadow-lg inline-flex items-center gap-2">
                    <span>Telusuri Tahapan Kaderisasi</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        {{-- Architectural Showcase Box (Dark Contrast Card + 3 Meaning Pillars) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            {{-- Left Visual Story Panel --}}
            <div class="lg:col-span-5 rounded-2xl overflow-hidden bg-[#080A08] text-white border border-stone-900 flex flex-col justify-between shadow-xl">
                <div class="relative h-64 sm:h-72 overflow-hidden">
                    <img src="{{ asset('images/gambar2.webp') }}"
                        alt="Pelantikan dan Penyematan Syal Kuning SEMAR RIMBA"
                        class="size-full object-cover"
                        loading="lazy" />
                    <div class="absolute inset-0 bg-linear-to-t from-[#080A08] via-[#080A08]/30 to-transparent"></div>
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-md bg-stone-950/90 border border-white/20 text-gold font-bold text-xs">
                        Identitas Rimbawan
                    </span>
                </div>

                <div class="p-6 sm:p-8 space-y-4">
                    <h3 class="text-xl sm:text-2xl font-black text-white leading-snug">
                        Mengapa Warna Kuning Emas?
                    </h3>
                    <p class="text-sm text-stone-300 leading-relaxed">
                        Di tengah lebatnya kanopi hutan hujan tropis dan kabut tebal pegunungan, warna kuning emas melambangkan <strong class="text-gold font-semibold">cahaya penuntun, kehangatan persaudaraan, dan visibilitas keselamatan</strong>. Sehelai syal kuning yang melingkar di leher mengingatkan pemiliknya bahwa ia tidak pernah berjalan sendirian.
                    </p>
                </div>
            </div>

            {{-- Right 3 Philosophical Stages / Meanings --}}
            <div class="lg:col-span-7 grid grid-cols-1 gap-6">
                {{-- Meaning 1 --}}
                <article class="p-6 sm:p-8 rounded-2xl bg-offwhite border border-stone-900/15 flex flex-col justify-between gap-3 shadow-xs">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <h3 class="text-lg sm:text-xl font-black text-stone-950">
                            Kawah Candradimuka &amp; Pembuktian Diri
                        </h3>
                        <span class="px-2.5 py-1 rounded bg-stone-900 text-gold font-bold text-xs">
                            Tahap Tempaan
                        </span>
                    </div>
                    <p class="text-sm sm:text-base text-stone-800 leading-relaxed">
                        Tidak ada jalan pintas menuju Syal Kuning. Setiap calon anggota wajib menuntaskan materi kelas, latihan fisik terukur, simulasi lapangan, hingga aplikasi DIKLAT di medan gunung hutan. Syal ini menjadi saksi bisu bagaimana keraguan diri diubah menjadi ketangguhan mental.
                    </p>
                </article>

                {{-- Meaning 2 --}}
                <article class="p-6 sm:p-8 rounded-2xl bg-offwhite border border-stone-900/15 flex flex-col justify-between gap-3 shadow-xs">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <h3 class="text-lg sm:text-xl font-black text-stone-950">
                            Ikatan Persaudaraan Lintas 32 Angkatan
                        </h3>
                        <span class="px-2.5 py-1 rounded bg-stone-900 text-gold font-bold text-xs">
                            Jiwa Korsa
                        </span>
                    </div>
                    <p class="text-sm sm:text-base text-stone-800 leading-relaxed">
                        Saat Syal Kuning disematkan, seorang anggota muda resmi menyandang nomor registrasi anggota dan terhubung dalam ikatan kekeluargaan abadi bersama ratusan rimbawan dan alumni SEMAR RIMBA sejak angkatan 1998.
                    </p>
                </article>

                {{-- Meaning 3 --}}
                <article class="p-6 sm:p-8 rounded-2xl bg-offwhite border border-stone-900/15 flex flex-col justify-between gap-3 shadow-xs">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <h3 class="text-lg sm:text-xl font-black text-stone-950">
                            Amanah Pengembaraan &amp; Pengabdian
                        </h3>
                        <span class="px-2.5 py-1 rounded bg-stone-900 text-gold font-bold text-xs">
                            Janji Rimbawan
                        </span>
                    </div>
                    <p class="text-sm sm:text-base text-stone-800 leading-relaxed">
                        Penyematan syal bukanlah garis akhir, melainkan awal dari tanggung jawab untuk mengembangkan spesialisasi matra, merawat alat dan sekretariat, menurunkan ilmu kepada generasi berikutnya, serta siap sedia saat panggilan kemanusiaan datang.
                    </p>
                </article>
            </div>
        </div>
    </div>
</section>

