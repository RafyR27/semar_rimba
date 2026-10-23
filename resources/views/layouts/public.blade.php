<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head', ['title' => $title ?? 'SEMAR RIMBA — Mahasiswa Pecinta Alam Politeknik STIA LAN Bandung'])
    </head>
    <body class="min-h-screen bg-offwhite text-content-dark antialiased flex flex-col font-sans selection:bg-gold selection:text-black">
        {{-- Main Navigation (Matching Screenshot Header) --}}
        <header class="sticky top-0 z-40 bg-[#080A08]/95 backdrop-blur-md border-b border-white/10 text-white" x-data="{ mobileOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
                {{-- Brand Identity --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-none focus-visible:ring-2 focus-visible:ring-gold rounded-md p-1">
                    <div class="flex aspect-square size-10 items-center justify-center rounded-full bg-gold/20 border-2 border-gold text-gold shrink-0 group-hover:scale-105 transition">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L2 19h20L12 3zM12 9l4 7H8l4-7z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-base sm:text-lg font-black tracking-wider text-white leading-tight group-hover:text-gold transition">
                            SEMAR RIMBA
                        </span>
                        <span class="text-[9px] uppercase tracking-widest text-gold font-bold">
                            POLITEKNIK STIA LAN BANDUNG
                        </span>
                    </div>
                </a>

                {{-- Desktop Menu Links --}}
                <nav class="hidden lg:flex items-center gap-7 text-xs sm:text-sm font-medium text-stone-300" aria-label="Navigasi Utama">
                    <a href="#hero" class="hover:text-gold transition">Beranda</a>
                    <a href="#tentang" class="hover:text-gold transition">Profil</a>
                    <a href="#divisi-matra" class="hover:text-gold transition">Divisi</a>
                    <a href="#biro-khusus" class="hover:text-gold transition">Kegiatan</a>
                    <a href="#bagan-komando" class="hover:text-gold transition">Galeri</a>
                    <a href="#pimpinan" class="hover:text-gold transition">Pengurus</a>
                </nav>

                {{-- Right Actions --}}
                <div class="hidden sm:flex items-center gap-3">
                    <a
                        href="#cta-audiensi"
                        class="px-5 py-2 rounded-full bg-gold hover:bg-gold-hover text-stone-950 font-bold text-xs tracking-wide transition shadow-sm inline-flex items-center gap-1.5"
                    >
                        <span>Gabung Ekspedisi</span>
                    </a>

                    @if (Route::has('login'))
                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="size-9 rounded-full border border-gold/50 flex items-center justify-center text-gold hover:border-gold hover:bg-gold/10 transition"
                                title="Buka Dashboard Pengurus"
                                wire:navigate
                            >
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="size-9 rounded-full border border-gold/50 flex items-center justify-center text-gold hover:border-gold hover:bg-gold/10 transition"
                                title="Akses Masuk Pengurus"
                                wire:navigate
                            >
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                        @endauth
                    @endif
                </div>

                {{-- Mobile Menu Trigger --}}
                <div class="flex lg:hidden items-center gap-2">
                    <a
                        href="#cta-audiensi"
                        class="px-3 py-1.5 rounded-full bg-gold text-stone-950 font-bold text-[11px] sm:hidden"
                    >
                        Gabung
                    </a>
                    <button
                        type="button"
                        @click="mobileOpen = !mobileOpen"
                        class="p-2 rounded-lg text-stone-300 hover:text-white hover:bg-white/10 transition border border-white/10"
                        aria-label="Buka menu navigasi"
                        :aria-expanded="mobileOpen.toString()"
                    >
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Dropdown Drawer --}}
            <div x-show="mobileOpen" x-cloak class="lg:hidden border-t border-white/10 bg-[#0B1510] px-4 pt-3 pb-6 space-y-2 text-white">
                <nav class="flex flex-col space-y-1 text-sm font-medium" aria-label="Navigasi Mobile">
                    <a href="#hero" @click="mobileOpen = false" class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Beranda</a>
                    <a href="#tentang" @click="mobileOpen = false" class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Profil</a>
                    <a href="#divisi-matra" @click="mobileOpen = false" class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Divisi</a>
                    <a href="#biro-khusus" @click="mobileOpen = false" class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Kegiatan</a>
                    <a href="#bagan-komando" @click="mobileOpen = false" class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Galeri</a>
                    <a href="#pimpinan" @click="mobileOpen = false" class="px-3 py-2 rounded-md hover:bg-white/5 hover:text-gold transition">Pengurus</a>
                </nav>
                <div class="pt-3 border-t border-white/10 flex flex-col gap-2">
                    <a
                        href="#cta-audiensi"
                        @click="mobileOpen = false"
                        class="w-full text-center py-2.5 rounded-full bg-gold text-stone-950 font-bold text-xs"
                    >
                        Gabung Ekspedisi
                    </a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="block text-center w-full px-4 py-2 rounded-full bg-white/10 text-white text-xs font-semibold" wire:navigate>
                                Dashboard Pengurus
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block text-center w-full px-4 py-2 rounded-full border border-white/20 text-stone-300 text-xs font-semibold hover:bg-white/5" wire:navigate>
                                Masuk Portal Pengurus
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        {{-- Page Content Slot --}}
        <main class="flex-1">
            {{ $slot }}
        </main>

        {{-- Footer (Matching Screenshot Section 11) --}}
        <footer class="bg-[#080A08] border-t border-stone-800 text-stone-300 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-stone-800">
                    {{-- Column 1: Identity & Motto --}}
                    <div class="lg:col-span-4 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="flex aspect-square size-10 items-center justify-center rounded-full bg-gold/20 border-2 border-gold text-gold shrink-0">
                                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L2 19h20L12 3zM12 9l4 7H8l4-7z" />
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <h3 class="text-base font-black tracking-wider text-white">SEMAR RIMBA</h3>
                                <p class="text-[10px] uppercase tracking-widest text-gold font-bold">POLITEKNIK STIA LAN BANDUNG</p>
                            </div>
                        </div>

                        <p class="text-xs text-stone-400 leading-relaxed">
                            Unit Kegiatan Mahasiswa Pecinta Alam Politeknik STIA LAN Bandung. Wadah eksplorasi kealaman, pembinaan karakter kemandirian, ketangguhan fisik, dan kepedulian kelestarian hidup mahasiswa.
                        </p>

                        <div class="pt-2">
                            <span class="text-xs font-black tracking-widest text-gold uppercase">
                                TABAH &bull; TERAMPIL &bull; TANGGUH &bull; LESTARI
                            </span>
                        </div>
                    </div>

                    {{-- Column 2: Navigasi Portal --}}
                    <div class="lg:col-span-3 space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-white">NAVIGASI PORTAL</h4>
                        <ul class="space-y-2 text-xs text-stone-400 font-medium">
                            <li><a href="#hero" class="hover:text-gold transition">Beranda</a></li>
                            <li><a href="#tentang" class="hover:text-gold transition">Profil Organisasi</a></li>
                            <li><a href="#divisi-matra" class="hover:text-gold transition">Divisi Operasional</a></li>
                            <li><a href="#biro-khusus" class="hover:text-gold transition">Agenda &amp; Kegiatan</a></li>
                            <li><a href="#bagan-komando" class="hover:text-gold transition">Dokumen Etik Korsa</a></li>
                            <li><a href="#pimpinan" class="hover:text-gold transition">Struktur Kepengurusan</a></li>
                        </ul>
                    </div>

                    {{-- Column 3: Program & Ekspedisi --}}
                    <div class="lg:col-span-2 space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-white">PROGRAM &amp; EKSPEDISI</h4>
                        <ul class="space-y-2 text-xs text-stone-400 font-medium">
                            <li><a href="#divisi-matra" class="hover:text-gold transition">Gunung Hutan (Mountaineering)</a></li>
                            <li><a href="#divisi-matra" class="hover:text-gold transition">Panjat Tebing (Rock Climbing)</a></li>
                            <li><a href="#divisi-matra" class="hover:text-gold transition">Susur Gua (Caving)</a></li>
                            <li><a href="#biro-khusus" class="hover:text-gold transition">Konservasi Lingkungan Hidup</a></li>
                            <li><a href="#divisi-matra" class="hover:text-gold transition">Pendidikan Dasar (DIKLAT) 2024</a></li>
                        </ul>
                    </div>

                    {{-- Column 4: Sekretariat --}}
                    <div class="lg:col-span-3 space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-white">SEKRETARIAT</h4>
                        <p class="text-xs text-stone-400 leading-relaxed">
                            Gedung UKM Kampus Politeknik STIA LAN Bandung<br />
                            Jl. Hayam Wuruk No. 34, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115
                        </p>
                        <div class="pt-1 space-y-1 text-xs">
                            <p class="text-gold font-semibold">sekretariat@semarrimba-lan.org</p>
                            <p class="text-gold font-semibold">+62 (022) 423-7484</p>
                        </div>
                    </div>
                </div>

                {{-- Copyright & Tagline Bar --}}
                <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-stone-500">
                    <p>&copy; 2024 UKM Mapala Semar Rimba Politeknik STIA LAN Bandung. Seluruh hak cipta dilindungi.</p>
                    <p class="text-gold font-bold tracking-widest text-[11px] uppercase">
                        KORSA RIMBA LESTARI
                    </p>
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
