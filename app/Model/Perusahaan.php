<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    //
    protected $table = 'perusahaan';
    protected $fillable =['nama_hotel',
        'nama_perusahaan',
        'alamat_jalan',
        'alamat_kabupaten',
        'alamat_provinsi',
        'nomor_telp',
        'nomor_fax',
        'website',
        'email'];
}
