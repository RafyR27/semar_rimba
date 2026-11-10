<x-layouts::app :title="__('Edit Hero Banner')">
    <div class="max-w-4xl flex flex-col gap-6">
        {{-- Header & Back Navigation --}}
        <div class="flex items-center gap-3">
            <flux:button variant="subtle" icon="arrow-left" href="{{ route('admin.hero-banners.index') }}" wire:navigate>
                {{ __('Kembali') }}
            </flux:button>
            <div>
                <flux:heading size="xl" level="1">{{ __('Edit Hero Banner') }}</flux:heading>
                <flux:subheading size="sm" class="mt-0.5">
                    {{ __('Perbarui informasi banner, ganti foto, atau ubah urutan dan status tayang.') }}
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
            <form method="POST" action="{{ route('admin.hero-banners.update', $banner) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Judul Banner --}}
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Judul Utama Banner') }} <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title', $banner->title) }}"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
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
                        value="{{ old('subtitle', $banner->subtitle) }}"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
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
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    >{{ old('description', $banner->description) }}</textarea>
                </div>

                {{-- Current Image & File Upload --}}
                <div class="space-y-3" x-data="{ previewUrl: null }">
                    <label class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Gambar Banner') }}
                    </label>

                    {{-- Current Image Display --}}
                    <div>
                        <p class="text-xs text-zinc-500 mb-1.5">{{ __('Gambar yang saat ini digunakan (Cloudinary):') }}</p>
                        <div class="w-full max-w-md aspect-video rounded-lg overflow-hidden border border-zinc-300 dark:border-zinc-700 shadow-sm bg-black">
                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="w-full h-full object-cover object-center" />
                        </div>
                    </div>

                    {{-- Replacement Upload Input --}}
                    <div class="pt-2">
                        <label for="image" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                            {{ __('Ganti Gambar (Opsional):') }}
                        </label>
                        <input
                            type="file"
                            name="image"
                            id="image"
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
                            value="{{ old('button_text', $banner->button_text) }}"
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
                            value="{{ old('button_url', $banner->button_url) }}"
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
                            value="{{ old('order', $banner->order) }}"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        />
                    </div>

                    <div class="flex items-center pt-8">
                        <label class="relative flex items-center gap-3 cursor-pointer select-none">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                {{ old('is_active', $banner->is_active ? '1' : '0') === '1' ? 'checked' : '' }}
                                class="size-4.5 rounded text-amber-500 border-zinc-300 dark:border-zinc-700 focus:ring-amber-500"
                            />
                            <div>
                                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Aktifkan Banner') }}</span>
                                <p class="text-xs text-zinc-500">{{ __('Jika dicentang, banner akan tayang di beranda.') }}</p>
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
                        {{ __('Simpan Perubahan') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
