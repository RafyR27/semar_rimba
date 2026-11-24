<x-layouts::app :title="__('Tambah Divisi')">
    <div class="mx-auto flex w-full max-w-2xl flex-col gap-6">
        <div>
            <flux:heading size="xl" level="1">Tambah Divisi</flux:heading>
            <flux:subheading class="mt-1">Masukkan informasi divisi baru.</flux:subheading>
        </div>
        <form method="POST" action="{{ route('admin.divisi.store') }}" class="space-y-5 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            @csrf
            @include('admin.divisi.form')
            <div class="flex justify-end gap-2 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                <flux:button variant="ghost" href="{{ route('admin.divisi.index') }}">Batal</flux:button>
                <flux:button variant="primary" type="submit">Simpan Divisi</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
