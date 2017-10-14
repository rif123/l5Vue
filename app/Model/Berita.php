<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    //
    protected $table = 'berita';

    protected $fillable = ['user_id','title','isi_berita','status'];

    protected $appends = ['status_text'];

    public function getStatusTextAttribute()
    {
    	if($this->attributes['status'] == 0){
    		return 'BIASA';
    	} 
    	return 'PENTING';
    }

    public function user()
    {
    	return $this->hasOne('App\Model\User','id','user_id');
    }
}
