<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

use Illuminate\Http\Request;

class AdminController extends Controller
{

  
    public function adminhome()
    {
        
        return view('admin/index');
    }

    //*******user******
    public function adminuser(Request $req)
    {
        //$data=emp::get();
        $name = $req->search;
        $data = User::select('*')->where('role', 2);
        if ($name != "") {
            $data->where('name', 'like', '%' . $name . '%');
        }
        if ($req->userid != "") {
            $data->where('id',$req->userid);
        }
        $data = $data->paginate(10)->withQueryString();
        //return view('user',);
        return view('admin/user', compact('data'));
    }
    public function user_del($id)
    {
        User::where('id', $id)->delete();
        return redirect('admin/user')->with('success', 'User Deleted Successfully');
    }
    public function edit_user($id)
    {
        $data = User::select('*')->where('id', $id)->first();
        return view('admin/edit_user', compact('data'));
    }
    public function update_user(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'address_line1' => 'required',
            'city' => 'required',
            'state' => 'required',
            
            'postal_code' => 'required',
            'email' => 'required|email'
        ]);
        $data = User::find($id);
        $data->name = $req->name;
        $data->email = $req->email;
        $data->phone = $req->phone;
        $data->address_line1 = $req->address_line1;
        $data->address_line2 = $req->address_line2;
        $data->city = $req->city;
        $data->state = $req->state;
        $data->postal_code = $req->postal_code;
        $data->save();
        return redirect('admin/user')->with('success', 'User Updated Successfully');
    }
}
