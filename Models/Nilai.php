<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
        'guru_id',
        'mapel_id',
        'siswa_id',
        'tanggal',
        'keterangan',
        'nilai',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relationship: Nilai dibuat oleh Guru
     */
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    /**
     * Relationship: Nilai untuk Mapel
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    /**
     * Relationship: Nilai untuk Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
