<x-layouts::public :title="$berita->judul.' — SEMAR RIMBA Politeknik STIA LAN Bandung'">
    <article class="px-6 lg:px-30 py-12 lg:py-16">
        {{-- Top Breadcrumb Navigation --}}
        <nav aria-label="Breadcrumb" class="text-xs font-medium text-stone-500">
            <ol class="inline-flex items-center gap-2 list-none p-0 m-0">
                <li>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center py-1 px-1.5 -my-1 -mx-1.5 rounded-xs hover:text-gold transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                        Beranda
                    </a>
                </li>
                <li aria-hidden="true" class="text-stone-500 select-none">/</li>
                <li>
                    <a href="{{ route('berita.index') }}"
                        class="inline-flex items-center py-1 px-1.5 -my-1 -mx-1.5 rounded-xs hover:text-gold transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                        Berita &amp; Kabar
                    </a>
                </li>
                <li aria-hidden="true" class="text-stone-500 select-none">/</li>
                <li>
                    <span class="text-gold font-semibold" aria-current="page">{{ $berita->judul }}</span>
                </li>
            </ol>
        </nav>

        <div class="max-w-3xl mx-auto mt-10 space-y-8">
            {{-- Headline --}}
            <header class="space-y-4">
                <span class="text-[11px] font-bold text-gold uppercase tracking-widest">
                    {{ $berita->publicationDate()?->translatedFormat('d F Y') }}
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-content-dark leading-[1.15] text-balance">
                    {{ $berita->judul }}
                </h1>
            </header>

            {{-- Thumbnail --}}
            @if ($berita->thumbnail_url)
                <figure class="rounded-xl overflow-hidden border border-white/10 shadow-xs">
                    <img src="{{ $berita->thumbnail_url }}" alt="{{ $berita->judul }}"
                        class="w-full aspect-[16/9] object-cover object-center" loading="eager" />
                </figure>
            @endif

            {{-- Konten --}}
            <div class="text-base text-stone-700 leading-relaxed whitespace-pre-line space-y-4">
                {{ $berita->konten }}
            </div>

            {{-- Back Navigation --}}
            <footer class="pt-6 border-t border-stone-200">
                <a href="{{ route('berita.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-gold hover:underline transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-gold rounded-xs">
                    <span aria-hidden="true">&larr;</span>
                    <span>Kembali ke daftar berita</span>
                </a>
            </footer>
        </div>

        {{-- Related News --}}
        @if ($lainnya->isNotEmpty())
            <aside class="max-w-5xl mx-auto mt-16 pt-12 border-t border-stone-200">
                <h2 class="text-xl font-black text-content-dark">Berita Lainnya</h2>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-8">
                    @foreach ($lainnya as $item)
                        <a href="{{ route('berita.show', $item->slug) }}"
                            class="group flex flex-col bg-white rounded-xl overflow-hidden border border-white/10 shadow-xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <div class="relative aspect-[16/10] bg-forest-dark/10 overflow-hidden">
                                @if ($item->thumbnail_url)
                                    <img src="{{ $item->thumbnail_url }}" alt="{{ $item->judul }}"
                                        class="absolute inset-0 size-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                                        loading="lazy" />
                                @endif
                            </div>
                            <div class="flex flex-col flex-1 p-5">
                                <span class="text-[11px] font-bold text-gold uppercase tracking-widest">
                                    {{ $item->publicationDate()?->translatedFormat('d F Y') }}
                                </span>
                                <h3
                                    class="mt-2 text-base font-black text-content-dark leading-snug group-hover:text-gold transition-colors line-clamp-2">
                                    {{ $item->judul }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </aside>
        @endif
    </article>
</x-layouts::public>
