<x-layouts::app :title="__('Kelola Data Pengurus')">
    <div class="flex w-full flex-col gap-6">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <flux:heading size="xl" level="1">Kelola Data Pengurus</flux:heading>
                <flux:subheading size="lg" class="mt-1">Atur identitas, jabatan, dan divisi setiap pengurus.</flux:subheading>
            </div>
            <flux:button variant="primary" icon="plus" href="{{ route('admin.pengurus.create') }}" wire:navigate>Tambah Pengurus</flux:button>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-700 dark:text-emerald-400">{{ session('status') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.pengurus.index') }}" class="flex flex-col gap-2 sm:flex-row">
            <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama, NIM, atau jabatan..." class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white sm:max-w-sm">
            <select name="divisi_id" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 outline-none focus:border-amber-500 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white sm:max-w-xs">
                <option value="">Semua Divisi</option>
                @foreach ($divisis as $divisi)
                    <option value="{{ $divisi->id }}" @selected((string) $divisiId === (string) $divisi->id)>{{ $divisi->nama }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <flux:button type="submit" variant="filled">Cari</flux:button>
                @if ($search !== '' || $divisiId)
                    <flux:button href="{{ route('admin.pengurus.index') }}" variant="ghost">Reset</flux:button>
                @endif
            </div>
        </form>

        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
            @if ($penguruses->isEmpty())
                <div class="px-6 py-14 text-center">
                    <flux:heading size="lg">Belum ada data pengurus</flux:heading>
                    <flux:text class="mt-1">Tambahkan data pengurus untuk mulai mengelola kepengurusan.</flux:text>
                    <div class="mt-5"><flux:button variant="primary" icon="plus" href="{{ route('admin.pengurus.create') }}" wire:navigate>Tambah Pengurus</flux:button></div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase tracking-wide text-zinc-500 dark:border-zinc-700 dark:bg-zinc-800/60">
                            <tr>
                                <th class="px-4 py-3">Nama & NIM</th>
                                <th class="px-4 py-3">Jabatan</th>
                                <th class="px-4 py-3">Divisi</th>
                                <th class="px-4 py-3">Angkatan</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($penguruses as $pengurus)
                                <tr class="hover:bg-zinc-50/60 dark:hover:bg-zinc-800/40">
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-zinc-900 dark:text-white">{{ $pengurus->nama }}</div>
                                        <div class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">{{ $pengurus->nim ?: 'NIM belum diisi' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-zinc-700 dark:text-zinc-300">{{ $pengurus->jabatan }}</td>
                                    <td class="px-4 py-4 text-zinc-700 dark:text-zinc-300">{{ $pengurus->divisi?->nama ?: '—' }}</td>
                                    <td class="px-4 py-4 text-zinc-700 dark:text-zinc-300">{{ $pengurus->angkatan ?: '—' }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <form method="POST" action="{{ route('admin.pengurus.toggle', $pengurus) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-full px-3 py-1 text-xs font-semibold {{ $pengurus->is_active ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300' }}">{{ $pengurus->is_active ? 'Aktif' : 'Nonaktif' }}</button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-end gap-2">
                                            <flux:button size="sm" variant="subtle" icon="pencil-square" href="{{ route('admin.pengurus.edit', $pengurus) }}" wire:navigate title="Edit pengurus" />
                                            <form method="POST" action="{{ route('admin.pengurus.destroy', $pengurus) }}" onsubmit="return confirm('Hapus data pengurus ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button size="sm" variant="danger" icon="trash" type="submit" title="Hapus pengurus" />
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($penguruses->hasPages())
                    <div class="border-t border-zinc-200 px-4 py-3 dark:border-zinc-700">{{ $penguruses->links() }}</div>
                @endif
            @endif
        </div>
    </div>
</x-layouts::app>
