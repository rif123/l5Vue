<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\kamarType;

class TypeKamarCtrl extends Controller
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
        $this->data['title'] = 'Tipe Kamar';
        $this->data['deskripsi_title'] = 'Administrasi tipe Kamar';
        return view('backend.typekamar',$this->data);
    }

    public function getTypeKamar(Request $request)
    {
        $cari = $request->get('cari');
        if($cari){
            $typekamar = kamarType::where('nama','LIKE','%'.$cari.'%')
                                ->orWhere('harga_malam','LIKE','%'.$cari.'%')
                                ->orWhere('harga_orang','LIKE','%'.$cari.'%')
                                ->paginate(5)
                                ->appends($request->only('cari'));
        } else {
            $typekamar = kamarType::paginate(5);
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
            'nama' => 'required',
            'harga_malam' => 'numeric|min:1',
            'harga_orang' =>'numeric|min:1',
        ]);
        $buat = kamarType::create($request->all());

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
            'nama' => 'required',
            'harga_malam' => 'numeric|min:1',
            'harga_orang' =>'numeric|min:1',
        ]);
        $buat = kamarType::findorfail($id)->update($request->all());

        return response()->json($buat);
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
        $hapus = kamarType::findorfail($id)->delete();
        
        return response()->json($hapus);
    }
}
