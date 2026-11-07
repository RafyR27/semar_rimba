<x-layouts::app :title="__('Manajemen Hero Banner')">
    <div class="flex flex-col gap-6 w-full">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Manajemen Hero Banner') }}</flux:heading>
                <flux:subheading size="lg" class="mt-1">
                    {{ __('Kelola gambar dan narasi ekspedisi yang ditampilkan pada slider halaman utama SEMAR RIMBA.') }}
                </flux:subheading>
            </div>

            <flux:button variant="primary" icon="plus" href="{{ route('admin.hero-banners.create') }}" wire:navigate>
                {{ __('Tambah Banner') }}
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

        {{-- Banners Table / List --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-xs">
            @if ($banners->isEmpty())
                <div class="py-16 px-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-3 text-zinc-400">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <flux:heading size="lg">{{ __('Belum Ada Hero Banner') }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-zinc-500 max-w-md mx-auto">
                        {{ __('Belum ada data banner di database. Halaman utama saat ini menggunakan gambar default fallback. Klik tombol di bawah untuk menambahkan banner pertama.') }}
                    </flux:text>
                    <div class="mt-6">
                        <flux:button variant="primary" icon="plus" href="{{ route('admin.hero-banners.create') }}" wire:navigate>
                            {{ __('Tambah Banner Sekarang') }}
                        </flux:button>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 uppercase tracking-wider font-semibold">
                            <tr>
                                <th scope="col" class="py-3 px-4 w-20">{{ __('Urutan') }}</th>
                                <th scope="col" class="py-3 px-4 w-36">{{ __('Gambar') }}</th>
                                <th scope="col" class="py-3 px-4">{{ __('Judul & Narasi') }}</th>
                                <th scope="col" class="py-3 px-4 w-40">{{ __('Tombol (CTA)') }}</th>
                                <th scope="col" class="py-3 px-4 w-28 text-center">{{ __('Status') }}</th>
                                <th scope="col" class="py-3 px-4 w-36 text-right">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($banners as $banner)
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                                    {{-- Order --}}
                                    <td class="py-4 px-4 font-mono font-medium text-zinc-600 dark:text-zinc-400">
                                        #{{ $banner->order }}
                                    </td>

                                    {{-- Thumbnail --}}
                                    <td class="py-4 px-4">
                                        <div class="w-28 h-16 rounded-lg overflow-hidden bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-2xs">
                                            <img
                                                src="{{ $banner->image_url }}"
                                                alt="{{ $banner->title }}"
                                                class="w-full h-full object-cover object-center"
                                                loading="lazy"
                                            />
                                        </div>
                                    </td>

                                    {{-- Title & Subtitle --}}
                                    <td class="py-4 px-4">
                                        <div class="font-bold text-zinc-900 dark:text-white leading-snug">
                                            {{ $banner->title }}
                                        </div>
                                        @if ($banner->subtitle)
                                            <div class="text-xs text-amber-600 dark:text-amber-400 font-medium mt-0.5">
                                                {{ $banner->subtitle }}
                                            </div>
                                        @endif
                                        @if ($banner->description)
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-1 mt-1 max-w-md">
                                                {{ $banner->description }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- CTA Button --}}
                                    <td class="py-4 px-4 text-xs">
                                        @if ($banner->hasButton())
                                            <div class="font-medium text-zinc-800 dark:text-zinc-200">{{ $banner->button_text }}</div>
                                            <div class="text-zinc-400 truncate max-w-xs mt-0.5">{{ $banner->button_url }}</div>
                                        @else
                                            <span class="text-zinc-400 italic">{{ __('Tidak ada') }}</span>
                                        @endif
                                    </td>

                                    {{-- Status Toggle --}}
                                    <td class="py-4 px-4 text-center">
                                        <form method="POST" action="{{ route('admin.hero-banners.toggle', $banner) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                title="{{ $banner->is_active ? __('Klik untuk menonaktifkan') : __('Klik untuk mengaktifkan') }}"
                                                class="cursor-pointer inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition {{ $banner->is_active ? 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-500/25' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}"
                                            >
                                                <span class="size-1.5 rounded-full {{ $banner->is_active ? 'bg-emerald-500' : 'bg-zinc-400' }}"></span>
                                                {{ $banner->is_active ? __('Aktif') : __('Nonaktif') }}
                                            </button>
                                        </form>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="py-4 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <flux:button
                                                size="sm"
                                                variant="subtle"
                                                icon="pencil-square"
                                                href="{{ route('admin.hero-banners.edit', $banner) }}"
                                                wire:navigate
                                                title="{{ __('Edit Banner') }}"
                                            />

                                            <form
                                                method="POST"
                                                action="{{ route('admin.hero-banners.destroy', $banner) }}"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini? Gambar di Cloudinary juga akan dihapus.');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <flux:button
                                                    size="sm"
                                                    variant="danger"
                                                    icon="trash"
                                                    type="submit"
                                                    title="{{ __('Hapus Banner') }}"
                                                />
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($banners->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                        {{ $banners->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layouts::app>
