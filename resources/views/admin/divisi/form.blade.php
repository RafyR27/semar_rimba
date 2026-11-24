<div>
    <label for="nama" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Nama Divisi <span class="text-rose-500">*</span></label>
    <input id="nama" name="nama" type="text" required maxlength="100" value="{{ old('nama', $divisi->nama ?? '') }}" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
    @error('nama')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
</div>
<div>
    <label for="deskripsi" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="4" maxlength="2000" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">{{ old('deskripsi', $divisi->deskripsi ?? '') }}</textarea>
    @error('deskripsi')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
</div>
<div>
    <input type="hidden" name="is_active" value="0">
    <label class="inline-flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-200">
        <input type="checkbox" name="is_active" value="1" @checked((bool) old('is_active', $divisi->is_active ?? true)) class="rounded border-zinc-300 text-amber-600 focus:ring-amber-500">
        Tampilkan divisi di website
    </label>
    @error('is_active')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
</div>
