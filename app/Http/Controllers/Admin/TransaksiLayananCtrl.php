<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\TransaksiKamar;
use App\Model\TransaksiLayanan;
use App\Model\Layanan;
use App\Model\layananKategori;
use App\Model\Kamar;

use Auth;

class TransaksiLayananCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['title'] = 'Room Services';
        $this->data['deskripsi_title'] = 'Pilih kamar yang akan melakukan pemesanan';
        $this->data['guest'] = TransaksiKamar::with('kamar','tamu')->where('status',1)->get();
        return view('backend.layanan.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->data['title'] = 'Pembersihan Kamar';
        $this->data['deskripsi_title'] = 'Administrasi pembersihan kamar';
        return view('backend.layanan.bersih',$this->data);
    }

    public function getKamarKotor()
    {
        $kamar = Kamar::with('typekamar')->where('status',2)->get();
        return response()->json($kamar);
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
        $input = $request->all();
        if($input['layanan']){
            foreach ($input['layanan'] as $key => $value) {
                if($key == 'jumlah'){
                    foreach($value as $layanan_id => $jumlah){
                        if($layanan_id == 0)
                            continue;
                        if(!$jumlah){
                            continue;
                        }
                        $input['layanan_id'] = $layanan_id;
                        $input['jumlah'] = $jumlah;
                        $input['user_id'] = Auth::user()->id;
                        $input['total'] = $jumlah * $input['layanan']['harga'][$layanan_id];

                        $transaksi = TransaksiLayanan::create($input);
                    }
                }
            }
        }

        return response()->json($transaksi);
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
        $this->data['title'] = 'Room Services';
        $this->data['deskripsi_title'] = 'Pilih produk / layanan';
        $this->data['guest'] = TransaksiKamar::with('kamar','tamu')->find($id);
        $this->data['layanan'] = layananKategori::all();
        return view('backend.layanan.edit',$this->data);

    }

    public function getLayanan($id)
    {
        $layanan = Layanan::where('layanan_kategori_id',$id)->get();

        return response()->json($layanan);
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
        $bersihkan = Kamar::find($id)->update(['status' => 0]);

        return response()->json($bersihkan);
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
