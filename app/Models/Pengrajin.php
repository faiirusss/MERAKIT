<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengrajin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function barangmasuk(): HasMany
    {
        return $this->hasMany(BarangMasuk::class);
    }
}
