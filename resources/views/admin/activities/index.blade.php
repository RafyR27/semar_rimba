<x-layouts::app :title="__('Manajemen Kegiatan')">
    <div class="flex flex-col gap-6 w-full">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Manajemen Kegiatan') }}</flux:heading>
                <flux:subheading size="lg" class="mt-1">
                    {{ __('Kelola jadwal, dokumentasi perjalanan, dan publikasi kegiatan SEMAR RIMBA.') }}
                </flux:subheading>
            </div>

            <flux:button variant="primary" icon="plus" href="{{ route('admin.activities.create') }}" wire:navigate>
                {{ __('Tambah Kegiatan') }}
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

        {{-- Activities Table --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-xs">
            @if ($activities->isEmpty())
                <div class="py-16 px-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-3 text-zinc-400">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <flux:heading size="lg">{{ __('Belum Ada Kegiatan') }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-zinc-500 max-w-md mx-auto">
                        {{ __('Belum ada data kegiatan di database. Klik tombol di bawah untuk menambahkan kegiatan pertama.') }}
                    </flux:text>
                    <div class="mt-6">
                        <flux:button variant="primary" icon="plus" href="{{ route('admin.activities.create') }}" wire:navigate>
                            {{ __('Tambah Kegiatan Sekarang') }}
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
                                <th scope="col" class="py-3 px-4">{{ __('Judul & Lokasi') }}</th>
                                <th scope="col" class="py-3 px-4 w-44">{{ __('Kategori & Tanggal') }}</th>
                                <th scope="col" class="py-3 px-4 w-28 text-center">{{ __('Status') }}</th>
                                <th scope="col" class="py-3 px-4 w-36 text-right">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($activities as $activity)
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                                    {{-- Order --}}
                                    <td class="py-4 px-4 font-mono font-medium text-zinc-600 dark:text-zinc-400">
                                        #{{ $activity->order }}
                                    </td>

                                    {{-- Thumbnail --}}
                                    <td class="py-4 px-4">
                                        <div class="w-28 h-16 rounded-lg overflow-hidden bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-2xs">
                                            <img
                                                src="{{ $activity->image_url }}"
                                                alt="{{ $activity->title }}"
                                                class="w-full h-full object-cover object-center"
                                                loading="lazy"
                                            />
                                        </div>
                                    </td>

                                    {{-- Title & Location --}}
                                    <td class="py-4 px-4">
                                        <div class="font-bold text-zinc-900 dark:text-white leading-snug">
                                            {{ $activity->title }}
                                        </div>
                                        @if ($activity->location)
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                                {{ $activity->location }}
                                            </div>
                                        @endif
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-1 mt-1 max-w-md">
                                            {{ $activity->description }}
                                        </div>
                                    </td>

                                    {{-- Category & Date --}}
                                    <td class="py-4 px-4 text-xs space-y-1">
                                        <div>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-amber-500/10 text-amber-700 dark:text-amber-400 font-medium">
                                                {{ $activity->category }}
                                            </span>
                                        </div>
                                        @if ($activity->event_date)
                                            <div class="text-zinc-500 dark:text-zinc-400">
                                                {{ $activity->event_date->format('d M Y') }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Status Toggle --}}
                                    <td class="py-4 px-4 text-center">
                                        <form method="POST" action="{{ route('admin.activities.toggle', $activity) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                title="{{ $activity->is_active ? __('Klik untuk jadikan draft') : __('Klik untuk mempublikasikan') }}"
                                                class="cursor-pointer inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition {{ $activity->is_active ? 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-500/25' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}"
                                            >
                                                <span class="size-1.5 rounded-full {{ $activity->is_active ? 'bg-emerald-500' : 'bg-zinc-400' }}"></span>
                                                {{ $activity->is_active ? __('Publish') : __('Draft') }}
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
                                                href="{{ route('admin.activities.edit', $activity) }}"
                                                wire:navigate
                                                title="{{ __('Edit Kegiatan') }}"
                                            />

                                            <form
                                                method="POST"
                                                action="{{ route('admin.activities.destroy', $activity) }}"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini? Gambar di Cloudinary juga akan dihapus.');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <flux:button
                                                    size="sm"
                                                    variant="danger"
                                                    icon="trash"
                                                    type="submit"
                                                    title="{{ __('Hapus Kegiatan') }}"
                                                />
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($activities->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                        {{ $activities->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layouts::app>