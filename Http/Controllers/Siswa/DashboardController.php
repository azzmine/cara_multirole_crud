<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $siswaId = Auth::id();

        // Get all nilai for this siswa
        $nilais = Nilai::where('siswa_id', $siswaId)
            ->with(['mapel', 'guru'])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Calculate overall statistics
        $totalNilai = $nilais->count();
        $rataRataKeseluruhan = $totalNilai > 0 ? round($nilais->avg('nilai'), 2) : 0;
        $nilaiTertinggi = $totalNilai > 0 ? $nilais->max('nilai') : 0;
        $nilaiTerendah = $totalNilai > 0 ? $nilais->min('nilai') : 0;

        // Statistics per mapel (gabungan dari semua guru)
        $statistikPerMapel = Nilai::where('siswa_id', $siswaId)
            ->select('mapel_id')
            ->selectRaw('AVG(nilai) as rata_rata')
            ->selectRaw('MAX(nilai) as tertinggi')
            ->selectRaw('MIN(nilai) as terendah')
            ->selectRaw('COUNT(*) as jumlah')
            ->with('mapel')
            ->groupBy('mapel_id')
            ->get()
            ->map(function ($stat) {
                return [
                    'mapel' => $stat->mapel->nama_mapel,
                    'rata_rata' => round($stat->rata_rata, 2),
                    'tertinggi' => $stat->tertinggi,
                    'terendah' => $stat->terendah,
                    'jumlah' => $stat->jumlah,
                    'label' => $this->getLabel($stat->rata_rata),
                    'color' => $this->getColor($stat->rata_rata),
                ];
            });

        // Data for chart
        $chartLabels = $statistikPerMapel->pluck('mapel')->toArray();
        $chartData = $statistikPerMapel->pluck('rata_rata')->toArray();
        $chartColors = $statistikPerMapel->pluck('color')->toArray();

        return view('siswa.dashboard', compact(
            'nilais',
            'totalNilai',
            'rataRataKeseluruhan',
            'nilaiTertinggi',
            'nilaiTerendah',
            'statistikPerMapel',
            'chartLabels',
            'chartData',
            'chartColors'
        ));
    }

    private function getLabel($nilai)
    {
        if ($nilai >= 90) return 'Excellent';
        if ($nilai >= 75) return 'Good';
        if ($nilai >= 60) return 'Average';
        return 'Need Improvement';
    }

    private function getColor($nilai)
    {
        if ($nilai >= 90) return 'rgba(16, 185, 129, 0.8)'; // Green
        if ($nilai >= 75) return 'rgba(59, 130, 246, 0.8)'; // Blue
        if ($nilai >= 60) return 'rgba(245, 158, 11, 0.8)'; // Yellow
        return 'rgba(239, 68, 68, 0.8)'; // Red
    }
}
