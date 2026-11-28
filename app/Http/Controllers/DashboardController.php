<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Gallery;
use App\Models\HeroBanner;
use App\Models\Pengurus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Statuses visible to editorial reviewers (Admin & Staff).
     *
     * @var list<string>
     */
    private const REVIEWABLE_STATUSES = ['review', 'published', 'archived'];

    /**
     * All workflow statuses tracked for content authors (Penulis).
     *
     * @var list<string>
     */
    private const ALL_STATUSES = ['draft', 'review', 'published', 'archived'];

    /**
     * Display the Admin dashboard with user, editorial, and organization metrics.
     */
    public function admin(Request $request): View
    {
        return view('dashboard.admin', [
            'user' => $request->user(),
            'userStats' => $this->userOverview(),
            ...$this->editorialOverview('admin'),
        ]);
    }

    /**
     * Display the Staff dashboard with editorial and organization metrics only.
     */
    public function staff(Request $request): View
    {
        return view('dashboard.staff', [
            'user' => $request->user(),
            ...$this->editorialOverview('staff'),
        ]);
    }

    /**
     * Display the Penulis dashboard scoped strictly to the authenticated author's content.
     */
    public function penulis(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $userId = $user->getKey();

        $activityCounts = $this->statusCounts(Activity::class, self::ALL_STATUSES, $userId);
        $beritaCounts = $this->statusCounts(Berita::class, self::ALL_STATUSES, $userId);

        $combinedCounts = [];
        foreach (self::ALL_STATUSES as $status) {
            $combinedCounts[$status] = $activityCounts[$status] + $beritaCounts[$status];
        }
        $combinedCounts['total'] = $activityCounts['total'] + $beritaCounts['total'];

        $todayActivities = Activity::query()
            ->where('user_id', $userId)
            ->whereDate('created_at', today())
            ->count();
        $todayBeritas = Berita::query()
            ->where('user_id', $userId)
            ->whereDate('created_at', today())
            ->count();

        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $monthActivities = Activity::query()
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();
        $monthBeritas = Berita::query()
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();

        $recentActivities = Activity::query()
            ->where('user_id', $userId)
            ->latest('updated_at')
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(fn (Activity $activity): array => [
                'title' => $activity->title,
                'meta' => $activity->category.($activity->location ? ' · '.$activity->location : ''),
                'status' => $activity->status,
                'date' => $activity->event_date?->format('d M Y') ?? $activity->updated_at?->format('d M Y'),
                'href' => route('penulis.activities.edit', $activity),
            ])
            ->values()
            ->all();

        $recentBeritas = Berita::query()
            ->where('user_id', $userId)
            ->latest('updated_at')
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(fn (Berita $berita): array => [
                'title' => $berita->judul,
                'meta' => $berita->publicationDate()?->format('d M Y') ?? '-',
                'status' => $berita->status,
                'date' => $berita->updated_at?->format('d M Y'),
                'href' => route('penulis.beritas.edit', $berita),
            ])
            ->values()
            ->all();

        return view('dashboard.penulis', [
            'user' => $user,
            'activityStats' => $activityCounts,
            'beritaStats' => $beritaCounts,
            'combinedStats' => $combinedCounts,
            'periodStats' => [
                'today_total' => $todayActivities + $todayBeritas,
                'today_activities' => $todayActivities,
                'today_beritas' => $todayBeritas,
                'month_total' => $monthActivities + $monthBeritas,
                'month_activities' => $monthActivities,
                'month_beritas' => $monthBeritas,
            ],
            'recentActivities' => $recentActivities,
            'recentBeritas' => $recentBeritas,
        ]);
    }

    /**
     * Collect user account metrics for the Admin dashboard.
     *
     * @return array{
     *     total: int,
     *     active: int,
     *     inactive: int,
     *     by_role: array{admin: int, staff: int, penulis: int}
     * }
     */
    protected function userOverview(): array
    {
        $roleRows = User::query()
            ->select('role', DB::raw('COUNT(*) as aggregate'))
            ->groupBy('role')
            ->pluck('aggregate', 'role');

        $byRole = [
            'admin' => (int) ($roleRows['admin'] ?? 0),
            'staff' => (int) ($roleRows['staff'] ?? 0),
            'penulis' => (int) ($roleRows['penulis'] ?? 0),
        ];

        $total = User::query()->count();
        $active = User::query()->where('status', true)->count();

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => max(0, $total - $active),
            'by_role' => $byRole,
        ];
    }

    /**
     * Collect shared editorial and organization metrics for Admin and Staff dashboards.
     *
     * @return array{
     *     activityStats: array<string, int>,
     *     beritaStats: array<string, int>,
     *     reviewQueue: array{total: int, activities: int, beritas: int},
     *     organizationStats: array{
     *         divisi_total: int,
     *         divisi_active: int,
     *         pengurus_total: int,
     *         pengurus_active: int,
     *         gallery_total: int,
     *         gallery_active: int,
     *         banner_total: int,
     *         banner_active: int
     *     },
     *     recentActivities: list<array{title: string, meta: string, status: string, date: string|null, href: string}>,
     *     recentBeritas: list<array{title: string, meta: string, status: string, date: string|null, href: string}>
     * }
     */
    protected function editorialOverview(string $routePrefix): array
    {
        $activityStats = $this->statusCounts(Activity::class, self::REVIEWABLE_STATUSES);
        $beritaStats = $this->statusCounts(Berita::class, self::REVIEWABLE_STATUSES);

        $recentActivities = array_values(Activity::query()
            ->with('user:id,name')
            ->whereIn('status', self::REVIEWABLE_STATUSES)
            ->orderByRaw("CASE WHEN status = 'review' THEN 0 ELSE 1 END")
            ->latest('updated_at')
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(fn (Activity $activity): array => [
                'title' => $activity->title,
                'meta' => ($activity->user->name ?? 'Sistem').' · '.$activity->category,
                'status' => $activity->status,
                'date' => $activity->updated_at?->format('d M Y'),
                'href' => route($routePrefix.'.activities.index', ['status' => $activity->status]),
            ])
            ->all());

        $recentBeritas = array_values(Berita::query()
            ->with('user:id,name')
            ->whereIn('status', self::REVIEWABLE_STATUSES)
            ->orderByRaw("CASE WHEN status = 'review' THEN 0 ELSE 1 END")
            ->latest('updated_at')
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(fn (Berita $berita): array => [
                'title' => $berita->judul,
                'meta' => $berita->user->name ?? 'Sistem',
                'status' => $berita->status,
                'date' => $berita->updated_at?->format('d M Y'),
                'href' => route($routePrefix.'.beritas.index', ['status' => $berita->status]),
            ])
            ->all());

        return [
            'activityStats' => $activityStats,
            'beritaStats' => $beritaStats,
            'reviewQueue' => [
                'total' => $activityStats['review'] + $beritaStats['review'],
                'activities' => $activityStats['review'],
                'beritas' => $beritaStats['review'],
            ],
            'organizationStats' => [
                'divisi_total' => Divisi::query()->count(),
                'divisi_active' => Divisi::query()->where('is_active', true)->count(),
                'pengurus_total' => Pengurus::query()->count(),
                'pengurus_active' => Pengurus::query()->where('is_active', true)->count(),
                'gallery_total' => Gallery::query()->count(),
                'gallery_active' => Gallery::query()->where('is_active', true)->count(),
                'banner_total' => HeroBanner::query()->count(),
                'banner_active' => HeroBanner::query()->where('is_active', true)->count(),
            ],
            'recentActivities' => $recentActivities,
            'recentBeritas' => $recentBeritas,
        ];
    }

    /**
     * Aggregate row counts grouped by workflow status for a given Eloquent model.
     *
     * @param  class-string<Model>  $modelClass
     * @param  list<string>  $statuses
     * @return array<string, int>
     */
    protected function statusCounts(string $modelClass, array $statuses, ?int $userId = null): array
    {
        /** @var Builder<Model> $query */
        $query = $modelClass::query()
            ->select('status', DB::raw('COUNT(*) as aggregate'))
            ->whereIn('status', $statuses)
            ->when($userId !== null, fn (Builder $builder) => $builder->where('user_id', $userId))
            ->groupBy('status');

        $grouped = $query->pluck('aggregate', 'status');

        $counts = [];
        $total = 0;

        foreach ($statuses as $status) {
            $value = (int) ($grouped[$status] ?? 0);
            $counts[$status] = $value;
            $total += $value;
        }

        $counts['total'] = $total;

        return $counts;
    }
}
