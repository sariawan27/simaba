<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengajuan extends Model
{
    use HasFactory;
    protected $table = 'pengajuan';
    protected $fillable = [
        'id',
        'user_id',
        'kd_pengajuan',
        'status',
        'assign_at',
        'assign_by'
    ];

    /**
     * Get the detailPengajuan associated with the pengajuan.
     */
    public function detailPengajuan(): HasMany
    {
        return $this->hasMany(DetailPengajuan::class);
    }

    /**
     * Get the detailPengajuan associated with the pengajuan.
     */
    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class);
    }
}
