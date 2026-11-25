@php
    $prefix = auth()->user()?->role === 'staff' ? 'staff' : 'admin';
@endphp

<x-layouts::app :title="__('Kelola Divisi')">
    <div class="flex w-full flex-col gap-6">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <flux:heading size="xl" level="1">Kelola Divisi</flux:heading>
                <flux:subheading size="lg" class="mt-1">Atur daftar divisi yang tampil di website SEMAR RIMBA.</flux:subheading>
            </div>
            <flux:button class="cursor-pointer" variant="primary" icon="plus" href="{{ route($prefix . '.divisi.create') }}" wire:navigate>Tambah Divisi</flux:button>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-700 dark:text-emerald-400">{{ session('status') }}</div>
        @endif

        <form method="GET" action="{{ route($prefix . '.divisi.index') }}" class="flex flex-col gap-2 sm:flex-row">
            <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama divisi..." class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white sm:max-w-sm">
            <div class="flex gap-2">
                <flux:button class="cursor-pointer" type="submit" variant="filled">Cari</flux:button>
                @if ($search !== '')
                    <flux:button class="cursor-pointer" href="{{ route($prefix . '.divisi.index') }}" variant="ghost">Reset</flux:button>
                @endif
            </div>
        </form>

        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
            @if ($divisis->isEmpty())
                <div class="px-6 py-14 text-center">
                    <flux:heading size="lg">Belum ada data divisi</flux:heading>
                    <flux:text class="mt-1">Tambahkan divisi agar bisa dipilih saat mengelola pengurus.</flux:text>
                    <div class="mt-5"><flux:button class="cursor-pointer" variant="primary" icon="plus" href="{{ route($prefix . '.divisi.create') }}" wire:navigate>Tambah Divisi</flux:button></div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase tracking-wide text-zinc-500 dark:border-zinc-700 dark:bg-zinc-800/60">
                            <tr>
                                <th class="px-4 py-3">Nama Divisi</th>
                                <th class="px-4 py-3">Deskripsi</th>
                                <th class="px-4 py-3 text-center">Pengurus</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($divisis as $divisi)
                                <tr class="hover:bg-zinc-50/60 dark:hover:bg-zinc-800/40">
                                    <td class="px-4 py-4 font-semibold text-zinc-900 dark:text-white">{{ $divisi->nama }}</td>
                                    <td class="max-w-md px-4 py-4 text-zinc-600 dark:text-zinc-400">{{ $divisi->deskripsi ?: '—' }}</td>
                                    <td class="px-4 py-4 text-center tabular-nums">{{ $divisi->pengurus_count }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <form method="POST" action="{{ route($prefix . '.divisi.toggle', $divisi) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-full px-3 py-1 text-xs font-semibold {{ $divisi->is_active ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300' }}">{{ $divisi->is_active ? 'Aktif' : 'Nonaktif' }}</button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-end gap-2">
                                            <flux:button class="cursor-pointer" size="sm" variant="subtle" icon="pencil-square" href="{{ route($prefix . '.divisi.edit', $divisi) }}" wire:navigate title="Edit divisi" />
                                            <form method="POST" action="{{ route($prefix . '.divisi.destroy', $divisi) }}" onsubmit="return confirm('Hapus divisi ini? Data pengurus tetap tersimpan, tetapi tidak lagi terhubung ke divisi ini.');">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button class="cursor-pointer" size="sm" variant="danger" icon="trash" type="submit" title="Hapus divisi" />
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($divisis->hasPages())
                    <div class="border-t border-zinc-200 px-4 py-3 dark:border-zinc-700">{{ $divisis->links() }}</div>
                @endif
            @endif
        </div>
    </div>
</x-layouts::app>
