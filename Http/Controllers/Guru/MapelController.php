<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Auth::user()->mapels()->withCount(['nilais' => function($q) {
            $q->where('guru_id', Auth::id());
        }])->get();

        return view('guru.mapels.index', compact('mapels'));
    }
}
