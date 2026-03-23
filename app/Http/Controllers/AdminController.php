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
        return redirect('admin/category')->with('success', 'Category deleted successfully!');
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
        $filename = time(). '.' . $file->getClientOriginalExtension();
        $file->move(public_path('admin/assets/images/categories'), $filename);
        Category::create([
            'name' => $req->name,
            'slug' => $req->slug,
            'status' => $req->status,
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
        $category = Category::findOrFail($id);

        if ($req->image != '') {



            $file = $req->image;
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/assets/images/categories'), $filename);

            $category->image = 'categories/' . $filename;
        }
        $category->name = $req->name;
        $category->slug = $req->slug;
        $category->status = $req->status;

        $category->save();
        return redirect('admin/category')->with('success', 'Category updated successfully!');;
    }





    //*********product*********



   



    public function productimage(Request $r)
    {
        $query = ProductImage::with('product'); 

        $proname = $r->search;


        if (!empty($proname)) {
            $query->whereHas('product', function ($q) use ($proname) {
                $q->where('proname', 'like', '%' . $proname . '%');
            });
        }

        $productImages = $query->paginate(5)->withQueryString();

        return view('admin.product-images', compact('productImages'));
    }


    public function addproductimage()
    {
        $products = Product::where('status', 1)->get(); // only active products

        return view('admin.add-product-image', compact('products'));
    }
    public function saveproductimage(Request $r)
    {

        $r->validate([
            'proid' => 'required|exists:products,proid',
            'image' => 'required|image|mimes:jpg|max:2048',
            'sort_order' => 'required|integer|min:0'
        ]);

        $imageName = time().'.' . $r->image->extension();


        $r->image->move(public_path('admin/assets/images/products'), $imageName);


        ProductImage::create([
            'proid' => $r->proid,
            'image' => 'products/' . $imageName,
            'sort_order' => $r->sort_order
        ]);

        return redirect('admin/product-image')
            ->with('success', 'Product Image Added Successfully!');
    }
    public function editProductImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $products = Product::all();

        return view('admin.edit-product-image', compact('image', 'products'));
    }
    public function updateProductImage(Request $r, $id)
    {
        $image = ProductImage::findOrFail($id);

        if ($r->hasFile('image')) {

            // Correct old image path
            $oldPath = public_path('admin/assets/images/products/' . $image->image);

            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            
            $imageName = time() . '.' . $r->image->getClientOriginalName();

            $r->image->move(
                public_path('admin/assets/images/products'),
                $imageName
            );

            $image->image = "products/".$imageName;
        }

        $image->proid = $r->proid;
        $image->sort_order = $r->sort_order;
        $image->save();

        return redirect('admin/product-image')
            ->with('success', 'Image Updated Successfully');
    }
    public function deleteProductImage($id)
    {
        $image = ProductImage::findOrFail($id);        
        $image->delete();

        return redirect()->back()
            ->with('success', 'Image Deleted Successfully');
    }
}
