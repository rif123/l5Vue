<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Perusahaan;
class PerusahaanCtrl extends Controller
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
        $this->data['title'] = 'Perusahaan';
        $this->data['deskripsi_title'] = 'Administrasi informasi perusahaan';
        return view('backend.perusahaan',$this->data);
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
        $perusahaan = Perusahaan::findorfail($id);
        return response()->json($perusahaan);
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
                'nama_hotel' => 'required',
                'nama_perusahaan' => 'required',
                'alamat_jalan' => 'required',
                'alamat_kabupaten' => 'required',
                'alamat_provinsi' => 'required',
                'nomor_telp' => 'required',
                'nomor_fax' => 'required',
                'email' => 'email'
            ]);
        $update = Perusahaan::findorfail($id)->update($request->all());
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
    }
}
