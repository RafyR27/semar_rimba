<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\View\View;

class BeritaController extends Controller
{
    /**
     * Display a listing of published news for public visitors.
     */
    public function index(): View
    {
        $beritas = Berita::query()
            ->published()
            ->latestPublished()
            ->paginate(9);

        return view('berita.index', [
            'beritas' => $beritas,
        ]);
    }

    /**
     * Display a single published news entry or authorized preview.
     */
    public function show(Berita $berita): View
    {
        $status = $berita->status ?? ($berita->is_published ? 'published' : 'draft');
        $user = auth()->user();

        $canView = match (true) {
            $status === 'published' || $berita->is_published => true,
            $user === null => false,
            in_array($user->role, ['admin', 'staff'], true) => in_array($status, ['review', 'archived'], true),
            $user->role === 'penulis' => $berita->user_id === $user->id && in_array($status, ['draft', 'review', 'archived'], true),
            default => false,
        };

        abort_unless($canView, 404);

        $lainnya = Berita::query()
            ->published()
            ->whereKeyNot($berita->getKey())
            ->latestPublished()
            ->take(3)
            ->get();

        return view('berita.show', [
            'berita' => $berita,
            'beritaStatus' => $status,
            'lainnya' => $lainnya,
        ]);
    }
}
