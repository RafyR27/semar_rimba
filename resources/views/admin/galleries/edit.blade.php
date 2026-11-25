@php
    $prefix = auth()->user()?->role === 'staff' ? 'staff' : 'admin';
@endphp

<x-layouts::app :title="__('Edit Foto Galeri')">
    <div class="mx-auto flex w-full max-w-4xl flex-col gap-6">
        {{-- Header & Back Navigation --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
            <flux:button class="cursor-pointer self-start sm:self-auto shrink-0" variant="subtle" icon="arrow-left" href="{{ route($prefix . '.galleries.index') }}" wire:navigate />
            <div>
                <flux:heading size="xl" level="1">{{ __('Edit Foto Galeri') }}</flux:heading>
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
            <form
                method="POST"
                action="{{ route($prefix . '.galleries.update', $gallery) }}"
                enctype="multipart/form-data"
                x-data="{ submitting: false }"
                @submit="submitting = true"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Judul Dokumentasi --}}
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Judul Dokumentasi') }} <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title', $gallery->title) }}"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
                </div>

                {{-- Kategori --}}
                <div class="space-y-2">
                    <label for="category" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Kategori Divisi / Kegiatan') }}
                    </label>
                    <input
                        type="text"
                        name="category"
                        id="category"
                        value="{{ old('category', $gallery->category) }}"
                        placeholder="Contoh: Gunung Hutan, Panjat Tebing, Susur Gua, Arung Jeram"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    />
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Deskripsi Dokumentasi') }}
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="3"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                    >{{ old('description', $gallery->description) }}</textarea>
                </div>

                {{-- File Gambar Cloudinary --}}
                <div class="space-y-3" x-data="{ previewUrl: null }">
                    <label class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Foto Dokumentasi Saat Ini') }}
                    </label>

                    <div class="w-full max-w-md aspect-video rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 shadow-xs">
                        <img
                            src="{{ $gallery->image_url }}"
                            alt="{{ $gallery->title }}"
                            class="w-full h-full object-cover object-center"
                        />
                    </div>

                    <div class="pt-2">
                        <label for="image" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                            {{ __('Ganti Foto (Opsional):') }}
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
                            {{ __('Biarkan kosong jika tidak ingin mengubah foto. Jika file baru diunggah, foto lama di Cloudinary akan dihapus secara otomatis.') }}
                        </p>
                    </div>

                    {{-- Live Replacement Preview --}}
                    <template x-if="previewUrl">
                        <div class="mt-3">
                            <p class="text-xs font-semibold text-amber-600 dark:text-amber-400 mb-1.5">{{ __('Pratinjau Foto Pengganti Baru:') }}</p>
                            <div class="w-full max-w-md aspect-video rounded-lg overflow-hidden border-2 border-amber-500 shadow-md bg-black">
                                <img :src="previewUrl" alt="Pratinjau Pengganti" class="w-full h-full object-cover object-center" />
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Status & Order Setting --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <div class="space-y-2">
                        <label for="order" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Urutan Tampil') }}
                        </label>
                        <input
                            type="number"
                            name="order"
                            id="order"
                            min="0"
                            value="{{ old('order', $gallery->order) }}"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        />
                    </div>

                    <div class="flex items-start sm:items-center pt-1 sm:pt-7">
                        <label class="relative flex items-start sm:items-center gap-3 cursor-pointer select-none">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                {{ old('is_active', $gallery->is_active ? '1' : '0') === '1' ? 'checked' : '' }}
                                class="mt-0.5 sm:mt-0 size-4.5 rounded text-amber-500 border-zinc-300 dark:border-zinc-700 focus:ring-amber-500"
                            />
                            <div>
                                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Tampilkan di Galeri Publik') }}</span>
                                <p class="text-xs text-zinc-500">{{ __('Jika dicentang, foto akan tampil di halaman galeri.') }}</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <flux:button
                        class="cursor-pointer w-full sm:w-auto justify-center"
                        variant="subtle"
                        href="{{ route($prefix . '.galleries.index') }}"
                        wire:navigate
                        x-bind:class="{ 'pointer-events-none opacity-60': submitting }"
                    >
                        {{ __('Batal') }}
                    </flux:button>
                    <flux:button
                        class="cursor-pointer w-full sm:w-auto justify-center"
                        variant="primary"
                        type="submit"
                        x-bind:disabled="submitting"
                    >
                        <span class="inline-flex items-center justify-center gap-2">
                            <flux:icon.arrow-path x-show="submitting" x-cloak class="size-4 animate-spin" />
                            <flux:icon.check x-show="!submitting" class="size-4" />
                            <span>{{ __('Simpan Perubahan') }}</span>
                        </span>
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>