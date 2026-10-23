<x-layouts::public :title="'Dewan Pengurus & Badan Pengurus Harian — SEMAR RIMBA Politeknik STIA LAN Bandung'">
    {{-- Section 2: Hero Gelap dengan Label, Headline, Deskripsi, Tahun & Statistik --}}
    @include('partials.homepage.hero')

    {{-- Section 3: Navigasi Kategori Pengurus & SK Dir --}}
    @include('partials.homepage.nav-tabs')

    {{-- Section 4: Struktur Tingkat I: Pucuk Pimpinan & Komando Operasi --}}
    @include('partials.homepage.tingkat-1-pimpinan')

    {{-- Section 5: Struktur Tingkat II: Sekretariat Jenderal & Keuangan Mandiri --}}
    @include('partials.homepage.tingkat-2-sekretariat')

    {{-- Section 6: Divisi Lapangan: Koordinator 4 Matra Operasional --}}
    @include('partials.homepage.divisi-matra')

    {{-- Section 7: Struktur Tingkat IV: Biro Khusus, SAR Kemanusiaan & Litbang --}}
    @include('partials.homepage.tingkat-4-biro')

    {{-- Section 8: Bagan Struktur Komando SEMAR RIMBA 2024/2025 --}}
    @include('partials.homepage.bagan-komando')

    {{-- Section 9: Struktur Penasihat & Alumni / Dewan Penasihat (DPO) --}}
    @include('partials.homepage.penasihat-alumni')

    {{-- Section 10: CTA Sekretariat untuk Audiensi & Kerjasama --}}
    @include('partials.homepage.cta-sekretariat')
</x-layouts::public>
