<x-layouts::app :title="__('Tambah Kegiatan')">
    <div class="max-w-4xl flex flex-col gap-6">
        {{-- Header & Back Navigation --}}
        <div class="flex items-center gap-3">
            <flux:button variant="subtle" icon="arrow-left" href="{{ route('admin.activities.index') }}" wire:navigate>
                {{ __('Kembali') }}
            </flux:button>
            <div>
                <flux:heading size="xl" level="1">{{ __('Tambah Kegiatan Baru') }}</flux:heading>
                <flux:subheading size="sm" class="mt-0.5">
                    {{ __('Tambahkan dokumentasi perjalanan, program kerja, atau artikel kegiatan SEMAR RIMBA.') }}
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
            <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Judul Kegiatan --}}
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Judul Kegiatan') }} <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title') }}"
                        placeholder="Contoh: Ekspedisi Pendakian Gunung Ciremai"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
                </div>

                {{-- Kategori, Tanggal & Lokasi --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label for="category" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Kategori') }} <span class="text-rose-500">*</span>
                        </label>
                        <select
                            name="category"
                            id="category"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        >
                            <option value="">{{ __('-- Pilih Kategori --') }}</option>
                            @foreach (['Ekspedisi', 'Diklat', 'SAR & Kemanusiaan', 'Konservasi', 'Umum'] as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="event_date" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Tanggal Pelaksanaan') }}
                        </label>
                        <input
                            type="date"
                            name="event_date"
                            id="event_date"
                            value="{{ old('event_date') }}"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        />
                    </div>

                    <div class="space-y-2">
                        <label for="location" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Lokasi') }}
                        </label>
                        <input
                            type="text"
                            name="location"
                            id="location"
                            value="{{ old('location') }}"
                            placeholder="Contoh: Kuningan, Jawa Barat"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        />
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Deskripsi / Laporan Kegiatan') }} <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="5"
                        required
                        placeholder="Tuliskan rincian pelaksanaan, tujuan, dan hasil kegiatan..."
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    >{{ old('description') }}</textarea>
                </div>

                {{-- File Gambar Cloudinary --}}
                <div class="space-y-2" x-data="{ previewUrl: null }">
                    <label for="image" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Foto Dokumentasi') }} <span class="text-rose-500">*</span>
                    </label>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <input
                            type="file"
                            name="image"
                            id="image"
                            accept="image/jpeg,image/png,image/webp"
                            required
                            @change="const file = $event.target.files[0]; if (file) { previewUrl = URL.createObjectURL(file); }"
                            class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-stone-950 hover:file:bg-amber-400 file:cursor-pointer cursor-pointer border border-zinc-300 dark:border-zinc-700 rounded-lg p-2 dark:bg-zinc-800"
                        />
                    </div>

                    {{-- Live Preview --}}
                    <template x-if="previewUrl">
                        <div class="mt-3">
                            <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">{{ __('Pratinjau Gambar:') }}</p>
                            <div class="w-full max-w-md aspect-video rounded-lg overflow-hidden border border-zinc-300 dark:border-zinc-700 shadow-sm bg-black">
                                <img :src="previewUrl" alt="Pratinjau Kegiatan" class="w-full h-full object-cover object-center" />
                            </div>
                        </div>
                    </template>

                    <p class="text-xs text-zinc-500">
                        {{ __('Format yang didukung: JPG, PNG, WEBP. Ukuran maksimal 4MB. Gambar akan diunggah ke Cloudinary.') }}
                    </p>
                </div>

                {{-- Status & Order Setting --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-zinc-200 dark:border-zinc-800">
                    <div class="space-y-2">
                        <label for="order" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Urutan Tampil') }}
                        </label>
                        <input
                            type="number"
                            name="order"
                            id="order"
                            min="0"
                            value="{{ old('order', 0) }}"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        />
                        <p class="text-xs text-zinc-500">{{ __('Angka kecil ditampilkan lebih dahulu.') }}</p>
                    </div>

                    <div class="flex items-center pt-8">
                        <label class="relative flex items-center gap-3 cursor-pointer select-none">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                {{ old('is_active', '1') === '1' ? 'checked' : '' }}
                                class="size-4.5 rounded text-amber-500 border-zinc-300 dark:border-zinc-700 focus:ring-amber-500"
                            />
                            <div>
                                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Publikasikan Kegiatan') }}</span>
                                <p class="text-xs text-zinc-500">{{ __('Jika dicentang, kegiatan akan langsung tayang di halaman publik.') }}</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <flux:button variant="subtle" href="{{ route('admin.activities.index') }}" wire:navigate>
                        {{ __('Batal') }}
                    </flux:button>
                    <flux:button variant="primary" type="submit" icon="check">
                        {{ __('Simpan Kegiatan') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>