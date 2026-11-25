<x-layouts::app :title="__('Kelola Profil dan Kontak')">
    <div class="max-w-5xl flex flex-col gap-6">
        {{-- Header --}}
        <div class="flex items-center gap-3">
            <div>
                <flux:heading size="xl" level="1">{{ __('Kelola Profil dan Kontak') }}</flux:heading>
                <flux:subheading size="sm" class="mt-0.5">
                    {{ __('Perbarui identitas organisasi, visi misi, logo, serta informasi kontak yang tampil di halaman publik.') }}
                </flux:subheading>
            </div>
        </div>

        {{-- Flash: Success --}}
        @if (session('status'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- Flash: Error --}}
        @if (session('error'))
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation Errors --}}
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

        <form method="POST" action="{{ route('admin.organization-profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Group A: Profil Organisasi --}}
            <div class="p-6 sm:p-8 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-xs">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">{{ __('Profil Organisasi') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        {{ __('Identitas utama organisasi yang digunakan pada halaman Tentang Kami dan beranda.') }}
                    </p>
                </div>

                <div class="space-y-6">
                    {{-- Nama Organisasi --}}
                    <div class="space-y-2">
                        <label for="nama_organisasi" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Nama Organisasi') }} <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nama_organisasi"
                            id="nama_organisasi"
                            value="{{ old('nama_organisasi', $profile?->nama_organisasi) }}"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        />
                    </div>

                    {{-- Deskripsi Singkat --}}
                    <div class="space-y-2">
                        <label for="deskripsi_singkat" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Deskripsi Singkat') }} <span class="text-rose-500">*</span>
                        </label>
                        <textarea
                            name="deskripsi_singkat"
                            id="deskripsi_singkat"
                            rows="3"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        >{{ old('deskripsi_singkat', $profile?->deskripsi_singkat) }}</textarea>
                        <p class="text-xs text-zinc-500">{{ __('Tampil sebagai paragraf pembuka pada bagian Tentang Kami.') }}</p>
                    </div>

                    {{-- Sejarah --}}
                    <div class="space-y-2">
                        <label for="sejarah" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Sejarah Organisasi') }} <span class="text-rose-500">*</span>
                        </label>
                        <textarea
                            name="sejarah"
                            id="sejarah"
                            rows="5"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        >{{ old('sejarah', $profile?->sejarah) }}</textarea>
                    </div>

                    {{-- Visi --}}
                    <div class="space-y-2">
                        <label for="visi" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Visi') }} <span class="text-rose-500">*</span>
                        </label>
                        <textarea
                            name="visi"
                            id="visi"
                            rows="3"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        >{{ old('visi', $profile?->visi) }}</textarea>
                    </div>

                    {{-- Misi --}}
                    <div class="space-y-2">
                        <label for="misi" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Misi') }} <span class="text-rose-500">*</span>
                        </label>
                        <textarea
                            name="misi"
                            id="misi"
                            rows="5"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        >{{ old('misi', $profile?->misi) }}</textarea>
                        <p class="text-xs text-zinc-500">{{ __('Tuliskan satu butir misi per baris agar tampil sebagai daftar pilar misi.') }}</p>
                    </div>

                    {{-- Logo --}}
                    <div class="space-y-3 pt-2 border-t border-zinc-200 dark:border-zinc-800" x-data="{ previewUrl: null }">
                        <label class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Logo Organisasi') }}
                        </label>

                        <div>
                            <p class="text-xs text-zinc-500 mb-1.5">{{ __('Logo yang saat ini digunakan:') }}</p>
                            <div class="size-24 rounded-lg overflow-hidden border border-zinc-300 dark:border-zinc-700 shadow-sm bg-white flex items-center justify-center p-2">
                                <img src="{{ $profile?->logoUrl() ?? asset('images/logo.png') }}" alt="{{ $profile?->displayName() ?? __('SEMAR RIMBA') }}" class="max-w-full max-h-full object-contain" />
                            </div>
                        </div>

                        <div class="pt-1">
                            <label for="logo" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                {{ __('Ganti Logo (Opsional):') }}
                            </label>
                            <input
                                type="file"
                                name="logo"
                                id="logo"
                                accept="image/jpeg,image/png,image/webp"
                                @change="const file = $event.target.files[0]; if (file) { previewUrl = URL.createObjectURL(file); }"
                                class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-stone-950 hover:file:bg-amber-400 file:cursor-pointer cursor-pointer border border-zinc-300 dark:border-zinc-700 rounded-lg p-2 dark:bg-zinc-800"
                            />
                            <p class="text-xs text-zinc-500 mt-1">
                                {{ __('Biarkan kosong jika tidak ingin mengubah logo. Format JPG, PNG, atau WEBP maksimal 4MB.') }}
                            </p>
                        </div>

                        <template x-if="previewUrl">
                            <div class="mt-3">
                                <p class="text-xs font-semibold text-amber-600 dark:text-amber-400 mb-1.5">{{ __('Pratinjau Logo Pengganti:') }}</p>
                                <div class="size-24 rounded-lg overflow-hidden border-2 border-amber-500 shadow-md bg-white flex items-center justify-center p-2">
                                    <img :src="previewUrl" alt="{{ __('Pratinjau Logo') }}" class="max-w-full max-h-full object-contain" />
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Group B: Informasi Kontak --}}
            <div class="p-6 sm:p-8 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-xs">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">{{ __('Informasi Kontak') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        {{ __('Kontak sekretariat dan tautan media sosial yang tampil pada footer serta bagian media sosial.') }}
                    </p>
                </div>

                <div class="space-y-6">
                    {{-- Alamat --}}
                    <div class="space-y-2">
                        <label for="alamat" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ __('Alamat Sekretariat') }} <span class="text-rose-500">*</span>
                        </label>
                        <textarea
                            name="alamat"
                            id="alamat"
                            rows="2"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                        >{{ old('alamat', $profile?->alamat) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Email --}}
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                {{ __('Email') }}
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $profile?->email) }}"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                            />
                        </div>

                        {{-- Telepon --}}
                        <div class="space-y-2">
                            <label for="telepon" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                {{ __('Nomor Telepon') }}
                            </label>
                            <input
                                type="text"
                                name="telepon"
                                id="telepon"
                                value="{{ old('telepon', $profile?->telepon) }}"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                            />
                        </div>

                        {{-- WhatsApp --}}
                        <div class="space-y-2">
                            <label for="whatsapp" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                {{ __('Nomor WhatsApp') }}
                            </label>
                            <input
                                type="text"
                                name="whatsapp"
                                id="whatsapp"
                                value="{{ old('whatsapp', $profile?->whatsapp) }}"
                                placeholder="62812xxxxxxx"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                            />
                        </div>

                        {{-- Google Maps --}}
                        <div class="space-y-2">
                            <label for="google_maps_url" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                {{ __('URL Google Maps') }}
                            </label>
                            <input
                                type="url"
                                name="google_maps_url"
                                id="google_maps_url"
                                value="{{ old('google_maps_url', $profile?->google_maps_url) }}"
                                placeholder="https://maps.google.com/..."
                                class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                            />
                        </div>

                        {{-- Instagram --}}
                        <div class="space-y-2">
                            <label for="instagram_url" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                {{ __('URL Instagram') }}
                            </label>
                            <input
                                type="url"
                                name="instagram_url"
                                id="instagram_url"
                                value="{{ old('instagram_url', $profile?->instagram_url) }}"
                                placeholder="https://instagram.com/..."
                                class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                            />
                        </div>

                        {{-- TikTok --}}
                        <div class="space-y-2">
                            <label for="tiktok_url" class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                {{ __('URL TikTok') }}
                            </label>
                            <input
                                type="url"
                                name="tiktok_url"
                                id="tiktok_url"
                                value="{{ old('tiktok_url', $profile?->tiktok_url) }}"
                                placeholder="https://tiktok.com/@..."
                                class="w-full px-3.5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                            />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3">
                <flux:button variant="primary" type="submit" icon="check">
                    {{ __('Simpan Pengaturan') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
