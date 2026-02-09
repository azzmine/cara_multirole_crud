<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Mapel};
use Illuminate\Http\Request;

class GuruMapelController extends Controller
{
    public function index()
    {
        $gurus = User::whereHas('role', function($q) {
            $q->where('name', 'guru');
        })->with('mapels')->get();

        $mapels = Mapel::all();

        return view('admin.guru-mapel.index', compact('gurus', 'mapels'));
    }

    public function assign(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:users,id',
            'mapel_ids' => 'required|array',
            'mapel_ids.*' => 'exists:mapels,id',
        ]);

        $guru = User::findOrFail($validated['guru_id']);
        $guru->mapels()->sync($validated['mapel_ids']); // sync akan replace yang lama

        return redirect()->route('admin.guru-mapel.index')
            ->with('success', 'Mapel berhasil di-assign ke guru');
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mapels,id',
            'is_assigned' => 'required|boolean',
        ]);

        $guru = User::findOrFail($validated['guru_id']);

        if ($validated['is_assigned']) {
            // Attach mapel to guru
            $guru->mapels()->syncWithoutDetaching([$validated['mapel_id']]);
        } else {
            // Detach mapel from guru
            $guru->mapels()->detach($validated['mapel_id']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil diupdate'
        ]);
    }
}
