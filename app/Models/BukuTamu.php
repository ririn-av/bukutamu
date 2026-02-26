<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    use HasFactory;

    protected $table = 'buku_tamu';

    protected $fillable = [
        'nama',
        'pekerjaan',
        'instansi_asal',
        'bidang_tujuan',
        'keperluan',
        'foto',
        'berkas', 
    ];

    // Event yang dijalankan saat model di-boot
    protected static function boot()
    {
        parent::boot();

        // Event sebelum data dihapus
        static::deleting(function ($bukuTamu) {
            // Hapus file foto jika ada
            if ($bukuTamu->foto) {
                $fotoPath = public_path('fototamu/' . $bukuTamu->foto);
                if (file_exists($fotoPath)) {
                    unlink($fotoPath);
                }
            }
            
            // Hapus file berkas jika ada
            if ($bukuTamu->berkas) {
                $berkasPath = public_path('berkas/' . $bukuTamu->berkas);
                if (file_exists($berkasPath)) {
                    unlink($berkasPath);
                }
            }
        });
    }
}