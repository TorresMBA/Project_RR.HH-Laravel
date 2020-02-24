<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller{

    public function __construct(){
        $this->middleware('guest', ['only' => 'validacionLogin']);
    }

    public function login(){
        $credentials = $this->validate(request(), [
            'email' => 'email|required|string',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($credentials)){
            return redirect()->route('cargaempleado.index');
        }
        return back()
            ->withErrors(['email' => trans('auth.failed')])
            ->withInput(request(['email']));
    }

    public function validacionLogin(){
        return view('auth.login');
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
