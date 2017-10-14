<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\layananKategori;

class layananKategoriCtrl extends Controller
{
    public function __construct()
    {
       $this->middleware('role');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['title'] = 'Kategori Layanan';
        $this->data['deskripsi_title'] = 'Administrasi kategori layanan';
        return view('backend.kategorilayanan',$this->data);
    }

    public function getLayananKategori(Request $request)
    {
        $cari = $request->get('cari');
        if($cari){
            $typekamar = layananKategori::where('nama_layanan_kategori','LIKE','%'.$cari.'%')
                            ->orWhere('keterangan','LIKE','%'.$cari.'%')
                            ->paginate(5)
                            ->appends($request->only('cari'));
        } else {
            $typekamar = layananKategori::paginate(5);
        }
        return response()->json($typekamar);
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
            'nama_layanan_kategori' => 'required'
        ]);
        $buat = layananKategori::create($request->all());

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
            'nama_layanan_kategori' => 'required'
        ]);
        $ubah = layananKategori::findorfail($id)->update($request->all());

        return response()->json($ubah);
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
        $hapus = layananKategori::findorfail($id)->delete();

        return response()->json($hapus);
    }
}
