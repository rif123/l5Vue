<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TransaksiLayanan extends Model
{
    //
    protected $table = 'transaksi_layanan';

    protected $fillable = ['user_id','transaksi_kamar_id','layanan_id','jumlah','total'];

    protected $appends = ['total_format'];

    public function transaksikamar(){
    	return $this->hasOne('App\Model\TransaksiKamar','id','transaksi_kamar_id');
    }

    public function layanan(){
    	return $this->hasOne('App\Model\Layanan','id','layanan_id');
    }

    public function getTotalFormatAttribute($value){
    	return 'Rp. '.number_format($this->attributes['total'],2);
    }

    public function user(){
        return $this->hasOne('App\Model\User','id','user_id');
    }
}
