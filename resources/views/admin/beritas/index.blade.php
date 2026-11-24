<x-layouts::app :title="__('Manajemen Berita')">
    <div class="flex flex-col gap-6 w-full">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Manajemen Berita') }}</flux:heading>
                <flux:subheading size="lg" class="mt-1">
                    {{ __('Kelola kabar, laporan ekspedisi, dan artikel yang tampil pada halaman berita SEMAR RIMBA.') }}
                </flux:subheading>
            </div>

            <flux:button variant="primary" icon="plus" href="{{ route('admin.beritas.create') }}" wire:navigate>
                {{ __('Tambah Berita') }}
            </flux:button>
        </div>

        {{-- Flash Messages --}}
        @if (session('status'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-sm flex items-center justify-between">
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 text-sm flex items-center justify-between">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('admin.beritas.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="relative flex-1">
                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="{{ __('Cari judul, slug, atau isi berita...') }}"
                    class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                />
            </div>

            <div class="flex items-center gap-3">
                <select
                    name="status"
                    class="px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                >
                    <option value="all" @selected($status === 'all')>{{ __('Semua Status') }}</option>
                    <option value="published" @selected($status === 'published')>{{ __('Published') }}</option>
                    <option value="draft" @selected($status === 'draft')>{{ __('Draft') }}</option>
                </select>

                <flux:button variant="subtle" type="submit" icon="magnifying-glass">
                    {{ __('Cari') }}
                </flux:button>

                @if ($search !== '' || $status !== 'all')
                    <flux:button variant="subtle" href="{{ route('admin.beritas.index') }}" wire:navigate>
                        {{ __('Reset') }}
                    </flux:button>
                @endif
            </div>
        </form>

        {{-- News Table / List --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-xs">
            @if ($beritas->isEmpty())
                <div class="py-16 px-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-3 text-zinc-400">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <flux:heading size="lg">{{ __('Belum Ada Berita') }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-zinc-500 max-w-md mx-auto">
                        {{ __('Belum ada berita yang tersimpan. Tambahkan berita pertama untuk mengisi halaman publik SEMAR RIMBA.') }}
                    </flux:text>
                    <div class="mt-6">
                        <flux:button variant="primary" icon="plus" href="{{ route('admin.beritas.create') }}" wire:navigate>
                            {{ __('Tambah Berita Sekarang') }}
                        </flux:button>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 uppercase tracking-wider font-semibold">
                            <tr>
                                <th scope="col" class="py-3 px-4 w-32">{{ __('Thumbnail') }}</th>
                                <th scope="col" class="py-3 px-4">{{ __('Judul & Ringkasan') }}</th>
                                <th scope="col" class="py-3 px-4 w-36">{{ __('Tanggal') }}</th>
                                <th scope="col" class="py-3 px-4 w-32 text-center">{{ __('Status') }}</th>
                                <th scope="col" class="py-3 px-4 w-28 text-right">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($beritas as $berita)
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                                    {{-- Thumbnail --}}
                                    <td class="py-4 px-4">
                                        <div class="w-24 h-16 rounded-lg overflow-hidden bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-2xs">
                                            @if ($berita->thumbnail_url)
                                                <img
                                                    src="{{ $berita->thumbnail_url }}"
                                                    alt="{{ $berita->judul }}"
                                                    class="w-full h-full object-cover object-center"
                                                    loading="lazy"
                                                />
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Title & Excerpt --}}
                                    <td class="py-4 px-4">
                                        <div class="font-bold text-zinc-900 dark:text-white leading-snug">
                                            {{ $berita->judul }}
                                        </div>
                                        <div class="text-xs font-mono text-zinc-400 mt-0.5">
                                            /{{ $berita->slug }}
                                        </div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-1 mt-1 max-w-xl">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($berita->konten), 120) }}
                                        </div>
                                    </td>

                                    {{-- Publication Date --}}
                                    <td class="py-4 px-4 text-xs text-zinc-600 dark:text-zinc-400">
                                        {{ $berita->publicationDate()?->format('d M Y') ?? __('Belum diatur') }}
                                    </td>

                                    {{-- Publication Status Toggle --}}
                                    <td class="py-4 px-4 text-center">
                                        <form method="POST" action="{{ route('admin.beritas.toggle', $berita) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                title="{{ $berita->is_published ? __('Klik untuk menyimpan sebagai draft') : __('Klik untuk menerbitkan') }}"
                                                class="cursor-pointer inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition {{ $berita->is_published ? 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-500/25' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}"
                                            >
                                                <span class="size-1.5 rounded-full {{ $berita->is_published ? 'bg-emerald-500' : 'bg-zinc-400' }}"></span>
                                                {{ $berita->is_published ? __('Published') : __('Draft') }}
                                            </button>
                                        </form>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="py-4 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if ($berita->is_published)
                                                <flux:button
                                                    size="sm"
                                                    variant="subtle"
                                                    icon="arrow-top-right-on-square"
                                                    href="{{ route('berita.show', $berita->slug) }}"
                                                    target="_blank"
                                                    title="{{ __('Lihat di Halaman Publik') }}"
                                                />
                                            @endif

                                            <flux:button
                                                size="sm"
                                                variant="subtle"
                                                icon="pencil-square"
                                                href="{{ route('admin.beritas.edit', $berita) }}"
                                                wire:navigate
                                                title="{{ __('Edit Berita') }}"
                                            />

                                            <form
                                                method="POST"
                                                action="{{ route('admin.beritas.destroy', $berita) }}"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini? Gambar di Cloudinary juga akan dihapus.');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <flux:button
                                                    size="sm"
                                                    variant="danger"
                                                    icon="trash"
                                                    type="submit"
                                                    title="{{ __('Hapus Berita') }}"
                                                />
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($beritas->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                        {{ $beritas->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layouts::app>
