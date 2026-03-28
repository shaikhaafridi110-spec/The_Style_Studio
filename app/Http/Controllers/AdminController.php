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
        return redirect('admin/user');
    }
}
