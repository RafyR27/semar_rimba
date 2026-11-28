<x-layouts::app :title="__('Dashboard Admin')">
    <div class="flex flex-col gap-6 w-full min-w-0">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Dashboard Admin') }}</flux:heading>
                <flux:subheading size="lg" class="mt-1">
                    {{ __('Ringkasan akun pengguna, antrean review editorial, dan aset organisasi SEMAR RIMBA.') }}
                </flux:subheading>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <flux:button variant="filled" icon="users" href="{{ route('admin.users-management.index') }}" wire:navigate>
                    {{ __('Kelola Pengguna') }}
                </flux:button>
                <flux:button variant="primary" icon="newspaper" href="{{ route('admin.beritas.index', ['status' => 'review']) }}" wire:navigate>
                    {{ __('Antrean Review (:count)', ['count' => $reviewQueue['total']]) }}
                </flux:button>
            </div>
        </div>

        {{-- Primary KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <x-dashboard.stat-card
                :title="__('Total Pengguna')"
                :value="$userStats['total']"
                :subtitle="__(':active aktif · :inactive nonaktif', ['active' => $userStats['active'], 'inactive' => $userStats['inactive']])"
                icon="users"
                tone="sky"
                :href="route('admin.users-management.index')"
                :action-label="__('Kelola pengguna')"
            />

            <x-dashboard.stat-card
                :title="__('Menunggu Review')"
                :value="$reviewQueue['total']"
                :subtitle="__(':activities kegiatan · :beritas berita', ['activities' => $reviewQueue['activities'], 'beritas' => $reviewQueue['beritas']])"
                icon="inbox-stack"
                tone="amber"
                :href="route('admin.activities.index', ['status' => 'review'])"
                :action-label="__('Tinjau antrean')"
            />

            <x-dashboard.stat-card
                :title="__('Pengurus Aktif')"
                :value="$organizationStats['pengurus_active']"
                :subtitle="__(':total total pengurus · :divisi divisi (:divisiActive aktif)', [
                    'total' => $organizationStats['pengurus_total'],
                    'divisi' => $organizationStats['divisi_total'],
                    'divisiActive' => $organizationStats['divisi_active'],
                ])"
                icon="user-group"
                tone="emerald"
                :href="route('admin.pengurus.index')"
                :action-label="__('Kelola pengurus')"
            />

            <x-dashboard.stat-card
                :title="__('Galeri & Hero Banner')"
                :value="$organizationStats['gallery_total'] + $organizationStats['banner_total']"
                :subtitle="__(':galleries galeri (:galleryActive aktif) · :banners banner (:bannerActive aktif)', [
                    'galleries' => $organizationStats['gallery_total'],
                    'galleryActive' => $organizationStats['gallery_active'],
                    'banners' => $organizationStats['banner_total'],
                    'bannerActive' => $organizationStats['banner_active'],
                ])"
                icon="photo"
                tone="neutral"
                :href="route('admin.galleries.index')"
                :action-label="__('Kelola media')"
            />
        </div>

        {{-- Role & Status Breakdowns --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <x-dashboard.status-breakdown
                :title="__('Pengguna per Role')"
                :subtitle="__('Distribusi akun dan status keaktifan')"
                :total="$userStats['total']"
                :items="[
                    ['label' => __('Admin'), 'count' => $userStats['by_role']['admin'], 'tone' => 'sky', 'href' => route('admin.users-management.index', ['role' => 'admin'])],
                    ['label' => __('Staff'), 'count' => $userStats['by_role']['staff'], 'tone' => 'emerald', 'href' => route('admin.users-management.index', ['role' => 'staff'])],
                    ['label' => __('Penulis'), 'count' => $userStats['by_role']['penulis'], 'tone' => 'amber', 'href' => route('admin.users-management.index', ['role' => 'penulis'])],
                    ['label' => __('Akun Aktif / Nonaktif'), 'count' => $userStats['active'] . ' / ' . $userStats['inactive'], 'tone' => 'neutral'],
                ]"
                :href="route('admin.users-management.index')"
                :href-label="__('Buka manajemen pengguna')"
            />

            <x-dashboard.status-breakdown
                :title="__('Status Kegiatan')"
                :subtitle="__('Rekap kegiatan yang diajukan dan dipublikasikan')"
                :total="$activityStats['total']"
                :items="[
                    ['label' => __('Menunggu Review'), 'count' => $activityStats['review'], 'tone' => 'amber', 'href' => route('admin.activities.index', ['status' => 'review'])],
                    ['label' => __('Published'), 'count' => $activityStats['published'], 'tone' => 'emerald', 'href' => route('admin.activities.index', ['status' => 'published'])],
                    ['label' => __('Archived'), 'count' => $activityStats['archived'], 'tone' => 'sky', 'href' => route('admin.activities.index', ['status' => 'archived'])],
                ]"
                :href="route('admin.activities.index')"
                :href-label="__('Kelola kegiatan')"
            />

            <x-dashboard.status-breakdown
                :title="__('Status Berita')"
                :subtitle="__('Rekap berita yang diajukan dan diterbitkan')"
                :total="$beritaStats['total']"
                :items="[
                    ['label' => __('Menunggu Review'), 'count' => $beritaStats['review'], 'tone' => 'amber', 'href' => route('admin.beritas.index', ['status' => 'review'])],
                    ['label' => __('Published'), 'count' => $beritaStats['published'], 'tone' => 'emerald', 'href' => route('admin.beritas.index', ['status' => 'published'])],
                    ['label' => __('Archived'), 'count' => $beritaStats['archived'], 'tone' => 'sky', 'href' => route('admin.beritas.index', ['status' => 'archived'])],
                ]"
                :href="route('admin.beritas.index')"
                :href-label="__('Kelola berita')"
            />
        </div>

        {{-- Organization Snapshot --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-dashboard.stat-card
                :title="__('Jumlah Divisi')"
                :value="$organizationStats['divisi_total']"
                :subtitle="__(':active divisi aktif', ['active' => $organizationStats['divisi_active']])"
                icon="folder-open"
                :href="route('admin.divisi.index')"
                :action-label="__('Lihat divisi')"
            />
            <x-dashboard.stat-card
                :title="__('Total Pengurus')"
                :value="$organizationStats['pengurus_total']"
                :subtitle="__(':active pengurus aktif', ['active' => $organizationStats['pengurus_active']])"
                icon="identification"
                :href="route('admin.pengurus.index')"
                :action-label="__('Lihat pengurus')"
            />
            <x-dashboard.stat-card
                :title="__('Jumlah Galeri')"
                :value="$organizationStats['gallery_total']"
                :subtitle="__(':active foto aktif', ['active' => $organizationStats['gallery_active']])"
                icon="squares-2x2"
                :href="route('admin.galleries.index')"
                :action-label="__('Lihat galeri')"
            />
            <x-dashboard.stat-card
                :title="__('Jumlah Hero Banner')"
                :value="$organizationStats['banner_total']"
                :subtitle="__(':active banner aktif', ['active' => $organizationStats['banner_active']])"
                icon="photo"
                :href="route('admin.hero-banners.index')"
                :action-label="__('Lihat hero banner')"
            />
        </div>

        {{-- Recent Editorial Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-dashboard.content-list
                :title="__('Kegiatan Terbaru / Antrean Review')"
                :subtitle="__('Prioritas konten berstatus review dan pembaruan terakhir')"
                :items="$recentActivities"
                :empty-text="__('Belum ada kegiatan yang diajukan atau dipublikasikan.')"
                :view-all-href="route('admin.activities.index')"
                :view-all-label="__('Semua kegiatan')"
            />

            <x-dashboard.content-list
                :title="__('Berita Terbaru / Antrean Review')"
                :subtitle="__('Prioritas berita berstatus review dan pembaruan terakhir')"
                :items="$recentBeritas"
                :empty-text="__('Belum ada berita yang diajukan atau diterbitkan.')"
                :view-all-href="route('admin.beritas.index')"
                :view-all-label="__('Semua berita')"
            />
        </div>
    </div>
</x-layouts::app>
