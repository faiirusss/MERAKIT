<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'sku',
        'pengrajin',
        'kategori_id',
        'warna',
        'kondisi',
        'deskripsi',
        'harga',
        'stok',
        'tanggal_masuk',
        'status',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
