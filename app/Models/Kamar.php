<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kamar extends Model
{
    use HasFactory;
    protected $table = 'kamar';
    protected $fillable = [
        'id',
        'nama_kamar',
        'deskripsi',
    ];

    /**
     * Get the phone associated with the user.
     */
    public function taruni(): HasOne
    {
        return $this->hasOne(Taruni::class);
    }
}
