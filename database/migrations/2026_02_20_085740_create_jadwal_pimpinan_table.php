<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_pimpinan', function (Blueprint $table) {
            $table->id();
            // Foreign Key yang terhubung ke tabel pegawai
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            
            $table->string('nama'); // Nama disimpan ulang untuk kemudahan display cepat
            $table->string('jabatan'); 
            $table->enum('status', ['TERSEDIA', 'SAKIT', 'DINAS LUAR', 'CUTI'])->default('TERSEDIA');
            $table->string('info_utama')->nullable(); // Lokasi rapat atau jam kerja
            
            // Kolom pendukung status Dinas Luar / Cuti
            $table->date('mulai_tgl')->nullable();
            $table->date('sampai_tgl')->nullable();
         
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pimpinan');
    }
};