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
        'pengrajin_id',
        'kategori_id',
        'warna',
        'kondisi',
        'deskripsi',
        'harga',
        'stok',
        'tanggal_masuk',
        'status',
        'foto'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function pengrajin(): BelongsTo
    {
        return $this->belongsTo(Pengrajin::class);
    }
}
