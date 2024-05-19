<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Taruni extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'taruni';
    protected $fillable = [
        'id',
        'user_id',
        'kamar_id',
        'nim',
        'angkatan'
    ];

    public function kamar(): HasMany
    {
        return $this->hasMany(Kamar::class);
    }
}
