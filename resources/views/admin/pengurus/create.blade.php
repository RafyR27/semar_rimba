<x-layouts::app :title="__('Tambah Pengurus')">
    <div class="mx-auto flex w-full max-w-2xl flex-col gap-6">
        <div>
            <flux:heading size="xl" level="1">Tambah Pengurus</flux:heading>
            <flux:subheading class="mt-1">Masukkan data pengurus baru.</flux:subheading>
        </div>
        <form method="POST" action="{{ route('admin.pengurus.store') }}" class="space-y-5 rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            @csrf
            @include('admin.pengurus.form')
            <div class="flex justify-end gap-2 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                <flux:button variant="ghost" href="{{ route('admin.pengurus.index') }}">Batal</flux:button>
                <flux:button variant="primary" type="submit">Simpan Pengurus</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
