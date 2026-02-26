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
    Schema::create('jadwal_history', function (Blueprint $table) {
        $table->id();
        // Foreign Key ke tabel pegawai (Wajib ada)
        $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
        
        // Tambahan NIP & Jabatan (Snapshot dari tabel pegawai)
        $table->string('nip')->nullable(); 
        $table->string('nama'); 
        $table->string('jabatan'); 
        
        // Kolom yang SAMA PERSIS dengan jadwal_pimpinan
        $table->string('status');
        $table->string('info_utama')->nullable(); 
        $table->date('mulai_tgl')->nullable();
        $table->date('sampai_tgl')->nullable();
        $table->date('mulai_kerja')->nullable();
        
        // Tanggal record ini dibuat
        $table->date('tgl_kejadian'); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_history');
    }
};
