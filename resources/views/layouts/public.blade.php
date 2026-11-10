@php
    // Dynamic query with safe fallback when database tables/models exist in the future
    $kegiatans = class_exists(\App\Models\Kegiatan::class) && \Illuminate\Support\Facades\Schema::hasTable('kegiatans')
        ? \App\Models\Kegiatan::latest()->take(4)->get()
        : collect([
            (object) [
                'title' => 'Pendidikan & Latihan Dasar (DIKLAT)',
                'desc' => 'Kaderisasi wajib calon rimbawan baru untuk ketahanan fisik, mental, dan teknik navigasi darat.',
                'url' => '#kaderisasi',
                'badge' => 'Wajib',
            ],
            (object) [
                'title' => 'Ekspedisi Rimba Tropis',
                'desc' => 'Penjelajahan dan perintisan jalur alam bebas pada kawasan pegunungan tropis nusantara.',
                'url' => '#ekspedisi',
                'badge' => 'Ekspedisi',
            ],
            (object) [
                'title' => 'Bakti Lingkungan & Konservasi',
                'desc' => 'Aksi nyata advokasi kelestarian ekologi, penanaman bibit pohon, dan operasi bersih gunung.',
                'url' => '#konservasi',
                'badge' => 'Sosial',
            ],
        ]);

    $divisis = class_exists(\App\Models\Divisi::class) && \Illuminate\Support\Facades\Schema::hasTable('divisis')
        ? \App\Models\Divisi::all()
        : collect([
            (object) [
                'title' => 'Gunung Hutan',
                'desc' => 'Navigasi darat, perintisan jalur rimba, bivak, dan survival pegunungan.',
                'url' => '#divisi',
                'matra' => 'Matra I',
            ],
            (object) [
                'title' => 'Panjat Tebing',
                'desc' => 'Artificial & free climbing, ascending-descending, pemetaan tebing, dan rigging.',
                'url' => '#divisi',
                'matra' => 'Matra II',
            ],
            (object) [
                'title' => 'Arung Jeram',
                'desc' => 'White water rafting (ORAD), hidrologi arus sungai liar, dan self-rescue.',
                'url' => '#divisi',
                'matra' => 'Matra III',
            ],
            (object) [
                'title' => 'Susur Gua',
                'desc' => 'Caving & speleologi, Single Rope Technique (SRT), dan hidrologi bawah tanah.',
                'url' => '#divisi',
                'matra' => 'Matra IV',
            ],
            (object) [
                'title' => 'Konservasi & SAR',
                'desc' => 'Pelestarian ekosistem rimba, reboisasi, dan kesiapsiagaan operasi kemanusiaan.',
                'url' => '#divisi',
                'matra' => 'Matra V',
            ],
        ]);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    @include('partials.head', [
        'title' => 'SEMAR RIMBA | Mahasiswa Pecinta Alam Politeknik STIA LAN Bandung',
    ])
</head>

