<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Berita;

class BeritaCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['title'] = 'Berita';
        $this->data['deskripsi_title'] = 'Daftar Berita';
        return view('backend.berita',$this->data);
    }

    public function getBerita(Request $request){
/*        //echo "<pre>".print_r($request->all(),true)."</pre>";
        //die(); */
        // DB::enableQueryLog();
        $cari = $request->get('cari');
        if($cari){
            $berita = Berita::where('title','LIKE','%'.$request->get('cari').'%')
                    ->orWhere('isi_berita','LIKE','%'.$request->get('cari').'%')
                    ->with('user')
                    ->orderBy('created_at','DESC')
                    ->paginate(5)
                    ->appends($request->only('cari'));
        } else {
            $berita = Berita::with('user')->orderBy('created_at','DESC')->paginate(5);
        }
/*        echo "<pre>".print_r(
            DB::getQueryLog()
        ,true)."</pre>";*/
        return response()->json($berita);
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
            'title' => 'required',
            'isi_berita' => 'required',
            'status' =>'required',
        ]);
        $input = $request->all();
        $input['user_id'] = \Auth::user()->id;
        $buat = Berita::create($input);

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
        $berita = Berita::with('user')->find($id);
        return response()->json($berita);
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
            'title' => 'required',
            'isi_berita' => 'required',
            'status' =>'required',
        ]);
        $input = $request->all();
        $input['user_id'] = \Auth::user()->id;
        $buat = Berita::find($id)->update($input);

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
        $hapus = Berita::findorfail($id)->delete();
        
        return response()->json($hapus);
    }
}
