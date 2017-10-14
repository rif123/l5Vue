<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class userRole extends Model
{
    //
    protected $table = 'user_roles';
    protected $fillable = [
        'role_name','keterangan'
    ];

    public function user(){
    	return $this->belongsTo('App\Model\User','role_id','id');
    }
}
