@php
    $prefix = $routePrefix ?? 'admin';
    $userRole = auth()->user()?->role;
    $isReviewer = in_array($userRole, ['admin', 'staff'], true);
@endphp

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

            @unless ($isReviewer)
                <flux:button class="cursor-pointer" variant="primary" icon="plus" href="{{ route($prefix . '.activities.create') }}" wire:navigate>
                    {{ __('Tambah Kegiatan') }}
                </flux:button>
            @endunless
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

        {{-- Search & Filter Bar --}}
        @php
            $searchValue = $search ?? '';
            $categoryValue = $category ?? '';
            $statusValue = $status ?? '';
            $hasActiveFilter = $searchValue !== '' || $categoryValue !== '' || $statusValue !== '';
        @endphp
        <form
            method="GET"
            action="{{ route($prefix . '.activities.index') }}"
            x-data="{ submitting: false }"
            @submit="submitting = true"
            class="flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-3"
        >
            <div class="flex-1 min-w-60 max-w-md">
                <flux:input
                    name="search"
                    :value="$searchValue"
                    icon="magnifying-glass"
                    :placeholder="__('Cari judul atau lokasi kegiatan...')"
                />
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <flux:button class="cursor-pointer" type="submit" variant="filled" x-bind:disabled="submitting">
                    <span class="inline-flex items-center justify-center gap-2">
                        <flux:icon.arrow-path x-show="submitting" x-cloak class="size-4 animate-spin" />
                        <span>{{ __('Cari') }}</span>
                    </span>
                </flux:button>

                <div class="w-44">
                    <flux:select name="category" @change="submitting = true; $el.form.submit()" aria-label="{{ __('Filter Kategori') }}">
                        <option value="">{{ __('Semua Kategori') }}</option>
                        @foreach (['Ekspedisi', 'Diklat', 'SAR & Kemanusiaan', 'Konservasi', 'Umum'] as $cat)
                            <option value="{{ $cat }}" @selected($categoryValue === $cat)>{{ $cat }}</option>
                        @endforeach
                    </flux:select>
                </div>

                <div class="w-38">
                    <flux:select name="status" @change="submitting = true; $el.form.submit()" aria-label="{{ __('Filter Status') }}">
                        <option value="">{{ __('Semua Status') }}</option>
                        @unless ($isReviewer)
                            <option value="draft" @selected($statusValue === 'draft')>{{ __('Draft') }}</option>
                        @endunless
                        <option value="review" @selected($statusValue === 'review')>{{ __('Review') }}</option>
                        <option value="published" @selected($statusValue === 'published')>{{ __('Published') }}</option>
                        <option value="archived" @selected($statusValue === 'archived')>{{ __('Archived') }}</option>
                    </flux:select>
                </div>

                @if ($hasActiveFilter)
                    <flux:button
                        class="cursor-pointer"
                        variant="subtle"
                        href="{{ route($prefix . '.activities.index') }}"
                        wire:navigate
                        x-data="{ loading: false }"
                        @click="loading = true"
                        x-bind:class="{ 'pointer-events-none opacity-60': loading }"
                    >
                        <span class="inline-flex items-center justify-center gap-2">
                            <flux:icon.arrow-path x-show="loading" x-cloak class="size-4 animate-spin" />
                            <span>{{ __('Reset') }}</span>
                        </span>
                    </flux:button>
                @endif
            </div>
        </form>

        {{-- Activities Table --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-xs">
            @if ($activities->isEmpty())
                <div class="py-16 px-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-3 text-zinc-400">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <flux:heading size="lg">{{ $hasActiveFilter ? __('Kegiatan Tidak Ditemukan') : __('Belum Ada Kegiatan') }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-zinc-500 max-w-md mx-auto">
                        @if ($hasActiveFilter)
                            {{ __('Tidak ada kegiatan yang cocok dengan pencarian atau filter Anda.') }}
                        @else
                            {{ $isReviewer
                                ? __('Belum ada kegiatan yang diajukan untuk direview atau dipublikasikan.')
                                : __('Belum ada data kegiatan di database. Klik tombol di bawah untuk menambahkan kegiatan pertama.') }}
                        @endif
                    </flux:text>
                    @unless ($isReviewer || $hasActiveFilter)
                        <div class="mt-6">
                            <flux:button class="cursor-pointer" variant="primary" icon="plus" href="{{ route($prefix . '.activities.create') }}" wire:navigate>
                                {{ __('Tambah Kegiatan Sekarang') }}
                            </flux:button>
                        </div>
                    @endunless
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 uppercase tracking-wider font-semibold">
                            <tr>
                                <th scope="col" class="py-3 px-4 w-20">{{ __('Urutan') }}</th>
                                <th scope="col" class="py-3 px-4 w-36">{{ __('Foto') }}</th>
                                <th scope="col" class="py-3 px-4 min-w-44">{{ __('Judul') }}</th>
                                <th scope="col" class="py-3 px-4 min-w-36">{{ __('Lokasi') }}</th>
                                <th scope="col" class="py-3 px-4 min-w-56">{{ __('Deskripsi') }}</th>
                                <th scope="col" class="py-3 px-4 w-36">{{ __('Kategori') }}</th>
                                <th scope="col" class="py-3 px-4 w-32">{{ __('Tanggal') }}</th>
                                <th scope="col" class="py-3 px-4 w-28 text-center">{{ __('Status') }}</th>
                                <th scope="col" class="py-3 px-4 w-24 text-right">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($activities as $activity)
                                @php
                                    $activityStatus = $activity->status ?? ($activity->is_active ? 'published' : 'draft');
                                    $statusBadge = match ($activityStatus) {
                                        'published' => ['label' => 'Published', 'bg' => 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400', 'dot' => 'bg-emerald-500'],
                                        'review' => ['label' => 'Review', 'bg' => 'bg-amber-500/15 text-amber-700 dark:text-amber-400', 'dot' => 'bg-amber-500'],
                                        'archived' => ['label' => 'Archived', 'bg' => 'bg-rose-500/10 text-rose-700 dark:text-rose-400', 'dot' => 'bg-rose-500'],
                                        default => ['label' => 'Draft', 'bg' => 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300', 'dot' => 'bg-zinc-400'],
                                    };
                                    $canDelete = $isReviewer
                                        ? in_array($activityStatus, ['review', 'archived'], true)
                                        : $activityStatus === 'draft';
                                @endphp
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                                    {{-- Urutan --}}
                                    <td class="py-4 px-4 font-mono font-medium text-zinc-600 dark:text-zinc-400">
                                        #{{ $activity->order }}
                                    </td>

                                    {{-- Foto --}}
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

                                    {{-- Judul --}}
                                    <td class="py-4 px-4 font-bold text-zinc-900 dark:text-white leading-snug">
                                        {{ $activity->title }}
                                    </td>

                                    {{-- Lokasi --}}
                                    <td class="py-4 px-4 text-xs text-zinc-600 dark:text-zinc-300">
                                        {{ $activity->location ?: '-' }}
                                    </td>

                                    {{-- Deskripsi --}}
                                    <td class="py-4 px-4 text-xs text-zinc-500 dark:text-zinc-400">
                                        <p class="line-clamp-2 max-w-xs">{{ strip_tags($activity->description) }}</p>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="py-4 px-4 text-xs">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-amber-500/10 text-amber-700 dark:text-amber-400 font-medium">
                                            {{ $activity->category }}
                                        </span>
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="py-4 px-4 text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                        {{ $activity->event_date?->format('d M Y') ?? '-' }}
                                    </td>

                                    {{-- Status (Badge Only) --}}
                                    <td class="py-4 px-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusBadge['bg'] }}">
                                            <span class="size-1.5 rounded-full {{ $statusBadge['dot'] }}"></span>
                                            {{ __($statusBadge['label']) }}
                                        </span>
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
                                                    icon="arrow-top-right-on-square"
                                                    href="{{ route('kegiatan.show', $activity->slug) }}"
                                                    target="_blank"
                                                >
                                                    {{ $activityStatus === 'published' ? __('Lihat') : __('Preview') }}
                                                </flux:menu.item>

                                                @if ($isReviewer)
                                                    @if ($activityStatus === 'review')
                                                        <form method="POST" action="{{ route($prefix . '.activities.status', $activity) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="published" />
                                                            <flux:menu.item as="button" type="submit" icon="check-circle" class="w-full cursor-pointer">
                                                                {{ __('Publish') }}
                                                            </flux:menu.item>
                                                        </form>
                                                    @elseif ($activityStatus === 'published')
                                                        <form method="POST" action="{{ route($prefix . '.activities.status', $activity) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="archived" />
                                                            <flux:menu.item as="button" type="submit" icon="archive-box" class="w-full cursor-pointer">
                                                                {{ __('Archive') }}
                                                            </flux:menu.item>
                                                        </form>
                                                    @endif
                                                @else
                                                    <flux:menu.item
                                                        icon="pencil-square"
                                                        href="{{ route($prefix . '.activities.edit', $activity) }}"
                                                        wire:navigate
                                                    >
                                                        {{ __('Edit') }}
                                                    </flux:menu.item>
                                                @endif

                                                @if ($canDelete)
                                                    <flux:modal.trigger name="delete-activity-modal-{{ $activity->id }}">
                                                        <flux:menu.item icon="trash" variant="danger">
                                                            {{ __('Hapus') }}
                                                        </flux:menu.item>
                                                    </flux:modal.trigger>
                                                @endif
                                            </flux:menu>
                                        </flux:dropdown>
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

    {{-- Modal Konfirmasi Hapus Kegiatan --}}
    @foreach ($activities as $activity)
        <flux:modal name="delete-activity-modal-{{ $activity->id }}" focusable class="max-w-md w-full">
            <form
                method="POST"
                action="{{ route($prefix . '.activities.destroy', $activity) }}"
                x-data="{ submitting: false }"
                @submit="submitting = true"
                class="space-y-5"
            >
                @csrf
                @method('DELETE')

                <div>
                    <flux:heading size="lg">
                        {{ __('Hapus Kegiatan') }}
                    </flux:heading>
                    <flux:subheading class="mt-1">
                        {{ __('Apakah Anda yakin ingin menghapus kegiatan :title? Foto di Cloudinary juga akan dihapus secara permanen.', ['title' => $activity->title]) }}
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
