<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengajuan extends Model
{
    use HasFactory;
    protected $table = 'detail_pengajuan';
    protected $fillable = [
        'id',
        'pengajuan_id',
        'barang_id',
        'quantity'
    ];
}
