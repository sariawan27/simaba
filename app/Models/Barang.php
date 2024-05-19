<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'id',
        'deskripsi',
        "nama_barang",
        "description",
        "stok",
        "satuan",
        "max_pengajuan",
        "max_quantity"
    ];
}
