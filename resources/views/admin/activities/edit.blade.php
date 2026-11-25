@php
    $prefix = $routePrefix ?? 'admin';
    $isPenulis = auth()->user()?->role === 'penulis';
    $statusOptions = $isPenulis
        ? ['draft' => 'Draft', 'review' => 'Review']
        : ['draft' => 'Draft', 'review' => 'Review', 'published' => 'Published', 'archived' => 'Archived'];
@endphp

<x-layouts::app :title="__('Edit Kegiatan')">
    <div class="mx-auto flex w-full max-w-4xl flex-col gap-6">
        {{-- Header & Back Navigation --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
            <flux:button class="cursor-pointer self-start sm:self-auto shrink-0" variant="subtle" icon="arrow-left" href="{{ route($prefix . '.activities.index') }}" wire:navigate />
            <div>
                <flux:heading size="xl" level="1">{{ __('Edit Kegiatan') }}</flux:heading>
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
                action="{{ route($prefix . '.activities.update', $activity) }}"
                enctype="multipart/form-data"
                x-data="{ submitting: false }"
                @submit="submitting = true"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Judul Kegiatan --}}
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Judul Kegiatan') }} <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title', $activity->title) }}"
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
                            @foreach (['Ekspedisi', 'Diklat', 'SAR & Kemanusiaan', 'Konservasi', 'Umum'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $activity->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
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
                            value="{{ old('event_date', $activity->event_date?->format('Y-m-d')) }}"
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
                            value="{{ old('location', $activity->location) }}"
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
                    <x-tiptap-editor
                        name="description"
                        id="description"
                        :value="old('description', $activity->description)"
                        :required="true"
                    />
                </div>

                {{-- File Gambar Cloudinary --}}
                <div class="space-y-3" x-data="{ previewUrl: null }">
                    <label class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Foto Dokumentasi Saat Ini') }}
                    </label>

                    <div class="w-full max-w-md aspect-video rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 shadow-xs">
                        <img
                            src="{{ $activity->image_url }}"
                            alt="{{ $activity->title }}"
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
                            value="{{ old('order', $activity->order) }}"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        />
                    </div>

                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Status Publikasi') }} <span class="text-rose-500">*</span>
                        </label>
                        @php
                            $currentStatus = old('status', $activity->status ?? ($activity->is_active ? 'published' : 'draft'));
                            if ($isPenulis && ! array_key_exists($currentStatus, $statusOptions)) {
                                $currentStatus = 'draft';
                            }
                        @endphp
                        <select
                            name="status"
                            id="status"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        >
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected($currentStatus === $value)>{{ __($label) }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-zinc-500">
                            {{ $isPenulis
                                ? __('Pilih Draft untuk menyimpan sementara atau Review untuk diajukan ke Admin/Staff.')
                                : __('Hanya kegiatan berstatus Published yang tampil di halaman publik.') }}
                        </p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <flux:button
                        class="cursor-pointer w-full sm:w-auto justify-center"
                        variant="subtle"
                        href="{{ route($prefix . '.activities.index') }}"
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