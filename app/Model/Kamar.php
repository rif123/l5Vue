<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    //
    protected $table = 'kamar';
    protected $fillable = ['nomor_kamar','type_id','max_dewasa','max_anak','status'];

    public function typekamar(){
    	return $this->hasOne('App\Model\kamarType','id','type_id');
    }

    public function transaksi(){
    	return $this->belongsTo('App\Model\TransaksiKamar','id','kamar_id');
    }

}
