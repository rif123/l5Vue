<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User;
use App\Model\userRole;

class UserCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('role')->except('edit','update');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['title'] = 'Pengguna';
        $this->data['deskripsi_title'] = 'Administrasi pengguna sistem';
        $this->data['user_roles'] = userRole::pluck('role_name','id');
        return view('backend.user',$this->data);
    }

    public function getUser(Request $request)
    {
        $cari = $request->get('cari');
        if($cari){
            $user = User::whereHas('userroles',function($q) use ($cari){
                                    $q->where('role_name','LIKE','%'.$cari.'%');
                                })
                                ->orWhere('name','LIKE','%'.$cari.'%')
                                ->orWhere('email','LIKE','%'.$cari.'%')
                                ->orWhere('jabatan','LIKE','%'.$cari.'%')
                                ->orWhere('username','LIKE','%'.$cari.'%')
                                ->with('userroles')
                                ->paginate(5)
                                ->appends($request->only('cari'));
        } else {
            $user = User::with('userroles')->paginate(5);
        }
        return response()->json($user);
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
            'name' => 'required',
            'username' => 'required',
            'role_id' =>'numeric|min:1',
            'password' => 'required',
            'jabatan' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email'
        ]);
        $buat = User::create($request->all());

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
        $this->data['title'] = 'Profil';
        $this->data['deskripsi_title'] = 'Data Profil Pengguna';
        $this->data['user'] = User::find($id);
        $this->data['user_roles'] = userRole::pluck('role_name','id');
        return view('backend.users.edit',$this->data);
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
        $response = ['success' => false ,'message' => 'Data Tidak Berhasil Diubah'];

        $this->validate($request, [
            'name' => 'required',
            'role_id' =>'numeric|min:1',
            'jabatan' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email'
        ]);
        $buat = User::findorfail($id)->update($request->all());

        if($buat){
            $response = ['success' => true , 'message' => 'Data Berhasil Diubah'];
        }
        return response()->json($response);
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
        $hapus = User::findorfail($id)->delete();
        
        return response()->json($hapus);
    }
}
