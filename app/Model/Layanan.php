<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    //
    protected $table = 'layanan';
    protected $fillable = ['nama_layanan','layanan_kategori_id','satuan','harga'];
    protected $appends = ['harga_format'];

    public function layanankategori(){
    	return $this->hasOne('App\Model\layananKategori','id','layanan_kategori_id');
    }

    public function getHargaFormatAttribute($value){
    	return 'Rp. '.number_format($this->attributes['harga'],2);
    }
}
