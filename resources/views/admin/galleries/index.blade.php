@php
    $prefix = auth()->user()?->role === 'staff' ? 'staff' : 'admin';
@endphp

<x-layouts::app :title="__('Manajemen Galeri')">
    <div class="flex flex-col gap-6 w-full">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Manajemen Galeri') }}</flux:heading>
                <flux:subheading size="lg" class="mt-1">
                    {{ __('Kelola dokumentasi foto kegiatan dan penjelajahan SEMAR RIMBA.') }}
                </flux:subheading>
            </div>

            <flux:button class="cursor-pointer" variant="primary" icon="plus" href="{{ route($prefix . '.galleries.create') }}" wire:navigate>
                {{ __('Tambah Foto Galeri') }}
            </flux:button>
        </div>

        {{-- Toast Flash Messages --}}
        @if (session('status') || session('error'))
            @php
                $toastVariant = session('error') ? 'danger' : 'success';
                $toastText = session('error') ?? session('status');
            @endphp
            <div
                x-data
                x-init="$nextTick(() => Flux.toast({ variant: @js($toastVariant), text: @js($toastText) }))"
                class="hidden"
            ></div>
        @endif

        {{-- Galleries Table --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-xs">
            @if ($galleries->isEmpty())
                <div class="py-16 px-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-3 text-zinc-400">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <flux:heading size="lg">{{ __('Belum Ada Foto Galeri') }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-zinc-500 max-w-md mx-auto">
                        {{ __('Belum ada dokumentasi foto di database. Klik tombol di bawah untuk mengunggah foto galeri pertama.') }}
                    </flux:text>
                    <div class="mt-6">
                        <flux:button class="cursor-pointer" variant="primary" icon="plus" href="{{ route($prefix . '.galleries.create') }}" wire:navigate>
                            {{ __('Tambah Foto Sekarang') }}
                        </flux:button>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 uppercase tracking-wider font-semibold">
                            <tr>
                                <th scope="col" class="py-3 px-4 w-20">{{ __('Urutan') }}</th>
                                <th scope="col" class="py-3 px-4 w-36">{{ __('Foto') }}</th>
                                <th scope="col" class="py-3 px-4 min-w-44">{{ __('Judul') }}</th>
                                <th scope="col" class="py-3 px-4 min-w-56">{{ __('Deskripsi') }}</th>
                                <th scope="col" class="py-3 px-4 w-40">{{ __('Kategori') }}</th>
                                <th scope="col" class="py-3 px-4 w-28 text-center">{{ __('Status') }}</th>
                                <th scope="col" class="py-3 px-4 w-24 text-right">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($galleries as $gallery)
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                                    {{-- Urutan --}}
                                    <td class="py-4 px-4 font-mono font-medium text-zinc-600 dark:text-zinc-400">
                                        #{{ $gallery->order }}
                                    </td>

                                    {{-- Foto --}}
                                    <td class="py-4 px-4">
                                        <div class="w-28 h-16 rounded-lg overflow-hidden bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-2xs">
                                            <img
                                                src="{{ $gallery->image_url }}"
                                                alt="{{ $gallery->title }}"
                                                class="w-full h-full object-cover object-center"
                                                loading="lazy"
                                            />
                                        </div>
                                    </td>

                                    {{-- Judul --}}
                                    <td class="py-4 px-4 font-bold text-zinc-900 dark:text-white leading-snug">
                                        {{ $gallery->title }}
                                    </td>

                                    {{-- Deskripsi --}}
                                    <td class="py-4 px-4 text-xs text-zinc-500 dark:text-zinc-400">
                                        @if ($gallery->description)
                                            <p class="line-clamp-2 max-w-xs">{{ $gallery->description }}</p>
                                        @else
                                            <span class="text-zinc-400 italic">-</span>
                                        @endif
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="py-4 px-4 text-xs">
                                        @if ($gallery->category)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-amber-500/10 text-amber-700 dark:text-amber-400 font-medium">
                                                {{ $gallery->category }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400 italic">{{ __('Umum') }}</span>
                                        @endif
                                    </td>

                                    {{-- Status Toggle --}}
                                    <td class="py-4 px-4 text-center">
                                        <form method="POST" action="{{ route($prefix . '.galleries.toggle', $gallery) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                title="{{ $gallery->is_active ? __('Klik untuk menonaktifkan') : __('Klik untuk mengaktifkan') }}"
                                                class="cursor-pointer inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition {{ $gallery->is_active ? 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-500/25' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}"
                                            >
                                                <span class="size-1.5 rounded-full {{ $gallery->is_active ? 'bg-emerald-500' : 'bg-zinc-400' }}"></span>
                                                {{ $gallery->is_active ? __('Aktif') : __('Nonaktif') }}
                                            </button>
                                        </form>
                                    </td>

                                    {{-- Aksi (Dropdown) --}}
                                    <td class="py-4 px-4 text-right">
                                        <flux:dropdown position="bottom" align="end">
                                            <flux:button class="cursor-pointer"
                                                variant="subtle"
                                                size="sm"
                                                icon="ellipsis-vertical"
                                                aria-label="{{ __('Aksi') }}"
                                            />

                                            <flux:menu>
                                                <flux:menu.item
                                                    icon="pencil-square"
                                                    href="{{ route($prefix . '.galleries.edit', $gallery) }}"
                                                    wire:navigate
                                                >
                                                    {{ __('Edit') }}
                                                </flux:menu.item>

                                                <flux:modal.trigger name="delete-gallery-modal-{{ $gallery->id }}">
                                                    <flux:menu.item icon="trash" variant="danger">
                                                        {{ __('Hapus') }}
                                                    </flux:menu.item>
                                                </flux:modal.trigger>
                                            </flux:menu>
                                        </flux:dropdown>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($galleries->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                        {{ $galleries->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus Galeri --}}
    @foreach ($galleries as $gallery)
        <flux:modal name="delete-gallery-modal-{{ $gallery->id }}" focusable class="max-w-md w-full">
            <form
                method="POST"
                action="{{ route($prefix . '.galleries.destroy', $gallery) }}"
                x-data="{ submitting: false }"
                @submit="submitting = true"
                class="space-y-5"
            >
                @csrf
                @method('DELETE')

                <div>
                    <flux:heading size="lg">
                        {{ __('Hapus Foto Galeri') }}
                    </flux:heading>
                    <flux:subheading class="mt-1">
                        {{ __('Apakah Anda yakin ingin menghapus foto :title? Gambar di Cloudinary juga akan dihapus secara permanen.', ['title' => $gallery->title]) }}
                    </flux:subheading>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button class="cursor-pointer" variant="filled" type="button" x-bind:disabled="submitting">{{ __('Batal') }}</flux:button>
                    </flux:modal.close>

                    <flux:button class="cursor-pointer" variant="danger" type="submit" x-bind:disabled="submitting">
                        <span class="inline-flex items-center justify-center gap-2">
                            <flux:icon.arrow-path x-show="submitting" x-cloak class="size-4 animate-spin" />
                            <span>{{ __('Hapus') }}</span>
                        </span>
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    @endforeach
</x-layouts::app>
