<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class layananKategori extends Model
{
    //
    protected $table = 'layanan_kategori';
    protected $fillable = ['nama_layanan_kategori','keterangan'];
}
