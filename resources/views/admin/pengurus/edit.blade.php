@php
    $prefix = auth()->user()?->role === 'staff' ? 'staff' : 'admin';
@endphp

<x-layouts::app :title="__('Edit Pengurus')">
    <div class="mx-auto flex w-full max-w-2xl flex-col gap-6">
        <div>
            <flux:heading size="xl" level="1">Edit Pengurus</flux:heading>
            <flux:subheading class="mt-1">Perbarui data {{ $pengurus->nama }}.</flux:subheading>
        </div>
        <form method="POST" action="{{ route($prefix . '.pengurus.update', $pengurus) }}" class="space-y-5 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            @csrf
            @method('PUT')
            @include('admin.pengurus.form')
            <div class="flex justify-end gap-2 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                <flux:button class="cursor-pointer" variant="ghost" href="{{ route($prefix . '.pengurus.index') }}">Batal</flux:button>
                <flux:button class="cursor-pointer" variant="primary" type="submit">Simpan Perubahan</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
