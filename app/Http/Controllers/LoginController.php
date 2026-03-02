<?php

namespace App\Http\Controllers;
// use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class LoginController extends Controller
{
    public function loginProcess(Request $req)
    {

        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {



            if (Auth::user()->role == 1) {
                return redirect('admin/home');
            }
            return redirect('/');
        } else {

            return view('login', ['error' => 'Invalid Email or Password']);
        }
    }
    public function cProcess(Request $req)
    {
        
        $req->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'address_line1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'password' => 'required|min:6|confirmed',
            'postal_code' => 'required'
        ]);
        $user = auth()->user();
         $user->update([
        'name'=>$req->name,
        'phone' => $req->phone,
        'address_line1' => $req->address_line1,
        'address_line2' => $req->address_line2,
        'city' => $req->city,
        'state' => $req->state,
        'postal_code' => $req->postal_code,
        'password'=>$req->password
    ]);
        return view('login',['success'=>'Account successfully created 🎉']);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
