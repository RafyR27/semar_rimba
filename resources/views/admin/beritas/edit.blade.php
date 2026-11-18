<x-layouts::app :title="__('Edit Berita')">
    <div class="max-w-4xl flex flex-col gap-6">
        {{-- Header & Back Navigation --}}
        <div class="flex items-center gap-3">
            <flux:button variant="subtle" icon="arrow-left" href="{{ route('admin.beritas.index') }}" wire:navigate>
                {{ __('Kembali') }}
            </flux:button>
            <div>
                <flux:heading size="xl" level="1">{{ __('Edit Berita') }}</flux:heading>
                <flux:subheading size="sm" class="mt-0.5">
                    {{ __('Perbarui isi berita, ganti gambar, atau ubah status publikasi.') }}
                </flux:subheading>
            </div>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 text-sm">
                <p class="font-bold mb-1">{{ __('Terdapat kesalahan pada formulir:') }}</p>
                <ul class="list-disc list-inside space-y-0.5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form Card --}}
        <div class="p-6 sm:p-8 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-xs">
            <form method="POST" action="{{ route('admin.beritas.update', $berita) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Judul Berita --}}
                <div class="space-y-2">
                    <label for="judul" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Judul Berita') }} <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="judul"
                        id="judul"
                        value="{{ old('judul', $berita->judul) }}"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
                </div>

                {{-- Slug --}}
                <div class="space-y-2">
                    <label for="slug" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Slug') }}
                    </label>
                    <input
                        type="text"
                        name="slug"
                        id="slug"
                        value="{{ old('slug', $berita->slug) }}"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
                    <p class="text-xs text-zinc-500">{{ __('Slug digunakan pada URL halaman publik berita.') }}</p>
                </div>

                {{-- Isi Berita --}}
                <div class="space-y-2">
                    <label for="konten" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Isi Berita') }} <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        name="konten"
                        id="konten"
                        rows="14"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    >{{ old('konten', $berita->konten) }}</textarea>
                </div>

                {{-- Current Image & Replacement --}}
                <div class="space-y-3" x-data="{ previewUrl: null }">
                    <label class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Gambar Berita') }}
                    </label>

                    {{-- Current Image Display --}}
                    @if ($berita->thumbnail_url)
                        <div>
                            <p class="text-xs text-zinc-500 mb-1.5">{{ __('Gambar yang saat ini digunakan (Cloudinary):') }}</p>
                            <div class="w-full max-w-md aspect-video rounded-lg overflow-hidden border border-zinc-300 dark:border-zinc-700 shadow-sm bg-black">
                                <img src="{{ $berita->thumbnail_url }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover object-center" />
                            </div>
                        </div>
                    @endif

                    {{-- Replacement Upload Input --}}
                    <div class="pt-2">
                        <label for="thumbnail" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                            {{ __('Ganti Gambar (Opsional):') }}
                        </label>
                        <input
                            type="file"
                            name="thumbnail"
                            id="thumbnail"
                            accept="image/jpeg,image/png,image/webp"
                            @change="const file = $event.target.files[0]; if (file) { previewUrl = URL.createObjectURL(file); }"
                            class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-stone-950 hover:file:bg-amber-400 file:cursor-pointer cursor-pointer border border-zinc-300 dark:border-zinc-700 rounded-lg p-2 dark:bg-zinc-800"
                        />
                        <p class="text-xs text-zinc-500 mt-1">
                            {{ __('Biarkan kosong jika tidak ingin mengubah gambar. Jika file baru diunggah, gambar lama di Cloudinary akan dihapus secara otomatis.') }}
                        </p>
                    </div>

                    {{-- Live Replacement Preview --}}
                    <template x-if="previewUrl">
                        <div class="mt-3">
                            <p class="text-xs font-semibold text-amber-600 dark:text-amber-400 mb-1.5">{{ __('Pratinjau Gambar Pengganti Baru:') }}</p>
                            <div class="w-full max-w-md aspect-video rounded-lg overflow-hidden border-2 border-amber-500 shadow-md bg-black">
                                <img :src="previewUrl" alt="Pratinjau Pengganti" class="w-full h-full object-cover object-center" />
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Tanggal & Status Publikasi --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-zinc-200 dark:border-zinc-800">
                    <div class="space-y-2">
                        <label for="tanggal_terbit" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Tanggal Publikasi') }}
                        </label>
                        <input
                            type="date"
                            name="tanggal_terbit"
                            id="tanggal_terbit"
                            value="{{ old('tanggal_terbit', $berita->tanggal_terbit?->toDateString()) }}"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        />
                    </div>

                    <div class="flex items-center pt-8">
                        <label class="relative flex items-center gap-3 cursor-pointer select-none">
                            <input
                                type="checkbox"
                                name="is_published"
                                value="1"
                                {{ old('is_published', $berita->is_published ? '1' : '0') === '1' ? 'checked' : '' }}
                                class="size-4.5 rounded text-amber-500 border-zinc-300 dark:border-zinc-700 focus:ring-amber-500"
                            />
                            <div>
                                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Terbitkan Berita') }}</span>
                                <p class="text-xs text-zinc-500">{{ __('Jika tidak dicentang, berita disimpan sebagai draft dan tidak tampil untuk pengunjung.') }}</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <flux:button variant="subtle" href="{{ route('admin.beritas.index') }}" wire:navigate>
                        {{ __('Batal') }}
                    </flux:button>
                    <flux:button variant="primary" type="submit" icon="check">
                        {{ __('Simpan Perubahan') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
