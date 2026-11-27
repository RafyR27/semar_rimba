@props([
    'title',
    'value',
    'subtitle' => null,
    'icon' => 'chart-bar',
    'tone' => 'neutral',
    'href' => null,
    'actionLabel' => null,
])

@php
    $iconClasses = match ($tone) {
        'amber' => 'bg-amber-500/15 text-amber-600 dark:text-amber-400',
        'emerald' => 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400',
        'sky' => 'bg-sky-500/15 text-sky-600 dark:text-sky-400',
        default => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300',
    };
@endphp

<div class="flex flex-col justify-between rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-5 shadow-xs">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                {{ $title }}
            </p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">
                {{ $value }}
            </p>
            @if ($subtitle)
                <p class="mt-1.5 text-xs text-zinc-500 dark:text-zinc-400">
                    {{ $subtitle }}
                </p>
            @endif
        </div>

        <div class="shrink-0 rounded-lg p-2.5 {{ $iconClasses }}">
            <flux:icon :icon="$icon" class="size-5" />
        </div>
    </div>

    @if ($href)
        <div class="mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-800">
            <a
                href="{{ $href }}"
                wire:navigate
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 dark:text-amber-400 hover:underline"
            >
                <span>{{ $actionLabel ?? __('Lihat detail') }}</span>
                <flux:icon.arrow-right class="size-3.5" />
            </a>
        </div>
    @endif
</div>
