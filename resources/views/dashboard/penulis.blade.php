<x-layouts::app :title="__('Dashboard Penulis')">
    <div class="flex flex-col gap-6 w-full min-w-0">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Dashboard Penulis') }}</flux:heading>
                <flux:subheading size="lg" class="mt-1">
                    {{ __('Pantau perkembangan draf, ajuan review, dan publikasi kegiatan serta berita milik Anda.') }}
                </flux:subheading>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <flux:button variant="filled" icon="plus" href="{{ route('penulis.activities.create') }}" wire:navigate>
                    {{ __('Tulis Kegiatan') }}
                </flux:button>
                <flux:button variant="primary" icon="plus" href="{{ route('penulis.beritas.create') }}" wire:navigate>
                    {{ __('Tulis Berita') }}
                </flux:button>
            </div>
        </div>

        {{-- Primary Author KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <x-dashboard.stat-card
                :title="__('Total Konten Saya')"
                :value="$combinedStats['total']"
                :subtitle="__(':activities kegiatan · :beritas berita', ['activities' => $activityStats['total'], 'beritas' => $beritaStats['total']])"
                icon="pencil-square"
                tone="neutral"
            />

            <x-dashboard.stat-card
                :title="__('Konten Draft')"
                :value="$combinedStats['draft']"
                :subtitle="__(':activities kegiatan · :beritas berita', ['activities' => $activityStats['draft'], 'beritas' => $beritaStats['draft']])"
                icon="document-text"
                tone="neutral"
                :href="route('penulis.activities.index', ['status' => 'draft'])"
                :action-label="__('Lihat draft kegiatan')"
            />

            <x-dashboard.stat-card
                :title="__('Menunggu Review')"
                :value="$combinedStats['review']"
                :subtitle="__(':activities kegiatan · :beritas berita', ['activities' => $activityStats['review'], 'beritas' => $beritaStats['review']])"
                icon="inbox-stack"
                tone="amber"
                :href="route('penulis.beritas.index', ['status' => 'review'])"
                :action-label="__('Lihat berita review')"
            />

            <x-dashboard.stat-card
                :title="__('Konten Published')"
                :value="$combinedStats['published']"
                :subtitle="__(':activities kegiatan · :beritas berita', ['activities' => $activityStats['published'], 'beritas' => $beritaStats['published']])"
                icon="check-circle"
                tone="emerald"
                :href="route('penulis.beritas.index', ['status' => 'published'])"
                :action-label="__('Lihat berita terbit')"
            />
        </div>

        {{-- Archived & Period Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-dashboard.stat-card
                :title="__('Konten Archived')"
                :value="$combinedStats['archived']"
                :subtitle="__(':activities kegiatan · :beritas berita', ['activities' => $activityStats['archived'], 'beritas' => $beritaStats['archived']])"
                icon="archive-box"
                tone="sky"
            />

            <x-dashboard.stat-card
                :title="__('Dibuat Hari Ini')"
                :value="$periodStats['today_total']"
                :subtitle="__(':activities kegiatan · :beritas berita', ['activities' => $periodStats['today_activities'], 'beritas' => $periodStats['today_beritas']])"
                icon="calendar"
                tone="amber"
            />

            <x-dashboard.stat-card
                :title="__('Dibuat Bulan Ini')"
                :value="$periodStats['month_total']"
                :subtitle="__(':activities kegiatan · :beritas berita', ['activities' => $periodStats['month_activities'], 'beritas' => $periodStats['month_beritas']])"
                icon="calendar-days"
                tone="emerald"
            />
        </div>

        {{-- Own Content Status Breakdowns --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-dashboard.status-breakdown
                :title="__('Kegiatan Saya per Status')"
                :subtitle="__('Statistik khusus kegiatan yang Anda buat')"
                :total="$activityStats['total']"
                :items="[
                    ['label' => __('Draft'), 'count' => $activityStats['draft'], 'tone' => 'neutral', 'href' => route('penulis.activities.index', ['status' => 'draft'])],
                    ['label' => __('Review'), 'count' => $activityStats['review'], 'tone' => 'amber', 'href' => route('penulis.activities.index', ['status' => 'review'])],
                    ['label' => __('Published'), 'count' => $activityStats['published'], 'tone' => 'emerald', 'href' => route('penulis.activities.index', ['status' => 'published'])],
                    ['label' => __('Archived'), 'count' => $activityStats['archived'], 'tone' => 'sky', 'href' => route('penulis.activities.index', ['status' => 'archived'])],
                ]"
                :href="route('penulis.activities.index')"
                :href-label="__('Kelola kegiatan saya')"
            />

            <x-dashboard.status-breakdown
                :title="__('Berita Saya per Status')"
                :subtitle="__('Statistik khusus berita yang Anda tulis')"
                :total="$beritaStats['total']"
                :items="[
                    ['label' => __('Draft'), 'count' => $beritaStats['draft'], 'tone' => 'neutral', 'href' => route('penulis.beritas.index', ['status' => 'draft'])],
                    ['label' => __('Review'), 'count' => $beritaStats['review'], 'tone' => 'amber', 'href' => route('penulis.beritas.index', ['status' => 'review'])],
                    ['label' => __('Published'), 'count' => $beritaStats['published'], 'tone' => 'emerald', 'href' => route('penulis.beritas.index', ['status' => 'published'])],
                    ['label' => __('Archived'), 'count' => $beritaStats['archived'], 'tone' => 'sky', 'href' => route('penulis.beritas.index', ['status' => 'archived'])],
                ]"
                :href="route('penulis.beritas.index')"
                :href-label="__('Kelola berita saya')"
            />
        </div>

        {{-- Author Recent Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-dashboard.content-list
                :title="__('Kegiatan Terbaru Saya')"
                :subtitle="__('5 kegiatan terakhir yang Anda buat atau perbarui')"
                :items="$recentActivities"
                :empty-text="__('Anda belum memiliki kegiatan. Mulai buat kegiatan pertama Anda.')"
                :view-all-href="route('penulis.activities.index')"
                :view-all-label="__('Semua kegiatan saya')"
            />

            <x-dashboard.content-list
                :title="__('Berita Terbaru Saya')"
                :subtitle="__('5 berita terakhir yang Anda tulis atau perbarui')"
                :items="$recentBeritas"
                :empty-text="__('Anda belum memiliki berita. Mulai tulis berita pertama Anda.')"
                :view-all-href="route('penulis.beritas.index')"
                :view-all-label="__('Semua berita saya')"
            />
        </div>
    </div>
</x-layouts::app>
