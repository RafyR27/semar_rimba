<x-layouts::public :title="$activity->title.' — SEMAR RIMBA Politeknik STIA LAN Bandung'">
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
                    <a href="{{ route('kegiatan') }}"
                        class="inline-flex items-center py-1 px-1.5 -my-1 -mx-1.5 rounded-xs hover:text-gold transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                        Kegiatan
                    </a>
                </li>
                <li aria-hidden="true" class="text-stone-500 select-none">/</li>
                <li>
                    <span class="text-gold font-semibold" aria-current="page">{{ $activity->title }}</span>
                </li>
            </ol>
        </nav>

        <div class="max-w-3xl mx-auto mt-10 space-y-8">
            @if ($activityStatus !== 'published' && ! $activity->is_active)
                <div class="rounded-xl border border-amber-500/30 bg-amber-500/10 px-4 py-3 text-xs font-semibold text-amber-800">
                    Mode Pratinjau — Status kegiatan ini saat ini adalah <span class="uppercase">{{ $activityStatus }}</span> dan belum tayang untuk publik.
                </div>
            @endif

            {{-- Headline --}}
            <header class="space-y-4">
                <div class="flex flex-wrap items-center gap-3 text-[11px] font-bold text-gold uppercase tracking-widest">
                    <span>{{ $activity->category }}</span>
                    @if ($activity->event_date)
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ $activity->event_date->translatedFormat('d F Y') }}</span>
                    @endif
                    @if ($activity->location)
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ $activity->location }}</span>
                    @endif
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-content-dark leading-[1.15] text-balance">
                    {{ $activity->title }}
                </h1>
            </header>

            {{-- Image --}}
            @if ($activity->image_url)
                <figure class="rounded-xl overflow-hidden border border-white/10 shadow-xs">
                    <img src="{{ $activity->image_url }}" alt="{{ $activity->title }}"
                        class="w-full aspect-[16/9] object-cover object-center" loading="eager" />
                </figure>
            @endif

            {{-- Deskripsi --}}
            <div class="tiptap-prose text-base text-stone-700 leading-relaxed space-y-4">
                {!! $activity->description !!}
            </div>

            {{-- Back Navigation --}}
            <footer class="pt-6 border-t border-stone-200">
                <a href="{{ route('kegiatan') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-gold hover:underline transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-gold rounded-xs">
                    <span aria-hidden="true">&larr;</span>
                    <span>Kembali ke halaman kegiatan</span>
                </a>
            </footer>
        </div>
    </article>
</x-layouts::public>
