<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    /**
     * Display a single activity or authorized preview.
     */
    public function show(Activity $activity): View
    {
        $status = $activity->status ?? ($activity->is_active ? 'published' : 'draft');
        $user = auth()->user();

        $canView = match (true) {
            $status === 'published' || $activity->is_active => true,
            $user === null => false,
            in_array($user->role, ['admin', 'staff'], true) => in_array($status, ['review', 'archived'], true),
            $user->role === 'penulis' => $activity->user_id === $user->id && in_array($status, ['draft', 'review', 'archived'], true),
            default => false,
        };

        abort_unless($canView, 404);

        return view('kegiatan.show', [
            'activity' => $activity,
            'activityStatus' => $status,
        ]);
    }
}
