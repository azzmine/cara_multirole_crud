<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'gender',
        'address',
        'birth_place',
        'birth_date',
        'phone',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    /**
     * Relationship with Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    /**
     * Check if user is guru
     */
    public function isGuru()
    {
        return $this->role->name === 'guru';
    }

    /**
     * Check if user is siswa
     */
    public function isSiswa()
    {
        return $this->role->name === 'siswa';
    }

    /**
     * Relationship: Guru mengajar banyak Mapel (many-to-many)
     */
    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'user_id', 'mapel_id')
                    ->withTimestamps();
    }
}
