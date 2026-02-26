<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipSurat extends Model
{
    use HasFactory;


    protected $table = 'arsip_surats';

   
    protected $fillable = [
        'jenis',
        'tanggal_surat',
        'nomor_surat',
        'pengirim_penerima',
        'perihal',
        'bidang',
        'file_surat'
    ];
}