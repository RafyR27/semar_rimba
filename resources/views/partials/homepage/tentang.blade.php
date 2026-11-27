<section id="tentang" class="py-20 bg-offwhite text-stone-900 border-b border-stone-200">
    @php($profile = \App\Models\OrganizationProfile::current())
    <div class="max-w-7xl px-6 lg:px-35">
        {{-- Section Title & Intro --}}
        <div class="max-w-3xl">
            <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-stone-500 mb-2">
                {{ $profile?->displayName() ?? 'SEMAR RIMBA' }}
            </p>
            <h2
                class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-stone-900 leading-tight text-balance">
                TENTANG KAMI
            </h2>
            <p class="mt-4 text-base sm:text-lg text-stone-600 leading-relaxed text-pretty">
                {{ $profile?->deskripsi_singkat ?? 'Semar Rimba menghimpun mahasiswa Politeknik STIA LAN Bandung dalam dedikasi penjelajahan alam terbuka, kesiapsiagaan kemanusiaan, dan pelestarian ekologi nusantara.' }}
            </p>
            @if (filled($profile?->sejarah))
                <p class="mt-4 text-base sm:text-lg text-stone-600 leading-relaxed text-pretty">
                    {!! nl2br(e($profile->sejarah)) !!}
                </p>
            @else
                <p class="mt-4 text-base sm:text-lg text-stone-600 leading-relaxed text-pretty">
                    Didirikan pada tanggal <strong class="font-semibold text-stone-900">17 Agustus 1998</strong> di
                    kampus Politeknik STIA LAN Bandung, Unit Kegiatan Mahasiswa Pecinta Alam SEMAR RIMBA hadir sebagai
                    wahana pembentukan karakter mandiri dan kepemimpinan rimbawan muda. Organisasi ini memadukan
                    kedisiplinan akademis dengan keahlian teknis eksplorasi rimba raya Indonesia, operasi kemanusiaan (SAR),
                    dan advokasi kelestarian ekologi.
                </p>
            @endif
        </div>
    </div>
</section>
