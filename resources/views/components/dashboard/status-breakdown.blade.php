@props([
    'title',
    'subtitle' => null,
    'total' => 0,
    'items' => [],
    'href' => null,
    'hrefLabel' => null,
])

@php
    $badgeClasses = static fn (string $tone): string => match ($tone) {
        'amber' => 'bg-amber-500/15 text-amber-700 dark:text-amber-400',
        'emerald' => 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400',
        'sky' => 'bg-sky-500/15 text-sky-700 dark:text-sky-400',
        default => 'bg-zinc-200/80 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300',
    };

    $dotClasses = static fn (string $tone): string => match ($tone) {
        'amber' => 'bg-amber-500',
        'emerald' => 'bg-emerald-500',
        'sky' => 'bg-sky-500',
        default => 'bg-zinc-400',
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

        <span class="shrink-0 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200">
            {{ __('Total: :count', ['count' => $total]) }}
        </span>
    </div>

    <div class="divide-y divide-zinc-100 dark:divide-zinc-800/80">
        @foreach ($items as $item)
            <div class="flex items-center justify-between gap-4 px-5 py-3.5">
                <div class="flex items-center gap-2.5 min-w-0">
                    <span class="size-2 rounded-full shrink-0 {{ $dotClasses($item['tone'] ?? 'neutral') }}"></span>
                    @if (! empty($item['href']))
                        <a href="{{ $item['href'] }}" wire:navigate class="text-sm font-medium text-zinc-800 dark:text-zinc-200 hover:underline truncate">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="text-sm font-medium text-zinc-800 dark:text-zinc-200 truncate">
                            {{ $item['label'] }}
                        </span>
                    @endif
                </div>

                <span class="shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badgeClasses($item['tone'] ?? 'neutral') }}">
                    {{ $item['count'] }}
                </span>
            </div>
        @endforeach
    </div>

    @if ($href)
        <div class="mt-auto px-5 py-3 bg-zinc-50/70 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-800">
            <a
                href="{{ $href }}"
                wire:navigate
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 dark:text-amber-400 hover:underline"
            >
                <span>{{ $hrefLabel ?? __('Kelola selengkapnya') }}</span>
                <flux:icon.arrow-right class="size-3.5" />
            </a>
        </div>
    @endif
</div>
