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
        Schema::create('arsip_surats', function (Blueprint $table) {
            $table->id();
            // Kolom pembeda: 'masuk' atau 'keluar'
            $table->enum('jenis', ['masuk', 'keluar']); 
            
            $table->date('tanggal_surat');
            $table->string('nomor_surat');
            
            // Nama pengirim (untuk surat masuk) atau Nama tujuan (untuk surat keluar)
            $table->string('pengirim_penerima'); 
            
            $table->text('perihal');
            
            // Bidang yang menangani (Sekretariat, E-Gov, dll)
            $table->string('bidang'); 
            
            // Menyimpan nama file yang diupload ke public/surat
            $table->string('file_surat')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_surats');
    }
};