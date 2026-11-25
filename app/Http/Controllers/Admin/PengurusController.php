<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Pengurus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PengurusController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $divisiId = $request->query('divisi_id');

        $penguruses = Pengurus::query()
            ->with('divisi')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%")
                        ->orWhere('jabatan', 'like', "%{$search}%");
                });
            })
            ->when($divisiId, fn ($query) => $query->where('divisi_id', $divisiId))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        $divisis = Divisi::query()->orderBy('nama')->get();

        return view('admin.pengurus.index', compact('penguruses', 'divisis', 'search', 'divisiId'));
    }

    public function create(): View
    {
        $divisis = Divisi::query()->where('is_active', true)->orderBy('nama')->get();

        return view('admin.pengurus.create', compact('divisis'));
    }

    protected function routePrefix(Request $request): string
    {
        return $request->user()?->role === 'staff' ? 'staff' : 'admin';
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'nim' => ['nullable', 'string', 'max:30', 'unique:pengurus,nim'],
            'jabatan' => ['required', 'string', 'max:100'],
            'divisi_id' => ['nullable', 'integer', 'exists:divisis,id'],
            'angkatan' => ['nullable', 'string', 'max:20'],
            'is_active' => ['required', 'boolean'],
        ]);

        Pengurus::create($validated);

        return redirect()->route($this->routePrefix($request).'.pengurus.index')->with('status', 'Data pengurus berhasil ditambahkan.');
    }

    public function edit(Pengurus $pengurus): View
    {
        $divisis = Divisi::query()->orderBy('nama')->get();

        return view('admin.pengurus.edit', compact('pengurus', 'divisis'));
    }

    public function update(Request $request, Pengurus $pengurus): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'nim' => ['nullable', 'string', 'max:30', Rule::unique('pengurus', 'nim')->ignore($pengurus->id)],
            'jabatan' => ['required', 'string', 'max:100'],
            'divisi_id' => ['nullable', 'integer', 'exists:divisis,id'],
            'angkatan' => ['nullable', 'string', 'max:20'],
            'is_active' => ['required', 'boolean'],
        ]);

        $pengurus->update($validated);

        return redirect()->route($this->routePrefix($request).'.pengurus.index')->with('status', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(Request $request, Pengurus $pengurus): RedirectResponse
    {
        $pengurus->delete();

        return redirect()->route($this->routePrefix($request).'.pengurus.index')->with('status', 'Data pengurus berhasil dihapus.');
    }

    public function toggleActive(Pengurus $pengurus): RedirectResponse
    {
        $pengurus->update(['is_active' => ! $pengurus->is_active]);

        return back()->with('status', $pengurus->is_active ? 'Pengurus berhasil diaktifkan.' : 'Pengurus berhasil dinonaktifkan.');
    }
}
