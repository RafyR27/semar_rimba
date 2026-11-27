@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Semar Rimba" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-7 items-center justify-center rounded-md overflow-hidden">
            <img src="{{ asset('images/logo.png') }}" alt="Semar Rimba" class="size-8 object-contain" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Semar Rimba" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md overflow-hidden">
            <img src="{{ asset('images/logo.png') }}" alt="Semar Rimba" class="size-8 object-contain" />
        </x-slot>
    </flux:brand>
@endif
