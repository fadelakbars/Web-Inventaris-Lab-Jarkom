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
        Schema::disableForeignKeyConstraints();

        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang', 150);
            $table->string('kode_barang', 100)->unique();
            $table->foreignId('kategori_id')->constrained('kategori_barangs');
            $table->integer('jumlah');
            $table->string('satuan', 50);
            $table->enum('kondisi', ["baik","rusak","hilang"]);
            $table->string('lokasi', 100);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
