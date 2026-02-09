<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $fillable = [
        'nama_mapel',
        'durasi',
    ];

    /**
     * Relationship: Mapel diajar oleh banyak Guru (many-to-many)
     */
    public function gurus()
    {
        return $this->belongsToMany(User::class, 'guru_mapel', 'mapel_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Get durasi in readable format
     */
    public function getDurasiTextAttribute()
    {
        return $this->durasi . ' Jam';
    }

    /**
     * Relationship: Mapel punya banyak Nilai
     */
    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}
