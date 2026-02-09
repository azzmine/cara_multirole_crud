<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Nilai, Mapel, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Mapel $mapel)
    {
        // Pastikan guru ini mengampu mapel ini
        if (!Auth::user()->mapels->contains($mapel->id)) {
            abort(403, 'Anda tidak mengampu mapel ini');
        }

        $nilais = Nilai::where('guru_id', Auth::id())
            ->where('mapel_id', $mapel->id)
            ->with('siswa')
            ->latest()
            ->paginate(10);

        $siswas = User::whereHas('role', function($q) {
            $q->where('name', 'siswa');
        })->get();

        return view('guru.nilais.index', compact('mapel', 'nilais', 'siswas'));
    }

    public function store(Request $request, Mapel $mapel)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nilai' => 'required|integer|min:0|max:100',
        ]);

        $validated['guru_id'] = Auth::id();
        $validated['mapel_id'] = $mapel->id;

        Nilai::create($validated);

        return redirect()->route('guru.nilais.index', $mapel)
            ->with('success', 'Nilai berhasil ditambahkan');
    }

    public function update(Request $request, Mapel $mapel, Nilai $nilai)
    {
        // Pastikan nilai ini milik guru yang login
        if ($nilai->guru_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nilai' => 'required|integer|min:0|max:100',
        ]);

        $nilai->update($validated);

        return redirect()->route('guru.nilais.index', $mapel)
            ->with('success', 'Nilai berhasil diupdate');
    }

    public function destroy(Mapel $mapel, Nilai $nilai)
    {
        // Pastikan nilai ini milik guru yang login
        if ($nilai->guru_id !== Auth::id()) {
            abort(403);
        }

        $nilai->delete();

        return redirect()->route('guru.nilais.index', $mapel)
            ->with('success', 'Nilai berhasil dihapus');
    }
}
