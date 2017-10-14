<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Kamar;
use App\Model\Tamu;
use App\Model\TransaksiKamar;
use App\Model\TransaksiLayanan;
use Auth;

class CheckinCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['title'] = 'Check In';
        $this->data['deskripsi_title'] = 'Pilih kamar yang tersedia';
        $this->data['kamar'] = Kamar::with('typekamar')->where('status',0)->orderBy('nomor_kamar')->get();
        return view('backend.checkin.index',$this->data);
    }

    public function listCheckin()
    {
        $this->data['title'] = 'Tamu In-House';
        $this->data['deskripsi_title'] = 'Daftar tamu yang sedang menginap';
        $this->data['transaksi'] = TransaksiKamar::with('kamar','tamu')->where('status',1)->get();
        return view('backend.checkin.tamu',$this->data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       $this->validate($request,[
            'tamu_id' => 'integer|min:1',
            'jumlah_dewasa' => 'integer|min:1',
            'jumlah_anak' => 'integer|min:0',
            'invoice_id' => 'required',
            'tgl_checkout' => 'required|date',
            'deposit' => 'required|numeric|min:0'
        ]);

       $input = $request->all();
       $input['user_id'] = Auth::user()->id;
       $input['tgl_checkout'] = $request->get('tgl_checkout').' '.$request->get('waktu_checkout');
       $input['tgl_checkin'] = $request->get('tgl_checkin').' '.$request->get('waktu_checkin');
       $input['status'] = 1;

       $kamar = Kamar::find($input['kamar_id']);

       $jumlah_hari = $this->jumlahhari($input['tgl_checkin'],$input['tgl_checkout']);
       
       $input['total_biaya'] = $kamar->typekamar->harga_malam * $jumlah_hari;


       $transaksi = TransaksiKamar::create($input);
       $update_kamar = $kamar->update(['status' => 1]);

       return response()->json($update_kamar);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $this->data['title'] = 'Check Out';
        $this->data['deskripsi_title'] = 'Pilih kamar yang terpakai';
        $this->data['transaksi'] = TransaksiKamar::with('kamar','tamu')->find($id);
        $collection = Tamu::all();
        $tamu = $collection->mapWithKeys(function ($item) {
            return [$item['id'] => $item['nama_lengkap']];
        });

        $this->data['tamu'] = $tamu->all();
        return view('backend.checkin.show',$this->data);
    }

    public function checkout()
    {
        //
        $this->data['title'] = 'Check Out';
        $this->data['deskripsi_title'] = 'Pilih kamar yang terpakai';
        $this->data['kamar'] = Kamar::where('status',1)->with('transaksi','typekamar')->whereHas('transaksi')->get();
        return view('backend.checkout.index',$this->data);
    }

    public function checkoutedit($id)
    {
        $this->data['title'] = 'Check Out';
        $this->data['deskripsi_title'] = 'Pilih kamar yang terpakai';
        $this->data['transaksi'] = TransaksiKamar::with('kamar','tamu')->find($id);
        $this->data['tgl_checkout'] = date('Y-m-d H:i:s');
        $this->data['jumlah_hari'] = $this->jumlahhari($this->data['transaksi']->tgl_checkin,$this->data['tgl_checkout']);
        $this->data['layanan'] = TransaksiLayanan::where('transaksi_kamar_id',$this->data['transaksi']->id)->get();
        return view('backend.checkout.edit',$this->data);
    }

    public function checkoutprint($id)
    {
        $this->data['transaksi'] = TransaksiKamar::with('kamar','tamu')->find($id);
        $this->data['tgl_checkout'] = date('Y-m-d H:i:s');
        $this->data['jumlah_hari'] = $this->jumlahhari($this->data['transaksi']->tgl_checkin,$this->data['tgl_checkout']);
        $this->data['layanan'] = TransaksiLayanan::where('transaksi_kamar_id',$this->data['transaksi']->kamar->id)->get();
        return view('backend.checkout.invoice',$this->data);
    }

    public function checkoutsave(Request $request)
    {
        $id = $request->get('id');
        $transaksi = TransaksiKamar::find($id);
        $tgl_checkout = date('Y-m-d H:i:s');
        $tgl_checkin = $transaksi->tgl_checkin;
        $selisih = $this->jumlahhari($tgl_checkin,$tgl_checkout);
        $total_biaya = $transaksi->kamar->typekamar->harga_malam * $selisih;
        $transaksi->update(['status' => 0,'tgl_checkout' => $tgl_checkout,'total_biaya' => $total_biaya]);
        $kamar = $transaksi->kamar->update(['status' => 2]);

        return response()->json($kamar);
    }

    private function jumlahhari($checkin,$checkout)
    {
        $checkin = date_create($checkin);
        $checkout = date_create($checkout);
        $interval = date_diff($checkin, $checkout);
       
       return $interval->format('%a');
       
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $this->data['title'] = 'Check In';
        $this->data['deskripsi_title'] = 'Input data tamu';
        $this->data['kamar'] = Kamar::find($id);
        $this->data['nomor_invoice'] = 'INV-'.date('Ymd').'-'.(TransaksiKamar::count('id') + 1);
        $collection = Tamu::all();
        $tamu = $collection->mapWithKeys(function ($item) {
            return [$item['id'] => $item['nama_lengkap']];
        });

        $this->data['tamu'] = $tamu->all();
        return view('backend.checkin.edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
            'tamu_id' => 'integer|min:1',
            'jumlah_dewasa' => 'integer|min:1',
            'jumlah_anak' => 'integer|min:0',
            'invoice_id' => 'required',
            'tgl_checkout' => 'required|date',
            'deposit' => 'required|numeric|min:0'
        ]);

        $transaksi = TransaksiKamar::find($id);

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['tgl_checkout'] = $request->get('tgl_checkout').' '.$request->get('waktu_checkout');
        $input['tgl_checkin'] = $request->get('tgl_checkin').' '.$request->get('waktu_checkin');
        $input['status'] = 1;

        $jumlah_hari = $this->jumlahhari($input['tgl_checkin'],$input['tgl_checkout']);

        $input['total_biaya'] = $transaksi->kamar->typekamar->harga_malam * $jumlah_hari;

        $update_transaksi = $transaksi->update($input);
        $update_kamar = $transaksi->kamar->update(['status' => 1]);

        return response()->json($update_kamar);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
