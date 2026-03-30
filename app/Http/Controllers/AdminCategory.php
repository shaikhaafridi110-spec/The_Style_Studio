<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategory extends Controller
{
     //*******Category******
    public function category_del($id)
    {
        Category::where('id', $id)->delete();
        return redirect('admin/category')->with('success', 'Category deleted successfully!');
    }
    public function addcategory()
    {
        return view('admin/add-category');
    }
    public function savecategory(Request $req)
    {
       $req->validate([
            'name' => 'required|unique:categories,name',
            'slug' => 'required|unique:categories,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $file = $req->image;
        $filename = time(). '.' . $file->getClientOriginalExtension();
        $file->move(public_path('admin/assets/images/categories'), $filename);
        Category::create([
            'name' => $req->name,
            'slug' => $req->slug,
            'image' => "categories/" . $filename
        ]);
        return redirect('admin/category')->with('success', 'Category added successfully!');;
    }
    public function admincategory(Request $req)
    {
        $cname = $req->search;
        $cstatus = $req->status;
        $cdata = Category::select('*');
        if ($cname != '') {
            $cdata->where('name', 'like', '%' . $cname . '%');
        }
        if ($cstatus != '') {
            $cdata->where('status', $cstatus);
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
        $req->validate([
            'name' => 'required|unique:categories,name,' . $id,
            'slug' => 'required|unique:categories,slug,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $category = Category::findOrFail($id);

        if ($req->image != '') {



            $file = $req->image;
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/assets/images/categories'), $filename);

            $category->image = 'categories/' . $filename;
        }
        $category->name = $req->name;
        $category->slug = $req->slug;

        $category->save();
        return redirect('admin/category')->with('success', 'Category updated successfully!');;
    }

    public function status($id){
        $category = Category::find($id);
        if($category->status==0){
            $category->status='1';
        }
        else{
            $category->status='0';
        }

        $category->save();
        return redirect('admin/category')->with('success', 'Category satatus updated successfully!');


    }

}
