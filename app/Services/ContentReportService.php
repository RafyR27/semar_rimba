<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;

class ContentReportService
{
    /**
     * Status options permitted for the given user role.
     *
     * @return list<string>
     */
    public function visibleStatusesFor(User $user): array
    {
        return $user->role === 'penulis'
            ? ['draft', 'review', 'published', 'archived']
            : ['review', 'published', 'archived'];
    }

    /**
     * Fetch normalized report rows matching the user's authorization scope and filters.
     *
     * @param  array{start_date: string|null, end_date: string|null, type: string, status: string}  $filters
     * @return Collection<int, array{
     *     id: int,
     *     type_key: string,
     *     type_label: string,
     *     title: string,
     *     category: string,
     *     location: string,
     *     author: string,
     *     status: string,
     *     date_raw: string,
     *     date_formatted: string,
     *     public_url: string
     * }>
     */
    public function buildRows(User $user, array $filters): Collection
    {
        /** @var list<array{id: int, type_key: string, type_label: string, title: string, category: string, location: string, author: string, status: string, date_raw: string, date_formatted: string, public_url: string}> $merged */
        $merged = [];

        if (in_array($filters['type'], ['all', 'activity'], true)) {
            $merged = array_merge($merged, $this->queryActivities($user, $filters));
        }

        if (in_array($filters['type'], ['all', 'berita'], true)) {
            $merged = array_merge($merged, $this->queryBeritas($user, $filters));
        }

        return collect($merged)
            ->sortByDesc(fn (array $row): string => $row['date_raw'].'-'.str_pad((string) $row['id'], 8, '0', STR_PAD_LEFT))
            ->values();
    }

    /**
     * Compute aggregate summary metrics for the given report rows.
     *
     * @param  Collection<int, array{
     *     id: int,
     *     type_key: string,
     *     type_label: string,
     *     title: string,
     *     category: string,
     *     location: string,
     *     author: string,
     *     status: string,
     *     date_raw: string,
     *     date_formatted: string,
     *     public_url: string
     * }>  $rows
     * @return array{total: int, activities: int, beritas: int, by_status: array<string, int>}
     */
    public function summarize(Collection $rows, User $user): array
    {
        $byStatus = [];
        foreach ($this->visibleStatusesFor($user) as $status) {
            $byStatus[$status] = $rows->where('status', $status)->count();
        }

        return [
            'total' => $rows->count(),
            'activities' => $rows->where('type_key', 'activity')->count(),
            'beritas' => $rows->where('type_key', 'berita')->count(),
            'by_status' => $byStatus,
        ];
    }

    /**
     * Export the filtered report rows into an XLSX file and return the temporary path.
     *
     * @param  Collection<int, array{
     *     id: int,
     *     type_key: string,
     *     type_label: string,
     *     title: string,
     *     category: string,
     *     location: string,
     *     author: string,
     *     status: string,
     *     date_raw: string,
     *     date_formatted: string,
     *     public_url: string
     * }>  $rows
     * @param  array{start_date: string|null, end_date: string|null, type: string, status: string}  $filters
     */
    public function exportXlsx(Collection $rows, array $filters, User $user): string
    {
        $baseTemp = tempnam(sys_get_temp_dir(), 'semar_report_');
        $xlsxPath = ($baseTemp !== false ? $baseTemp : sys_get_temp_dir().'/semar_report_'.uniqid()).'.xlsx';

        if ($baseTemp !== false && file_exists($baseTemp)) {
            @unlink($baseTemp);
        }

        $writer = new Writer;
        $writer->openToFile($xlsxPath);

        $titleStyle = new Style(fontBold: true, fontSize: 13);
        $metaStyle = new Style(fontSize: 10);
        $headerStyle = new Style(
            fontBold: true,
            fontSize: 10,
            fontColor: Color::WHITE,
            backgroundColor: '142E24',
        );
        $cellStyle = new Style(fontSize: 10);

        $periodLabel = match (true) {
            $filters['start_date'] !== null && $filters['end_date'] !== null => $filters['start_date'].' s/d '.$filters['end_date'],
            $filters['start_date'] !== null => 'Mulai '.$filters['start_date'],
            $filters['end_date'] !== null => 'Sampai '.$filters['end_date'],
            default => 'Semua Periode',
        };

        $typeLabel = match ($filters['type']) {
            'activity' => 'Kegiatan',
            'berita' => 'Berita',
            default => 'Semua (Kegiatan & Berita)',
        };

        $statusLabel = $filters['status'] === 'all' ? 'Semua Status' : ucfirst($filters['status']);

        $writer->addRow(Row::fromValuesWithStyle(['LAPORAN KONTEN CMS SEMAR RIMBA'], $titleStyle));
        $writer->addRow(Row::fromValuesWithStyle(['Diekspor Oleh', $user->name.' ('.ucfirst($user->role).')'], $metaStyle));
        $writer->addRow(Row::fromValuesWithStyle(['Periode', $periodLabel], $metaStyle));
        $writer->addRow(Row::fromValuesWithStyle(['Jenis Konten', $typeLabel], $metaStyle));
        $writer->addRow(Row::fromValuesWithStyle(['Status', $statusLabel], $metaStyle));
        $writer->addRow(Row::fromValuesWithStyle(['Total Data', $rows->count()], $metaStyle));
        $writer->addRow(Row::fromValues([]));

        $writer->addRow(Row::fromValuesWithStyle([
            'No',
            'Jenis Konten',
            'Judul',
            'Kategori',
            'Lokasi',
            'Penulis',
            'Status',
            'Tanggal',
            'Tautan',
        ], $headerStyle));

        $index = 1;
        foreach ($rows as $row) {
            $writer->addRow(Row::fromValuesWithStyle([
                $index++,
                $row['type_label'],
                $row['title'],
                $row['category'],
                $row['location'],
                $row['author'],
                ucfirst($row['status']),
                $row['date_formatted'],
                $row['public_url'],
            ], $cellStyle));
        }

        $writer->close();

        return $xlsxPath;
    }

