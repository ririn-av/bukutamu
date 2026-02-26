<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPimpinan extends Model
{
    use HasFactory;

    // Nama tabel sesuai database Anda
    protected $table = 'jadwal_pimpinan';

    protected $fillable = [
        'pegawai_id', // Foreign key ke tabel pegawai
        'jabatan', 
        'nama', 
        'status', 
        'info_utama', 
        'mulai_tgl', 
        'sampai_tgl', 
       
    ];

    /**
     * Relasi balik ke Pegawai (Many to One)
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }
}