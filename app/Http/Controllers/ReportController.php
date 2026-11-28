<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentReportRequest;
use App\Models\User;
use App\Services\ContentReportService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    /**
     * Display the filterable content report page scoped to the authenticated user's role.
     */
    public function index(ContentReportRequest $request, ContentReportService $reportService): View
    {
        /** @var User $user */
        $user = $request->user();
        $filters = $request->filters();
        $allRows = $reportService->buildRows($user, $filters);
        $summary = $reportService->summarize($allRows, $user);

        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedItems = $allRows->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $rows = (new LengthAwarePaginator(
            $pagedItems,
            $allRows->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url()]
        ))->withQueryString();

        return view('reports.index', [
            'rows' => $rows,
            'summary' => $summary,
            'filters' => $filters,
            'availableStatuses' => $reportService->visibleStatusesFor($user),
            'routePrefix' => $this->routePrefix($user),
        ]);
    }

    /**
     * Export the filtered content report as an XLSX spreadsheet.
     */
    public function export(ContentReportRequest $request, ContentReportService $reportService): BinaryFileResponse
    {
        /** @var User $user */
        $user = $request->user();
        $filters = $request->filters();
        $rows = $reportService->buildRows($user, $filters);

        $xlsxPath = $reportService->exportXlsx($rows, $filters, $user);
        $filename = 'laporan-konten-semar-rimba-'.now()->format('Ymd-His').'.xlsx';

        return response()->download($xlsxPath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Resolve the route name prefix for the authenticated user's role.
     */
    protected function routePrefix(User $user): string
    {
        return match ($user->role) {
            'admin' => 'admin',
            'penulis' => 'penulis',
            default => 'staff',
        };
    }
}
