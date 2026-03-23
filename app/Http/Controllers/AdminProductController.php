<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function product(Request $r)
    {

        $products = Product::select('*');
        $proname = $r->search;
        $prostatus = $r->status;
        if ($proname != '') {
            $products->where('proname', 'like', '%' . $proname . '%');
        }
        if ($prostatus != '') {
            $products->where('status', $prostatus);
        }
        $products = $products->paginate(5)->withQueryString();
        return view('admin/product', compact('products'));
    }
    public function addproduct(){
        $data=Category::select('id','name')->get();
        return view('admin.add-product',compact('data'));
    }
    public function saveproduct(Request $res){
        $res->validate([
            'proname'=>'required',
            'description'=>'required',
            'price'=>'required|numeric|min:1',
            'discount_price'=>'',
            'catid'=>'required',
        'proimage' => 'required|image|mimes:jpg|max:2048'
        ]);
        $imageName = time().'.' . $res->proimage->getClientOriginalExtension();

        $res->proimage->move(public_path('admin/assets/images/products'), $imageName);

        Product::create([
            'proname'=>$res->proname,
            'description'=>$res->description,
            'price'=>$res->price,
            'discount_price'=>$res->discount_price,
            'catid'=>$res->catid,
        'proimage' => $imageName
        ]);
        return redirect('admin/product')->with('success', 'Product Added Successfully!');
    }

    public function product_delete($id){
        Product::find($id)->delete();
        return redirect('admin/product')->with('success', 'Product Deleted Successfully!');
        
    }

}
