<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Layanan;
use App\Model\layananKategori;
use DB;

class LayananCtrl extends Controller
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
        $this->data['title'] = 'Layanan';
        $this->data['deskripsi_title'] = 'Administrasi layanan hotel';
        $this->data['layanan_kategori'] = layananKategori::pluck('nama_layanan_kategori','id');
        return view('backend.layanan',$this->data);
    }

    public function getLayanan(Request $request){
        $cari = $request->get('cari');
       /* DB::enableQueryLog();*/
        if($cari){
            $typekamar = layanan::whereHas('layanankategori',function($q) use ($cari){
                                $q->where('nama_layanan_kategori','LIKE','%'.$cari.'%');
                            })->orWhere('satuan','LIKE','%'.$cari.'%')
                            ->orWhere('harga','LIKE','%'.$cari.'%')
                            ->orWhere('nama_layanan','LIKE','%'.$cari.'%')
                            ->with('layanankategori')
                            ->paginate(5)
                            ->appends($request->only('cari'));
        } else {
            $typekamar = layanan::with('layanankategori')->paginate(5);
        }
         /*       echo "<pre>".print_r(
            DB::getQueryLog()
        ,true)."</pre>";*/
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
            'nama_layanan' => 'required',
            'layanan_kategori_id' => 'numeric|min:1',
            'satuan' => 'required',
            'harga' => 'numeric|min:1'
        ]);
        $buat = Layanan::create($request->all());

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
            'nama_layanan' => 'required',
            'layanan_kategori_id' => 'numeric|min:1',
            'satuan' => 'required',
            'harga' => 'numeric|min:1'
        ]);
        $ubah = Layanan::findorfail($id)->update($request->all());

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
        $hapus = Layanan::findorfail($id)->delete();

        return response()->json($hapus);
    }
}
