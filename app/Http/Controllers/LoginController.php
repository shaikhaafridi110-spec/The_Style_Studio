<?php

namespace App\Http\Controllers;
// use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class LoginController extends Controller
{
    public function loginProcess(Request $req){
       
        if(Auth::attempt(['email'=>$req->email,'password'=>$req->password])){
           
           

            if(Auth::user()->role=='1'){
                return redirect('admin/home');
            }
            return redirect('/');
        }else{

           return view('login', ['error' => 'Invalid Email or Password']);
        }

    }
}
