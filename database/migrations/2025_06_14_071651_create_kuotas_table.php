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
        Schema::create('kuotas', function (Blueprint $table) {
            $table->id();
            $table->string('jalur', 50);
            $table->string('program_keahlian', 100);
            $table->tinyinteger('kuota');
            $table->tinyinteger('kuota_pelimpahan');
            $table->char('model_seleksi', 1);
            $table->char('status_pelimpahan', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuotas');
    }
};
