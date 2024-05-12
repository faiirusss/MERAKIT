<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->cascadeOnDelete();
            $table->string('sku');
            $table->foreignId('pengrajin_id')->constrained('pengrajins')->cascadeOnDelete();
            $table->string('warna');
            // $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->string('kondisi');
            $table->string('deskripsi');
            // $table->string('harga');
            $table->integer('stok');
            $table->string('status');
            $table->date('tanggal_masuk');
            $table->string('foto');
            $table->timestamps();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};