    /**
     * Query activities scoped to role and filters.
     *
     * @param  array{start_date: string|null, end_date: string|null, type: string, status: string}  $filters
     * @return list<array{
     *     id: int,
     *     type_key: string,
     *     type_label: string,
     *     title: string,
     *     category: string,
     *     location: string,
     *     author: string,
     *     status: string,
     *     date_raw: string,
     *     date_formatted: string,
     *     public_url: string
     * }>
     */
    protected function queryActivities(User $user, array $filters): array
    {
        $query = Activity::query()->with('user:id,name');

        if ($user->role === 'penulis') {
            $query->where('user_id', $user->getKey());
        } else {
            $query->whereIn('status', $this->visibleStatusesFor($user));
        }

        if ($filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        $this->applyDateRange($query, 'event_date', $filters['start_date'], $filters['end_date']);

        return array_values($query
            ->orderByDesc('event_date')
            ->orderByDesc('id')
            ->get()
            ->map(function (Activity $activity): array {
                $effectiveDate = $activity->event_date ?? $activity->created_at;

                return [
                    'id' => $activity->id,
                    'type_key' => 'activity',
                    'type_label' => 'Kegiatan',
                    'title' => $activity->title,
                    'category' => $activity->category,
                    'location' => $activity->location ?: '-',
                    'author' => $activity->user->name ?? 'Sistem',
                    'status' => $activity->status,
                    'date_raw' => $effectiveDate?->format('Y-m-d') ?? '',
                    'date_formatted' => $effectiveDate?->format('d M Y') ?? '-',
                    'public_url' => route('kegiatan.show', $activity->slug),
                ];
            })
            ->all());
    }

    /**
     * Query news items scoped to role and filters.
     *
     * @param  array{start_date: string|null, end_date: string|null, type: string, status: string}  $filters
     * @return list<array{
     *     id: int,
     *     type_key: string,
     *     type_label: string,
     *     title: string,
     *     category: string,
     *     location: string,
     *     author: string,
     *     status: string,
     *     date_raw: string,
     *     date_formatted: string,
     *     public_url: string
     * }>
     */
    protected function queryBeritas(User $user, array $filters): array
    {
        $query = Berita::query()->with('user:id,name');

        if ($user->role === 'penulis') {
            $query->where('user_id', $user->getKey());
        } else {
            $query->whereIn('status', $this->visibleStatusesFor($user));
        }

        if ($filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        $this->applyDateRange($query, 'tanggal_terbit', $filters['start_date'], $filters['end_date']);

        return array_values($query
            ->orderByDesc('tanggal_terbit')
            ->orderByDesc('id')
            ->get()
            ->map(function (Berita $berita): array {
                $effectiveDate = $berita->publicationDate();

                return [
                    'id' => $berita->id,
                    'type_key' => 'berita',
                    'type_label' => 'Berita',
                    'title' => $berita->judul,
                    'category' => 'Berita',
                    'location' => '-',
                    'author' => $berita->user->name ?? 'Sistem',
                    'status' => $berita->status,
                    'date_raw' => $effectiveDate?->format('Y-m-d') ?? '',
                    'date_formatted' => $effectiveDate?->format('d M Y') ?? '-',
                    'public_url' => route('berita.show', $berita->slug),
                ];
            })
            ->all());
    }

    /**
     * Apply inclusive date boundaries to an Eloquent query expression.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  Builder<TModel>  $query
     * @param  'event_date'|'tanggal_terbit'  $dateColumn
     */
    protected function applyDateRange(Builder $query, string $dateColumn, ?string $startDate, ?string $endDate): void
    {
        if ($dateColumn === 'event_date') {
            if ($startDate !== null) {
                $query->whereRaw('COALESCE(event_date, DATE(created_at)) >= ?', [$startDate]);
            }

            if ($endDate !== null) {
                $query->whereRaw('COALESCE(event_date, DATE(created_at)) <= ?', [$endDate]);
            }

            return;
        }

        if ($startDate !== null) {
            $query->whereRaw('COALESCE(tanggal_terbit, DATE(created_at)) >= ?', [$startDate]);
        }

        if ($endDate !== null) {
            $query->whereRaw('COALESCE(tanggal_terbit, DATE(created_at)) <= ?', [$endDate]);
        }
    }
}
