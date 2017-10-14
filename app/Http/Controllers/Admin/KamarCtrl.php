<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Kamar;
use App\Model\kamarType;
use Auth;

class KamarCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware(['role']);
       /* $this->middleware('role:super');
        $this->middleware('role:dev');*/
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['title'] = 'Kamar';
        $this->data['deskripsi_title'] = 'Administrasi kamar hotel';
        $this->data['kamar_type'] = kamarType::pluck('nama','id');
        return view('backend.kamar',$this->data);
    }

    public function getKamar(Request $request){
/*        //echo "<pre>".print_r($request->all(),true)."</pre>";
        //die(); */
        // DB::enableQueryLog();
        $cari = $request->get('cari');
        if($cari){
            $kamar = Kamar::
                    whereHas('typekamar',function($q) use ($cari){
                        $q->where('nama','LIKE','%'.$cari.'%');
                    })
                    ->orWhere('nomor_kamar','LIKE','%'.$request->get('cari').'%')
                    ->with('typekamar')
                    ->paginate(5)
                    ->appends($request->only('cari'));
        } else {
            $kamar = Kamar::with('typekamar')->paginate(5);
        }
/*        echo "<pre>".print_r(
            DB::getQueryLog()
        ,true)."</pre>";*/
        return response()->json($kamar);
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
            'nomor_kamar' => 'required',
            'type_id' => 'integer|min:1',
            'max_dewasa' =>'integer|min:1',
            'max_anak' =>'integer|min:1'
        ]);
        $buat = Kamar::create($request->all());

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
            'nomor_kamar' => 'required',
            'type_id' => 'integer|min:1',
            'max_dewasa' =>'integer|min:1',
            'max_anak' =>'integer|min:1'
        ]);
        $update = Kamar::findorfail($id)->update($request->all());
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
        $hapus = Kamar::findorfail($id)->delete();
        return response()->json($hapus);
    }
}
