<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\TransaksiKamar;
use App\Model\TransaksiLayanan;

use DB;

class LaporanCtrl extends Controller
{
    //
    public function laporan($type)
    {
    	$this->data['title'] = 'Laporan Transaksi '.$type;
    	$this->data['deskripsi_title'] = '';
    	return view('backend.laporan.kamar',$this->data);
    }

    public function getLaporan(Request $request,$type){
    	 DB::enableQueryLog();
    	$this->validate($request,[
    			'tgl_awal' => 'required|date|before_or_equal:'.$request->get('tgl_akhir'),
    			'tgl_akhir' => 'required|date|after_or_equal:'.$request->get('tgl_awal'),
    		]);
    	$tgl_awal = date('Y-m-d',strtotime($request->get('tgl_awal')));
    	$tgl_akhir = date('Y-m-d',strtotime($request->get('tgl_akhir')));

    	if($type == 'kamar'){
	    	$data['laporan'] = TransaksiKamar::whereBetween('created_at',[$tgl_awal,$tgl_akhir])->where('status',0)->get();
	/*    	                echo "<pre>".print_r(
	            DB::getQueryLog()
	        ,true)."</pre>";*/
	    	$data['total'] = 'Rp. '.number_format($data['laporan']->sum('total_biaya'),2);
    	} else {
    		$data['laporan'] = TransaksiLayanan::whereHas('transaksikamar')->whereBetween('created_at',[$tgl_awal,$tgl_akhir])->with(['transaksikamar' => function($q) {
    				$q->with('kamar');
    		}])->with('layanan','user')->get();
    		$data['total'] = 'Rp. '.number_format($data['laporan']->sum('total'),2);
    	}
    	return response()->json($data);
    }
}
