@php
    $prefix = $routePrefix ?? 'admin';
    $hasActiveFilter = ($filters['start_date'] ?? null) !== null
        || ($filters['end_date'] ?? null) !== null
        || ($filters['type'] ?? 'all') !== 'all'
        || ($filters['status'] ?? 'all') !== 'all';

    $exportQuery = array_filter([
        'start_date' => $filters['start_date'] ?? null,
        'end_date' => $filters['end_date'] ?? null,
        'type' => ($filters['type'] ?? 'all') !== 'all' ? $filters['type'] : null,
        'status' => ($filters['status'] ?? 'all') !== 'all' ? $filters['status'] : null,
    ], static fn (?string $value): bool => $value !== null && $value !== '');

    $statusBadge = static fn (string $status): array => match ($status) {
        'published' => ['label' => __('Published'), 'bg' => 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400', 'dot' => 'bg-emerald-500'],
        'review' => ['label' => __('Review'), 'bg' => 'bg-amber-500/15 text-amber-700 dark:text-amber-400', 'dot' => 'bg-amber-500'],
        'archived' => ['label' => __('Archived'), 'bg' => 'bg-sky-500/15 text-sky-700 dark:text-sky-400', 'dot' => 'bg-sky-500'],
        default => ['label' => __('Draft'), 'bg' => 'bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300', 'dot' => 'bg-zinc-400'],
    };
@endphp

<x-layouts::app :title="__('Laporan Konten')">
    <div class="flex flex-col gap-6 w-full min-w-0">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Laporan Konten') }}</flux:heading>
                <flux:subheading size="lg" class="mt-1">
                    {{ auth()->user()?->role === 'penulis'
                        ? __('Rekap dan ekspor data kegiatan serta berita milik Anda berdasarkan periode dan status.')
                        : __('Rekap dan ekspor data kegiatan serta berita SEMAR RIMBA berdasarkan periode, jenis, dan status.') }}
                </flux:subheading>
            </div>

            <flux:button
                variant="primary"
                icon="arrow-down-tray"
                href="{{ route($prefix . '.reports.export', $exportQuery) }}"
            >
                {{ __('Export Excel (.xlsx)') }}
            </flux:button>
        </div>

        {{-- Filter Validation Errors --}}
        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 text-sm">
                <p class="font-bold mb-1">{{ __('Parameter filter tidak valid:') }}</p>
                <ul class="list-disc list-inside space-y-0.5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Filter Bar --}}
        <form
            method="GET"
            action="{{ route($prefix . '.reports.index') }}"
            class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-xs"
        >
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                <div class="space-y-1.5">
                    <label for="start_date" class="block text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        {{ __('Tanggal Mulai') }}
                    </label>
                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ old('start_date', $filters['start_date']) }}"
                        class="w-full px-3.5 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
                </div>

                <div class="space-y-1.5">
                    <label for="end_date" class="block text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        {{ __('Tanggal Akhir') }}
                    </label>
                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ old('end_date', $filters['end_date']) }}"
                        class="w-full px-3.5 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
                </div>

                <div class="space-y-1.5">
                    <label for="type" class="block text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        {{ __('Jenis Konten') }}
                    </label>
                    <select
                        id="type"
                        name="type"
                        class="w-full px-3.5 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    >
                        <option value="all" @selected(($filters['type'] ?? 'all') === 'all')>{{ __('Semua Jenis') }}</option>
                        <option value="activity" @selected(($filters['type'] ?? 'all') === 'activity')>{{ __('Kegiatan') }}</option>
                        <option value="berita" @selected(($filters['type'] ?? 'all') === 'berita')>{{ __('Berita') }}</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        {{ __('Status Konten') }}
                    </label>
                    <select
                        id="status"
                        name="status"
                        class="w-full px-3.5 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    >
                        <option value="all" @selected(($filters['status'] ?? 'all') === 'all')>{{ __('Semua Status') }}</option>
                        @foreach ($availableStatuses as $statusOption)
                            <option value="{{ $statusOption }}" @selected(($filters['status'] ?? 'all') === $statusOption)>
                                {{ __(ucfirst($statusOption)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <flux:button class="cursor-pointer flex-1" type="submit" variant="filled" icon="magnifying-glass">
                        {{ __('Terapkan') }}
                    </flux:button>

                    @if ($hasActiveFilter)
                        <flux:button class="cursor-pointer" variant="subtle" href="{{ route($prefix . '.reports.index') }}" wire:navigate>
                            {{ __('Reset') }}
                        </flux:button>
                    @endif
                </div>
            </div>
        </form>

        {{-- Summary KPI Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-dashboard.stat-card
                :title="__('Total Data Terfilter')"
                :value="$summary['total']"
                :subtitle="__('Sesuai filter yang diterapkan')"
                icon="chart-bar"
                tone="neutral"
            />

            <x-dashboard.stat-card
                :title="__('Kegiatan')"
                :value="$summary['activities']"
                :subtitle="__('Entri kegiatan pada laporan')"
                icon="calendar-days"
                tone="amber"
            />

            <x-dashboard.stat-card
                :title="__('Berita')"
                :value="$summary['beritas']"
                :subtitle="__('Artikel berita pada laporan')"
                icon="newspaper"
                tone="emerald"
            />
        </div>

        {{-- Report Table --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-xs">
            @if ($rows->isEmpty())
                <div class="py-16 px-6 text-center">
                    <flux:heading size="lg">{{ __('Tidak Ada Data Laporan') }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-zinc-500 max-w-md mx-auto">
                        {{ $hasActiveFilter
                            ? __('Tidak ditemukan data kegiatan atau berita yang sesuai dengan filter yang dipilih.')
                            : __('Belum ada data konten yang tersedia untuk ditampilkan pada laporan.') }}
                    </flux:text>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 uppercase tracking-wider font-semibold">
                            <tr>
                                <th scope="col" class="py-3 px-4 w-28">{{ __('Jenis') }}</th>
                                <th scope="col" class="py-3 px-4 min-w-52">{{ __('Judul') }}</th>
                                <th scope="col" class="py-3 px-4 w-40">{{ __('Kategori') }}</th>
                                <th scope="col" class="py-3 px-4 w-40">{{ __('Lokasi') }}</th>
                                <th scope="col" class="py-3 px-4 w-36">{{ __('Penulis') }}</th>
                                <th scope="col" class="py-3 px-4 w-28 text-center">{{ __('Status') }}</th>
                                <th scope="col" class="py-3 px-4 w-32 whitespace-nowrap">{{ __('Tanggal') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($rows as $row)
                                @php
                                    $badge = $statusBadge($row['status']);
                                @endphp
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                                    <td class="py-3.5 px-4 text-xs font-semibold">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md {{ $row['type_key'] === 'activity' ? 'bg-amber-500/10 text-amber-700 dark:text-amber-400' : 'bg-sky-500/10 text-sky-700 dark:text-sky-400' }}">
                                            {{ $row['type_label'] }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-zinc-900 dark:text-white">
                                        {{ $row['title'] }}
                                    </td>
                                    <td class="py-3.5 px-4 text-xs text-zinc-600 dark:text-zinc-300">
                                        {{ $row['category'] }}
                                    </td>
                                    <td class="py-3.5 px-4 text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $row['location'] }}
                                    </td>
                                    <td class="py-3.5 px-4 text-xs text-zinc-600 dark:text-zinc-300">
                                        {{ $row['author'] }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge['bg'] }}">
                                            <span class="size-1.5 rounded-full {{ $badge['dot'] }}"></span>
                                            {{ $badge['label'] }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                        {{ $row['date_formatted'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($rows->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                        {{ $rows->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layouts::app>