<body
    class="min-h-screen bg-offwhite text-content-dark antialiased flex flex-col font-sans selection:bg-gold selection:text-black">
    {{-- Main Navigation (Matching Screenshot Header) --}}
    <header class="sticky top-0 z-40 bg-[#080A08]/95 backdrop-blur-md border-b border-white/10 text-white"
        x-data="{
            mobileOpen: false,
            activeMenu: null,
            closeTimeout: null,
            openMenu(menu) {
                clearTimeout(this.closeTimeout);
                this.activeMenu = menu;
            },
            scheduleClose() {
                this.closeTimeout = setTimeout(() => {
                    this.activeMenu = null;
                }, 180);
            },
            cancelClose() {
                clearTimeout(this.closeTimeout);
            },
            closeMenuImmediately() {
                clearTimeout(this.closeTimeout);
                this.activeMenu = null;
            }
        }"
        x-effect="document.body.classList.toggle('overflow-hidden', mobileOpen)"
        @resize.window="if (window.innerWidth >= 1024 && mobileOpen) mobileOpen = false"
        @mouseleave="scheduleClose()"
        @keydown.escape.window="closeMenuImmediately(); mobileOpen = false">
        <div class="w-full px-6 lg:px-30 h-20 flex items-center justify-between gap-4">
            {{-- Brand Identity --}}
            <a href="{{ route('home') }}"
                @mouseenter="scheduleClose()"
                class="flex items-center gap-3 group focus:outline-none focus-visible:ring-2 focus-visible:ring-gold rounded-md p-1">
                <div class="w-9 h-9">
                    <img src={{ asset('images/logo.png') }} alt="Semar Rimba">
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-base sm:text-lg font-black text-white">
                        SEMAR RIMBA
                    </span>
                </div>
            </a>

            {{-- Desktop Menu Links --}}
            <nav class="hidden lg:flex items-center gap-10 h-full text-sm sm:text-sm font-medium text-stone-300"
                @mouseenter="cancelClose()"
                aria-label="Navigasi Utama">

                {{-- Item: Tentang --}}
                <a href="{{ route('tentang') }}"
                    @mouseenter="openMenu('tentang')"
                    @click="closeMenuImmediately()"
                    class="relative h-full flex items-center gap-1.5 transition font-medium focus:outline-none"
                    :class="activeMenu === 'tentang' ? 'text-gold' : '{{ request()->routeIs('tentang') ? 'text-gold' : 'text-stone-300 hover:text-gold' }}'">
                    <span>Tentang</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-down preview-icon transition-transform duration-200"
                        :class="activeMenu === 'tentang' ? 'rotate-180 text-gold' : 'text-stone-400 group-hover:text-gold'">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-gold transition-all duration-200"
                        x-show="activeMenu === 'tentang' || {{ request()->routeIs('tentang') ? 'true' : 'false' }}"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-x-0"
                        x-transition:enter-end="opacity-100 scale-x-100"></span>
                </a>

                {{-- Item: Kegiatan --}}
                <a href="{{ route('kegiatan') }}"
                    @mouseenter="openMenu('kegiatan')"
                    @click="closeMenuImmediately()"
                    class="relative h-full flex items-center gap-1.5 transition font-medium focus:outline-none"
                    :class="activeMenu === 'kegiatan' ? 'text-gold' : '{{ request()->routeIs('kegiatan') ? 'text-gold' : 'text-stone-300 hover:text-gold' }}'">
                    <span>Kegiatan</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-down preview-icon transition-transform duration-200"
                        :class="activeMenu === 'kegiatan' ? 'rotate-180 text-gold' : 'text-stone-400 group-hover:text-gold'">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-gold transition-all duration-200"
                        x-show="activeMenu === 'kegiatan' || {{ request()->routeIs('kegiatan') ? 'true' : 'false' }}"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-x-0"
                        x-transition:enter-end="opacity-100 scale-x-100"></span>
                </a>

                {{-- Item: Divisi --}}
                <a href="{{ route('home') }}#divisi"
                    @mouseenter="openMenu('divisi')"
                    @click="closeMenuImmediately()"
                    class="relative h-full flex items-center gap-1.5 transition font-medium focus:outline-none"
                    :class="activeMenu === 'divisi' ? 'text-gold' : 'text-stone-300 hover:text-gold'">
                    <span>Divisi</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-down preview-icon transition-transform duration-200"
                        :class="activeMenu === 'divisi' ? 'rotate-180 text-gold' : 'text-stone-400 group-hover:text-gold'">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-gold transition-all duration-200"
                        x-show="activeMenu === 'divisi'"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-x-0"
                        x-transition:enter-end="opacity-100 scale-x-100"></span>
                </a>

                {{-- Item: Galeri (Direct Link) --}}
                <a href="{{ route('home') }}#galeri"
                    @mouseenter="scheduleClose()"
                    @click="closeMenuImmediately()"
                    class="relative h-full flex items-center transition text-sm sm:text-sm font-medium text-stone-300 hover:text-gold focus:outline-none">
                    <span>Galeri</span>
                </a>

                {{-- Item: Kontak --}}
                <a href="#kontak"
                    @mouseenter="scheduleClose()"
                    @click="closeMenuImmediately()"
                    class="relative h-full flex items-center transition text-sm sm:text-sm font-medium text-stone-300 hover:text-gold focus:outline-none">
                    <span>Kontak</span>
                </a>
            </nav>

            {{-- Mobile Menu Trigger --}}
            <div class="flex lg:hidden items-center gap-2">
                <button type="button" @click="mobileOpen = !mobileOpen"
                    class="p-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition"
                    aria-label="Buka menu navigasi" :aria-expanded="mobileOpen.toString()">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Slide-Over Drawer (Left to Right, 3/4 Screen Width) --}}
        <div x-show="mobileOpen" x-cloak class="lg:hidden" x-data="{ openSub: null }">
            {{-- Backdrop Overlay --}}
            <div x-show="mobileOpen"
                x-transition:enter="transition-opacity ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="mobileOpen = false"
                @touchmove.prevent
                class="fixed inset-0 h-dvh w-screen bg-black/65 backdrop-blur-xs z-40"></div>

            {{-- Drawer Panel (w-3/4) --}}
            <div x-show="mobileOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-250 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="fixed top-0 left-0 z-50 h-dvh w-3/4 bg-[#080A08] border-r border-white/10 shadow-2xl flex flex-col justify-between overflow-y-auto overscroll-contain text-white">

                <div>
                    {{-- Drawer Header --}}
                    <div class="h-20 px-5 flex items-center justify-between border-b border-white/10">
                        <a href="{{ route('home') }}" @click="mobileOpen = false" class="flex items-center gap-2.5">
                            <img src="{{ asset('images/logo.png') }}" alt="Semar Rimba" class="size-8">
                            <div class="flex flex-col">
                                <span class="text-sm font-black tracking-wider text-white leading-none">SEMAR RIMBA</span>
                            </div>
                        </a>
                        <button type="button" @click="mobileOpen = false"
                            class="p-1.5 rounded-lg text-stone-400 hover:text-white hover:bg-white/10 transition"
                            aria-label="Tutup menu navigasi">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Accordion Navigation --}}
                    <nav class="px-4 py-5 flex flex-col divide-y divide-white/30 text-sm font-medium" aria-label="Navigasi Mobile">
                        <a href="{{ route('home') }}" @click="mobileOpen = false"
                            class="py-3 px-2 flex items-center justify-between text-stone-200 hover:text-gold font-bold transition">
                            <span>Beranda</span>
                        </a>

                        {{-- Accordion: Tentang --}}
                        <div class="py-1">
                            <button type="button" @click="openSub = openSub === 'tentang' ? null : 'tentang'"
                                class="w-full py-2.5 px-2 flex items-center justify-between text-left font-bold transition"
                                :class="openSub === 'tentang' ? 'text-gold' : 'text-stone-200 hover:text-gold'">
                                <span>Tentang</span>
                                <svg class="size-4 transition-transform duration-200"
                                    :class="openSub === 'tentang' ? 'rotate-180 text-gold' : 'text-stone-400'"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="openSub === 'tentang'"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="pl-4 pr-2 pb-2.5 space-y-1 mt-1">
                                <a href="{{ route('tentang') }}#sejarah" @click="mobileOpen = false"
                                    class="block py-2 px-2 rounded-md text-stone-300 hover:text-gold hover:bg-white/5 transition">
                                    <span class="block text-sm font-bold text-white">Sejarah &amp; Asal-Usul</span>
                                    <span class="block text-[11px] text-stone-400 mt-0.5">Rekam jejak berdiri sejak 1998</span>
                                </a>
                                <a href="{{ route('tentang') }}#visi-misi" @click="mobileOpen = false"
                                    class="block py-2 px-2 rounded-md text-stone-300 hover:text-gold hover:bg-white/5 transition">
                                    <span class="block text-sm font-bold text-white">Visi, Misi &amp; Nilai Korsa</span>
                                    <span class="block text-[11px] text-stone-400 mt-0.5">Tabah, Terampil, Tangguh, Lestari</span>
                                </a>
                                <a href="{{ route('tentang') }}#syal-kuning" @click="mobileOpen = false"
                                    class="block py-2 px-2 rounded-md text-stone-300 hover:text-gold hover:bg-white/5 transition">
                                    <span class="block text-sm font-bold text-white">Filosofi Syal Kuning</span>
                                    <span class="block text-[11px] text-stone-400 mt-0.5">Makna kehormatan &amp; tempaan rimbawan</span>
                                </a>
                            </div>
                        </div>

                        {{-- Accordion: Kegiatan --}}
                        <div class="py-1">
                            <button type="button" @click="openSub = openSub === 'kegiatan' ? null : 'kegiatan'"
                                class="w-full py-2.5 px-2 flex items-center justify-between text-left font-bold transition"
                                :class="openSub === 'kegiatan' ? 'text-gold' : 'text-stone-200 hover:text-gold'">
                                <span>Kegiatan</span>
                                <svg class="size-4 transition-transform duration-200"
                                    :class="openSub === 'kegiatan' ? 'rotate-180 text-gold' : 'text-stone-400'"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="openSub === 'kegiatan'"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="pl-4 pr-2 pb-2.5 space-y-1 mt-1">
                                @foreach ($kegiatans as $kegiatan)
                                    <a href="{{ route('kegiatan') }}{{ $kegiatan->url ?? '#katalog' }}" @click="mobileOpen = false"
                                        class="block py-2 px-2 rounded-md text-stone-300 hover:text-gold hover:bg-white/5 transition">
                                        <span class="block text-sm font-bold text-white">{{ $kegiatan->title }}</span>
                                        <span class="block text-[11px] text-stone-400 mt-0.5 line-clamp-1">{{ $kegiatan->desc }}</span>
                                    </a>
                                @endforeach
                                <a href="{{ route('kegiatan') }}" @click="mobileOpen = false"
                                    class="block py-2 px-2 rounded-md text-sm text-gold font-bold hover:underline transition">
                                    Lihat semuanya kegiatan &rarr;
                                </a>
                            </div>
                        </div>

                        {{-- Accordion: Divisi --}}
                        <div class="py-1">
                            <button type="button" @click="openSub = openSub === 'divisi' ? null : 'divisi'"
                                class="w-full py-2.5 px-2 flex items-center justify-between text-left font-bold transition"
                                :class="openSub === 'divisi' ? 'text-gold' : 'text-stone-200 hover:text-gold'">
                                <span>Divisi</span>
                                <svg class="size-4 transition-transform duration-200"
                                    :class="openSub === 'divisi' ? 'rotate-180 text-gold' : 'text-stone-400'"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="openSub === 'divisi'"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="pl-4 pr-2 pb-2.5 space-y-1 mt-1">
                                @foreach ($divisis as $divisi)
                                    <a href="{{ route('home') }}{{ $divisi->url ?? '#divisi' }}" @click="mobileOpen = false"
                                        class="block py-2 px-2 rounded-md text-stone-300 hover:text-gold hover:bg-white/5 transition">
                                        <span class="block text-sm font-bold text-white">{{ $divisi->title }}</span>
                                        <span class="block text-[11px] text-stone-400 mt-0.5 line-clamp-1">{{ $divisi->desc }}</span>
                                    </a>
                                @endforeach
                                <a href="{{ route('home') }}#divisi" @click="mobileOpen = false"
                                    class="block py-2 px-2 rounded-md text-sm text-gold font-bold hover:underline transition">
                                    Lihat semua divisi &rarr;
                                </a>
                            </div>
                        </div>

                        {{-- Direct Link: Galeri --}}
                        <a href="{{ route('home') }}#galeri" @click="mobileOpen = false"
                            class="py-3 px-2 flex items-center justify-between text-stone-200 hover:text-gold font-bold transition">
                            <span>Galeri</span>
                        </a>

                        {{-- Direct Link: Kontak --}}
                        <a href="#kontak" @click="mobileOpen = false"
                            class="py-3 px-2 flex items-center justify-between text-stone-200 hover:text-gold font-bold transition">
                            <span>Kontak</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        {{-- Desktop Mega Menu Dropdown Section --}}
        <div x-show="activeMenu !== null"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            @mouseenter="cancelClose()"
            @mouseleave="scheduleClose()"
            class="hidden lg:block absolute top-full left-0 w-full bg-offwhite backdrop-blur-xl text-black border-b border-white/10 shadow-2xl z-50">
            <div class="w-full px-6 lg:px-30 py-8 lg:py-10">
                
                {{-- Slot: Tentang --}}
                <div x-show="activeMenu === 'tentang'" class="w-full grid grid-cols-9 gap-8 items-start">
                    {{-- Col 1: Identity & Stats --}}
                    <div class="col-span-3 pr-2">
                        <span class="text-gold text-sm font-bold tracking-widest uppercase">Tentang</span>
                        <p class="text-sm text-stone-800 leading-relaxed mt-2.5">
                            Perhimpunan Mahasiswa Pecinta Alam Politeknik STIA LAN Bandung, berdiri sebagai wahana pembinaan karakter mandiri, ketangguhan fisik, dan pelestarian ekologi.
                        </p>
                        <div class="border-t border-white/10 mt-6 pt-4 grid grid-cols-2 gap-4">
                            <div>
                                <span class="block text-2xl font-black leading-none">32</span>
                                <span class="block text-[11px] font-bold text-stone-800 uppercase tracking-widest mt-1.5">angkatan</span>
                            </div>
                            <div>
                                <span class="block text-2xl font-black leading-none">5</span>
                                <span class="block text-[11px] font-bold text-stone-800 uppercase tracking-widest mt-1.5">divisi</span>
                            </div>
                        </div>
                    </div>

                    {{-- Col 2: Organisasi --}}
                    <div class="col-span-3">
                        <span class="text-[11px] font-bold text-stone-800 uppercase tracking-widest mb-2 block">Organisasi</span>
                        <a href="{{ route('tentang') }}#sejarah" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                            <h4 class="text-sm font-bold group-hover:text-gold transition-colors">Sejarah &amp; Asal-Usul</h4>
                            <p class="text-sm text-stone-800 mt-0.5 leading-relaxed">Rekam jejak berdirinya Semar Rimba sejak 1998</p>
                        </a>
                        <a href="{{ route('tentang') }}#visi-misi" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                            <h4 class="text-sm font-bold group-hover:text-gold transition-colors">Visi, Misi &amp; Nilai Korsa</h4>
                            <p class="text-sm text-stone-800 mt-0.5 leading-relaxed">Tabah, Terampil, Tangguh, dan Lestari</p>
                        </a>
                        <a href="{{ route('tentang') }}#syal-kuning" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                            <h4 class="text-sm font-bold group-hover:text-gold transition-colors">Filosofi Syal Kuning</h4>
                            <p class="text-sm text-stone-800 mt-0.5 leading-relaxed">Makna kehormatan dan ikatan persaudaraan rimbawan</p>
                        </a>
                    </div>

                    {{-- Col 3: Jejak --}}
                    <div class="col-span-3">
                        <span class="text-[11px] font-bold text-stone-800 uppercase tracking-widest mb-2 block">Jejak &amp; Koordinasi</span>
                        <a href="{{ route('home') }}#rangkaian" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                            <h4 class="text-sm font-bold group-hover:text-gold transition-colors">Tahapan Kaderisasi</h4>
                            <p class="text-sm text-stone-800 mt-0.5 leading-relaxed">Pendidikan dasar hingga penyematan syal kuning</p>
                        </a>
                        <a href="#kontak" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                            <h4 class="text-sm font-bold group-hover:text-gold transition-colors">Sekretariat</h4>
                            <p class="text-sm text-stone-800 mt-0.5 leading-relaxed">Pusat koordinasi &amp; narahubung rimbawan</p>
                        </a>
                    </div>
                </div>

                {{-- Slot: Kegiatan --}}
                <div x-show="activeMenu === 'kegiatan'" class="w-full grid grid-cols-12 gap-8 items-start">
                    {{-- Col 1: Identity & Stats --}}
                    <div class="col-span-3 pr-2">
                        <span class="text-gold text-sm font-bold tracking-widest uppercase">Kegiatan</span>
                        <p class="text-sm text-stone-800 leading-relaxed mt-2.5">
                            Aktivitas penjelajahan alam bebas, pembinaan ketahanan mental rimbawan, serta aksi kepedulian lingkungan hidup nusantara.
                        </p>
                        <div class="border-t border-white/10 mt-6 pt-4 grid grid-cols-2 gap-4">
                            <div>
                                <span class="block text-2xl font-black leading-none">100+</span>
                                <span class="block text-[11px] font-bold text-stone-800 uppercase tracking-widest mt-1.5">ekspedisi</span>
                            </div>
                            <div>
                                <span class="block text-2xl font-black leading-none">4</span>
                                <span class="block text-[11px] font-bold text-stone-800 uppercase tracking-widest mt-1.5">agenda utama</span>
                            </div>
                        </div>
                    </div>

                    {{-- Col 2: Kaderisasi & Kegiatan Utama --}}
                    <div class="col-span-3">
                        <span class="text-[11px] font-bold text-stone-800 uppercase tracking-widest mb-2 block">Kaderisasi</span>
                        @foreach ($kegiatans as $kegiatan)
                            <a href="{{ route('kegiatan') }}{{ $kegiatan->url ?? '#katalog' }}" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-bold group-hover:text-gold transition-colors truncate">
                                        {{ $kegiatan->title }}
                                    </h4>
                                </div>
                                <p class="text-sm text-stone-800 mt-0.5 leading-relaxed line-clamp-2">
                                    {{ $kegiatan->desc ?? 'Kegiatan resmi kepecintaan alam dan kaderisasi rimbawan SEMAR RIMBA.' }}
                                </p>
                            </a>
                        @endforeach
                    </div>

                    {{-- Col 3: Aksi & Lihat Semua --}}
                    <div class="col-span-3">
                        <span class="text-[11px] font-bold text-stone-800 uppercase tracking-widest mb-2 block">Aksi &amp; Jejak</span>
                        <a href="{{ route('kegiatan') }}#arsip" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                            <h4 class="text-sm font-bold group-hover:text-gold transition-colors">Arsip &amp; Rekam Jejak</h4>
                            <p class="text-sm text-stone-800 mt-0.5 leading-relaxed">Catatan agenda lapangan, pemetaan jalur, dan dokumentasi resmi</p>
                        </a>
                        <a href="{{ route('kegiatan') }}" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                            <h4 class="text-sm font-bold text-gold group-hover:underline flex items-center gap-1 transition-colors">
                                <span>Lihat semuanya kegiatan</span>
                                <span>&rarr;</span>
                            </h4>
                            <p class="text-sm text-stone-800 mt-0.5 leading-relaxed">Telusuri seluruh dokumentasi dan agenda rimbawan</p>
                        </a>
                    </div>

                    {{-- Col 4: Featured Activity Card --}}
                    <div class="col-span-3">
                        <div class="relative aspect-[4/3] rounded-lg border border-white/10 overflow-hidden flex flex-col justify-end p-5 text-white shadow-xs group">
                            <img src="{{ asset('images/gambar1.webp') }}" alt="Kegiatan Semar Rimba" class="absolute inset-0 size-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#080A08]/95 via-[#080A08]/45 to-transparent"></div>
                            <span class="relative z-10 text-[11px] text-gold font-bold uppercase tracking-wider">Pendidikan Dasar</span>
                            <h4 class="relative z-10 text-sm font-black mt-1 leading-snug">Tempaan fisik &amp; mental rimbawan baru</h4>
                            <a href="{{ route('kegiatan') }}#sorotan" @click="closeMenuImmediately()" class="relative z-10 text-sm text-gold font-semibold mt-3 hover:underline flex items-center gap-1">
                                <span>Lihat kegiatan lainnya</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Slot: Divisi --}}
                <div x-show="activeMenu === 'divisi'" class="w-full grid grid-cols-12 gap-8 items-start">
                    {{-- Col 1: Identity & Stats --}}
                    <div class="col-span-3 pr-2">
                        <span class="text-gold text-sm font-bold tracking-widest uppercase">Divisi</span>
                        <p class="text-sm text-stone-800 leading-relaxed mt-2.5">
                            Spesialisasi penjelajahan alam bebas yang menjadi fondasi kompetensi teknis, disiplin keselamatan, dan penguasaan medan setiap rimbawan.
                        </p>
                        <div class="border-t border-white/10 mt-6 pt-4 grid grid-cols-2 gap-4">
                            <div>
                                <span class="block text-2xl font-black leading-none">5</span>
                                <span class="block text-[11px] font-bold text-stone-800 uppercase tracking-widest mt-1.5">spesialisasi</span>
                            </div>
                            <div>
                                <span class="block text-2xl font-black leading-none">100%</span>
                                <span class="block text-[11px] font-bold text-stone-800 uppercase tracking-widest mt-1.5">disiplin SOP</span>
                            </div>
                        </div>
                    </div>

                    {{-- Col 2: Matra Terbuka --}}
                    <div class="col-span-3">
                        <span class="text-[11px] font-bold text-stone-800 uppercase tracking-widest mb-2 block">Matra Terbuka</span>
                        @foreach ($divisis->take(3) as $divisi)
                            <a href="{{ route('home') }}{{ $divisi->url ?? '#divisi' }}" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                                <h4 class="text-sm font-bold group-hover:text-gold transition-colors">
                                    {{ $divisi->title }}
                                </h4>
                                <p class="text-sm text-stone-800 mt-0.5 leading-relaxed line-clamp-1">
                                    {{ $divisi->desc ?? 'Spesialisasi penjelajahan alam bebas SEMAR RIMBA.' }}
                                </p>
                            </a>
                        @endforeach
                    </div>

                    {{-- Col 3: Speleologi, Konservasi, & Lihat Semua --}}
                    <div class="col-span-3">
                        <span class="text-[11px] font-bold text-stone-800 uppercase tracking-widest mb-2 block">Eksplorasi &amp; Advokasi</span>
                        @foreach ($divisis->slice(3) as $divisi)
                            <a href="{{ route('home') }}{{ $divisi->url ?? '#divisi' }}" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                                <h4 class="text-sm font-bold group-hover:text-gold transition-colors">
                                    {{ $divisi->title }}
                                </h4>
                                <p class="text-sm text-stone-800 mt-0.5 leading-relaxed line-clamp-1">
                                    {{ $divisi->desc ?? 'Spesialisasi penjelajahan alam bebas SEMAR RIMBA.' }}
                                </p>
                            </a>
                        @endforeach
                        <a href="{{ route('home') }}#divisi" @click="closeMenuImmediately()" class="block py-3 border-b border-white/10 hover:pl-1 transition-all group">
                            <h4 class="text-sm font-bold text-gold group-hover:underline flex items-center gap-1 transition-colors">
                                <span>Lihat semua divisi</span>
                                <span>&rarr;</span>
                            </h4>
                            <p class="text-sm text-stone-800 mt-0.5 leading-relaxed">Eksplorasi seluruh kurikulum dan profil spesialisasi matra</p>
                        </a>
                    </div>

                    {{-- Col 4: Featured Division Card --}}
                    <div class="col-span-3">
                        <div class="relative aspect-[4/3] rounded-lg border border-white/10 overflow-hidden flex flex-col justify-end p-5 text-white shadow-xs group">
                            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=800&auto=format&fit=crop" alt="Divisi Semar Rimba" class="absolute inset-0 size-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#080A08]/95 via-[#080A08]/45 to-transparent"></div>
                            <span class="relative z-10 text-[11px] text-gold font-bold uppercase tracking-wider">Matra Lapangan</span>
                            <h4 class="relative z-10 text-sm font-black mt-1 leading-snug">Disiplin &amp; keselamatan di segala medan</h4>
                            <a href="{{ route('home') }}#divisi" @click="closeMenuImmediately()" class="relative z-10 text-sm text-gold font-semibold mt-3 hover:underline flex items-center gap-1">
                                <span>Lihat profil divisi</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    {{-- Page Content Slot --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Section 5: Footer (Identitas Organisasi, Navigasi Penting, Kontak & Media Sosial) --}}
    <footer id="kontak" class="bg-[#080A08] border-t border-stone-800 text-stone-300 py-16">
        <div class="w-full px-6 lg:px-35">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-stone-800">
                {{-- Column 1: Identity & Motto --}}
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9">
                            <img src={{ asset('images/logo.png') }} alt="Semar Rimba">
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-base font-black tracking-wider text-white">SEMAR RIMBA</h3>
                            <p class="text-[10px] uppercase tracking-widest text-gold font-bold">POLITEKNIK STIA LAN
                                BANDUNG</p>
                        </div>
                    </div>

                    <p class="text-sm text-stone-400 leading-relaxed">
                        Unit Kegiatan Mahasiswa Pecinta Alam Politeknik STIA LAN Bandung. Berdiri sejak tahun 1998
                        (dummy), sebagai wadah eksplorasi kealaman nusantara, pembinaan karakter kemandirian mahasiswa,
                        ketangguhan fisik, dan kepedulian kelestarian lingkungan hidup.
                    </p>
                </div>

                {{-- Column 2: Navigasi Penting --}}
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-sm font-bold uppercase tracking-widest text-white">NAVIGASI PENTING</h4>
                    <ul class="space-y-2 text-sm text-stone-400 font-medium">
                        <li><a href="{{ route('home') }}" class="hover:text-gold transition">Beranda</a></li>
                        <li><a href="{{ route('tentang') }}" class="hover:text-gold transition">Tentang Kami</a>
                        </li>
                        <li><a href="{{ route('kegiatan') }}" class="hover:text-gold transition">Kegiatan &amp; Pengabdian</a></li>
                        <li><a href="{{ route('home') }}#divisi" class="hover:text-gold transition">Divisi</a></li>
                        <li><a href="#kontak" class="hover:text-gold transition">Kontak Sekretariat</a></li>
                    </ul>
                </div>

                {{-- Column 3: 4 Matra & Disiplin --}}
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-sm font-bold uppercase tracking-widest text-white">DIVISI</h4>
                    <ul class="space-y-2 text-sm text-stone-400 font-medium">
                        <li><a href="{{ route('home') }}#divisi" class="hover:text-gold transition">Gunung Hutan</a></li>
                        <li><a href="{{ route('home') }}#divisi" class="hover:text-gold transition">Panjat Tebing</a></li>
                        <li><a href="{{ route('home') }}#divisi" class="hover:text-gold transition">Susur Gua</a></li>
                        <li><a href="{{ route('home') }}#divisi" class="hover:text-gold transition">Arung Jeram</a></li>
                        <li><a href="{{ route('home') }}#divisi" class="hover:text-gold transition">SAR &amp; Konservasi</a></li>
                    </ul>
                </div>

                {{-- Column 4: Kontak & Media Sosial --}}
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-sm font-bold uppercase tracking-widest text-white">KONTAK &amp; MEDIA</h4>
                    <p class="text-sm text-stone-400 leading-relaxed">
                        Gedung UKM Kampus Politeknik STIA LAN Bandung<br />
                        Jl. Hayam Wuruk No. 34, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115
                    </p>
                    <div class="pt-1 space-y-1 text-sm">
                        <p class="text-stone-300">Surel: <a href="mailto:sekretariat@semarrimba-lan.org"
                                class="text-gold font-semibold hover:underline">sekretariat@semarrimba-lan.org</a></p>
                        <p class="text-stone-300">Telepon: <span class="text-gold font-semibold">+62 (022)
                                423-7484</span></p>
                        <p class="text-stone-300">Instagram: <a href="https://instagram.com/semarrimba_lan"
                                target="_blank" rel="noopener noreferrer"
                                class="text-gold font-semibold hover:underline">@semarrimba_lan</a></p>
                    </div>
                </div>
            </div>

            {{-- Copyright & Tagline Bar --}}
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-stone-500">
                <p>&copy; 2024 UKM Mapala Semar Rimba Politeknik STIA LAN Bandung. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>
