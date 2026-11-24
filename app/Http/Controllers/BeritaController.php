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
     * Display a single published news entry.
     */
    public function show(Berita $berita): View
    {
        abort_unless($berita->is_published, 404);

        $lainnya = Berita::query()
            ->published()
            ->whereKeyNot($berita->getKey())
            ->latestPublished()
            ->take(3)
            ->get();

        return view('berita.show', [
            'berita' => $berita,
            'lainnya' => $lainnya,
        ]);
    }
}
