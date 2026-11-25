<x-layouts::app :title="__('Kelola Pengguna')">
    <div class="flex flex-col gap-6 w-full">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Kelola Pengguna') }}</flux:heading>
                <flux:subheading size="lg" class="mt-1">
                    {{ __('Kelola daftar pengguna dan hak akses akun SEMAR RIMBA.') }}
                </flux:subheading>
            </div>

            <flux:modal.trigger name="add-user-modal">
                <flux:button variant="primary" icon="plus" type="button">
                    {{ __('Tambah Pengguna') }}
                </flux:button>
            </flux:modal.trigger>
        </div>

        {{-- Flash Messages --}}
        @if (session('status'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-sm flex items-center justify-between">
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 text-sm flex items-center justify-between">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Search & Filter Bar --}}
        <form
            method="GET"
            action="{{ route('admin.users-management.index') }}"
            x-data="{ submitting: false }"
            @submit="submitting = true"
            class="flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-3"
        >
            <div class="flex-1 min-w-60 max-w-md">
                <flux:input
                    name="search"
                    :value="$search"
                    icon="magnifying-glass"
                    :placeholder="__('Cari nama atau email pengguna...')"
                />
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <flux:button type="submit" variant="filled" x-bind:disabled="submitting">
                    <flux:icon.arrow-path x-show="submitting" x-cloak class="size-4 animate-spin" />
                    <span>{{ __('Cari') }}</span>
                </flux:button>

                <div class="w-36">
                    <flux:select name="role" @change="submitting = true; $el.form.submit()" aria-label="{{ __('Filter Role') }}">
                        <option value="">{{ __('Semua Role') }}</option>
                        <option value="admin" @selected($role === 'admin')>{{ __('Admin') }}</option>
                        <option value="staff" @selected($role === 'staff')>{{ __('Staff') }}</option>
                        <option value="penulis" @selected($role === 'penulis')>{{ __('Penulis') }}</option>
                    </flux:select>
                </div>

                <div class="w-36">
                    <flux:select name="status" @change="submitting = true; $el.form.submit()" aria-label="{{ __('Filter Status') }}">
                        <option value="">{{ __('Semua Status') }}</option>
                        <option value="1" @selected($status === '1')>{{ __('Aktif') }}</option>
                        <option value="0" @selected($status === '0')>{{ __('Nonaktif') }}</option>
                    </flux:select>
                </div>

                @if ($search !== '' || $role !== '' || $status !== '')
                    <flux:button
                        variant="subtle"
                        href="{{ route('admin.users-management.index') }}"
                        wire:navigate
                        x-data="{ loading: false }"
                        @click="loading = true"
                        x-bind:class="{ 'pointer-events-none opacity-60': loading }"
                    >
                        <flux:icon.arrow-path x-show="loading" x-cloak class="size-4 animate-spin" />
                        <span>{{ __('Reset') }}</span>
                    </flux:button>
                @endif
            </div>
        </form>

        {{-- Users Table --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-xs">
            @if ($users->isEmpty())
                <div class="py-16 px-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-3 text-zinc-400">
                        <flux:icon.users class="size-6" />
                    </div>
                    <flux:heading size="lg">{{ __('Pengguna Tidak Ditemukan') }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-zinc-500 max-w-md mx-auto">
                        {{ ($search !== '' || $role !== '' || $status !== '') ? __('Tidak ada pengguna yang cocok dengan pencarian atau filter Anda.') : __('Belum ada data pengguna di database.') }}
                    </flux:text>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 uppercase tracking-wider font-semibold">
                            <tr>
                                <th scope="col" class="py-3 px-4">{{ __('Nama') }}</th>
                                <th scope="col" class="py-3 px-4">{{ __('Email') }}</th>
                                <th scope="col" class="py-3 px-4 w-36">{{ __('Role') }}</th>
                                <th scope="col" class="py-3 px-4 w-32 text-center">{{ __('Status') }}</th>
                                <th scope="col" class="py-3 px-4 w-48">{{ __('Dibuat Pada') }}</th>
                                <th scope="col" class="py-3 px-4 w-24 text-right">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($users as $user)
                                @php
                                    $roleBadgeClass = match ($user->role) {
                                        'admin' => 'bg-rose-500/10 text-rose-700 dark:text-rose-400',
                                        'penulis' => 'bg-sky-500/10 text-sky-700 dark:text-sky-400',
                                        default => 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400',
                                    };
                                @endphp
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                                    <td class="py-4 px-4 font-semibold text-zinc-900 dark:text-white">
                                        {{ $user->name }}
                                    </td>
                                    <td class="py-4 px-4 text-zinc-600 dark:text-zinc-300">
                                        {{ $user->email }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold capitalize {{ $roleBadgeClass }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $user->status ? 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300' }}">
                                            <span class="size-1.5 rounded-full {{ $user->status ? 'bg-emerald-500' : 'bg-zinc-400' }}"></span>
                                            {{ $user->status ? __('Aktif') : __('Nonaktif') }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-zinc-500 dark:text-zinc-400">
                                        {{ $user->created_at?->format('d M Y H:i') ?? '-' }}
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <flux:dropdown position="bottom" align="end">
                                            <flux:button
                                                variant="subtle"
                                                size="sm"
                                                icon="ellipsis-vertical"
                                                aria-label="{{ __('Aksi') }}"
                                            />

                                            <flux:menu>
                                                <flux:modal.trigger name="edit-user-modal-{{ $user->id }}">
                                                    <flux:menu.item icon="pencil-square">
                                                        {{ __('Edit') }}
                                                    </flux:menu.item>
                                                </flux:modal.trigger>

                                                <flux:modal.trigger name="toggle-status-modal-{{ $user->id }}">
                                                    @if ($user->status)
                                                        <flux:menu.item icon="no-symbol" variant="danger">
                                                            {{ __('Nonaktifkan') }}
                                                        </flux:menu.item>
                                                    @else
                                                        <flux:menu.item icon="check-circle">
                                                            {{ __('Aktifkan') }}
                                                        </flux:menu.item>
                                                    @endif
                                                </flux:modal.trigger>
                                            </flux:menu>
                                        </flux:dropdown>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                        {{ $users->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Modal Tambah Pengguna --}}
    <flux:modal name="add-user-modal" :show="$errors->addUser->isNotEmpty()" focusable class="max-w-lg w-full">
        <form
            method="POST"
            action="{{ route('admin.users-management.add') }}"
            x-data="{ submitting: false }"
            @submit="submitting = true"
            class="space-y-5"
        >
            @csrf

            <div>
                <flux:heading size="lg">{{ __('Tambah Pengguna') }}</flux:heading>
                <flux:subheading>{{ __('Buat akun pengguna baru dan atur role-nya.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <flux:input
                        name="name"
                        :label="__('Nama')"
                        :value="old('name')"
                        required
                        placeholder="{{ __('Masukkan nama lengkap') }}"
                    />
                    @error('name', 'addUser')
                        <flux:text class="mt-1 text-xs text-rose-500">{{ $message }}</flux:text>
                    @enderror
                </div>

                <div>
                    <flux:input
                        name="email"
                        type="email"
                        :label="__('Email')"
                        :value="old('email')"
                        required
                        placeholder="email@example.com"
                    />
                    @error('email', 'addUser')
                        <flux:text class="mt-1 text-xs text-rose-500">{{ $message }}</flux:text>
                    @enderror
                </div>

                <div>
                    <flux:select name="role" :label="__('Role')" required>
                        <option value="admin" @selected(old('role') === 'admin')>{{ __('Admin') }}</option>
                        <option value="staff" @selected(old('role', 'staff') === 'staff')>{{ __('Staff') }}</option>
                        <option value="penulis" @selected(old('role') === 'penulis')>{{ __('Penulis') }}</option>
                    </flux:select>
                    @error('role', 'addUser')
                        <flux:text class="mt-1 text-xs text-rose-500">{{ $message }}</flux:text>
                    @enderror
                </div>

                <div>
                    <flux:input
                        name="password"
                        type="password"
                        :label="__('Password')"
                        required
                        viewable
                        placeholder="{{ __('Minimal 8 karakter') }}"
                    />
                    @error('password', 'addUser')
                        <flux:text class="mt-1 text-xs text-rose-500">{{ $message }}</flux:text>
                    @enderror
                </div>

                <div>
                    <flux:input
                        name="password_confirmation"
                        type="password"
                        :label="__('Konfirmasi Password')"
                        required
                        viewable
                        placeholder="{{ __('Ulangi password') }}"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <flux:modal.close>
                    <flux:button variant="filled" type="button" x-bind:disabled="submitting">{{ __('Batal') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="primary" type="submit" x-bind:disabled="submitting">
                    <flux:icon.arrow-path x-show="submitting" x-cloak class="size-4 animate-spin" />
                    <span>{{ __('Simpan') }}</span>
                </flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Modal Edit Pengguna --}}
    @foreach ($users as $user)
        @php
            $editBag = 'editUser'.$user->id;
            $hasEditErrors = $errors->getBag($editBag)->isNotEmpty();
        @endphp
        <flux:modal name="edit-user-modal-{{ $user->id }}" :show="$hasEditErrors" focusable class="max-w-lg w-full">
            <form
                method="POST"
                action="{{ route('admin.users-management.edit', $user) }}"
                x-data="{ submitting: false }"
                @submit="submitting = true"
                class="space-y-5"
            >
                @csrf
                @method('PUT')

                <div>
                    <flux:heading size="lg">{{ __('Edit Pengguna') }}</flux:heading>
                    <flux:subheading>{{ __('Perbarui data nama, email, dan role pengguna.') }}</flux:subheading>
                </div>

                <div class="space-y-4">
                    <div>
                        <flux:input
                            name="name"
                            :label="__('Nama')"
                            :value="$hasEditErrors ? old('name') : $user->name"
                            required
                        />
                        @error('name', $editBag)
                            <flux:text class="mt-1 text-xs text-rose-500">{{ $message }}</flux:text>
                        @enderror
                    </div>

                    <div>
                        <flux:input
                            name="email"
                            type="email"
                            :label="__('Email')"
                            :value="$hasEditErrors ? old('email') : $user->email"
                            required
                        />
                        @error('email', $editBag)
                            <flux:text class="mt-1 text-xs text-rose-500">{{ $message }}</flux:text>
                        @enderror
                    </div>

                    <div>
                        <flux:select name="role" :label="__('Role')" required>
                            @php
                                $selectedRole = $hasEditErrors ? old('role') : $user->role;
                            @endphp
                            <option value="admin" @selected($selectedRole === 'admin')>{{ __('Admin') }}</option>
                            <option value="staff" @selected($selectedRole === 'staff')>{{ __('Staff') }}</option>
                            <option value="penulis" @selected($selectedRole === 'penulis')>{{ __('Penulis') }}</option>
                        </flux:select>
                        @error('role', $editBag)
                            <flux:text class="mt-1 text-xs text-rose-500">{{ $message }}</flux:text>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button variant="filled" type="button" x-bind:disabled="submitting">{{ __('Batal') }}</flux:button>
                    </flux:modal.close>

                    <flux:button variant="primary" type="submit" x-bind:disabled="submitting">
                        <flux:icon.arrow-path x-show="submitting" x-cloak class="size-4 animate-spin" />
                        <span>{{ __('Simpan Perubahan') }}</span>
                    </flux:button>
                </div>
            </form>
        </flux:modal>

        {{-- Modal Konfirmasi Ubah Status --}}
        <flux:modal name="toggle-status-modal-{{ $user->id }}" focusable class="max-w-md w-full">
            <form
                method="POST"
                action="{{ route('admin.users-management.toggle-status', $user) }}"
                x-data="{ submitting: false }"
                @submit="submitting = true"
                class="space-y-5"
            >
                @csrf
                @method('PATCH')

                <div>
                    <flux:heading size="lg">
                        {{ $user->status ? __('Nonaktifkan Pengguna') : __('Aktifkan Pengguna') }}
                    </flux:heading>
                    <flux:subheading class="mt-1">
                        {{ $user->status
                            ? __('Apakah Anda yakin ingin menonaktifkan pengguna :name?', ['name' => $user->name])
                            : __('Apakah Anda yakin ingin mengaktifkan pengguna :name?', ['name' => $user->name]) }}
                    </flux:subheading>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button variant="filled" type="button" x-bind:disabled="submitting">{{ __('Batal') }}</flux:button>
                    </flux:modal.close>

                    <flux:button variant="{{ $user->status ? 'danger' : 'primary' }}" type="submit" x-bind:disabled="submitting">
                        <flux:icon.arrow-path x-show="submitting" x-cloak class="size-4 animate-spin" />
                        <span>{{ $user->status ? __('Nonaktifkan') : __('Aktifkan') }}</span>
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    @endforeach
</x-layouts::app>
