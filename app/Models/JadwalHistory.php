<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalHistory extends Model
{
    protected $table = 'jadwal_history';

   protected $fillable = [
    'pegawai_id', 'nip', 'nama', 'jabatan', 'status', 
    'info_utama', 'mulai_tgl', 'sampai_tgl', 'mulai_kerja', 'tgl_kejadian'
];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}