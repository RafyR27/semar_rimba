<section id="divisi" class="py-20 bg-offwhite text-stone-900 border-b border-stone-200">
    <div class="w-full px-6 lg:px-35">
        <div class="mb-8 max-w-2xl">
            <p class="text-xs font-black uppercase tracking-[0.2em] text-amber-700">SEMAR RIMBA</p>
            <h2 class="mt-2 text-3xl sm:text-4xl font-black tracking-tight text-stone-900">Divisi Operasional Lapangan</h2>
            <p class="mt-4 text-base text-stone-600 leading-relaxed">Spesialisasi penjelajahan alam bebas yang menjadi fondasi kompetensi teknis, disiplin keselamatan, dan penguasaan medan setiap rimbawan SEMAR RIMBA.</p>
        </div>

        @if (isset($divisis) && $divisis->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($divisis as $divisi)
                    <article class="relative min-h-56 overflow-hidden rounded-2xl bg-stone-900 border border-stone-200 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=900&auto=format&fit=crop" alt="{{ $divisi->title }}" class="absolute inset-0 size-full object-cover opacity-65" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#080A08] via-[#080A08]/45 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-6 text-white">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-amber-300">{{ $divisi->matra ?? 'Divisi' }}</p>
                            <h3 class="mt-1 text-xl font-black">{{ $divisi->title }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-stone-200">{{ $divisi->desc }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="rounded-xl border border-stone-200 bg-white p-6 text-sm text-stone-600">Belum ada divisi aktif yang ditampilkan.</p>
        @endif

        <div class="mt-8">
            <a href="#kontak" class="inline-flex items-center gap-2 text-sm font-black text-stone-900 hover:text-amber-700 transition-colors">Konsultasi &amp; Gabung Divisi <span aria-hidden="true">↗</span></a>
        </div>
    </div>
</section>
