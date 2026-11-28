@props([
    'title',
    'subtitle' => null,
    'items' => [],
    'emptyText' => 'Belum ada konten yang tercatat.',
    'viewAllHref' => null,
    'viewAllLabel' => null,
])

@php
    $statusBadge = static fn (string $status): array => match ($status) {
        'published' => ['label' => __('Published'), 'class' => 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400'],
        'review' => ['label' => __('Review'), 'class' => 'bg-amber-500/15 text-amber-700 dark:text-amber-400'],
        'archived' => ['label' => __('Archived'), 'class' => 'bg-sky-500/15 text-sky-700 dark:text-sky-400'],
        default => ['label' => __('Draft'), 'class' => 'bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300'],
    };
@endphp

<div class="flex flex-col rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-xs overflow-hidden">
    <div class="flex items-start justify-between gap-4 p-5 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <flux:heading size="lg">{{ $title }}</flux:heading>
            @if ($subtitle)
                <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
            @endif
        </div>

        @if ($viewAllHref)
            <a
                href="{{ $viewAllHref }}"
                wire:navigate
                class="shrink-0 inline-flex items-center gap-1 text-xs font-semibold text-amber-600 dark:text-amber-400 hover:underline"
            >
                <span>{{ $viewAllLabel ?? __('Lihat semua') }}</span>
                <flux:icon.arrow-right class="size-3.5" />
            </a>
        @endif
    </div>

    @if (empty($items))
        <div class="px-5 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
            {{ $emptyText }}
        </div>
    @else
        <div class="divide-y divide-zinc-100 dark:divide-zinc-800/80">
            @foreach ($items as $item)
                @php
                    $badge = $statusBadge($item['status'] ?? 'draft');
                @endphp
                <div class="flex items-center justify-between gap-4 px-5 py-3.5 hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition">
                    <div class="min-w-0">
                        <a
                            href="{{ $item['href'] }}"
                            wire:navigate
                            class="block text-sm font-semibold text-zinc-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 truncate"
                        >
                            {{ $item['title'] }}
                        </a>
                        <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400 truncate">
                            {{ $item['meta'] }}
                            @if (! empty($item['date']))
                                · {{ $item['date'] }}
                            @endif
                        </p>
                    </div>

                    <span class="shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badge['class'] }}">
                        {{ $badge['label'] }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
