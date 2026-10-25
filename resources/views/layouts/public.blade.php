<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    @include('partials.head', [
        'title' => $title ?? 'SEMAR RIMBA | Mahasiswa Pecinta Alam Politeknik STIA LAN Bandung',
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
        @mouseleave="scheduleClose()"
        @keydown.escape.window="closeMenuImmediately()">
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
            <nav class="hidden lg:flex items-center gap-10 h-full text-xs sm:text-sm font-medium text-stone-300"
                @mouseenter="cancelClose()"
                aria-label="Navigasi Utama">

                {{-- Item: Tentang --}}
                <a href="#tentang"
                    @mouseenter="openMenu('tentang')"
                    @click="closeMenuImmediately()"
                    class="relative h-full flex items-center gap-1.5 transition font-medium focus:outline-none"
                    :class="activeMenu === 'tentang' ? 'text-gold' : 'text-stone-300 hover:text-gold'">
                    <span>Tentang</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-down preview-icon transition-transform duration-200"
                        :class="activeMenu === 'tentang' ? 'rotate-180 text-gold' : 'text-stone-400 group-hover:text-gold'">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-gold transition-all duration-200"
                        x-show="activeMenu === 'tentang'"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-x-0"
                        x-transition:enter-end="opacity-100 scale-x-100"></span>
                </a>

                {{-- Item: Kegiatan --}}
                <a href="#kegiatan"
                    @mouseenter="openMenu('kegiatan')"
                    @click="closeMenuImmediately()"
                    class="relative h-full flex items-center gap-1.5 transition font-medium focus:outline-none"
                    :class="activeMenu === 'kegiatan' ? 'text-gold' : 'text-stone-300 hover:text-gold'">
                    <span>Kegiatan</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-down preview-icon transition-transform duration-200"
                        :class="activeMenu === 'kegiatan' ? 'rotate-180 text-gold' : 'text-stone-400 group-hover:text-gold'">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-gold transition-all duration-200"
                        x-show="activeMenu === 'kegiatan'"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-x-0"
                        x-transition:enter-end="opacity-100 scale-x-100"></span>
                </a>

                {{-- Item: Galeri --}}
                <a href="#galeri"
                    @mouseenter="openMenu('galeri')"
                    @click="closeMenuImmediately()"
                    class="relative h-full flex items-center gap-1.5 transition font-medium focus:outline-none"
                    :class="activeMenu === 'galeri' ? 'text-gold' : 'text-stone-300 hover:text-gold'">
                    <span>Galeri</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-down preview-icon transition-transform duration-200"
                        :class="activeMenu === 'galeri' ? 'rotate-180 text-gold' : 'text-stone-400 group-hover:text-gold'">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-gold transition-all duration-200"
                        x-show="activeMenu === 'galeri'"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-x-0"
                        x-transition:enter-end="opacity-100 scale-x-100"></span>
                </a>

                {{-- Item: Divisi --}}
                <a href="#divisi"
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

                {{-- Item: Kontak --}}
                <a href="#kontak"
                    @mouseenter="scheduleClose()"
                    @click="closeMenuImmediately()"
                    class="relative h-full flex items-center transition text-xs sm:text-sm font-medium text-stone-300 hover:text-gold focus:outline-none">
                    <span>Kontak</span>
                </a>
            </nav>

            {{-- Mobile Menu Trigger --}}
            <div class="flex lg:hidden items-center gap-2">
                <button type="button" @click="mobileOpen = !mobileOpen"
                    class="p-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition border border-white/10"
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

        {{-- Mobile Dropdown Drawer --}}
        <div x-show="mobileOpen" x-cloak
            class="lg:hidden border-t border-white/10 bg-[#0B1510] px-4 pt-3 pb-6 space-y-2 text-white">
            <nav class="flex flex-col space-y-1 text-sm font-medium" aria-label="Navigasi Mobile">
                <a href="#hero" @click="mobileOpen = false"
                    class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Beranda</a>
                <a href="#tentang" @click="mobileOpen = false"
                    class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Tentang</a>
                <a href="#kegiatan" @click="mobileOpen = false"
                    class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Kegiatan</a>
                <a href="#divisi" @click="mobileOpen = false"
                    class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Divisi</a>
                <a href="#kontak" @click="mobileOpen = false"
                    class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Kontak</a>
            </nav>
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
            class="hidden lg:block absolute top-full left-0 w-full bg-[#080A08]/98 backdrop-blur-xl border-b border-white/10 shadow-2xl text-white">
            <div class="w-full px-6 lg:px-30 py-8 lg:py-10 min-h-[160px]">
                {{-- Slot List Menu Tentang (kosong terlebih dahulu) --}}
                <div x-show="activeMenu === 'tentang'" class="w-full">
                    {{-- Tempat list menu Tentang (kosong terlebih dahulu) --}}
                </div>

                {{-- Slot List Menu Kegiatan (kosong terlebih dahulu) --}}
                <div x-show="activeMenu === 'kegiatan'" class="w-full">
                    {{-- Tempat list menu Kegiatan (kosong terlebih dahulu) --}}
                </div>

                {{-- Slot List Menu Galeri (kosong terlebih dahulu) --}}
                <div x-show="activeMenu === 'galeri'" class="w-full">
                    {{-- Tempat list menu Galeri (kosong terlebih dahulu) --}}
                </div>

                {{-- Slot List Menu Divisi (kosong terlebih dahulu) --}}
                <div x-show="activeMenu === 'divisi'" class="w-full">
                    {{-- Tempat list menu Divisi (kosong terlebih dahulu) --}}
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

                    <p class="text-xs text-stone-400 leading-relaxed">
                        Unit Kegiatan Mahasiswa Pecinta Alam Politeknik STIA LAN Bandung. Berdiri sejak tahun 1998
                        (dummy), sebagai wadah eksplorasi kealaman nusantara, pembinaan karakter kemandirian mahasiswa,
                        ketangguhan fisik, dan kepedulian kelestarian lingkungan hidup.
                    </p>
                </div>

                {{-- Column 2: Navigasi Penting --}}
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-white">NAVIGASI PENTING</h4>
                    <ul class="space-y-2 text-xs text-stone-400 font-medium">
                        <li><a href="#hero" class="hover:text-gold transition">Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-gold transition">Tentang Kami &amp; Nilai Korsa</a>
                        </li>
                        <li><a href="#kegiatan" class="hover:text-gold transition">Kegiatan &amp; Pengabdian</a></li>
                        <li><a href="#divisi" class="hover:text-gold transition">Divisi Operasional Lapangan</a></li>
                        <li><a href="#kontak" class="hover:text-gold transition">Kontak Sekretariat</a></li>
                    </ul>
                </div>

                {{-- Column 3: 4 Matra & Disiplin --}}
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-white">DIVISI OPERASIONAL</h4>
                    <ul class="space-y-2 text-xs text-stone-400 font-medium">
                        <li><a href="#divisi" class="hover:text-gold transition">Gunung Hutan</a></li>
                        <li><a href="#divisi" class="hover:text-gold transition">Panjat Tebing</a></li>
                        <li><a href="#divisi" class="hover:text-gold transition">Susur Gua</a></li>
                        <li><a href="#divisi" class="hover:text-gold transition">Arung Jeram</a></li>
                        <li><a href="#kegiatan" class="hover:text-gold transition">SAR &amp; Konservasi</a></li>
                    </ul>
                </div>

                {{-- Column 4: Kontak & Media Sosial --}}
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-white">KONTAK &amp; MEDIA</h4>
                    <p class="text-xs text-stone-400 leading-relaxed">
                        Gedung UKM Kampus Politeknik STIA LAN Bandung<br />
                        Jl. Hayam Wuruk No. 34, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115
                    </p>
                    <div class="pt-1 space-y-1 text-xs">
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
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-stone-500">
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
