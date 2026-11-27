<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DivisiController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $divisis = Divisi::query()
            ->withCount('pengurus')
            ->when($search !== '', fn ($query) => $query->where('nama', 'like', "%{$search}%"))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.divisi.index', compact('divisis', 'search'));
    }

    public function create(): View
    {
        return view('admin.divisi.create');
    }

    protected function routePrefix(Request $request): string
    {
        return $request->user()?->role === 'staff' ? 'staff' : 'admin';
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:divisis,nama'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['required', 'boolean'],
        ]);

        Divisi::create($validated);

        return redirect()->route($this->routePrefix($request).'.divisi.index')->with('status', 'Divisi berhasil ditambahkan.');
    }

    public function edit(Divisi $divisi): View
    {
        return view('admin.divisi.edit', compact('divisi'));
    }

    public function update(Request $request, Divisi $divisi): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:divisis,nama,'.$divisi->id],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['required', 'boolean'],
        ]);

        $divisi->update($validated);

        return redirect()->route($this->routePrefix($request).'.divisi.index')->with('status', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Request $request, Divisi $divisi): RedirectResponse
    {
        $divisi->delete();

        return redirect()->route($this->routePrefix($request).'.divisi.index')->with('status', 'Divisi berhasil dihapus. Data pengurus tetap tersimpan, tetapi tidak lagi terhubung ke divisi tersebut.');
    }

    public function toggleActive(Divisi $divisi): RedirectResponse
    {
        $divisi->update(['is_active' => ! $divisi->is_active]);

        return back()->with('status', $divisi->is_active ? 'Divisi berhasil diaktifkan.' : 'Divisi berhasil dinonaktifkan.');
    }
}
