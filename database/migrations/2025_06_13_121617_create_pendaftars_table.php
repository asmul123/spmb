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
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pendaftaran', 20);
            $table->string('nisn', 10);
            $table->string('nama', 50);
            $table->string('asal_sekolah', 100);
            $table->string('jalur', 50);
            $table->string('pilihan_1', 100);
            $table->double('skor_pilihan_1');
            $table->string('pilihan_2', 100);
            $table->double('skor_pilihan_2');
            $table->string('pilihan_3', 100);
            $table->double('skor_pilihan_3');
            $table->tinyinteger('pilihan_ke');
            $table->string('pilihan_diterima', 100);
            $table->double('skor_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
