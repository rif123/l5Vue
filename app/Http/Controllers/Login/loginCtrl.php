<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Hash;
use DB;

class loginCtrl extends Controller
{
    public function checkLogin(Request $request){
		$password = Hash::make('asdqwe123');
    	$remember = $request->get('remember');
    	$username = $request->get('username');
    	$password = $request->get('password');
    	$check = Auth::attempt(['username' => $username, 'password' => $password],$remember);
    	if ($check) {
		    return response()->json(route('dashboard.index'));
		} else {
			return response()->json($check);
		}
    }
}
