<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::withCount('gurus')->latest()->paginate(10);
        return view('admin.mapels.index', compact('mapels'));
    }

    public function store(Request $request)
    {
        // Konversi nama mapel ke lowercase untuk pengecekan unique
        $request->merge([
            'nama_mapel' => ucwords(strtolower($request->nama_mapel))
        ]);

        $validated = $request->validate([
            'nama_mapel' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\Mapel::whereRaw('LOWER(nama_mapel) = ?', [strtolower($value)])->exists();
                    if ($exists) {
                        $fail('Mata pelajaran dengan nama ini sudah ada.');
                    }
                },
            ],
            'durasi' => 'required|integer|min:1|max:8',
        ]);

        Mapel::create($validated);

        return redirect()->route('admin.mapels.index')->with('success', 'Mapel berhasil ditambahkan');
    }

    public function update(Request $request, Mapel $mapel)
    {
        // Konversi nama mapel ke lowercase untuk pengecekan unique
        $request->merge([
            'nama_mapel' => ucwords(strtolower($request->nama_mapel))
        ]);

        $validated = $request->validate([
            'nama_mapel' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($mapel) {
                    $exists = \App\Models\Mapel::whereRaw('LOWER(nama_mapel) = ?', [strtolower($value)])
                        ->where('id', '!=', $mapel->id)
                        ->exists();
                    if ($exists) {
                        $fail('Mata pelajaran dengan nama ini sudah ada.');
                    }
                },
            ],
            'durasi' => 'required|integer|min:1|max:8',
        ]);

        $mapel->update($validated);

        return redirect()->route('admin.mapels.index')->with('success', 'Mapel berhasil diupdate');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return redirect()->route('admin.mapels.index')->with('success', 'Mapel berhasil dihapus');
    }
}
