<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;

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
        $data = $data->paginate(10)->withQueryString();
        //return view('user',);
        return view('admin/user', compact('data'));
    }
    public function user_del($id)
    {
        User::where('id', $id)->delete();
        return redirect('admin/user');
    }



    //*******Category******
    public function category_del($id)
    {
        Category::where('id', $id)->delete();
        return redirect('admin/category');
    }
    public function addcategory()
    {
        return view('admin/add-category');
    }
    public function savecategory(Request $req)
    {
        $req->validate([
            'status' => 'required|in:0,1',
        ]);
        $file = $req->image;
        $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('admin/assets/images/categories'), $filename);
        Category::create([
            'name' => $req->name,
            'slug' => $req->slug,
            'status' => $req->status,
            'image' => "categories/" . $filename
        ]);
        return redirect('admin/category');
    }
    public function admincategory(Request $req)
    {
        $cname = $req->search;
        $cstatus = $req->status;
        $cdata = Category::select('*');
        if ($cname != '') {
            $cdata->where('name', 'like', '%' . $cname . '%');
        }
        if($cstatus!=''){
            $cdata->where('status',$cstatus);
        }
        $cdata = $cdata->paginate(5)->withQueryString();

        return view('admin/category', compact('cdata'));
    }
    public function editcategory($id)
    {
        $cat = Category::findOrFail($id);
        return view('admin/edit-category', compact('cat'));
    }
    public function updatecategory(Request $req, $id)
    {
        $category = Category::findOrFail($id);

        if ($req->image != '') {



            $file = $req->image;
            $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/assets/images/categories'), $filename);

            $category->image = 'categories/' . $filename;
        }
        $category->name = $req->name;
        $category->slug = $req->slug;
        $category->status = $req->status;

        $category->save();
        return redirect('admin/category');

    }
}
