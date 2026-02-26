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
    Schema::table('buku_tamu', function (Blueprint $table) {
        // Menambah kolom bidang_tujuan setelah instansi_asal
        $table->string('bidang_tujuan')->nullable()->after('instansi_asal');
    });
}

public function down(): void
{
    Schema::table('buku_tamu', function (Blueprint $table) {
        $table->dropColumn('bidang_tujuan');
    });
}

   
};
