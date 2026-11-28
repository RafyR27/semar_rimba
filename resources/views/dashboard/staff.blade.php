<x-layouts::app :title="__('Dashboard Staff')">
    <div class="flex flex-col gap-6 w-full min-w-0">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Dashboard Staff') }}</flux:heading>
                <flux:subheading size="lg" class="mt-1">
                    {{ __('Ringkasan operasional editorial, review konten, dan data organisasi SEMAR RIMBA.') }}
                </flux:subheading>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <flux:button variant="filled" icon="calendar-days" href="{{ route('staff.activities.index', ['status' => 'review']) }}" wire:navigate>
                    {{ __('Review Kegiatan (:count)', ['count' => $reviewQueue['activities']]) }}
                </flux:button>
                <flux:button variant="primary" icon="newspaper" href="{{ route('staff.beritas.index', ['status' => 'review']) }}" wire:navigate>
                    {{ __('Review Berita (:count)', ['count' => $reviewQueue['beritas']]) }}
                </flux:button>
            </div>
        </div>

        {{-- Operational KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <x-dashboard.stat-card
                :title="__('Menunggu Review')"
                :value="$reviewQueue['total']"
                :subtitle="__(':activities kegiatan · :beritas berita', ['activities' => $reviewQueue['activities'], 'beritas' => $reviewQueue['beritas']])"
                icon="inbox-stack"
                tone="amber"
                :href="route('staff.activities.index', ['status' => 'review'])"
                :action-label="__('Tinjau antrean')"
            />

            <x-dashboard.stat-card
                :title="__('Jumlah Divisi')"
                :value="$organizationStats['divisi_total']"
                :subtitle="__(':active divisi aktif', ['active' => $organizationStats['divisi_active']])"
                icon="folder-open"
                tone="sky"
                :href="route('staff.divisi.index')"
                :action-label="__('Kelola divisi')"
            />

            <x-dashboard.stat-card
                :title="__('Pengurus Aktif')"
                :value="$organizationStats['pengurus_active']"
                :subtitle="__(':total total pengurus terdaftar', ['total' => $organizationStats['pengurus_total']])"
                icon="user-group"
                tone="emerald"
                :href="route('staff.pengurus.index')"
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
                :href="route('staff.galleries.index')"
                :action-label="__('Kelola galeri')"
            />
        </div>

        {{-- Content Status Breakdowns --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-dashboard.status-breakdown
                :title="__('Status Kegiatan')"
                :subtitle="__('Rekap kegiatan yang diajukan dan dipublikasikan')"
                :total="$activityStats['total']"
                :items="[
                    ['label' => __('Menunggu Review'), 'count' => $activityStats['review'], 'tone' => 'amber', 'href' => route('staff.activities.index', ['status' => 'review'])],
                    ['label' => __('Published'), 'count' => $activityStats['published'], 'tone' => 'emerald', 'href' => route('staff.activities.index', ['status' => 'published'])],
                    ['label' => __('Archived'), 'count' => $activityStats['archived'], 'tone' => 'sky', 'href' => route('staff.activities.index', ['status' => 'archived'])],
                ]"
                :href="route('staff.activities.index')"
                :href-label="__('Kelola kegiatan')"
            />

            <x-dashboard.status-breakdown
                :title="__('Status Berita')"
                :subtitle="__('Rekap berita yang diajukan dan diterbitkan')"
                :total="$beritaStats['total']"
                :items="[
                    ['label' => __('Menunggu Review'), 'count' => $beritaStats['review'], 'tone' => 'amber', 'href' => route('staff.beritas.index', ['status' => 'review'])],
                    ['label' => __('Published'), 'count' => $beritaStats['published'], 'tone' => 'emerald', 'href' => route('staff.beritas.index', ['status' => 'published'])],
                    ['label' => __('Archived'), 'count' => $beritaStats['archived'], 'tone' => 'sky', 'href' => route('staff.beritas.index', ['status' => 'archived'])],
                ]"
                :href="route('staff.beritas.index')"
                :href-label="__('Kelola berita')"
            />
        </div>

        {{-- Media Snapshot --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-dashboard.stat-card
                :title="__('Jumlah Galeri')"
                :value="$organizationStats['gallery_total']"
                :subtitle="__(':active foto galeri aktif', ['active' => $organizationStats['gallery_active']])"
                icon="squares-2x2"
                :href="route('staff.galleries.index')"
                :action-label="__('Lihat galeri')"
            />
            <x-dashboard.stat-card
                :title="__('Jumlah Hero Banner')"
                :value="$organizationStats['banner_total']"
                :subtitle="__(':active hero banner aktif', ['active' => $organizationStats['banner_active']])"
                icon="photo"
                :href="route('staff.hero-banners.index')"
                :action-label="__('Lihat hero banner')"
            />
        </div>

        {{-- Recent Editorial Content for Review --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-dashboard.content-list
                :title="__('Kegiatan Terbaru untuk Review')"
                :subtitle="__('Konten berstatus review diprioritaskan di bagian atas')"
                :items="$recentActivities"
                :empty-text="__('Belum ada kegiatan yang menunggu review atau dipublikasikan.')"
                :view-all-href="route('staff.activities.index')"
                :view-all-label="__('Semua kegiatan')"
            />

            <x-dashboard.content-list
                :title="__('Berita Terbaru untuk Review')"
                :subtitle="__('Berita berstatus review diprioritaskan di bagian atas')"
                :items="$recentBeritas"
                :empty-text="__('Belum ada berita yang menunggu review atau diterbitkan.')"
                :view-all-href="route('staff.beritas.index')"
                :view-all-label="__('Semua berita')"
            />
        </div>
    </div>
</x-layouts::app>
