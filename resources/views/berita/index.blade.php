<x-layouts::public :title="'Berita & Kabar Rimba — SEMAR RIMBA Politeknik STIA LAN Bandung'">
    <section
        class="relative overflow-hidden text-white bg-forest-dark min-h-[280px] flex flex-col justify-center px-6 lg:px-30 pt-10 pb-12 lg:pt-16 lg:pb-14 border-b border-white/10">
        {{-- Atmospheric Backdrop --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden select-none z-0">
            <img src="{{ asset('images/gambar1.webp') }}" alt="" aria-hidden="true" role="presentation" width="1920"
                height="1280" class="size-full object-cover object-center opacity-30 scale-105" loading="eager" />
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
                        <span class="text-gold font-semibold" aria-current="page">Berita &amp; Kabar</span>
                    </li>
                </ol>
            </nav>
        </div>

        {{-- Headline --}}
        <div class="relative z-10 my-auto py-10 lg:py-12 space-y-4 max-w-3xl">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-[1.08] text-balance">
                Berita &amp; Kabar Rimba
            </h1>
            <p class="text-base sm:text-lg text-stone-300 leading-relaxed max-w-2xl">
                Kabar terbaru, laporan ekspedisi, dan catatan aksi kepecintaan alam resmi dari UKM Mapala Semar Rimba
                Politeknik STIA LAN Bandung.
            </p>
        </div>
    </section>

    <section class="px-6 lg:px-30 py-14 lg:py-20">
        @if ($beritas->isEmpty())
            <div class="max-w-xl mx-auto text-center py-16">
                <div
                    class="w-12 h-12 rounded-full bg-forest-dark/10 flex items-center justify-center mx-auto mb-4 text-forest-dark/60">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h2 class="text-xl font-black text-content-dark">Belum Ada Berita</h2>
                <p class="text-sm text-stone-600 mt-2">
                    Belum ada berita yang telah diterbitkan. Silakan kembali lagi nanti untuk kabar terbaru dari kami.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($beritas as $berita)
                    <article
                        class="group flex flex-col bg-white rounded-xl overflow-hidden border border-white/10 shadow-xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <a href="{{ route('berita.show', $berita->slug) }}" class="flex flex-col h-full">
                            <div class="relative aspect-[16/10] bg-forest-dark/10 overflow-hidden">
                                @if ($berita->thumbnail_url)
                                    <img src="{{ $berita->thumbnail_url }}" alt="{{ $berita->judul }}"
                                        class="absolute inset-0 size-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                                        loading="lazy" />
                                @endif
                            </div>

                            <div class="flex flex-col flex-1 p-6">
                                <span class="text-[11px] font-bold text-gold uppercase tracking-widest">
                                    {{ $berita->publicationDate()?->translatedFormat('d F Y') }}
                                </span>
                                <h2
                                    class="mt-2 text-lg font-black text-content-dark leading-snug group-hover:text-gold transition-colors">
                                    {{ $berita->judul }}
                                </h2>
                                <p class="mt-2 text-sm text-stone-600 leading-relaxed line-clamp-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($berita->konten), 160) }}
                                </p>
                                <span
                                    class="mt-auto pt-4 text-sm font-bold text-gold inline-flex items-center gap-1 group-hover:gap-2 transition-all">
                                    Baca selengkapnya
                                    <span aria-hidden="true">&rarr;</span>
                                </span>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            @if ($beritas->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $beritas->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </section>
</x-layouts::public>
