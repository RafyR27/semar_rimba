<div>
    <label for="nama" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Nama Lengkap <span class="text-rose-500">*</span></label>
    <input id="nama" name="nama" type="text" required maxlength="120" value="{{ old('nama', $pengurus->nama ?? '') }}" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
    @error('nama')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
</div>
<div>
    <label for="nim" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-200">NIM</label>
    <input id="nim" name="nim" type="text" maxlength="30" value="{{ old('nim', $pengurus->nim ?? '') }}" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
    @error('nim')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
</div>
<div>
    <label for="jabatan" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Jabatan <span class="text-rose-500">*</span></label>
    <input id="jabatan" name="jabatan" type="text" required maxlength="100" placeholder="Contoh: Ketua Umum / Kepala Divisi" value="{{ old('jabatan', $pengurus->jabatan ?? '') }}" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
    @error('jabatan')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
</div>
<div>
    <label for="divisi_id" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Divisi</label>
    <select id="divisi_id" name="divisi_id" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
        <option value="">Tidak terikat divisi</option>
        @foreach ($divisis as $divisi)
            <option value="{{ $divisi->id }}" @selected((string) old('divisi_id', $pengurus->divisi_id ?? '') === (string) $divisi->id)>{{ $divisi->nama }}{{ $divisi->is_active ? '' : ' (Nonaktif)' }}</option>
        @endforeach
    </select>
    @error('divisi_id')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
</div>
<div>
    <label for="angkatan" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Angkatan / Periode</label>
    <input id="angkatan" name="angkatan" type="text" maxlength="20" placeholder="Contoh: 2024" value="{{ old('angkatan', $pengurus->angkatan ?? '') }}" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white">
    @error('angkatan')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
</div>
<div>
    <input type="hidden" name="is_active" value="0">
    <label class="inline-flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-200">
        <input type="checkbox" name="is_active" value="1" @checked((bool) old('is_active', $pengurus->is_active ?? true)) class="rounded border-zinc-300 text-amber-600 focus:ring-amber-500">
        Pengurus aktif
    </label>
    @error('is_active')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
</div>
