@props([
    'name',
    'id' => null,
    'value' => '',
    'required' => false,
])

@php
    $inputId = $id ?? $name;
@endphp

<div
    x-data="createTiptapAlpineData(@js($value ?? ''))"
    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden focus-within:ring-2 focus-within:ring-amber-500/50 focus-within:border-amber-500"
>
    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center gap-1 px-2.5 py-2 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900/60">
        <button
            type="button"
            @click="toggleBold()"
            :class="isActive('bold') ? 'bg-amber-500 text-stone-950' : 'text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
            class="px-2 py-1 rounded text-xs font-bold transition cursor-pointer"
            title="{{ __('Tebal (Bold)') }}"
        >B</button>

        <button
            type="button"
            @click="toggleItalic()"
            :class="isActive('italic') ? 'bg-amber-500 text-stone-950' : 'text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
            class="px-2 py-1 rounded text-xs italic font-serif transition cursor-pointer"
            title="{{ __('Miring (Italic)') }}"
        >I</button>

        <button
            type="button"
            @click="toggleStrike()"
            :class="isActive('strike') ? 'bg-amber-500 text-stone-950' : 'text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
            class="px-2 py-1 rounded text-xs line-through transition cursor-pointer"
            title="{{ __('Coret (Strikethrough)') }}"
        >S</button>

        <span class="w-px h-4 bg-zinc-300 dark:bg-zinc-700 mx-1"></span>

        <button
            type="button"
            @click="toggleHeading(2)"
            :class="isActive('heading', { level: 2 }) ? 'bg-amber-500 text-stone-950' : 'text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
            class="px-2 py-1 rounded text-xs font-semibold transition cursor-pointer"
            title="{{ __('Heading 2') }}"
        >H2</button>

        <button
            type="button"
            @click="toggleHeading(3)"
            :class="isActive('heading', { level: 3 }) ? 'bg-amber-500 text-stone-950' : 'text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
            class="px-2 py-1 rounded text-xs font-semibold transition cursor-pointer"
            title="{{ __('Heading 3') }}"
        >H3</button>

        <span class="w-px h-4 bg-zinc-300 dark:bg-zinc-700 mx-1"></span>

        <button
            type="button"
            @click="toggleBulletList()"
            :class="isActive('bulletList') ? 'bg-amber-500 text-stone-950' : 'text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
            class="px-2 py-1 rounded text-xs font-medium transition cursor-pointer"
            title="{{ __('Daftar Poin') }}"
        >• List</button>

        <button
            type="button"
            @click="toggleOrderedList()"
            :class="isActive('orderedList') ? 'bg-amber-500 text-stone-950' : 'text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
            class="px-2 py-1 rounded text-xs font-medium transition cursor-pointer"
            title="{{ __('Daftar Bernomor') }}"
        >1. List</button>

        <button
            type="button"
            @click="toggleBlockquote()"
            :class="isActive('blockquote') ? 'bg-amber-500 text-stone-950' : 'text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
            class="px-2 py-1 rounded text-xs font-medium transition cursor-pointer"
            title="{{ __('Kutipan (Blockquote)') }}"
        >“ ”</button>

        <span class="w-px h-4 bg-zinc-300 dark:bg-zinc-700 mx-1"></span>

        <button
            type="button"
            @click="undo()"
            class="px-2 py-1 rounded text-xs font-medium text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition cursor-pointer"
            title="{{ __('Undo') }}"
        >↶</button>

        <button
            type="button"
            @click="redo()"
            class="px-2 py-1 rounded text-xs font-medium text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition cursor-pointer"
            title="{{ __('Redo') }}"
        >↷</button>
    </div>

    {{-- Editor Surface --}}
    <div wire:ignore x-ref="editor"></div>

    {{-- Hidden Form Input --}}
    <input
        type="hidden"
        name="{{ $name }}"
        id="{{ $inputId }}"
        x-model="content"
        @if($required) required @endif
    />
</div>
