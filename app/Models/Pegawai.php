<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Sudah benar

class Pegawai extends Model
{
    use HasFactory, SoftDeletes; // <--- Tambahkan SoftDeletes di sini agar aktif

    // Nama tabel di database
    protected $table = 'pegawai';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'nama',
        'jabatan',
        'nip',
    ];

    /**
     * Relasi ke tabel JadwalPimpinan
     * Satu pegawai bisa memiliki banyak riwayat jadwal (One to Many)
     */
    public function jadwal()
    {
        return $this->hasMany(JadwalPimpinan::class, 'pegawai_id', 'id');
    }

    /**
     * Mendapatkan status terbaru pegawai
     */
    public function statusTerbaru()
    {
        return $this->hasOne(JadwalPimpinan::class, 'pegawai_id', 'id')->latestOfMany();
    }
}