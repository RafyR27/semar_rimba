<x-layouts::app :title="__('Tambah Hero Banner')">
    <div class="max-w-4xl flex flex-col gap-6">
        {{-- Header & Back Navigation --}}
        <div class="flex items-center gap-3">
            <flux:button variant="subtle" icon="arrow-left" href="{{ route('admin.hero-banners.index') }}" wire:navigate>
                {{ __('Kembali') }}
            </flux:button>
            <div>
                <flux:heading size="xl" level="1">{{ __('Tambah Hero Banner Baru') }}</flux:heading>
                <flux:subheading size="sm" class="mt-0.5">
                    {{ __('Unggah gambar dan lengkapi narasi banner untuk ditampilkan pada slider beranda.') }}
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
            <form method="POST" action="{{ route('admin.hero-banners.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Judul Banner --}}
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Judul Utama Banner') }} <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title') }}"
                        placeholder="Contoh: SEMAR RIMBA"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
                    <p class="text-xs text-zinc-500">{{ __('Teks judul berukuran besar pada hero header.') }}</p>
                </div>

                {{-- Subtitle --}}
                <div class="space-y-2">
                    <label for="subtitle" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Subjudul / Label Organisasi') }}
                    </label>
                    <input
                        type="text"
                        name="subtitle"
                        id="subtitle"
                        value="{{ old('subtitle') }}"
                        placeholder="Contoh: UKM Pecinta Alam Politeknik STIA LAN Bandung"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
                    <p class="text-xs text-zinc-500">{{ __('Teks pendukung berwarna emas di bawah judul utama.') }}</p>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Deskripsi / Narasi Petualangan') }}
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="3"
                        placeholder="Contoh: Berdiri sejak tahun 1998 di lingkungan Politeknik STIA LAN Bandung..."
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    >{{ old('description') }}</textarea>
                </div>

                {{-- File Gambar Cloudinary --}}
                <div class="space-y-2" x-data="{ previewUrl: null }">
                    <label for="image" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('File Gambar Banner') }} <span class="text-rose-500">*</span>
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
                                <img :src="previewUrl" alt="Pratinjau Banner" class="w-full h-full object-cover object-center" />
                            </div>
                        </div>
                    </template>

                    <p class="text-xs text-zinc-500">
                        {{ __('Format yang didukung: JPG, PNG, WEBP. Ukuran maksimal 4MB. Gambar akan diunggah ke Cloudinary dan dioptimasi secara otomatis.') }}
                    </p>
                </div>

                {{-- CTA Button Setting (Two columns) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="space-y-2">
                        <label for="button_text" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Teks Tombol (Opsional)') }}
                        </label>
                        <input
                            type="text"
                            name="button_text"
                            id="button_text"
                            value="{{ old('button_text') }}"
                            placeholder="Contoh: Mengenal Profil Kami"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        />
                    </div>

                    <div class="space-y-2">
                        <label for="button_url" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('URL / Tautan Tombol') }}
                        </label>
                        <input
                            type="text"
                            name="button_url"
                            id="button_url"
                            value="{{ old('button_url') }}"
                            placeholder="Contoh: #tentang atau https://..."
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        />
                    </div>
                </div>

                {{-- Status & Order Setting (Two columns) --}}
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
                                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Aktifkan Banner') }}</span>
                                <p class="text-xs text-zinc-500">{{ __('Jika dicentang, banner akan langsung tayang di beranda.') }}</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <flux:button variant="subtle" href="{{ route('admin.hero-banners.index') }}" wire:navigate>
                        {{ __('Batal') }}
                    </flux:button>
                    <flux:button variant="primary" type="submit" icon="check">
                        {{ __('Simpan Banner') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
