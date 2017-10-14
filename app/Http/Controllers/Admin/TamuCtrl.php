<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Tamu;

class TamuCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['title'] = 'Tamu';
        $this->data['deskripsi_title'] = 'Administrasi tamu hotel';
        return view('backend.tamu',$this->data);
    }

    public function getTamu(Request $request)
    {
        $cari = $request->get('cari');
       /* DB::enableQueryLog();*/
        if($cari){
            $tamu = Tamu::where('nama_depan','LIKE','%'.$cari.'%')
                            ->paginate(5)
                            ->appends($request->only('cari'));
        } else {
            $tamu = Tamu::paginate(5);
        }
         /*       echo "<pre>".print_r(
            DB::getQueryLog()
        ,true)."</pre>";*/
        return response()->json($tamu);
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
        $this->validate($request, [
            'nama_depan' => 'required',
            'tipe_identitas' => 'required',
            'nomor_identitas' =>'required',
            'warga_negara' =>'required',
            'alamat_kabupaten' => 'required',
            'alamat_jalan' => 'required',
            'alamat_provinsi' => 'required',
            'nomor_telp' => 'required',
            'email' => 'email'
        ]);
        $buat = Tamu::create($request->all());

        return response()->json($buat);
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
        $this->validate($request, [
            'nama_depan' => 'required',
            'tipe_identitas' => 'required',
            'nomor_identitas' =>'required',
            'warga_negara' =>'required',
            'alamat_kabupaten' => 'required',
            'alamat_jalan' => 'required',
            'alamat_provinsi' => 'required',
            'nomor_telp' => 'required',
            'email' => 'email'
        ]);
        $update = Tamu::findorfail($id)->update($request->all());
        return response()->json($update);
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
        $hapus = Tamu::findorfail($id)->delete();
        return response()->json($hapus);
    }
}
